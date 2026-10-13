<?php

namespace Tests\Feature;

use App\Livewire\Shared\ApprovalCenter;
use App\Models\ApprovalAction;
use App\Models\ApprovalRequest;
use App\Models\ErpNotification;
use App\Models\ExpenseCategory;
use App\Models\Material;
use App\Models\Payroll;
use App\Models\PayrollBatch;
use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\ProjectExpense;
use App\Models\Role;
use App\Models\SaleInvoice;
use App\Models\User;
use App\Models\Worker;
use App\Services\ErpReminderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ApprovalReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_hr_requests_and_admin_decisions_are_recorded_in_approval_history(): void
    {
        $hr = $this->createUser('hr');
        $admin = $this->createUser('admin');
        $category = ExpenseCategory::firstOrCreate(['name' => 'Approval test']);
        $this->actingAs($hr);

        Livewire::test(ApprovalCenter::class)
            ->set('requestType', 'expense')
            ->set('title', 'Request site equipment expense')
            ->set('details', 'Supplier quotation ref SUP-22.')
            ->set('amount', '450.00')
            ->set('categoryId', $category->id)
            ->call('submitRequest')
            ->assertHasNoErrors();

        $request = ApprovalRequest::firstOrFail();
        $this->assertSame('pending', $request->status);
        $this->assertDatabaseHas('approval_actions', [
            'approval_request_id' => $request->id,
            'action' => 'submitted',
            'to_status' => 'pending',
        ]);

        $this->actingAs($admin);
        Livewire::test(ApprovalCenter::class)
            ->set('decisionNote', 'Please attach a revised supplier quote.')
            ->call('decide', $request->id, 'rejected')
            ->assertHasNoErrors();

        $this->assertSame('rejected', $request->fresh()->status);
        $this->assertSame(2, ApprovalAction::where('approval_request_id', $request->id)->count());
        $this->assertDatabaseHas('approval_actions', [
            'approval_request_id' => $request->id,
            'action' => 'rejected',
            'notes' => 'Please attach a revised supplier quote.',
        ]);
        $this->assertDatabaseMissing('project_expenses', ['description' => 'Request site equipment expense']);
    }

    public function test_approved_expense_request_creates_a_real_project_expense(): void
    {
        $hr = $this->createUser('hr');
        $admin = $this->createUser('admin');
        $category = ExpenseCategory::firstOrCreate(['name' => 'Approved expense']);
        $project = Project::create([
            'name' => 'Expense project',
            'project_code' => 'EX-'.uniqid(),
            'client_name' => 'Example client',
            'status' => 'ongoing',
        ]);
        $this->actingAs($hr);

        Livewire::test(ApprovalCenter::class)
            ->set('requestType', 'expense')
            ->set('projectId', $project->id)
            ->set('categoryId', $category->id)
            ->set('title', 'Approved safety equipment')
            ->set('amount', '725.50')
            ->set('details', 'Approved before purchase.')
            ->call('submitRequest')
            ->assertHasNoErrors();
        $request = ApprovalRequest::firstOrFail();

        $this->actingAs($admin);
        Livewire::test(ApprovalCenter::class)
            ->call('decide', $request->id, 'approved')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('project_expenses', [
            'project_id' => $project->id,
            'category_id' => $category->id,
            'description' => 'Approved safety equipment',
            'amount' => 725.5,
            'created_by' => $hr->id,
        ]);
        $this->assertSame('project_expense', $request->fresh()->subject_type);
    }

    public function test_approved_payroll_and_quotation_requests_update_their_source_records(): void
    {
        $hr = $this->createUser('hr');
        $admin = $this->createUser('admin');
        $project = Project::create([
            'name' => 'Quotation approval project',
            'project_code' => 'QA-'.uniqid(),
            'client_name' => 'Example client',
            'status' => 'planning',
        ]);
        $batch = PayrollBatch::create([
            'year' => today()->year,
            'month' => today()->month,
            'period_start' => today()->startOfMonth(),
            'period_end' => today()->endOfMonth(),
            'status' => 'draft',
        ]);
        $worker = Worker::create([
            'name' => 'Payroll approval worker',
            'email' => 'payroll-'.uniqid().'@example.test',
            'rate_type' => 'hourly',
            'rate' => 15,
            'status' => 'active',
        ]);
        Payroll::create([
            'payroll_batch_id' => $batch->id,
            'worker_id' => $worker->id,
            'rate_type' => 'hourly',
            'rate_snapshot' => 15,
            'total_days' => 2,
            'total_hours' => 16,
            'gross_amount' => 240,
            'advance_deduction' => 0,
            'manual_adjustment' => 0,
            'net_amount' => 240,
        ]);

        $this->actingAs($hr);
        Livewire::test(ApprovalCenter::class)
            ->set('requestType', 'payroll')
            ->set('payrollBatchId', $batch->id)
            ->call('submitRequest')
            ->assertHasNoErrors();
        $payrollApproval = ApprovalRequest::where('request_type', 'payroll')->firstOrFail();

        $this->actingAs($admin);
        Livewire::test(ApprovalCenter::class)
            ->call('decide', $payrollApproval->id, 'approved')
            ->assertHasNoErrors();
        $this->assertDatabaseHas('payroll_batches', ['id' => $batch->id, 'status' => 'finalized']);

        $this->actingAs($hr);
        Livewire::test(ApprovalCenter::class)
            ->set('requestType', 'quotation')
            ->set('projectId', $project->id)
            ->set('title', 'Submit client quotation')
            ->call('submitRequest')
            ->assertHasNoErrors();
        $quotationApproval = ApprovalRequest::where('request_type', 'quotation')->firstOrFail();

        $this->actingAs($admin);
        Livewire::test(ApprovalCenter::class)
            ->set('decisionNote', 'Quotation reviewed.')
            ->call('decide', $quotationApproval->id, 'approved')
            ->assertHasNoErrors();
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'quotation_approval_status' => 'approved',
            'quotation_approved_by' => $admin->id,
        ]);
    }

    public function test_reminder_generation_is_idempotent_for_deadlines_expiry_and_low_stock(): void
    {
        $admin = $this->createUser('admin');
        $hr = $this->createUser('hr');
        $project = Project::create([
            'name' => 'Deadline project',
            'project_code' => 'DL-001',
            'client_name' => 'Example client',
            'end_date' => today()->addDays(3),
            'budget_cap' => 100,
            'status' => 'ongoing',
        ]);
        Worker::create([
            'name' => 'Medical renewal worker',
            'email' => 'medical-'.uniqid().'@example.test',
            'medical_expiry_date' => today()->addDays(10)->toDateString(),
            'rate_type' => 'hourly',
            'rate' => 0,
            'status' => 'active',
        ]);
        Material::create([
            'sku' => 'LOW-'.uniqid(),
            'name' => 'Low stock cement',
            'unit' => 'bag',
            'reorder_level' => 10,
            'is_active' => true,
        ]);
        $category = ExpenseCategory::firstOrCreate(['name' => 'Reminder test']);
        ProjectExpense::create([
            'expense_type' => 'project',
            'project_id' => $project->id,
            'category_id' => $category->id,
            'description' => 'Over-budget test expense',
            'amount' => 200,
            'expense_date' => today(),
            'created_by' => $hr->id,
        ]);
        \App\Models\ProjectMilestone::create([
            'project_id' => $project->id,
            'name' => 'Reminder milestone',
            'due_date' => today()->addDays(2),
            'status' => 'pending',
            'created_by' => $hr->id,
        ]);
        ProjectDocument::create([
            'documentable_type' => 'project',
            'documentable_id' => $project->id,
            'uploaded_by' => $hr->id,
            'category' => 'permit',
            'original_name' => 'site-permit.pdf',
            'storage_path' => 'erp-documents/test-permit.pdf',
            'mime_type' => 'application/pdf',
            'size_bytes' => 100,
            'expires_at' => today()->addDays(12),
        ]);
        ApprovalRequest::create([
            'request_type' => 'quotation',
            'project_id' => $project->id,
            'title' => 'Quotation review',
            'status' => 'pending',
            'requested_by' => $hr->id,
        ]);
        SaleInvoice::create([
            'invoice_number' => 'REM-'.uniqid(),
            'invoice_date' => today()->subDays(45),
            'payment_status' => 'unpaid',
            'project_id' => $project->id,
            'client_name' => 'Reminder client',
            'subtotal' => 100,
            'vat_amount' => 21,
            'total' => 121,
            'created_by' => $admin->id,
        ]);

        $service = app(ErpReminderService::class);
        $service->generate();
        $firstCount = ErpNotification::count();
        $service->generate();

        $this->assertGreaterThanOrEqual(3, $firstCount);
        $this->assertSame($firstCount, ErpNotification::count());
        $this->assertDatabaseHas('erp_notifications', [
            'user_id' => $admin->id,
            'category' => 'project_deadline',
        ]);
        $this->assertDatabaseHas('erp_notifications', [
            'user_id' => $hr->id,
            'category' => 'medical_expiry',
        ]);
        $this->assertDatabaseHas('erp_notifications', [
            'category' => 'low_stock',
            'resolved_at' => null,
        ]);
        foreach (['milestone_due', 'document_expiry', 'pending_approval', 'budget_overrun', 'unpaid_invoice'] as $category) {
            $this->assertDatabaseHas('erp_notifications', [
                'category' => $category,
                'resolved_at' => null,
            ]);
        }
    }

    private function createUser(string $roleName): User
    {
        $role = Role::firstOrCreate(['name' => $roleName]);

        return User::create([
            'name' => ucfirst($roleName).' User',
            'email' => $roleName.uniqid().'@example.test',
            'password' => 'password',
            'role_id' => $role->id,
            'status' => 'active',
        ]);
    }
}
