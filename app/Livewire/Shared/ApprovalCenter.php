<?php

namespace App\Livewire\Shared;

use App\Models\ApprovalAction;
use App\Models\ApprovalRequest;
use App\Models\ExpenseCategory;
use App\Models\PayrollBatch;
use App\Models\Project;
use App\Models\ProjectExpense;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ApprovalCenter extends Component
{
    public string $requestType = 'expense';

    public ?int $projectId = null;

    public string $title = '';

    public ?string $details = null;

    public ?string $amount = null;

    public ?int $categoryId = null;

    public ?int $payrollBatchId = null;

    public ?string $decisionNote = null;

    public function submitRequest(): void
    {
        abort_unless(auth()->user()?->role?->name === 'hr', 403);
        $data = $this->validate([
            'requestType' => ['required', 'in:expense,payroll,quotation'],
            'projectId' => ['nullable', 'integer', 'exists:projects,id'],
            'title' => [$this->requestType === 'payroll' ? 'nullable' : 'required', 'string', 'min:3', 'max:255'],
            'details' => ['nullable', 'string', 'max:5000'],
            'amount' => [$this->requestType === 'expense' ? 'required' : 'nullable', 'numeric', $this->requestType === 'expense' ? 'gt:0' : 'min:0'],
            'categoryId' => [$this->requestType === 'expense' ? 'required' : 'nullable', 'integer', 'exists:expense_categories,id'],
            'payrollBatchId' => [$this->requestType === 'payroll' ? 'required' : 'nullable', 'integer', 'exists:payroll_batches,id'],
        ]);

        $subjectType = null;
        $subjectId = null;
        if ($data['requestType'] === 'expense' && ! ExpenseCategory::whereKey($data['categoryId'])->where('is_active', true)->exists()) {
            throw ValidationException::withMessages(['categoryId' => 'Select an active expense category.']);
        }
        if ($data['requestType'] === 'payroll') {
            $batch = PayrollBatch::withSum('payrolls', 'net_amount')
                ->whereKey($data['payrollBatchId'])->where('status', 'draft')->firstOrFail();
            if ($batch->payrolls()->doesntExist()) {
                throw ValidationException::withMessages(['payrollBatchId' => 'The selected payroll batch has no payroll records.']);
            }
            $subjectType = 'payroll_batch';
            $subjectId = $batch->id;
            $data['title'] = 'Payroll approval — '.$batch->month_name.' '.$batch->year;
            $data['amount'] = $batch->payrolls_sum_net_amount;
            $data['details'] = 'Payroll period '.$batch->period_start->format('d M Y').' to '.$batch->period_end->format('d M Y');
        } elseif ($data['requestType'] === 'quotation') {
            if (empty($data['projectId'])) {
                throw ValidationException::withMessages(['projectId' => 'Select the project quotation to submit.']);
            }
            $project = Project::findOrFail($data['projectId']);
            $subjectType = 'project_quotation';
            $subjectId = $project->id;
        }

        if ($subjectType && ApprovalRequest::where('subject_type', $subjectType)
            ->where('subject_id', $subjectId)->where('status', 'pending')->exists()) {
            throw ValidationException::withMessages(['requestType' => 'An approval request for this record is already pending.']);
        }

        DB::transaction(function () use ($data, $subjectType, $subjectId) {
            if ($data['requestType'] === 'quotation') {
                Project::whereKey($subjectId)->update([
                    'quotation_approval_status' => 'pending',
                    'updated_at' => now(),
                ]);
            }
            $request = ApprovalRequest::create([
                'request_type' => $data['requestType'],
                'subject_type' => $subjectType,
                'subject_id' => $subjectId,
                'project_id' => $data['projectId'] ?: null,
                'category_id' => $data['categoryId'] ?: null,
                'title' => $data['title'],
                'details' => $data['details'],
                'amount' => $data['amount'] ?: null,
                'status' => 'pending',
                'requested_by' => auth()->id(),
            ]);

            ApprovalAction::create([
                'approval_request_id' => $request->id,
                'user_id' => auth()->id(),
                'action' => 'submitted',
                'from_status' => 'new',
                'to_status' => 'pending',
                'notes' => 'Submitted for Admin review.',
            ]);
        });

        $this->reset('title', 'details', 'amount', 'categoryId', 'payrollBatchId');
        $this->requestType = 'expense';
        session()->flash('success', 'Approval request submitted.');
    }

    public function decide(int $requestId, string $decision): void
    {
        abort_unless(auth()->user()?->role?->name === 'admin', 403);
        if (! in_array($decision, ['approved', 'rejected'], true)) {
            throw ValidationException::withMessages(['decisionNote' => 'Invalid approval decision.']);
        }
        $validated = $this->validate([
            'decisionNote' => [$decision === 'rejected' ? 'required' : 'nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($requestId, $decision, $validated) {
            $request = ApprovalRequest::whereKey($requestId)->lockForUpdate()->firstOrFail();
            if ($request->status !== 'pending') {
                throw ValidationException::withMessages(['decisionNote' => 'This approval request has already been decided.']);
            }

            if ($request->subject_type === 'purchase_request' && $request->subject_id) {
                $purchase = PurchaseRequest::whereKey($request->subject_id)
                    ->where('status', 'pending')->lockForUpdate()->firstOrFail();
                $purchase->update([
                    'status' => $decision,
                    'reviewed_by' => auth()->id(),
                    'reviewed_at' => now(),
                    'review_notes' => $validated['decisionNote'] ?: null,
                ]);
            }
            if ($decision === 'approved' && $request->request_type === 'expense') {
                if (! $request->category_id || $request->amount === null) {
                    throw ValidationException::withMessages(['decisionNote' => 'The expense request is missing its category or amount.']);
                }
                $expense = ProjectExpense::create([
                    'expense_type' => $request->project_id ? 'project' : 'company',
                    'project_id' => $request->project_id,
                    'category_id' => $request->category_id,
                    'description' => $request->title,
                    'amount' => $request->amount,
                    'expense_date' => today(),
                    'notes' => $request->details,
                    'created_by' => $request->requested_by,
                ]);
                $request->subject_type = 'project_expense';
                $request->subject_id = $expense->id;
            }
            if ($decision === 'approved' && $request->request_type === 'payroll') {
                $batch = PayrollBatch::whereKey($request->subject_id)->where('status', 'draft')->lockForUpdate()->firstOrFail();
                $batch->update(['status' => 'finalized', 'finalized_at' => now()]);
            }
            if ($request->request_type === 'quotation' && $request->subject_type === 'project_quotation') {
                Project::whereKey($request->subject_id)->update([
                    'quotation_approval_status' => $decision,
                    'quotation_approved_by' => auth()->id(),
                    'quotation_approved_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $request->update([
                'status' => $decision,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
            ApprovalAction::create([
                'approval_request_id' => $request->id,
                'user_id' => auth()->id(),
                'action' => $decision,
                'from_status' => 'pending',
                'to_status' => $decision,
                'notes' => $validated['decisionNote'] ?: null,
            ]);
        });

        $this->decisionNote = null;
        session()->flash('success', 'Approval decision and history saved.');
    }

    public function render()
    {
        $role = auth()->user()?->role?->name;
        abort_unless(in_array($role, ['admin', 'hr'], true), 403);

        $requests = ApprovalRequest::with(['project', 'requester', 'reviewer', 'actions.user'])
            ->when($role === 'hr', fn ($query) => $query->where('requested_by', auth()->id()))
            ->when($role === 'admin', fn ($query) => $query->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END"))
            ->latest()->limit(100)->get();

        return view('livewire.shared.approval-center', [
            'requests' => $requests,
            'projects' => Project::orderBy('name')->get(),
            'expenseCategories' => ExpenseCategory::active()->orderBy('sort_order')->get(),
            'draftPayrollBatches' => PayrollBatch::draft()->withCount('payrolls')->orderByDesc('year')->orderByDesc('month')->get(),
            'isAdmin' => $role === 'admin',
        ])->layout($role === 'admin' ? 'layouts.admindashboard' : 'layouts.hrmanagerdashboard');
    }
}
