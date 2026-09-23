<style>
    /* ============================================================
       HEADER / NAVBAR — full width, logo left, nav right
       Works in both static and sticky states
       ============================================================ */

    /* ---------- Wrapper ---------- */
    .sticky-wrapper,
    .sticky-wrapper.is-sticky,
    .sticky-wrapper.sticky {
        position: relative;
        z-index: 999;
        width: 100%;
        left: 0;
        right: 0;
    }

    /* When theme makes it sticky, pin it full-width */
    .sticky-wrapper.is-sticky,
    .sticky-wrapper.sticky,
    .sticky-wrapper.fixed {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        background: rgba(6, 8, 14, .92);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-bottom: 1px solid rgba(255, 255, 255, .06);
    }

    /* ---------- Menu area ---------- */
    .sticky-wrapper .menu-area {
        width: 100%;
        padding: 0;
        background: transparent;
    }

    /* Full-width container with safe gutters */
    .sticky-wrapper .menu-area > .th-container4,
    .sticky-wrapper .menu-area > .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 14px clamp(20px, 3vw, 48px) !important;
        box-sizing: border-box;
    }

    /* ---------- Neutralise Bootstrap row/col ---------- */
    .sticky-wrapper .menu-wrapp { width: 100%; }
    .sticky-wrapper .menu-wrapp > .row {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .sticky-wrapper .menu-wrapp > .row > .col,
    .sticky-wrapper .menu-wrapp > .row > [class*="col"] {
        width: 100% !important;
        max-width: 100% !important;
        flex: 1 1 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* ---------- Single flex row: logo ←→ nav ---------- */
    .sticky-wrapper .header-left {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;   /* logo left · nav right */
        gap: clamp(24px, 3vw, 48px) !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* ---------- Logo — reset ALL theme positioning ---------- */
    .sticky-wrapper .header-logo {
        position: static !important;
        top: auto !important;
        left: auto !important;
        right: auto !important;
        bottom: auto !important;
        transform: none !important;
        margin: 0 !important;
        padding: 0 !important;
        flex: 0 0 auto !important;
        display: flex !important;
        align-items: center !important;
        line-height: 0 !important;
    }
    .sticky-wrapper .header-logo a {
        display: inline-flex !important;
        align-items: center !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .sticky-wrapper .header-logo img {
        height: 55px !important;
        width: auto !important;
        max-width: none !important;
        display: block !important;
        margin: 0 !important;
        transition: opacity .3s ease, height .3s ease;
    }
    .sticky-wrapper .header-logo a:hover img { opacity: .85; }

    /* shrink logo a touch when sticky */
    .sticky-wrapper.is-sticky .header-logo img,
    .sticky-wrapper.sticky .header-logo img,
    .sticky-wrapper.fixed .header-logo img {
        height: 55px !important;
    }

    /* ---------- Nav — pushed to the right ---------- */
    .sticky-wrapper .header-left .main-menu {
        flex: 1 1 auto !important;
        display: flex !important;
        justify-content: flex-end !important;      /* nav hugs right edge */
        margin: 0 !important;
        padding: 0 !important;
    }
    .sticky-wrapper .header-left .main-menu > ul {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: clamp(18px, 2.2vw, 34px) !important;
        margin: 0 !important;
        padding: 0 !important;
        list-style: none !important;
    }
    .sticky-wrapper .header-left .main-menu ul li {
        position: relative !important;
        margin: 0 !important;
        padding: 0 !important;
        float: none !important;
        display: inline-block !important;
    }
    .sticky-wrapper .header-left .main-menu ul li > a {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px;
        padding: 8px 0 !important;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: .02em;
        color: rgba(255, 255, 255, .82) !important;
        text-decoration: none !important;
        white-space: nowrap;
        transition: color .3s ease;
    }
    .sticky-wrapper .header-left .main-menu ul li > a:hover,
    .sticky-wrapper .header-left .main-menu ul li.active > a {
        color: #ffffff !important;
    }

    /* gold underline accent */
    .sticky-wrapper .header-left .main-menu ul li > a::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        height: 1px;
        width: 0;
        background: #d4a95d;
        transition: width .35s cubic-bezier(.22, .61, .36, 1);
    }
    .sticky-wrapper .header-left .main-menu ul li:hover > a::after,
    .sticky-wrapper .header-left .main-menu ul li.active > a::after {
        width: 100%;
    }

    /* ---------- Mobile hamburger — right edge ----------
       NOTE: no `display` on the base rule, so Bootstrap's
       .d-lg-none can hide it above 992px without a fight. */
    .sticky-wrapper .sticky-menu-wrap {
        flex: 0 0 auto !important;
        margin: 0 0 0 auto !important;
        padding: 0 !important;
    }

    .sticky-wrapper .th-menu-toggle {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 42px;
        height: 42px;
        padding: 0 !important;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 8px;
        background: rgba(255, 255, 255, .04);
        color: #fff;
        font-size: 18px;
        line-height: 1;
        cursor: pointer;
        transition: background-color .3s ease, border-color .3s ease;
    }
    .sticky-wrapper .th-menu-toggle:hover {
        background: rgba(255, 255, 255, .10);
        border-color: rgba(255, 255, 255, .32);
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 991px) {
        /* Show the hamburger wrapper only on mobile — never touches
           the desktop state, so Bootstrap's .d-lg-none wins above 992px. */
        .sticky-wrapper .sticky-menu-wrap {
            display: flex !important;
            align-items: center !important;
        }
        .sticky-wrapper .header-left .main-menu { display: none !important; }
        .sticky-wrapper .header-left { justify-content: space-between !important; }
    }

    @media (max-width: 575px) {
        .sticky-wrapper .header-logo img { height: 38px !important; }
        .sticky-wrapper .th-menu-toggle { width: 38px; height: 38px; font-size: 16px; }
    }
</style>

<div class="sticky-wrapper">
    <!-- Main Menu Area -->
    <div class="menu-area d-none d-lg-block">
        <div class="container-fluid th-container4 th-container2">
            <div class="menu-wrapp">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="header-left d-flex align-items-center">

                            
                            <div class="header-logo">
                                <a href="<?php echo e(route('home')); ?>">
                                    <img src="<?php echo e(asset('dist/images/logo-white.png')); ?>" alt="CUST Logo" />
                                </a>
                            </div>

                            
                            <nav class="main-menu d-none d-lg-block">
                                <ul>
                                    <?php if($navbarItems->isNotEmpty()): ?>
                                        <?php echo $__env->make('web.custom.components.partials.nav-items', ['items' => $navbarItems], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php else: ?>
                                        <li>
                                            <a href="<?php echo e(route('home')); ?>">Home</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>

                            
                            <div class="sticky-menu-wrap d-lg-none">
                                <button type="button" class="th-menu-toggle">
                                    <i class="far fa-bars"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\office_project\cust\resources\views/web/custom/components/navigation.blade.php ENDPATH**/ ?>