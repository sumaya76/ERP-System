<div>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>
                            Real-Time Payroll Dashboard
                        </h4>
                        <small>View real-time earnings and generate payroll instantly</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
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

        <div class="row">
            <!-- Left Column: Controls -->
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-sliders-h me-2"></i>
                            Payroll Controls
                        </h5>

                        <!-- Worker Selection -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-user me-1"></i>
                                Select Worker
                            </label>
                            <select class="form-select" wire:model.live="selectedWorker">
                                <option value="">Choose a worker...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($worker->id); ?>">
                                        <?php echo e($worker->name); ?> - <?php echo e(ucfirst($worker->rate_type)); ?>: €<?php echo e(number_format($worker->rate, 2)); ?>

                                    </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>

                        <!-- Overtime Multiplier -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-clock me-1"></i>
                                Overtime Multiplier
                            </label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control" 
                                       step="0.1"
                                       min="1"
                                       max="3"
                                       wire:model.live="overtimeMultiplier">
                                <span class="input-group-text">x</span>
                            </div>
                            <small class="text-muted">Example: 1.5 = Time and a half, 2 = Double time</small>
                        </div>

                        <!-- Generate Payroll Button -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg" 
                                    wire:click="generatePayroll"
                                    wire:loading.attr="disabled">
                                <i class="fas fa-calculator me-2"></i>
                                <span wire:loading.remove>Generate Payroll for <?php echo e(date('F Y')); ?></span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Generating...
                                </span>
                            </button>
                        </div>

                        <!-- Current Batch Status -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentBatch): ?>
                            <div class="alert alert-info mt-4 mb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Current Batch:</strong> <?php echo e($currentBatch->month_name); ?> <?php echo e($currentBatch->year); ?>

                                        <br>
                                        <small>Status: <?php echo e(ucfirst($currentBatch->status)); ?></small>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentBatch->status === 'draft'): ?>
                                        <button class="btn btn-success btn-sm" 
                                                wire:click="finalizeBatch(<?php echo e($currentBatch->id); ?>)">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Finalize Batch
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Real-Time Earnings -->
            <div class="col-md-7 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-chart-line me-2"></i>
                            Real-Time Earnings
                        </h5>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedWorker && $earningsData): ?>
                            <div class="mb-4">
                                <h6 class="text-muted">From <?php echo e($earningsData['from_date']->format('M d, Y')); ?> to <?php echo e($earningsData['to_date']->format('M d, Y')); ?></h6>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="card bg-light border-0">
                                        <div class="card-body text-center">
                                            <small class="text-muted">Total Hours Worked</small>
                                            <h3 class="mb-0"><?php echo e(number_format($earningsData['total_hours'], 2)); ?></h3>
                                            <small><?php echo e($earningsData['regular_hours']); ?> regular + <?php echo e($earningsData['overtime_hours']); ?> overtime</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light border-0">
                                        <div class="card-body text-center">
                                            <small class="text-muted">Attendance Records</small>
                                            <h3 class="mb-0"><?php echo e($earningsData['attendance_count']); ?></h3>
                                            <small>Days worked</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="card border-0 bg-gradient-success text-white">
                                        <div class="card-body">
                                            <small class="text-white-50">Regular Pay</small>
                                            <h4 class="mb-0">€ <?php echo e(number_format($earningsData['regular_pay'], 2)); ?></h4>
                                            <small><?php echo e(number_format($earningsData['regular_hours'], 2)); ?> hrs × €<?php echo e(number_format($earningsData['gross_earnings'] / ($earningsData['total_hours'] ?: 1), 2)); ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 bg-gradient-warning text-white">
                                        <div class="card-body">
                                            <small class="text-white-50">Overtime Pay</small>
                                            <h4 class="mb-0">€ <?php echo e(number_format($earningsData['overtime_pay'], 2)); ?></h4>
                                            <small><?php echo e(number_format($earningsData['overtime_hours'], 2)); ?> hrs × €<?php echo e(number_format($earningsData['gross_earnings'] / ($earningsData['total_hours'] ?: 1), 2)); ?> × <?php echo e($overtimeMultiplier); ?>x</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="card border-0 bg-gradient-info text-white">
                                        <div class="card-body">
                                            <small class="text-white-50">Gross Earnings</small>
                                            <h4 class="mb-0">€ <?php echo e(number_format($earningsData['gross_earnings'], 2)); ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 bg-gradient-danger text-white">
                                        <div class="card-body">
                                            <small class="text-white-50">Pending Advances</small>
                                            <h4 class="mb-0">€ <?php echo e(number_format($earningsData['pending_advances'], 2)); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 bg-gradient-primary text-white">
                                <div class="card-body text-center">
                                    <small class="text-white-50">Net Payable (After Advances)</small>
                                    <h3 class="mb-0">€ <?php echo e(number_format($earningsData['net_earnings'], 2)); ?></h3>
                                </div>
                            </div>

                            <!-- Project Breakdown -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($earningsData['attendance_count'] > 0): ?>
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-project-diagram me-2"></i>
                                        Project Breakdown
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Project</th>
                                                    <th>Days</th>
                                                    <th>Hours</th>
                                                    <th class="text-end">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $earningsData['attendance'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                    <tr>
                                                        <td><?php echo e($attendance->project->name); ?></td>
                                                        <td>1</td>
                                                        <td><?php echo e(number_format($attendance->hours_worked, 2)); ?></td>
                                                        <td class="text-end">€ <?php echo e(number_format($attendance->hours_worked * $earningsData['gross_earnings'] / ($earningsData['total_hours'] ?: 1), 2)); ?></td>
                                                    </tr>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php elseif($selectedWorker): ?>
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                                <p>No attendance records found for this period</p>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-user-circle fa-3x mb-3"></i>
                                <p>Select a worker to view real-time earnings</p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Payroll Batches -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payrollBatches->count() > 0): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-history me-2"></i>
                                Recent Payroll Batches
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Period</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Workers</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $payrollBatches->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo e($batch->month_name); ?> <?php echo e($batch->year); ?></strong>
                                                </td>
                                                <td><?php echo e($batch->period_start->format('M d, Y')); ?></td>
                                                <td><?php echo e($batch->period_end->format('M d, Y')); ?></td>
                                                <td><?php echo e($batch->payrolls->count()); ?></td>
                                                <td>€ <?php echo e(number_format($batch->payrolls->sum('net_amount'), 2)); ?></td>
                                                <td>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($batch->status === 'finalized'): ?>
                                                        <span class="badge bg-success">Finalized</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning">Draft</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(route('payroll.history', ['batch' => $batch->id])); ?>" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-gradient-success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .bg-gradient-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .bg-gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .bg-gradient-danger {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .card {
            border-radius: 1rem;
        }
        .btn {
            border-radius: 0.5rem;
        }
    </style>
</div><?php /**PATH C:\xampp\htdocs\ERP-System\resources\views\livewire\hr\payroll\real-time-dashboard.blade.php ENDPATH**/ ?>