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
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?><div class="alert alert-danger"><?php echo e($errors->first()); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (! ($isAdmin)): ?>
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
                            <select class="form-select" wire:model="projectId"><option value="">Company / general</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?><option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requestType === 'expense'): ?>
                            <div class="col-md-3">
                                <label class="form-label">Expense category</label>
                                <select class="form-select" wire:model="categoryId" required><option value="">Select category</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $expenseCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?><option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select>
                            </div>
                            <div class="col-md-3"><label class="form-label">Amount</label><input type="number" min="0.01" step="0.01" class="form-control" wire:model="amount" required></div>
                        <?php elseif($requestType === 'payroll'): ?>
                            <div class="col-md-6">
                                <label class="form-label">Draft payroll batch</label>
                                <select class="form-select" wire:model="payrollBatchId" required><option value="">Select draft batch</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $draftPayrollBatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?><option value="<?php echo e($batch->id); ?>"><?php echo e($batch->month_name); ?> <?php echo e($batch->year); ?> — <?php echo e($batch->payrolls_count); ?> worker(s)</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requestType !== 'payroll'): ?>
                            <div class="col-md-<?php echo e($requestType === 'expense' ? '3' : '4'); ?>"><label class="form-label">Request title</label><input class="form-control" wire:model="title" required maxlength="255"></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requestType !== 'expense'): ?>
                                <div class="col-md-2"><label class="form-label">Amount (optional)</label><input type="number" min="0" step="0.01" class="form-control" wire:model="amount"></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isAdmin): ?>
        <div class="alert alert-info d-flex gap-2 align-items-start">
            <i class="fa-solid fa-circle-info mt-1"></i>
            <div><strong>Reviewing a request?</strong> Add a decision note below before rejecting. A note is required for every rejection.</div>
        </div>
        <div class="card mb-4">
            <div class="card-body py-3">
                <label class="form-label mb-1" for="approval-decision-note">Decision note</label>
                <input id="approval-decision-note" class="form-control <?php $__errorArgs = ['decisionNote'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="decisionNote" maxlength="2000" placeholder="Reason for rejection or context for the decision">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['decisionNote'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-1"><?php echo e($isAdmin ? 'Approval Queue & History' : 'My Requests & Decision History'); ?></h5>
            <p class="small text-muted mb-0"><?php echo e($isAdmin ? 'Pending requests appear first. Review each request and record your decision.' : 'Track the status and review history of requests you have submitted.'); ?></p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Request</th><th>Type / Project</th><th>Requested by</th><th>Amount</th><th>Status</th><th>Decision</th></tr></thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('approval-{{ $request->id }}', get_defined_vars()); ?>wire:key="approval-<?php echo e($request->id); ?>">
                            <td><strong><?php echo e($request->title); ?></strong><div class="small text-muted"><?php echo e($request->details); ?></div></td>
                            <td><?php echo e(ucfirst($request->request_type)); ?><div class="small text-muted"><?php echo e($request->project?->name ?? 'Company / general'); ?></div></td>
                            <td><?php echo e($request->requester->name); ?><div class="small text-muted"><?php echo e($request->created_at->format('d M Y H:i')); ?></div></td>
                            <td><?php echo e($request->amount !== null ? number_format((float) $request->amount, 2) : '—'); ?></td>
                            <td><span class="badge <?php echo e($request->status === 'approved' ? 'bg-label-success' : ($request->status === 'rejected' ? 'bg-label-danger' : 'bg-label-warning')); ?>"><?php echo e(ucfirst($request->status)); ?></span></td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isAdmin && $request->status === 'pending'): ?>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-success" wire:click="decide(<?php echo e($request->id); ?>, 'approved')" wire:loading.attr="disabled" wire:target="decide"><i class="fa-solid fa-check me-1"></i>Approve</button>
                                        <button class="btn btn-sm btn-outline-danger" wire:click="decide(<?php echo e($request->id); ?>, 'rejected')" wire:confirm="Reject this request using the decision note above?" wire:loading.attr="disabled" wire:target="decide"><i class="fa-solid fa-xmark me-1"></i>Reject</button>
                                    </div>
                                <?php else: ?>
                                    <?php echo e($request->reviewer?->name ?? 'Awaiting review'); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($request->reviewed_at): ?><div class="small text-muted"><?php echo e($request->reviewed_at->format('d M Y H:i')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($request->actions->isNotEmpty()): ?>
                            <tr class="table-light"><td colspan="6">
                                <details><summary>Approval history (<?php echo e($request->actions->count()); ?> action(s))</summary>
                                    <ul class="mb-0 mt-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $request->actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <li><?php echo e(ucfirst($action->action)); ?> — <?php echo e($action->user->name); ?> — <?php echo e($action->created_at->format('d M Y H:i')); ?><?php echo e($action->notes ? ': ' . $action->notes : ''); ?></li>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </ul>
                                </details>
                            </td></tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No approval requests found.</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/livewire/shared/approval-center.blade.php ENDPATH**/ ?>