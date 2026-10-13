<div>
    <div class="card shadow-sm border-0">
        <!-- Header -->
        <div class="card-header border-0 pt-4 pb-4"
            style="background: linear-gradient(135deg, #ff0000 0%, #000000 100%); border-radius: 1rem 1rem 0 0;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-hand-holding-usd text-white fs-4"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold text-white">Worker Advance Accounts</h3>
                        <p class="text-white-50 small mb-0">Track advances and deductions per worker</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('hr.advances.form')); ?>" class="btn btn-light">
                        <i class="fas fa-plus-circle me-2"></i>
                        Add New Advance
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body pt-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo e(session('message')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Search and Filters Section -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-search me-2" style="color: #ff0000;"></i>
                            Search & Filter Workers
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="resetFilters">
                            <i class="fas fa-undo-alt me-1"></i> Reset All Filters
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="performSearch">
                        <div class="row g-3 pt-3">
                            <!-- Search Input -->
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-search me-1" style="color: #ff0000;"></i>
                                    Search Workers
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control"
                                           placeholder="Search by name, email, phone, designation, department..."
                                           wire:model="tempSearch">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempSearch): ?>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="clearSearch">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Searches across all worker fields
                                </small>
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-chart-pie me-1" style="color: #ff0000;"></i>
                                    Filter by Status
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-filter"></i>
                                    </span>
                                    <select class="form-select" wire:model="tempStatusFilter">
                                        <option value="">All Workers</option>
                                        <option value="has_advances">Has Advances</option>
                                        <option value="has_balance">Has Outstanding Balance</option>
                                        <option value="cleared">Fully Cleared</option>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempStatusFilter): ?>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="clearStatusFilter">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <!-- Items Per Page -->
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-eye me-1" style="color: #ff0000;"></i>
                                    Items Per Page
                                </label>
                                <select class="form-select" wire:model.live="perPage">
                                    <option value="10">10 per page</option>
                                    <option value="25">25 per page</option>
                                    <option value="50">50 per page</option>
                                    <option value="100">100 per page</option>
                                </select>
                            </div>

                            <!-- Search Actions -->
                            <div class="col-md-2">
                                <label class="form-label fw-semibold invisible">Search</label>
                                <div class="d-flex gap-2 w-100">
                                    <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #ff0000 0%, #000000 100%); border: none;">
                                        <i class="fas fa-search me-2"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Active Filters Display -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $statusFilter): ?>
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <small class="text-muted me-2">
                                    <i class="fas fa-filter me-1"></i>Active filters:
                                </small>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-search me-1"></i>
                                        Search: <?php echo e($search); ?>

                                        <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="clearSearch"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($statusFilter): ?>
                                    <span class="badge bg-info">
                                        <i class="fas fa-chart-pie me-1"></i>
                                        Status:
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($statusFilter == 'has_advances'): ?> Has Advances
                                        <?php elseif($statusFilter == 'has_balance'): ?> Has Outstanding Balance
                                        <?php elseif($statusFilter == 'cleared'): ?> Fully Cleared
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="clearStatusFilter"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase">Total Workers</small>
                                    <h3 class="mb-0 fw-bold"><?php echo e($totalWorkers); ?></h3>
                                    <small class="text-muted">With advances: <?php echo e($workersWithAdvances); ?></small>
                                </div>
                                <div class="rounded-circle p-3" style="background: rgba(255, 0, 0, 0.1);">
                                    <i class="fas fa-users fa-2x" style="color: #ff0000;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase">Total Advances Given</small>
                                    <h3 class="mb-0 fw-bold text-primary">€ <?php echo e(number_format($totalGiven, 2)); ?></h3>
                                </div>
                                <div class="rounded-circle p-3" style="background: rgba(40, 167, 69, 0.1);">
                                    <i class="fas fa-arrow-up fa-2x" style="color: #28a745;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase">Total Deducted</small>
                                    <h3 class="mb-0 fw-bold text-success">€ <?php echo e(number_format($totalPaidOverall, 2)); ?></h3>
                                </div>
                                <div class="rounded-circle p-3" style="background: rgba(255, 193, 7, 0.1);">
                                    <i class="fas fa-arrow-down fa-2x" style="color: #ffc107;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase">Outstanding Balance</small>
                                    <h3 class="mb-0 fw-bold text-danger">€ <?php echo e(number_format($totalOutstanding, 2)); ?></h3>
                                </div>
                                <div class="rounded-circle p-3" style="background: rgba(23, 162, 184, 0.1);">
                                    <i class="fas fa-coins fa-2x" style="color: #17a2b8;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workers Advance Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-list me-2" style="color: #ff0000;"></i>
                        Worker Advance Accounts
                    </h6>
                    <div class="text-muted small">
                        <i class="fas fa-chart-line me-1"></i>
                        Showing <?php echo e($workers->firstItem() ?? 0); ?> to <?php echo e($workers->lastItem() ?? 0); ?>

                        of <?php echo e($workers->total()); ?> workers
                    </div>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-hover align-middle">
                        <thead class="bg-sec">
                            <tr>
                                <th class="py-3 cursor-pointer" wire:click="sortByColumn('name')">
                                    <i class="fas fa-user me-2"></i> Worker
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy == 'name'): ?>
                                        <i class="fas fa-arrow-<?php echo e($sortDirection == 'asc' ? 'up' : 'down'); ?> ms-1"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </th>
                                <th class="py-3 cursor-pointer" wire:click="sortByColumn('designation')">
                                    <i class="fas fa-briefcase me-2"></i> Designation
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy == 'designation'): ?>
                                        <i class="fas fa-arrow-<?php echo e($sortDirection == 'asc' ? 'up' : 'down'); ?> ms-1"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </th>
                                <th class="py-3 text-end cursor-pointer" wire:click="sortByColumn('total_taken')">
                                    <i class="fas fa-hand-holding-usd me-2"></i> Total Taken (€)
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy == 'total_taken'): ?>
                                        <i class="fas fa-arrow-<?php echo e($sortDirection == 'asc' ? 'up' : 'down'); ?> ms-1"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </th>
                                <th class="py-3 text-end cursor-pointer" wire:click="sortByColumn('total_paid')">
                                    <i class="fas fa-check-circle me-2"></i> Total Paid (€)
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy == 'total_paid'): ?>
                                        <i class="fas fa-arrow-<?php echo e($sortDirection == 'asc' ? 'up' : 'down'); ?> ms-1"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </th>
                                <th class="py-3 text-end cursor-pointer" wire:click="sortByColumn('current_balance')">
                                    <i class="fas fa-coins me-2"></i> Remaining (€)
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy == 'current_balance'): ?>
                                        <i class="fas fa-arrow-<?php echo e($sortDirection == 'asc' ? 'up' : 'down'); ?> ms-1"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </th>
                                <th class="py-3 text-center">
                                    <i class="fas fa-cog me-2"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $workerSummaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold"><?php echo e($summary->worker->name); ?></div>
                                        <small class="text-muted">
                                            <i class="fas fa-envelope me-1"></i><?php echo e($summary->worker->email ?? 'N/A'); ?>

                                        </small>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($summary->worker->phone): ?>
                                            <br><small class="text-muted">
                                                <i class="fas fa-phone me-1"></i><?php echo e($summary->worker->phone); ?>

                                            </small>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($summary->worker->designation ?? 'Not assigned'); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($summary->worker->department): ?>
                                            <br><small class="text-muted"><?php echo e($summary->worker->department); ?></small>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-semibold text-primary">
                                            € <?php echo e(number_format($summary->total_taken, 2)); ?>

                                        </span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($summary->last_advance_date): ?>
                                            <br><small class="text-muted">Last: <?php echo e(\Carbon\Carbon::parse($summary->last_advance_date)->format('M d, Y')); ?></small>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-semibold text-success">
                                            € <?php echo e(number_format($summary->total_paid, 2)); ?>

                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($summary->current_balance > 0): ?>
                                            <span class="fw-bold text-danger">
                                                € <?php echo e(number_format($summary->current_balance, 2)); ?>

                                            </span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($summary->total_taken > 0): ?>
                                                <div class="progress mt-1" style="height: 4px; width: 100px; margin-left: auto;">
                                                    <?php
                                                        $paidPercent = $summary->total_taken > 0 ? ($summary->total_paid / $summary->total_taken) * 100 : 0;
                                                    ?>
                                                    <div class="progress-bar bg-success" style="width: <?php echo e($paidPercent); ?>%"></div>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i> Cleared
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button wire:click="viewWorkerDetails(<?php echo e($summary->worker->id); ?>)"
                                                    class="btn btn-sm btn-info"
                                                    style="font-size: 12px; padding: 6px 12px;">
                                                <i class="fas fa-chart-line me-1"></i> View Account
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                            <p class="mb-0">No workers found</p>
                                            <small>Try adjusting your search or filters</small>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                     </table>
                </div>

                <!-- Pagination -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workers->total() > 0): ?>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="fas fa-info-circle me-1"></i>
                            Showing <?php echo e($workers->firstItem() ?? 0); ?> to <?php echo e($workers->lastItem() ?? 0); ?>

                            of <?php echo e($workers->total()); ?> workers
                        </div>
                        <div>
                            <?php echo e($workers->links()); ?>

                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Edit Advance Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showEditModal): ?>
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #ff0000 0%, #000000 100%);">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-edit me-2"></i>
                            Edit Advance Record
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeEditModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-light mb-3">
                            <i class="fas fa-user me-2"></i>
                            <strong>Worker:</strong> <?php echo e($editWorkerName); ?>

                        </div>

                        <form wire:submit.prevent="updateAdvance">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-euro-sign me-1 text-danger"></i>
                                    Advance Amount *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">€</span>
                                    <input type="number"
                                           step="0.01"
                                           class="form-control <?php $__errorArgs = ['editAmount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           wire:model="editAmount"
                                           required>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['editAmount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-day me-1 text-danger"></i>
                                    Advance Date *
                                </label>
                                <input type="date"
                                       class="form-control <?php $__errorArgs = ['editAdvanceDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       wire:model="editAdvanceDate"
                                       required>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['editAdvanceDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-chart-pie me-1 text-danger"></i>
                                    Status *
                                </label>
                                <select class="form-select <?php $__errorArgs = ['editStatus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="editStatus">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['editStatus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editStatus == 'pending'): ?>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-coins me-1 text-danger"></i>
                                    Remaining Amount
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">€</span>
                                    <input type="number"
                                           step="0.01"
                                           class="form-control <?php $__errorArgs = ['editRemainingAmount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           wire:model="editRemainingAmount"
                                           min="0"
                                           max="<?php echo e($editAmount); ?>">
                                </div>
                                <small class="text-muted">Amount still pending to be deducted</small>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['editRemainingAmount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-sticky-note me-1 text-danger"></i>
                                    Notes / Remarks
                                </label>
                                <textarea class="form-control"
                                          wire:model="editNotes"
                                          rows="3"
                                          placeholder="Enter reason for advance, e.g., Emergency, Festival, Medical, etc..."></textarea>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['editNotes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <small>Changing the amount will update the worker's running balance automatically.</small>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-light" wire:click="closeEditModal">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-danger" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class="fas fa-save me-2"></i> Update Advance
                                    </span>
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin me-2"></i> Updating...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Worker Details Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showWorkerDetails && $selectedWorkerId): ?>
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 70%, #ffffff 100%);">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-chart-line fa-2x text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title text-white fw-bold mb-0">Advance Account Details</h5>
                                <small class="text-white-50"><?php echo e($workerName); ?></small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-black" wire:click="closeWorkerDetails"></button>
                    </div>
                    <div class="modal-body p-4">
                        <!-- Worker Info Summary -->
                        <div class="alert alert-light border mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <i class="fas fa-user text-info me-2"></i>
                                    <strong><?php echo e($workerName); ?></strong>
                                </div>
                                <div class="col-md-3">
                                    <i class="fas fa-briefcase text-info me-2"></i>
                                    <?php echo e($workerDesignation); ?>

                                </div>
                                <div class="col-md-3">
                                    <i class="fas fa-envelope text-info me-2"></i>
                                    <?php echo e($workerEmail); ?>

                                </div>
                                <div class="col-md-2">
                                    <i class="fas fa-phone text-info me-2"></i>
                                    <?php echo e($workerPhone); ?>

                                </div>
                            </div>
                        </div>

                        <!-- Balance Summary Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="card border-0 bg-primary bg-opacity-10">
                                    <div class="card-body text-center">
                                        <small class="text-muted text-uppercase">Total Taken</small>
                                        <h4 class="mb-0 fw-bold text-info">€ <?php echo e(number_format($totalTaken, 2)); ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 bg-success bg-opacity-10">
                                    <div class="card-body text-center">
                                        <small class="text-muted text-uppercase">Total Deducted</small>
                                        <h4 class="mb-0 fw-bold text-success">€ <?php echo e(number_format($totalPaid, 2)); ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 bg-danger bg-opacity-10">
                                    <div class="card-body text-center">
                                        <small class="text-muted text-uppercase">Remaining Balance</small>
                                        <h4 class="mb-0 fw-bold text-danger">€ <?php echo e(number_format($remainingBalance, 2)); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 1: Advances Given -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold">
                                    <i class="fas fa-arrow-up text-success me-2"></i>
                                    Advances Given (<?php echo e($advancesGiven->count()); ?> records)
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="bg-sec">
                                            <tr>
                                                <th>Date</th>
                                                <th class="text-end">Amount (€)</th>
                                                <th>Reason / Notes</th>
                                                <th class="text-end">Balance After</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $advancesGiven; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <tr>
                                                    <td>
                                                        <?php echo e(\Carbon\Carbon::parse($advance->advance_date)->format('M d, Y')); ?>

                                                    </td>
                                                    <td class="text-end text-success fw-semibold">
                                                        + € <?php echo e(number_format($advance->amount, 2)); ?>

                                                    </td>
                                                    <td>
                                                        <small><?php echo e(Str::limit($advance->notes ?? '-', 50)); ?></small>
                                                    </td>
                                                    <td class="text-end">€ <?php echo e(number_format($advance->running_balance, 2)); ?></td>
                                                    <td class="text-center">
                                                        <button wire:click="editAdvance(<?php echo e($advance->id); ?>)"
                                                                class="btn btn-sm btn-warning"
                                                                style="font-size: 11px; padding: 3px 8px;">
                                                            <i class="fas fa-edit me-1"></i> Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-3 text-muted">
                                                        No advance records found
                                                    </td>
                                                </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr class="fw-bold">
                                                <td>TOTAL</td>
                                                <td class="text-end">€ <?php echo e(number_format($totalTaken, 2)); ?></td>
                                                <td></td>
                                                <td class="text-end">€ <?php echo e(number_format($remainingBalance, 2)); ?></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Deductions Made -->
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold">
                                    <i class="fas fa-arrow-down text-danger me-2"></i>
                                    Deductions Made (<?php echo e($deductionsMade->count()); ?> records)
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="bg-sec">
                                            <tr>
                                                <th>Date</th>
                                                <th class="text-end">Amount (€)</th>
                                                <th>Payroll Batch</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $deductionsMade; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <tr>
                                                    <td>
                                                        <?php echo e(\Carbon\Carbon::parse($deduction->advance_date)->format('M d, Y')); ?>

                                                    </td>
                                                    <td class="text-end text-danger fw-semibold">
                                                        - € <?php echo e(number_format($deduction->amount, 2)); ?>

                                                    </td>
                                                    <td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->deductedInPayroll): ?>
                                                            <span class="badge bg-secondary">
                                                                Batch #<?php echo e($deduction->deductedInPayroll->id); ?>

                                                            </span>
                                                            <br>
                                                            <small class="text-muted">
                                                                <?php echo e(\Carbon\Carbon::parse($deduction->deductedInPayroll->created_at)->format('M d, Y')); ?>

                                                            </small>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <small><?php echo e(Str::limit($deduction->notes ?? 'Payroll deduction', 50)); ?></small>
                                                    </td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <tr>
                                                    <td colspan="4" class="text-center py-3 text-muted">
                                                        No deduction records found
                                                    </td>
                                                </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr class="fw-bold">
                                                <td>TOTAL</td>
                                                <td class="text-end">€ <?php echo e(number_format($totalPaid, 2)); ?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="closeWorkerDetails">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                        <a href="<?php echo e(route('hr.advances.form')); ?>?worker_id=<?php echo e($selectedWorkerId); ?>" class="btn btn-danger">
                            <i class="fas fa-plus-circle me-1"></i> Add New Advance
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <style>
        /* Custom styling */
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table > :not(caption) > * > * {
            padding: 1rem 0.75rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 0, 0, 0.02);
            transition: all 0.2s ease;
        }

        .form-control, .form-select, .input-group-text {
            border-radius: 0.5rem;
            border: 1px solid #e0e0e0;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #ff0000;
            box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.1);
            outline: none;
        }

        .input-group:focus-within .form-control,
        .input-group:focus-within .form-select,
        .input-group:focus-within .input-group-text {
            border-color: #ff0000;
            box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.1);
        }

        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-light {
            background: white;
            color: #000;
            border: 1px solid #e0e0e0;
        }

        .btn-light:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            background: #ff0000;
            border: none;
        }

        .btn-danger:hover {
            background: #000000;
            transform: translateY(-1px);
        }

        .btn-info {
            background: #17a2b8;
            border: none;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
            transform: translateY(-1px);
        }

        .btn-warning {
            background: #ffc107;
            border: none;
            color: #000;
        }

        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff0000, #cc0000);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #cc0000, #990000);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.3);
        }

        .btn-outline-secondary {
            border-color: #e0e0e0;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            border-color: #e0e0e0;
        }

        .badge {
            font-weight: 500;
            border-radius: 0.5rem;
        }

        .bg-sec {
            background-color: #f8f9fa !important;
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
        }

        /* Pagination styling */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 0.5rem;
            margin: 0 2px;
            color: #ff0000;
            border: 1px solid #e0e0e0;
        }

        .page-link:hover {
            background-color: #ff0000;
            border-color: #ff0000;
            color: white;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #ff0000, #000000);
            border-color: #ff0000;
        }

        /* Cursor pointer for sortable columns */
        .cursor-pointer {
            cursor: pointer;
        }

        .cursor-pointer:hover {
            background-color: rgba(255, 0, 0, 0.05);
        }

        /* Modal styling */
        .modal.show {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            border-radius: 1rem;
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-footer {
            border-top: 1px solid #e0e0e0;
        }

        /* Progress bar */
        .progress {
            background-color: #e9ecef;
            border-radius: 4px;
        }

        /* Text colors */
        .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        /* Active filters */
        .btn-close-white {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .btn-close-white:hover {
            opacity: 1;
        }

        .badge {
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 0.5rem;
            }

            .d-flex.gap-2 {
                flex-direction: column;
                gap: 5px;
            }

            .d-flex.gap-2 .btn {
                width: 100%;
            }
        }

        /* Modal body scroll */
        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #e4e2e2;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #cc0000;
        }

        /* Background opacity utilities */
        .bg-primary.bg-opacity-10 {
            background-color: rgba(23, 162, 184, 0.1) !important;
        }

        .bg-success.bg-opacity-10 {
            background-color: rgba(40, 167, 69, 0.1) !important;
        }

        .bg-danger.bg-opacity-10 {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }
    </style>
</div>
<?php /**PATH C:\xampp\htdocs\ERP-System\resources\views\livewire\hr\payment\worker-advance-list.blade.php ENDPATH**/ ?>