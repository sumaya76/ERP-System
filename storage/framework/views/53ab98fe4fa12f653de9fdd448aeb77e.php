
<div>
    <div class="card shadow-sm border-0">
        <!-- Header with Red-Black Gradient Background -->
        <div class="card-header border-0 pt-4 pb-4" style="background: linear-gradient(135deg, #ff0000 0%, #000000 100%); border-radius: 1rem 1rem 0 0;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-receipt text-white fs-4"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold text-white">Expenses Management</h3>
                        <p class="text-white-50 small mb-0">Track project & company expenses</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light" wire:click="openModal">
                        <i class="fas fa-plus-circle me-2"></i>
                        Add New Expense
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
                            Search & Filter Expenses
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="resetFilters">
                            <i class="fas fa-undo-alt me-1"></i> Reset All Filters
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="performSearch">
                        <div class="row g-3 pt-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-project-diagram me-1" style="color: #ff0000;"></i>
                                    Project
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    <select class="form-select" wire:model="tempFilterProject">
                                        <option value="">All Projects</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempFilterProject): ?>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="clearProjectFilter">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-tags me-1" style="color: #ff0000;"></i>
                                    Category
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                    <select class="form-select" wire:model="tempFilterCategory">
                                        <option value="">All Categories</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempFilterCategory): ?>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="clearCategoryFilter">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-building me-1" style="color: #ff0000;"></i>
                                    Expense Type
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                    <select class="form-select" wire:model="tempFilterExpenseType">
                                        <option value="">All Types</option>
                                        <option value="project">Project Expenses</option>
                                        <option value="company">Company Expenses</option>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempFilterExpenseType): ?>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="clearExpenseTypeFilter">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1" style="color: #ff0000;"></i>
                                    From Date
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-calendar-day"></i>
                                    </span>
                                    <input type="date" class="form-control" wire:model="tempFilterDateFrom">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempFilterDateFrom): ?>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="clearDateFromFilter">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1" style="color: #ff0000;"></i>
                                    To Date
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-calendar-check"></i>
                                    </span>
                                    <input type="date" class="form-control" wire:model="tempFilterDateTo">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempFilterDateTo): ?>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="clearDateToFilter">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-9">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-search me-1" style="color: #ff0000;"></i>
                                            Search Description / Invoice #
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" class="form-control" wire:model="tempSearch" placeholder="Search by description or invoice number...">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tempSearch): ?>
                                                <button type="button" class="btn btn-outline-secondary" wire:click="clearSearch">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">&nbsp;</label>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%); border: none;">
                                                <i class="fas fa-search me-2"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Active Filters Display -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isSearching && ($filterProject || $filterCategory || $filterExpenseType || $filterDateFrom || $filterDateTo || $search)): ?>
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <small class="text-muted me-2">
                                    <i class="fas fa-filter me-1"></i>Active filters:
                                </small>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterProject): ?>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-project-diagram me-1"></i>
                                        Project: <?php echo e($projects->firstWhere('id', $filterProject)?->name); ?>

                                        <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="clearProjectFilter"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterCategory): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-tag me-1"></i>
                                        Category: <?php echo e($categories->firstWhere('id', $filterCategory)?->name); ?>

                                        <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="clearCategoryFilter"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterExpenseType): ?>
                                    <span class="badge bg-info">
                                        <i class="fas fa-building me-1"></i>
                                        Type: <?php echo e($filterExpenseType === 'project' ? 'Project' : 'Company'); ?> Expense
                                        <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="clearExpenseTypeFilter"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterDateFrom): ?>
                                    <span class="badge bg-info">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        From: <?php echo e(\Carbon\Carbon::parse($filterDateFrom)->format('M d, Y')); ?>

                                        <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="clearDateFromFilter"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterDateTo): ?>
                                    <span class="badge bg-info">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        To: <?php echo e(\Carbon\Carbon::parse($filterDateTo)->format('M d, Y')); ?>

                                        <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="clearDateToFilter"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-search me-1"></i>
                                        Search: "<?php echo e($search); ?>"
                                        <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 8px;" wire:click="clearSearch"></button>
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Statistics Dashboard -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="dashboard-card dashboard-card-primary">
                        <div class="dashboard-card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <span class="dashboard-card-label">Total Expenses</span>
                            <h3 class="dashboard-card-value">€ <?php echo e(number_format($totalExpenses, 2)); ?></h3>
                            <span class="dashboard-card-subtitle">Filtered period</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card dashboard-card-success">
                        <div class="dashboard-card-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <span class="dashboard-card-label">Total Transactions</span>
                            <h3 class="dashboard-card-value"><?php echo e(number_format($totalTransactions)); ?></h3>
                            <span class="dashboard-card-subtitle">Expense records</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card dashboard-card-info">
                        <div class="dashboard-card-icon">
                            <i class="fas fa-chart-simple"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <span class="dashboard-card-label">Average Expense</span>
                            <h3 class="dashboard-card-value">€ <?php echo e(number_format($averageExpense, 2)); ?></h3>
                            <span class="dashboard-card-subtitle">Per transaction</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card dashboard-card-warning">
                        <div class="dashboard-card-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <span class="dashboard-card-label">Expense Breakdown</span>
                            <h3 class="dashboard-card-value">
                                € <?php echo e(number_format($totalProjectExpenses, 2)); ?>

                                <small style="font-size: 12px;">Projects</small>
                            </h3>
                            <span class="dashboard-card-subtitle">
                                € <?php echo e(number_format($totalCompanyExpenses, 2)); ?> Company
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Breakdown Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-chart-pie me-2" style="color: #ff0000;"></i>
                        Expenses by Category
                    </h6>
                </div>
                <div class="card-body pt-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalByCategory && $totalByCategory->count() > 0): ?>
                        <div class="row">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $totalByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryExpense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <div class="col-md-4 col-lg-3 mb-3">
                                    <div class="category-card" style="border-left-color: <?php echo e($categoryExpense->category->color); ?>;">
                                        <div class="category-card-header">
                                            <i class="<?php echo e($categoryExpense->category->icon); ?>" style="color: <?php echo e($categoryExpense->category->color); ?>;"></i>
                                            <span class="category-name"><?php echo e($categoryExpense->category->name); ?></span>
                                        </div>
                                        <div class="category-card-body">
                                            <div class="category-amount">€ <?php echo e(number_format($categoryExpense->total, 2)); ?></div>
                                            <?php
                                                $percentage = $totalExpenses > 0 ? ($categoryExpense->total / $totalExpenses) * 100 : 0;
                                            ?>
                                            <div class="progress-custom">
                                                <div class="progress-custom-bar" style="width: <?php echo e($percentage); ?>%; background-color: <?php echo e($categoryExpense->category->color); ?>;"></div>
                                            </div>
                                            <div class="category-percentage"><?php echo e(number_format($percentage, 1)); ?>% of total</div>
                                        </div>
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-chart-pie fa-3x mb-3 opacity-50"></i>
                                <p class="mb-0">No expense data available for the selected filters</p>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Expenses Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-list me-2" style="color: #ff0000;"></i>
                        Expense Records
                    </h6>
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        <?php echo e($expenses->total()); ?> records found
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-sec">
                            <tr>
                                <th class="py-3 ps-4"><i class="fas fa-calendar-alt me-2"></i> Date</th>
                                <th class="py-3"><i class="fas fa-project-diagram me-2"></i> Project/Company</th>
                                <th class="py-3"><i class="fas fa-tags me-2"></i> Category</th>
                                <th class="py-3"><i class="fas fa-align-left me-2"></i> Description</th>
                                <th class="py-3"><i class="fas fa-hashtag me-2"></i> Invoice #</th>
                                <th class="py-3 text-end"><i class="fas fa-euro-sign me-2"></i> Amount</th>
                                <th class="py-3"><i class="fas fa-user me-2"></i> Added By</th>
                                <th class="py-3 text-center pe-4"><i class="fas fa-cog me-2"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <tr class="border-bottom">
                                    <td class="ps-4">
                                        <div class="fw-semibold"><?php echo e($expense->expense_date->format('M d, Y')); ?></div>
                                        <small class="text-muted"><?php echo e($expense->expense_date->diffForHumans()); ?></small>
                                    </td>
                                    <td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($expense->expense_type === 'company'): ?>
                                            <div class="fw-bold text-success">
                                                <i class="fas fa-building me-1"></i> Company Expense
                                            </div>
                                            <small class="text-muted">General Company</small>
                                        <?php else: ?>
                                            <div class="fw-bold"><?php echo e($expense->project->name ?? 'N/A'); ?></div>
                                            <small class="text-muted"><?php echo e($expense->project->project_code ?? ''); ?></small>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge px-3 py-2" style="background-color: <?php echo e($expense->category->color); ?>20; color: <?php echo e($expense->category->color); ?>;">
                                            <i class="<?php echo e($expense->category->icon); ?> me-1"></i>
                                            <?php echo e($expense->category->name); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?php echo e(Str::limit($expense->description, 50)); ?></div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($expense->notes): ?>
                                            <small class="text-muted">
                                                <i class="fas fa-sticky-note me-1"></i>
                                                <?php echo e(Str::limit($expense->notes, 40)); ?>

                                            </small>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($expense->invoice_number): ?>
                                            <span class="badge bg-info"><?php echo e($expense->invoice_number); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold text-danger fs-6">€ <?php echo e(number_format($expense->amount, 2)); ?></span>
                                    </td>
                                    <td>
                                        <div><?php echo e($expense->createdBy->name ?? 'System'); ?></div>
                                        <small class="text-muted"><?php echo e($expense->created_at->format('M d, Y')); ?></small>
                                    </td>
                                    <td class="text-center pe-4">
                                        <button class="btn btn-sm btn-success" wire:click="editExpense(<?php echo e($expense->id); ?>)" style="font-size: 12px; padding: 3px 6px;">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger" wire:click="confirmDelete(<?php echo e($expense->id); ?>)" style="font-size: 12px; padding: 3px 6px;">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                            <p class="mb-0">No expense records found</p>
                                            <small>Click "Add New Expense" to start tracking expenses</small>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($expenses->count() > 0): ?>
                            <tfoot class="bg-light">
                                <tr class="fw-bold">
                                    <td colspan="5" class="py-3 ps-4">TOTAL</td>
                                    <td class="text-end py-3 text-black fs-5">€ <?php echo e(number_format($expenses->sum('amount'), 2)); ?></td>
                                    <td colspan="2" class="py-3 pe-4"></td>
                                </tr>
                            </tfoot>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </table>
                </div>

                <!-- Pagination with Info -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($expenses->total() > 0): ?>
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="text-muted small">
                            <i class="fas fa-info-circle me-1"></i>
                            Showing <?php echo e($expenses->firstItem() ?? 0); ?> to <?php echo e($expenses->lastItem() ?? 0); ?> 
                            of <?php echo e($expenses->total()); ?> expenses
                        </div>
                        <div>
                            <?php echo e($expenses->links()); ?>

                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Add/Edit Expense Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 1rem;">
                <div class="modal-header" style="background: linear-gradient(135deg, #28c76f 70%, #ffffff 100%); border-radius: 1rem 1rem 0 0; padding: 1rem 1.5rem;">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-<?php echo e($expenseId ? 'edit' : 'plus-circle'); ?> me-2"></i>
                        <?php echo e($expenseId ? 'Edit Expense' : 'Add New Expense'); ?>

                    </h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" wire:click="resetForm"></button>
                </div>
                <div class="modal-body">
                    <!-- Expense Type Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-building me-1" style="color: #28c76f;"></i>
                            Expense Type *
                        </label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="expense_type" id="project_type" value="project" wire:model="expense_type" autocomplete="off">
                            <label class="btn btn-outline-primary" for="project_type">
                                <i class="fas fa-project-diagram me-1"></i> Project Expense
                            </label>
                            
                            <input type="radio" class="btn-check" name="expense_type" id="company_type" value="company" wire:model="expense_type" autocomplete="off">
                            <label class="btn btn-outline-success" for="company_type">
                                <i class="fas fa-building me-1"></i> Company Expense
                            </label>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['expense_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Project Field (shows only for project expenses) -->
                    <div class="mb-3" x-data="{ show: <?php if ((object) ('expense_type') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('expense_type'->value()); ?>')<?php echo e('expense_type'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('expense_type'); ?>')<?php endif; ?> }" x-show="show === 'project'" x-transition>
                        <label class="form-label fw-semibold">
                            <i class="fas fa-project-diagram me-1" style="color: #28c76f;"></i>
                            Project *
                        </label>
                        <select class="form-select" wire:model="project_id">
                            <option value="">Select Project</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?> (<?php echo e($project->project_code); ?>)</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Company Info (shows only for company expenses) -->
                    <div class="mb-3" x-data="{ show: <?php if ((object) ('expense_type') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('expense_type'->value()); ?>')<?php echo e('expense_type'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('expense_type'); ?>')<?php endif; ?> }" x-show="show === 'company'" x-transition>
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-building me-2"></i>
                            <strong>Company Expense</strong><br>
                            <small>This expense is not associated with any specific project.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tags me-1" style="color: #28c76f;"></i>
                            Category *
                        </label>
                        <select class="form-select" wire:model="category_id">
                            <option value="">Select Category</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-align-left me-1" style="color: #28c76f;"></i>
                            Description *
                        </label>
                        <input type="text" class="form-control" wire:model="description" placeholder="What was this expense for?">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-euro-sign me-1" style="color: #28c76f;"></i>
                                Amount *
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">€</span>
                                <input type="number" step="0.01" class="form-control" wire:model="amount" placeholder="0.00">
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt me-1" style="color: #28c76f;"></i>
                                Expense Date *
                            </label>
                            <input type="date" class="form-control" wire:model="expense_date">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['expense_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <!-- Invoice Number Field -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-hashtag me-1" style="color: #28c76f;"></i>
                            Invoice Number <small class="text-muted">(Optional - Must be unique)</small>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-file-invoice"></i>
                            </span>
                            <input type="text" class="form-control <?php $__errorArgs = ['invoice_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   wire:model="invoice_number" placeholder="INV-2024-001">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice_number && !$errors->has('invoice_number')): ?>
                                <span class="input-group-text bg-success text-white">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['invoice_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php else: ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice_number): ?>
                                <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Invoice number is unique</small>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-sticky-note me-1" style="color: #28c76f;"></i>
                            Notes (Optional)
                        </label>
                        <textarea class="form-control" wire:model="notes" rows="3" placeholder="Additional details..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click="resetForm">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="saveExpense" style="background: linear-gradient(135deg, #28c76f 0%, #28c76f 100%); border: none;">
                        <i class="fas fa-save me-1"></i>
                        <?php echo e($expenseId ? 'Update' : 'Save'); ?> Expense
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 1rem;">
                <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 70%, #ffffff 100%); border-radius: 1rem 1rem 0 0; padding: 1rem 1.5rem;">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Confirm Delete
                    </h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" wire:click="closeDeleteModal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-trash-alt" style="font-size: 4rem; color: #dc3545;"></i>
                    </div>
                    <h5 class="mb-3">Are you sure you want to delete this expense?</h5>
                    <p class="text-muted mb-2">You are about to delete the following expense:</p>
                    <div class="alert alert-danger" style="border-radius: 0.5rem;">
                        <strong><?php echo e($deleteDescription); ?></strong>
                    </div>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center gap-3">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click="closeDeleteModal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-danger" wire:click="deleteExpense">
                        <i class="fas fa-trash-alt me-1"></i> Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('open-modal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('expenseModal'));
                myModal.show();
            });

            Livewire.on('close-modal', () => {
                var myModal = bootstrap.Modal.getInstance(document.getElementById('expenseModal'));
                if (myModal) myModal.hide();
            });

            Livewire.on('open-delete-modal', () => {
                var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
                deleteModal.show();
            });

            Livewire.on('close-delete-modal', () => {
                var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
                if (deleteModal) deleteModal.hide();
            });
        });
    </script>

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

        tfoot {
            border-top: 2px solid #dee2e6;
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

        .btn-info {
            background: #17a2b8;
            border: none;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background: #c82333;
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

        .bg-sec {
            background-color: #f8f9fa !important;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .dashboard-card-icon {
            width: 55px;
            height: 55px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .dashboard-card-primary .dashboard-card-icon { background: linear-gradient(135deg, #ff0000, #cc0000); }
        .dashboard-card-success .dashboard-card-icon { background: linear-gradient(135deg, #28a745, #20c997); }
        .dashboard-card-info .dashboard-card-icon { background: linear-gradient(135deg, #17a2b8, #138496); }
        .dashboard-card-warning .dashboard-card-icon { background: linear-gradient(135deg, #ffc107, #e0a800); }

        .dashboard-card-content {
            flex: 1;
        }

        .dashboard-card-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6c757d;
            letter-spacing: 0.5px;
        }

        .dashboard-card-value {
            font-size: 1.75rem;
            font-weight: 800;
            margin: 0.25rem 0;
            color: #2c3e50;
        }

        .dashboard-card-subtitle {
            font-size: 0.7rem;
            color: #6c757d;
        }

        /* Category Cards */
        .category-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1rem;
            border-left: 4px solid;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }

        .category-card:hover {
            transform: translateX(3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .category-card-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .category-card-header i {
            font-size: 1.1rem;
        }

        .category-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: #333;
        }

        .category-card-body {
            text-align: right;
        }

        .category-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 0.5rem;
        }

        .progress-custom {
            height: 4px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin: 0.5rem 0;
        }

        .progress-custom-bar {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .category-percentage {
            font-size: 0.7rem;
            color: #6c757d;
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

        /* Modal styling */
        .modal-content {
            border-radius: 1rem;
            border: none;
        }

        .modal-header {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }

        /* White text opacity */
        .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        /* Active Filters */
        .btn-close-white {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .btn-close-white:hover {
            opacity: 1;
        }

        /* Transitions */
        [x-cloak] {
            display: none;
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

            .modal-dialog {
                margin: 0.5rem;
            }

            .dashboard-card {
                flex-direction: column;
                text-align: center;
            }

            .dashboard-card-icon {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }

            .dashboard-card-value {
                font-size: 1.5rem;
            }
        }
    </style>
</div><?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/livewire/admin/project-expenses.blade.php ENDPATH**/ ?>