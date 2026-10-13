<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-menu-collapsed" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-no-customizer">

<head>

    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>HR Manager Dashboard</title>
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
        <li class="menu-item <?php echo e(request()->routeIs('hr.dashboard') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('hr.dashboard')); ?>" class="menu-link">
                <i class="menu-icon fa-solid fa-house fs-6"></i>
                <div>Dashboard</div>
            </a>
        </li>
        <!-- Workers Dropdown -->
        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-users fs-6"></i>
                <div>Workers</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?php echo e(route('hr.workers.list')); ?>" class="menu-link">
                        <i class="fa-solid fa-list fa-xs me-2" style="color: #6c757d;"></i>
                        <div style="color: #6c757d;">Worker List</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?php echo e(route('hr.worker.create')); ?>" class="menu-link">
                        <i class="fa-solid fa-user-plus fa-xs me-2" style="color: #6c757d;"></i>
                        <div style="color: #6c757d;">Add Worker</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Projects Dropdown -->
        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-diagram-project fs-6"></i>
                <div>Projects</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?php echo e(route('hr.projects.list')); ?>" class="menu-link">
                        <i class="fa-solid fa-list fa-xs me-2" style="color: #6c757d;"></i>
                        <div style="color: #6c757d;">Project List</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?php echo e(route('hr.project.add')); ?>" class="menu-link">
                        <i class="fa-solid fa-folder-plus fa-xs me-2" style="color: #6c757d;"></i>
                        <div style="color: #6c757d;">Add/Edit Project</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Assigning (single item - no dropdown, just direct link) -->
        <li class="menu-item">
            <a href="<?php echo e(route('hr.project.assignment')); ?>" class="menu-link">
                <i class="menu-icon fa-solid fa-user-check fs-6"></i>
                <div>Project Staffing</div>
            </a>
        </li>

        <!-- Attendance Dropdown -->
        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-calendar-alt fs-6"></i>
                <div>Attendance</div>
            </a>
            <ul class="menu-sub">

                <li class="menu-item">
                    <a href="<?php echo e(route('hr.attendance', ['view' => 'mark'])); ?>" class="menu-link">
                        <i class="fa-solid fa-clock fa-xs me-2" style="color: #6c757d;"></i>
                        <div style="color: #6c757d;">Mark Attendance</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?php echo e(route('hr.attendancesheet')); ?>" class="menu-link">
                        <i class="fa-solid fa-chart-line fa-xs me-2" style="color: #6c757d;"></i>
                        <div style="color: #6c757d;">Attendance Sheet</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Worker Advances Dropdown -->
        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-money-bill-wave fs-6"></i>
                <div>Worker Advances</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?php echo e(route('hr.advances.list')); ?>" class="menu-link">
                        <i class="fa-solid fa-list-alt fa-xs me-2" style="color: #6c757d;"></i>
                        <div style="color: #6c757d;">Advance List</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?php echo e(route('hr.advances.form')); ?>" class="menu-link">
                        <i class="fa-solid fa-money-bill-wave fa-xs me-2" style="color: #6c757d;"></i>
                        <div style="color: #6c757d;">Add/Edit Advance</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Payroll Dropdown -->
        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-file-invoice-dollar fs-6"></i>
                <div>Payroll</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?php echo e(route('payroll.single-worker')); ?>" class="menu-link">
                        <i class="fa-solid fa-user-clock fa-xs me-2" style="color: #6c757d;"></i>
                        <div style="color: #6c757d;">Single Worker Payroll</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?php echo e(route('payroll.history')); ?>" class="menu-link">
                        <i class="fa-solid fa-history fa-xs me-2" style="color: #6c757d;"></i>
                        <div style="color: #6c757d;">Payroll History</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Reports (single item - no dropdown) -->
        <li class="menu-item">
            <a href="<?php echo e(route('hr.projectwiseattendance')); ?>" class="menu-link">
                <i class="menu-icon fa-solid fa-chart-bar fs-6"></i>
                <div>Projectwise Attendance</div>
            </a>
        </li>


        <li class="menu-item">
            <a href="<?php echo e(route('hr.companybillingsystem')); ?>" class="menu-link">
                <i class="menu-icon fa-solid fa-credit-card fs-6"></i>
                <div>Company Billing System</div>
            </a>
        </li>
        <li class="menu-item <?php echo e(request()->routeIs('hr.inventory') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('hr.inventory')); ?>" class="menu-link">
                <i class="menu-icon fa-solid fa-boxes-stacked fs-6"></i>
                <div>Inventory & Requests</div>
            </a>
        </li>
        <li class="menu-item <?php echo e(request()->routeIs('hr.project-workspace') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('hr.project-workspace')); ?>" class="menu-link">
                <i class="menu-icon fa-solid fa-chart-gantt fs-6"></i>
                <div>Project Workspace</div>
            </a>
        </li>
        <li class="menu-item <?php echo e(request()->routeIs('hr.approvals') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('hr.approvals')); ?>" class="menu-link">
                <i class="menu-icon fa-solid fa-clipboard-check fs-6"></i>
                <div>Approvals</div>
            </a>
        </li>
        <li class="menu-item <?php echo e(request()->routeIs('hr.notifications') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('hr.notifications')); ?>" class="menu-link">
                <i class="menu-icon fa-solid fa-bell fs-6"></i>
                <div>Notifications</div>
            </a>
        </li>

        <!-- Logout -->
        <li class="menu-item mt-3">
            <a href="<?php echo e(route('logout')); ?>" class="menu-link">
                <i class="menu-icon fa-solid fa-sign-out-alt fs-6"></i>
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
<?php /**PATH C:\xampp\htdocs\ERP-System\resources\views/layouts/hrmanagerdashboard.blade.php ENDPATH**/ ?>