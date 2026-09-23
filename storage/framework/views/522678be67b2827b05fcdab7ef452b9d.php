<section id="campus_life" class="campus container overflow-hidden space">
    <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-center">
            <?php if(isset($contentSections['campus_life'])): ?>
                <?php $section = $contentSections['campus_life']; ?>

                <div class="col-lg-8 col-12">
                    <div class="title-area text-center text-lg-start">
                        <span class="sub-title text-anim"><?php echo e($section->subtitle); ?></span>
                        <h2 class="sec-title text-anim2"><?php echo e($section->title); ?></h2>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-auto align-self-end">
                <div class="sec-btn">
                    <a href="<?php echo e(route('campus-life')); ?>" class="th-btn style-border1 th-icon wow fadeInUp" data-wow-delay=".2s">
                        Explore All
                    </a>
                </div>
            </div>
        </div>

        <div class="slider-area">
            
            <div class="swiper th-slider has-shadow" id="campusLifeSlider"
                data-slider-options='{
                    "spaceBetween":24,
                    "autoplay":{"delay":5000,"disableOnInteraction":false},
                    "pagination":{"el":".campus-pag","type":"bullets","clickable":true},
                    "breakpoints":{
                        "0":{"slidesPerView":1},
                        "576":{"slidesPerView":1},
                        "768":{"slidesPerView":2},
                        "992":{"slidesPerView":2},
                        "1200":{"slidesPerView":3},
                        "1400":{"slidesPerView":3,"spaceBetween":24}
                    }
                }'>

                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $campus_lifes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campusLife): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $url = route('campus-life.single', ['slug' => $campusLife->slug]);

                            /* Optional fields — fall back to sensible defaults */
                            $eyebrow    = $campusLife->category      ?? 'Campus Infrastructure';
                            $badge      = $campusLife->badge         ?? 'Governance';
                            $wing       = $campusLife->wing_label    ?? null;

                            /* Highlights — stored as array, comma string, or JSON */
                            $highlights = $campusLife->highlights ?? [];
                            if (is_string($highlights)) {
                                $decoded = json_decode($highlights, true);
                                $highlights = is_array($decoded)
                                    ? $decoded
                                    : array_filter(array_map('trim', explode(',', $highlights)));
                            }
                            if (!is_array($highlights)) $highlights = [];

                            /* CTA label fallback */
                            $cta = $campusLife->button_text ?: 'Explore Facility Details';
                        ?>

                        <div class="swiper-slide">
                            <article class="campus-card">

                                
                                <div class="campus-media">
                                    <a href="<?php echo e($url); ?>" class="campus-media-link"
                                       aria-label="<?php echo e($campusLife->title); ?>">
                                        <img src="<?php echo e(asset('uploads/campus-life/' . $campusLife->attach)); ?>"
                                             alt="<?php echo e($campusLife->title); ?>">
                                    </a>

                                    <?php if(!empty($badge)): ?>
                                        <span class="campus-chip campus-chip--left">
                                            <span class="campus-chip-icon" aria-hidden="true">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                     stroke="currentColor" stroke-width="2"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 21h18"/>
                                                    <path d="M5 21V7l7-4 7 4v14"/>
                                                    <path d="M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01"/>
                                                </svg>
                                            </span>
                                            <span class="campus-chip-text"><?php echo e(strtoupper($badge)); ?></span>
                                        </span>
                                    <?php endif; ?>

                                    <?php if(!empty($wing)): ?>
                                        <span class="campus-chip campus-chip--right">
                                            <?php echo e($wing); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="campus-body">

                                    
                                    <span class="campus-tag">
                                        <?php echo e(strtoupper($campusLife->title)); ?>

                                    </span>

                                    <div class="campus-divider" aria-hidden="true"></div>

                                    
                                    <?php if(!empty($eyebrow)): ?>
                                        <span class="campus-eyebrow"><?php echo e($eyebrow); ?></span>
                                    <?php endif; ?>

                                    
                                    <h3 class="campus-title">
                                        <a href="<?php echo e($url); ?>"><?php echo e($campusLife->title); ?></a>
                                    </h3>

                                    
                                    <?php if(!empty($campusLife->feature_text)): ?>
                                        <p class="campus-text"><?php echo e($campusLife->feature_text); ?></p>
                                    <?php endif; ?>

                                    
                                    <?php if(!empty($highlights)): ?>
                                        <div class="campus-highlights">
                                            <span class="campus-highlights-label">KEY HIGHLIGHTS</span>

                                            <div class="campus-highlights-list">
                                                <?php $__currentLoopData = $highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $label = is_array($item)
                                                            ? ($item['label'] ?? $item['title'] ?? reset($item))
                                                            : $item;
                                                        $icon = is_array($item) ? ($item['icon'] ?? null) : null;
                                                    ?>
                                                    <span class="campus-pill">
                                                        <?php if($icon): ?>
                                                            <i class="<?php echo e($icon); ?>" aria-hidden="true"></i>
                                                        <?php else: ?>
                                                            <svg width="14" height="14" viewBox="0 0 24 24"
                                                                 fill="none" stroke="currentColor"
                                                                 stroke-width="1.7" stroke-linecap="round"
                                                                 stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M3 21h18"/>
                                                                <path d="M5 21V7l7-4 7 4v14"/>
                                                            </svg>
                                                        <?php endif; ?>
                                                        <span><?php echo e($label); ?></span>
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    
                                    <a href="<?php echo e($url); ?>" class="campus-btn">
                                        <span><?php echo e($cta); ?></span>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="1.8"
                                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M5 12h14"/>
                                            <path d="m13 5 7 7-7 7"/>
                                        </svg>
                                    </a>

                                </div>
                            </article>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="campus-pag d-flex justify-content-center gap-2 pt-4"></div>
            </div>
        </div>
    </div>
</section>

<style>
    /* ============================================================
       CAMPUS LIFE — equal-height editorial cards
       ============================================================ */

    #campus_life .slider-area { padding: 8px 0; }
    #campus_life .swiper { overflow: visible; }

    /* ---- Equal height chain ---- */
    #campus_life .swiper-wrapper   { align-items: stretch; }
    #campus_life .swiper-slide     { height: auto !important; display: flex; align-items: stretch; }
    #campus_life .campus-card      { display: flex; flex-direction: column; width: 100%; height: 100%; }

    /* ---- Card shell ---- */
    #campus_life .campus-card {
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, .07);
        border-radius: 18px;
        overflow: hidden;
        box-shadow:
            0 1px 2px rgba(15, 23, 42, .04),
            0 18px 40px -24px rgba(15, 23, 42, .18);
        transition:
            transform .45s cubic-bezier(.22, .61, .36, 1),
            box-shadow .45s cubic-bezier(.22, .61, .36, 1);
        will-change: transform;
    }
    #campus_life .campus-card:hover {
        transform: translateY(-5px);
        box-shadow:
            0 1px 2px rgba(15, 23, 42, .05),
            0 28px 60px -26px rgba(15, 23, 42, .28);
    }

    /* ============================================================
       Media
       ============================================================ */
    #campus_life .campus-media {
        position: relative;
        flex: 0 0 auto;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: #e8ecf2;
    }
    #campus_life .campus-media-link {
        position: absolute;
        inset: 0;
        display: block;
    }
    #campus_life .campus-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .8s cubic-bezier(.22, .61, .36, 1);
    }
    #campus_life .campus-card:hover .campus-media img {
        transform: scale(1.05);
    }

    /* Chips */
    #campus_life .campus-chip {
        position: absolute;
        top: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        line-height: 1;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        white-space: nowrap;
        max-width: calc(100% - 28px);
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #campus_life .campus-chip--left {
        left: 14px;
        background: rgba(12, 20, 38, .82);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, .10);
    }
    #campus_life .campus-chip--left .campus-chip-icon {
        display: inline-flex;
        color: #d4a95d;
    }
    #campus_life .campus-chip--right {
        right: 14px;
        background: rgba(255, 255, 255, .96);
        color: #0f172a;
        border: 1px solid rgba(15, 23, 42, .06);
        font-weight: 600;
        letter-spacing: .02em;
        text-transform: none;
        font-size: 12px;
    }

    /* ============================================================
       Body
       ============================================================ */
    #campus_life .campus-body {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        padding: 22px 24px 24px;
    }

    /* Dark tag line (like the pill in the reference) */
    #campus_life .campus-tag {
        display: inline-block;
        align-self: flex-start;
        padding: 6px 12px;
        border-radius: 6px;
        background: #0e1a33;
        color: #f4d9a4;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .14em;
        line-height: 1;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    #campus_life .campus-divider {
        height: 1px;
        margin: 18px 0;
        background: linear-gradient(90deg, rgba(15, 23, 42, .12), rgba(15, 23, 42, 0));
    }

    #campus_life .campus-eyebrow {
        display: inline-block;
        margin-bottom: 10px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #c8873d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    #campus_life .campus-title {
        margin: 0 0 12px;
        font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
        font-size: 1.55rem;
        font-weight: 600;
        line-height: 1.22;
        letter-spacing: -0.012em;
        color: #0e1a33;
        /* reserve 2 lines so cards align */
        min-height: calc(1.22em * 2);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #campus_life .campus-title a {
        color: inherit;
        text-decoration: none;
        transition: color .3s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #campus_life .campus-title a:hover { color: #1d3a6b; }

    #campus_life .campus-text {
        margin: 0 0 22px;
        font-size: .9rem;
        font-weight: 400;
        line-height: 1.68;
        color: #64748b;
        min-height: calc(1.68em * 3);
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ============================================================
       Highlights
       ============================================================ */
    #campus_life .campus-highlights {
        margin: auto 0 22px;   /* pin to bottom before CTA */
    }
    #campus_life .campus-highlights-label {
        display: block;
        margin-bottom: 12px;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #94a3b8;
    }
    #campus_life .campus-highlights-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    #campus_life .campus-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border: 1px solid rgba(15, 23, 42, .10);
        border-radius: 999px;
        background: #f7f9fc;
        color: #0e1a33;
        font-size: 12.5px;
        font-weight: 500;
        line-height: 1;
        white-space: nowrap;
        max-width: 100%;
        transition: background-color .3s ease, border-color .3s ease;
    }
    #campus_life .campus-pill:hover {
        background: #ffffff;
        border-color: rgba(212, 169, 93, .5);
    }
    #campus_life .campus-pill svg,
    #campus_life .campus-pill i {
        color: #64748b;
        flex: 0 0 auto;
    }

    /* ============================================================
       CTA button — matches reference
       ============================================================ */
    #campus_life .campus-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        width: 100%;
        margin-top: auto;
        padding: 14px 20px;
        border: 1px solid rgba(15, 23, 42, .12);
        border-radius: 12px;
        background: #ffffff;
        color: #0e1a33;
        font-size: 13.5px;
        font-weight: 500;
        letter-spacing: .01em;
        text-decoration: none;
        transition:
            background-color .35s cubic-bezier(.22, .61, .36, 1),
            border-color .35s cubic-bezier(.22, .61, .36, 1),
            color .35s cubic-bezier(.22, .61, .36, 1);
    }
    #campus_life .campus-btn > span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    #campus_life .campus-btn svg {
        flex: 0 0 auto;
        transition: transform .35s cubic-bezier(.22, .61, .36, 1);
    }
    #campus_life .campus-btn:hover,
    #campus_life .campus-btn:focus-visible {
        background: #0e1a33;
        border-color: #0e1a33;
        color: #ffffff;
        outline: none;
    }
    #campus_life .campus-btn:hover svg { transform: translateX(4px); }

    /* ============================================================
       Responsive
       ============================================================ */
    @media (max-width: 991px) {
        #campus_life .campus-body { padding: 20px 22px 22px; }
        #campus_life .campus-title { font-size: 1.4rem; }
    }

    @media (max-width: 575px) {
        #campus_life .campus-body { padding: 18px 18px 20px; }
        #campus_life .campus-title { font-size: 1.25rem; }
        #campus_life .campus-text  { -webkit-line-clamp: 3; margin-bottom: 18px; }
        #campus_life .campus-btn   { padding: 13px 18px; font-size: 13px; }
        #campus_life .campus-pill  { font-size: 12px; padding: 7px 12px; }
        #campus_life .campus-chip  { font-size: 10px; padding: 6px 12px; }
    }
</style><?php /**PATH D:\office_project\cust\resources\views/web/custom/sections/campus-life.blade.php ENDPATH**/ ?>