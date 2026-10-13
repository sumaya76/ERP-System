<?php

namespace Tests\Feature;

use App\Models\ApprovalRequest;
use App\Models\ErpNotification;
use App\Models\Material;
use App\Models\Project;
use App\Models\ProjectMilestone;
use App\Models\ProjectProgressUpdate;
use App\Models\PurchaseRequest;
use App\Models\Role;
use App\Models\User;
use App\Livewire\Hr\Inventory;
use App\Livewire\Shared\ApprovalCenter;
use App\Livewire\Shared\Notifications;
use App\Livewire\Shared\ProjectWorkspace;
use Database\Seeders\HrModuleDemoDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HRModuleDemoDataSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_demo_data_for_hr_pages_without_creating_duplicates(): void
    {
        $hrRole = Role::firstOrCreate(['name' => 'hr']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $hrUser = User::factory()->create(['role_id' => $hrRole->id]);
        User::factory()->create(['role_id' => $adminRole->id]);

        $this->seed(HrModuleDemoDataSeeder::class);

        $project = Project::where('project_code', 'DEMO-INV-001')->firstOrFail();
        $this->assertSame(4, Material::where('sku', 'like', 'DEMO-%')->count());
        $this->assertSame(18.0, Material::where('sku', 'DEMO-CEM-001')->firstOrFail()->on_hand);
        $this->assertSame(5.0, Material::where('sku', 'DEMO-STL-001')->firstOrFail()->on_hand);
        $this->assertSame(2, PurchaseRequest::where('request_number', 'like', 'DEMO-INV-%')->count());
        $this->assertSame(2, ProjectMilestone::where('project_id', $project->id)->count());
        $this->assertSame(2, ProjectProgressUpdate::where('project_id', $project->id)->count());
        $this->assertSame(2, ApprovalRequest::where('requested_by', $hrUser->id)
            ->whereIn('request_type', ['expense', 'quotation'])->count());
        $this->assertSame(3, ErpNotification::where('user_id', $hrUser->id)
            ->where('alert_key', 'like', 'demo-hr-%')->count());

        $this->actingAs($hrUser);
        Livewire::test(Inventory::class)
            ->assertSee('DEMO-CEM-001')
            ->assertSee('DEMO-INV-PR-001');
        Livewire::test(ProjectWorkspace::class)
            ->assertSee('Demo Inventory - Riverside Office')
            ->assertSee('Complete structural frame');
        Livewire::test(ApprovalCenter::class)
            ->assertSee('Safety equipment for Riverside site')
            ->assertSee('Riverside Office structural works quotation');
        Livewire::test(Notifications::class)
            ->assertSee('Project update is ready')
            ->assertSee('Request awaiting approval');

        $this->seed(HrModuleDemoDataSeeder::class);

        $this->assertSame(4, Material::where('sku', 'like', 'DEMO-%')->count());
        $this->assertSame(9, \App\Models\InventoryTransaction::where('reference', 'like', 'DEMO-%')->count());
        $this->assertSame(2, PurchaseRequest::where('request_number', 'like', 'DEMO-INV-%')->count());
        $this->assertSame(2, ProjectMilestone::where('project_id', $project->id)->count());
        $this->assertSame(2, ProjectProgressUpdate::where('project_id', $project->id)->count());
        $this->assertSame(3, ErpNotification::where('user_id', $hrUser->id)
            ->where('alert_key', 'like', 'demo-hr-%')->count());
    }
}
