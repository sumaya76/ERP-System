<?php

namespace Database\Seeders;

use App\Models\ApprovalAction;
use App\Models\ApprovalRequest;
use App\Models\ErpNotification;
use App\Models\ExpenseCategory;
use App\Models\InventoryTransaction;
use App\Models\Material;
use App\Models\Project;
use App\Models\ProjectMilestone;
use App\Models\ProjectProgressUpdate;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class HrModuleDemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $hrUser = User::whereHas('role', fn ($query) => $query->where('name', 'hr'))
            ->orderBy('id')
            ->first();

        if (! $hrUser) {
            throw new RuntimeException('Create an HR user before running the HR module demo seeder.');
        }

        $adminUser = User::whereHas('role', fn ($query) => $query->where('name', 'admin'))
            ->orderBy('id')
            ->first();

        if (! $adminUser) {
            throw new RuntimeException('Create an Admin user before running the HR module demo seeder.');
        }

        DB::transaction(function () use ($hrUser, $adminUser) {
            $project = Project::firstOrCreate(
                ['project_code' => 'DEMO-INV-001'],
                [
                    'name' => 'Demo Inventory - Riverside Office',
                    'client_name' => 'BuildDesk Demo Client',
                    'location' => 'Demo Site A',
                    'description' => 'Sample project for demonstrating inventory workflows.',
                    'contract_value' => 25000,
                    'estimated_cost' => 15000,
                    'start_date' => today()->subMonth()->toDateString(),
                    'end_date' => today()->addMonths(5)->toDateString(),
                    'status' => 'ongoing',
                    'project_stage' => 'Structure',
                    'progress_percent' => 45,
                    'budget_cap' => 15000,
                ]
            );

            $materials = collect([
                [
                    'sku' => 'DEMO-CEM-001',
                    'name' => 'Portland Cement',
                    'category' => 'Building Materials',
                    'unit' => 'bag',
                    'reorder_level' => 20,
                    'opening_receipt' => 60,
                    'issued' => 50,
                    'unit_cost' => 8.50,
                ],
                [
                    'sku' => 'DEMO-STL-001',
                    'name' => 'Steel Rebar 12mm',
                    'category' => 'Steel',
                    'unit' => 'ton',
                    'reorder_level' => 6,
                    'opening_receipt' => 12,
                    'issued' => 7,
                    'unit_cost' => 740,
                ],
                [
                    'sku' => 'DEMO-BLK-001',
                    'name' => 'Concrete Block',
                    'category' => 'Masonry',
                    'unit' => 'piece',
                    'reorder_level' => 200,
                    'opening_receipt' => 1200,
                    'issued' => 350,
                    'unit_cost' => 0.85,
                ],
                [
                    'sku' => 'DEMO-PVC-001',
                    'name' => 'PVC Electrical Conduit',
                    'category' => 'Electrical',
                    'unit' => 'meter',
                    'reorder_level' => 50,
                    'opening_receipt' => 200,
                    'issued' => 45,
                    'unit_cost' => 2.40,
                ],
            ])->mapWithKeys(function (array $item) use ($project, $hrUser) {
                $material = Material::updateOrCreate(
                    ['sku' => $item['sku']],
                    [
                        'name' => $item['name'],
                        'category' => $item['category'],
                        'unit' => $item['unit'],
                        'reorder_level' => $item['reorder_level'],
                        'is_active' => true,
                    ]
                );

                $this->recordMovement(
                    $material,
                    'receipt',
                    $item['opening_receipt'],
                    $item['unit_cost'],
                    null,
                    $hrUser,
                    $item['sku'].'-OPENING',
                    'Demo opening stock receipt.'
                );
                $this->recordMovement(
                    $material,
                    'issue',
                    $item['issued'],
                    $item['unit_cost'],
                    $project,
                    $hrUser,
                    $item['sku'].'-ISSUE',
                    'Demo issue to Riverside Office site.'
                );

                return [$item['sku'] => $material];
            });

            $supplier = Supplier::firstOrCreate(
                ['name' => 'Demo Building Supplies'],
                [
                    'contact_person' => 'Demo Supplier Contact',
                    'email' => 'supplier@example.test',
                    'phone' => '0000000201',
                    'address' => 'Demo Supplier Address',
                    'is_active' => true,
                ]
            );

            $pendingRequest = PurchaseRequest::firstOrCreate(
                ['request_number' => 'DEMO-INV-PR-001'],
                [
                    'project_id' => $project->id,
                    'requested_by' => $hrUser->id,
                    'status' => 'pending',
                    'required_by' => today()->addDays(7)->toDateString(),
                    'notes' => 'Demo request: replenish low stock before the next construction phase.',
                ]
            );
            $pendingRequest->items()->firstOrCreate(
                ['material_id' => $materials['DEMO-STL-001']->id],
                ['quantity' => 8, 'notes' => 'Required for scheduled structural work.']
            );
            $this->recordPurchaseApproval($pendingRequest, $hrUser);

            $orderedRequest = PurchaseRequest::firstOrCreate(
                ['request_number' => 'DEMO-INV-PR-002'],
                [
                    'project_id' => $project->id,
                    'requested_by' => $hrUser->id,
                    'status' => 'ordered',
                    'required_by' => today()->addDays(3)->toDateString(),
                    'notes' => 'Demo order with a partial delivery awaiting the remaining quantity.',
                ]
            );
            $orderedItem = $orderedRequest->items()->firstOrCreate(
                ['material_id' => $materials['DEMO-CEM-001']->id],
                ['quantity' => 20, 'notes' => 'Partial delivery: 8 bags received.']
            );
            $order = PurchaseOrder::firstOrCreate(
                ['order_number' => 'DEMO-INV-PO-001'],
                [
                    'purchase_request_id' => $orderedRequest->id,
                    'supplier_id' => $supplier->id,
                    'created_by' => $hrUser->id,
                    'status' => 'partially_received',
                    'expected_delivery_date' => today()->addDays(2)->toDateString(),
                    'notes' => 'Demo purchase order with an outstanding delivery.',
                    'ordered_at' => now()->subDay(),
                ]
            );
            $orderItem = $order->items()->firstOrCreate(
                ['purchase_request_item_id' => $orderedItem->id],
                [
                    'material_id' => $materials['DEMO-CEM-001']->id,
                    'quantity' => 20,
                    'received_quantity' => 8,
                    'unit_price' => 8.50,
                ]
            );
            $this->recordMovement(
                $materials['DEMO-CEM-001'],
                'receipt',
                8,
                8.50,
                $project,
                $hrUser,
                'DEMO-INV-PO-001-RECEIPT-001',
                'Demo partial delivery against '.$order->order_number,
                $orderItem->id
            );
            $this->recordPurchaseApproval($orderedRequest, $hrUser, 'approved', $adminUser);
            $this->seedProjectWorkspace($project, $hrUser);
            $this->seedApprovalExamples($project, $hrUser);
            $this->seedNotifications($project, $hrUser);
        });

        $this->command?->info('HR demo data ready: inventory, project workspace, approvals, and notifications are populated.');
    }

    private function seedProjectWorkspace(Project $project, User $hrUser): void
    {
        ProjectMilestone::firstOrCreate(
            ['project_id' => $project->id, 'name' => 'Complete structural frame'],
            [
                'description' => 'Finish the main frame before interior work begins.',
                'due_date' => today()->addDays(4)->toDateString(),
                'status' => 'in_progress',
                'created_by' => $hrUser->id,
            ]
        );
        ProjectMilestone::firstOrCreate(
            ['project_id' => $project->id, 'name' => 'Site mobilization'],
            [
                'description' => 'Initial site setup and safety checks completed.',
                'due_date' => today()->subDays(5)->toDateString(),
                'status' => 'completed',
                'completed_at' => now()->subDays(5),
                'created_by' => $hrUser->id,
            ]
        );

        ProjectProgressUpdate::firstOrCreate(
            ['project_id' => $project->id, 'summary' => 'Demo: ground-floor structural work is complete.'],
            [
                'user_id' => $hrUser->id,
                'update_date' => today()->subDays(2)->toDateString(),
                'stage' => 'Structure',
                'progress_percent' => 38,
                'blockers' => null,
            ]
        );
        ProjectProgressUpdate::firstOrCreate(
            ['project_id' => $project->id, 'summary' => 'Demo: reinforcement and formwork are progressing on the first floor.'],
            [
                'user_id' => $hrUser->id,
                'update_date' => today()->subDay()->toDateString(),
                'stage' => 'Structure',
                'progress_percent' => 45,
                'blockers' => 'Waiting for the remaining cement delivery.',
            ]
        );
    }

    private function seedApprovalExamples(Project $project, User $hrUser): void
    {
        $category = ExpenseCategory::firstOrCreate(
            ['name' => 'Demo Site Supplies'],
            [
                'icon' => 'fas fa-hard-hat',
                'color' => '#16856b',
                'is_active' => true,
                'sort_order' => 50,
            ]
        );

        $expenseRequest = ApprovalRequest::firstOrCreate(
            ['subject_type' => 'demo_expense', 'subject_id' => 1],
            [
                'request_type' => 'expense',
                'project_id' => $project->id,
                'category_id' => $category->id,
                'title' => 'Safety equipment for Riverside site',
                'details' => 'Demo request for helmets, gloves, and site safety signage.',
                'amount' => 1250,
                'status' => 'pending',
                'requested_by' => $hrUser->id,
            ]
        );
        $this->recordSubmittedApprovalAction($expenseRequest, $hrUser);

        $quotationRequest = ApprovalRequest::firstOrCreate(
            ['subject_type' => 'project_quotation', 'subject_id' => $project->id],
            [
                'request_type' => 'quotation',
                'project_id' => $project->id,
                'title' => 'Riverside Office structural works quotation',
                'details' => 'Demo quotation awaiting Admin review.',
                'amount' => 25000,
                'status' => 'pending',
                'requested_by' => $hrUser->id,
            ]
        );
        $this->recordSubmittedApprovalAction($quotationRequest, $hrUser);
    }

    private function seedNotifications(Project $project, User $hrUser): void
    {
        foreach ([
            [
                'alert_key' => 'demo-hr-project-update-'.$hrUser->id,
                'category' => 'project_deadline',
                'title' => 'Project update is ready',
                'message' => 'Riverside Office has a new progress update and an upcoming structural milestone.',
                'action_url' => '/hr/project-workspace?documentableType=project&documentableId='.$project->id,
            ],
            [
                'alert_key' => 'demo-hr-approval-'.$hrUser->id,
                'category' => 'pending_approval',
                'title' => 'Request awaiting approval',
                'message' => 'Your safety equipment request is awaiting Admin review.',
                'action_url' => '/hr/approvals',
            ],
            [
                'alert_key' => 'demo-hr-stock-'.$hrUser->id,
                'category' => 'low_stock',
                'title' => 'Low material stock',
                'message' => 'Portland Cement and Steel Rebar are at or below their reorder levels.',
                'action_url' => '/hr/inventory',
            ],
        ] as $notification) {
            ErpNotification::firstOrCreate(
                ['alert_key' => $notification['alert_key']],
                [
                    'user_id' => $hrUser->id,
                    'category' => $notification['category'],
                    'title' => $notification['title'],
                    'message' => $notification['message'],
                    'action_url' => $notification['action_url'],
                ]
            );
        }
    }

    private function recordMovement(
        Material $material,
        string $type,
        float|int $quantity,
        float $unitCost,
        ?Project $project,
        User $user,
        string $reference,
        string $notes,
        ?int $purchaseOrderItemId = null
    ): void {
        InventoryTransaction::firstOrCreate(
            ['reference' => $reference],
            [
                'material_id' => $material->id,
                'project_id' => $project?->id,
                'user_id' => $user->id,
                'purchase_order_item_id' => $purchaseOrderItemId,
                'type' => $type,
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'transaction_date' => today()->subDay()->toDateString(),
                'notes' => $notes,
            ]
        );
    }

    private function recordPurchaseApproval(
        PurchaseRequest $purchaseRequest,
        User $user,
        string $status = 'pending',
        ?User $reviewer = null
    ): void {
        $approval = ApprovalRequest::firstOrCreate(
            [
                'subject_type' => 'purchase_request',
                'subject_id' => $purchaseRequest->id,
            ],
            [
                'request_type' => 'purchase',
                'project_id' => $purchaseRequest->project_id,
                'title' => 'Purchase request '.$purchaseRequest->request_number,
                'details' => $purchaseRequest->notes,
                'status' => $status,
                'requested_by' => $user->id,
                'reviewed_by' => $status === 'approved' ? $reviewer?->id : null,
                'reviewed_at' => $status === 'approved' ? now()->subHours(4) : null,
            ]
        );

        $this->recordSubmittedApprovalAction($approval, $user);

        if ($status === 'approved') {
            ApprovalAction::firstOrCreate(
                [
                    'approval_request_id' => $approval->id,
                    'action' => 'approved',
                ],
                [
                    'user_id' => $reviewer?->id ?? $user->id,
                    'from_status' => 'pending',
                    'to_status' => 'approved',
                    'notes' => 'Demo purchase request approved for supplier ordering.',
                ]
            );
        }
    }

    private function recordSubmittedApprovalAction(ApprovalRequest $approval, User $user): void
    {
        ApprovalAction::firstOrCreate(
            [
                'approval_request_id' => $approval->id,
                'action' => 'submitted',
            ],
            [
                'user_id' => $user->id,
                'from_status' => 'new',
                'to_status' => 'pending',
                'notes' => 'Demo request submitted for Admin review.',
            ]
        );
    }
}
