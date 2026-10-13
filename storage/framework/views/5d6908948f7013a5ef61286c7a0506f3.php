<div class="erp-module-page">
    <div class="card erp-page-heading shadow-sm border-0 mb-4">
        <div class="card-header border-0">
            <div class="d-flex align-items-center gap-3">
                <span class="erp-page-heading-icon"><i class="fa-solid fa-chart-gantt"></i></span>
                <div>
                    <h3 class="mb-1">Project Progress, Cost & Documents</h3>
                    <p class="mb-0">Track site progress, milestones, budget versus actual costs, and project/worker files.</p>
                </div>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?><div class="alert alert-danger"><?php echo e($errors->first()); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <label class="form-label fw-semibold" for="workspace-project">Project overview</label>
            <select id="workspace-project" class="form-select" wire:model.live="projectId" aria-describedby="workspace-project-help">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($projects->isEmpty()): ?><option value="">No projects available</option><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <option value="<?php echo e($project->id); ?>"><?php echo e($project->project_code); ?> — <?php echo e($project->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            <div id="workspace-project-help" class="form-text">Choose a project to review progress, budget, milestones, and site updates.</div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedProject): ?>
        <?php
            $projectCost = $costs[$selectedProject->id];
            $budget = (float) $projectCost['budget'];
            $actual = (float) $projectCost['actual'];
            $budgetUsed = $budget > 0 ? min(100, ($actual / $budget) * 100) : 0;
        ?>
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="card h-100"><div class="card-body">
                    <div class="text-muted mb-1">Project progress</div>
                    <h3 class="mb-2"><?php echo e(number_format((float) $selectedProject->progress_percent, 1)); ?>%</h3>
                    <div class="progress mb-2" role="progressbar" aria-label="Project completion" aria-valuenow="<?php echo e(min(100, (float) $selectedProject->progress_percent)); ?>" aria-valuemin="0" aria-valuemax="100" style="height: 8px"><div class="progress-bar bg-success" style="width: <?php echo e(min(100, (float) $selectedProject->progress_percent)); ?>%"></div></div>
                    <span class="badge bg-label-primary"><?php echo e($selectedProject->project_stage); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedProject->quotation_approval_status): ?>
                        <span class="badge <?php echo e($selectedProject->quotation_approval_status === 'approved' ? 'bg-label-success' : ($selectedProject->quotation_approval_status === 'rejected' ? 'bg-label-danger' : 'bg-label-warning')); ?>">
                            Quotation <?php echo e(ucfirst($selectedProject->quotation_approval_status)); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div></div>
            </div>
            <div class="col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><div class="text-muted mb-1">Budget</div><h3 class="mb-0"><?php echo e(number_format($budget, 2)); ?></h3></div></div></div>
            <div class="col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><div class="text-muted mb-1">Actual cost</div><h3 class="mb-0"><?php echo e(number_format($actual, 2)); ?></h3><small class="text-muted">Materials + labour + expenses</small></div></div></div>
            <div class="col-md-6 col-xl-3"><div class="card h-100"><div class="card-body">
                <div class="text-muted mb-1">Budget status</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($budget > 0 && $actual > $budget): ?>
                    <h4 class="text-danger mb-1">Over budget</h4><small class="text-danger"><?php echo e(number_format($actual - $budget, 2)); ?> above budget</small>
                    <div class="progress mt-2" role="progressbar" aria-label="Budget usage" aria-valuenow="<?php echo e(min(100, $budgetUsed)); ?>" aria-valuemin="0" aria-valuemax="100" style="height: 6px"><div class="progress-bar bg-danger" style="width: <?php echo e(min(100, $budgetUsed)); ?>%"></div></div>
                <?php elseif($budget > 0): ?>
                    <h4 class="text-success mb-1">Within budget</h4><small><?php echo e(number_format(100 - $budgetUsed, 1)); ?>% remaining</small>
                    <div class="progress mt-2" role="progressbar" aria-label="Budget usage" aria-valuenow="<?php echo e($budgetUsed); ?>" aria-valuemin="0" aria-valuemax="100" style="height: 6px"><div class="progress-bar bg-success" style="width: <?php echo e($budgetUsed); ?>%"></div></div>
                <?php else: ?>
                    <h4 class="mb-1">No budget set</h4><small>Add budget lines or a project budget cap.</small>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div></div></div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div><h5 class="mb-1">Budget vs Actual Cost</h5><small class="text-muted">Compare total project costs with the budget.</small></div>
                <form wire:submit="saveBudgetCap" class="d-flex flex-wrap gap-2 align-items-center">
                    <label class="form-label mb-0" for="budget-cap">Budget cap</label>
            <input id="budget-cap" type="number" min="0.01" step="0.01" class="form-control form-control-sm" style="max-width: 170px" wire:model="budgetCapInput" placeholder="Use budget lines" aria-label="Project budget cap">
            <button class="btn btn-sm btn-outline-primary" type="submit" wire:loading.attr="disabled" wire:target="saveBudgetCap">
                <span wire:loading.remove wire:target="saveBudgetCap">Save cap</span>
                <span wire:loading wire:target="saveBudgetCap">Saving...</span>
            </button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Cost category</th><th>Actual</th><th>Share of budget</th></tr></thead>
                    <tbody>
                        <tr><td>Materials issued to site</td><td><?php echo e(number_format($projectCost['materials'], 2)); ?></td><td><?php echo e($budget > 0 ? number_format(($projectCost['materials'] / $budget) * 100, 1) : '—'); ?>%</td></tr>
                        <tr><td>Project labour</td><td><?php echo e(number_format($projectCost['labor'], 2)); ?></td><td><?php echo e($budget > 0 ? number_format(($projectCost['labor'] / $budget) * 100, 1) : '—'); ?>%</td></tr>
                        <tr><td>Recorded expenses</td><td><?php echo e(number_format($projectCost['expenses'], 2)); ?></td><td><?php echo e($budget > 0 ? number_format(($projectCost['expenses'] / $budget) * 100, 1) : '—'); ?>%</td></tr>
                        <tr class="table-light fw-semibold"><td>Total actual</td><td><?php echo e(number_format($actual, 2)); ?></td><td><?php echo e($budget > 0 ? number_format(($actual / $budget) * 100, 1) : '—'); ?>%</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-5">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-0">Daily Site Progress Update</h5></div>
                    <div class="card-body">
                        <form wire:submit="saveProgressUpdate">
                            <div class="mb-3"><label class="form-label">Current stage</label><input class="form-control" wire:model="stage" placeholder="Foundation, structure, finishing..." required></div>
                            <div class="mb-3"><label class="form-label">Completion %</label><input type="number" min="0" max="100" step="0.01" class="form-control" wire:model="progressPercent" required></div>
                            <div class="mb-3"><label class="form-label">Today's work completed</label><textarea class="form-control" rows="3" wire:model="progressSummary" required></textarea></div>
                            <div class="mb-3"><label class="form-label">Delay / blocker (optional)</label><textarea class="form-control" rows="2" wire:model="blockers"></textarea></div>
                            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="saveProgressUpdate">
                                <span wire:loading.remove wire:target="saveProgressUpdate">Save site update</span>
                                <span wire:loading wire:target="saveProgressUpdate"><span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Saving...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-0">Milestones</h5></div>
                    <div class="card-body border-bottom">
                        <form wire:submit="addMilestone">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-5"><label class="form-label">Milestone</label><input class="form-control" wire:model="milestoneName" required></div>
                                <div class="col-md-3"><label class="form-label">Target date</label><input type="date" class="form-control" wire:model="milestoneDueDate"></div>
                                <div class="col-md-4"><label class="form-label">Notes</label><input class="form-control" wire:model="milestoneDescription"></div>
                                <div class="col-12"><button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled" wire:target="addMilestone">
                                    <span wire:loading.remove wire:target="addMilestone"><i class="fa-solid fa-plus me-1"></i>Add milestone</span>
                                    <span wire:loading wire:target="addMilestone">Adding...</span>
                                </button></div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead><tr><th>Milestone</th><th>Due</th><th>Status</th><th>Update</th></tr></thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $selectedProject->milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('milestone-{{ $milestone->id }}', get_defined_vars()); ?>wire:key="milestone-<?php echo e($milestone->id); ?>">
                                        <td><?php echo e($milestone->name); ?><div class="small text-muted"><?php echo e($milestone->description); ?></div></td>
                                        <td><?php echo e($milestone->due_date?->format('d M Y') ?? '—'); ?></td>
                                        <td>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($milestone->due_date && $milestone->due_date->lt(today()) && $milestone->status !== 'completed'): ?>
                                                <span class="badge bg-label-danger">Delayed</span>
                                            <?php else: ?>
                                                <span class="badge bg-label-secondary"><?php echo e(str_replace('_', ' ', ucfirst($milestone->status))); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm" wire:change="updateMilestone(<?php echo e($milestone->id); ?>, $event.target.value)">
                                                <option value="pending" <?php if($milestone->status === 'pending'): echo 'selected'; endif; ?>>Pending</option>
                                                <option value="in_progress" <?php if($milestone->status === 'in_progress'): echo 'selected'; endif; ?>>In progress</option>
                                                <option value="completed" <?php if($milestone->status === 'completed'): echo 'selected'; endif; ?>>Completed</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <tr><td colspan="4" class="text-center text-muted py-4">No milestones added.</td></tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Recent Daily Updates</h5></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Date</th><th>Stage</th><th>Progress</th><th>Update</th><th>Blockers</th><th>Updated by</th></tr></thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $selectedProject->progressUpdates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr><td><?php echo e($update->update_date->format('d M Y')); ?></td><td><?php echo e($update->stage); ?></td><td><?php echo e(number_format((float) $update->progress_percent, 1)); ?>%</td><td><?php echo e($update->summary); ?></td><td><?php echo e($update->blockers ?: '—'); ?></td><td><?php echo e($update->user->name); ?></td></tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr><td colspan="6" class="text-center text-muted py-4">No daily updates yet.</td></tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="card erp-empty-state mb-4">
            <div class="card-body text-center py-5">
                <span class="erp-empty-state-icon"><i class="fa-solid fa-diagram-project"></i></span>
                <h5 class="mt-3 mb-2">No projects to show yet</h5>
                <p class="text-muted mb-0">Create a project first, then you can track progress, costs, milestones, and documents here.</p>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Upload Project / Worker Document</h5></div>
        <div class="card-body">
            <p class="small text-muted mb-3">Store project and worker documents securely. Supported: PDF, images, Word, and Excel files up to 10 MB.</p>
            <form wire:submit="saveDocument">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Attach to</label>
                        <select class="form-select" wire:model.live="documentableType"><option value="project">Project</option><option value="worker">Worker</option></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e($documentableType === 'project' ? 'Project' : 'Worker'); ?></label>
                        <select class="form-select" wire:model="documentableId">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($documentableType === 'project'): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?><option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php else: ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?><option value="<?php echo e($worker->id); ?>"><?php echo e($worker->name); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Document type</label>
                        <select class="form-select" wire:model="documentCategory">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['contract', 'drawing', 'permit', 'invoice', 'identity', 'medical', 'certificate', 'other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($category); ?>"><?php echo e(ucfirst($category)); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-4"><label class="form-label" for="workspace-upload">Choose file</label><input id="workspace-upload" type="file" class="form-control <?php $__errorArgs = ['upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="upload" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx" aria-describedby="workspace-upload-help"><div id="workspace-upload-help" class="form-text">Max 10 MB</div><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                    <div class="col-md-3"><label class="form-label">Expiry / renewal date</label><input type="date" class="form-control" wire:model="documentExpiry"></div>
                    <div class="col-md-7"><label class="form-label">Notes</label><input class="form-control" wire:model="documentNotes"></div>
                    <div class="col-md-2 d-flex align-items-end"><button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled" wire:target="upload,saveDocument">
                        <span wire:loading.remove wire:target="saveDocument"><i class="fa-solid fa-cloud-arrow-up me-1"></i>Upload document</span>
                        <span wire:loading wire:target="upload,saveDocument"><span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Uploading...</span>
                    </button></div>
                </div>
                <div wire:loading wire:target="upload" class="small text-muted mt-2">Uploading file...</div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Document</th><th>Category</th><th>Expiry</th><th>Uploaded by</th><th>Uploaded</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('document-{{ $document->id }}', get_defined_vars()); ?>wire:key="document-<?php echo e($document->id); ?>">
                            <td><?php echo e($document->original_name); ?><div class="small text-muted"><?php echo e($document->notes); ?></div></td>
                            <td><?php echo e(ucfirst($document->category)); ?></td><td><?php echo e($document->expires_at?->format('d M Y') ?? '—'); ?></td>
                            <td><?php echo e($document->uploader->name); ?></td><td><?php echo e($document->created_at->format('d M Y')); ?></td>
                            <td><button class="btn btn-sm btn-outline-primary" wire:click="downloadDocument(<?php echo e($document->id); ?>)">Download</button> <button class="btn btn-sm btn-outline-danger" wire:click="deleteDocument(<?php echo e($document->id); ?>)" wire:confirm="Delete this document permanently?">Delete</button></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">No documents uploaded for the selected record.</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/livewire/shared/project-workspace.blade.php ENDPATH**/ ?>