
<div>
    <div class="card shadow-sm border-0">
        <!-- Header with Red-Black Gradient Background -->
        <div class="card-header border-0 pt-4 pb-4" style="background: linear-gradient(135deg, #ff0000 0%, #000000 100%); border-radius: 1rem 1rem 0 0;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-users text-white fs-4"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold text-white">Manage Workers</h3>
                        <p class="text-white-50 small mb-0">View and manage all your workforce members</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('hr.worker.edit', 0)); ?>" class="btn btn-light">
                        <i class="fas fa-plus-circle me-2"></i>
                        Add New Worker
                    </a>
                </div>
            </div>
        </div>

        <div class="">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('message')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="card-body border-bottom bg-light">
                <form wire:submit="importWorkers">
                    <div class="row align-items-end g-3">
                        <div class="col-lg-5">
                            <label for="worker-csv" class="form-label fw-semibold">Bulk Import Workers (CSV)</label>
                            <input id="worker-csv" type="file" class="form-control bg-white" style="max-width: 360px;" accept=".csv,.txt" aria-describedby="worker-csv-help" wire:model="workerCsv">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['workerCsv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-lg-7 d-flex flex-wrap justify-content-lg-end gap-2">
                            <button type="button" wire:click="downloadWorkerCsvTemplate" class="btn btn-outline-secondary">
                                <i class="fas fa-download me-1"></i> Download CSV Template
                            </button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="importWorkers">
                                <span wire:loading.remove wire:target="importWorkers">
                                    <i class="fas fa-upload me-1"></i> Import Workers
                                </span>
                                <span wire:loading wire:target="importWorkers">
                                    <i class="fas fa-spinner fa-spin me-1"></i> Importing...
                                </span>
                            </button>
                            <span wire:loading wire:target="workerCsv" class="text-muted align-self-center">Uploading CSV...</span>
                        </div>
                    </div>
                    <small id="worker-csv-help" class="d-block text-muted mt-2">
                        Required: name, email, phone, national_id, rate, rate_type.
                        Dates: YYYY-MM-DD. Rate type: hourly, daily, or monthly.
                        Status defaults to active. Maximum 1,000 workers per upload.
                    </small>
                </form>
            </div>

            <!-- Search and Filters Section -->
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-search me-1" style="color: #ff0000;"></i>
                            Search Workers
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   placeholder="Search by name, email, phone, department..."
                                   wire:model="tempSearch">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempSearch): ?>
                                <button wire:click="clearSearch" class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Searches: Name, Email, Phone, National ID, Department, Designation
                        </small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-chart-pie me-1" style="color: #ff0000;"></i>
                            Filter by Status
                        </label>
                        <div class="input-group">
                            <select class="form-select" wire:model="tempStatusFilter">
                                <option value="">All Statuses</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="terminated">Terminated</option>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempStatusFilter): ?>
                                <button wire:click="clearStatusFilter" class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-building me-1" style="color: #ff0000;"></i>
                            Filter by Department
                        </label>
                        <div class="input-group">
                            <select class="form-select" wire:model="tempDepartmentFilter">
                                <option value="">All Departments</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($dept); ?>"><?php echo e($dept); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempDepartmentFilter): ?>
                                <button wire:click="clearDepartmentFilter" class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-2">
    <label class="form-label fw-semibold invisible" style="visibility: hidden;">
        <i class="fas fa- me-1" style="color: #ff0000;"></i>
        Action
    </label>
    <div class="d-flex gap-2 w-100">
        <button wire:click="performSearch" class="btn btn-primary flex-grow-1">
            <i class="fas fa-search me-2"></i> Search
        </button>
        <button wire:click="resetFilters" class="btn btn-secondary">
            <i class="fas fa-undo-alt me-1"></i>
        </button>
    </div>
</div>
                </div>

                <!-- Active Filters Display -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $statusFilter || $departmentFilter): ?>
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <small class="text-muted me-2">
                                <i class="fas fa-filter me-1"></i>Active filters:
                            </small>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                                <span class="badge bg-primary">
                                    <i class="fas fa-search me-1"></i>
                                    Search: <?php echo e($search); ?>

                                    <button wire:click="clearSearch" class="btn-close btn-close-white ms-2" style="font-size: 8px;"></button>
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($statusFilter): ?>
                                <span class="badge bg-info">
                                    <i class="fas fa-chart-pie me-1"></i>
                                    Status: <?php echo e(ucfirst($statusFilter)); ?>

                                    <button wire:click="clearStatusFilter" class="btn-close btn-close-white ms-2" style="font-size: 8px;"></button>
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($departmentFilter): ?>
                                <span class="badge bg-success">
                                    <i class="fas fa-building me-1"></i>
                                    Department: <?php echo e($departmentFilter); ?>

                                    <button wire:click="clearDepartmentFilter" class="btn-close btn-close-white ms-2" style="font-size: 8px;"></button>
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Workers Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3">
                                <i class="fas fa-id-card me-2"></i> ID
                            </th>
                            <th class="py-3">
                                <i class="fas fa-user me-2"></i> Worker Details
                            </th>
                            <th class="py-3">
                                <i class="fas fa-phone me-2"></i> Contact
                            </th>
                            <th class="py-3">
                                <i class="fas fa-briefcase me-2"></i> Employment
                            </th>
                            <th class="py-3">
                                <i class="fas fa-dollar-sign me-2"></i> Rate
                            </th>
                            <th class="py-3">
                                <i class="fas fa-chart-pie me-2"></i> Status
                            </th>
                            <th class="py-3">
                                <i class="fas fa-calendar-alt me-2"></i> Joining Date
                            </th>
                            <th class="py-3 text-center">
                                <i class="fas fa-cog me-2"></i> Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr class="border-bottom">
                                <td>
                                    <span class="badge bg-light text-dark px-3 py-2">
                                        <?php echo e($worker->id); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold"><?php echo e($worker->name); ?></div>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i>
                                        <?php echo e($worker->email); ?>

                                    </small>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($worker->national_id): ?>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-id-card me-1"></i>
                                            <?php echo e($worker->national_id); ?>

                                        </small>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($worker->blood_group): ?>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-tint me-1"></i>
                                            Blood: <?php echo e($worker->blood_group); ?>

                                        </small>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-phone-alt me-1 text-muted"></i>
                                        <?php echo e($worker->phone ?: 'Not provided'); ?>

                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($worker->alternate_phone): ?>
                                        <small class="text-muted">
                                            <i class="fas fa-phone me-1"></i>
                                            Alt: <?php echo e($worker->alternate_phone); ?>

                                        </small>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($worker->address): ?>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            <?php echo e(Str::limit($worker->address, 40)); ?>

                                        </small>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-building me-1 text-muted"></i>
                                        <?php echo e($worker->department ?: 'Not assigned'); ?>

                                    </div>
                                    <div>
                                        <i class="fas fa-user-tag me-1 text-muted"></i>
                                        <?php echo e($worker->designation ?: 'Not assigned'); ?>

                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($worker->date_of_joining): ?>
                                        <div>
                                            <i class="fas fa-calendar-check me-1 text-muted"></i>
                                            Joined: <?php echo e(\Carbon\Carbon::parse($worker->date_of_joining)->format('d M, Y')); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($worker->rate && $worker->rate_type): ?>
                                        <div class="fw-semibold text-success">
                                            € <?php echo e(number_format($worker->rate, 2)); ?>

                                            <small class="text-muted">/<?php echo e($worker->rate_type); ?></small>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Not set</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $statusColors = [
                                            'active' => 'success',
                                            'inactive' => 'warning',
                                            'terminated' => 'danger'
                                        ];
                                        $statusIcons = [
                                            'active' => 'fa-check-circle',
                                            'inactive' => 'fa-pause-circle',
                                            'terminated' => 'fa-times-circle'
                                        ];
                                        $color = $statusColors[$worker->status] ?? 'secondary';
                                        $icon = $statusIcons[$worker->status] ?? 'fa-circle';
                                    ?>
                                    <span class="badge bg-<?php echo e($color); ?> px-3 py-2">
                                        <i class="fas <?php echo e($icon); ?> me-1"></i>
                                        <?php echo e(ucfirst($worker->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-calendar-day text-muted me-1"></i>
                                        <small><?php echo e($worker->date_of_joining ? \Carbon\Carbon::parse($worker->date_of_joining)->format('d M, Y') : 'Not set'); ?></small>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($worker->dob): ?>
                                        <div>
                                            <i class="fas fa-birthday-cake text-muted me-1"></i>
                                            <small>DOB: <?php echo e(\Carbon\Carbon::parse($worker->dob)->format('d M, Y')); ?></small>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button wire:click="viewDetails(<?php echo e($worker->id); ?>)"
                                                class="btn btn-sm btn-info"
                                                data-bs-toggle="tooltip"
                                                title="View Details"
                                                style="font-size: 12px; padding: 3px 6px; white-space: nowrap;">
                                            <i class="fas fa-eye me-1"></i> Details
                                        </button>

                                        <a href="<?php echo e(route('hr.worker.edit', $worker->id)); ?>"
                                           class="btn btn-sm btn-success"
                                           style="font-size: 12px; padding: 3px 6px; white-space: nowrap;">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>

                                        <button wire:click="confirmDelete(<?php echo e($worker->id); ?>)"
                                                class="btn btn-sm btn-danger"
                                                data-bs-toggle="tooltip"
                                                title="Delete Worker"
                                                style="font-size: 12px; padding: 3px 6px; white-space: nowrap;">
                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
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

            <!-- Pagination with Info -->
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
        </div>
    </div>

    <!-- Worker Details Modal - Enhanced Layout -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDetailsModal && $selectedWorker): ?>
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 70%, #ffffff 100%); color: white;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="modal-title text-white fw-bold mb-0"><?php echo e($selectedWorker->name); ?></h5>
                                <small class="opacity-75">Worker ID: #<?php echo e($selectedWorker->id); ?></small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-black" wire:click="closeDetailsModal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="container-fluid">
                            <!-- Profile Summary Cards -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-3">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body text-center p-3">
                                            <i class="fas fa-envelope fs-4 mb-2" style="color: #17a2b8;"></i>
                                            <div class="small text-muted">Email</div>
                                            <div class="fw-semibold"><?php echo e($selectedWorker->email); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body text-center p-3">
                                            <i class="fas fa-phone fs-4 mb-2" style="color: #17a2b8;"></i>
                                            <div class="small text-muted">Phone</div>
                                            <div class="fw-semibold"><?php echo e($selectedWorker->phone ?: 'Not provided'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body text-center p-3">
                                            <i class="fas fa-briefcase fs-4 mb-2" style="color: #17a2b8;"></i>
                                            <div class="small text-muted">Department</div>
                                            <div class="fw-semibold"><?php echo e($selectedWorker->department ?: 'Not assigned'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body text-center p-3">
                                            <i class="fas fa-chart-line fs-4 mb-2" style="color: #17a2b8;"></i>
                                            <div class="small text-muted">Status</div>
                                            <div class="fw-semibold">
                                                <?php
                                                    $statusColors = [
                                                        'active' => 'success',
                                                        'inactive' => 'warning',
                                                        'terminated' => 'danger'
                                                    ];
                                                    $color = $statusColors[$selectedWorker->status] ?? 'secondary';
                                                ?>
                                                <span class="badge bg-<?php echo e($color); ?>">
                                                    <?php echo e(ucfirst($selectedWorker->status)); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                        <i class="fas fa-id-card fs-5 me-2" style="color: #17a2b8;"></i>
                                        <h6 class="fw-bold mb-0">Personal Information</h6>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Full Name</div>
                                        <div class="fw-semibold fs-5"><?php echo e($selectedWorker->name); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Date of Birth</div>
                                        <div class="fw-semibold"><?php echo e($selectedWorker->dob ? \Carbon\Carbon::parse($selectedWorker->dob)->format('d F, Y') : 'Not provided'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Blood Group</div>
                                        <div class="fw-semibold"><?php echo e($selectedWorker->blood_group ?: 'Not provided'); ?></div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="info-card p-3 border rounded-3">
                                        <div class="small text-muted text-uppercase mb-1">National ID</div>
                                        <div class="fw-semibold"><?php echo e($selectedWorker->national_id ?: 'Not provided'); ?></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Medical Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                        <i class="fas fa-notes-medical fs-5 me-2" style="color: #17a2b8;"></i>
                                        <h6 class="fw-bold mb-0">Medical Information</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Issue Date</div>
                                        <div class="fw-semibold">
                                            <i class="fas fa-calendar-plus me-2 text-muted"></i>
                                            <?php echo e($selectedWorker->medical_issue_date ? \Carbon\Carbon::parse($selectedWorker->medical_issue_date)->format('d F, Y') : 'Not provided'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Expiry Date</div>
                                        <div class="fw-semibold">
                                            <i class="fas fa-calendar-times me-2 text-muted"></i>
                                            <?php echo e($selectedWorker->medical_expiry_date ? \Carbon\Carbon::parse($selectedWorker->medical_expiry_date)->format('d F, Y') : 'Not provided'); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedWorker->medical_expiry_date): ?>
                                                <?php
                                                    $expiryDate = \Carbon\Carbon::parse($selectedWorker->medical_expiry_date);
                                                    $isExpired = $expiryDate->isPast();
                                                    $daysLeft = now()->diffInDays($expiryDate, false);
                                                ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isExpired): ?>
                                                    <span class="badge bg-danger ms-2">Expired</span>
                                                <?php elseif($daysLeft <= 30): ?>
                                                    <span class="badge bg-warning ms-2">Expires in <?php echo e($daysLeft); ?> days</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success ms-2">Valid</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact & Address Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                        <i class="fas fa-address-book fs-5 me-2" style="color: #17a2b8;"></i>
                                        <h6 class="fw-bold mb-0">Contact Information</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Phone Numbers</div>
                                        <div class="mb-2">
                                            <i class="fas fa-phone-alt me-2 text-muted"></i>
                                            <strong>Primary:</strong> <?php echo e($selectedWorker->phone ?: 'Not provided'); ?>

                                        </div>
                                        <div>
                                            <i class="fas fa-phone me-2 text-muted"></i>
                                            <strong>Alternate:</strong> <?php echo e($selectedWorker->alternate_phone ?: 'Not provided'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Address</div>
                                        <div class="mb-2">
                                            <i class="fas fa-home me-2 text-muted"></i>
                                            <strong>Street:</strong> <?php echo e($selectedWorker->address ?: 'Not provided'); ?>

                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-city me-2 text-muted"></i>
                                            <strong>City:</strong> <?php echo e($selectedWorker->city ?: 'Not provided'); ?>

                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-globe me-2 text-muted"></i>
                                            <strong>State/Province:</strong> <?php echo e($selectedWorker->state ?: 'Not provided'); ?>

                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-mail-bulk me-2 text-muted"></i>
                                            <strong>ZIP/Postal Code:</strong> <?php echo e($selectedWorker->zip ?: 'Not provided'); ?>

                                        </div>
                                        <div>
                                            <i class="fas fa-flag me-2 text-muted"></i>
                                            <strong>Country:</strong> <?php echo e($selectedWorker->country ?: 'Not provided'); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Details -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                        <i class="fas fa-briefcase fs-5 me-2" style="color: #17a2b8;"></i>
                                        <h6 class="fw-bold mb-0">Employment Details</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Department</div>
                                        <div class="fw-semibold"><?php echo e($selectedWorker->department ?: 'Not assigned'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Designation</div>
                                        <div class="fw-semibold"><?php echo e($selectedWorker->designation ?: 'Not assigned'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Rate Type</div>
                                        <div class="fw-semibold text-capitalize"><?php echo e($selectedWorker->rate_type ?: 'Not set'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-card p-3 border rounded-3 h-100">
                                        <div class="small text-muted text-uppercase mb-1">Rate Amount</div>
                                        <div class="fw-semibold text-success">
                                            <?php echo e($selectedWorker->rate ? '€ ' . number_format($selectedWorker->rate, 2) : 'Not set'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-card p-3 border rounded-3">
                                        <div class="small text-muted text-uppercase mb-1">Date of Joining</div>
                                        <div class="fw-semibold">
                                            <i class="fas fa-calendar-check me-2 text-muted"></i>
                                            <?php echo e($selectedWorker->date_of_joining ? \Carbon\Carbon::parse($selectedWorker->date_of_joining)->format('d F, Y') : 'Not set'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-card p-3 border rounded-3">
                                        <div class="small text-muted text-uppercase mb-1">Employment Status</div>
                                        <div class="fw-semibold">
                                            <?php
                                                $statusColors = [
                                                    'active' => 'success',
                                                    'inactive' => 'warning',
                                                    'terminated' => 'danger'
                                                ];
                                                $statusIcons = [
                                                    'active' => 'fa-check-circle',
                                                    'inactive' => 'fa-pause-circle',
                                                    'terminated' => 'fa-times-circle'
                                                ];
                                                $color = $statusColors[$selectedWorker->status] ?? 'secondary';
                                                $icon = $statusIcons[$selectedWorker->status] ?? 'fa-circle';
                                            ?>
                                            <span class="badge bg-<?php echo e($color); ?> fs-6 px-3 py-2">
                                                <i class="fas <?php echo e($icon); ?> me-2"></i>
                                                <?php echo e(ucfirst($selectedWorker->status)); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Emergency Contact -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                        <i class="fas fa-ambulance fs-5 me-2" style="color: #17a2b8;"></i>
                                        <h6 class="fw-bold mb-0">Emergency Contact</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-card p-3 border rounded-3">
                                        <div class="small text-muted text-uppercase mb-1">Contact Person</div>
                                        <div class="fw-semibold">
                                            <i class="fas fa-user me-2 text-muted"></i>
                                            <?php echo e($selectedWorker->emergency_contact_name ?: 'Not provided'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-card p-3 border rounded-3">
                                        <div class="small text-muted text-uppercase mb-1">Contact Number</div>
                                        <div class="fw-semibold">
                                            <i class="fas fa-phone-alt me-2 text-muted"></i>
                                            <?php echo e($selectedWorker->emergency_contact_phone ?: 'Not provided'); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- System Information -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                        <i class="fas fa-clock fs-5 me-2" style="color: #17a2b8;"></i>
                                        <h6 class="fw-bold mb-0">System Information</h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card p-3 border rounded-3">
                                        <div class="small text-muted text-uppercase mb-1">Created At</div>
                                        <div>
                                            <i class="fas fa-calendar-plus me-2 text-muted"></i>
                                            <?php echo e($selectedWorker->created_at ? \Carbon\Carbon::parse($selectedWorker->created_at)->format('d F, Y h:i A') : 'Not available'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card p-3 border rounded-3">
                                        <div class="small text-muted text-uppercase mb-1">Last Updated</div>
                                        <div>
                                            <i class="fas fa-edit me-2 text-muted"></i>
                                            <?php echo e($selectedWorker->updated_at ? \Carbon\Carbon::parse($selectedWorker->updated_at)->format('d F, Y h:i A') : 'Not available'); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="closeDetailsModal">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                        <a href="<?php echo e(route('hr.worker.edit', $selectedWorker->id)); ?>" class="btn btn-success">
                            <i class="fas fa-edit me-1"></i> Edit Worker
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Delete Confirmation Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($confirmingDelete): ?>
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-exclamation-triangle text-white me-2"></i>
                            Confirm Delete
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('confirmingDelete', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center py-3">
                            <i class="fas fa-trash-alt text-danger fa-3x mb-3"></i>
                            <p class="mb-0 fw-semibold">Are you sure you want to delete this worker?</p>
                            <small class="text-muted">This action cannot be undone.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="$set('confirmingDelete', false)">
                            <i class="fas fa-times me-1"></i> Cancel
                        </button>
                        <button type="button" class="btn btn-danger" wire:click="deleteWorker">
                            <i class="fas fa-trash-alt me-1"></i> Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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

        .btn-info {
            background: #17a2b8;
            border: none;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
            transform: translateY(-1px);
            color: white;
        }

        .btn-success {
            background: #28a745;
            border: none;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-1px);
        }

        .btn-danger:hover {
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

        .btn-secondary {
            background: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        .badge {
            font-weight: 500;
            border-radius: 0.5rem;
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
        }

        /* Status badges with icons */
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

        .bg-info {
            background-color: #17a2b8 !important;
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
        .modal.show {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            border-radius: 1rem;
            border: none;
        }

        .modal-header {
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .modal-footer {
            border-top: 2px solid #f0f0f0;
        }

        /* Info cards styling */
        .info-card {
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Table responsive */
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 0.5rem;
            }

            .d-flex.gap-1 {
                flex-direction: column;
                gap: 5px;
            }

            .d-flex.gap-1 .btn {
                width: 100%;
            }
        }

        /* Modal body styling */
        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        .modal-body .row {
            margin-bottom: 0.5rem;
        }

        .modal-body small.text-muted {
            font-size: 0.7rem;
            letter-spacing: 0.5px;
        }

        /* Scrollbar styling */
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #e9e7e7;
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #e9e7e7;
        }

        /* Border radius for cards */
        .rounded-3 {
            border-radius: 0.75rem !important;
        }

        /* Summary cards */


        /* Active filters styling */
        .btn-close-white {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .btn-close-white:hover {
            opacity: 1;
        }

        /* Badge animations */
        .badge {
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</div>
<?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/livewire/hr/edit-worker.blade.php ENDPATH**/ ?>