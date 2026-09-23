<style>
    #event-sec .bangla-text {
        font-family: "Noto Sans Bengali", var(--body-font), sans-serif;
    }

    /* ============================================================
       EVENT CARDS — text top-aligned with image
       ============================================================ */

    /* Force the card to stretch children so content column
       matches the image column height and content starts at top */
    #event-sec .event-card {
        align-items: stretch !important;
    }

    /* Content column: top-aligned, no vertical centering */
    #event-sec .event-content {
        display: flex !important;
        flex-direction: column !important;
        justify-content: flex-start !important;
        align-items: stretch !important;
        /* padding-top: clamp(22px, 2.4vw, 34px) !important; */
        padding-bottom: clamp(22px, 2.4vw, 34px) !important;
    }

    /* Inner wrapper — remove any inherited vertical centering */
    #event-sec .event-content .event-wrapp {
        display: flex !important;
        flex-direction: column !important;
        justify-content: flex-start !important;
        align-items: stretch !important;
        margin: 0 !important;
        padding: 0 !important;
        flex: 1 1 auto !important;
    }

    /* Kill any top margin/padding on the first element (title) */
    #event-sec .event-content .event-wrapp > *:first-child,
    #event-sec .event-content .box-title:first-child {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    /* ---------- Title ---------- */
    #event-sec .event-card .box-title {
        margin: 0 0 14px !important;
        font-family: 'Playfair Display', Georgia, 'Times New Roman', serif !important;
        font-size: 1.35rem !important;
        font-weight: 600 !important;
        line-height: 1.3 !important;
        letter-spacing: -0.012em !important;
        color: #0e1a33 !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
    }
    #event-sec .event-card .box-title a {
        color: inherit !important;
        text-decoration: none !important;
        transition: color .3s ease !important;
    }
    #event-sec .event-card .box-title a:hover {
        color: #b98a3d !important;
    }

    /* ---------- Description ---------- */
    #event-sec .event-card .box-text {
        margin: 0 0 20px !important;
        font-size: .92rem !important;
        font-weight: 400 !important;
        line-height: 1.7 !important;
        letter-spacing: -0.003em !important;
        color: #64748b !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 3 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
    }

    /* ---------- Meta row ---------- */
    #event-sec .event-card .blog-meta {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        gap: 16px !important;
        margin: 0 0 20px !important;
        padding: 0 !important;
        border: 0 !important;
    }
    #event-sec .event-card .blog-meta a {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        font-size: 12.5px !important;
        font-weight: 500 !important;
        letter-spacing: -0.002em !important;
        color: #64748b !important;
        text-decoration: none !important;
        transition: color .3s ease !important;
    }
    #event-sec .event-card .blog-meta a:hover {
        color: #0e1a33 !important;
    }
    #event-sec .event-card .blog-meta i {
        font-size: 12px !important;
        color: #b98a3d !important;
        opacity: .9 !important;
    }

    /* ---------- CTA button — Details → ---------- */
    #event-sec .event-card .btn-wrap {
        margin: auto 0 0 0 !important;   /* push button to the bottom */
        padding: 0 !important;
    }
    #event-sec .event-card .btn-wrap .th-btn {
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;

        padding: 10px 20px !important;
        border: 1px solid rgba(15, 23, 42, .12) !important;
        border-radius: 999px !important;
        background: transparent !important;

        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        letter-spacing: .08em !important;
        text-transform: uppercase !important;
        color: #0e1a33 !important;
        text-decoration: none !important;
        white-space: nowrap !important;

        transition:
            background-color .35s cubic-bezier(.22, .61, .36, 1),
            border-color .35s cubic-bezier(.22, .61, .36, 1),
            color .35s cubic-bezier(.22, .61, .36, 1),
            gap .35s cubic-bezier(.22, .61, .36, 1) !important;
    }

    /* Hide theme's default arrow icon */
    #event-sec .event-card .btn-wrap .th-btn i {
        display: none !important;
    }

    /* Custom arrow drawn with CSS */
    #event-sec .event-card .btn-wrap .th-btn::after {
        content: "→" !important;
        display: inline-block !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        line-height: 1 !important;
        transform: translateX(0);
        transition: transform .35s cubic-bezier(.22, .61, .36, 1) !important;
    }

    #event-sec .event-card .btn-wrap .th-btn:hover,
    #event-sec .event-card .btn-wrap .th-btn:focus-visible {
        background: #0e1a33 !important;
        border-color: #0e1a33 !important;
        color: #ffffff !important;
        outline: none !important;
    }
    #event-sec .event-card .btn-wrap .th-btn:hover::after {
        transform: translateX(4px);
    }

    /* ============================================================
       Responsive Optimization
       ============================================================ */
    @media (max-width: 767px) {
        #event-sec .event-card .box-title {
            font-size: 20px !important;
            line-height: 1.3 !important;
            margin-bottom: 10px !important;
        }
        #event-sec .event-card .box-text {
            font-size: 14px !important;
            line-height: 1.6 !important;
            margin-bottom: 15px !important;
        }
    }

    @media (max-width: 575px) {
        #event-sec .event-card .box-title {
            font-size: 18px !important;
            line-height: 1.32 !important;
        }
        #event-sec .event-card .box-text {
            font-size: 13px !important;
            line-height: 1.55 !important;
        }
        #event-sec .event-card .btn-wrap .th-btn {
            padding: 9px 16px !important;
            font-size: 11.5px !important;
            letter-spacing: .06em !important;
        }
        #event-sec .event-card .blog-meta {
            gap: 12px !important;
            margin-bottom: 16px !important;
        }
        #event-sec .event-card .blog-meta a {
            font-size: 12px !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        #event-sec .event-card .box-title a,
        #event-sec .event-card .blog-meta a,
        #event-sec .event-card .btn-wrap .th-btn,
        #event-sec .event-card .btn-wrap .th-btn::after {
            transition-duration: .001ms !important;
        }
    }
</style>

<section class="event-area-1 position-relative overflow-hidden space" id="event-sec">
    <div class="event-shape shape-mockup d-none d-xxl-block" data-top="0%" data-left="0%">
        <img src="<?php echo e(asset('dist/img/shape/shape-2.png')); ?>" alt="">
    </div>
    <div class="event-shape jump shape-mockup  d-none d-xxl-block" data-bottom="0%" data-left="3%">
        <img src="<?php echo e(asset('dist/img/shape/event-1-1.png')); ?>" alt="">
    </div>
    <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-center">
            <div class="col-lg-8 col-12">
                <?php if(isset($contentSections['news-event'])): ?>
                  <div class="title-area text-center text-lg-start">
                    <span class="sub-title text-anim"><?php echo e($contentSections['news-event']->subtitle); ?></span>
                    <h2 class="sec-title text-anim2"><?php echo e($contentSections['news-event']->title); ?></h2>
                </div>
                <?php endif; ?>

            </div>
            <div class="col-auto align-self-end">
                <div class="sec-btn wow fadeInUp" data-wow-delay=".3s">
                    <a href="<?php echo e(route('event')); ?>" class="th-btn style-border1 th-icon">Explore All</a>
                </div>
            </div>
        </div>
        <div class="event-card-wrap">
            <?php if(isset($events) && $events->count()): ?>
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="event-card wow fadeInUp" data-wow-delay="<?php echo e(sprintf('%.1fs', 0.2 * ($loop->index + 1))); ?>">
                    <div class="event-card-img global-img position-relative">
                        <img src="<?php echo e($event->attach ? asset('uploads/web-event/'.$event->attach) : asset('dist/images/homepage/news-1.jpg')); ?>" alt="event">
                        <p class="event-card-tag"><span class="tag-number"><?php echo e(date('d', strtotime($event->date))); ?></span><?php echo e(date('M', strtotime($event->date))); ?></p>
                        <?php if(!empty($event->pinned)): ?>
                            <span class="position-absolute top-0 start-0 m-3 p-2 rounded bg-warning text-dark text-center shadow-sm" style="z-index: 10; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" title="<?php echo e(__('field_pinned')); ?>: <?php echo e($event->pinned); ?>">
                                <i class="fa-solid fa-thumbtack"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="event-content">
                        <div class="event-wrapp">
                            <h4 class="h4 box-title bangla-text">
                                <a href="<?php echo e(route('event.single', ['id' => $event->id, 'slug' => $event->slug])); ?>"><?php echo e($event->title); ?></a>
                            </h4>
                            <p class="box-text bangla-text">
                                <?php echo e(\Illuminate\Support\Str::limit($event->feature_text ?? '', 160)); ?>

                            </p>
                            <div class="blog-meta">
                                <a class="location" href="#"><i class="fa-solid fa-location-dot"></i> <?php echo e($event->address); ?></a>
                                <a class="date" href="#"><i class="fa-regular fa-calendar-days"></i> <?php echo e(date('d.m.Y', strtotime($event->date))); ?></a>
                                <?php if($event->time): ?>
                                <a class="time" href="#"><i class="fa-solid fa-clock"></i> <?php echo e($event->time); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="btn-wrap">
                            <a class="th-btn style-border1 th-icon" href="<?php echo e(route('event.single', ['id' => $event->id, 'slug' => $event->slug])); ?>">Details</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</section><?php /**PATH D:\office_project\cust\resources\views/web/custom/sections/events.blade.php ENDPATH**/ ?>