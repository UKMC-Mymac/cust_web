<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $hasChildren = $item->activeChildrenRecursive->isNotEmpty();
        $currentPageSlug = request()->route('slug');
        $isActive = $item->page && $currentPageSlug === $item->page->slug;
        if ($item->page) {
            $linkUrl = route('page.single', $item->page->slug);
        } elseif ($item->route_name && \Illuminate\Support\Facades\Route::has($item->route_name)) {
            $linkUrl = route($item->route_name);
        } else {
            $linkUrl = $item->url ?: '#';
        }
        $target = $item->target ?: '_self';
    ?>
    <li class="<?php echo e($hasChildren ? 'menu-item-has-children' : ''); ?>">
        <a class="<?php echo e($isActive ? 'active' : ''); ?>" href="<?php echo e($linkUrl); ?>" target="<?php echo e($target); ?>" <?php if($isActive): ?> aria-current="page" <?php endif; ?>><?php echo e($item->label); ?></a>
        <?php if($hasChildren): ?>
            <ul class="sub-menu">
                <?php echo $__env->make('web.custom.components.partials.nav-items', ['items' => $item->activeChildrenRecursive], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </ul>
        <?php endif; ?>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/components/partials/nav-items.blade.php ENDPATH**/ ?>