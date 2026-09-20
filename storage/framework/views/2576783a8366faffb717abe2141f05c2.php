
<?php $__env->startSection('title', __('Programs')); ?>

<?php $__env->startSection('content'); ?>

    <section class="bg-body-tertiary py-5">
        <div class="container">
            <div class="row g-4">
                <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $itemImage = !empty($item->attach)
                            ? asset('uploads/course/' . $item->attach)
                            : asset('dist/images/homepage/news-1.jpg');
                        $itemSlug = $item->slug;
                        $itemTitle = $item->title;
                        $itemSummary = \Illuminate\Support\Str::limit(
                            strip_tags($item->feature_text ?? $item->description ?? ''),
                            120,
                            ' ...'
                        );
                        $itemRoute = route('program.single', ['slug' => $itemSlug]);
                    ?>

                    <div class="col-md-6 col-xl-4">
                        <article class="card h-100 border-0 shadow-sm bg-white overflow-hidden">
                            <div class="position-relative">
                                <a href="<?php echo e($itemRoute); ?>" class="d-block">
                                    <img src="<?php echo e($itemImage); ?>" class="card-img-top" alt="<?php echo e($itemTitle); ?>" style="height: 200px; object-fit: cover;">
                                </a>
                            </div>

                            <div class="card-body p-3 p-md-4 d-flex flex-column">
                                <span class="badge rounded-pill bg-danger text-white align-self-start mb-3"><?php echo e(__('Program')); ?></span>
                                <h3 class="h4 fw-bold text-body mb-3">
                                    <a class="text-decoration-none text-body hover-danger" href="<?php echo e($itemRoute); ?>"><?php echo e($itemTitle); ?></a>
                                </h3>

                                <?php if(!empty($itemSummary)): ?>
                                    <p class="text-body-secondary mb-3"><?php echo e($itemSummary); ?></p>
                                <?php endif; ?>

                                <div class="mt-auto d-grid gap-2 pt-3 border-top">
                                    <?php if($item->department): ?>
                                        <div class="d-flex align-items-start gap-2 text-body-secondary small mb-1">
                                            <i class="fa-solid fa-building text-danger mt-1"></i>
                                            <span><?php echo e($item->department->title); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($item->duration)): ?>
                                        <div class="d-flex align-items-center gap-2 text-body-secondary small mb-1">
                                            <i class="fa-solid fa-clock text-danger"></i>
                                            <span><strong><?php echo e(__('Duration:')); ?></strong> <?php echo e($item->duration); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <a class="btn btn-outline-danger mt-2" href="<?php echo e($itemRoute); ?>">
                                        <?php echo e(__('View Details')); ?>

                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0">
                            <?php echo e(__('No programs found.')); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row mt-4 mt-md-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <?php echo e($courses->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.custom.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cust_web\resources\views/web/all-programs.blade.php ENDPATH**/ ?>