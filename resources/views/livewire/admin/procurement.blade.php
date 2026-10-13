<div class="erp-module-page">
    <div class="card erp-page-heading shadow-sm border-0 mb-4">
        <div class="card-header border-0">
            <div class="d-flex align-items-center gap-3">
                <span class="erp-page-heading-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
                <div>
                    <h3 class="mb-1">Procurement & Inventory</h3>
                    <p class="mb-0">Manage suppliers and materials, review requests, compare quotations, and receive orders.</p>
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

    <div class="row g-4 mb-4">
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header"><h5 class="mb-0">Add Supplier</h5></div>
                <div class="card-body">
                    <form wire:submit="saveSupplier">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Supplier name</label><input class="form-control" wire:model="supplierForm.name" required></div>
                            <div class="col-md-6"><label class="form-label">Contact person</label><input class="form-control" wire:model="supplierForm.contact_person"></div>
                            <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" wire:model="supplierForm.email"></div>
                            <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" wire:model="supplierForm.phone"></div>
                            <div class="col-md-6"><label class="form-label">Tax / registration no.</label><input class="form-control" wire:model="supplierForm.tax_number"></div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Save supplier</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header"><h5 class="mb-0">Add Material</h5></div>
                <div class="card-body">
                    <form wire:submit="saveMaterial">
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">SKU</label><input class="form-control" wire:model="materialForm.sku" required></div>
                            <div class="col-md-8"><label class="form-label">Material name</label><input class="form-control" wire:model="materialForm.name" required></div>
                            <div class="col-md-4"><label class="form-label">Category</label><input class="form-control" wire:model="materialForm.category"></div>
                            <div class="col-md-4"><label class="form-label">Unit</label><input class="form-control" wire:model="materialForm.unit" placeholder="bag, kg, piece"></div>
                            <div class="col-md-4"><label class="form-label">Reorder level</label><input type="number" min="0" step="0.01" class="form-control" wire:model="materialForm.reorder_level"></div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Save material</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Inventory Balances & Low-stock Alerts</h5></div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>SKU</th><th>Material</th><th>Category</th><th>On hand</th><th>Reorder at</th><th>Level</th></tr></thead>
                <tbody>
                    @forelse ($materials as $material)
                        <tr>
                            <td>{{ $material->sku }}</td><td>{{ $material->name }}</td><td>{{ $material->category ?: '—' }}</td>
                            <td>{{ number_format((float) $material->stock_on_hand, 2) }} {{ $material->unit }}</td>
                            <td>{{ number_format((float) $material->reorder_level, 2) }} {{ $material->unit }}</td>
                            <td>@if ((float) $material->stock_on_hand <= (float) $material->reorder_level)<span class="badge bg-label-warning">Low stock</span>@else<span class="badge bg-label-success">In stock</span>@endif</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No materials in the catalog yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Purchase Requests</h5></div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Request</th><th>Requested by</th><th>Project</th><th>Items</th><th>Required by</th><th>Status / Action</th></tr></thead>
                <tbody>
                    @forelse ($requests as $request)
                        <tr wire:key="request-{{ $request->id }}">
                            <td><strong>{{ $request->request_number }}</strong><div class="small text-muted">{{ $request->notes }}</div></td>
                            <td>{{ $request->requester->name }}</td>
                            <td>{{ $request->project?->name ?? 'Company' }}</td>
                            <td>{{ $request->items->map(fn ($item) => $item->material->name . ' × ' . number_format((float) $item->quantity, 2))->implode(', ') }}</td>
                            <td>{{ $request->required_by?->format('d M Y') ?? '—' }}</td>
                            <td>
                                @if ($request->status === 'pending')
                                    <button class="btn btn-sm btn-success" wire:click="approveRequest({{ $request->id }})">Approve</button>
                                    <button class="btn btn-sm btn-outline-danger" wire:click="rejectRequest({{ $request->id }})" wire:confirm="Reject this purchase request? Add a reason in the Review note field below.">Reject</button>
                                @else
                                    <span class="badge bg-label-success">Approved</span>
                                    <button class="btn btn-sm btn-outline-primary ms-1" wire:click="prepareQuotation({{ $request->id }})">Add supplier quote</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No pending or approved requests.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body border-top">
            <label class="form-label">Review note (required when rejecting)</label>
            <input class="form-control" wire:model="reviewNote" maxlength="2000" placeholder="Reason or note for the requester">
        </div>
    </div>

    @if ($quoteRequestId)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Enter Supplier Quotation — Request #{{ $quoteRequestId }}</h5>
                <button type="button" class="btn-close" wire:click="$set('quoteRequestId', null)" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <form wire:submit="saveQuotation">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Supplier</label>
                            <select class="form-select" wire:model="quoteSupplierId" required>
                                <option value="">Select supplier</option>
                                @foreach ($suppliers as $supplier)<option value="{{ $supplier->id }}">{{ $supplier->name }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Supplier quote no.</label><input class="form-control" wire:model="quoteNumber" required></div>
                        <div class="col-md-4"><label class="form-label">Valid until</label><input type="date" class="form-control" wire:model="quoteValidUntil"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead><tr><th>Requested material</th><th>Requested qty</th><th>Quoted qty</th><th>Unit price</th><th>Lead time (days)</th></tr></thead>
                            <tbody>
                                @foreach ($quoteItems as $index => $item)
                                    @php $requestLine = $requests->firstWhere('id', $quoteRequestId)?->items->firstWhere('id', $item['request_item_id']); @endphp
                                    <tr wire:key="quote-line-{{ $item['request_item_id'] }}">
                                        <td>{{ $requestLine?->material?->name }}</td>
                                        <td>{{ number_format((float) ($requestLine?->quantity ?? 0), 2) }}</td>
                                        <td><input type="number" min="0.01" step="0.01" class="form-control" wire:model="quoteItems.{{ $index }}.quantity"></td>
                                        <td><input type="number" min="0" step="0.01" class="form-control" wire:model="quoteItems.{{ $index }}.unit_price"></td>
                                        <td><input type="number" min="0" step="1" class="form-control" wire:model="quoteItems.{{ $index }}.lead_time_days"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary">Save quotation</button>
                </form>
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Quotation Comparison</h5></div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Request</th><th>Supplier</th><th>Quote no.</th><th>Total</th><th>Delivery lead time</th><th></th></tr></thead>
                <tbody>
                    @foreach ($requests->where('status', 'approved') as $request)
                        @foreach ($request->quotations as $quotation)
                            <tr wire:key="quotation-{{ $quotation->id }}">
                                <td>{{ $request->request_number }}</td>
                                <td>{{ $quotation->supplier->name }}</td>
                                <td>{{ $quotation->quotation_number }}</td>
                                <td>{{ number_format($quotation->items->sum(fn ($item) => (float) $request->items->firstWhere('id', $item->purchase_request_item_id)->quantity * (float) $item->unit_price), 2) }}</td>
                                <td>{{ $quotation->items->max('lead_time_days') }} days</td>
                                <td><button class="btn btn-sm btn-primary" wire:click="createPurchaseOrder({{ $quotation->id }})" wire:confirm="Create a purchase order using this supplier quotation?">Select & create PO</button></td>
                            </tr>
                        @endforeach
                    @endforeach
                    @if ($requests->where('status', 'approved')->every(fn ($request) => $request->quotations->isEmpty()))
                        <tr><td colspan="6" class="text-center py-4 text-muted">Approved requests need supplier quotations before comparison.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h5 class="mb-0">Purchase Orders & Delivery Tracking</h5></div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>PO</th><th>Supplier</th><th>Project</th><th>Material</th><th>Ordered</th><th>Received</th><th>Status</th><th>Receive now</th></tr></thead>
                <tbody>
                    @forelse ($orders as $order)
                        @foreach ($order->items as $item)
                            <tr wire:key="po-item-{{ $item->id }}">
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->supplier->name }}</td>
                                <td>{{ $order->purchaseRequest->project?->name ?? 'Company' }}</td>
                                <td>{{ $item->material->name }}</td>
                                <td>{{ number_format((float) $item->quantity, 2) }}</td>
                                <td>{{ number_format((float) $item->received_quantity, 2) }}</td>
                                <td><span class="badge bg-label-secondary">{{ str_replace('_', ' ', ucfirst($order->status)) }}</span></td>
                                <td>
                                    @if ((float) $item->received_quantity < (float) $item->quantity)
                                        <div class="d-flex gap-2">
                                            <input type="number" min="0.01" max="{{ (float) $item->quantity - (float) $item->received_quantity }}" step="0.01" class="form-control form-control-sm" wire:model="receivingQuantities.{{ $item->id }}">
                                            <button class="btn btn-sm btn-primary" wire:click="receiveItem({{ $item->id }})">Receive</button>
                                        </div>
                                    @else
                                        <span class="text-muted">Complete</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">No purchase orders recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
