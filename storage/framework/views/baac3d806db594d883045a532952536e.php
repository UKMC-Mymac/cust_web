<div class="th-menu-wrapper">
    <div class="th-menu-area text-center">
        <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
        <div class="mobile-logo">
            <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('dist/images/logo.png')); ?>" alt="CUST"></a>
        </div>
        <div class="th-mobile-menu">
            <ul>
                <?php if($navbarItems->isNotEmpty()): ?>
                    <?php echo $__env->make('web.custom.components.partials.nav-items', ['items' => $navbarItems], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php else: ?>
                    <li>
                        <a href="<?php echo e(route('home')); ?>">Home</a>
                    </li>
                <?php endif; ?>
                <?php if(auth()->guard('web')->check()): ?>
                    <li class="d-block d-md-none">
                        <a href="<?php echo e(route('admin.dashboard.index')); ?>">Dashboard</a>
                    </li>
                <?php elseif(auth()->guard('student')->check()): ?>
                    <li class="d-block d-md-none">
                        <a href="<?php echo e(route('student.dashboard.index')); ?>">Student Dashboard</a>
                    </li>
                <?php else: ?>
                    <li class="d-block d-md-none">
                       <a href="#">Student Login</a>
                    </li>
                    <li class="d-block d-md-none">
                       <a href="#">Staff Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/components/mobile-navigation.blade.php ENDPATH**/ ?>