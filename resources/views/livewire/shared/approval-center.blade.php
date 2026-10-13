<div class="erp-module-page">
    <div class="card erp-page-heading shadow-sm border-0 mb-4">
        <div class="card-header border-0">
            <div class="d-flex align-items-center gap-3">
                <span class="erp-page-heading-icon"><i class="fa-solid fa-clipboard-check"></i></span>
                <div>
                    <h3 class="mb-1">Approval Workflow</h3>
                    <p class="mb-0">Submit and review expenses, purchases, payroll and quotation requests with a permanent decision history.</p>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

    @unless ($isAdmin)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-1">Submit Approval Request</h5>
                <p class="small text-muted mb-0">Choose a request type. Required fields change to match your selection.</p>
            </div>
            <div class="card-body">
                <form wire:submit="submitRequest">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Request type</label>
                            <select id="approval-request-type" class="form-select" wire:model.live="requestType">
                                <option value="expense">Expense</option><option value="payroll">Payroll</option><option value="quotation">Quotation</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Project (optional)</label>
                            <select class="form-select" wire:model="projectId"><option value="">Company / general</option>@foreach ($projects as $project)<option value="{{ $project->id }}">{{ $project->name }}</option>@endforeach</select>
                        </div>
                        @if ($requestType === 'expense')
                            <div class="col-md-3">
                                <label class="form-label">Expense category</label>
                                <select class="form-select" wire:model="categoryId" required><option value="">Select category</option>@foreach ($expenseCategories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select>
                            </div>
                            <div class="col-md-3"><label class="form-label">Amount</label><input type="number" min="0.01" step="0.01" class="form-control" wire:model="amount" required></div>
                        @elseif ($requestType === 'payroll')
                            <div class="col-md-6">
                                <label class="form-label">Draft payroll batch</label>
                                <select class="form-select" wire:model="payrollBatchId" required><option value="">Select draft batch</option>@foreach ($draftPayrollBatches as $batch)<option value="{{ $batch->id }}">{{ $batch->month_name }} {{ $batch->year }} — {{ $batch->payrolls_count }} worker(s)</option>@endforeach</select>
                            </div>
                        @endif
                        @if ($requestType !== 'payroll')
                            <div class="col-md-{{ $requestType === 'expense' ? '3' : '4' }}"><label class="form-label">Request title</label><input class="form-control" wire:model="title" required maxlength="255"></div>
                            @if ($requestType !== 'expense')
                                <div class="col-md-2"><label class="form-label">Amount (optional)</label><input type="number" min="0" step="0.01" class="form-control" wire:model="amount"></div>
                            @endif
                        @endif
                        <div class="col-12"><label class="form-label">Details / supporting reference</label><textarea class="form-control" rows="3" wire:model="details"></textarea></div>
                        <div class="col-12"><button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="submitRequest">
                            <span wire:loading.remove wire:target="submitRequest"><i class="fa-solid fa-paper-plane me-1"></i>Submit to Admin</span>
                            <span wire:loading wire:target="submitRequest"><span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Submitting...</span>
                        </button></div>
                    </div>
                </form>
                <div class="small text-muted mt-3">Purchase requests created from Inventory are automatically routed to this approval queue.</div>
            </div>
        </div>
    @endunless

    @if ($isAdmin)
        <div class="alert alert-info d-flex gap-2 align-items-start">
            <i class="fa-solid fa-circle-info mt-1"></i>
            <div><strong>Reviewing a request?</strong> Add a decision note below before rejecting. A note is required for every rejection.</div>
        </div>
        <div class="card mb-4">
            <div class="card-body py-3">
                <label class="form-label mb-1" for="approval-decision-note">Decision note</label>
                <input id="approval-decision-note" class="form-control @error('decisionNote') is-invalid @enderror" wire:model="decisionNote" maxlength="2000" placeholder="Reason for rejection or context for the decision">
                @error('decisionNote')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-1">{{ $isAdmin ? 'Approval Queue & History' : 'My Requests & Decision History' }}</h5>
            <p class="small text-muted mb-0">{{ $isAdmin ? 'Pending requests appear first. Review each request and record your decision.' : 'Track the status and review history of requests you have submitted.' }}</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Request</th><th>Type / Project</th><th>Requested by</th><th>Amount</th><th>Status</th><th>Decision</th></tr></thead>
                <tbody>
                    @forelse ($requests as $request)
                        <tr wire:key="approval-{{ $request->id }}">
                            <td><strong>{{ $request->title }}</strong><div class="small text-muted">{{ $request->details }}</div></td>
                            <td>{{ ucfirst($request->request_type) }}<div class="small text-muted">{{ $request->project?->name ?? 'Company / general' }}</div></td>
                            <td>{{ $request->requester->name }}<div class="small text-muted">{{ $request->created_at->format('d M Y H:i') }}</div></td>
                            <td>{{ $request->amount !== null ? number_format((float) $request->amount, 2) : '—' }}</td>
                            <td><span class="badge {{ $request->status === 'approved' ? 'bg-label-success' : ($request->status === 'rejected' ? 'bg-label-danger' : 'bg-label-warning') }}">{{ ucfirst($request->status) }}</span></td>
                            <td>
                                @if ($isAdmin && $request->status === 'pending')
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-success" wire:click="decide({{ $request->id }}, 'approved')" wire:loading.attr="disabled" wire:target="decide"><i class="fa-solid fa-check me-1"></i>Approve</button>
                                        <button class="btn btn-sm btn-outline-danger" wire:click="decide({{ $request->id }}, 'rejected')" wire:confirm="Reject this request using the decision note above?" wire:loading.attr="disabled" wire:target="decide"><i class="fa-solid fa-xmark me-1"></i>Reject</button>
                                    </div>
                                @else
                                    {{ $request->reviewer?->name ?? 'Awaiting review' }}
                                    @if ($request->reviewed_at)<div class="small text-muted">{{ $request->reviewed_at->format('d M Y H:i') }}</div>@endif
                                @endif
                            </td>
                        </tr>
                        @if ($request->actions->isNotEmpty())
                            <tr class="table-light"><td colspan="6">
                                <details><summary>Approval history ({{ $request->actions->count() }} action(s))</summary>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($request->actions as $action)
                                            <li>{{ ucfirst($action->action) }} — {{ $action->user->name }} — {{ $action->created_at->format('d M Y H:i') }}{{ $action->notes ? ': ' . $action->notes : '' }}</li>
                                        @endforeach
                                    </ul>
                                </details>
                            </td></tr>
                        @endif
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No approval requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
