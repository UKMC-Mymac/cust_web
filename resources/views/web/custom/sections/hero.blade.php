@php
    $heroSliders = $sliders ?? collect();
    $totalSlides = $heroSliders->count();
    $totalSlidesPadded = str_pad($totalSlides, 2, '0', STR_PAD_LEFT);
@endphp

<style>
    /* ============================================================
       HERO CAROUSEL — full-bleed slide, auto-height centered card
       ============================================================ */
    #hero {
        --hero-bg: #05070d;
        --hero-gold: #d4a95d;
        --hero-gold-2: #e8c88a;
        --hero-white: #ffffff;
        --hero-muted: rgba(255, 255, 255, .60);
        --hero-muted-2: rgba(255, 255, 255, .42);
        --hero-border: rgba(255, 255, 255, .14);
        --hero-border-2: rgba(255, 255, 255, .08);
        --hero-radius: 999px;
        --hero-ease: cubic-bezier(.22, .61, .36, 1);
        --hero-stat-h: 96px;

        /* clearance above / below the card */
        --hero-pad-top: clamp(90px, 11vh, 130px);
        --hero-pad-bottom: calc(var(--hero-stat-h) + clamp(40px, 6vh, 70px));

        --hero-overlay:
            linear-gradient(90deg,
                rgba(4, 6, 11, .94) 0%,
                rgba(4, 6, 11, .78) 34%,
                rgba(4, 6, 11, .42) 62%,
                rgba(4, 6, 11, .10) 100%),
            linear-gradient(180deg,
                rgba(4, 6, 11, .55) 0%,
                rgba(4, 6, 11, 0) 26%,
                rgba(4, 6, 11, .35) 100%);

        position: relative;
        isolation: isolate;
        background: var(--hero-bg);
        overflow: hidden;
        font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    /* ============================================================
       SLIDE — full height, no height:auto
       ============================================================ */
    #hero .swiper-slide {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        min-height: 100svh;
        /* IMPORTANT: no height:auto, no vertical padding here */
        box-sizing: border-box;
        overflow: hidden;
    }

    /* hero-inner owns full height + padding, so the background
       (absolute inset:0 inside it) can cover the whole slide */
    #hero .hero-inner {
        position: relative;
        width: 100%;
        min-height: 100vh;
        min-height: 100svh;
        display: flex;
        align-items: center;         /* vertically center the card */
        justify-content: center;
        box-sizing: border-box;
        padding-top: var(--hero-pad-top);
        padding-bottom: var(--hero-pad-bottom);
    }

    /* ---------- Background ---------- */
    #hero .th-hero-bg {
        position: absolute;
        inset: 0;
        z-index: 0;
        background-size: cover;
        background-position: center right;
        background-repeat: no-repeat;
        transform: scale(1.06);
        transition: transform 10s linear;
        will-change: transform;
    }

    #hero .swiper-slide-active .th-hero-bg {
        transform: scale(1.14);
    }

    #hero .hero-inner::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        background: var(--hero-overlay);
        pointer-events: none;
    }

    /* ---------- Container ---------- */
    #hero .th-container2 {
        position: relative;
        z-index: 2;
        width: 100%;
        height: auto;
        padding-top: 0;
        padding-bottom: 0;
        padding-left: clamp(20px, 3vw, 48px);
        padding-right: clamp(20px, 3vw, 48px);
    }

    /* ============================================================
       GLASS CARD — auto height, centered, water-flow effect
       ============================================================ */
    #hero .hero-style1 {
        position: relative;
        isolation: isolate;
        max-width: 620px;

        /* do NOT stretch — take only content height */
        height: auto !important;
        max-height: none !important;
        flex: 0 0 auto;
        align-self: center;
        margin: 0;

        padding: clamp(28px, 3.4vh, 44px) clamp(24px, 3vw, 40px);

        border: 1px solid rgba(255, 255, 255, .10);
        border-radius: 20px;
        background:
            linear-gradient(135deg,
                rgba(255, 255, 255, .07) 0%,
                rgba(255, 255, 255, .03) 40%,
                rgba(255, 255, 255, .05) 100%);
        backdrop-filter: blur(22px) saturate(140%);
        -webkit-backdrop-filter: blur(22px) saturate(140%);
        box-shadow:
            0 30px 80px -40px rgba(0, 0, 0, .65),
            inset 0 1px 0 rgba(255, 255, 255, .10),
            inset 0 -1px 0 rgba(255, 255, 255, .04);
        overflow: hidden;
    }

    /* --- Layer 1: rotating water light pool --- */
    #hero .hero-style1::before {
        content: "";
        position: absolute;
        inset: -60%;
        z-index: -1;
        background:
            conic-gradient(from 0deg at 50% 50%,
                transparent 0deg,
                rgba(120, 200, 255, .10) 60deg,
                transparent 120deg,
                rgba(255, 255, 255, .06) 200deg,
                transparent 260deg,
                rgba(120, 200, 255, .08) 320deg,
                transparent 360deg);
        filter: blur(40px);
        animation: heroWaterFlow 18s linear infinite;
        pointer-events: none;
    }

    /* --- Layer 2: diagonal light sheen --- */
    #hero .hero-style1::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;
        background: linear-gradient(115deg,
            transparent 30%,
            rgba(255, 255, 255, .08) 45%,
            rgba(180, 220, 255, .12) 50%,
            rgba(255, 255, 255, .08) 55%,
            transparent 70%);
        background-size: 250% 100%;
        background-position: -150% 0;
        animation: heroWaterSheen 9s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes heroWaterFlow {
        0%   { transform: rotate(0deg)   scale(1); }
        50%  { transform: rotate(180deg) scale(1.15); }
        100% { transform: rotate(360deg) scale(1); }
    }

    @keyframes heroWaterSheen {
        0%   { background-position: -150% 0; }
        55%  { background-position: 250% 0; }
        100% { background-position: 250% 0; }
    }

    /* ============================================================
       CONTENT — compact typography inside the card
       ============================================================ */
    #hero .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        margin: 0 0 16px;
        border: 1px solid var(--hero-border);
        border-radius: var(--hero-radius);
        background: rgba(255, 255, 255, .04);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        font-size: 10px;
        font-weight: 500;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .82);
    }

    #hero .hero-badge .dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--hero-gold);
        box-shadow: 0 0 0 3px rgba(212, 169, 93, .20);
    }

    #hero .hero-title {
        margin: 0 0 12px;
        font-size: clamp(1.4rem, 2.7vw, 2.35rem);
        font-weight: 500;
        line-height: 1.14;
        letter-spacing: -0.02em;
        color: var(--hero-white);
        text-wrap: balance;
    }

    #hero .hero-title .accent {
        display: block;
        margin-top: .06em;
        font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 500;
        letter-spacing: -0.012em;
        background: linear-gradient(100deg, var(--hero-gold) 0%, var(--hero-gold-2) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    #hero .hero-quote {
        position: relative;
        margin: 0 0 12px;
        padding: 2px 0 2px 14px;
        border-left: 2px solid var(--hero-gold);
        font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 400;
        font-size: clamp(.9rem, .95vw, 1rem);
        line-height: 1.5;
        color: rgba(255, 255, 255, .92);
    }

    #hero .hero-quote b,
    #hero .hero-quote strong { font-weight: 600; color: #fff; }

    #hero .hero-text {
        max-width: 52ch;
        margin: 0 0 20px;
        font-size: clamp(.82rem, .84vw, .88rem);
        font-weight: 300;
        line-height: 1.68;
        letter-spacing: .004em;
        color: var(--hero-muted);
    }

    #hero .hero-text b,
    #hero .hero-text strong { font-weight: 500; color: rgba(255, 255, 255, .9); }

    /* ============================================================
       BUTTONS
       ============================================================ */
    #hero .btn-wrap {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    #hero .btn-wrap .th-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 22px;
        border: 1px solid transparent;
        border-radius: var(--hero-radius);
        font-size: 11.5px;
        font-weight: 600;
        line-height: 1;
        letter-spacing: .14em;
        text-transform: uppercase;
        text-decoration: none;
        white-space: nowrap;
        transition:
            background-color .35s var(--hero-ease),
            color .35s var(--hero-ease),
            border-color .35s var(--hero-ease),
            transform .35s var(--hero-ease),
            box-shadow .35s var(--hero-ease);
    }

    #hero .btn-wrap .th-btn i { display: none; }

    #hero .btn-wrap .th-btn.th-icon::after {
        content: "→";
        font-size: 13px;
        line-height: 1;
        font-weight: 500;
        transition: transform .35s var(--hero-ease);
    }

    #hero .btn-wrap .th-btn.style-border1::after {
        content: "›";
        font-size: 17px;
        margin-top: -2px;
    }

    #hero .btn-wrap .th-btn:hover::after { transform: translateX(4px); }

    #hero .btn-wrap .th-btn.white-hover:not(.style-border1) {
        background: linear-gradient(180deg, var(--hero-gold-2) 0%, var(--hero-gold) 100%);
        color: #1a1206;
        box-shadow: 0 12px 28px -14px rgba(212, 169, 93, .65);
    }

    #hero .btn-wrap .th-btn.white-hover:not(.style-border1):hover,
    #hero .btn-wrap .th-btn.white-hover:not(.style-border1):focus-visible {
        background: linear-gradient(180deg, #f0d29b 0%, var(--hero-gold-2) 100%);
        transform: translateY(-2px);
        box-shadow: 0 18px 34px -14px rgba(212, 169, 93, .85);
        outline: none;
    }

    #hero .btn-wrap .th-btn.style-border1 {
        background: rgba(255, 255, 255, .02);
        color: rgba(255, 255, 255, .92);
        border-color: var(--hero-border);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    #hero .btn-wrap .th-btn.style-border1:hover,
    #hero .btn-wrap .th-btn.style-border1:focus-visible {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .30);
        color: #fff;
        transform: translateY(-2px);
        outline: none;
    }

    /* ============================================================
       STATS BAR
       ============================================================ */
    #hero .hero-stats {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 7;
        height: var(--hero-stat-h);
        background: linear-gradient(180deg, rgba(6, 8, 14, .78) 0%, rgba(6, 8, 14, .96) 100%);
        border-top: 1px solid var(--hero-border-2);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
    }

    #hero .hero-stats .container { height: 100%; }

    #hero .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        height: 100%;
    }

    #hero .stat-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 0 clamp(14px, 2vw, 26px);
        border-right: 1px solid var(--hero-border-2);
    }

    #hero .stat-item:last-child { border-right: 0; }

    #hero .stat-icon {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border: 1px solid rgba(212, 169, 93, .28);
        border-radius: 10px;
        background: rgba(212, 169, 93, .06);
        color: var(--hero-gold);
    }

    #hero .stat-icon svg { width: 18px; height: 18px; }

    #hero .stat-value {
        font-size: 1.05rem;
        font-weight: 600;
        letter-spacing: -.01em;
        color: #fff;
        line-height: 1.15;
    }

    #hero .stat-label {
        font-size: 11px;
        font-weight: 400;
        letter-spacing: .02em;
        color: var(--hero-muted-2);
        line-height: 1.3;
        margin-top: 3px;
    }

    /* ---------- Entrance motion ---------- */
    @keyframes heroRise {
        from { opacity: 0; transform: translate3d(0, 26px, 0); }
        to   { opacity: 1; transform: translate3d(0, 0, 0); }
    }

    #hero .swiper-slide-active .hero-badge { animation: heroRise .9s var(--hero-ease) .05s both; }
    #hero .swiper-slide-active .hero-title { animation: heroRise .9s var(--hero-ease) .18s both; }
    #hero .swiper-slide-active .hero-quote { animation: heroRise .9s var(--hero-ease) .32s both; }
    #hero .swiper-slide-active .hero-text  { animation: heroRise .9s var(--hero-ease) .44s both; }
    #hero .swiper-slide-active .btn-wrap   { animation: heroRise .9s var(--hero-ease) .56s both; }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1199px) {
        #hero .hero-style1 { max-width: 560px; }
    }

    @media (max-width: 991px) {
        #hero {
            --hero-overlay:
                linear-gradient(180deg,
                    rgba(4, 6, 11, .72) 0%,
                    rgba(4, 6, 11, .78) 52%,
                    rgba(4, 6, 11, .94) 100%);
            --hero-stat-h: 168px;
        }

        #hero .hero-style1 {
            max-width: 620px;
            text-align: center;
            padding: clamp(26px, 3.6vh, 40px) clamp(22px, 3.4vw, 36px);
        }

        #hero .hero-badge { margin-inline: auto; }

        #hero .hero-quote {
            padding-left: 0;
            border-left: 0;
        }

        #hero .hero-text { margin-inline: auto; }
        #hero .btn-wrap { justify-content: center; }

        #hero .stats-grid { grid-template-columns: repeat(2, 1fr); }

        #hero .stat-item:nth-child(2) { border-right: 0; }
        #hero .stat-item:nth-child(1),
        #hero .stat-item:nth-child(2) { border-bottom: 1px solid var(--hero-border-2); }
    }

    @media (max-width: 767px) {
        #hero {
            --hero-stat-h: 152px;
            --hero-pad-top: 84px;
            --hero-pad-bottom: calc(var(--hero-stat-h) + 24px);
        }

        #hero .th-container2 {
            padding-left: 20px;
            padding-right: 20px;
        }

        #hero .hero-style1 {
            padding: 24px 20px;
            border-radius: 20px;
        }

        #hero .hero-title {
            font-size: clamp(1.3rem, 5.6vw, 1.75rem);
            line-height: 1.16;
            margin-bottom: 10px;
        }

        #hero .hero-quote { font-size: .9rem; margin-bottom: 10px; }
        #hero .hero-text  { font-size: .82rem; margin-bottom: 18px; }

        #hero .hero-badge {
            font-size: 9.5px;
            padding: 6px 12px;
            letter-spacing: .18em;
            margin-bottom: 14px;
        }

        #hero .btn-wrap { gap: 8px; }
        #hero .btn-wrap .th-btn {
            padding: 11px 18px;
            font-size: 11px;
            letter-spacing: .12em;
        }

        #hero .stats-grid { grid-template-columns: repeat(2, 1fr); }
        #hero .stat-item { padding: 0 14px; gap: 10px; }
        #hero .stat-icon { width: 32px; height: 32px; }
        #hero .stat-icon svg { width: 15px; height: 15px; }
        #hero .stat-value { font-size: .95rem; }
        #hero .stat-label { font-size: 10px; }
    }

    @media (max-width: 575px) {
        #hero .btn-wrap {
            flex-direction: column;
            align-items: stretch;
            max-width: 300px;
            margin-inline: auto;
        }

        #hero .btn-wrap .th-btn {
            width: 100%;
            justify-content: center;
            padding: 12px 18px;
        }

        #hero .btn-wrap .th-btn.th-icon::after { margin-left: auto; }
    }

    @media (prefers-reduced-motion: reduce) {
        #hero *, #hero *::before, #hero *::after {
            animation-duration: .001ms !important;
            animation-delay: 0ms !important;
            transition-duration: .001ms !important;
        }
        #hero .th-hero-bg,
        #hero .swiper-slide-active .th-hero-bg { transform: scale(1.03); }
    }
</style>

<div class="th-hero-wrapper hero-1" id="hero">
    <div class="swiper th-slider" id="heroSlide"
        data-slider-options='{"effect":"fade","navigation":{"nextEl":".hero-nav-next","prevEl":".hero-nav-prev"},"pagination":{"el":".slider-pagination","clickable":true}}'>
        <div class="swiper-wrapper">

            @if ($heroSliders->isNotEmpty())
                @foreach ($heroSliders as $slider)
                    @php
                        $primaryButtonUrl = $slider->button_link ?? '';
                        if (!empty($slider->page_id)) {
                            $primaryPage = \App\Models\Web\Page::find($slider->page_id);
                            if ($primaryPage) {
                                $primaryButtonUrl = route('page.single', $primaryPage->slug);
                            }
                        } elseif (!empty($slider->route_name)) {
                            try {
                                $primaryButtonUrl = route($slider->route_name);
                            } catch (\Exception $e) {
                                $primaryButtonUrl = $slider->button_link ?? '';
                            }
                        }

                        $secondaryButtonUrl = $slider->button_link_2 ?? '';
                        if (!empty($slider->page_id_2)) {
                            $secondaryPage = \App\Models\Web\Page::find($slider->page_id_2);
                            if ($secondaryPage) {
                                $secondaryButtonUrl = route('page.single', $secondaryPage->slug);
                            }
                        } elseif (!empty($slider->route_name_2)) {
                            try {
                                $secondaryButtonUrl = route($slider->route_name_2);
                            } catch (\Exception $e) {
                                $secondaryButtonUrl = $slider->button_link_2 ?? '';
                            }
                        }

                        $titleParts = preg_split('/\s*\|\s*/', (string) ($slider->title ?? ''), 2);
                        $titleMain = trim($titleParts[0] ?? '');
                        $titleAccent = trim($titleParts[1] ?? '');

                        $badge = $slider->badge ?? 'Admissions Open · Fall 2025';
                    @endphp

                    <div class="swiper-slide">
                        <div class="hero-inner">
                            <div class="th-hero-bg"
                                data-bg-src="{{ asset('uploads/slider/' . ($slider->attach ?? '')) }}"></div>

                            <div class="container th-container2">
                                <div class="hero-style1">
                                    <div class="hero-text-wrap">

                                        @if (!empty($badge))
                                            <div class="hero-badge">
                                                <span class="dot"></span>
                                                {{ $badge }}
                                            </div>
                                        @endif

                                        <h1 class="hero-title text-white" data-ani="slideinup" data-ani-delay="0.3s">
                                            {{ $titleMain }}
                                            @if ($titleAccent)
                                                <span class="accent">{{ $titleAccent }}</span>
                                            @endif
                                        </h1>

                                        @if (!empty($slider->sub_title))
                                            <p class="hero-quote text-white" data-ani="slideinup" data-ani-delay="0.5s">
                                                {!! strip_tags($slider->sub_title ?? '', '<b><u><i><em><br>') !!}
                                            </p>
                                        @endif

                                        @if (!empty($slider->short_description ?? null))
                                            <p class="hero-text" data-ani="slideinup" data-ani-delay="0.65s">
                                                {{ $slider->short_description }}
                                            </p>
                                        @endif

                                        <div class="btn-wrap justify-content-center justify-content-lg-start"
                                            data-ani="slideinup" data-ani-delay="0.8s">

                                            @if (!empty($primaryButtonUrl) || !empty($secondaryButtonUrl))
                                                @if (!empty($primaryButtonUrl))
                                                    <a href="{{ $primaryButtonUrl }}"
                                                        class="th-btn white-hover th-icon">
                                                        {{ $slider->button_text ?? 'Apply Now' }}
                                                    </a>
                                                @endif

                                                @if (!empty($secondaryButtonUrl))
                                                    <a href="{{ $secondaryButtonUrl }}"
                                                        class="th-btn style-border1 th-icon white-hover">
                                                        {{ $slider->button_text_2 ?? 'Explore Programs' }}
                                                    </a>
                                                @endif
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="swiper-slide">
                    <div class="hero-inner text-center text-white">
                        <h2>No sliders available</h2>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>