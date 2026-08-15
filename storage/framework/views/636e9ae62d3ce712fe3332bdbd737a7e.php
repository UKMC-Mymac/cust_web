<div id="club" class="counter-area1 overflow-hidden">
    <div class="container th-container2">
        <div class="counter-wrap1">
            <?php if(isset($clubs) && $clubs->count() > 0): ?>
                <?php $__currentLoopData = $clubs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $club): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $linkHref = $club->link;
                    if (empty($linkHref) && !empty($club->page)) {
                        $linkHref = url('page/' . ($club->page->slug ?? $club->page->id));
                    } elseif (empty($linkHref) && !empty($club->route_name)) {
                        try {
                            $linkHref = route($club->route_name);
                        } catch (\Exception $e) {
                            $linkHref = '#';
                        }
                    }
                ?>
                <a href="<?php echo e($linkHref ?? '#'); ?>" class="counter-card wow fadeInUp" data-wow-delay="<?php echo e(0.2 * ($index + 1)); ?>s" style="text-decoration: none;">
                    <div class="box-icon">
                        <i class="<?php echo e($club->icon ?? 'fa-solid fa-users'); ?>"></i>
                    </div>
                    <div class="media-body">
                        <p class="box-text"><?php echo e($club->title); ?></p>
                    </div>
                </a>
                <?php if($index < $clubs->count() - 1): ?>
                <div class="divider"></div>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    @media (min-width: 1200px) {
        .counter-wrap1 .divider:last-of-type {
            display: block !important;
        }
    }
</style>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/sections/clubs.blade.php ENDPATH**/ ?>