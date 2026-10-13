<?php

namespace App\Services;

use App\Models\ApprovalRequest;
use App\Models\ErpNotification;
use App\Models\InventoryTransaction;
use App\Models\Material;
use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\ProjectMilestone;
use App\Models\SaleInvoice;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ErpReminderService
{
    private array $activeAlerts = [];

    private array $userRoles = [];

    public function generate(): int
    {
        $this->activeAlerts = [];
        $this->userRoles = User::with('role')->get()->mapWithKeys(
            fn (User $user) => [$user->id => $user->role?->name]
        )->all();
        $admins = User::whereHas('role', fn ($query) => $query->where('name', 'admin'))->pluck('id');
        $hrUsers = User::whereHas('role', fn ($query) => $query->where('name', 'hr'))->pluck('id');
        $adminsAndHr = $admins->merge($hrUsers)->unique();

        Project::whereNotNull('end_date')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->whereDate('end_date', '<=', today()->addDays(7))
            ->get(['id', 'name', 'end_date', 'status'])
            ->each(function (Project $project) use ($adminsAndHr) {
                $days = today()->diffInDays($project->end_date, false);
                $this->alert(
                    $adminsAndHr,
                    'project_deadline',
                    'project-deadline-'.$project->id.'-'.$project->end_date->format('Ymd'),
                    $days < 0 ? 'Project deadline passed' : 'Project deadline approaching',
                    $project->name.($days < 0
                        ? ' is overdue by '.abs($days).' day(s).'
                        : ' is due in '.$days.' day(s).'),
                    'admin.project-workspace',
                    ['documentableType' => 'project', 'documentableId' => $project->id]
                );
            });

        ProjectMilestone::whereNotNull('due_date')
            ->where('status', '!=', 'completed')
            ->whereDate('due_date', '<=', today()->addDays(7))
            ->with('project:id,name')
            ->get()
            ->each(function (ProjectMilestone $milestone) use ($adminsAndHr) {
                $days = today()->diffInDays($milestone->due_date, false);
                $this->alert(
                    $adminsAndHr,
                    'milestone_due',
                    'milestone-due-'.$milestone->id.'-'.$milestone->due_date->format('Ymd'),
                    $days < 0 ? 'Project milestone delayed' : 'Project milestone approaching',
                    $milestone->project->name.' — '.$milestone->name.($days < 0
                        ? ' is overdue by '.abs($days).' day(s).'
                        : ' is due in '.$days.' day(s).'),
                    'admin.project-workspace',
                    ['documentableType' => 'project', 'documentableId' => $milestone->project_id]
                );
            });

        Worker::whereNotNull('medical_expiry_date')
            ->whereDate('medical_expiry_date', '<=', today()->addDays(30))
            ->get(['id', 'name', 'medical_expiry_date'])
            ->each(function (Worker $worker) use ($hrUsers) {
                $this->alert(
                    $hrUsers,
                    'medical_expiry',
                    'medical-expiry-'.$worker->id.'-'.$worker->medical_expiry_date->format('Ymd'),
                    'Worker medical document expiring',
                    $worker->name.'\'s medical certificate expires on '.$worker->medical_expiry_date.'.',
                    'hr.project-workspace',
                    ['documentableType' => 'worker', 'documentableId' => $worker->id]
                );
            });

        ProjectDocument::whereNotNull('expires_at')
            ->whereDate('expires_at', '<=', today()->addDays(30))
            ->get()
            ->each(function (ProjectDocument $document) use ($hrUsers) {
                $owner = $document->documentable_type === 'worker'
                    ? Worker::find($document->documentable_id)
                    : Project::find($document->documentable_id);
                if (! $owner) {
                    return;
                }
                $ownerName = $owner->name;
                $this->alert(
                    $hrUsers,
                    'document_expiry',
                    'document-expiry-'.$document->id.'-'.$document->expires_at->format('Ymd'),
                    'Document renewal approaching',
                    $document->original_name.' for '.$ownerName.' expires on '.$document->expires_at->format('d M Y').'.',
                    'hr.project-workspace',
                    $document->documentable_type === 'worker'
                        ? ['documentableType' => 'worker', 'documentableId' => $document->documentable_id]
                        : ['documentableType' => 'project', 'documentableId' => $document->documentable_id]
                );
            });

        ApprovalRequest::where('status', 'pending')->with('requester')->get()->each(function (ApprovalRequest $request) use ($admins) {
            $daysPending = $request->created_at->diffInDays(now());
            $this->alert(
                $admins,
                'pending_approval',
                'approval-'.$request->id,
                'Approval pending',
                $request->title.' from '.$request->requester->name.' has been waiting '.$daysPending.' day(s).',
                'admin.approvals'
            );
            $this->alert(
                collect([$request->requested_by]),
                'pending_approval',
                'approval-status-'.$request->id,
                'Request awaiting approval',
                $request->title.' is awaiting Admin review.',
                'hr.approvals'
            );
        });

        Material::where('is_active', true)->get()->each(function (Material $material) use ($adminsAndHr) {
            if ($material->on_hand <= (float) $material->reorder_level) {
                $this->alert(
                    $adminsAndHr,
                    'low_stock',
                    'low-stock-'.$material->id,
                    'Low material stock',
                    $material->name.' has '.number_format($material->on_hand, 2).' '.$material->unit
                        .' on hand; reorder level is '.number_format((float) $material->reorder_level, 2).'.',
                    'admin.procurement'
                );
            }
        });

        Project::whereNotIn('status', ['cancelled'])->get()->each(function (Project $project) use ($adminsAndHr) {
            $budgetLines = (float) $project->budgetItems()->sum('total');
            $budget = $project->budget_cap !== null
                ? (float) $project->budget_cap
                : ($budgetLines > 0 ? $budgetLines : (float) $project->estimated_cost);
            if ($budget <= 0) {
                return;
            }

            $materialCost = (float) InventoryTransaction::where('project_id', $project->id)
                ->whereIn('type', ['issue', 'return'])
                ->sum(DB::raw("CASE WHEN type = 'issue' THEN quantity * COALESCE(unit_cost, 0) ELSE -quantity * COALESCE(unit_cost, 0) END"));
            $laborCost = (float) DB::table('payroll_project_breakdowns as breakdowns')
                ->join('payrolls', 'payrolls.id', '=', 'breakdowns.payroll_id')
                ->join('payroll_batches', 'payroll_batches.id', '=', 'payrolls.payroll_batch_id')
                ->where('breakdowns.project_id', $project->id)
                ->where('payroll_batches.status', 'finalized')
                ->sum('breakdowns.amount');
            $expenseCost = (float) $project->expenses()->sum('amount');
            $actual = $materialCost + $laborCost + $expenseCost;
            if ($actual > $budget) {
                $this->alert(
                    $adminsAndHr,
                    'budget_overrun',
                    'budget-overrun-'.$project->id,
                    'Project budget exceeded',
                    $project->name.' actual cost is '.number_format($actual - $budget, 2).' over its budget.',
                    'admin.project-workspace',
                    ['documentableType' => 'project', 'documentableId' => $project->id]
                );
            }
        });

        SaleInvoice::whereIn('payment_status', ['unpaid', 'partial'])
            ->whereDate('invoice_date', '<=', today()->subDays(30))
            ->with('project')
            ->get(['id', 'invoice_number', 'invoice_date', 'project_id', 'payment_status', 'total'])
            ->each(function (SaleInvoice $invoice) use ($admins) {
                $this->alert(
                    $admins,
                    'unpaid_invoice',
                    'unpaid-invoice-'.$invoice->id,
                    'Invoice payment overdue',
                    $invoice->invoice_number.' for '.$invoice->project->name.' remains '
                        .$invoice->payment_status.' after 30 days.',
                    'admin.sales-invoices.list'
                );
            });

        $activeKeys = array_keys($this->activeAlerts);
        ErpNotification::whereNull('resolved_at')
            ->whereIn('category', ['project_deadline', 'milestone_due', 'medical_expiry', 'document_expiry', 'pending_approval', 'low_stock', 'budget_overrun', 'unpaid_invoice'])
            ->whereNotIn('alert_key', $activeKeys)
            ->update(['resolved_at' => now(), 'updated_at' => now()]);

        return count($this->activeAlerts);
    }

    private function alert(Collection $userIds, string $category, string $key, string $title, string $message, ?string $url, array $routeParameters = []): void
    {
        foreach ($userIds->unique() as $userId) {
            $alertKey = $userId.':'.$key;
            $this->activeAlerts[$alertKey] = true;
            $notification = ErpNotification::firstOrNew(['alert_key' => $alertKey]);
            $wasResolved = $notification->exists && $notification->resolved_at !== null;
            $routeName = $url;
            $role = $this->userRoles[$userId] ?? null;
            if ($role === 'hr') {
                $routeName = match ($url) {
                    'admin.project-workspace' => 'hr.project-workspace',
                    'admin.approvals' => 'hr.approvals',
                    'admin.procurement' => 'hr.inventory',
                    default => $url,
                };
            }
            $notification->fill([
                'user_id' => $userId,
                'category' => $category,
                'title' => $title,
                'message' => $message,
                'action_url' => $routeName ? route($routeName, $routeParameters) : null,
                'resolved_at' => null,
            ]);
            if ($wasResolved) {
                $notification->read_at = null;
            }
            $notification->save();
        }
    }
}
