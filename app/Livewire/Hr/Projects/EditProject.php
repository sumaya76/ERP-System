<?php

namespace App\Livewire\Hr\Projects;

use Livewire\Component;
use App\Models\Project;
use App\Models\BudgetItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class EditProject extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Actual filter properties (applied after search button click)
    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;

    // Temporary properties for button search
    public $tempSearch = '';
    public $tempStatusFilter = '';

    // Delete confirmation properties
    public $confirmingDelete = false;
    public $deleteId = null;
    public $deleteProjectName = '';

    // Edit modal properties
    public $editingProject = false;
    public $editProjectId = null;
    public $editForm = [
        'name' => '',
        'project_code' => '',
        'quotation_number' => '',
        'client_name' => '',
        'client_phone' => '',
        'client_email' => '',
        'client_address' => '',
        'location' => '',
        'description' => '',
        'contract_value' => '',
        'estimated_cost' => '',
        'vat_rate' => 0,
        'vat_included' => false,
        'start_date' => '',
        'end_date' => '',
        'valid_until' => '',
        'status' => 'planning',
    ];

    // Budget items for editing
    public $budgetItems = [];

    // Details modal properties
    public $showDetailsModal = false;
    public $selectedProject = null;
    public $projectCsv;

    // Status counts and icons
    public $statusCounts = [
        'planning' => 0,
        'ongoing' => 0,
        'on_hold' => 0,
        'completed' => 0,
        'cancelled' => 0,
    ];
    public $totalProjectsCount = 0;

    public $statusIcons = [
        'planning' => 'fa-calendar-alt',
        'ongoing' => 'fa-play-circle',
        'on_hold' => 'fa-pause-circle',
        'completed' => 'fa-check-circle',
        'cancelled' => 'fa-times-circle'
    ];

    protected $rules = [
        'editForm.name' => 'required|string|max:255',
        'editForm.project_code' => 'required|string|max:50',
        'editForm.quotation_number' => 'nullable|string|max:50',
        'editForm.client_name' => 'required|string|max:255',
        'editForm.client_phone' => 'nullable|string|max:20',
        'editForm.client_email' => 'nullable|email|max:255',
        'editForm.client_address' => 'nullable|string',
        'editForm.location' => 'nullable|string',
        'editForm.description' => 'nullable|string',
        'editForm.contract_value' => 'nullable|numeric|min:0',
        'editForm.estimated_cost' => 'nullable|numeric|min:0',
        'editForm.vat_rate' => 'nullable|numeric|min:0|max:100',
        'editForm.vat_included' => 'boolean',
        'editForm.start_date' => 'nullable|date',
        'editForm.end_date' => 'nullable|date|after_or_equal:start_date',
        'editForm.valid_until' => 'nullable|date',
        'editForm.status' => 'required|in:planning,ongoing,on_hold,completed,cancelled',
    ];

    public function mount()
    {
        $this->loadStatusCounts();
    }

    public function loadStatusCounts()
    {
        $this->statusCounts = [
            'planning' => Project::where('status', 'planning')->count(),
            'ongoing' => Project::where('status', 'ongoing')->count(),
            'on_hold' => Project::where('status', 'on_hold')->count(),
            'completed' => Project::where('status', 'completed')->count(),
            'cancelled' => Project::where('status', 'cancelled')->count(),
        ];
        $this->totalProjectsCount = Project::count();
    }

    public function filterByStatus($status)
    {
        $this->tempStatusFilter = $status;
        $this->statusFilter = $status;
        $this->search = $this->tempSearch;
        $this->resetPage();
    }

    public function showAllProjects()
    {
        $this->tempStatusFilter = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    public function performSearch()
    {
        $this->search = $this->tempSearch;
        $this->statusFilter = $this->tempStatusFilter;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->tempSearch = '';
        $this->tempStatusFilter = '';
        $this->resetPage();
    }

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

    public function addBudgetItem()
    {
        $this->budgetItems[] = [
            'id' => null,
            'section' => 'General',
            'description' => '',
            'unit' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'total' => 0,
        ];
    }

    public function removeBudgetItem($index)
    {
        if (isset($this->budgetItems[$index])) {
            if ($this->budgetItems[$index]['id']) {
                BudgetItem::find($this->budgetItems[$index]['id'])->delete();
            }
            array_splice($this->budgetItems, $index, 1);
            $this->recalculateTotals();
        }
    }

    public function updatedBudgetItems()
    {
        $this->recalculateTotals();
    }

    public function updatedEditFormVatRate()
    {
        $this->recalculateTotals();
    }

    public function updatedEditFormVatIncluded()
    {
        $this->recalculateTotals();
    }

    public function recalculateTotals()
    {
        // Calculate item totals
        foreach ($this->budgetItems as $index => $item) {
            $quantity = floatval($item['quantity'] ?? 0);
            $unitPrice = floatval($item['unit_price'] ?? 0);
            $this->budgetItems[$index]['total'] = $quantity * $unitPrice;
        }

        // Calculate subtotal
        $subtotal = collect($this->budgetItems)->sum('total');
        $vatRate = floatval($this->editForm['vat_rate'] ?? 0);
        $vatAmount = $subtotal * ($vatRate / 100);

        // Update estimated cost and contract value
        $this->editForm['estimated_cost'] = $subtotal;
        $this->editForm['contract_value'] = ($this->editForm['vat_included'] ?? false) ? $subtotal : $subtotal + $vatAmount;
    }

    public function openEditModal($id)
    {
        $project = Project::with('budgetItems')->findOrFail($id);

        $this->editProjectId = $project->id;
        $this->editForm = [
            'name' => $project->name,
            'project_code' => $project->project_code,
            'quotation_number' => $project->quotation_number,
            'client_name' => $project->client_name,
            'client_phone' => $project->client_phone,
            'client_email' => $project->client_email,
            'client_address' => $project->client_address,
            'location' => $project->location,
            'description' => $project->description,
            'contract_value' => $project->contract_value,
            'estimated_cost' => $project->estimated_cost,
            'vat_rate' => $project->vat_rate ?? 0,
            'vat_included' => $project->vat_included ?? false,
            'start_date' => $project->start_date,
            'end_date' => $project->end_date,
            'valid_until' => $project->valid_until,
            'status' => $project->status,
        ];

        // Load budget items
        $this->budgetItems = [];
        foreach ($project->budgetItems as $item) {
            $this->budgetItems[] = [
                'id' => $item->id,
                'section' => $item->section,
                'description' => $item->description,
                'unit' => $item->unit,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total' => $item->total,
            ];
        }

        if (empty($this->budgetItems)) {
            $this->addBudgetItem();
        }

        $this->editingProject = true;
    }

    public function viewDetails($id)
    {
        $this->selectedProject = Project::with('budgetItems')->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedProject = null;
    }

    public function updateProject()
    {
        // Validate unique project code except for current project
        $this->rules['editForm.project_code'] = 'required|string|max:50|unique:projects,project_code,' . $this->editProjectId;

        $this->validate();

        $this->recalculateTotals();

        $subtotal = collect($this->budgetItems)->sum('total');
        $vatRate = floatval($this->editForm['vat_rate'] ?? 0);
        $vatAmount = $subtotal * ($vatRate / 100);
        $totalWithVat = ($this->editForm['vat_included'] ?? false) ? $subtotal : $subtotal + $vatAmount;

        $project = Project::findOrFail($this->editProjectId);

        // Update project data
        $project->update([
            'name' => $this->editForm['name'],
            'project_code' => $this->editForm['project_code'],
            'quotation_number' => $this->editForm['quotation_number'],
            'client_name' => $this->editForm['client_name'],
            'client_phone' => $this->editForm['client_phone'],
            'client_email' => $this->editForm['client_email'],
            'client_address' => $this->editForm['client_address'],
            'location' => $this->editForm['location'],
            'description' => $this->editForm['description'],
            'contract_value' => $totalWithVat,
            'estimated_cost' => $subtotal,
            'budget_total' => $totalWithVat,
            'vat_rate' => $this->editForm['vat_rate'],
            'vat_included' => $this->editForm['vat_included'],
            'start_date' => $this->editForm['start_date'],
            'end_date' => $this->editForm['end_date'],
            'valid_until' => $this->editForm['valid_until'],
            'status' => $this->editForm['status'],
        ]);

        // Update budget items
        $existingItemIds = [];
        foreach ($this->budgetItems as $index => $item) {
            if (!empty($item['description'])) {
                $budgetItem = BudgetItem::updateOrCreate(
                    ['id' => $item['id']],
                    [
                        'project_id' => $project->id,
                        'section' => $item['section'],
                        'description' => $item['description'],
                        'unit' => $item['unit'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total' => $item['total'],
                        'sort_order' => $index,
                    ]
                );
                if ($budgetItem->id) {
                    $existingItemIds[] = $budgetItem->id;
                }
            }
        }

        // Delete budget items that were removed
        BudgetItem::where('project_id', $project->id)
            ->whereNotIn('id', $existingItemIds)
            ->delete();

        $vatStatus = $this->editForm['vat_rate'] > 0
            ? ($this->editForm['vat_included'] ? 'VAT ' . $this->editForm['vat_rate'] . '% included' : 'VAT ' . $this->editForm['vat_rate'] . '% added')
            : 'No VAT';

        session()->flash('message', 'Project updated successfully with ' . $vatStatus . '.');

        $this->closeEditModal();
        $this->loadStatusCounts();
        $this->resetPage();
    }

    public function closeEditModal()
    {
        $this->editingProject = false;
        $this->editProjectId = null;
        $this->editForm = [
            'name' => '',
            'project_code' => '',
            'quotation_number' => '',
            'client_name' => '',
            'client_phone' => '',
            'client_email' => '',
            'client_address' => '',
            'location' => '',
            'description' => '',
            'contract_value' => '',
            'estimated_cost' => '',
            'vat_rate' => 0,
            'vat_included' => false,
            'start_date' => '',
            'end_date' => '',
            'valid_until' => '',
            'status' => 'planning',
        ];
        $this->budgetItems = [];
        $this->resetErrorBag();
    }

    public function confirmDelete($id)
    {
        $project = Project::find($id);
        if ($project) {
            $this->deleteId = $id;
            $this->deleteProjectName = $project->name;
            $this->confirmingDelete = true;
        }
    }

    public function deleteProject()
    {
        if ($this->deleteId) {
            $project = Project::find($this->deleteId);

            if ($project) {
                $project->workers()->detach();
                $project->expenses()->delete();
                $project->budgetItems()->delete();
                $project->delete();

                session()->flash('message', 'Project deleted successfully.');
                $this->loadStatusCounts();
            }

            $this->confirmingDelete = false;
            $this->deleteId = null;
            $this->deleteProjectName = '';
            $this->resetPage();
        }
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->deleteId = null;
        $this->deleteProjectName = '';
    }

    public function downloadProjectCsvTemplate()
    {
        $headers = [
            'name',
            'project_code',
            'client_name',
            'client_phone',
            'client_email',
            'client_address',
            'location',
            'description',
            'contract_value',
            'estimated_cost',
            'vat_rate',
            'vat_included',
            'start_date',
            'end_date',
            'quotation_number',
            'valid_until',
            'status',
        ];

        return response()->streamDownload(function () use ($headers): void {
            $output = fopen('php://output', 'wb');

            if ($output === false) {
                throw new \RuntimeException('Unable to generate the project CSV template.');
            }

            if (fwrite($output, "\xEF\xBB\xBF") === false || fputcsv($output, $headers) === false) {
                fclose($output);
                throw new \RuntimeException('Unable to write the project CSV template.');
            }

            fclose($output);
        }, 'projects-template.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function importProjects(): void
    {
        $this->validate([
            'projectCsv' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $path = $this->projectCsv->getRealPath();
        if ($path === false) {
            $this->addError('projectCsv', 'The uploaded CSV file could not be read.');
            return;
        }

        $handle = fopen($path, 'rb');

        if ($handle === false) {
            $this->addError('projectCsv', 'The uploaded CSV file could not be read.');
            return;
        }

        $requiredHeaders = ['name', 'project_code', 'client_name'];
        $allowedHeaders = [
            'name', 'project_code', 'client_name', 'client_phone', 'client_email', 'client_address',
            'location', 'description', 'contract_value', 'estimated_cost', 'vat_rate', 'vat_included',
            'start_date', 'end_date', 'quotation_number', 'valid_until', 'status',
        ];
        $rows = [];
        $errors = [];
        $seenCodes = [];
        $lineNumber = 1;
        $dataRowCount = 0;

        try {
            $csvHeaders = fgetcsv($handle);

            if (!is_array($csvHeaders)) {
                $this->addError('projectCsv', 'The CSV file is empty.');
                return;
            }

            $headers = array_map(
                static fn ($header) => strtolower(trim(ltrim((string) $header, "\xEF\xBB\xBF"))),
                $csvHeaders
            );

            if (count($headers) !== count(array_unique($headers))) {
                $this->addError('projectCsv', 'The CSV file contains duplicate column names.');
                return;
            }

            $missingHeaders = array_diff($requiredHeaders, $headers);
            if ($missingHeaders !== []) {
                $this->addError(
                    'projectCsv',
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
                    $errors[] = 'The CSV file may contain no more than 1,000 project rows.';
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

                $row = array_intersect_key($row, array_flip($allowedHeaders));

                foreach ($row as $field => $value) {
                    if ($value === '' && !in_array($field, $requiredHeaders, true)) {
                        $row[$field] = null;
                    }
                }

                $row['contract_value'] = $row['contract_value'] ?? 0;
                $row['estimated_cost'] = $row['estimated_cost'] ?? 0;
                $row['vat_rate'] = $row['vat_rate'] ?? 0;
                $row['vat_included'] = $this->normalizeCsvBoolean($row['vat_included'] ?? null);
                $row['status'] = $row['status'] ?? 'planning';
                $row['budget_total'] = $row['contract_value'];

                $validator = Validator::make($row, [
                    'name' => 'required|string|max:255',
                    'project_code' => 'required|string|max:50|unique:projects,project_code',
                    'client_name' => 'required|string|max:255',
                    'client_phone' => 'nullable|string|max:20',
                    'client_email' => 'nullable|email|max:255',
                    'client_address' => 'nullable|string',
                    'location' => 'nullable|string',
                    'description' => 'nullable|string',
                    'contract_value' => 'numeric|min:0',
                    'estimated_cost' => 'numeric|min:0',
                    'vat_rate' => 'numeric|min:0|max:100',
                    'vat_included' => 'boolean',
                    'start_date' => 'nullable|date',
                    'end_date' => 'nullable|date|after_or_equal:start_date',
                    'quotation_number' => 'nullable|string|max:50',
                    'valid_until' => 'nullable|date',
                    'status' => 'required|in:planning,ongoing,on_hold,completed,cancelled',
                    'budget_total' => 'numeric|min:0',
                ]);

                if ($validator->fails()) {
                    $errors[] = "Row {$lineNumber}: " . implode(' ', $validator->errors()->all());
                    continue;
                }

                $code = strtolower($row['project_code']);
                if (isset($seenCodes[$code])) {
                    $errors[] = "Row {$lineNumber}: project code {$row['project_code']} is duplicated in this file.";
                    continue;
                }

                $seenCodes[$code] = true;
                $rows[] = $row;
            }
        } finally {
            fclose($handle);
        }

        if ($rows === [] && $errors === []) {
            $this->addError('projectCsv', 'The CSV file does not contain any project rows.');
            return;
        }

        if ($errors !== []) {
            $this->addError('projectCsv', implode(' ', array_slice($errors, 0, 30)));
            return;
        }

        DB::transaction(function () use ($rows): void {
            foreach ($rows as $row) {
                Project::create($row);
            }
        });

        $importedCount = count($rows);
        $this->projectCsv = null;
        $this->loadStatusCounts();
        $this->resetPage();
        session()->flash('message', "{$importedCount} projects imported successfully.");
    }

    private function normalizeCsvBoolean(?string $value): int
    {
        if ($value === null || $value === '') {
            return 0;
        }

        return match (strtolower($value)) {
            '1', 'true', 'yes' => 1,
            '0', 'false', 'no' => 0,
            default => -1,
        };
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Project::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('project_code', 'like', "%{$this->search}%")
                    ->orWhere('quotation_number', 'like', "%{$this->search}%")
                    ->orWhere('client_name', 'like', "%{$this->search}%");
            });
        }

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        $projects = $query->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.hr.projects.edit-project', [
            'projects' => $projects
        ])->layout('layouts.hrmanagerdashboard');
    }
}
