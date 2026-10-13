<div class="erp-module-page">
    <div class="card erp-page-heading shadow-sm border-0 mb-4">
        <div class="card-header border-0">
            <div class="d-flex align-items-center gap-3">
                <span class="erp-page-heading-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
                <div>
                    <h3 class="mb-1">Inventory & Purchase Requests</h3>
                    <p class="mb-0">Check stock, issue or return materials, and request purchasing approval.</p>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    @php
        $lowStockCount = $stockMaterials->filter(fn ($material) => (float) $material->stock_on_hand <= (float) $material->reorder_level)->count();
    @endphp
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-6">
            <div class="card erp-summary-card h-100"><div class="card-body d-flex align-items-center gap-3">
                <span class="erp-summary-icon"><i class="fa-solid fa-cubes-stacked"></i></span>
                <div><div class="small text-muted">Materials tracked</div><div class="h4 mb-0">{{ $stockMaterials->count() }}</div></div>
            </div></div>
        </div>
        <div class="col-sm-6 col-xl-6">
            <div class="card erp-summary-card h-100"><div class="card-body d-flex align-items-center gap-3">
                <span class="erp-summary-icon {{ $lowStockCount ? 'erp-summary-icon-warning' : '' }}"><i class="fa-solid fa-triangle-exclamation"></i></span>
                <div><div class="small text-muted">Materials to reorder</div><div class="h4 mb-0">{{ $lowStockCount }}</div></div>
            </div></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div><h5 class="mb-1">Current Material Stock</h5><p class="small text-muted mb-0">Quantities at or below the reorder point are flagged for attention.</p></div>
            <span class="badge {{ $lowStockCount ? 'bg-label-warning' : 'bg-label-success' }}">{{ $lowStockCount ? $lowStockCount.' need attention' : 'Stock levels healthy' }}</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>SKU</th><th>Material</th><th>Category</th><th>On hand</th><th>Reorder at</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse ($stockMaterials as $material)
                        <tr>
                            <td>{{ $material->sku }}</td>
                            <td>{{ $material->name }}</td>
                            <td>{{ $material->category ?: '—' }}</td>
                            <td>{{ number_format((float) $material->stock_on_hand, 2) }} {{ $material->unit }}</td>
                            <td>{{ number_format((float) $material->reorder_level, 2) }} {{ $material->unit }}</td>
                            <td>
                                @if ((float) $material->stock_on_hand <= (float) $material->reorder_level)
                                    <span class="badge bg-label-warning">Low stock</span>
                                @else
                                    <span class="badge bg-label-success">In stock</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted"><i class="fa-solid fa-box-open d-block fs-3 mb-2"></i>No materials have been added yet. Add materials through Procurement to start tracking stock.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header"><h5 class="mb-0">Create Purchase Request</h5></div>
                <div class="card-body">
                    <form wire:submit="submitRequest">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="purchase-project">Project <span class="text-muted fw-normal">(optional)</span></label>
                                <select id="purchase-project" class="form-select" wire:model="requestProjectId">
                                    <option value="">Company / general request</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="purchase-required-by">Required by <span class="text-muted fw-normal">(optional)</span></label>
                                <input id="purchase-required-by" type="date" class="form-control" wire:model="requiredBy">
                                @error('requiredBy')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        @foreach ($requestItems as $index => $item)
                            <div class="row g-2 align-items-end mb-3" wire:key="request-item-{{ $index }}">
                                <div class="col-md-5">
                                    <label class="form-label" for="request-material-{{ $index }}">Material</label>
                                    <select id="request-material-{{ $index }}" class="form-select @error('requestItems.'.$index.'.material_id') is-invalid @enderror" wire:model="requestItems.{{ $index }}.material_id">
                                        <option value="">Select material</option>
                                        @foreach ($materials as $material)
                                            <option value="{{ $material->id }}">{{ $material->sku }} — {{ $material->name }} ({{ $material->unit }})</option>
                                        @endforeach
                                    </select>
                                    @error('requestItems.'.$index.'.material_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="request-quantity-{{ $index }}">Quantity</label>
                                    <input id="request-quantity-{{ $index }}" type="number" min="0.01" step="0.01" class="form-control @error('requestItems.'.$index.'.quantity') is-invalid @enderror" wire:model="requestItems.{{ $index }}.quantity">
                                    @error('requestItems.'.$index.'.quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Item note</label>
                                    <input type="text" maxlength="255" class="form-control" wire:model="requestItems.{{ $index }}.notes">
                                </div>
                                <div class="col-md-1">
                                    @if (count($requestItems) > 1)
                                        <button type="button" class="btn btn-outline-danger" wire:click="removeRequestItem({{ $index }})" aria-label="Remove material {{ $index + 1 }}"><i class="fa-solid fa-trash-can"></i></button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-outline-primary btn-sm mb-3" wire:click="addRequestItem"><i class="fa-solid fa-plus me-1"></i>Add another material</button>
                        <div class="mb-3">
                            <label class="form-label">Request notes</label>
                            <textarea class="form-control" rows="2" wire:model="requestNotes"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="submitRequest">
                            <span wire:loading.remove wire:target="submitRequest"><i class="fa-solid fa-paper-plane me-1"></i>Submit for approval</span>
                            <span wire:loading wire:target="submitRequest"><span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Submitting...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header"><h5 class="mb-0">Issue / Return Materials</h5></div>
                <div class="card-body">
                    <p class="small text-muted mb-3">Record material issued to a project or returned from site. Stock availability is checked before saving.</p>
                    <form wire:submit="recordStockMovement">
                        <div class="mb-3">
                            <label class="form-label">Movement</label>
                            <select class="form-select" wire:model.live="stockMovement.type">
                                <option value="issue">Issue to project</option>
                                <option value="return">Return from project</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Material</label>
                            <select class="form-select" wire:model="stockMovement.material_id">
                                <option value="">Select material</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name }} ({{ $material->unit }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Project</label>
                            <select class="form-select" wire:model="stockMovement.project_id">
                                <option value="">Select project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Worker (optional)</label>
                            <select class="form-select" wire:model="stockMovement.worker_id">
                                <option value="">Project-level</option>
                                @foreach ($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="movement-quantity">Quantity</label>
                            <input id="movement-quantity" type="number" min="0.01" step="0.01" class="form-control @error('stockMovement.quantity') is-invalid @enderror" wire:model="stockMovement.quantity">
                            @error('stockMovement.quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" rows="2" wire:model="stockMovement.notes"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="recordStockMovement">
                            <span wire:loading.remove wire:target="recordStockMovement">Record movement</span>
                            <span wire:loading wire:target="recordStockMovement"><span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Saving...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($orders->isNotEmpty())
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Receive Purchase Order Deliveries</h5></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Order</th><th>Supplier</th><th>Material</th><th>Ordered</th><th>Received</th><th>Receive now</th><th></th></tr></thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @foreach ($order->items as $orderItem)
                                @if ((float) $orderItem->received_quantity < (float) $orderItem->quantity)
                                    <tr wire:key="hr-order-item-{{ $orderItem->id }}">
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->supplier->name }}</td>
                                        <td>{{ $orderItem->material->name }}</td>
                                        <td>{{ number_format((float) $orderItem->quantity, 2) }}</td>
                                        <td>{{ number_format((float) $orderItem->received_quantity, 2) }}</td>
                                        <td><input type="number" min="0.01" max="{{ (float) $orderItem->quantity - (float) $orderItem->received_quantity }}" step="0.01" class="form-control form-control-sm" wire:model="receivingQuantities.{{ $orderItem->id }}"></td>
                                        <td><button class="btn btn-sm btn-primary" wire:click="receiveOrderItem({{ $orderItem->id }})">Receive</button></td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header"><h5 class="mb-0">My Recent Purchase Requests</h5></div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Request</th><th>Project</th><th>Materials</th><th>Required by</th><th>Status</th><th>Admin note</th></tr></thead>
                <tbody>
                    @forelse ($requests as $request)
                        <tr>
                            <td>{{ $request->request_number }}</td>
                            <td>{{ $request->project?->name ?? 'Company' }}</td>
                            <td>{{ $request->items->map(fn ($item) => $item->material->name . ' × ' . number_format((float) $item->quantity, 2))->implode(', ') }}</td>
                            <td>{{ $request->required_by?->format('d M Y') ?? '—' }}</td>
                            <td>
                                @php
                                    $requestStatusClass = match ($request->status) {
                                        'completed' => 'bg-label-success',
                                        'rejected' => 'bg-label-danger',
                                        'approved', 'ordered', 'partially_received' => 'bg-label-primary',
                                        default => 'bg-label-warning',
                                    };
                                @endphp
                                <span class="badge {{ $requestStatusClass }}">{{ str_replace('_', ' ', ucfirst($request->status)) }}</span>
                            </td>
                            <td>{{ $request->review_notes ?: '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No purchase requests submitted yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
