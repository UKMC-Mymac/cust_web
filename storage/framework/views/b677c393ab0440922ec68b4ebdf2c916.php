<section class="academic1-area space overflow-hidden" id="program-sec">
    <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-center">
            <div class="col-lg-9 col-12">
                <?php if(isset($contentSections['course'])): ?>
                    <?php $section = $contentSections['course']; ?>
                    <div class="title-area text-center text-lg-start mb-75">
                        <span class="sub-title text-anim"><?php echo e($section->subtitle); ?></span>
                        <h2 class="sec-title text-anim2"><?php echo e($section->title); ?></h2>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-3 col-12 text-center text-lg-end mb-75">
                <a href="<?php echo e(route('program')); ?>" class="th-btn style-border1 th-icon">View All</a>
            </div>
        </div>

        <div class="academic-wrapp">
            <div class="slider-area">
                <div class="swiper th-slider has-shadow" id="academicSlider2"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"3", "spaceBetween": "24"}},"autoplay": {"delay": 5000, "disableOnInteraction": false}, "pagination": {"el": ".th-pag2", "type": "bullets", "clickable": true}}'>

                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $rawTitle = (string) ($course->title ?? '');
                                $mainTitle = $rawTitle;
                                $acronym = '';
                                if (preg_match('/^(.*?)\s*\(([^)]+)\)\s*$/', $rawTitle, $m)) {
                                    $mainTitle = trim($m[1]);
                                    $acronym   = trim($m[2]);
                                }
                                $url = route('program.single', ['slug' => $course->slug]);
                            ?>

                            <div class="swiper-slide">
                                <article class="program-card">
                                    
                                    <div class="program-media">
                                        <a href="<?php echo e($url); ?>" class="program-media-link" aria-label="<?php echo e($course->title); ?>">
                                            <img src="<?php echo e(asset('uploads/course/' . ($course->attach ?? ''))); ?>"
                                                 alt="<?php echo e($course->title); ?>">
                                        </a>

                                        <?php if(!empty($course->department->title)): ?>
                                            <div class="program-chip program-chip--dept">
                                                <span class="program-chip-icon">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M3 21h18"/>
                                                        <path d="M5 21V7l7-4 7 4v14"/>
                                                        <path d="M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01"/>
                                                    </svg>
                                                </span>
                                                <span class="program-chip-text"><?php echo e($course->department->title); ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if(!empty($course->accreditation ?? null)): ?>
                                            <div class="program-chip program-chip--accred">
                                                <?php echo e($course->accreditation); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    
                                    <div class="program-body">

                                        <?php if(!empty($course->degree_level ?? null)): ?>
                                            <span class="program-eyebrow"><?php echo e($course->degree_level); ?></span>
                                        <?php endif; ?>

                                        <h3 class="program-title">
                                            <a href="<?php echo e($url); ?>" title="<?php echo e($rawTitle); ?>">
                                                <?php echo e($mainTitle); ?><?php if($acronym): ?> <span class="program-title-acronym">(<?php echo e($acronym); ?>)</span><?php endif; ?>
                                            </a>
                                        </h3>

                                        <?php if(!empty($course->feature_text)): ?>
                                            <p class="program-text"><?php echo e($course->feature_text); ?></p>
                                        <?php endif; ?>

                                        
                                        <div class="program-meta">
                                            <?php if(!empty($course->credits)): ?>
                                                <div class="program-meta-item">
                                                    <span class="program-meta-icon" aria-hidden="true">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M2 4h9a3 3 0 0 1 3 3v13a2.5 2.5 0 0 0-2.5-2.5H2z"/>
                                                            <path d="M22 4h-9a3 3 0 0 0-3 3v13a2.5 2.5 0 0 1 2.5-2.5H22z"/>
                                                        </svg>
                                                    </span>
                                                    <div class="program-meta-text">
                                                        <span class="program-meta-value"><?php echo e($course->credits); ?></span>
                                                        <span class="program-meta-label">Credits</span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if(!empty($course->duration)): ?>
                                                <div class="program-meta-item">
                                                    <span class="program-meta-icon" aria-hidden="true">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="9"/>
                                                            <path d="M12 7v5l3 2"/>
                                                        </svg>
                                                    </span>
                                                    <div class="program-meta-text">
                                                        <span class="program-meta-value"><?php echo e($course->duration); ?></span>
                                                        <span class="program-meta-label"><?php echo e($course->study_mode ?? 'Full-Time'); ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        
                                        <a href="<?php echo e($url); ?>" class="program-btn">
                                            <span class="program-btn-label"><?php echo e($course->cta_text ?? 'Explore Curriculum'); ?></span>
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M5 12h14"/>
                                                <path d="m13 5 7 7-7 7"/>
                                            </svg>
                                        </a>

                                    </div>
                                </article>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="th-pag2 d-flex justify-content-center gap-2 pt-4"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* ============================================================
       PROGRAM CARDS — equal height, clean editorial design
       ============================================================ */

    #program-sec .academic-wrapp { position: relative; }

    /* Shadows must not be clipped */
    #program-sec .slider-area { padding: 8px 0 8px; }
    #program-sec .swiper { overflow: visible; }

    /* ============================================================
       EQUAL HEIGHT MAGIC
       ============================================================ */
    #program-sec .swiper-wrapper {
        align-items: stretch;
    }
    #program-sec .swiper-slide {
        height: auto !important;
        display: flex;
        align-items: stretch;
    }
    #program-sec .program-card {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
    }

    /* ---------- Card shell ---------- */
    #program-sec .program-card {
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, .06);
        border-radius: 20px;
        overflow: hidden;
        box-shadow:
            0 1px 2px rgba(15, 23, 42, .04),
            0 18px 40px -22px rgba(15, 23, 42, .18);
        transition: transform .45s cubic-bezier(.22, .61, .36, 1),
                    box-shadow .45s cubic-bezier(.22, .61, .36, 1);
        will-change: transform;
    }
    #program-sec .program-card:hover {
        transform: translateY(-6px);
        box-shadow:
            0 1px 2px rgba(15, 23, 42, .05),
            0 30px 60px -24px rgba(15, 23, 42, .28);
    }

    /* ---------- Media ---------- */
    #program-sec .program-media {
        position: relative;
        flex: 0 0 auto;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: #e8ecf2;
    }
    #program-sec .program-media-link {
        position: absolute;
        inset: 0;
        display: block;
    }
    #program-sec .program-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .8s cubic-bezier(.22, .61, .36, 1);
    }
    #program-sec .program-card:hover .program-media img {
        transform: scale(1.05);
    }

    /* Chips over the image */
    #program-sec .program-chip {
        position: absolute;
        top: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: .02em;
        line-height: 1;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        white-space: nowrap;
        max-width: calc(100% - 28px);
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #program-sec .program-chip--dept {
        left: 14px;
        background: rgba(12, 20, 38, .82);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, .10);
    }
    #program-sec .program-chip--dept .program-chip-icon {
        display: inline-flex;
        color: #d4a95d;
        flex: 0 0 auto;
    }
    #program-sec .program-chip-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    #program-sec .program-chip--accred {
        right: 14px;
        background: rgba(255, 255, 255, .96);
        color: #0f172a;
        border: 1px solid rgba(15, 23, 42, .06);
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        font-size: 10.5px;
    }

    /* ---------- Body ---------- */
    #program-sec .program-body {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        padding: 26px 26px 24px;
        min-width: 0;   /* allow children to shrink & ellipsize inside grid */
    }

    #program-sec .program-eyebrow {
        display: inline-block;
        margin-bottom: 12px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: #c8873d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    /* ---------- Title ---------- */
    #program-sec .program-title {
        margin: 0 0 14px;
        font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
        font-size: 1.5rem;
        font-weight: 600;
        line-height: 1.22;
        letter-spacing: -0.01em;
        color: #0e1a33;
        min-height: calc(1.22em * 2);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
    }
    #program-sec .program-title a {
        color: inherit;
        text-decoration: none;
        transition: color .3s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #program-sec .program-title a:hover { color: #1d3a6b; }
    #program-sec .program-title-acronym {
        font-family: inherit;
        color: #0e1a33;
    }

    /* ---------- Description ---------- */
    #program-sec .program-text {
        margin: 0 0 22px;
        font-size: .925rem;
        font-weight: 400;
        line-height: 1.65;
        color: #64748b;
        min-height: calc(1.65em * 2);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ---------- Meta row ---------- */
    #program-sec .program-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        padding: 16px 0;
        margin: auto 0 20px;
        border-top: 1px solid rgba(15, 23, 42, .07);
        border-bottom: 1px solid rgba(15, 23, 42, .07);
    }
    #program-sec .program-meta-item {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }
    #program-sec .program-meta-icon {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border: 1px solid rgba(15, 23, 42, .10);
        border-radius: 10px;
        color: #0e1a33;
        background: #ffffff;
    }
    #program-sec .program-meta-text {
        display: flex;
        flex-direction: column;
        min-width: 0;
        line-height: 1.15;
    }
    #program-sec .program-meta-value {
        font-size: 1rem;
        font-weight: 700;
        color: #0e1a33;
        letter-spacing: -.005em;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #program-sec .program-meta-label {
        margin-top: 3px;
        font-size: 10.5px;
        font-weight: 600;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #94a3b8;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ============================================================
       CTA BUTTON — forced single-line layout
       ============================================================ */
    #program-sec .program-btn {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 12px !important;

        width: 100% !important;
        min-width: 0 !important;
        margin-top: auto !important;
        padding: 14px 20px !important;

        border: 1px solid rgba(15, 23, 42, .12) !important;
        border-radius: 12px !important;
        background: #f7f9fc !important;
        color: #0e1a33 !important;

        font-size: 13.5px !important;
        font-weight: 500 !important;
        letter-spacing: .01em !important;
        line-height: 1.2 !important;
        text-decoration: none !important;

        transition:
            background-color .35s cubic-bezier(.22, .61, .36, 1),
            border-color .35s cubic-bezier(.22, .61, .36, 1),
            color .35s cubic-bezier(.22, .61, .36, 1),
            transform .35s cubic-bezier(.22, .61, .36, 1) !important;
    }

    /* Label — single line with ellipsis */
    #program-sec .program-btn > span,
    #program-sec .program-btn .program-btn-label {
        display: block !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
        text-align: left !important;
    }

    /* Arrow icon — never shrink, never wrap */
    #program-sec .program-btn svg {
        display: block !important;
        flex: 0 0 auto !important;
        margin: 0 !important;
        transition: transform .35s cubic-bezier(.22, .61, .36, 1) !important;
    }

    #program-sec .program-btn:hover,
    #program-sec .program-btn:focus-visible {
        background: #0e1a33 !important;
        border-color: #0e1a33 !important;
        color: #ffffff !important;
        outline: none !important;
    }
    #program-sec .program-btn:hover svg { transform: translateX(4px) !important; }

    /* ============================================================
       Responsive
       ============================================================ */

    /* ----- Tablet (≤ 991px) ----- */
    @media (max-width: 991px) {
        #program-sec .program-body { padding: 22px 22px 20px; }
        #program-sec .program-title {
            font-size: 1.35rem;
            min-height: calc(1.22em * 2);
        }
        #program-sec .program-text {
            font-size: .9rem;
            min-height: calc(1.65em * 2);
        }
    }

    /* ----- Mobile (≤ 767px) ----- */
    @media (max-width: 767px) {
        #program-sec .program-body { padding: 20px 20px 18px; }
        #program-sec .program-title {
            font-size: 1.2rem;
            line-height: 1.25;
            min-height: calc(1.25em * 2);
        }
        #program-sec .program-text {
            font-size: .875rem;
            margin-bottom: 18px;
        }
        #program-sec .program-meta {
            gap: 12px;
            padding: 14px 0;
            margin-bottom: 16px;
        }
        #program-sec .program-meta-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
        }
        #program-sec .program-meta-value { font-size: .95rem; }
        #program-sec .program-meta-label { font-size: 10px; letter-spacing: .12em; }

        #program-sec .program-btn {
            padding: 12px 16px !important;
            font-size: 13px !important;
            gap: 10px !important;
            border-radius: 10px !important;
        }
    }

    /* ----- Small mobile (≤ 575px) ----- */
    @media (max-width: 575px) {
        #program-sec .program-body { padding: 18px 16px 16px; }
        #program-sec .program-title {
            font-size: 1.1rem;
            line-height: 1.28;
            min-height: calc(1.28em * 2);
            margin-bottom: 10px;
        }
        #program-sec .program-text {
            font-size: .84rem;
            line-height: 1.6;
            margin-bottom: 16px;
        }
        #program-sec .program-meta {
            gap: 10px;
            padding: 12px 0;
            margin-bottom: 14px;
        }
        #program-sec .program-meta-icon { width: 30px; height: 30px; }
        #program-sec .program-meta-value { font-size: .9rem; }
        #program-sec .program-meta-label { font-size: 9.5px; }

        #program-sec .program-btn {
            padding: 11px 14px !important;
            font-size: 12.5px !important;
            letter-spacing: 0 !important;
            gap: 8px !important;
            border-radius: 10px !important;
        }
        #program-sec .program-btn svg { width: 14px !important; height: 14px !important; }

        #program-sec .program-chip {
            font-size: 10px;
            padding: 5px 10px;
            top: 10px;
        }
        #program-sec .program-chip--dept { left: 10px; }
        #program-sec .program-chip--accred { right: 10px; }
    }

    /* ----- Extra small (≤ 380px) ----- */
    @media (max-width: 380px) {
        #program-sec .program-body { padding: 16px 14px 14px; }
        #program-sec .program-title { font-size: 1rem; }
        #program-sec .program-btn {
            padding: 10px 12px !important;
            font-size: 12px !important;
        }
        #program-sec .program-btn svg { width: 13px !important; height: 13px !important; }
    }

    @media (prefers-reduced-motion: reduce) {
        #program-sec .program-card,
        #program-sec .program-media img,
        #program-sec .program-btn,
        #program-sec .program-btn svg {
            transition-duration: .001ms !important;
        }
    }
</style><?php /**PATH D:\office_project\cust\resources\views/web/custom/sections/academics.blade.php ENDPATH**/ ?>