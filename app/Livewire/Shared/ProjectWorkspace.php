<?php

namespace App\Livewire\Shared;

use App\Models\InventoryTransaction;
use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\ProjectMilestone;
use App\Models\ProjectProgressUpdate;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectWorkspace extends Component
{
    use WithFileUploads;

    public ?int $projectId = null;

    public ?string $budgetCapInput = null;

    public string $stage = 'Planning';

    public string $progressPercent = '0';

    public string $progressSummary = '';

    public ?string $blockers = null;

    public string $milestoneName = '';

    public ?string $milestoneDueDate = null;

    public ?string $milestoneDescription = null;

    public string $documentableType = 'project';

    public ?int $documentableId = null;

    public string $documentCategory = 'contract';

    public $upload = null;

    public ?string $documentExpiry = null;

    public ?string $documentNotes = null;

    public function mount(): void
    {
        $this->ensureWorkspaceRole();
        $this->projectId = Project::orderBy('name')->value('id');
        $this->budgetCapInput = $this->projectId
            ? Project::whereKey($this->projectId)->value('budget_cap')
            : null;
        $requestedType = request()->query('documentableType');
        $requestedId = request()->query('documentableId');
        if ($requestedType === 'worker' && $requestedId && Worker::whereKey($requestedId)->exists()) {
            $this->documentableType = 'worker';
            $this->documentableId = (int) $requestedId;
        } elseif ($requestedType === 'project' && $requestedId && Project::whereKey($requestedId)->exists()) {
            $this->projectId = (int) $requestedId;
            $this->documentableType = 'project';
            $this->documentableId = (int) $requestedId;
        } else {
            $this->documentableId = $this->projectId;
        }
    }

    public function updatedDocumentableType(): void
    {
        $this->documentableId = $this->documentableType === 'project'
            ? $this->projectId
            : Worker::where('status', 'active')->orderBy('name')->value('id');
    }

    public function updatedProjectId(): void
    {
        $this->budgetCapInput = Project::whereKey($this->projectId)->value('budget_cap');
        $this->documentableId = $this->documentableType === 'project'
            ? $this->projectId
            : $this->documentableId;
    }

    public function saveBudgetCap(): void
    {
        $this->ensureWorkspaceRole();
        $data = $this->validate([
            'projectId' => ['required', 'integer', 'exists:projects,id'],
            'budgetCapInput' => ['nullable', 'numeric', 'gt:0'],
        ]);

        Project::whereKey($data['projectId'])->update([
            'budget_cap' => $data['budgetCapInput'] ?: null,
            'updated_at' => now(),
        ]);
        session()->flash('success', 'Project budget cap updated.');
    }

    public function saveProgressUpdate(): void
    {
        $this->ensureWorkspaceRole();
        $data = $this->validate([
            'projectId' => ['required', 'integer', 'exists:projects,id'],
            'stage' => ['required', 'string', 'max:100'],
            'progressPercent' => ['required', 'numeric', 'min:0', 'max:100'],
            'progressSummary' => ['required', 'string', 'min:5', 'max:5000'],
            'blockers' => ['nullable', 'string', 'max:5000'],
        ]);

        DB::transaction(function () use ($data) {
            $project = Project::whereKey($data['projectId'])->lockForUpdate()->firstOrFail();
            ProjectProgressUpdate::create([
                'project_id' => $project->id,
                'user_id' => auth()->id(),
                'update_date' => today(),
                'stage' => $data['stage'],
                'progress_percent' => $data['progressPercent'],
                'summary' => $data['progressSummary'],
                'blockers' => $data['blockers'] ?: null,
            ]);
            $project->update([
                'project_stage' => $data['stage'],
                'progress_percent' => $data['progressPercent'],
            ]);
        });

        $this->progressSummary = '';
        $this->blockers = null;
        session()->flash('success', 'Daily project progress update saved.');
    }

    public function addMilestone(): void
    {
        $this->ensureWorkspaceRole();
        $data = $this->validate([
            'projectId' => ['required', 'integer', 'exists:projects,id'],
            'milestoneName' => ['required', 'string', 'max:255'],
            'milestoneDueDate' => ['nullable', 'date'],
            'milestoneDescription' => ['nullable', 'string', 'max:2000'],
        ]);

        ProjectMilestone::create([
            'project_id' => $data['projectId'],
            'name' => $data['milestoneName'],
            'due_date' => $data['milestoneDueDate'],
            'description' => $data['milestoneDescription'],
            'created_by' => auth()->id(),
        ]);

        $this->milestoneName = '';
        $this->milestoneDueDate = null;
        $this->milestoneDescription = null;
        session()->flash('success', 'Project milestone added.');
    }

    public function updateMilestone(int $milestoneId, string $status): void
    {
        $this->ensureWorkspaceRole();
        if (! in_array($status, ['pending', 'in_progress', 'completed'], true)) {
            throw ValidationException::withMessages(['milestoneName' => 'Invalid milestone status.']);
        }

        $milestone = ProjectMilestone::where('project_id', $this->projectId)
            ->whereKey($milestoneId)->firstOrFail();
        $milestone->update([
            'status' => $status,
            'completed_at' => $status === 'completed' ? now() : null,
        ]);
    }

    public function saveDocument(): void
    {
        $this->ensureWorkspaceRole();
        $data = $this->validate([
            'documentableType' => ['required', 'in:project,worker'],
            'documentableId' => ['required', 'integer'],
            'documentCategory' => ['required', 'in:contract,drawing,permit,invoice,identity,medical,certificate,other'],
            'upload' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx', 'max:10240'],
            'documentExpiry' => ['nullable', 'date'],
            'documentNotes' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($data['documentableType'] === 'project') {
            Project::findOrFail($data['documentableId']);
        } else {
            Worker::findOrFail($data['documentableId']);
        }

        $file = $this->upload;
        $path = $file->storeAs(
            'erp-documents',
            Str::uuid().'.'.strtolower($file->getClientOriginalExtension()),
            'local'
        );

        ProjectDocument::create([
            'documentable_type' => $data['documentableType'],
            'documentable_id' => $data['documentableId'],
            'uploaded_by' => auth()->id(),
            'category' => $data['documentCategory'],
            'original_name' => Str::limit(basename($file->getClientOriginalName()), 250, ''),
            'storage_path' => $path,
            'mime_type' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
            'expires_at' => $data['documentExpiry'],
            'notes' => $data['documentNotes'],
        ]);

        $this->reset('upload', 'documentExpiry', 'documentNotes');
        session()->flash('success', 'Document uploaded to private storage.');
    }

    public function downloadDocument(int $documentId)
    {
        $this->ensureWorkspaceRole();
        $document = ProjectDocument::whereKey($documentId)->firstOrFail();
        abort_unless(Storage::disk('local')->exists($document->storage_path), 404, 'Document file is missing.');

        return Storage::disk('local')->download($document->storage_path, $document->original_name);
    }

    public function deleteDocument(int $documentId): void
    {
        $this->ensureWorkspaceRole();
        $document = ProjectDocument::whereKey($documentId)->firstOrFail();
        if (Storage::disk('local')->exists($document->storage_path)
            && ! Storage::disk('local')->delete($document->storage_path)) {
            throw new \RuntimeException('The document could not be removed from private storage.');
        }
        $document->delete();
        session()->flash('success', 'Document deleted.');
    }

    private function ensureWorkspaceRole(): void
    {
        abort_unless(in_array(auth()->user()?->role?->name, ['admin', 'hr'], true), 403);
    }

    public function render()
    {
        $this->ensureWorkspaceRole();
        $projects = Project::with(['milestones' => fn ($query) => $query->orderBy('due_date')])
            ->with(['progressUpdates' => fn ($query) => $query->with('user')->latest('update_date')->limit(10)])
            ->orderBy('name')->get();

        $costs = [];
        foreach ($projects as $project) {
            $budgetLines = (float) $project->budgetItems()->sum('total');
            $budget = $project->budget_cap !== null
                ? (float) $project->budget_cap
                : ($budgetLines > 0 ? $budgetLines : (float) $project->estimated_cost);
            $expenses = (float) $project->expenses()->sum('amount');
            $labor = (float) DB::table('payroll_project_breakdowns as breakdowns')
                ->join('payrolls', 'payrolls.id', '=', 'breakdowns.payroll_id')
                ->join('payroll_batches', 'payroll_batches.id', '=', 'payrolls.payroll_batch_id')
                ->where('breakdowns.project_id', $project->id)
                ->where('payroll_batches.status', 'finalized')
                ->sum('breakdowns.amount');
            $materials = (float) InventoryTransaction::where('project_id', $project->id)
                ->whereIn('type', ['issue', 'return'])
                ->sum(DB::raw("CASE WHEN type = 'issue' THEN quantity * COALESCE(unit_cost, 0) ELSE -quantity * COALESCE(unit_cost, 0) END"));
            $costs[$project->id] = [
                'budget' => $budget,
                'materials' => $materials,
                'labor' => $labor,
                'expenses' => $expenses,
                'actual' => $materials + $labor + $expenses,
            ];
        }

        $selectedProject = $projects->firstWhere('id', $this->projectId);
        $documents = ProjectDocument::with('uploader')
            ->where('documentable_type', $this->documentableType)
            ->where('documentable_id', $this->documentableId ?? 0)
            ->latest()->limit(30)->get();

        return view('livewire.shared.project-workspace', [
            'projects' => $projects,
            'workers' => Worker::orderBy('name')->get(),
            'selectedProject' => $selectedProject,
            'costs' => $costs,
            'documents' => $documents,
        ])->layout(auth()->user()->role->name === 'admin'
            ? 'layouts.admindashboard'
            : 'layouts.hrmanagerdashboard');
    }
}
