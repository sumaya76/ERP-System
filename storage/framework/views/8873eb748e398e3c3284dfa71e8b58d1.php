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

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <tr>
                            <td><?php echo e($material->sku); ?></td><td><?php echo e($material->name); ?></td><td><?php echo e($material->category ?: '—'); ?></td>
                            <td><?php echo e(number_format((float) $material->stock_on_hand, 2)); ?> <?php echo e($material->unit); ?></td>
                            <td><?php echo e(number_format((float) $material->reorder_level, 2)); ?> <?php echo e($material->unit); ?></td>
                            <td><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((float) $material->stock_on_hand <= (float) $material->reorder_level): ?><span class="badge bg-label-warning">Low stock</span><?php else: ?><span class="badge bg-label-success">In stock</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No materials in the catalog yet.</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('request-{{ $request->id }}', get_defined_vars()); ?>wire:key="request-<?php echo e($request->id); ?>">
                            <td><strong><?php echo e($request->request_number); ?></strong><div class="small text-muted"><?php echo e($request->notes); ?></div></td>
                            <td><?php echo e($request->requester->name); ?></td>
                            <td><?php echo e($request->project?->name ?? 'Company'); ?></td>
                            <td><?php echo e($request->items->map(fn ($item) => $item->material->name . ' × ' . number_format((float) $item->quantity, 2))->implode(', ')); ?></td>
                            <td><?php echo e($request->required_by?->format('d M Y') ?? '—'); ?></td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($request->status === 'pending'): ?>
                                    <button class="btn btn-sm btn-success" wire:click="approveRequest(<?php echo e($request->id); ?>)">Approve</button>
                                    <button class="btn btn-sm btn-outline-danger" wire:click="rejectRequest(<?php echo e($request->id); ?>)" wire:confirm="Reject this purchase request? Add a reason in the Review note field below.">Reject</button>
                                <?php else: ?>
                                    <span class="badge bg-label-success">Approved</span>
                                    <button class="btn btn-sm btn-outline-primary ms-1" wire:click="prepareQuotation(<?php echo e($request->id); ?>)">Add supplier quote</button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No pending or approved requests.</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-body border-top">
            <label class="form-label">Review note (required when rejecting)</label>
            <input class="form-control" wire:model="reviewNote" maxlength="2000" placeholder="Reason or note for the requester">
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quoteRequestId): ?>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Enter Supplier Quotation — Request #<?php echo e($quoteRequestId); ?></h5>
                <button type="button" class="btn-close" wire:click="$set('quoteRequestId', null)" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <form wire:submit="saveQuotation">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Supplier</label>
                            <select class="form-select" wire:model="quoteSupplierId" required>
                                <option value="">Select supplier</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?><option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->name); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label">Supplier quote no.</label><input class="form-control" wire:model="quoteNumber" required></div>
                        <div class="col-md-4"><label class="form-label">Valid until</label><input type="date" class="form-control" wire:model="quoteValidUntil"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead><tr><th>Requested material</th><th>Requested qty</th><th>Quoted qty</th><th>Unit price</th><th>Lead time (days)</th></tr></thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $quoteItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <?php $requestLine = $requests->firstWhere('id', $quoteRequestId)?->items->firstWhere('id', $item['request_item_id']); ?>
                                    <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('quote-line-{{ $item[\'request_item_id\'] }}', get_defined_vars()); ?>wire:key="quote-line-<?php echo e($item['request_item_id']); ?>">
                                        <td><?php echo e($requestLine?->material?->name); ?></td>
                                        <td><?php echo e(number_format((float) ($requestLine?->quantity ?? 0), 2)); ?></td>
                                        <td><input type="number" min="0.01" step="0.01" class="form-control" wire:model="quoteItems.<?php echo e($index); ?>.quantity"></td>
                                        <td><input type="number" min="0" step="0.01" class="form-control" wire:model="quoteItems.<?php echo e($index); ?>.unit_price"></td>
                                        <td><input type="number" min="0" step="1" class="form-control" wire:model="quoteItems.<?php echo e($index); ?>.lead_time_days"></td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary">Save quotation</button>
                </form>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Quotation Comparison</h5></div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Request</th><th>Supplier</th><th>Quote no.</th><th>Total</th><th>Delivery lead time</th><th></th></tr></thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $requests->where('status', 'approved'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $request->quotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('quotation-{{ $quotation->id }}', get_defined_vars()); ?>wire:key="quotation-<?php echo e($quotation->id); ?>">
                                <td><?php echo e($request->request_number); ?></td>
                                <td><?php echo e($quotation->supplier->name); ?></td>
                                <td><?php echo e($quotation->quotation_number); ?></td>
                                <td><?php echo e(number_format($quotation->items->sum(fn ($item) => (float) $request->items->firstWhere('id', $item->purchase_request_item_id)->quantity * (float) $item->unit_price), 2)); ?></td>
                                <td><?php echo e($quotation->items->max('lead_time_days')); ?> days</td>
                                <td><button class="btn btn-sm btn-primary" wire:click="createPurchaseOrder(<?php echo e($quotation->id); ?>)" wire:confirm="Create a purchase order using this supplier quotation?">Select & create PO</button></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requests->where('status', 'approved')->every(fn ($request) => $request->quotations->isEmpty())): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Approved requests need supplier quotations before comparison.</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('po-item-{{ $item->id }}', get_defined_vars()); ?>wire:key="po-item-<?php echo e($item->id); ?>">
                                <td><?php echo e($order->order_number); ?></td>
                                <td><?php echo e($order->supplier->name); ?></td>
                                <td><?php echo e($order->purchaseRequest->project?->name ?? 'Company'); ?></td>
                                <td><?php echo e($item->material->name); ?></td>
                                <td><?php echo e(number_format((float) $item->quantity, 2)); ?></td>
                                <td><?php echo e(number_format((float) $item->received_quantity, 2)); ?></td>
                                <td><span class="badge bg-label-secondary"><?php echo e(str_replace('_', ' ', ucfirst($order->status))); ?></span></td>
                                <td>
                                    <?php if((float) $item->received_quantity < (float) $item->quantity): ?>
                                        <div class="d-flex gap-2">
                                            <input type="number" min="0.01" max="<?php echo e((float) $item->quantity - (float) $item->received_quantity); ?>" step="0.01" class="form-control form-control-sm" wire:model="receivingQuantities.<?php echo e($item->id); ?>">
                                            <button class="btn btn-sm btn-primary" wire:click="receiveItem(<?php echo e($item->id); ?>)">Receive</button>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Complete</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">No purchase orders recorded yet.</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/livewire/admin/procurement.blade.php ENDPATH**/ ?>