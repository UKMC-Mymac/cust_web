<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <?php echo $__env->make('web.custom.components.head-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body>
    <?php echo $__env->make('web.custom.components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('web.custom.components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('web.custom.components.mobile-navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('web.custom.components.search-box', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('web.custom.components.login-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <main>
        <?php if($showBreadcrumb ?? false): ?>
            <?php echo $__env->make('web.custom.components.breadcrumb', [
                'title' => $breadcrumbTitle ?? 'Page',
                'breadcrumbs' => $breadcrumbs ?? [],
                'breadcrumbThemeClass' => $breadcrumbThemeClass ?? 'non-hero2'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <?php echo $__env->make('web.custom.components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('web.custom.components.scroll-top', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('web.custom.components.chat', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('web.custom.components.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(session('show_login')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            try {
                if (typeof jQuery !== 'undefined' && typeof $.magnificPopup !== 'undefined') {
                    $.magnificPopup.open({ items: { src: '#login-form' }, type: 'inline' });
                } else {
                    var el = document.getElementById('login-form');
                    if (el) {
                        el.style.display = 'block';
                    }
                }
            } catch (e) {
                // ignore
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/layouts/app.blade.php ENDPATH**/ ?>