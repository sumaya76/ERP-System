
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
                        <h3 class="mb-0 fw-bold text-white">Project Worker Assignment</h3>
                        <p class="text-white-50 small mb-0">Assign workers to construction projects</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('hr.projects.list')); ?>" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Projects
                    </a>
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

            <!-- Assignment Form -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-plus-circle me-2" style="color: #ff0000;"></i>
                        New Assignment
                    </h6>
                </div>
                <div class="card-body mt-2">
                    <form wire:submit.prevent="assign">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-project-diagram me-1" style="color: #000000;"></i>
                                    Select Project
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="project_id">
                                    <option value="">Choose a project...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <option value="<?php echo e($project->id); ?>">
                                            <?php echo e($project->name); ?> (<?php echo e($project->project_code); ?>)
                                        </option>
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
                                    Select Worker
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['worker_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="worker_id">
                                    <option value="">Choose a worker...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <option value="<?php echo e($worker->id); ?>">
                                            <?php echo e($worker->name); ?> (<?php echo e($worker->designation ?: 'No designation'); ?>)
                                        </option>
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

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-day me-1" style="color: #000000;"></i>
                                    Assigned Date
                                </label>
                                <input type="date" 
                                       class="form-control <?php $__errorArgs = ['assigned_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       wire:model="assigned_date">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['assigned_date'];
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

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-save-assignment w-100" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class="fas fa-plus-circle me-1"></i> Add
                                    </span>
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Filter Section -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-search me-2" style="color: #ff0000;"></i>
                            Search & Filter Assignments
                        </h6>
                        <button wire:click="resetFilters" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-undo-alt me-1"></i> Reset All Filters
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Global Search Bar -->
                    <div class="mb-3 pt-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-globe me-1" style="color: #ff0000;"></i>
                            Global Search
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0" 
                                   wire:model="tempSearch" 
                                   placeholder="Search across projects, workers, status...">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempSearch): ?>
                                <button wire:click="clearGlobalSearch" class="btn btn-outline-secondary border-start-0" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Searches: Project name/code, Worker name/email/designation/phone, Status
                        </small>
                    </div>

                    <div class="row g-3">
                        <!-- Project Filter -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-project-diagram me-1" style="color: #ff0000;"></i>
                                Filter by Project
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-building"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       wire:model="tempSearchProject" 
                                       placeholder="Project name or code...">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempSearchProject): ?>
                                    <button wire:click="clearProjectFilter" class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <!-- Worker Filter -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-1" style="color: #ff0000;"></i>
                                Filter by Worker
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       wire:model="tempSearchWorker" 
                                       placeholder="Worker name, email, designation...">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempSearchWorker): ?>
                                    <button wire:click="clearWorkerFilter" class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-chart-pie me-1" style="color: #ff0000;"></i>
                                Filter by Status
                            </label>
                            <select class="form-select" wire:model="tempSearchStatus">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="released">Released</option>
                            </select>
                        </div>

                        <!-- Date Range Filter -->
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt me-1" style="color: #ff0000;"></i>
                                From Date
                            </label>
                            <div class="input-group">
                                <input type="date" 
                                       class="form-control" 
                                       wire:model="tempSearchDateFrom">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempSearchDateFrom): ?>
                                    <button wire:click="clearDateFromFilter" class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt me-1" style="color: #ff0000;"></i>
                                To Date
                            </label>
                            <div class="input-group">
                                <input type="date" 
                                       class="form-control" 
                                       wire:model="tempSearchDateTo">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempSearchDateTo): ?>
                                    <button wire:click="clearDateToFilter" class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Search Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end">
                                <button wire:click="performSearch" class="btn btn-primary px-4">
                                    <i class="fas fa-search me-2"></i> Search
                                </button>
                                <button wire:click="resetFilters" class="btn btn-secondary px-4">
                                    <i class="fas fa-undo-alt me-2"></i> Clear All
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Active Filters Display -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $searchProject || $searchWorker || $searchStatus || $searchDateFrom || $searchDateTo): ?>
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <small class="text-muted me-2">
                                    <i class="fas fa-filter me-1"></i>Active filters:
                                </small>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-search me-1"></i>
                                        Global: <?php echo e($search); ?>

                                        <button wire:click="clearGlobalSearch" class="btn-close btn-close-white ms-2" style="font-size: 8px;"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($searchProject): ?>
                                    <span class="badge bg-info">
                                        <i class="fas fa-project-diagram me-1"></i>
                                        Project: <?php echo e($searchProject); ?>

                                        <button wire:click="clearProjectFilter" class="btn-close btn-close-white ms-2" style="font-size: 8px;"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($searchWorker): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-user me-1"></i>
                                        Worker: <?php echo e($searchWorker); ?>

                                        <button wire:click="clearWorkerFilter" class="btn-close btn-close-white ms-2" style="font-size: 8px;"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($searchStatus): ?>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-chart-pie me-1"></i>
                                        Status: <?php echo e(ucfirst($searchStatus)); ?>

                                        <button wire:click="clearStatusFilter" class="btn-close btn-close-white ms-2" style="font-size: 8px;"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($searchDateFrom): ?>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        From: <?php echo e(\Carbon\Carbon::parse($searchDateFrom)->format('M d, Y')); ?>

                                        <button wire:click="clearDateFromFilter" class="btn-close btn-close-white ms-2" style="font-size: 8px;"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($searchDateTo): ?>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        To: <?php echo e(\Carbon\Carbon::parse($searchDateTo)->format('M d, Y')); ?>

                                        <button wire:click="clearDateToFilter" class="btn-close btn-close-white ms-2" style="font-size: 8px;"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Assignments Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-list me-2" style="color: #ff0000;"></i>
                            Current Assignments
                        </h6>
                        <span class="badge bg-secondary">
                            <i class="fas fa-chart-bar me-1"></i>
                            Total: <?php echo e($assignments->total()); ?>

                        </span>
                    </div>
                </div>
                <div class="py-2">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-sec">
                                <tr>
                                    <th class="py-3">
                                        <i class="fas fa-project-diagram me-2"></i> Project
                                    </th>
                                    <th class="py-3">
                                        <i class="fas fa-user me-2"></i> Worker
                                    </th>
                                    <th class="py-3">
                                        <i class="fas fa-calendar-check me-2"></i> Assigned Date
                                    </th>
                                    <th class="py-3">
                                        <i class="fas fa-calendar-times me-2"></i> Released Date
                                    </th>
                                    <th class="py-3">
                                        <i class="fas fa-chart-pie me-2"></i> Status
                                    </th>
                                    <th class="py-3 text-center">
                                        <i class="fas fa-cog me-2"></i> Action
                                    </th>
                                 </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <tr class="border-bottom">
                                        <td>
                                            <div class="fw-bold"><?php echo e($assignment->project_name); ?></div>
                                            <small class="text-muted">
                                                <i class="fas fa-barcode me-1"></i>
                                                <?php echo e($assignment->project_code ?? 'N/A'); ?>

                                            </small>
                                        </td>
                                        <td>
                                            <div><?php echo e($assignment->worker_name); ?></div>
                                            <small class="text-muted">
                                                <i class="fas fa-envelope me-1"></i>
                                                <?php echo e($assignment->worker_email ?? 'No email'); ?>

                                            </small>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assignment->worker_designation): ?>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-briefcase me-1"></i>
                                                    <?php echo e($assignment->worker_designation); ?>

                                                </small>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark px-3 py-2">
                                                <i class="fas fa-calendar-day me-1"></i>
                                                <?php echo e(\Carbon\Carbon::parse($assignment->assigned_date)->format('M d, Y')); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assignment->release_date): ?>
                                                <span class="badge bg-light text-dark px-3 py-2">
                                                    <i class="fas fa-calendar-times me-1"></i>
                                                    <?php echo e(\Carbon\Carbon::parse($assignment->release_date)->format('M d, Y')); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">Not released</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $statusColor = $assignment->status == 'active' ? 'success' : 'secondary';
                                                $statusIcon = $assignment->status == 'active' ? 'fa-check-circle' : 'fa-pause-circle';
                                            ?>
                                            <span class="badge bg-<?php echo e($statusColor); ?> px-3 py-2">
                                                <i class="fas <?php echo e($statusIcon); ?> me-1"></i>
                                                <?php echo e(ucfirst($assignment->status)); ?>

                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assignment->status == 'active'): ?>
                                                <button type="button" 
                                                        class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#releaseModal"
                                                        wire:click="setReleaseId(<?php echo e($assignment->id); ?>)"
                                                        style="font-size: 12px; padding: 3px 6px; white-space: nowrap;">
                                                    <i class="fas fa-user-minus me-1"></i> Release
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    <i class="fas fa-check-circle text-success me-1"></i>
                                                    Completed
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                                <p class="mb-0">No assignments found</p>
                                                <small>Try adjusting your search filters</small>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination with Info -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assignments->total() > 0): ?>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing <?php echo e($assignments->firstItem() ?? 0); ?> to <?php echo e($assignments->lastItem() ?? 0); ?> 
                                of <?php echo e($assignments->total()); ?> assignments
                            </div>
                            <div>
                                <?php echo e($assignments->links()); ?>

                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Release Confirmation Modal -->
    <div class="modal fade" id="releaseModal" tabindex="-1" aria-labelledby="releaseModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header d-flex align-items-center justify-content-between"
     style="background: linear-gradient(135deg, #ff0000 70%, #ffffff 100%);
            padding: 0.75rem 1rem;">

    <h5 class="modal-title text-white mb-0 d-flex align-items-center" id="releaseModalLabel">
        <i class="fas fa-exclamation-triangle me-2"></i>
        Confirm Release
    </h5>


</div>

                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-user-minus" style="font-size: 64px; color: #ff0000;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Are you sure you want to release this worker?</h5>
                        <p class="text-muted mb-2">
                            This action will:
                        </p>
                        <ul class="text-muted text-start d-inline-block">
                            <li><i class="fas fa-ban text-warning me-2"></i>Mark the assignment as released</li>
                            <li><i class="fas fa-calendar-day me-2 text-info"></i>Set the release date to today</li>
                            <li><i class="fas fa-user-friends me-2 text-success"></i>Free up the worker for other projects</li>
                        </ul>
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            This action can be undone by reassigning the worker.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-danger" wire:click="confirmRelease" data-bs-dismiss="modal">
                        <i class="fas fa-user-minus me-2"></i> Yes, Release Worker
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
        
        .btn-save-assignment {
            background: #ff0000;
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-save-assignment:hover {
            background: #000000;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .btn-save-assignment:active {
            transform: translateY(0);
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
        
        .badge {
            font-weight: 500;
            border-radius: 0.5rem;
        }
        
        .alert {
            border-radius: 0.75rem;
            border: none;
        }
        
        .bg-sec {
            background-color: #f8f9fa !important;
        }
        
        /* Status badges */
        .bg-success {
            background-color: #28a745 !important;
        }
        
        .bg-warning {
            background-color: #ffc107 !important;
            color: #000;
        }
        
        .bg-secondary {
            background-color: #6c757d !important;
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
        
        /* Table responsive */
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 0.5rem;
            }
            
            .row.g-3 {
                flex-direction: column;
            }
            
            .col-md-1.d-flex.align-items-end {
                margin-top: 10px;
            }
        }
        
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
        
        /* Search button section */
        .btn-primary, .btn-secondary {
            min-width: 120px;
        }
        
        /* Input group clear button */
        .input-group .btn-outline-secondary {
            border-color: #e0e0e0;
        }
        
        .input-group .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            border-color: #e0e0e0;
        }
        
        /* Modal styling */
        .modal-content {
            border-radius: 1rem;
            overflow: hidden;
            border: none;
        }
        
        .modal-header {
            border-bottom: none;
        }
        
        .modal-footer {
            border-top: 1px solid #e0e0e0;
            padding: 1rem 1.5rem;
        }
        
        .modal-body ul {
            padding-left: 0;
            list-style: none;
        }
        
        .modal-body ul li {
            margin-bottom: 8px;
        }
        
        .btn-danger {
            background: #ff0000;
            border: none;
            transition: all 0.2s ease;
        }
        
        .btn-danger:hover {
            background: #cc0000;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.3);
        }
    </style>

    <!-- Bootstrap JS for Modal -->
    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:initialized', function () {
            Livewire.on('closeModal', () => {
                var modalElement = document.getElementById('releaseModal');
                var modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
</div><?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/livewire/hr/projects/project-assignment.blade.php ENDPATH**/ ?>