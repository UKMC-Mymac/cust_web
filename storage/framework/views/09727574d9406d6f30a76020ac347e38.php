<?php $__env->startSection('title', $course->title); ?>

<?php $__env->startSection('social_meta_tags'); ?>
    <?php
        $itemImage = !empty($course->attach)
            ? asset('uploads/course/' . $course->attach)
            : asset('dist/images/homepage/news-1.jpg');
        $itemSummary = \Illuminate\Support\Str::limit(
            strip_tags($course->description ?: ($course->feature_text ?? '')),
            160,
            ' ...'
        );
        $itemUrl = route('program.single', ['slug' => $course->slug]);
    ?>

    <?php if(isset($setting)): ?>
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo e($setting->title); ?>">
    <meta property="og:title" content="<?php echo e($course->title); ?>">
    <meta property="og:description" content="<?php echo e($itemSummary); ?>">
    <meta property="og:url" content="<?php echo e($itemUrl); ?>">
    <meta property="og:image" content="<?php echo e($itemImage); ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="<?php echo '@'.str_replace(' ', '', $setting->title); ?>">
    <meta name="twitter:creator" content="@HiTechParks">
    <meta name="twitter:url" content="<?php echo e($itemUrl); ?>">
    <meta name="twitter:title" content="<?php echo e($course->title); ?>">
    <meta name="twitter:description" content="<?php echo e($itemSummary); ?>">
    <meta name="twitter:image" content="<?php echo e($itemImage); ?>">
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="bg-body-tertiary py-5 overflow-hidden">
        <div class="container">
            <div class="row g-4 g-xl-5 align-items-start">
                <div class="col-lg-8">
                    <article>
                        <figure class="position-relative overflow-hidden rounded shadow-sm bg-white mb-4">
                            <img class="img-fluid w-100" src="<?php echo e($itemImage); ?>" alt="<?php echo e($course->title); ?>">
                        </figure>

                        <div class="mb-4">
                            <span class="badge rounded-pill bg-danger text-white mb-3"><?php echo e(__('Program')); ?></span>
                            <h2 class="display-5 fw-bold lh-sm mb-3 text-body"><?php echo e($course->title); ?></h2>
                        </div>

                        <div class="rounded shadow-sm bg-white p-3 p-md-4 lh-lg text-body-secondary mb-4">
                            <?php echo $course->description; ?>

                        </div>

                        <?php if($course->department): ?>
                            <a class="btn btn-danger d-inline-flex align-items-center gap-2" href="<?php echo e(route('department.programs', ['slug' => $course->department->slug])); ?>">
                                <i class="fa-solid fa-arrow-left"></i>
                                <?php echo e(__('Back to Department')); ?>

                            </a>
                        <?php else: ?>
                            <a class="btn btn-danger d-inline-flex align-items-center gap-2" href="<?php echo e(route('academic')); ?>">
                                <i class="fa-solid fa-arrow-left"></i>
                                <?php echo e(__('Back to Academics')); ?>

                            </a>
                        <?php endif; ?>
                    </article>
                </div>

                <div class="col-lg-4">
                    <aside class="sticky-lg-top" style="top: 2rem;">
                        <div class="card border-0 shadow-sm mb-4 bg-white">
                            <div class="card-body p-3 p-md-4">
                                <h3 class="h4 fw-bold mb-4 text-body border-bottom pb-2">
                                    <?php echo e(__('Program Details')); ?>

                                </h3>

                                <div class="d-grid gap-3">
                                    <?php if($course->department): ?>
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-building"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary"><?php echo e(__('Department')); ?></span>
                                                <strong class="d-block">
                                                    <a href="<?php echo e(route('department.programs', ['slug' => $course->department->slug])); ?>" class="text-decoration-none text-body hover-danger">
                                                        <?php echo e($course->department->title); ?>

                                                    </a>
                                                </strong>
                                            </span>
                                        </div>
                                    <?php endif; ?>


                                    <?php if(!empty($course->duration)): ?>
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-clock"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary"><?php echo e(__('field_duration')); ?></span>
                                                <strong class="d-block"><?php echo e($course->duration); ?></strong>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!empty($course->credits)): ?>
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-book"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary"><?php echo e(__('field_total_credit_hour')); ?></span>
                                                <strong class="d-block"><?php echo e($course->credits); ?></strong>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!empty($course->semesters)): ?>
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-layer-group"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary"><?php echo e(__('Semesters')); ?></span>
                                                <strong class="d-block"><?php echo e($course->semesters); ?></strong>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!empty($course->courses)): ?>
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-list-check"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary"><?php echo e(__('Total Courses')); ?></span>
                                                <strong class="d-block"><?php echo e($course->courses); ?></strong>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!empty($course->fee)): ?>
                                        <div class="d-flex gap-3">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-tag"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary"><?php echo e(__('field_total')); ?> <?php echo e(__('field_fee')); ?></span>
                                                <strong class="d-block"><?php echo e(round($course->fee, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></strong>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.custom.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\office_project\cust\resources\views/web/program-single.blade.php ENDPATH**/ ?>