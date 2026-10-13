
<div>
    <div class="card shadow-sm border-0">
        <!-- Header with Red-Black Gradient Background -->
        <div class="card-header border-0 pt-4 pb-4" style="background: linear-gradient(135deg, #ff0000 0%, #000000 100%); border-radius: 1rem 1rem 0 0;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-chart-line text-white fs-4"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold text-white">Payroll Summary Dashboard</h3>
                        <p class="text-white-50 small mb-0">Track monthly payroll expenses and trends over time</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button wire:click="refreshData" class="btn btn-light">
                        <i class="fas fa-sync-alt me-2"></i>
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body pt-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('message')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Search and Filters Section -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-search me-2" style="color: #ff0000;"></i>
                            Search & Filter Payroll Summary
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="resetFilters">
                            <i class="fas fa-undo-alt me-1"></i> Reset All Filters
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="performSearch">
                        <div class="row g-3 pt-3">
                            <!-- View Type -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-chart-pie me-1" style="color: #ff0000;"></i>
                                    View Type
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-chart-simple"></i>
                                    </span>
                                    <select class="form-select" wire:model="tempViewType">
                                        <option value="yearly">Yearly View</option>
                                        <option value="quarterly">Quarterly View</option>
                                        <option value="monthly">Monthly View</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Year Filter -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar me-1" style="color: #ff0000;"></i>
                                    Year
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <select class="form-select" wire:model="tempSelectedYear">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempViewType == 'monthly'): ?>
                                <!-- From Month -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt me-1" style="color: #ff0000;"></i>
                                        From Month
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-calendar-week"></i>
                                        </span>
                                        <select class="form-select" wire:model="tempSelectedStartMonth">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <option value="<?php echo e($num); ?>"><?php echo e($name); ?></option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- To Month -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt me-1" style="color: #ff0000;"></i>
                                        To Month
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-calendar-week"></i>
                                        </span>
                                        <select class="form-select" wire:model="tempSelectedEndMonth">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <option value="<?php echo e($num); ?>"><?php echo e($name); ?></option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <!-- Search Actions -->
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="d-flex gap-2 w-100">
                                    <button type="submit" class="btn btn-primary flex-grow-1" style="background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%); border: none;">
                                        <i class="fas fa-search me-2"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Active Filters Display -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isSearching && ($selectedYear || $viewType)): ?>
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <small class="text-muted me-2">
                                    <i class="fas fa-filter me-1"></i>Active filters:
                                </small>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedYear): ?>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-calendar me-1"></i>
                                        Year: <?php echo e($selectedYear); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($viewType): ?>
                                    <span class="badge bg-info">
                                        <i class="fas fa-chart-pie me-1"></i>
                                        View: <?php echo e(ucfirst($viewType)); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($viewType == 'monthly' && $selectedStartMonth && $selectedEndMonth): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Range: <?php echo e($months[$selectedStartMonth]); ?> - <?php echo e($months[$selectedEndMonth]); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-card-mini" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="stat-card-mini-content">
                            <div>
                                <small class="text-white-50">Total Payrolls</small>
                                <h3 class="mb-0 fw-bold text-white"><?php echo e(number_format($totalPayrolls)); ?></h3>
                                <small class="text-white-50">Records processed</small>
                            </div>
                            <i class="fas fa-file-invoice fa-2x opacity-50 text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-mini" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <div class="stat-card-mini-content">
                            <div>
                                <small class="text-white-50">Total Workers</small>
                                <h3 class="mb-0 fw-bold text-white"><?php echo e(number_format($totalWorkers)); ?></h3>
                                <small class="text-white-50">Unique workers</small>
                            </div>
                            <i class="fas fa-users fa-2x opacity-50 text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-mini" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="stat-card-mini-content">
                            <div>
                                <small class="text-white-50">Total Gross Payout</small>
                                <h3 class="mb-0 fw-bold text-white">€ <?php echo e(number_format($totalGrossAmount, 2)); ?></h3>
                                <small class="text-white-50">Before deductions</small>
                            </div>
                            <i class="fas fa-chart-line fa-2x opacity-50 text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-mini" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="stat-card-mini-content">
                            <div>
                                <small class="text-white-50">Total Net Payout</small>
                                <h3 class="mb-0 fw-bold text-white">€ <?php echo e(number_format($totalNetAmount, 2)); ?></h3>
                                <small class="text-white-50">After advances</small>
                            </div>
                            <i class="fas fa-euro-sign fa-2x opacity-50 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats Row -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase">Total Advances Deducted</small>
                                    <h3 class="mb-0 fw-bold text-danger">€ <?php echo e(number_format($totalAdvancesDeducted, 2)); ?></h3>
                                    <small>Deducted from payrolls</small>
                                </div>
                                <div class="rounded-circle p-3" style="background: rgba(220, 53, 69, 0.1);">
                                    <i class="fas fa-hand-holding-usd fa-2x text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase">Average Payout</small>
                                    <h3 class="mb-0 fw-bold text-primary">€ <?php echo e(number_format($averageMonthlyPayout, 2)); ?></h3>
                                    <small>Per <?php echo e($viewType == 'quarterly' ? 'quarter' : 'month'); ?></small>
                                </div>
                                <div class="rounded-circle p-3" style="background: rgba(23, 162, 184, 0.1);">
                                    <i class="fas fa-chart-simple fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase">Period Coverage</small>
                                    <h3 class="mb-0 fw-bold">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($viewType == 'yearly'): ?>
                                            Full Year <?php echo e($selectedYear); ?>

                                        <?php elseif($viewType == 'quarterly'): ?>
                                            <?php echo e($selectedYear); ?> Quarters
                                        <?php else: ?>
                                            <?php echo e($months[$selectedStartMonth] ?? ''); ?> - <?php echo e($months[$selectedEndMonth] ?? ''); ?> <?php echo e($selectedYear); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </h3>
                                    <small><?php echo e(ucfirst($viewType)); ?> view</small>
                                </div>
                                <div class="rounded-circle p-3" style="background: rgba(255, 193, 7, 0.1);">
                                    <i class="fas fa-calendar-alt fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-table me-2" style="color: #ff0000;"></i>
                        <?php echo e(ucfirst($viewType)); ?> Payroll Summary
                    </h6>
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Showing <?php echo e($summaries->count()); ?> records
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-sec">
                            <tr>
                                <th class="py-3"><i class="fas fa-calendar-alt me-2" ></i> Period</th>
                                <th class="py-3 text-center"><i class="fas fa-file-invoice me-2" ></i> Payrolls</th>
                                <th class="py-3 text-center"><i class="fas fa-users me-2" ></i> Workers</th>
                                <th class="py-3 text-end"><i class="fas fa-chart-line me-2" ></i> Gross Amount</th>
                                <th class="py-3 text-end"><i class="fas fa-hand-holding-usd me-2" ></i> Advances</th>
                                <th class="py-3 text-end"><i class="fas fa-euro-sign me-2" ></i> Net Amount</th>
                                <th class="py-3 text-center"><i class="fas fa-chart-simple me-2" ></i> Avg per Worker</th>
                                <th class="py-3 text-center"><i class="fas fa-cog me-2" ></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $summaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($viewType == 'quarterly'): ?>
                                                <?php echo e($summary->quarter_name); ?>

                                            <?php else: ?>
                                                <?php echo e($months[$summary->month] ?? 'Unknown'); ?> <?php echo e($summary->year ?? $selectedYear); ?>

                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($viewType == 'monthly'): ?>
                                            <small class="text-muted"><?php echo e($selectedYear); ?></small>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="fas fa-file-invoice me-1"></i>
                                            <?php echo e(number_format($summary->total_payrolls)); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-users me-1"></i>
                                            <?php echo e(number_format($summary->total_workers)); ?>

                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-semibold">€ <?php echo e(number_format($summary->total_gross_amount, 2)); ?></span>
                                    </td>
                                    <td class="text-end text-danger">
                                        -€ <?php echo e(number_format($summary->total_advances_deducted, 2)); ?>

                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold text-success">
                                            € <?php echo e(number_format($summary->total_net_amount, 2)); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $avgPerWorker = ($summary->total_workers ?? 1) > 0 
                                                ? ($summary->total_net_amount / ($summary->total_workers ?? 1)) 
                                                : 0;
                                        ?>
                                        <span class="badge bg-light text-dark px-3 py-2">
                                            € <?php echo e(number_format($avgPerWorker, 2)); ?>

                                        </span>
                                    </td>
                                  <td class="text-center">
    <button class="btn btn-sm btn-info"
            wire:click="viewDetails(<?php echo e(json_encode((array)$summary)); ?>)">
        <i class="fas fa-eye me-1"></i> Details
    </button>
</td>

                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                            <p class="mb-0">No payroll data found for this period</p>
                                            <small>Try adjusting your search filters</small>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($summaries->count() > 0): ?>
                            <tfoot class="bg-light">
                                <tr class="fw-bold">
                                    <td class="py-3">TOTAL</td>
                                    <td class="text-center py-3"><?php echo e(number_format($totalPayrolls)); ?></td>
                                    <td class="text-center py-3"><?php echo e(number_format($totalWorkers)); ?></td>
                                    <td class="text-end py-3">€ <?php echo e(number_format($totalGrossAmount, 2)); ?></td>
                                    <td class="text-end text-danger py-3">-€ <?php echo e(number_format($totalAdvancesDeducted, 2)); ?></td>
                                    <td class="text-end text-success py-3">€ <?php echo e(number_format($totalNetAmount, 2)); ?></td>
                                    <td class="text-center py-3">€ <?php echo e(number_format($averageMonthlyPayout, 2)); ?></td>
                                    <td class="py-3"></td>
                                </tr>
                            </tfoot>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Details Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDetailsModal && $selectedSummary): ?>
        <div class="modal-modern-overlay" wire:click.self="closeDetailsModal">
            <div class="modal-modern-container" style="max-width: 800px;">
                <div class="modern-modal-content">
                    <div class="modern-modal-header">
                        <div class="modern-modal-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="modern-modal-title">
                            <h5 class="mb-0 fw-bold text-white">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($viewType == 'quarterly'): ?>
                                    <?php echo e($selectedSummary['quarter_name']); ?> <?php echo e($selectedYear); ?> Details
                                <?php else: ?>
                                    <?php echo e($months[$selectedSummary['month']] ?? 'Unknown'); ?> <?php echo e($selectedSummary['year'] ?? $selectedYear); ?> Details
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </h5>
                            <small>Detailed payroll breakdown</small>
                        </div>
                        <button type="button" class="modern-modal-close" wire:click="closeDetailsModal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="modern-modal-body">
                        <!-- Summary Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <div class="modal-stat-card">
                                    <div class="modal-stat-icon" style="background: #e3f2fd;">
                                        <i class="fas fa-file-invoice" style="color: #1976d2;"></i>
                                    </div>
                                    <div class="modal-stat-info">
                                        <span class="modal-stat-label">Total Payrolls</span>
                                        <strong class="modal-stat-value"><?php echo e(number_format($selectedSummary['total_payrolls'] ?? 0)); ?></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="modal-stat-card">
                                    <div class="modal-stat-icon" style="background: #e8f5e9;">
                                        <i class="fas fa-users" style="color: #388e3c;"></i>
                                    </div>
                                    <div class="modal-stat-info">
                                        <span class="modal-stat-label">Total Workers</span>
                                        <strong class="modal-stat-value"><?php echo e(number_format($selectedSummary['total_workers'] ?? 0)); ?></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="modal-stat-card">
                                    <div class="modal-stat-icon" style="background: #e8f5e9;">
                                        <i class="fas fa-chart-line" style="color: #388e3c;"></i>
                                    </div>
                                    <div class="modal-stat-info">
                                        <span class="modal-stat-label">Gross Amount</span>
                                        <strong class="modal-stat-value">€ <?php echo e(number_format($selectedSummary['total_gross_amount'] ?? 0, 2)); ?></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="modal-stat-card highlight">
                                    <div class="modal-stat-icon" style="background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%);">
                                        <i class="fas fa-wallet" style="color: white;"></i>
                                    </div>
                                    <div class="modal-stat-info">
                                        <span class="modal-stat-label">Net Amount</span>
                                        <strong class="modal-stat-value net">€ <?php echo e(number_format($selectedSummary['total_net_amount'] ?? 0, 2)); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="info-grid mb-4">
                            <div class="info-item">
                                <span><i class="fas fa-hand-holding-usd me-2 text-muted"></i>Total Advances Deducted:</span>
                                <strong class="text-danger">€ <?php echo e(number_format($selectedSummary['total_advances_deducted'] ?? 0, 2)); ?></strong>
                            </div>
                            <div class="info-item">
                                <span><i class="fas fa-chart-simple me-2 text-muted"></i>Average per Worker:</span>
                                <strong>
                                    <?php
                                        $avgPerWorker = ($selectedSummary['total_workers'] ?? 1) > 0 
                                            ? ($selectedSummary['total_net_amount'] / ($selectedSummary['total_workers'] ?? 1)) 
                                            : 0;
                                    ?>
                                    € <?php echo e(number_format($avgPerWorker, 2)); ?>

                                </strong>
                            </div>
                        </div>

                        <!-- Detailed Payroll Records -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detailedPayrolls && $detailedPayrolls->count() > 0): ?>
                            <div class="breakdown-modern">
                                <div class="breakdown-header">
                                    <i class="fas fa-list me-2 text-danger"></i>
                                    <span class="fw-semibold">Payroll Records</span>
                                    <span class="ms-auto badge bg-light text-dark"><?php echo e($detailedPayrolls->count()); ?> records</span>
                                </div>
                                <div class="breakdown-list">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detailedPayrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <div class="breakdown-item">
                                            <div class="breakdown-project">
                                                <i class="fas fa-user me-2 text-secondary"></i>
                                                <span class="fw-semibold"><?php echo e($payroll->worker->name); ?></span>
                                                <br>
                                                <small class="text-muted"><?php echo e($payroll->worker->designation ?? 'N/A'); ?></small>
                                            </div>
                                            <div class="breakdown-stats">
                                                <span class="breakdown-stat"><i class="fas fa-clock me-1"></i><?php echo e(number_format($payroll->total_hours, 1)); ?> hrs</span>
                                                <span class="breakdown-stat"><i class="fas fa-calendar-day me-1"></i><?php echo e($payroll->total_days); ?> days</span>
                                                <strong class="text-success">€<?php echo e(number_format($payroll->net_amount, 2)); ?></strong>
                                            </div>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                                <div class="breakdown-footer">
                                    <div class="breakdown-total">
                                        <span>Total Net Amount</span>
                                        <strong class="text-danger">€<?php echo e(number_format($detailedPayrolls->sum('net_amount'), 2)); ?></strong>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="modern-modal-footer">
                        <button class="modal-btn-secondary" wire:click="closeDetailsModal">
                            <i class="fas fa-times me-2"></i> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <style>
        /* Card Styles */
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
        
        tfoot {
            border-top: 2px solid #dee2e6;
        }
        
        /* Form Controls */
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
        .input-group:focus-within .input-group-text {
            border-color: #ff0000;
            box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.1);
        }
        
        /* Buttons */
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
        
        .btn-primary {
            background: linear-gradient(135deg, #ff0000, #cc0000);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #cc0000, #990000);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.3);
        }
        
        /* Action Buttons */
        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 0.5rem;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
        }
        
        .btn-action.btn-info { background: #17a2b8; }
        .btn-action.btn-info:hover { background: #138496; transform: translateY(-1px); }
        .btn-action.btn-infor { background: #00cfe8; }
        .btn-action.btn-infor:hover { background: #00cfe8; transform: translateY(-1px); }
        /* Badges */
        .badge {
            font-weight: 500;
            border-radius: 0.5rem;
        }
        
        .alert {
            border-radius: 0.75rem;
            border: none;
        }
        
        /* Stat Cards Mini */
        .stat-card-mini {
            border-radius: 1rem;
            padding: 1rem;
            transition: all 0.3s ease;
        }
        
        .stat-card-mini:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .stat-card-mini-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        
        /* Pagination */
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
        
        /* Modal Styles */
        .modal-modern-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        
        .modal-modern-container {
            position: relative;
            width: 100%;
            margin: 0 20px;
            animation: modalSlideIn 0.3s ease;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modern-modal-content {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .modern-modal-header {
            background: linear-gradient(135deg, #00cfe8 70%, #ffffff 100%);
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .modern-modal-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .modern-modal-icon i {
            font-size: 1.25rem;
        }
        
        .modern-modal-title {
            flex: 1;
            color: white;
        }
        
        .modern-modal-title h5 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }
        
        .modern-modal-title small {
            font-size: 0.7rem;
            opacity: 0.8;
        }
        
        .modern-modal-close {
            background: rgba(0, 0, 0, 0.2);
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .modern-modal-close:hover {
            background: rgba(0, 0, 0, 0.3);
            transform: rotate(90deg);
            color: white;
        }
        
        .modern-modal-body {
            padding: 1.25rem;
            max-height: 60vh;
            overflow-y: auto;
        }
        
        .modern-modal-footer {
            padding: 0.75rem 1.25rem;
            background: #f8f9fa;
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            border-top: 1px solid #f0f0f0;
        }
        
        .modal-btn-secondary {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            background: white;
            color: #6c757d;
            border: 1px solid #e5e7eb;
        }
        
        .modal-btn-secondary:hover {
            background: #f8f9fa;
            border-color: #ff0000;
            color: #ff0000;
        }
        
        /* Modal Stats Cards */
        .modal-stat-card {
            background: #f8f9fa;
            border-radius: 0.75rem;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .modal-stat-card.highlight {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe0e0 100%);
            border: 1px solid #ffcccc;
        }
        
        .modal-stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-stat-icon i {
            font-size: 1rem;
        }
        
        .modal-stat-info {
            flex: 1;
        }
        
        .modal-stat-label {
            display: block;
            font-size: 0.65rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }
        
        .modal-stat-value {
            display: block;
            font-size: 1rem;
            font-weight: 700;
            color: #333;
        }
        
        .modal-stat-value.net {
            color: #ff0000;
        }
        
        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }
        
        .info-item {
            background: #f8f9fa;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Breakdown */
        .breakdown-modern {
            background: #f8f9fa;
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .breakdown-header {
            background: white;
            padding: 0.75rem;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.8rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .breakdown-list {
            padding: 0.5rem;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .breakdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid #e9ecef;
            font-size: 0.75rem;
            transition: all 0.2s ease;
        }
        
        .breakdown-item:hover {
            background: white;
        }
        
        .breakdown-item:last-child {
            border-bottom: none;
        }
        
        .breakdown-project {
            flex: 1;
        }
        
        .breakdown-stats {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .breakdown-stat {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            color: #6c757d;
        }
        
        .breakdown-footer {
            background: white;
            padding: 0.75rem;
            border-top: 1px solid #f0f0f0;
        }
        
        .breakdown-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
        }
        
        /* Active Filters */
        .btn-close-white {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }
        
        .btn-close-white:hover {
            opacity: 1;
        }
        
        .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Scrollbar */
        .modern-modal-body::-webkit-scrollbar,
        .breakdown-list::-webkit-scrollbar {
            width: 6px;
        }
        
        .modern-modal-body::-webkit-scrollbar-track,
        .breakdown-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .modern-modal-body::-webkit-scrollbar-thumb,
        .breakdown-list::-webkit-scrollbar-thumb {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 0.5rem;
            }
            
            .d-flex.gap-2 {
                flex-direction: column;
            }
            
            .d-flex.gap-2 .btn {
                width: 100%;
            }
            
            .row.g-3 {
                flex-direction: column;
                gap: 10px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .breakdown-stats {
                flex-direction: column;
                align-items: flex-end;
                gap: 0.25rem;
            }
            
            .breakdown-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .modal-modern-container {
                max-width: 95%;
                margin: 0 10px;
            }
        }
         .bg-sec {
            background-color: #f8f9fa !important;
        }
    </style>
</div><?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/livewire/admin/payroll-summary.blade.php ENDPATH**/ ?>