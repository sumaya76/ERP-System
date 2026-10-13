
<div>
    <div class="card shadow-sm border-0">
        <!-- Header with Red-Black Gradient Background -->
        <div class="card-header border-0 pt-4 pb-4" style="background: linear-gradient(135deg, #ff0000 0%, #000000 100%); border-radius: 1rem 1rem 0 0;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-circle text-white fs-4"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold text-white">Worker Profile Dashboard</h3>
                        <p class="text-white-50 small mb-0">View detailed worker information, attendance, and payroll history</p>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedWorker): ?>
                    <div class="d-flex gap-2">
                        <button onclick="window.print()" class="btn btn-light">
                            <i class="fas fa-print me-2"></i>
                            Print Profile
                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                            Search & Filter Worker Data
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="resetFilters">
                            <i class="fas fa-undo-alt me-1"></i> Reset All Filters
                        </button>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <form wire:submit.prevent="performSearch">
                        <div class="row g-3">
                            <!-- Worker Selection -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user-tie me-1" style="color: #ff0000;"></i>
                                    Select Worker
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <select class="form-select" wire:model="tempSelectedWorkerId">
                                        <option value="">-- Select a worker --</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <option value="<?php echo e($worker->id); ?>">
                                                <?php echo e($worker->name); ?> - <?php echo e($worker->designation ?: 'No designation'); ?>

                                            </option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempSelectedWorkerId): ?>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="clearWorkerFilter">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = Carbon\Carbon::now()->year; $i >= Carbon\Carbon::now()->year - 3; $i--): ?>
                                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Month Filter -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-chart-line me-1" style="color: #ff0000;"></i>
                                    Month View
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <select class="form-select" wire:model="tempSelectedMonth">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <option value="<?php echo e($num); ?>"><?php echo e($name); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Search Actions -->
                            <div class="col-md-12">
                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4" style="background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%); border: none;">
                                        <i class="fas fa-search me-2"></i> Search Worker
                                    </button>
                                    <button type="button" class="btn btn-secondary px-4" wire:click="resetFilters">
                                        <i class="fas fa-undo-alt me-2"></i> Clear All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Active Filters Display -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isSearching && $selectedWorkerId): ?>
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <small class="text-muted me-2">
                                    <i class="fas fa-filter me-1"></i>Active filters:
                                </small>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedWorkerId && $selectedWorker): ?>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-user me-1"></i>
                                        Worker: <?php echo e($selectedWorker->name); ?>

                                        <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="clearWorkerFilter"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedYear): ?>
                                    <span class="badge bg-info">
                                        <i class="fas fa-calendar me-1"></i>
                                        Year: <?php echo e($selectedYear); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedMonth): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Month: <?php echo e($months[$selectedMonth]); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedWorker): ?>
                <div id="print-area">
                    <!-- Personal Information Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-id-card me-2" style="color: #ff0000;"></i>
                                Personal Information
                            </h6>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Full Name</label>
                                    <div class="fw-bold fs-5"><?php echo e($selectedWorker->name); ?></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Email Address</label>
                                    <div><?php echo e($selectedWorker->email); ?></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Phone Number</label>
                                    <div><?php echo e($selectedWorker->phone ?: 'Not provided'); ?></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Alternate Phone</label>
                                    <div><?php echo e($selectedWorker->alternate_phone ?: 'Not provided'); ?></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Date of Birth</label>
                                    <div><?php echo e($selectedWorker->dob ? Carbon\Carbon::parse($selectedWorker->dob)->format('M d, Y') : 'Not provided'); ?></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">National ID</label>
                                    <div><?php echo e($selectedWorker->national_id ?: 'Not provided'); ?></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Blood Group</label>
                                    <div><?php echo e($selectedWorker->blood_group ?: 'Not provided'); ?></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Date of Joining</label>
                                    <div><?php echo e($selectedWorker->date_of_joining ? Carbon\Carbon::parse($selectedWorker->date_of_joining)->format('M d, Y') : 'Not provided'); ?></div>
                                </div>
                                <div class="col-md-12">
                                    <label class="text-muted small text-uppercase fw-semibold">Address</label>
                                    <div><?php echo e($selectedWorker->address ?: 'Not provided'); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedWorker->city || $selectedWorker->state || $selectedWorker->zip): ?>
                                        <div><?php echo e($selectedWorker->city); ?>, <?php echo e($selectedWorker->state); ?> <?php echo e($selectedWorker->zip); ?> <?php echo e($selectedWorker->country); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-briefcase me-2" style="color: #ff0000;"></i>
                                Employment Information
                            </h6>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Department</label>
                                    <div class="fw-bold"><?php echo e($selectedWorker->department ?: 'Not assigned'); ?></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Designation</label>
                                    <div class="fw-bold"><?php echo e($selectedWorker->designation ?: 'Not assigned'); ?></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Rate Type</label>
                                    <div><span class="badge bg-info"><?php echo e(ucfirst($selectedWorker->rate_type)); ?></span></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Rate Amount</label>
                                    <div class="fw-bold text-success fs-5">€ <?php echo e(number_format($selectedWorker->rate, 2)); ?></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Hourly Rate</label>
                                    <div>€ <?php echo e(number_format($selectedWorker->hourly_rate, 2)); ?>/hr</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Daily Rate</label>
                                    <div>€ <?php echo e(number_format($selectedWorker->daily_rate, 2)); ?>/day</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Monthly Rate</label>
                                    <div>€ <?php echo e(number_format($selectedWorker->monthly_rate, 2)); ?>/month</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small text-uppercase fw-semibold">Status</label>
                                    <div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedWorker->status == 'active'): ?>
                                            <span class="badge bg-success px-3 py-2">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger px-3 py-2">Inactive</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-ambulance me-2" style="color: #ff0000;"></i>
                                Emergency Contact
                            </h6>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-semibold">Contact Name</label>
                                    <div class="fw-bold"><?php echo e($selectedWorker->emergency_contact_name ?: 'Not provided'); ?></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-semibold">Contact Phone</label>
                                    <div><?php echo e($selectedWorker->emergency_contact_phone ?: 'Not provided'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards Row -->
                    <div class="row mb-4 g-3">
                        <div class="col-md-3">
                            <div class="stat-card-mini" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="stat-card-mini-content">
                                    <div>
                                        <small class="text-white-50">Total Hours (<?php echo e($selectedYear); ?>)</small>
                                        <h3 class="mb-0 fw-bold text-white"><?php echo e(number_format($totalHours, 2)); ?></h3>
                                        <small class="text-white-50">Including <?php echo e(number_format($totalOvertime, 2)); ?> overtime</small>
                                    </div>
                                    <i class="fas fa-clock fa-2x opacity-50 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card-mini" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                <div class="stat-card-mini-content">
                                    <div>
                                        <small class="text-white-50">Days Worked (<?php echo e($selectedYear); ?>)</small>
                                        <h3 class="mb-0 fw-bold text-white"><?php echo e(number_format($totalDaysWorked)); ?></h3>
                                        <small class="text-white-50">Attendance records</small>
                                    </div>
                                    <i class="fas fa-calendar-check fa-2x opacity-50 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card-mini" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <div class="stat-card-mini-content">
                                    <div>
                                        <small class="text-white-50">Total Earnings (<?php echo e($selectedYear); ?>)</small>
                                        <h3 class="mb-0 fw-bold text-white">€ <?php echo e(number_format($totalEarnings, 2)); ?></h3>
                                        <small class="text-white-50">Net amount after advances</small>
                                    </div>
                                    <i class="fas fa-euro-sign fa-2x opacity-50 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card-mini" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <div class="stat-card-mini-content">
                                    <div>
                                        <small class="text-white-50">Pending Advances</small>
                                        <h3 class="mb-0 fw-bold text-white">€ <?php echo e(number_format($pendingAdvances, 2)); ?></h3>
                                        <small class="text-white-50">Total: € <?php echo e(number_format($totalAdvances, 2)); ?></small>
                                    </div>
                                    <i class="fas fa-hand-holding-usd fa-2x opacity-50 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Attendance Summary -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-calendar-alt me-2" style="color: #ff0000;"></i>
                                Monthly Attendance Summary - <?php echo e($selectedYear); ?>

                            </h6>
                        </div>
                        <div class="card-body p-0 pt-2">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-sec">
                                        <tr>
                                            <th class="py-3 ps-4"><i class="fas fa-calendar me-2" ></i>Month</th>
                                            <th class="py-3 text-center"><i class="fas fa-calendar-check me-2" ></i>Days Worked</th>
                                            <th class="py-3 text-end"><i class="fas fa-clock me-2" ></i>Regular Hours</th>
                                            <th class="py-3 text-end"><i class="fas fa-chart-line me-2" ></i>Overtime Hours</th>
                                            <th class="py-3 text-end pe-4"><i class="fas fa-hourglass-half me-2" ></i>Total Hours</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <?php $monthData = $monthlyAttendance[$num] ?? null; ?>
                                            <tr class="border-bottom">
                                                <td class="ps-4 fw-bold"><?php echo e($name); ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-info px-3 py-2">
                                                        <?php echo e($monthData ? $monthData['days_worked'] : 0); ?>

                                                    </span>
                                                </td>
                                                <td class="text-end"><?php echo e($monthData ? number_format($monthData['regular_hours'], 2) : 0); ?></td>
                                                <td class="text-end text-warning"><?php echo e($monthData ? number_format($monthData['total_overtime'], 2) : 0); ?></td>
                                                <td class="text-end pe-4 fw-semibold"><?php echo e($monthData ? number_format($monthData['total_hours'], 2) : 0); ?></td>
                                            </tr>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr class="fw-bold">
                                            <td class="py-3 ps-4">TOTAL</td>
                                            <td class="text-center py-3"><?php echo e(number_format($totalDaysWorked)); ?></td>
                                            <td class="text-end py-3"><?php echo e(number_format($totalHours - $totalOvertime, 2)); ?></td>
                                            <td class="text-end py-3"><?php echo e(number_format($totalOvertime, 2)); ?></td>
                                            <td class="text-end pe-4 py-3"><?php echo e(number_format($totalHours, 2)); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Payroll History -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-file-invoice-dollar me-2" style="color: #ff0000;"></i>
                                Payroll History
                            </h6>
                        </div>
                        <div class="card-body p-0 pt-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($payrollHistory) > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-sec">
                                            <tr>
                                                <th class="py-3 ps-4"><i class="fas fa-calendar-alt me-2" ></i>Period</th>
                                                <th class="py-3 text-end"><i class="fas fa-clock me-2" ></i>Total Hours</th>
                                                <th class="py-3 text-end"><i class="fas fa-chart-line me-2" ></i>Gross Amount</th>
                                                <th class="py-3 text-end"><i class="fas fa-hand-holding-usd me-2" ></i>Advance Deduction</th>
                                                <th class="py-3 text-end"><i class="fas fa-euro-sign me-2" ></i>Net Amount</th>
                                                <th class="py-3"><i class="fas fa-project-diagram me-2" ></i>Projects</th>
                                                <th class="py-3 pe-4"><i class="fas fa-calendar me-2" ></i>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $payrollHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <tr class="border-bottom">
                                                    <td class="ps-4">
                                                        <span class="fw-bold"><?php echo e($payroll['month_name']); ?> <?php echo e($payroll['year']); ?></span>
                                                    </td>
                                                    <td class="text-end"><?php echo e(number_format($payroll['total_hours'], 2)); ?> hrs</td>
                                                    <td class="text-end">€ <?php echo e(number_format($payroll['gross_amount'], 2)); ?></td>
                                                    <td class="text-end text-danger">-€ <?php echo e(number_format($payroll['advance_deduction'], 2)); ?></td>
                                                    <td class="text-end fw-bold text-success">€ <?php echo e(number_format($payroll['net_amount'], 2)); ?></td>
                                                    <td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $payroll['project_breakdown']->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breakdown): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                            <div class="small">
                                                                <i class="fas fa-project-diagram text-muted me-1"></i>
                                                                <?php echo e($breakdown->project->name); ?> (<?php echo e(number_format($breakdown->hours, 1)); ?> hrs)
                                                            </div>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payroll['project_breakdown']->count() > 2): ?>
                                                            <small class="text-muted">+<?php echo e($payroll['project_breakdown']->count() - 2); ?> more</small>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td class="pe-4"><small><?php echo e($payroll['created_at']->format('M d, Y')); ?></small></td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </tbody>
                                        <tfoot class="bg-light">
                                            <tr class="fw-bold">
                                                <td class="py-3 ps-4">TOTAL</td>
                                                <td class="text-end py-3"><?php echo e(number_format(collect($payrollHistory)->sum('total_hours'), 2)); ?> hrs</td>
                                                <td class="text-end py-3">€ <?php echo e(number_format(collect($payrollHistory)->sum('gross_amount'), 2)); ?></td>
                                                <td class="text-end py-3">-€ <?php echo e(number_format(collect($payrollHistory)->sum('advance_deduction'), 2)); ?></td>
                                                <td class="text-end py-3">€ <?php echo e(number_format(collect($payrollHistory)->sum('net_amount'), 2)); ?></td>
                                                <td colspan="2" class="pe-4"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-file-invoice fa-3x mb-3 opacity-50"></i>
                                        <p class="mb-0">No payroll records found for this worker</p>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <!-- Advance History -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-hand-holding-usd me-2" style="color: #ff0000;"></i>
                                Advance History
                            </h6>
                        </div>
                        <div class="card-body p-0 pt-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($advanceHistory->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-sec">
                                            <tr>
                                                <th class="py-3 ps-4"><i class="fas fa-calendar me-2" ></i>Date</th>
                                                <th class="py-3 text-end"><i class="fas fa-euro-sign me-2" ></i>Amount</th>
                                                <th class="py-3 text-end"><i class="fas fa-chart-line me-2" ></i>Remaining</th>
                                                <th class="py-3"><i class="fas fa-info-circle me-2" ></i>Status</th>
                                                <th class="py-3 pe-4"><i class="fas fa-sticky-note me-2" ></i>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $advanceHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <tr class="border-bottom">
                                                    <td class="ps-4"><?php echo e($advance->advance_date->format('M d, Y')); ?></td>
                                                    <td class="text-end fw-bold">€ <?php echo e(number_format($advance->amount, 2)); ?></td>
                                                    <td class="text-end">€ <?php echo e(number_format($advance->remaining_amount, 2)); ?></td>
                                                    <td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($advance->status == 'paid'): ?>
                                                            <span class="badge bg-success px-3 py-2">Paid</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning px-3 py-2">Pending</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td class="pe-4"><?php echo e($advance->notes ?: '-'); ?></td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </tbody>
                                        <tfoot class="bg-light">
                                            <tr class="fw-bold">
                                                <td class="py-3 ps-4">TOTAL</td>
                                                <td class="text-end py-3">€ <?php echo e(number_format($totalAdvances, 2)); ?></td>
                                                <td class="text-end py-3">€ <?php echo e(number_format($pendingAdvances, 2)); ?></td>
                                                <td colspan="2" class="pe-4"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-hand-holding-usd fa-3x mb-3 opacity-50"></i>
                                        <p class="mb-0">No advance records found for this worker</p>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <!-- Project History -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0 py-3">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-project-diagram me-2" style="color: #ff0000;"></i>
                                Project History
                            </h6>
                        </div>
                        <div class="card-body p-0 pt-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($projectHistory->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-sec">
                                            <tr>
                                                <th class="py-3 ps-4"><i class="fas fa-tag me-2" ></i>Project Name</th>
                                                <th class="py-3"><i class="fas fa-code-branch me-2" ></i>Project Code</th>
                                                <th class="py-3"><i class="fas fa-calendar-plus me-2" ></i>Assigned Date</th>
                                                <th class="py-3"><i class="fas fa-calendar-times me-2" ></i>Release Date</th>
                                                <th class="py-3 pe-4"><i class="fas fa-chart-simple me-2" ></i>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projectHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <tr class="border-bottom">
                                                    <td class="ps-4 fw-bold"><?php echo e($project->name); ?></td>
                                                    <td><span class="badge bg-light text-dark"><?php echo e($project->project_code); ?></span></td>
                                                    <td><?php echo e($project->pivot->assigned_date ? Carbon\Carbon::parse($project->pivot->assigned_date)->format('M d, Y') : '-'); ?></td>
                                                    <td><?php echo e($project->pivot->release_date ? Carbon\Carbon::parse($project->pivot->release_date)->format('M d, Y') : 'Current'); ?></td>
                                                    <td class="pe-4">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($project->pivot->status == 'active'): ?>
                                                            <span class="badge bg-success px-3 py-2">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary px-3 py-2">Released</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-project-diagram fa-3x mb-3 opacity-50"></i>
                                        <p class="mb-0">No projects assigned to this worker</p>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- No Worker Selected -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-user-circle fa-5x mb-3 opacity-50"></i>
                            <h5 class="mb-2">Select a Worker to View Profile</h5>
                            <p class="mb-0">Choose a worker from the filters above and click "Search Worker" to see their complete profile</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        let attendanceChart = null;
        
        function renderAttendanceChart() {
            const ctx = document.getElementById('attendanceChart');
            if (!ctx) return;
            
            const labels = <?php echo json_encode($chartData['labels'] ?? []); ?>;
            const hours = <?php echo json_encode($chartData['hours'] ?? []); ?>;
            const overtime = <?php echo json_encode($chartData['overtime'] ?? []); ?>;
            const earnings = <?php echo json_encode($chartData['earnings'] ?? []); ?>;
            
            if (attendanceChart) {
                attendanceChart.destroy();
            }
            
            attendanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Regular Hours',
                            data: hours.map((h, i) => h - overtime[i]),
                            backgroundColor: 'rgba(255, 0, 0, 0.7)',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 1,
                            borderRadius: 5
                        },
                        {
                            label: 'Overtime Hours',
                            data: overtime,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            borderRadius: 5
                        },
                        {
                            label: 'Earnings (€)',
                            data: earnings,
                            type: 'line',
                            backgroundColor: 'transparent',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            tension: 0.4,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.dataset.label === 'Earnings (€)') {
                                        label += '€ ' + context.raw.toLocaleString('en-US', {minimumFractionDigits: 2});
                                    } else {
                                        label += context.raw.toLocaleString('en-US', {minimumFractionDigits: 1}) + ' hrs';
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Hours',
                                font: { weight: 'bold' }
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + ' hrs';
                                }
                            }
                        },
                        y1: {
                            position: 'right',
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Earnings (€)',
                                font: { weight: 'bold' }
                            },
                            ticks: {
                                callback: function(value) {
                                    return '€ ' + value.toLocaleString();
                                }
                            },
                            grid: {
                                drawOnChartArea: false,
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month',
                                font: { weight: 'bold' }
                            }
                        }
                    }
                }
            });
        }
        
        document.addEventListener('livewire:load', function () {
            setTimeout(renderAttendanceChart, 100);
        });
        
        document.addEventListener('livewire:updated', function () {
            setTimeout(renderAttendanceChart, 100);
        });
        
        const printStyle = document.createElement('style');
        printStyle.textContent = `
            @media print {
                .btn, .form-select, .card-header .btn, .navbar, .sidebar, .footer, .modal-modern-overlay {
                    display: none !important;
                }
                .card {
                    break-inside: avoid;
                    page-break-inside: avoid;
                    border: 1px solid #ddd !important;
                    margin-bottom: 20px !important;
                }
                body {
                    padding: 20px !important;
                }
                .stat-card-mini {
                    background: #f8f9fa !important;
                    color: #000 !important;
                    border: 1px solid #ddd !important;
                }
                .text-white, .text-white-50 {
                    color: #000 !important;
                }
                canvas {
                    max-height: 300px !important;
                }
                @page {
                    size: A4;
                    margin: 1.5cm;
                }
            }
        `;
        document.head.appendChild(printStyle);
    </script>

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
        
        .btn-secondary {
            background: #6c757d;
            border: none;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }
         .bg-sec {
            background-color: #f8f9fa !important;
        }
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
            
            .stat-card-mini-content {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
        }
    </style>
</div><?php /**PATH C:\xampp\htdocs\ERP-System\resources\views\livewire\admin\worker-profile.blade.php ENDPATH**/ ?>