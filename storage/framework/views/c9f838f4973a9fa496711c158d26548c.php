<header class="th-header header-layout1">
    <div class="header-top">
        <div class="container-fluid th-container4">
            <div class="row justify-content-start justify-content-md-between align-items-top gy-2">
                <div class="col-auto mt-0 mt-sm-2">
                    <div class="header-logo p-0 ms-0">
                        <a href="<?php echo e(route('home')); ?>">
                            <img class="d-block" src="<?php echo e(asset('dist/images/logo-white.png')); ?>" alt="CUST logo">
                        </a>
                    </div>
                </div>
                <div class="col-auto d-none d-md-block">
                    <div class="header-links">
                        <ul class="header-right-wrap">
                            <?php if(auth()->guard('web')->check()): ?>
                                <li>
                                    <i class="fa-solid fa-user"></i><a href="<?php echo e(route('admin.dashboard.index')); ?>">Dashboard</a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <i class="fa-solid fa-user"></i><a href="<?php echo e(isset($custom_urls['student_login']) ? $custom_urls['student_login']->resolved_url : '#'); ?>">Student Login</a>
                                </li>
                                <li>
                                    <i class="fa-solid fa-user-tie"></i><a href="<?php echo e(isset($custom_urls['staff_login']) ? $custom_urls['staff_login']->resolved_url : '#'); ?>">Staff Login</a>
                                </li>
                            <?php endif; ?>
                           <?php if(isset($topbarSetting->email)): ?>
                            <li>
                                <a href="mailto:<?php echo e($topbarSetting->email ?? ''); ?>">
                                    <i class="fa-sharp fa-solid fa-envelope pe-1"></i>
                                    <?php echo e($topbarSetting->email ?? ''); ?>

                                </a>
                            </li>
                            <?php endif; ?>

                              <?php if(isset($topbarSetting->phone)): ?>
                          <li>
                            <a href="tel:<?php echo e($topbarSetting->phone ?? ''); ?>">
                                <i class="fa-sharp fa-solid fa-phone pe-1"></i>
                                <?php echo e($topbarSetting->phone ?? ''); ?>

                            </a>
                        </li>
                            <?php endif; ?>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-menu-wrap d-inline-block d-lg-none">
        <button type="button" class="th-menu-toggle d-inline-block me-0">
            <i class="far fa-bars"></i>
        </button>
    </div>

    <!-- Main Menu -->
    <?php echo $__env->make('web.custom.components.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Mobile Menu -->
    <?php echo $__env->make('web.custom.components.mobile-navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</header>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/components/header.blade.php ENDPATH**/ ?>