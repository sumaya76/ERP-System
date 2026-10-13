<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-menu-collapsed" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-no-customizer">

<head>

    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Admin Dashboard</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('build/assets/img/builddesk-erp-logo.png')); ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/fonts/fontawesome.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/fonts/tabler-icons.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/fonts/flag-icons.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/flatpickr/flatpickr.css')); ?>" />

    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css')); ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/css/rtl/core.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/css/rtl/theme-default.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/css/demo.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/erp-theme.css')); ?>" />

    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/node-waves/node-waves.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/typeahead-js/typeahead.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/apex-charts/apex-charts.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/swiper/swiper.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')); ?>" />
    <link rel="stylesheet"
        href="<?php echo e(asset('build/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')); ?>" />
    <link rel="stylesheet"
        href="<?php echo e(asset('build/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')); ?>" />

    <!-- Dropzone, Select2, Tagify -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/dropzone/dropzone.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/select2/select2.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/tagify/tagify.css')); ?>" />

    <!-- Bootstrap Select (Bootstrap 5 Compatible) -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css" />

    <!-- Date/Time Pickers -->
    <link rel="stylesheet"
        href="<?php echo e(asset('build/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')); ?>" />
    <link rel="stylesheet"
        href="<?php echo e(asset('build/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/libs/pickr/pickr-themes.css')); ?>" />

    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/vendor/css/pages/cards-advance.css')); ?>" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <!-- Helpers & Config -->
    <script src="<?php echo e(asset('build/assets/vendor/js/helpers.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/js/config.js')); ?>"></script>

    <!-- Template Customizer -->
    <script src="<?php echo e(asset('build/assets/vendor/js/template-customizer.js')); ?>"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="#" class="app-brand-link">
                        <img class="erp-brand-logo" src="<?php echo e(asset('build/assets/img/builddesk-erp-logo.png')); ?>" alt="BuildDesk ERP">
                    </a>
                    <a href="#" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item active open">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="menu-link">
                            <i class="menu-icon fa-solid fa-chart-pie fs-6"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>
                    <!-- Payroll Management Dropdown -->
                    <li class="menu-item">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-calculator fs-6"></i>
                            <div>Payroll Management</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="<?php echo e(route('admin.payroll-dashboard')); ?>" class="menu-link">
                                    <i class="fa-solid fa-chart-line fa-xs me-2" style="color: #6c757d;"></i>
                                    <div style="color: #6c757d;">Payroll Dashboard</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo e(route('admin.payroll-summary')); ?>" class="menu-link">
                                    <i class="fa-solid fa-file-invoice-dollar fa-xs me-2" style="color: #6c757d;"></i>
                                    <div style="color: #6c757d;">Payroll Summary</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo e(route('admin.worker-profile')); ?>" class="menu-link">
                                    <i class="fa-solid fa-users fa-xs me-2" style="color: #6c757d;"></i>
                                    <div style="color: #6c757d;">Worker Profile</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Financial Management Dropdown -->
                    <li class="menu-item">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-chart-line fs-6"></i>
                            <div>Finance</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="<?php echo e(route('admin.expenses')); ?>" class="menu-link">
                                    <i class="fa-solid fa-file-invoice fa-xs me-2" style="color: #6c757d;"></i>
                                    <div style="color: #6c757d;">Project Expenses</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo e(route('admin.profit-loss')); ?>" class="menu-link">
                                    <i class="fa-solid fa-chart-simple fa-xs me-2" style="color: #6c757d;"></i>
                                    <div style="color: #6c757d;">Profit & Loss</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Budget Quotations (single item - no dropdown) -->
                    <li class="menu-item">
                        <a href="<?php echo e(route('admin.budget-quotations')); ?>" class="menu-link">
                            <i class="menu-icon fa-solid fa-file-invoice-dollar fs-6"></i>
                            <div>Budget Quotations</div>
                        </a>
                    </li>

                    <!-- Sales Invoice Dropdown -->
                    <li class="menu-item">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-file-invoice fs-6"></i>
                            <div>Sales Invoice</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="<?php echo e(route('admin.sales-invoices.create')); ?>" class="menu-link">
                                    <i class="fa-solid fa-plus fa-xs me-2" style="color: #6c757d;"></i>
                                    <div style="color: #6c757d;">Sale Invoice Form</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo e(route('admin.sales-invoices.list')); ?>" class="menu-link">
                                    <i class="fa-solid fa-list fa-xs me-2" style="color: #6c757d;"></i>
                                    <div style="color: #6c757d;">Sale Invoices List</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item <?php echo e(request()->routeIs('admin.procurement') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.procurement')); ?>" class="menu-link">
                            <i class="menu-icon fa-solid fa-boxes-stacked fs-6"></i>
                            <div>Procurement & Inventory</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo e(request()->routeIs('admin.project-workspace') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.project-workspace')); ?>" class="menu-link">
                            <i class="menu-icon fa-solid fa-chart-gantt fs-6"></i>
                            <div>Project Workspace</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo e(request()->routeIs('admin.approvals') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.approvals')); ?>" class="menu-link">
                            <i class="menu-icon fa-solid fa-clipboard-check fs-6"></i>
                            <div>Approvals</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo e(request()->routeIs('admin.notifications') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.notifications')); ?>" class="menu-link">
                            <i class="menu-icon fa-solid fa-bell fs-6"></i>
                            <div>Notifications</div>
                        </a>
                    </li>

                    <!-- Logout -->
                    <li class="menu-item">
                        <a href="<?php echo e(route('logout')); ?>" class="menu-link">
                            <i class="menu-icon fa-solid fa-right-from-bracket fs-6"></i>
                            <div>Log Out</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page mt-2">
                <!-- Content wrapper -->
                <div class="content-wrapper flex-grow-1">
                    <!-- Content -->
                    <div class="px-3 ">
                        <?php echo e($slot); ?>

                    </div>
                </div>

                <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="content-backdrop fade"></div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="<?php echo e(asset('build/assets/vendor/libs/jquery/jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/popper/popper.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/node-waves/node-waves.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/hammer/hammer.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/i18n/i18n.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/typeahead-js/typeahead.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/js/menu.js')); ?>"></script>

    <!-- Vendors JS -->
    <script src="<?php echo e(asset('build/assets/vendor/libs/apex-charts/apexcharts.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/swiper/swiper.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/select2/select2.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/dropzone/dropzone.js')); ?>"></script>

    <!-- Bootstrap Select (Bootstrap 5 Compatible) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

    <!-- Page Specific JS -->

    <script src="<?php echo e(asset('build/assets/js/dashboards-analytics.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/js/forms-file-upload.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/moment/moment.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/flatpickr/flatpickr.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/vendor/libs/pickr/pickr.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/js/forms-pickers.js')); ?>"></script>
    <script src="<?php echo e(asset('build/assets/js/main.js')); ?>"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/layouts/admindashboard.blade.php ENDPATH**/ ?>