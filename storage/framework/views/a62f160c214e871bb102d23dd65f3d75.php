<div class="sticky-wrapper">
    <!-- Main Menu Area -->
    <div class="menu-area">
        <div class="container-fluid th-container4 th-container2">
            <div class="menu-wrapp">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="header-left d-flex align-items-center">
                            <div class="header-logo d-none">
                                <a href="<?php echo e(route('home')); ?>">
                                    <img src="<?php echo e(asset('dist/images/logo-white.png')); ?>" alt="CUST Logo" />
                                </a>
                            </div>
                            <nav class="main-menu d-none d-lg-block">
                                <ul>
                                    <?php if($navbarItems->isNotEmpty()): ?>
                                        <?php echo $__env->make('web.custom.components.partials.nav-items', ['items' => $navbarItems], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php else: ?>
                                        <li>
                                            <a href="<?php echo e(route('home')); ?>">Home</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                            <div class="sticky-menu-wrap d-inline-blockx d-lg-none">
                                <button type="button" class="th-menu-toggle d-inline-block">
                                    <i class="far fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/components/navigation.blade.php ENDPATH**/ ?>