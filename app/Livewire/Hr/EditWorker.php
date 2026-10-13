<?php

namespace App\Livewire\Hr;

use Livewire\Component;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EditWorker extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Search properties (actual filters applied after button click)
    public $search = '';
    public $statusFilter = '';
    public $departmentFilter = '';
    
    // Temporary properties for button search
    public $tempSearch = '';
    public $tempStatusFilter = '';
    public $tempDepartmentFilter = '';
    
    public $confirmingDelete = false;
    public $deleteId = null;
    
    // For details modal
    public $showDetailsModal = false;
    public $selectedWorker = null;
    public $workerCsv;

    protected $paginationTheme = 'bootstrap';
    
    protected $queryString = ['search', 'statusFilter', 'departmentFilter'];

    // Perform search when button is clicked
    public function performSearch()
    {
        $this->search = $this->tempSearch;
        $this->statusFilter = $this->tempStatusFilter;
        $this->departmentFilter = $this->tempDepartmentFilter;
        $this->resetPage();
    }
    
    // Reset all filters
    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->departmentFilter = '';
        $this->tempSearch = '';
        $this->tempStatusFilter = '';
        $this->tempDepartmentFilter = '';
        $this->resetPage();
    }
    
    // Clear individual filters
    public function clearSearch()
    {
        $this->tempSearch = '';
        $this->search = '';
        $this->resetPage();
    }
    
    public function clearStatusFilter()
    {
        $this->tempStatusFilter = '';
        $this->statusFilter = '';
        $this->resetPage();
    }
    
    public function clearDepartmentFilter()
    {
        $this->tempDepartmentFilter = '';
        $this->departmentFilter = '';
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->deleteId = $id;
    }

    public function deleteWorker()
    {
        if ($this->deleteId) {
            $worker = Worker::find($this->deleteId);
            if ($worker) {
                $worker->delete();
                session()->flash('message', 'Worker deleted successfully.');
            }
            $this->confirmingDelete = false;
            $this->deleteId = null;
        }
    }
    
    public function viewDetails($id)
    {
        $this->selectedWorker = Worker::find($id);
        $this->showDetailsModal = true;
    }
    
    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedWorker = null;
    }

    public function downloadWorkerCsvTemplate()
    {
        $headers = [
            'name',
            'email',
            'phone',
            'alternate_phone',
            'address',
            'city',
            'state',
            'zip',
            'country',
            'emergency_contact_name',
            'emergency_contact_phone',
            'dob',
            'national_id',
            'blood_group',
            'medical_issue_date',
            'medical_expiry_date',
            'rate',
            'rate_type',
            'department',
            'designation',
            'date_of_joining',
            'status',
        ];

        return response()->streamDownload(function () use ($headers): void {
            $output = fopen('php://output', 'wb');

            if ($output === false) {
                throw new \RuntimeException('Unable to generate the worker CSV template.');
            }

            if (fwrite($output, "\xEF\xBB\xBF") === false || fputcsv($output, $headers) === false) {
                fclose($output);
                throw new \RuntimeException('Unable to write the worker CSV template.');
            }
            fclose($output);
        }, 'workers-template.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function importWorkers(): void
    {
        $this->validate([
            'workerCsv' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $path = $this->workerCsv->getRealPath();
        if ($path === false) {
            $this->addError('workerCsv', 'The uploaded CSV file could not be read.');
            return;
        }

        $handle = fopen($path, 'rb');

        if ($handle === false) {
            $this->addError('workerCsv', 'The uploaded CSV file could not be read.');
            return;
        }

        $requiredHeaders = ['name', 'email', 'phone', 'national_id', 'rate', 'rate_type'];
        $headers = [];
        $rows = [];
        $errors = [];
        $seenEmails = [];
        $lineNumber = 1;
        $dataRowCount = 0;

        try {
            $csvHeaders = fgetcsv($handle);

            if (!is_array($csvHeaders)) {
                $this->addError('workerCsv', 'The CSV file is empty.');
                return;
            }

            $headers = array_map(
                static fn ($header) => strtolower(trim(ltrim((string) $header, "\xEF\xBB\xBF"))),
                $csvHeaders
            );

            if (count($headers) !== count(array_unique($headers))) {
                $this->addError('workerCsv', 'The CSV file contains duplicate column names.');
                return;
            }

            $missingHeaders = array_diff($requiredHeaders, $headers);
            if ($missingHeaders !== []) {
                $this->addError(
                    'workerCsv',
                    'Missing required CSV columns: ' . implode(', ', $missingHeaders) . '. Download the template for the correct format.'
                );
                return;
            }

            while (($values = fgetcsv($handle)) !== false) {
                $lineNumber++;

                if ($values === [null] || count(array_filter($values, static fn ($value) => trim((string) $value) !== '')) === 0) {
                    continue;
                }

                $dataRowCount++;
                if ($dataRowCount > 1000) {
                    $errors[] = 'The CSV file may contain no more than 1,000 worker rows.';
                    break;
                }

                if (count($values) > count($headers)) {
                    $errors[] = "Row {$lineNumber}: contains more values than there are column headers.";
                    continue;
                }

                $values = array_pad($values, count($headers), '');
                $row = array_combine($headers, array_map(
                    static fn ($value) => trim((string) $value),
                    $values
                ));

                if ($row === false) {
                    $errors[] = "Row {$lineNumber}: could not be parsed.";
                    continue;
                }

                $row = array_intersect_key($row, array_flip([
                    'name', 'email', 'phone', 'alternate_phone', 'address', 'city', 'state', 'zip',
                    'country', 'emergency_contact_name', 'emergency_contact_phone', 'dob', 'national_id',
                    'blood_group', 'medical_issue_date', 'medical_expiry_date', 'rate', 'rate_type',
                    'department', 'designation', 'date_of_joining', 'status',
                ]));

                if (trim(implode('', $row)) === '') {
                    continue;
                }

                foreach ($row as $field => $value) {
                    if ($value === '' && !in_array($field, $requiredHeaders, true)) {
                        $row[$field] = null;
                    }
                }
                $row['status'] = $row['status'] ?? 'active';

                $validator = Validator::make($row, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:workers,email',
                    'phone' => 'required|string|max:20',
                    'alternate_phone' => 'nullable|string|max:20',
                    'address' => 'nullable|string|max:255',
                    'city' => 'nullable|string|max:50',
                    'state' => 'nullable|string|max:50',
                    'zip' => 'nullable|string|max:20',
                    'country' => 'nullable|string|max:50',
                    'emergency_contact_name' => 'nullable|string|max:255',
                    'emergency_contact_phone' => 'nullable|string|max:20',
                    'dob' => 'nullable|date',
                    'national_id' => 'required|string|max:255',
                    'blood_group' => 'nullable|string|max:5',
                    'medical_issue_date' => 'nullable|date',
                    'medical_expiry_date' => 'nullable|date|after_or_equal:medical_issue_date',
                    'rate' => 'required|numeric|min:0',
                    'rate_type' => 'required|in:hourly,daily,monthly',
                    'department' => 'nullable|string|max:50',
                    'designation' => 'nullable|string|max:50',
                    'date_of_joining' => 'nullable|date',
                    'status' => 'required|in:active,inactive,terminated',
                ]);

                if ($validator->fails()) {
                    $errors[] = "Row {$lineNumber}: " . implode(' ', $validator->errors()->all());
                    continue;
                }

                $email = strtolower($row['email']);
                if (isset($seenEmails[$email])) {
                    $errors[] = "Row {$lineNumber}: email {$row['email']} is duplicated in this file.";
                    continue;
                }

                $seenEmails[$email] = true;
                $rows[] = $row;
            }
        } finally {
            fclose($handle);
        }

        if ($rows === [] && $errors === []) {
            $this->addError('workerCsv', 'The CSV file does not contain any worker rows.');
            return;
        }

        if ($errors !== []) {
            $this->addError('workerCsv', implode(' ', array_slice($errors, 0, 30)));
            return;
        }

        DB::transaction(function () use ($rows): void {
            foreach ($rows as $row) {
                Worker::create($row);
            }
        });

        $importedCount = count($rows);
        $this->workerCsv = null;
        $this->resetPage();
        session()->flash('message', "{$importedCount} workers imported successfully.");
    }

    public function render()
    {
        $workers = Worker::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('alternate_phone', 'like', '%' . $this->search . '%')
                      ->orWhere('national_id', 'like', '%' . $this->search . '%')
                      ->orWhere('department', 'like', '%' . $this->search . '%')
                      ->orWhere('designation', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->departmentFilter, function ($query) {
                $query->where('department', $this->departmentFilter);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Get unique departments for filter dropdown
        $departments = Worker::whereNotNull('department')
            ->distinct()
            ->pluck('department')
            ->toArray();

        return view('livewire.hr.edit-worker', [
            'workers' => $workers,
            'departments' => $departments,
        ])->layout('layouts.hrmanagerdashboard');
    }
}