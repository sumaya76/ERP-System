<div class="erp-module-page">
    <div class="card erp-page-heading shadow-sm border-0 mb-4">
        <div class="card-header border-0 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <span class="erp-page-heading-icon"><i class="fa-solid fa-bell"></i></span>
                <div>
                    <h3 class="mb-1">Notifications & Reminders</h3>
                    <p class="mb-0">Project deadlines, medical renewals, approvals, low stock and unpaid invoices.</p>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-outline-light" wire:click="markAllRead" <?php if($unreadCount === 0): echo 'disabled'; endif; ?> wire:loading.attr="disabled" wire:target="markAllRead">
                    <i class="fa-solid fa-check-double me-1"></i>Mark all read
                </button>
                <button class="btn btn-light" wire:click="generateReminders" wire:loading.attr="disabled" wire:target="generateReminders">
                    <span wire:loading.remove wire:target="generateReminders"><i class="fa-solid fa-arrows-rotate me-1"></i>Check for reminders</span>
                    <span wire:loading wire:target="generateReminders"><span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Checking...</span>
                </button>
            </div>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><h5 class="mb-1">Your alerts</h5><p class="small text-muted mb-0">Review important updates and follow the action link when one is available.</p></div>
            <span class="badge <?php echo e($unreadCount ? 'bg-label-primary' : 'bg-label-secondary'); ?>"><?php echo e($unreadCount); ?> unread total</span>
        </div>
        <div class="list-group list-group-flush">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="list-group-item erp-notification-item <?php echo e($notification->read_at ? '' : 'erp-notification-unread'); ?>" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('notification-{{ $notification->id }}', get_defined_vars()); ?>wire:key="notification-<?php echo e($notification->id); ?>">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap align-items-center gap-2"><span class="badge bg-label-secondary"><?php echo e(str_replace('_', ' ', ucfirst($notification->category))); ?></span><strong><?php echo e($notification->title); ?></strong><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (! ($notification->read_at)): ?><span class="badge bg-primary">New</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                            <p class="mb-1 mt-2"><?php echo e($notification->message); ?></p><small class="text-muted"><?php echo e($notification->created_at->format('d M Y H:i')); ?></small>
                        </div>
                        <div class="d-flex gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->action_url): ?><a class="btn btn-sm btn-outline-primary" href="<?php echo e($notification->action_url); ?>">Open</a><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (! ($notification->read_at)): ?><button class="btn btn-sm btn-outline-secondary text-nowrap" wire:click="markRead(<?php echo e($notification->id); ?>)" wire:loading.attr="disabled" wire:target="markRead"><i class="fa-solid fa-check me-1"></i>Mark read</button><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="erp-empty-state text-center py-5">
                    <span class="erp-empty-state-icon"><i class="fa-solid fa-bell-slash"></i></span>
                    <h6 class="mt-3 mb-1">You’re all caught up</h6>
                    <p class="text-muted mb-0">There are no active alerts right now. New reminders will appear here.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notifications->hasPages()): ?><div class="card-footer"><?php echo e($notifications->links()); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/livewire/shared/notifications.blade.php ENDPATH**/ ?>