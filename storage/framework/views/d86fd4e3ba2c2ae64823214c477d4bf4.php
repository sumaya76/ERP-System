
<div id="admin-dashboard">    
    <!-- MAIN CARD WRAPPER -->
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
    
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            25% { transform: translateY(-20px) translateX(10px); }
            50% { transform: translateY(10px) translateX(-15px); }
            75% { transform: translateY(-10px) translateX(15px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .dashboard-card {
            animation: fadeInUp 0.6s ease-out;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }
        
        .clickable-card {
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .clickable-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }
        
        .quick-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .quick-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .quick-btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
        }
        
        .table-row {
            transition: all 0.2s ease;
        }
        
        .table-row:hover {
            background: #f8fafc;
            transform: scale(1.01);
        }
    </style>
    
    <!-- Header Section with Gradient -->
    <div style="background: linear-gradient(135deg, #ff0000 0%, #8b0000 50%, #000000 100%); padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); position: relative; overflow: hidden;">
        
        <!-- Animated Background Elements -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.03) 50%, transparent 70%); background-size: 200% 200%; animation: shimmer 3s ease infinite;"></div>
        
        <!-- Circles -->
        <div style="position: absolute; top: -50%; right: -10%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(255,255,255,0.15), rgba(255,255,255,0)); border-radius: 50%; animation: float 20s ease-in-out infinite;"></div>
        <div style="position: absolute; bottom: -30%; left: -5%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.1), rgba(255,255,255,0)); border-radius: 50%; animation: float 15s ease-in-out infinite reverse;"></div>
        <div style="position: absolute; top: 20%; left: 20%; width: 150px; height: 150px; background: radial-gradient(circle, rgba(255,255,255,0.08), rgba(255,255,255,0)); border-radius: 50%; animation: pulse 8s ease-in-out infinite;"></div>
        <div style="position: absolute; top: 60%; right: 20%; width: 120px; height: 120px; background: radial-gradient(circle, rgba(255,255,255,0.12), rgba(255,255,255,0)); border-radius: 50%; animation: float 12s ease-in-out infinite 2s;"></div>
        <div style="position: absolute; bottom: 10%; right: 35%; width: 80px; height: 80px; background: radial-gradient(circle, rgba(255,255,255,0.1), rgba(255,255,255,0)); border-radius: 50%; animation: pulse 6s ease-in-out infinite 1s;"></div>
        
        <!-- Diagonal Lines Pattern -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: repeating-linear-gradient(45deg, rgba(255,255,255,0.02) 0px, rgba(255,255,255,0.02) 2px, transparent 2px, transparent 8px); pointer-events: none;"></div>
        
        <!-- Dots Pattern -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 30px 30px; pointer-events: none;"></div>
        
        <!-- Border Accent Lines -->
        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), rgba(255,255,255,0.6), rgba(255,255,255,0.3), transparent);"></div>
        
        <div style="display: flex; justify-content: space-between; align-items: stretch; flex-wrap: wrap; gap: 30px; position: relative; z-index: 1;">
            
            <!-- Left Content -->
            <div style="flex: 1.5;">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 15px; padding: 8px 16px; margin-right: 15px; backdrop-filter: blur(5px);">
                        <i class="fas fa-chart-line" style="color: white; font-size: 16px;"></i>
                    </div>
                    <span style="background: white; padding: 8px 20px; border-radius: 25px; color: black; font-size: 14px; font-weight: 600;">Admin Dashboard</span>
                </div>
                
                <h1 style="color: white; font-size: 42px; font-weight: 800; margin-bottom: 15px; letter-spacing: -1px;">
                    Welcome to Admin Dashboard
                </h1>
                <h2 style="color: rgba(255,255,255,0.95); font-size: 28px; font-weight: 600; margin-bottom: 20px;">
                    <?php echo e(auth()->user()->name); ?>

                </h2>
                <p style="color: rgba(255,255,255,0.85); font-size: 16px; max-width: 550px; margin-bottom: 25px; line-height: 1.5;">
                    Complete business overview including workforce analytics, financial performance, and strategic insights.
                </p>
                
                <div style="display: flex; gap: 25px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.15); padding: 8px 18px; border-radius: 12px; backdrop-filter: blur(5px);">
                        <i class="fas fa-sync-alt" style="color: rgba(255,255,255,0.9); font-size: 14px;"></i>
                        <div>
                            <small style="color: rgba(255,255,255,0.7); display: block; font-size: 11px;">Last updated</small>
                            <small style="color: white; font-weight: 500;"><?php echo e(now()->format('h:i:s A')); ?></small>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.15); padding: 8px 18px; border-radius: 12px; backdrop-filter: blur(5px);">
                        <i class="fas fa-calendar-alt" style="color: rgba(255,255,255,0.9); font-size: 14px;"></i>
                        <div>
                            <small style="color: rgba(255,255,255,0.7); display: block; font-size: 11px;">Current Date</small>
                            <small style="color: white; font-weight: 500;"><?php echo e(now()->format('F d, Y')); ?></small>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.15); padding: 8px 18px; border-radius: 12px; backdrop-filter: blur(5px);">
                        <i class="fas fa-clock" style="color: rgba(255,255,255,0.9); font-size: 14px;"></i>
                        <div>
                            <small style="color: rgba(255,255,255,0.7); display: block; font-size: 11px;">Current Time</small>
                            <small style="color: white; font-weight: 500;" id="currentTime"><?php echo e(now()->format('h:i A')); ?></small>
                        </div>
                    </div>
                </div>
                
                <!-- KPI Overview Card -->
                <div style="background: white; border-radius: 15px; padding: 15px; margin-top: 20px; width: 500px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <i class="fas fa-chart-simple" style="color: #ff0000; font-size: 16px;"></i>
                        <span style="color: black; font-weight: 600; font-size: 13px;">Key Performance Indicators</span>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span style="color: #6b7280; font-size: 11px;">Attendance Rate</span>
                                <span style="color: black; font-size: 11px; font-weight: 600;"><?php echo e($quickStats['attendance_rate'] ?? 0); ?>%</span>
                            </div>
                            <div style="background: #e5e7eb; border-radius: 10px; height: 4px; overflow: hidden;">
                                <div style="background: #10b981; width: <?php echo e($quickStats['attendance_rate'] ?? 0); ?>%; height: 100%;"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span style="color: #6b7280; font-size: 11px;">Medical Compliance</span>
                                <span style="color: black; font-size: 11px; font-weight: 600;"><?php echo e($medicalStatus['valid_percentage'] ?? 0); ?>%</span>
                            </div>
                            <div style="background: #e5e7eb; border-radius: 10px; height: 4px; overflow: hidden;">
                                <div style="background: #f59e0b; width: <?php echo e($medicalStatus['valid_percentage'] ?? 0); ?>%; height: 100%;"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span style="color: #6b7280; font-size: 11px;">Profit Margin</span>
                                <span style="color: black; font-size: 11px; font-weight: 600;"><?php echo e($financialStats['profit_margin'] ?? 0); ?>%</span>
                            </div>
                            <div style="background: #e5e7eb; border-radius: 10px; height: 4px; overflow: hidden;">
                                <div style="background: #3b82f6; width: <?php echo e($financialStats['profit_margin'] ?? 0); ?>%; height: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Content - Stats Panels -->
            <div style="flex: 1; display: flex; flex-direction: column; gap: 15px;">
                
                <!-- Row 1: Two Cards -->
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div onclick="window.location='<?php echo e(route('admin.worker-profile')); ?>'" style="background: white; border-radius: 20px; padding: 20px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)';">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <p style="color: #6b7280; font-size: 12px; font-weight: 600;">TOTAL WORKERS</p>
                                <h3 style="font-size: 36px; font-weight: 800; color: #1f2937; margin: 0;"><?php echo e(number_format($quickStats['total_workers'])); ?></h3>
                            </div>
                            <div style="background: #ff000020; border-radius: 15px; padding: 10px;">
                                <i class="fas fa-users" style="color: #ff0000; font-size: 24px;"></i>
                            </div>
                        </div>
                        <div style="margin-top: 10px;">
                            <span style="color: #10b981;">✓ <?php echo e($quickStats['active_workers']); ?> Active</span>
                        </div>
                    </div>
                    
                    <div onclick="window.location='{#}'" style="background: white; border-radius: 20px; padding: 20px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)';">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <p style="color: #6b7280; font-size: 12px; font-weight: 600;">TOTAL PROJECTS</p>
                                <h3 style="font-size: 36px; font-weight: 800; color: #1f2937; margin: 0;"><?php echo e(number_format($quickStats['total_projects'])); ?></h3>
                            </div>
                            <div style="background: #10b98120; border-radius: 15px; padding: 10px;">
                                <i class="fas fa-project-diagram" style="color: #10b981; font-size: 24px;"></i>
                            </div>
                        </div>
                        <div style="margin-top: 10px;">
                            <span style="color: #3b82f6;">✓ <?php echo e($quickStats['active_projects']); ?> Active</span>
                        </div>
                    </div>
                </div>
                
                <!-- Row 2: Two Cards -->
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div onclick="window.location='<?php echo e(route('admin.sales-invoices.list')); ?>'" style="background: white; border-radius: 20px; padding: 20px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)';">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <p style="color: #6b7280; font-size: 12px; font-weight: 600;">MONTHLY REVENUE</p>
                                <h3 style="font-size: 24px; font-weight: 800; color: #1f2937; margin: 0;">€<?php echo e(number_format($financialStats['total_revenue'] ?? 0, 2)); ?></h3>
                            </div>
                            <div style="background: #f59e0b20; border-radius: 15px; padding: 10px;">
                                <i class="fas fa-chart-line" style="color: #f59e0b; font-size: 24px;"></i>
                            </div>
                        </div>
                        <div style="margin-top: 10px;">
                            <small><?php echo e($financialStats['invoices_count'] ?? 0); ?> Invoices</small>
                        </div>
                    </div>
                    
                    <div onclick="window.location='<?php echo e(route('admin.profit-loss')); ?>'" style="background: white; border-radius: 20px; padding: 20px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)';">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <p style="color: #6b7280; font-size: 12px; font-weight: 600;">NET PROFIT</p>
                                <h3 style="font-size: 24px; font-weight: 800; color: <?php echo e(($financialStats['net_profit'] ?? 0) >= 0 ? '#10b981' : '#ef4444'); ?>; margin: 0;">€<?php echo e(number_format($financialStats['net_profit'] ?? 0, 2)); ?></h3>
                            </div>
                            <div style="background: #8b5cf620; border-radius: 15px; padding: 10px;">
                                <i class="fas fa-chart-pie" style="color: #8b5cf6; font-size: 24px;"></i>
                            </div>
                        </div>
                        <div style="margin-top: 10px;">
                            <small>Margin: <?php echo e($financialStats['profit_margin'] ?? 0); ?>%</small>
                        </div>
                    </div>
                </div>
                
                <!-- Row 3: Three Cards -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    <div onclick="window.location='<?php echo e(route('admin.payroll-dashboard')); ?>'" style="background: white; border-radius: 20px; padding: 15px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)';">
                        <p style="color: #6b7280; font-size: 11px; font-weight: 600;">PAYROLL COST</p>
                        <h4 style="font-size: 18px; font-weight: 800; margin: 5px 0;">€<?php echo e(number_format($financialStats['total_payroll'] ?? 0, 2)); ?></h4>
                        <small><?php echo e($payrollStats['total_workers_paid'] ?? 0); ?> Workers</small>
                    </div>
                    
                    <div onclick="window.location='<?php echo e(route('admin.expenses')); ?>'" style="background: white; border-radius: 20px; padding: 15px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)';">
                        <p style="color: #6b7280; font-size: 11px; font-weight: 600;">OTHER EXPENSES</p>
                        <h4 style="font-size: 18px; font-weight: 800; margin: 5px 0;">€<?php echo e(number_format($financialStats['total_expenses'] ?? 0, 2)); ?></h4>
                        <small><?php echo e($financialStats['expenses_count'] ?? 0); ?> Transactions</small>
                    </div>
                    
                    <div onclick="window.location='<?php echo e(route('admin.worker-profile')); ?>?tab=advances'" style="background: white; border-radius: 20px; padding: 15px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)';">
                        <p style="color: #6b7280; font-size: 11px; font-weight: 600;">PENDING ADVANCES</p>
                        <h4 style="font-size: 18px; font-weight: 800; margin: 5px 0; color: #ef4444;">€<?php echo e(number_format($quickStats['pending_advances_total'] ?? 0, 2)); ?></h4>
                        <small><?php echo e($quickStats['workers_with_advances'] ?? 0); ?> Workers</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div style="background: white; border-radius: 15px; padding: 20px; margin: 30px 30px 30px 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div style="display: flex; gap: 10px;">
            <button wire:click="$set('dateRange', 'current_month')" style="padding: 10px 24px; border-radius: 10px; border: none; font-weight: 600; cursor: pointer; transition: all 0.3s; <?php echo e($dateRange == 'current_month' ? 'background: linear-gradient(135deg, #ff0000 0%, #000000 100%); color: white;' : 'background: #f3f4f6; color: #4b5563;'); ?>">
                Current Month
            </button>
            <button wire:click="$set('dateRange', 'previous_month')" style="padding: 10px 24px; border-radius: 10px; border: none; font-weight: 600; cursor: pointer; transition: all 0.3s; <?php echo e($dateRange == 'previous_month' ? 'background: linear-gradient(135deg, #ff0000 0%, #000000 100%); color: white;' : 'background: #f3f4f6; color: #4b5563;'); ?>">
                Previous Month
            </button>
        </div>
        <div style="display: flex; gap: 10px;">
            <select wire:model.live="selectedMonth" style="padding: 10px 16px; border-radius: 10px; border: 1px solid #e5e7eb; background: white; cursor: pointer;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <option value="<?php echo e($key); ?>"><?php echo e($month); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            <select wire:model.live="selectedYear" style="padding: 10px 16px; border-radius: 10px; border: 1px solid #e5e7eb; background: white; cursor: pointer;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            <button wire:click="loadDashboardData" style="background: linear-gradient(135deg, #ff0000 0%, #000000 100%); color: white; padding: 10px 24px; border-radius: 10px; border: none; font-weight: 600; cursor: pointer;">
                <i class="fas fa-sync-alt" style="margin-right: 8px;"></i>Refresh
            </button>
        </div>
    </div>

    <!-- Quick Action Buttons Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin: 0 30px 30px 30px;">
        <button wire:click="goToPage('<?php echo e(route('admin.worker-profile')); ?>')" class="quick-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 18px; border-radius: 15px; border: none; color: white; cursor: pointer;">
            <i class="fas fa-users" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
            <div style="font-weight: 700;">Workers</div>
            <div style="font-size: 11px; opacity: 0.9;">Manage Workforce</div>
        </button>
        
     
        
        <button wire:click="goToPage('<?php echo e(route('admin.sales-invoices.list')); ?>')" class="quick-btn" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 18px; border-radius: 15px; border: none; color: white; cursor: pointer;">
            <i class="fas fa-file-invoice-dollar" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
            <div style="font-weight: 700;">Invoices</div>
            <div style="font-size: 11px; opacity: 0.9;">Sales Invoices</div>
        </button>
        
        <button wire:click="goToPage('<?php echo e(route('admin.expenses')); ?>')" class="quick-btn" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 18px; border-radius: 15px; border: none; color: white; cursor: pointer;">
            <i class="fas fa-receipt" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
            <div style="font-weight: 700;">Expenses</div>
            <div style="font-size: 11px; opacity: 0.9;">Track Expenses</div>
        </button>
        
        <button wire:click="goToPage('<?php echo e(route('admin.payroll-dashboard')); ?>')" class="quick-btn" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); padding: 18px; border-radius: 15px; border: none; color: #333; cursor: pointer;">
            <i class="fas fa-coins" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
            <div style="font-weight: 700;">Payroll</div>
            <div style="font-size: 11px; opacity: 0.9;">Manage Payroll</div>
        </button>
        
        <button wire:click="goToPage('<?php echo e(route('admin.profit-loss')); ?>')" class="quick-btn" style="background: linear-gradient(135deg, #b1f4cf 0%, #5e5bea 100%); padding: 18px; border-radius: 15px; border: none; color: white; cursor: pointer;">
            <i class="fas fa-chart-line" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
            <div style="font-weight: 700;">P&L Report</div>
            <div style="font-size: 11px; opacity: 0.9;">Profit & Loss</div>
        </button>
        
        <button wire:click="goToPage('<?php echo e(route('admin.budget-quotations')); ?>')" class="quick-btn" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); padding: 18px; border-radius: 15px; border: none; color: #333; cursor: pointer;">
            <i class="fas fa-file-alt" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
            <div style="font-weight: 700;">Quotations</div>
            <div style="font-size: 11px; opacity: 0.9;">Budget & Quotes</div>
        </button>
        
        <button wire:click="goToPage('{#}')" class="quick-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 18px; border-radius: 15px; border: none; color: white; cursor: pointer;">
            <i class="fas fa-user-shield" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
            <div style="font-weight: 700;">Users</div>
            <div style="font-size: 11px; opacity: 0.9;">System Users</div>
        </button>
    </div>

    <!-- HR Stats Section (Same as HR Dashboard) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin: 0 30px 25px 30px;">
        <div class="clickable-card" onclick="window.location='<?php echo e(route('admin.worker-profile')); ?>'" style="background: white; border-radius: 15px; padding: 20px; border: 1px solid #e5e7eb;">
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <p style="color: #6b7280; font-size: 13px;">Total Workers</p>
                    <h3 style="font-size: 32px; font-weight: 800;"><?php echo e(number_format($quickStats['total_workers'])); ?></h3>
                    <small style="color: #10b981;"><?php echo e($quickStats['active_workers']); ?> Active</small>
                </div>
                <div style="background: rgba(255,0,0,0.1); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-users fa-2x" style="color: #ff0000;"></i>
                </div>
            </div>
        </div>
        
        <div class="clickable-card" onclick="window.location='{#}'" style="background: white; border-radius: 15px; padding: 20px; border: 1px solid #e5e7eb;">
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <p style="color: #6b7280; font-size: 13px;">Active Projects</p>
                    <h3 style="font-size: 32px; font-weight: 800;"><?php echo e(number_format($quickStats['active_projects'])); ?></h3>
                    <small style="color: #3b82f6;"><?php echo e($quickStats['completed_projects']); ?> Completed</small>
                </div>
                <div style="background: rgba(16,185,129,0.1); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-project-diagram fa-2x" style="color: #10b981;"></i>
                </div>
            </div>
        </div>
        
        <div class="clickable-card" onclick="window.location='{#}'" style="background: white; border-radius: 15px; padding: 20px; border: 1px solid #e5e7eb;">
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <p style="color: #6b7280; font-size: 13px;">Attendance Rate</p>
                    <h3 style="font-size: 32px; font-weight: 800;"><?php echo e($quickStats['attendance_rate']); ?>%</h3>
                    <small><?php echo e($quickStats['attendance_days']); ?> / <?php echo e($quickStats['total_attendance_days']); ?> days</small>
                </div>
                <div style="background: rgba(245,158,11,0.1); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-calendar-check fa-2x" style="color: #f59e0b;"></i>
                </div>
            </div>
        </div>
        
        <div class="clickable-card" onclick="window.location='<?php echo e(route('admin.worker-profile')); ?>?tab=advances'" style="background: white; border-radius: 15px; padding: 20px; border: 1px solid #e5e7eb;">
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <p style="color: #6b7280; font-size: 13px;">Pending Advances</p>
                    <h3 style="font-size: 22px; font-weight: 800;">€<?php echo e(number_format($quickStats['pending_advances_total'], 2)); ?></h3>
                    <small style="color: #ef4444;"><?php echo e($quickStats['workers_with_advances']); ?> Workers</small>
                </div>
                <div style="background: rgba(239,68,68,0.1); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-hand-holding-usd fa-2x" style="color: #ef4444;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Overview Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 25px; margin: 0 30px 30px 30px;">
        
        <!-- Profit & Loss Chart -->
        <div class="dashboard-card" style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <div style="margin-bottom: 20px; border-bottom: 2px solid #ff0000; padding-bottom: 15px;">
                <h3 style="font-size: 18px; font-weight: 700;">
                    <i class="fas fa-chart-line" style="margin-right: 10px; color: #ff0000;"></i>Profit & Loss Trend
                </h3>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 12px; text-align: left;">Month</th>
                            <th style="padding: 12px; text-align: right;">Revenue</th>
                            <th style="padding: 12px; text-align: right;">Expenses</th>
                            <th style="padding: 12px; text-align: right;">Payroll</th>
                            <th style="padding: 12px; text-align: right;">Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $profitLossData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <tr style="border-bottom: 1px solid #f0f0f0;">
                            <td style="padding: 12px; font-weight: 600;"><?php echo e($data['month']); ?></td>
                            <td style="padding: 12px; text-align: right; color: #10b981;">€<?php echo e(number_format($data['revenue'], 2)); ?></td>
                            <td style="padding: 12px; text-align: right; color: #ef4444;">€<?php echo e(number_format($data['expenses'], 2)); ?></td>
                            <td style="padding: 12px; text-align: right; color: #f59e0b;">€<?php echo e(number_format($data['payroll'], 2)); ?></td>
                            <td style="padding: 12px; text-align: right; font-weight: 700; color: <?php echo e($data['profit'] >= 0 ? '#10b981' : '#ef4444'); ?>;">€<?php echo e(number_format($data['profit'], 2)); ?></td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Top Projects by Revenue -->
        <div class="dashboard-card" style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <div style="margin-bottom: 20px; border-bottom: 2px solid #ff0000; padding-bottom: 15px;">
                <h3 style="font-size: 18px; font-weight: 700;">
                    <i class="fas fa-trophy" style="margin-right: 10px; color: #ff0000;"></i>Top Projects by Revenue
                </h3>
            </div>
            <div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topProjectsByRevenue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: 600;"><?php echo e($project['project_name']); ?></span>
                        <span style="color: #10b981; font-weight: 700;">€<?php echo e(number_format($project['total_revenue'], 2)); ?></span>
                    </div>
                    <div style="background: #e5e7eb; border-radius: 8px; height: 6px; overflow: hidden;">
                        <div style="background: linear-gradient(90deg, #ff0000, #000000); width: <?php echo e(($project['total_revenue'] / max(collect($topProjectsByRevenue)->first()['total_revenue'] ?? 1, 1)) * 100); ?>%; height: 100%;"></div>
                    </div>
                    <small style="color: #6b7280;"><?php echo e($project['invoice_count']); ?> invoices</small>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <p style="text-align: center; padding: 40px; color: #6b7280;">No project revenue data available</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Invoices & Expenses -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 25px; margin: 0 30px 30px 30px;">
        
        <!-- Recent Invoices -->
        <div class="dashboard-card" style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <div style="margin-bottom: 20px;">
                <h3 style="font-size: 18px; font-weight: 700;">
                    <i class="fas fa-file-invoice" style="margin-right: 10px; color: #ff0000;"></i>Recent Invoices
                </h3>
            </div>
            <div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; border-bottom: 1px solid #e5e7eb;">
                    <div>
                        <p style="font-weight: 600; margin-bottom: 3px;"><?php echo e($invoice['invoice_number']); ?></p>
                        <small style="color: #6b7280;"><?php echo e($invoice['client_name']); ?> - <?php echo e($invoice['project_name']); ?></small>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-weight: 700; color: #10b981;">€<?php echo e(number_format($invoice['total'], 2)); ?></p>
                        <span class="badge" style="background: <?php echo e($invoice['payment_status'] == 'paid' ? '#10b98120' : ($invoice['payment_status'] == 'partial' ? '#f59e0b20' : '#ef444420')); ?>; padding: 3px 10px; border-radius: 12px; font-size: 10px; color: <?php echo e($invoice['payment_status'] == 'paid' ? '#10b981' : ($invoice['payment_status'] == 'partial' ? '#f59e0b' : '#ef4444')); ?>;">
                            <?php echo e(ucfirst($invoice['payment_status'])); ?>

                        </span>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <p style="text-align: center; padding: 40px; color: #6b7280;">No recent invoices</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        
        <!-- Recent Expenses -->
        <div class="dashboard-card" style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <div style="margin-bottom: 20px;">
                <h3 style="font-size: 18px; font-weight: 700;">
                    <i class="fas fa-receipt" style="margin-right: 10px; color: #ff0000;"></i>Recent Expenses
                </h3>
            </div>
            <div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; border-bottom: 1px solid #e5e7eb;">
                    <div>
                        <p style="font-weight: 600; margin-bottom: 3px;"><?php echo e($expense['description']); ?></p>
                        <small style="color: #6b7280;"><?php echo e($expense['project_name']); ?> - <?php echo e($expense['category_name']); ?></small>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-weight: 700; color: #ef4444;">€<?php echo e(number_format($expense['amount'], 2)); ?></p>
                        <small><?php echo e(\Carbon\Carbon::parse($expense['expense_date'])->format('d M Y')); ?></small>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <p style="text-align: center; padding: 40px; color: #6b7280;">No recent expenses</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Attendance Trend Table (Same as HR Dashboard) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 25px; margin: 0 30px 30px 30px;">
        
        <div class="dashboard-card" style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <div style="margin-bottom: 20px;">
                <h3 style="font-size: 18px; font-weight: 700;">
                    <i class="fas fa-chart-line" style="margin-right: 10px; color: #ff0000;"></i>Daily Attendance Trend
                </h3>
            </div>
            <div style="overflow-x: auto; max-height: 400px; overflow-y: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="position: sticky; top: 0; background: white;">
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 12px; text-align: left;">Date</th>
                            <th style="padding: 12px; text-align: center;">Present</th>
                            <th style="padding: 12px; text-align: center;">Half Day</th>
                            <th style="padding: 12px; text-align: center;">Absent</th>
                            <th style="padding: 12px; text-align: center;">Hours</th>
                            <th style="padding: 12px; text-align: center;">Attendance %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $attendanceTrend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr class="table-row" style="border-bottom: 1px solid #f0f0f0;">
                                <td style="padding: 12px;"><?php echo e($trend['date']); ?></td>
                                <td style="padding: 12px; text-align: center;">
                                    <span style="background: #10b98120; color: #10b981; padding: 4px 10px; border-radius: 20px; font-size: 12px;"><?php echo e($trend['present']); ?></span>
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    <span style="background: #f59e0b20; color: #f59e0b; padding: 4px 10px; border-radius: 20px; font-size: 12px;"><?php echo e($trend['half_day']); ?></span>
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    <span style="background: #ef444420; color: #ef4444; padding: 4px 10px; border-radius: 20px; font-size: 12px;"><?php echo e($trend['absent']); ?></span>
                                </td>
                                <td style="padding: 12px; text-align: center;"><?php echo e(number_format($trend['hours'], 1)); ?> hrs</td>
                                <td style="padding: 12px; text-align: center;">
                                    <?php
                                        $total = $trend['present'] + $trend['half_day'] + $trend['absent'];
                                        $percentage = $total > 0 ? round((($trend['present'] + ($trend['half_day'] * 0.5)) / $total) * 100, 1) : 0;
                                    ?>
                                    <span style="background: <?php echo e($percentage >= 80 ? '#10b98120' : ($percentage >= 60 ? '#f59e0b20' : '#ef444420')); ?>; padding: 4px 10px; border-radius: 20px; color: <?php echo e($percentage >= 80 ? '#10b981' : ($percentage >= 60 ? '#f59e0b' : '#ef4444')); ?>;"><?php echo e($percentage); ?>%</span>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="6" style="padding: 40px; text-align: center; color: #6b7280;">No attendance data available</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 25px;">
            <!-- Weekly Performance -->
            <div class="dashboard-card" style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">
                    <i class="fas fa-chart-bar" style="margin-right: 10px; color: #ff0000;"></i>Weekly Performance
                </h3>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $weeklyAttendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="font-weight: 600;"><?php echo e($week['week']); ?></span>
                        <span style="color: #6b7280;"><?php echo e($week['present']); ?> days | <?php echo e($week['hours']); ?> hrs</span>
                    </div>
                    <div style="background: #e5e7eb; border-radius: 8px; height: 10px; overflow: hidden;">
                        <div style="background: linear-gradient(90deg, #ff0000, #000000); width: <?php echo e(min(100, ($week['present'] / 7) * 100)); ?>%; height: 100%;"></div>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <p style="text-align: center; padding: 20px;">No weekly data available</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <!-- Department Distribution -->
            <div class="dashboard-card" style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">
                    <i class="fas fa-building" style="margin-right: 10px; color: #ff0000;"></i>Department Distribution
                </h3>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $departmentDistribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-weight: 600;"><?php echo e($dept['department']); ?></span>
                        <span style="color: #6b7280;"><?php echo e($dept['count']); ?> workers</span>
                    </div>
                    <div style="background: #e5e7eb; border-radius: 8px; height: 6px; overflow: hidden;">
                        <div style="background: linear-gradient(90deg, #ff0000, #8b0000); width: <?php echo e(($dept['count'] / max($workerStats['active'], 1)) * 100); ?>%; height: 100%;"></div>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <p style="text-align: center; padding: 20px;">No department data available</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Top Performers & Recent Activity -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 25px; margin: 0 30px 30px 30px;">
        
        <div class="dashboard-card" style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">🏆 Top Performers (This Month)</h3>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topPerformers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $performer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div style="display: flex; align-items: center; gap: 15px; padding: 12px; background: <?php echo e($index == 0 ? 'linear-gradient(135deg, #fef3c7 0%, #fde68a 100%)' : '#f9fafb'); ?>; border-radius: 12px; margin-bottom: 10px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ff0000, #000000); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800;"><?php echo e($index + 1); ?></div>
                <div style="flex: 1;">
                    <p style="font-weight: 700;"><?php echo e($performer['name']); ?></p>
                    <p style="font-size: 12px; color: #6b7280;"><?php echo e($performer['designation']); ?></p>
                </div>
                <div style="text-align: right;">
                    <p style="font-weight: 700; color: #10b981;"><?php echo e($performer['present_days']); ?> days</p>
                    <p style="font-size: 12px;"><?php echo e($performer['total_hours']); ?> hrs</p>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p style="text-align: center; padding: 40px;">No data available</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="dashboard-card" style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">🔄 Recent Activity</h3>
            <div style="max-height: 300px; overflow-y: auto;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border-bottom: 1px solid #e5e7eb;">
                    <div style="width: 35px; height: 35px; background: <?php echo e($activity['type'] == 'worker' ? '#10b98120' : ($activity['type'] == 'invoice' ? '#f59e0b20' : '#8b5cf620')); ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas <?php echo e($activity['type'] == 'worker' ? 'fa-user-plus' : ($activity['type'] == 'invoice' ? 'fa-file-invoice' : 'fa-receipt')); ?>" style="color: <?php echo e($activity['type'] == 'worker' ? '#10b981' : ($activity['type'] == 'invoice' ? '#f59e0b' : '#8b5cf6')); ?>;"></i>
                    </div>
                    <div style="flex: 1;">
                        <p style="font-weight: 600; font-size: 14px;"><?php echo e($activity['title']); ?></p>
                        <p style="font-size: 12px; color: #6b7280;"><?php echo e($activity['description']); ?></p>
                    </div>
                    <div style="font-size: 11px; color: #9ca3af;"><?php echo e($activity['time']); ?></div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <p style="text-align: center; padding: 20px;">No recent activity</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <div style="border-top: 2px solid #e5e7eb; padding-top: 20px; margin-top: 10px;">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 15px;">📅 Upcoming Deadlines</h3>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $upcomingDeadlines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deadline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: #fef3c7; border-radius: 10px; margin-bottom: 8px;">
                    <div>
                        <p style="font-weight: 600; font-size: 13px;"><?php echo e($deadline['title']); ?></p>
                        <p style="font-size: 11px; color: #92400e;"><?php echo e($deadline['type']); ?> Certificate</p>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-weight: 700; color: #dc2626;"><?php echo e($deadline['days_left']); ?> days left</p>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <p style="text-align: center; padding: 20px;">No upcoming deadlines</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            setInterval(function() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                const timeElement = document.getElementById('currentTime');
                if (timeElement) timeElement.textContent = timeString;
            }, 60000);
        });
    </script>
</div><?php /**PATH C:\xampp\htdocs\ERP-System\resources\views\livewire\admin\dashboard.blade.php ENDPATH**/ ?>