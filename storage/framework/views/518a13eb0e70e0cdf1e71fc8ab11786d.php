<div class="calendar-modern-wrapper">
    <!-- Calendar Grid -->
    <div class="attendance-calendar-wrapper">
        <table class="calendar-grid-table">
            <thead>
                <tr>
                    <th class="calendar-weekday">Sun</th>
                    <th class="calendar-weekday">Mon</th>
                    <th class="calendar-weekday">Tue</th>
                    <th class="calendar-weekday">Wed</th>
                    <th class="calendar-weekday">Thu</th>
                    <th class="calendar-weekday">Fri</th>
                    <th class="calendar-weekday">Sat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    use Carbon\Carbon;
                    $firstDayOfMonth = Carbon::create($selectedYear, $selectedMonth, 1);
                    $startDayOfWeek = $firstDayOfMonth->dayOfWeek;
                    $daysInMonth = $firstDayOfMonth->daysInMonth;
                    $currentDay = 1;
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($week = 0; $week < 6; $week++): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentDay > $daysInMonth): ?> <?php break; ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++): ?>
                            <?php
                                $showDay = ($week == 0 && $dayOfWeek < $startDayOfWeek) ? false : true;
                                $record = $attendanceData[$currentDay] ?? null;

                                if($showDay && $currentDay <= $daysInMonth) {
                                    $status = $record ? $record['status'] : 'not_recorded';
                                    $hours = $record ? $record['hours_worked'] : 0;
                                    $overtime = $record ? $record['overtime'] : 0;
                                    $project = $record ? $record['project'] : null;

                                    $statusClass = '';
                                    $statusIcon = '';
                                    $statusBg = '';

                                    switch($status) {
                                        case 'present':
                                            $statusClass = 'cell-present';
                                            $statusIcon = 'fa-check-circle';
                                            $statusBg = '#d4edda';
                                            break;
                                        case 'absent':
                                            $statusClass = 'cell-absent';
                                            $statusIcon = 'fa-times-circle';
                                            $statusBg = '#f8d7da';
                                            break;
                                        case 'half_day':
                                            $statusClass = 'cell-half';
                                            $statusIcon = 'fa-adjust';
                                            $statusBg = '#fff3cd';
                                            break;
                                        default:
                                            $statusClass = 'cell-not-recorded';
                                            $statusIcon = 'fa-question-circle';
                                            $statusBg = '#ffffff';
                                    }
                                }
                            ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDay && $currentDay <= $daysInMonth): ?>
                                <td class="calendar-cell <?php echo e($statusClass); ?>" style="background-color: <?php echo e($statusBg); ?>;">
                                    <div class="cell-header">
                                        <span class="day-number"><?php echo e($currentDay); ?></span>
                                        <i class="fas <?php echo e($statusIcon); ?> status-icon"></i>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($record && $status != 'absent'): ?>
                                        <div class="cell-details">
                                            <div class="hours-badge">
                                                <i class="fas fa-clock me-1"></i>
                                                <span class="fw-semibold"><?php echo e(number_format($hours, 1)); ?>h</span>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($overtime > 0): ?>
                                                    <span class="overtime-badge-modern">
                                                        +<?php echo e(number_format($overtime, 1)); ?>

                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($project): ?>
                                                <div class="project-badge" title="<?php echo e($project); ?>">
                                                    <i class="fas fa-building me-1"></i>
                                                    <span><?php echo e(Str::limit($project, 12)); ?></span>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php elseif($status == 'absent'): ?>
                                        <div class="cell-details">
                                            <div class="absent-message">
                                                <i class="fas fa-user-slash me-1"></i>
                                                <span>Absent</span>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="cell-details">
                                            <div class="not-recorded-message">
                                                <i class="fas fa-clock me-1"></i>
                                                <span>No record</span>
                                            </div>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <?php $currentDay++ ?>
                            <?php else: ?>
                                <td class="calendar-cell empty-cell">?</td>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tr>
                <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Legend -->
    <div class="mt-3 d-flex justify-content-center gap-3 flex-wrap mb-3">
        <div class="legend-item">
            <span class="legend-dot present-dot"></span>
            <span class="legend-text">Present (5-9h)</span>
        </div>
        <div class="legend-item">
            <span class="legend-dot half-dot"></span>
            <span class="legend-text">Half Day (1-4.5h)</span>
        </div>
        <div class="legend-item">
            <span class="legend-dot absent-dot"></span>
            <span class="legend-text">Absent</span>
        </div>
        <div class="legend-item">
            <span class="legend-dot not-recorded-dot"></span>
            <span class="legend-text">Not Recorded</span>
        </div>
    </div>
</div>

<style>
/* Calendar Modern Styles */
.calendar-modern-wrapper {
    padding: 1rem;
}

.calendar-grid-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 6px;
}

.calendar-weekday {
    padding: 0.75rem;
    text-align: center;
    font-weight: 700;
    font-size: 0.875rem;
    color: #495057;
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.calendar-cell {
    padding: 0.5rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    vertical-align: top;
    min-width: 100px;
    height: 110px;
    background: white;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border: 1px solid #f0f0f0;
}

.calendar-cell:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    z-index: 2;
    border-color: #ff0000;
}

.cell-present {
    border-left: 3px solid #28a745;
}

.cell-absent {
    border-left: 3px solid #dc3545;
}

.cell-half {
    border-left: 3px solid #ffc107;
}

.cell-not-recorded {
    border-left: 3px solid #6c757d;
    background: #fafafa;
}

.empty-cell {
    background: #f8f9fa;
    opacity: 0.5;
}

.cell-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
    padding-bottom: 0.25rem;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.day-number {
    font-weight: 800;
    font-size: 1rem;
    color: #2c3e50;
}

.status-icon {
    font-size: 0.875rem;
    opacity: 0.7;
}

.cell-details {
    font-size: 0.75rem;
}

.hours-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(0,0,0,0.05);
    padding: 0.125rem 0.375rem;
    border-radius: 0.375rem;
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.overtime-badge-modern {
    background: #ff9800;
    color: white;
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
    font-size: 0.625rem;
    font-weight: 700;
    margin-left: 0.25rem;
}

.project-badge {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-top: 0.25rem;
    color: #6c757d;
    font-size: 0.6875rem;
}

.absent-message, .not-recorded-message {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: #6c757d;
    font-size: 0.75rem;
    margin-top: 0.5rem;
}

.legend-item {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
}

.present-dot { background: #28a745; }
.half-dot { background: #ffc107; }
.absent-dot { background: #dc3545; }
.not-recorded-dot { background: #6c757d; }

.legend-text {
    font-size: 0.75rem;
    color: #6c757d;
}

/* Responsive */
@media (max-width: 768px) {
    .calendar-cell {
        min-width: 60px;
        height: 80px;
        padding: 0.25rem;
    }
    
    .day-number {
        font-size: 0.75rem;
    }
    
    .hours-badge {
        font-size: 0.625rem;
    }
    
    .calendar-weekday {
        font-size: 0.75rem;
        padding: 0.5rem;
    }
    
    .calendar-grid-table {
        border-spacing: 3px;
    }
}
</style><?php /**PATH C:\xampp\htdocs\ERP-System\resources\views\livewire\hr\payroll\partials\calendar-view.blade.php ENDPATH**/ ?>