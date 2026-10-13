<?php

namespace Tests\Feature;

use App\Livewire\Hr\Projects\EditProject;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectBulkImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_imports_projects_from_a_valid_csv(): void
    {
        $csv = implode("\n", [
            'name,project_code,client_name,contract_value,estimated_cost,status',
            'Office Renovation,P-2026-100,Example Client,12000,10000,ongoing',
        ]);

        Livewire::test(EditProject::class)
            ->set('projectCsv', TemporaryUploadedFile::fake()->createWithContent('projects.csv', $csv))
            ->call('importProjects')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('projects', [
            'name' => 'Office Renovation',
            'project_code' => 'P-2026-100',
            'client_name' => 'Example Client',
            'contract_value' => 12000,
            'budget_total' => 12000,
            'estimated_cost' => 10000,
            'status' => 'ongoing',
        ]);
    }

    public function test_it_does_not_import_any_projects_when_a_csv_row_is_invalid(): void
    {
        $csv = implode("\n", [
            'name,project_code,client_name,client_email',
            'Valid Project,P-2026-101,Example Client,client@example.com',
            'Invalid Project,P-2026-102,Another Client,not-an-email',
        ]);

        Livewire::test(EditProject::class)
            ->set('projectCsv', TemporaryUploadedFile::fake()->createWithContent('projects.csv', $csv))
            ->call('importProjects')
            ->assertHasErrors('projectCsv');

        $this->assertSame(0, Project::count());
    }
}
