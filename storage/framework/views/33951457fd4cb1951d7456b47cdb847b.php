<section id="why_choose_us" class="why-area position-relative space overflow-hidden">
    <div class="container">
        <div class="row gy-5 align-items-start">

            
            <div class="col-xl-8">
                <?php if(isset($contentSections['why_choose_us'])): ?>
                    <?php $why_choose_us_section = $contentSections['why_choose_us']; ?>
                    <div class="title-area text-center text-lg-start why-head">
                        <span class="sub-title text-anim"><?php echo e($why_choose_us_section->subtitle); ?></span>
                        <h2 class="sec-title text-anim2"><?php echo e($why_choose_us_section->title); ?></h2>
                    </div>
                <?php endif; ?>

                <div class="why-grid">
                    <?php $reasons = $why_choose_us->items ?? []; ?>

                    <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $delay = number_format((($loop->iteration) * 0.15), 1);
                            $link  = $reason['url'] ?? '#';

                            if (!empty($reason['page_id'])) {
                                $page = \App\Models\Web\Page::find($reason['page_id']);
                                if ($page) {
                                    if (\Illuminate\Support\Facades\Route::has('page.single')) {
                                        try { $link = route('page.single', $page->slug); }
                                        catch (Exception $e) { $link = url('page/' . $page->slug); }
                                    } else {
                                        $link = url('page/' . $page->slug);
                                    }
                                }
                            } elseif (!empty($reason['route_name'])) {
                                try { $link = route($reason['route_name']); }
                                catch (\Exception $e) { $link = $reason['url'] ?? '#'; }
                            }

                            $number = $reason['number'] ?? str_pad($loop->iteration, 2, '0', STR_PAD_LEFT);
                        ?>

                        <article class="why-card wow fadeInUp" data-wow-delay="<?php echo e($delay); ?>s">
                            <div class="why-card-head">
                                <span class="why-number"><?php echo e($number); ?></span>
                                <span class="why-card-line" aria-hidden="true"></span>
                            </div>

                            <h3 class="why-card-title">
                                <a href="<?php echo e($link); ?>"><?php echo e($reason['title']); ?></a>
                            </h3>

                            <p class="why-card-text">
                                <?php echo e($reason['description']); ?>

                            </p>

                            <a href="<?php echo e($link); ?>" class="why-card-link">
                                <span><?php echo e($reason['button_text'] ?? 'Explore More'); ?></span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14"/>
                                    <path d="m13 5 7 7-7 7"/>
                                </svg>
                            </a>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="col-xl-4">
                <aside class="why-media">

                    
                    <div class="why-media-badge">
                        <span class="why-media-badge-dot"></span>
                        <span class="why-media-badge-text">Campus Life</span>
                    </div>

                    
                    <div class="why-media-frame">
                        <img src="<?php echo e(asset('uploads/why-choose-us/' . $why_choose_us->attach)); ?>"
                             alt="Why choose us">

                        <div class="why-media-overlay"></div>

                        <?php if(!empty($why_choose_us->url)): ?>
                            <a href="<?php echo e($why_choose_us->url); ?>"
                               class="why-media-play popup-video"
                               aria-label="Play video">
                                <span class="why-media-play-ring"></span>
                                <span class="why-media-play-ring why-media-play-ring--2"></span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        
                        <div class="why-media-caption">
                            <div class="why-media-caption-value">15+</div>
                            <div class="why-media-caption-label">Years of Excellence</div>
                        </div>
                    </div>

                </aside>
            </div>

        </div>
    </div>
</section>

<style>
    /* ============================================================
       WHY CHOOSE US — editorial cards + framed media
       ============================================================ */
    #why_choose_us {
        padding-top: clamp(60px, 8vh, 100px);
        padding-bottom: clamp(60px, 8vh, 100px);
    }

    /* ---------- Heading ---------- */
    #why_choose_us .why-head { margin-bottom: clamp(28px, 4vh, 48px); }

    /* ---------- Reason grid: equal-height two columns ---------- */
    #why_choose_us .why-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: clamp(16px, 2vw, 26px);
    }

    /* ---------- Card ---------- */
    #why_choose_us .why-card {
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: clamp(22px, 2.4vw, 32px) clamp(20px, 2.2vw, 30px);
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, .07);
        border-radius: 18px;
        box-shadow:
            0 1px 2px rgba(15, 23, 42, .04),
            0 14px 32px -20px rgba(15, 23, 42, .16);
        transition:
            transform .4s cubic-bezier(.22, .61, .36, 1),
            box-shadow .4s cubic-bezier(.22, .61, .36, 1),
            border-color .4s cubic-bezier(.22, .61, .36, 1);
    }
    #why_choose_us .why-card:hover {
        transform: translateY(-4px);
        border-color: rgba(212, 169, 93, .35);
        box-shadow:
            0 1px 2px rgba(15, 23, 42, .05),
            0 24px 50px -22px rgba(15, 23, 42, .24);
    }

    /* subtle gold accent bar on the left edge on hover */
    #why_choose_us .why-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 22px;
        bottom: 22px;
        width: 3px;
        border-radius: 3px;
        background: linear-gradient(180deg, #e8c88a 0%, #d4a95d 100%);
        transform: scaleY(0);
        transform-origin: top;
        transition: transform .45s cubic-bezier(.22, .61, .36, 1);
    }
    #why_choose_us .why-card:hover::before { transform: scaleY(1); }

    /* ---------- Card head: number + hairline ---------- */
    #why_choose_us .why-card-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 16px;
    }
    #why_choose_us .why-number {
        font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
        font-size: 1.35rem;
        font-weight: 600;
        font-style: italic;
        letter-spacing: -0.01em;
        line-height: 1;
        background: linear-gradient(100deg, #d4a95d 0%, #e8c88a 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    #why_choose_us .why-card-line {
        flex: 1 1 auto;
        height: 1px;
        background: linear-gradient(90deg, rgba(15, 23, 42, .14), rgba(15, 23, 42, 0));
    }

    /* ---------- Card title ---------- */
    #why_choose_us .why-card-title {
        margin: 0 0 10px;
        font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        font-size: clamp(1.05rem, 1.15vw, 1.2rem);
        font-weight: 600;
        line-height: 1.3;
        letter-spacing: -0.012em;
        color: #0e1a33;
    }
    #why_choose_us .why-card-title a {
        color: inherit;
        text-decoration: none;
        transition: color .3s ease;
    }
    #why_choose_us .why-card-title a:hover { color: #1d3a6b; }

    /* ---------- Card text — clamp to 3 lines for even cards ---------- */
    #why_choose_us .why-card-text {
        margin: 0 0 20px;
        font-size: .9rem;
        font-weight: 400;
        line-height: 1.68;
        color: #64748b;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ---------- Card link ---------- */
    #why_choose_us .why-card-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
        padding-top: 4px;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #0e1a33;
        text-decoration: none;
        transition: color .3s ease, gap .35s cubic-bezier(.22, .61, .36, 1);
    }
    #why_choose_us .why-card-link svg { transition: transform .35s cubic-bezier(.22, .61, .36, 1); }
    #why_choose_us .why-card-link:hover {
        color: #b98a3d;
        gap: 12px;
    }
    #why_choose_us .why-card-link:hover svg { transform: translateX(3px); }

    /* ============================================================
       RIGHT — Media panel
       ============================================================ */
    #why_choose_us .why-media {
        position: relative;
        /* aligns nicely under a top offset — no more stretched look */
        margin-top: clamp(0px, 2vh, 16px);
    }

    /* Badge above the frame */
    #why_choose_us .why-media-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        margin-bottom: 14px;
        border: 1px solid rgba(15, 23, 42, .10);
        border-radius: 999px;
        background: rgba(255, 255, 255, .9);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: #0e1a33;
    }
    #why_choose_us .why-media-badge-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #d4a95d;
        box-shadow: 0 0 0 3px rgba(212, 169, 93, .20);
    }

    /* Framed video — locked aspect ratio, no stretching */
    #why_choose_us .why-media-frame {
        position: relative;
        width: 100%;
        /* 4:5 vertical frame — elegant, doesn't dominate the row */
        aspect-ratio: 4 / 5;
        border-radius: 20px;
        overflow: hidden;
        background: #0e1a33;
        box-shadow:
            0 30px 60px -30px rgba(15, 23, 42, .35),
            0 1px 2px rgba(15, 23, 42, .06);
        isolation: isolate;
    }
    #why_choose_us .why-media-frame img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transform: scale(1.02);
        transition: transform 1s cubic-bezier(.22, .61, .36, 1);
    }
    #why_choose_us .why-media:hover .why-media-frame img {
        transform: scale(1.08);
    }

    /* Dark gradient overlay */
    #why_choose_us .why-media-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(180deg, rgba(6, 12, 26, 0) 40%, rgba(6, 12, 26, .78) 100%),
            linear-gradient(0deg, rgba(6, 12, 26, .35) 0%, rgba(6, 12, 26, 0) 55%);
        pointer-events: none;
    }

    /* Play button — centered with pulsing rings */
    #why_choose_us .why-media-play {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .95);
        color: #0e1a33;
        text-decoration: none;
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, .45);
        transition: transform .35s cubic-bezier(.22, .61, .36, 1), background-color .35s ease;
        z-index: 2;
    }
    #why_choose_us .why-media-play svg { margin-left: 3px; }
    #why_choose_us .why-media-play:hover {
        transform: translate(-50%, -50%) scale(1.08);
        background: #d4a95d;
        color: #ffffff;
    }

    /* Pulsing rings */
    #why_choose_us .why-media-play-ring {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, .55);
        animation: whyPulse 2.6s cubic-bezier(.22, .61, .36, 1) infinite;
        pointer-events: none;
    }
    #why_choose_us .why-media-play-ring--2 {
        animation-delay: 1.3s;
    }
    @keyframes whyPulse {
        0%   { transform: scale(1);    opacity: .75; }
        100% { transform: scale(1.85); opacity: 0; }
    }

    /* Caption chip at the bottom of the frame */
    #why_choose_us .why-media-caption {
        position: absolute;
        left: 18px;
        right: 18px;
        bottom: 18px;
        z-index: 2;
        padding: 14px 18px;
        border-radius: 14px;
        background: rgba(15, 23, 42, .55);
        border: 1px solid rgba(255, 255, 255, .10);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        display: flex;
        align-items: baseline;
        gap: 12px;
    }
    #why_choose_us .why-media-caption-value {
        font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
        font-size: 1.55rem;
        font-weight: 600;
        line-height: 1;
        color: #ffffff;
        letter-spacing: -0.01em;
    }
    #why_choose_us .why-media-caption-label {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .72);
        line-height: 1.2;
    }

    /* ============================================================
       Responsive
       ============================================================ */
    @media (max-width: 1199px) {
        #why_choose_us .why-media-frame { aspect-ratio: 5 / 4; }
    }

    @media (max-width: 991px) {
        #why_choose_us .why-media {
            max-width: 520px;
            margin: clamp(28px, 5vh, 48px) auto 0;
        }
        #why_choose_us .why-media-frame { aspect-ratio: 4 / 3; }
    }

    @media (max-width: 767px) {
        #why_choose_us .why-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 575px) {
        #why_choose_us .why-card { padding: 20px 18px; border-radius: 16px; }
        #why_choose_us .why-number { font-size: 1.2rem; }
        #why_choose_us .why-card-title { font-size: 1rem; }
        #why_choose_us .why-card-text { font-size: .86rem; -webkit-line-clamp: 4; }

        #why_choose_us .why-media-frame { border-radius: 16px; }
        #why_choose_us .why-media-play { width: 56px; height: 56px; }
        #why_choose_us .why-media-caption { left: 12px; right: 12px; bottom: 12px; padding: 12px 14px; }
        #why_choose_us .why-media-caption-value { font-size: 1.25rem; }
    }

    @media (prefers-reduced-motion: reduce) {
        #why_choose_us .why-media-play-ring { animation: none; }
    }
</style><?php /**PATH D:\office_project\cust\resources\views/web/custom/sections/why-choose-us.blade.php ENDPATH**/ ?>