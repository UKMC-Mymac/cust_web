
<?php $__env->startSection('title', e($event->title ?? __('navbar_event'))); ?>

<?php $__env->startSection('social_meta_tags'); ?>
    <?php
        $eventUrl = route('event.single', ['id' => $event->id, 'slug' => $event->slug]);
        $eventImage = !empty($event->attach)
            ? asset('uploads/web-event/'.$event->attach)
            : asset('dist/images/homepage/news-1.jpg');
        $eventSummary = \Illuminate\Support\Str::limit(strip_tags($event->description ?: $event->feature_text ?: ''), 160, ' ...');
    ?>

    <?php if(isset($setting)): ?>
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo e($setting->title); ?>">
    <meta property="og:title" content="<?php echo e($event->title); ?>">
    <meta property="og:description" content="<?php echo e($eventSummary); ?>">
    <meta property="og:url" content="<?php echo e($eventUrl); ?>">
    <meta property="og:image" content="<?php echo e($eventImage); ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="<?php echo '@'.str_replace(' ', '', $setting->title); ?>">
    <meta name="twitter:creator" content="@HiTechParks">
    <meta name="twitter:url" content="<?php echo e($eventUrl); ?>">
    <meta name="twitter:title" content="<?php echo e($event->title); ?>">
    <meta name="twitter:description" content="<?php echo e($eventSummary); ?>">
    <meta name="twitter:image" content="<?php echo e($eventImage); ?>">
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php
        $eventDateTime = null;
        $eventDate = \Carbon\Carbon::parse($event->date);
        $eventTimeLabel = null;
        $timeFormat = $setting->time_format ?? 'h:i A';

        if (!empty($event->time)) {
            $eventTimeLabel = date($timeFormat, strtotime($event->time));
            $eventDateTime = \Carbon\Carbon::parse($event->date.' '.$event->time);
        } else {
            $eventDateTime = \Carbon\Carbon::parse($event->date.' 00:00:00');
        }

        $showCountdown = $eventDateTime && $eventDateTime->isFuture();
        $eventUrl = route('event.single', ['id' => $event->id, 'slug' => $event->slug]);
        $encodedEventUrl = rawurlencode($eventUrl);
        $encodedEventTitle = rawurlencode(\Illuminate\Support\Str::limit(strip_tags($event->title), 100, ' ...'));
        $eventImage = !empty($event->attach)
            ? asset('uploads/web-event/'.$event->attach)
            : asset('dist/images/homepage/news-1.jpg');
    ?>

    <section class="bg-body-tertiary py-5 overflow-hidden">
        <div class="container">
            <div class="row g-4 g-xl-5 align-items-start">
                <div class="col-lg-8">
                    <article>
                        <figure class="position-relative overflow-hidden rounded shadow-sm bg-white mb-4">
                            <img class="img-fluid w-100" src="<?php echo e($eventImage); ?>" alt="<?php echo e($event->title); ?>">
                            <div class="position-absolute top-0 start-0 m-3 m-md-4 p-3 rounded bg-danger text-white text-center shadow-sm">
                                <strong class="d-block h2 lh-1 mb-1"><?php echo e($eventDate->format('d')); ?></strong>
                                <span class="d-block small fw-bold text-uppercase"><?php echo e($eventDate->format('M')); ?></span>
                            </div>
                        </figure>

                        <div class="mb-4">
                            <span class="badge rounded-pill bg-danger text-white mb-3"><?php echo e(__('navbar_event')); ?></span>
                            <h2 class="h4 fw-bold lh-sm mb-3 text-body"><?php echo e($event->title); ?></h2>

                            
                        </div>

                        <?php if($showCountdown): ?>
                            <div class="card border-0 shadow-sm mb-5 counter-list bg-white" data-offer-date="<?php echo e($eventDateTime->toIso8601String()); ?>">
                                <div class="card-body p-3 p-md-4">
                                    <div class="row g-3">
                                        <div class="col-6 col-md-3">
                                            <div class="rounded p-3 text-center h-100 bg-light border">
                                                <span class="day d-block h2 fw-bold lh-1 mb-2">00</span>
                                                <small class="d-block fw-bold text-uppercase"><?php echo e(__('Days')); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="rounded p-3 text-center h-100 bg-light border">
                                                <span class="hour d-block h2 fw-bold lh-1 mb-2">00</span>
                                                <small class="d-block fw-bold text-uppercase"><?php echo e(__('Hours')); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="rounded p-3 text-center h-100 bg-light border">
                                                <span class="minute d-block h2 fw-bold lh-1 mb-2">00</span>
                                                <small class="d-block fw-bold text-uppercase"><?php echo e(__('Minutes')); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="rounded p-3 text-center h-100 bg-light border">
                                                <span class="seconds d-block h2 fw-bold lh-1 mb-2">00</span>
                                                <small class="d-block fw-bold text-uppercase"><?php echo e(__('Seconds')); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="rounded shadow-sm bg-white p-3 p-md-4 lh-lg text-body-secondary">
                            <?php echo $event->description; ?>

                        </div>

                            <a class="btn btn-danger mt-4 d-inline-flex align-items-center gap-2" href="<?php echo e(route('event')); ?>">
                            <i class="fa-solid fa-arrow-left"></i>
                            <?php echo e(__('btn_back')); ?>

                        </a>
                    </article>
                </div>

                <div class="col-lg-4">
                    <aside class="sticky-lg-top">
                        <div class="card border-0 shadow-sm mb-4 bg-white">
                            <div class="card-body p-3 p-md-4">
                                <h3 class="h4 fw-bold mb-4 text-body">Details</h3>

                                <div class="d-grid gap-3">
                                    <div class="d-flex gap-3 pb-3 border-bottom">
                                        <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                            <i class="fa-regular fa-calendar-days"></i>
                                        </span>
                                        <span>
                                            <span class="d-block small fw-bold text-uppercase text-body-secondary"><?php echo e(__('field_date')); ?></span>
                                            <strong class="d-block"><?php echo e($eventDate->format('d F, Y')); ?></strong>
                                        </span>
                                    </div>

                                    <?php if(!empty($eventTimeLabel)): ?>
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-clock"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary"><?php echo e(__('field_time')); ?></span>
                                                <strong class="d-block"><?php echo e($eventTimeLabel); ?></strong>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!empty($event->address)): ?>
                                        <div class="d-flex gap-3">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary"><?php echo e(__('field_location')); ?></span>
                                                <strong class="d-block"><?php echo e($event->address); ?></strong>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm bg-white">
                            <div class="card-body p-3 p-md-4">
                                <h3 class="h4 fw-bold mb-3 text-body"><?php echo e(__('Share')); ?></h3>

                                <div class="d-flex flex-wrap gap-2">
                                    <a class="btn btn-outline-danger rounded d-inline-flex align-items-center justify-content-center" target="_blank" rel="noopener" aria-label="Share on Facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($encodedEventUrl); ?>">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>

                                    <a class="btn btn-outline-danger rounded d-inline-flex align-items-center justify-content-center" target="_blank" rel="noopener" aria-label="Share on Twitter" href="https://twitter.com/intent/tweet?text=<?php echo e($encodedEventTitle); ?>&url=<?php echo e($encodedEventUrl); ?>">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>

                                    <a class="btn btn-outline-danger rounded d-inline-flex align-items-center justify-content-center" target="_blank" rel="noopener" aria-label="Share on LinkedIn" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e($encodedEventUrl); ?>">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.custom.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cust_web\resources\views/web/event-single.blade.php ENDPATH**/ ?>