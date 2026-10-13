
<div>
    <div class="card shadow-sm border-0">
        <!-- Header with Red-Black Gradient Background -->
        <div class="card-header border-0 pt-4 pb-4" style="background: linear-gradient(135deg, #ff0000 0%, #000000 100%); border-radius: 1rem 1rem 0 0;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-calendar-check text-white fs-4"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold text-white">Attendance Management</h3>
                        <p class="text-white-50 small mb-0">Track and manage worker daily attendance</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light" wire:click="resetForm">
                        <i class="fas fa-sync-alt me-2"></i>
                        Reset Form
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body pt-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('message')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Attendance Form -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-plus-circle me-2" style="color: #ff0000;"></i>
                        Record Attendance
                    </h6>
                </div>
                <div class="card-body mt-2">
                    <form wire:submit.prevent="save">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-project-diagram me-1" style="color: #000000;"></i>
                                    Project
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.live="project_id">
                                    <option value="">Select Project</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user-tie me-1" style="color: #000000;"></i>
                                    Worker
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['worker_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.live="worker_id">
                                    <option value="">Select Worker</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <option value="<?php echo e($worker->id); ?>"><?php echo e($worker->name); ?> (<?php echo e($worker->designation ?: 'No designation'); ?>)</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['worker_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-day me-1" style="color: #000000;"></i>
                                    Date
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       wire:model.live="date"
                                       max="<?php echo e(now()->format('Y-m-d')); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <!-- Show existing attendance info for selected date -->
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($date && $worker_id): ?>
                                    <?php
                                        $existingCount = \App\Models\Attendance::where('worker_id', $worker_id)
                                            ->where('date', $date)
                                            ->count();
                                        $hasFullDay = \App\Models\Attendance::where('worker_id', $worker_id)
                                            ->where('date', $date)
                                            ->where(function($q) {
                                                $q->where('status', 'present')
                                                  ->orWhere('hours_worked', '>=', 8);
                                            })
                                            ->exists();
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existingCount > 0): ?>
                                        <small class="text-info d-block mt-1">
                                            <i class="fas fa-info-circle"></i>
                                            Worker has <?php echo e($existingCount); ?> attendance record(s) on this date.
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasFullDay): ?>
                                                <strong class="text-warning">⚠️ Only half-day allowed for additional sites.</strong>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </small>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-clock me-1" style="color: #000000;"></i>
        Check In
    </label>
    <input type="time"
           class="form-control <?php $__errorArgs = ['check_in'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           wire:model="check_in">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['check_in'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-clock me-1" style="color: #000000;"></i>
        Check Out
    </label>
    <input type="time"
           class="form-control <?php $__errorArgs = ['check_out'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           wire:model="check_out">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['check_out'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<!-- STATUS FIELD - Move this here (before Hours Worked) -->
<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-chart-pie me-1" style="color: #000000;"></i>
        Status
        <span class="text-danger">*</span>
    </label>
    <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.live="status">
        <option value="present">Present</option>
        <option value="absent">Absent</option>
        <option value="half_day">Half Day</option>
    </select>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-hourglass-half me-1" style="color: #000000;"></i>
        Hours Worked
        <span class="text-muted">(Editable)</span>
    </label>
    <div class="input-group">
        <input type="number"
               step="0.01"
               class="form-control <?php $__errorArgs = ['hours_worked'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               wire:model.live="hours_worked"
               placeholder="0.00">
        <span class="input-group-text bg-light">hrs</span>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['hours_worked'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<!-- CLIENT BILLING TYPE FIELD -->
<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-building me-1" style="color: #000000;"></i>
        Client Billing Type
        <span class="text-danger">*</span>
    </label>
    <select class="form-select <?php $__errorArgs = ['client_billing_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.live="client_billing_type">
        <option value="daily">Daily (Fixed 9 hours)</option>
        <option value="hourly">Hourly (Actual hours)</option>
    </select>
    <small class="text-muted">
        <i class="fas fa-info-circle me-1"></i>
        How will the company be billed?
    </small>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['client_billing_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<!-- CLIENT HOURS FIELD -->
<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-clock me-1" style="color: #000000;"></i>
        Client Hours (To Bill)
        <span class="text-muted">(Editable)</span>
    </label>
    <div class="input-group">
        <input type="number"
               step="0.01"
               class="form-control <?php $__errorArgs = ['client_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               wire:model.live="client_hours"
               placeholder="0.00">
        <span class="input-group-text bg-light">hrs</span>
    </div>
    <small class="text-muted">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($client_billing_type == 'daily'): ?>
            <i class="fas fa-info-circle me-1 text-info"></i>
            Daily billing: <?php echo e($status == 'present' ? '9' : ($status == 'half_day' ? '4.5' : '0')); ?> hours (fixed)
        <?php else: ?>
            <i class="fas fa-info-circle me-1 text-info"></i>
            Hourly billing: Same as hours worked
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </small>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['client_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<!-- HOURS WORKED FIELD - After Status -->


<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-chart-line me-1" style="color: #000000;"></i>
        Overtime Hours
    </label>
    <div class="input-group">
        <input type="number"
               step="0.01"
               class="form-control <?php $__errorArgs = ['overtime_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               wire:model="overtime_hours"
               placeholder="0.00">
        <span class="input-group-text bg-light">hrs</span>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['overtime_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>



                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-sticky-note me-1" style="color: #000000;"></i>
                                    Notes
                                </label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       wire:model="notes"
                                       placeholder="Optional notes about attendance...">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-md-12 mt-3 text-end">
                                <button type="submit" class="btn btn-save-attendance" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class="fas fa-save me-2"></i> Save Attendance
                                    </span>
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin"></i> Saving...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Attendance Records Table -->
      <div class="card border-0 shadow-sm">
    <div class="card-header bg-light border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="fw-bold mb-0">
            <i class="fas fa-history me-2" style="color: #ff0000;"></i>
            Recent Attendance Records
        </h6>
        <div class="text-muted small">
            <i class="fas fa-chart-line me-1"></i>
            Total: <?php echo e($records->total()); ?> records
        </div>
    </div>
                <!-- Search Filters Section -->
<!-- Search Filters Section - Improved Layout -->
<div class=" mb-2 border-0 shadow-sm">

    <div class="card-body">
        <form wire:submit.prevent="applySearch">
            <div class="row g-3">
                <!-- Project Filter -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-project-diagram me-1" style="color: #ff0000;"></i>
                        Project
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-building"></i>
                        </span>
                        <select class="form-select" wire:model="search_project_id">
                            <option value="">All Projects</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_project_id): ?>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$set('search_project_id', '')">
                                <i class="fas fa-times"></i>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Worker Filter -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-user-tie me-1" style="color: #ff0000;"></i>
                        Worker
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-user"></i>
                        </span>
                        <select class="form-select" wire:model="search_worker_id">
                            <option value="">All Workers</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allWorkers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($worker->id); ?>"><?php echo e($worker->name); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_worker_id): ?>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$set('search_worker_id', '')">
                                <i class="fas fa-times"></i>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-chart-pie me-1" style="color: #ff0000;"></i>
                        Status
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-flag-checkered"></i>
                        </span>
                        <select class="form-select" wire:model="search_status">
                            <option value="">All Status</option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="half_day">Half Day</option>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_status): ?>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$set('search_status', '')">
                                <i class="fas fa-times"></i>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Date Range From -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt me-1" style="color: #ff0000;"></i>
                        From Date
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-calendar-day"></i>
                        </span>
                        <input type="date"
                               class="form-control"
                               wire:model="search_date_from"
                               max="<?php echo e(now()->format('Y-m-d')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_date_from): ?>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$set('search_date_from', '')">
                                <i class="fas fa-times"></i>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Date Range To -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt me-1" style="color: #ff0000;"></i>
                        To Date
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-calendar-check"></i>
                        </span>
                        <input type="date"
                               class="form-control"
                               wire:model="search_date_to"
                               max="<?php echo e(now()->format('Y-m-d')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_date_to): ?>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$set('search_date_to', '')">
                                <i class="fas fa-times"></i>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Hours Worked Min -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-hourglass-half me-1" style="color: #ff0000;"></i>
                        Min Hours
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-hourglass-start"></i>
                        </span>
                        <input type="number"
                               step="0.5"
                               class="form-control"
                               wire:model="search_hours_min"
                               placeholder="0.00">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_hours_min): ?>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$set('search_hours_min', '')">
                                <i class="fas fa-times"></i>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Hours Worked Max -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-hourglass-half me-1" style="color: #ff0000;"></i>
                        Max Hours
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-hourglass-end"></i>
                        </span>
                        <input type="number"
                               step="0.5"
                               class="form-control"
                               wire:model="search_hours_max"
                               placeholder="24.00">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_hours_max): ?>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$set('search_hours_max', '')">
                                <i class="fas fa-times"></i>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Keyword Search -->
               <!-- Keyword Search -->
<div class="col-md-4">
    <label class="form-label fw-semibold">
        <i class="fas fa-keyboard me-1" style="color: #ff0000;"></i>
        Keyword Search
    </label>
    <div class="input-group">
        <span class="input-group-text bg-white">
            <i class="fas fa-search"></i>
        </span>
        <input type="text"
               class="form-control"
               wire:model="search_keyword"
               placeholder="Search in notes, worker or project...">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_keyword): ?>
            <button type="button" class="btn btn-outline-secondary" wire:click="$set('search_keyword', '')">
                <i class="fas fa-times"></i>
            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<!-- Buttons (Far Right) -->
<div class="col-md-4 d-flex align-items-end justify-content-end">
    <div class="d-flex gap-2">
        <button type="submit"
                class="btn btn-primary px-4"
                style="background: linear-gradient(135deg, #ff0000 0%, #000000 100%); border: none;">
            <i class="fas fa-search me-2"></i> Search
        </button>

        <button type="button"
                class="btn btn-secondary px-4"
                wire:click="resetFilters">
            <i class="fas fa-undo-alt me-2"></i> Clear
        </button>
    </div>
</div>


                <!-- Filter Actions -->

            </div>
        </form>

        <!-- Active Filters Display -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isSearching && ($search_project_id || $search_worker_id || $search_status || $search_date_from || $search_date_to || $search_hours_min || $search_hours_max || $search_keyword)): ?>
            <div class="mt-4 pt-3 border-top">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <small class="text-muted me-2">
                        <i class="fas fa-filter me-1"></i>Active filters:
                    </small>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_project_id): ?>
                        <span class="badge bg-primary">
                            <i class="fas fa-project-diagram me-1"></i>
                            Project: <?php echo e($projects->firstWhere('id', $search_project_id)?->name); ?>

                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="$set('search_project_id', '')"></button>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_worker_id): ?>
                        <span class="badge bg-success">
                            <i class="fas fa-user me-1"></i>
                            Worker: <?php echo e($allWorkers->firstWhere('id', $search_worker_id)?->name); ?>

                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="$set('search_worker_id', '')"></button>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_status): ?>
                        <span class="badge bg-info">
                            <i class="fas fa-chart-pie me-1"></i>
                            Status: <?php echo e(ucfirst($search_status)); ?>

                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="$set('search_status', '')"></button>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_date_from): ?>
                        <span class="badge bg-secondary">
                            <i class="fas fa-calendar-alt me-1"></i>
                            From: <?php echo e(\Carbon\Carbon::parse($search_date_from)->format('M d, Y')); ?>

                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="$set('search_date_from', '')"></button>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_date_to): ?>
                        <span class="badge bg-secondary">
                            <i class="fas fa-calendar-alt me-1"></i>
                            To: <?php echo e(\Carbon\Carbon::parse($search_date_to)->format('M d, Y')); ?>

                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="$set('search_date_to', '')"></button>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_hours_min): ?>
                        <span class="badge bg-warning">
                            <i class="fas fa-hourglass-half me-1"></i>
                            Min Hours: <?php echo e($search_hours_min); ?>

                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="$set('search_hours_min', '')"></button>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_hours_max): ?>
                        <span class="badge bg-warning">
                            <i class="fas fa-hourglass-half me-1"></i>
                            Max Hours: <?php echo e($search_hours_max); ?>

                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="$set('search_hours_max', '')"></button>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search_keyword): ?>
                        <span class="badge bg-dark">
                            <i class="fas fa-keyboard me-1"></i>
                            Keyword: "<?php echo e($search_keyword); ?>"
                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="$set('search_keyword', '')"></button>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
                <div class=" mt-2">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3">
                                        <i class="fas fa-calendar-alt me-2"></i> Date
                                    </th>
                                    <th class="py-3">
                                        <i class="fas fa-project-diagram me-2"></i> Project
                                    </th>
                                    <th class="py-3">
                                        <i class="fas fa-user me-2"></i> Worker
                                    </th>
                                    <th class="py-3 text-center">
                                        <i class="fas fa-clock me-2"></i> Check In/Out
                                    </th>
                                    <th class="py-3 text-center">
                                        <i class="fas fa-hourglass-half me-2"></i> Hours
                                    </th>
                                    <th class="py-3 text-center">
                                        <i class="fas fa-chart-line me-2"></i> OT
                                    </th>
                                    <th class="py-3">
                                        <i class="fas fa-chart-pie me-2"></i> Status
                                    </th>
                                    <th class="py-3">
                                        <i class="fas fa-sticky-note me-2"></i> Notes
                                    </th>
                                    <th class="py-3 text-center">
                                        <i class="fas fa-cog me-2"></i> Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <tr class="border-bottom">
                                        <td>
                                            <span class="badge bg-light text-dark px-3 py-2">
                                                <i class="fas fa-calendar-day me-1"></i>
                                                <?php echo e(\Carbon\Carbon::parse($record->date)->format('M d, Y')); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?php echo e($record->project->name); ?></div>
                                            <small class="text-muted">
                                                <i class="fas fa-barcode me-1"></i>
                                                <?php echo e($record->project->project_code); ?>

                                            </small>
                                        </td>
                                        <td>
                                            <div><?php echo e($record->worker->name); ?></div>
                                            <small class="text-muted">
                                                <i class="fas fa-user-tag me-1"></i>
                                                <?php echo e($record->worker->designation ?: 'No designation'); ?>

                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($record->check_in && $record->check_out): ?>
                                                <div>
                                                    <i class="fas fa-sign-in-alt text-success me-1"></i>
                                                    <?php echo e(\Carbon\Carbon::parse($record->check_in)->format('h:i A')); ?>

                                                </div>
                                                <div>
                                                    <i class="fas fa-sign-out-alt text-danger me-1"></i>
                                                    <?php echo e(\Carbon\Carbon::parse($record->check_out)->format('h:i A')); ?>

                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">Not recorded</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-semibold">
                                                <?php echo e(number_format($record->hours_worked, 2)); ?> hrs
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($record->overtime_hours > 0): ?>
                                                <span class="badge bg-warning px-3 py-2">
                                                    <i class="fas fa-chart-line me-1"></i>
                                                    <?php echo e(number_format($record->overtime_hours, 2)); ?> hrs
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $statusColors = [
                                                    'present' => 'success',
                                                    'absent' => 'danger',
                                                    'half_day' => 'warning'
                                                ];
                                                $statusIcons = [
                                                    'present' => 'fa-check-circle',
                                                    'absent' => 'fa-times-circle',
                                                    'half_day' => 'fa-adjust'
                                                ];
                                                $color = $statusColors[$record->status] ?? 'secondary';
                                                $icon = $statusIcons[$record->status] ?? 'fa-circle';
                                            ?>
                                            <span class="badge bg-<?php echo e($color); ?> px-3 py-2">
                                                <i class="fas <?php echo e($icon); ?> me-1"></i>
                                                <?php echo e(ucfirst(str_replace('_', ' ', $record->status))); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($record->notes): ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-sticky-note me-1"></i>
                                                    <?php echo e(Str::limit($record->notes, 30)); ?>

                                                </small>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="#"
                                               wire:click.prevent="editAttendance(<?php echo e($record->id); ?>)"
                                               class="btn btn-sm btn-success"
                                               style="font-size: 12px; padding: 3px 6px; white-space: nowrap;">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                                <p class="mb-0">No attendance records found</p>
                                                <small>Start recording attendance using the form above</small>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination with Info -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($records->total() > 0): ?>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing <?php echo e($records->firstItem() ?? 0); ?> to <?php echo e($records->lastItem() ?? 0); ?>

                                of <?php echo e($records->total()); ?> records
                            </div>
                            <div>
                                <?php echo e($records->links()); ?>

                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Attendance Modal -->
    <div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-labelledby="editAttendanceModalLabel" aria-hidden="true" data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header d-flex align-items-center justify-content-between py-3"
     style="background: linear-gradient(135deg, #28c76f 70%, #fcfcfc 100%);">

    <h5 class="modal-title text-white fw-bold m-0 d-flex align-items-center"
        id="editAttendanceModalLabel"
        style="line-height: 1;">

        <i class="fas fa-edit me-2"></i>
        Edit Attendance Record
    </h5>
</div>

                <form wire:submit.prevent="updateAttendance">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-project-diagram me-1" style="color: #28c76f;"></i>
                                    Project
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['edit_project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.live="edit_project_id">
                                    <option value="">Select Project</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['edit_project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user-tie me-1" style="color: #28c76f;"></i>
                                    Worker
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['edit_worker_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.live="edit_worker_id">
                                    <option value="">Select Worker</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $editWorkers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <option value="<?php echo e($worker->id); ?>"><?php echo e($worker->name); ?> (<?php echo e($worker->designation ?: 'No designation'); ?>)</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['edit_worker_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-day me-1" style="color: #28c76f;"></i>
                                    Date
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control <?php $__errorArgs = ['edit_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       wire:model="edit_date"
                                       max="<?php echo e(now()->format('Y-m-d')); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['edit_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-clock me-1" style="color: #28c76f;"></i>
        Check In
    </label>
    <input type="time"
           class="form-control <?php $__errorArgs = ['edit_check_in'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           wire:model="edit_check_in">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['edit_check_in'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-clock me-1" style="color: #28c76f;"></i>
        Check Out
    </label>
    <input type="time"
           class="form-control <?php $__errorArgs = ['edit_check_out'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           wire:model="edit_check_out">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['edit_check_out'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<!-- STATUS FIELD in Edit Modal -->
<div class="col-md-6">
    <label class="form-label fw-semibold">
        <i class="fas fa-chart-pie me-1" style="color: #28c76f;"></i>
        Status
        <span class="text-danger">*</span>
    </label>
    <select class="form-select <?php $__errorArgs = ['edit_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.live="edit_status">
        <option value="present">Present</option>
        <option value="absent">Absent</option>
        <option value="half_day">Half Day</option>
    </select>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['edit_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<!-- HOURS WORKED FIELD in Edit Modal -->
<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-hourglass-half me-1" style="color: #28c76f;"></i>
        Hours Worked
        <span class="text-muted">(Editable)</span>
    </label>
    <div class="input-group">
        <input type="number"
               step="0.01"
               class="form-control <?php $__errorArgs = ['edit_hours_worked'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               wire:model.live="edit_hours_worked"
               placeholder="0.00">
        <span class="input-group-text bg-light">hrs</span>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['edit_hours_worked'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<div class="col-md-3">
    <label class="form-label fw-semibold">
        <i class="fas fa-chart-line me-1" style="color: #28c76f;"></i>
        Overtime Hours
    </label>
    <div class="input-group">
        <input type="number"
               step="0.01"
               class="form-control <?php $__errorArgs = ['edit_overtime_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               wire:model="edit_overtime_hours"
               placeholder="0.00">
        <span class="input-group-text bg-light">hrs</span>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['edit_overtime_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<!-- CLIENT BILLING TYPE in Edit Modal -->
<div class="col-md-6">
    <label class="form-label fw-semibold">
        <i class="fas fa-building me-1" style="color: #28c76f;"></i>
        Client Billing Type
    </label>
    <select class="form-select" wire:model="edit_client_billing_type">
        <option value="daily">Daily (Fixed 9 hours)</option>
        <option value="hourly">Hourly (Actual hours)</option>
    </select>
</div>

<!-- CLIENT HOURS in Edit Modal -->
<div class="col-md-6">
    <label class="form-label fw-semibold">
        <i class="fas fa-clock me-1" style="color: #28c76f;"></i>
        Client Hours (To Bill)
    </label>
    <div class="input-group">
        <input type="number"
               step="0.01"
               class="form-control"
               wire:model="edit_client_hours"
               placeholder="0.00">
        <span class="input-group-text bg-light">hrs</span>
    </div>
</div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-chart-pie me-1" style="color: #28c76f;"></i>
                                    Status
                                </label>
                                <select class="form-select <?php $__errorArgs = ['edit_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="edit_status">
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="half_day">Half Day</option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['edit_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-sticky-note me-1" style="color: #28c76f;"></i>
                                    Notes
                                </label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['edit_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       wire:model="edit_notes"
                                       placeholder="Optional notes about attendance...">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['edit_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                    </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <!-- Left side (Delete button) -->
                        <div>
                          <button type="button"
        class="btn btn-danger"
        wire:click="prepareDeleteConfirmation"
        data-bs-toggle="modal"
        data-bs-target="#deleteConfirmationModal">
    <i class="fas fa-trash-alt me-2"></i> Delete
</button>
                        </div>

                        <!-- Right side (Other buttons) -->
                        <div>
                            <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                    id="cancelModalBtn">
                                <i class="fas fa-times me-2"></i> Cancel
                            </button>

                            <button type="submit"
                                    class="btn btn-update-attendance"
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="fas fa-save me-2"></i> Update Attendance
                                </span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin"></i> Updating...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true" data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 70%, #ffffff 100%);">
                    <h5 class="modal-title text-white fw-bold" id="deleteConfirmationModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Confirm Delete
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                        <h5 class="mb-3">Are you sure you want to delete this attendance record?</h5>
                        <p class="text-muted mb-0">This action cannot be undone. The attendance record will be permanently removed from the system.</p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($edit_id): ?>
                            <div class="alert alert-light mt-3">
                                <strong>Record Details:</strong><br>
                                Date: <?php echo e($edit_date ? \Carbon\Carbon::parse($edit_date)->format('F d, Y') : 'N/A'); ?><br>
                                Worker: <?php echo e($edit_worker_name ?? 'N/A'); ?><br>
                                Project: <?php echo e($edit_project_name ?? 'N/A'); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
               <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clearDeleteModal">
        <i class="fas fa-times me-2"></i> Cancel
    </button>
    <button type="button" class="btn btn-danger" wire:click="deleteAttendance" wire:loading.attr="disabled">
        <span wire:loading.remove>
            <i class="fas fa-trash-alt me-2"></i> Yes, Delete
        </span>
        <span wire:loading>
            <i class="fas fa-spinner fa-spin me-2"></i> Deleting...
        </span>
    </button>
</div>
            </div>
        </div>
    </div>

    <style>
        /* Custom styling for better visual appeal */
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
        }

        .btn-light:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-update-attendance {
            background: #28c76f;
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-update-attendance:hover {
            background: #000000;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
            .btn-save-attendance {
            background: #ff0000;
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-save-attendance:hover {
            background: #000000;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        /* Add to existing styles for better visual consistency */
.input-group .btn-outline-secondary {
    border-color: #e0e0e0;
}

.input-group .btn-outline-secondary:hover {
    background-color: #f8f9fa;
    border-color: #e0e0e0;
}

.badge {
    transition: all 0.2s ease;
}

.badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-close-white {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.btn-close-white:hover {
    opacity: 1;
}

/* Better spacing for filter row */
.row.g-3 {
    margin-bottom: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
        width: 100%;
    }

    .d-flex.gap-2 .btn {
        width: 100%;
    }
}

        .btn-save-attendance:active {
            transform: translateY(0);
        }

        .btn-outline-primary {
            border-color: #ff0000;
            color: #ff0000;
        }

        .btn-outline-primary:hover {
            background-color: #ff0000;
            border-color: #ff0000;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .badge {
            font-weight: 500;
            border-radius: 0.5rem;
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
        }



        /* Status badges */
        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
            color: #000;
        }

        .bg-danger {
            background-color: #dc3545 !important;
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

        /* White text opacity for description */
        .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        /* Modal styling */
        .modal-content {
            border-radius: 1rem;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: 1px solid #e0e0e0;
        }

        /* Table responsive */
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 0.5rem;
            }

            .row.g-3 {
                flex-direction: column;
            }

            .btn-save-attendance {
                width: 100%;
            }
        }
    </style>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let modalElement = document.getElementById('editAttendanceModal');
            let deleteModalElement = document.getElementById('deleteConfirmationModal');
            let modalInstance = null;
            let deleteModalInstance = null;

            // Initialize modals when needed
            function getModalInstance() {
                if (!modalInstance && modalElement) {
                    modalInstance = new bootstrap.Modal(modalElement, {
                        backdrop: 'static',
                        keyboard: false
                    });
                }
                return modalInstance;
            }

            function getDeleteModalInstance() {
                if (!deleteModalInstance && deleteModalElement) {
                    deleteModalInstance = new bootstrap.Modal(deleteModalElement, {
                        backdrop: 'static',
                        keyboard: false
                    });
                }
                return deleteModalInstance;
            }

            // Handle opening modal
            Livewire.on('openModal', () => {
                const modal = getModalInstance();
                if (modal) {
                    modal.show();
                }
            });

            // Handle closing modal and removing backdrop
            Livewire.on('closeModal', () => {
                const modal = getModalInstance();
                if (modal) {
                    modal.hide();
                    // Force remove backdrop if it still exists
                    setTimeout(() => {
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        backdrops.forEach(backdrop => {
                            backdrop.remove();
                        });
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }, 150);
                }
            });

            // Handle delete confirmation
            Livewire.on('confirmDelete', () => {
                const deleteModal = getDeleteModalInstance();
                if (deleteModal) {
                    deleteModal.show();
                }
            });

            // Handle close delete modal
            Livewire.on('closeDeleteModal', () => {
                const deleteModal = getDeleteModalInstance();
                if (deleteModal) {
                    deleteModal.hide();
                    setTimeout(() => {
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        backdrops.forEach(backdrop => {
                            backdrop.remove();
                        });
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }, 150);
                }
            });

            // Manual close handlers for edit modal
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelModalBtn = document.getElementById('cancelModalBtn');

            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', () => {
                    const modal = getModalInstance();
                    if (modal) {
                        modal.hide();
                        setTimeout(() => {
                            const backdrops = document.querySelectorAll('.modal-backdrop');
                            backdrops.forEach(backdrop => {
                                backdrop.remove();
                            });
                            document.body.classList.remove('modal-open');
                            document.body.style.overflow = '';
                            document.body.style.paddingRight = '';
                        }, 150);
                    }
                });
            }

            if (cancelModalBtn) {
                cancelModalBtn.addEventListener('click', () => {
                    const modal = getModalInstance();
                    if (modal) {
                        modal.hide();
                        setTimeout(() => {
                            const backdrops = document.querySelectorAll('.modal-backdrop');
                            backdrops.forEach(backdrop => {
                                backdrop.remove();
                            });
                            document.body.classList.remove('modal-open');
                            document.body.style.overflow = '';
                            document.body.style.paddingRight = '';
                        }, 150);
                    }
                });
            }

            // Handle delete button click
            const deleteAttendanceBtn = document.getElementById('deleteAttendanceBtn');
            if (deleteAttendanceBtn) {
                deleteAttendanceBtn.addEventListener('click', () => {
                    // Close edit modal first
                    const modal = getModalInstance();
                    if (modal) {
                        modal.hide();
                    }
                    // Then show delete confirmation
                    setTimeout(() => {
                        Livewire.dispatch('confirmDelete');
                    }, 300);
                });
            }

            // Handle modal hidden event to clean up
            if (modalElement) {
                modalElement.addEventListener('hidden.bs.modal', function () {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    backdrops.forEach(backdrop => {
                        backdrop.remove();
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                });
            }

            if (deleteModalElement) {
                deleteModalElement.addEventListener('hidden.bs.modal', function () {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    backdrops.forEach(backdrop => {
                        backdrop.remove();
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                });
            }
        });
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/livewire/hr/attendance.blade.php ENDPATH**/ ?>