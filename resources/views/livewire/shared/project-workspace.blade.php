<div class="erp-module-page">
    <div class="card erp-page-heading shadow-sm border-0 mb-4">
        <div class="card-header border-0">
            <div class="d-flex align-items-center gap-3">
                <span class="erp-page-heading-icon"><i class="fa-solid fa-chart-gantt"></i></span>
                <div>
                    <h3 class="mb-1">Project Progress, Cost & Documents</h3>
                    <p class="mb-0">Track site progress, milestones, budget versus actual costs, and project/worker files.</p>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

    <div class="card mb-4">
        <div class="card-body">
            <label class="form-label fw-semibold" for="workspace-project">Project overview</label>
            <select id="workspace-project" class="form-select" wire:model.live="projectId" aria-describedby="workspace-project-help">
                @if ($projects->isEmpty())<option value="">No projects available</option>@endif
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->project_code }} — {{ $project->name }}</option>
                @endforeach
            </select>
            <div id="workspace-project-help" class="form-text">Choose a project to review progress, budget, milestones, and site updates.</div>
        </div>
    </div>

    @if ($selectedProject)
        @php
            $projectCost = $costs[$selectedProject->id];
            $budget = (float) $projectCost['budget'];
            $actual = (float) $projectCost['actual'];
            $budgetUsed = $budget > 0 ? min(100, ($actual / $budget) * 100) : 0;
        @endphp
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="card h-100"><div class="card-body">
                    <div class="text-muted mb-1">Project progress</div>
                    <h3 class="mb-2">{{ number_format((float) $selectedProject->progress_percent, 1) }}%</h3>
                    <div class="progress mb-2" role="progressbar" aria-label="Project completion" aria-valuenow="{{ min(100, (float) $selectedProject->progress_percent) }}" aria-valuemin="0" aria-valuemax="100" style="height: 8px"><div class="progress-bar bg-success" style="width: {{ min(100, (float) $selectedProject->progress_percent) }}%"></div></div>
                    <span class="badge bg-label-primary">{{ $selectedProject->project_stage }}</span>
                    @if ($selectedProject->quotation_approval_status)
                        <span class="badge {{ $selectedProject->quotation_approval_status === 'approved' ? 'bg-label-success' : ($selectedProject->quotation_approval_status === 'rejected' ? 'bg-label-danger' : 'bg-label-warning') }}">
                            Quotation {{ ucfirst($selectedProject->quotation_approval_status) }}
                        </span>
                    @endif
                </div></div>
            </div>
            <div class="col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><div class="text-muted mb-1">Budget</div><h3 class="mb-0">{{ number_format($budget, 2) }}</h3></div></div></div>
            <div class="col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><div class="text-muted mb-1">Actual cost</div><h3 class="mb-0">{{ number_format($actual, 2) }}</h3><small class="text-muted">Materials + labour + expenses</small></div></div></div>
            <div class="col-md-6 col-xl-3"><div class="card h-100"><div class="card-body">
                <div class="text-muted mb-1">Budget status</div>
                @if ($budget > 0 && $actual > $budget)
                    <h4 class="text-danger mb-1">Over budget</h4><small class="text-danger">{{ number_format($actual - $budget, 2) }} above budget</small>
                    <div class="progress mt-2" role="progressbar" aria-label="Budget usage" aria-valuenow="{{ min(100, $budgetUsed) }}" aria-valuemin="0" aria-valuemax="100" style="height: 6px"><div class="progress-bar bg-danger" style="width: {{ min(100, $budgetUsed) }}%"></div></div>
                @elseif ($budget > 0)
                    <h4 class="text-success mb-1">Within budget</h4><small>{{ number_format(100 - $budgetUsed, 1) }}% remaining</small>
                    <div class="progress mt-2" role="progressbar" aria-label="Budget usage" aria-valuenow="{{ $budgetUsed }}" aria-valuemin="0" aria-valuemax="100" style="height: 6px"><div class="progress-bar bg-success" style="width: {{ $budgetUsed }}%"></div></div>
                @else
                    <h4 class="mb-1">No budget set</h4><small>Add budget lines or a project budget cap.</small>
                @endif
            </div></div></div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div><h5 class="mb-1">Budget vs Actual Cost</h5><small class="text-muted">Compare total project costs with the budget.</small></div>
                <form wire:submit="saveBudgetCap" class="d-flex flex-wrap gap-2 align-items-center">
                    <label class="form-label mb-0" for="budget-cap">Budget cap</label>
            <input id="budget-cap" type="number" min="0.01" step="0.01" class="form-control form-control-sm" style="max-width: 170px" wire:model="budgetCapInput" placeholder="Use budget lines" aria-label="Project budget cap">
            <button class="btn btn-sm btn-outline-primary" type="submit" wire:loading.attr="disabled" wire:target="saveBudgetCap">
                <span wire:loading.remove wire:target="saveBudgetCap">Save cap</span>
                <span wire:loading wire:target="saveBudgetCap">Saving...</span>
            </button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Cost category</th><th>Actual</th><th>Share of budget</th></tr></thead>
                    <tbody>
                        <tr><td>Materials issued to site</td><td>{{ number_format($projectCost['materials'], 2) }}</td><td>{{ $budget > 0 ? number_format(($projectCost['materials'] / $budget) * 100, 1) : '—' }}%</td></tr>
                        <tr><td>Project labour</td><td>{{ number_format($projectCost['labor'], 2) }}</td><td>{{ $budget > 0 ? number_format(($projectCost['labor'] / $budget) * 100, 1) : '—' }}%</td></tr>
                        <tr><td>Recorded expenses</td><td>{{ number_format($projectCost['expenses'], 2) }}</td><td>{{ $budget > 0 ? number_format(($projectCost['expenses'] / $budget) * 100, 1) : '—' }}%</td></tr>
                        <tr class="table-light fw-semibold"><td>Total actual</td><td>{{ number_format($actual, 2) }}</td><td>{{ $budget > 0 ? number_format(($actual / $budget) * 100, 1) : '—' }}%</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-5">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-0">Daily Site Progress Update</h5></div>
                    <div class="card-body">
                        <form wire:submit="saveProgressUpdate">
                            <div class="mb-3"><label class="form-label">Current stage</label><input class="form-control" wire:model="stage" placeholder="Foundation, structure, finishing..." required></div>
                            <div class="mb-3"><label class="form-label">Completion %</label><input type="number" min="0" max="100" step="0.01" class="form-control" wire:model="progressPercent" required></div>
                            <div class="mb-3"><label class="form-label">Today's work completed</label><textarea class="form-control" rows="3" wire:model="progressSummary" required></textarea></div>
                            <div class="mb-3"><label class="form-label">Delay / blocker (optional)</label><textarea class="form-control" rows="2" wire:model="blockers"></textarea></div>
                            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="saveProgressUpdate">
                                <span wire:loading.remove wire:target="saveProgressUpdate">Save site update</span>
                                <span wire:loading wire:target="saveProgressUpdate"><span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Saving...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-0">Milestones</h5></div>
                    <div class="card-body border-bottom">
                        <form wire:submit="addMilestone">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-5"><label class="form-label">Milestone</label><input class="form-control" wire:model="milestoneName" required></div>
                                <div class="col-md-3"><label class="form-label">Target date</label><input type="date" class="form-control" wire:model="milestoneDueDate"></div>
                                <div class="col-md-4"><label class="form-label">Notes</label><input class="form-control" wire:model="milestoneDescription"></div>
                                <div class="col-12"><button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled" wire:target="addMilestone">
                                    <span wire:loading.remove wire:target="addMilestone"><i class="fa-solid fa-plus me-1"></i>Add milestone</span>
                                    <span wire:loading wire:target="addMilestone">Adding...</span>
                                </button></div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead><tr><th>Milestone</th><th>Due</th><th>Status</th><th>Update</th></tr></thead>
                            <tbody>
                                @forelse ($selectedProject->milestones as $milestone)
                                    <tr wire:key="milestone-{{ $milestone->id }}">
                                        <td>{{ $milestone->name }}<div class="small text-muted">{{ $milestone->description }}</div></td>
                                        <td>{{ $milestone->due_date?->format('d M Y') ?? '—' }}</td>
                                        <td>
                                            @if ($milestone->due_date && $milestone->due_date->lt(today()) && $milestone->status !== 'completed')
                                                <span class="badge bg-label-danger">Delayed</span>
                                            @else
                                                <span class="badge bg-label-secondary">{{ str_replace('_', ' ', ucfirst($milestone->status)) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm" wire:change="updateMilestone({{ $milestone->id }}, $event.target.value)">
                                                <option value="pending" @selected($milestone->status === 'pending')>Pending</option>
                                                <option value="in_progress" @selected($milestone->status === 'in_progress')>In progress</option>
                                                <option value="completed" @selected($milestone->status === 'completed')>Completed</option>
                                            </select>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">No milestones added.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Recent Daily Updates</h5></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Date</th><th>Stage</th><th>Progress</th><th>Update</th><th>Blockers</th><th>Updated by</th></tr></thead>
                    <tbody>
                        @forelse ($selectedProject->progressUpdates as $update)
                            <tr><td>{{ $update->update_date->format('d M Y') }}</td><td>{{ $update->stage }}</td><td>{{ number_format((float) $update->progress_percent, 1) }}%</td><td>{{ $update->summary }}</td><td>{{ $update->blockers ?: '—' }}</td><td>{{ $update->user->name }}</td></tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">No daily updates yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card erp-empty-state mb-4">
            <div class="card-body text-center py-5">
                <span class="erp-empty-state-icon"><i class="fa-solid fa-diagram-project"></i></span>
                <h5 class="mt-3 mb-2">No projects to show yet</h5>
                <p class="text-muted mb-0">Create a project first, then you can track progress, costs, milestones, and documents here.</p>
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Upload Project / Worker Document</h5></div>
        <div class="card-body">
            <p class="small text-muted mb-3">Store project and worker documents securely. Supported: PDF, images, Word, and Excel files up to 10 MB.</p>
            <form wire:submit="saveDocument">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Attach to</label>
                        <select class="form-select" wire:model.live="documentableType"><option value="project">Project</option><option value="worker">Worker</option></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ $documentableType === 'project' ? 'Project' : 'Worker' }}</label>
                        <select class="form-select" wire:model="documentableId">
                            @if ($documentableType === 'project')
                                @foreach ($projects as $project)<option value="{{ $project->id }}">{{ $project->name }}</option>@endforeach
                            @else
                                @foreach ($workers as $worker)<option value="{{ $worker->id }}">{{ $worker->name }}</option>@endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Document type</label>
                        <select class="form-select" wire:model="documentCategory">
                            @foreach (['contract', 'drawing', 'permit', 'invoice', 'identity', 'medical', 'certificate', 'other'] as $category)
                                <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4"><label class="form-label" for="workspace-upload">Choose file</label><input id="workspace-upload" type="file" class="form-control @error('upload') is-invalid @enderror" wire:model="upload" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx" aria-describedby="workspace-upload-help"><div id="workspace-upload-help" class="form-text">Max 10 MB</div>@error('upload')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-3"><label class="form-label">Expiry / renewal date</label><input type="date" class="form-control" wire:model="documentExpiry"></div>
                    <div class="col-md-7"><label class="form-label">Notes</label><input class="form-control" wire:model="documentNotes"></div>
                    <div class="col-md-2 d-flex align-items-end"><button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled" wire:target="upload,saveDocument">
                        <span wire:loading.remove wire:target="saveDocument"><i class="fa-solid fa-cloud-arrow-up me-1"></i>Upload document</span>
                        <span wire:loading wire:target="upload,saveDocument"><span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Uploading...</span>
                    </button></div>
                </div>
                <div wire:loading wire:target="upload" class="small text-muted mt-2">Uploading file...</div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Document</th><th>Category</th><th>Expiry</th><th>Uploaded by</th><th>Uploaded</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($documents as $document)
                        <tr wire:key="document-{{ $document->id }}">
                            <td>{{ $document->original_name }}<div class="small text-muted">{{ $document->notes }}</div></td>
                            <td>{{ ucfirst($document->category) }}</td><td>{{ $document->expires_at?->format('d M Y') ?? '—' }}</td>
                            <td>{{ $document->uploader->name }}</td><td>{{ $document->created_at->format('d M Y') }}</td>
                            <td><button class="btn btn-sm btn-outline-primary" wire:click="downloadDocument({{ $document->id }})">Download</button> <button class="btn btn-sm btn-outline-danger" wire:click="deleteDocument({{ $document->id }})" wire:confirm="Delete this document permanently?">Delete</button></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No documents uploaded for the selected record.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
