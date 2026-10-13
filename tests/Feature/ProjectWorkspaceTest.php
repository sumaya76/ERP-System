<?php

namespace Tests\Feature;

use App\Livewire\Shared\ProjectWorkspace;
use App\Models\ExpenseCategory;
use App\Models\InventoryTransaction;
use App\Models\Material;
use App\Models\Payroll;
use App\Models\PayrollBatch;
use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\Role;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectWorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_records_daily_progress_and_updates_project_snapshot(): void
    {
        $user = $this->createUser('hr');
        $project = $this->createProject();
        $this->actingAs($user);

        Livewire::test(ProjectWorkspace::class)
            ->set('projectId', $project->id)
            ->set('stage', 'Structure')
            ->set('progressPercent', '42.5')
            ->set('progressSummary', 'Second floor structural work completed.')
            ->set('blockers', 'Concrete delivery delayed by one day.')
            ->call('saveProgressUpdate')
            ->assertHasNoErrors()
            ->set('milestoneName', 'Complete second floor')
            ->set('milestoneDueDate', today()->addDays(5)->toDateString())
            ->call('addMilestone')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'project_stage' => 'Structure',
            'progress_percent' => 42.5,
        ]);
        $this->assertDatabaseHas('project_progress_updates', [
            'project_id' => $project->id,
            'stage' => 'Structure',
            'progress_percent' => 42.5,
        ]);
        $this->assertDatabaseHas('project_milestones', [
            'project_id' => $project->id,
            'name' => 'Complete second floor',
            'status' => 'pending',
        ]);
    }

    public function test_documents_are_saved_in_private_storage_and_linked_to_project(): void
    {
        Storage::fake('local');
        $user = $this->createUser('hr');
        $project = $this->createProject();
        $this->actingAs($user);

        Livewire::test(ProjectWorkspace::class)
            ->set('projectId', $project->id)
            ->set('documentableType', 'project')
            ->set('documentableId', $project->id)
            ->set('documentCategory', 'contract')
            ->set('upload', UploadedFile::fake()->create('contract.pdf', 25, 'application/pdf'))
            ->call('saveDocument')
            ->assertHasNoErrors();

        $document = ProjectDocument::firstOrFail();
        $this->assertSame('project', $document->documentable_type);
        $this->assertSame($project->id, $document->documentable_id);
        Storage::disk('local')->assertExists($document->storage_path);
    }

    public function test_project_cost_summary_includes_materials_labour_and_expenses_and_flags_overrun(): void
    {
        $user = $this->createUser('admin');
        $project = $this->createProject();
        $project->update(['budget_cap' => 1000]);
        $material = Material::create([
            'sku' => 'COST-'.uniqid(),
            'name' => 'Project concrete',
            'unit' => 'm3',
            'reorder_level' => 0,
            'is_active' => true,
        ]);
        InventoryTransaction::create([
            'material_id' => $material->id,
            'project_id' => $project->id,
            'user_id' => $user->id,
            'type' => 'issue',
            'quantity' => 10,
            'unit_cost' => 60,
            'transaction_date' => today(),
        ]);
        $category = ExpenseCategory::firstOrCreate(['name' => 'Workspace cost']);
        \App\Models\ProjectExpense::create([
            'expense_type' => 'project',
            'project_id' => $project->id,
            'category_id' => $category->id,
            'description' => 'Site equipment rental',
            'amount' => 200,
            'expense_date' => today(),
            'created_by' => $user->id,
        ]);
        $worker = Worker::create([
            'name' => 'Cost worker',
            'email' => 'cost-'.uniqid().'@example.test',
            'rate_type' => 'hourly',
            'rate' => 20,
            'status' => 'active',
        ]);
        $batch = PayrollBatch::create([
            'year' => today()->year,
            'month' => today()->month,
            'period_start' => today()->startOfMonth(),
            'period_end' => today()->endOfMonth(),
            'status' => 'finalized',
            'finalized_at' => now(),
        ]);
        $payroll = Payroll::create([
            'payroll_batch_id' => $batch->id,
            'worker_id' => $worker->id,
            'rate_type' => 'hourly',
            'rate_snapshot' => 20,
            'total_days' => 5,
            'total_hours' => 15,
            'gross_amount' => 300,
            'advance_deduction' => 0,
            'manual_adjustment' => 0,
            'net_amount' => 300,
        ]);
        DB::table('payroll_project_breakdowns')->insert([
            'payroll_id' => $payroll->id,
            'project_id' => $project->id,
            'days' => 5,
            'hours' => 15,
            'amount' => 300,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($user);
        Livewire::test(ProjectWorkspace::class)
            ->set('projectId', $project->id)
            ->assertSee('Over budget')
            ->assertSee('600.00')
            ->assertSee('300.00')
            ->assertSee('200.00');
    }

    private function createProject(): Project
    {
        return Project::create([
            'name' => 'Workspace project',
            'project_code' => 'WS-'.uniqid(),
            'client_name' => 'Example client',
            'estimated_cost' => 10000,
            'status' => 'ongoing',
        ]);
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
