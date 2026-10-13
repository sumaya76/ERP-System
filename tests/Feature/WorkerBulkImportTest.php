<?php

namespace Tests\Feature;

use App\Livewire\Hr\EditWorker;
use App\Models\Worker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Tests\TestCase;

class WorkerBulkImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_imports_workers_from_a_valid_csv(): void
    {
        $csv = implode("\n", [
            'name,email,phone,national_id,rate,rate_type,status',
            'Sam Worker,sam@example.com,5550100,ID-100,20,hourly,',
        ]);

        Livewire::test(EditWorker::class)
            ->set('workerCsv', TemporaryUploadedFile::fake()->createWithContent('workers.csv', $csv))
            ->call('importWorkers')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('workers', [
            'name' => 'Sam Worker',
            'email' => 'sam@example.com',
            'status' => 'active',
            'rate_type' => 'hourly',
        ]);
    }

    public function test_it_imports_no_workers_when_a_csv_row_is_invalid(): void
    {
        $csv = implode("\n", [
            'name,email,phone,national_id,rate,rate_type',
            'Valid Worker,valid@example.com,5550100,ID-101,20,hourly',
            'Invalid Worker,not-an-email,5550101,ID-102,20,hourly',
        ]);

        Livewire::test(EditWorker::class)
            ->set('workerCsv', TemporaryUploadedFile::fake()->createWithContent('workers.csv', $csv))
            ->call('importWorkers')
            ->assertHasErrors('workerCsv');

        $this->assertSame(0, Worker::count());
    }
}
