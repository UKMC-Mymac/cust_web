<?php $__env->startSection('title', $page->display_text ?? $page->title); ?>
<?php $__env->startSection('content'); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Saira+Extra+Condensed:wght@700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

<style>
    :root {
        --teal-dark:  #0f3a4f;
        --teal:       #125875;
        --teal-light: #1b8aad;
        --gold:       #c8973a;
        --ink-mid:    #2c4a5a;
        --ink-soft:   #5a7585;
        --bg:         #f2f6fa;
        --surface:    #ffffff;
        --border:     rgba(18, 88, 117, 0.10);
        --radius:     24px;
        --shadow:     0 20px 52px rgba(13, 43, 62, 0.11);
    }

    *, *::before, *::after { box-sizing: border-box; }

    /* ── Shell ── */
    .page-shell {
        background: var(--bg);
        padding: 48px 0 72px;
    }

    /* ── Content card ── */
    .page-content-wrap {
        margin-top: -32px;
        position: relative;
        z-index: 10;
        opacity: 0;
        animation: fadeUp 0.6s 0.28s forwards;
    }

    .page-card {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .page-card-bar {
        height: 4px;
        background: linear-gradient(90deg, var(--teal) 0%, var(--teal-light) 55%, var(--gold) 100%);
    }

    .page-card-body {
        padding: 44px 52px 52px;
    }

    @media (max-width: 767px) {
        .page-card-body { padding: 28px 22px 36px; }
        .page-content-wrap { margin-top: -20px; }
    }

    /* ── Rich content ── */
    .page-rich-content,
    .page-rich-content p,
    .page-rich-content ul,
    .page-rich-content ol,
    .page-rich-content li,
    .page-rich-content span {
        font-family: 'DM Sans', sans-serif !important;
        font-size: 1.02rem !important;
        line-height: 1.9 !important;
        color: #000000 !important;
    }

    .page-rich-content > *:first-child { margin-top: 0 !important; }
    .page-rich-content > *:last-child  { margin-bottom: 0 !important; }

    /* headings */
    .page-rich-content h1,
    .page-rich-content h2 {
        font-family: 'Saira Extra Condensed', sans-serif;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--teal-dark);
        line-height: 1.05;
        margin: 2rem 0 0.65rem;
    }
    .page-rich-content h1 { font-size: clamp(1.85rem, 3vw, 2.8rem); }
    .page-rich-content h2 {
        font-size: clamp(1.45rem, 2.5vw, 2rem);
        padding-bottom: 10px;
        border-bottom: 2px solid rgba(18,88,117,0.12);
    }
    .page-rich-content h3,
    .page-rich-content h4,
    .page-rich-content h5,
    .page-rich-content h6 {
        font-family: 'DM Sans', sans-serif;
        font-weight: 700;
        color: var(--teal);
        margin: 1.7rem 0 0.5rem;
    }
    .page-rich-content h3 { font-size: 1.22rem; }
    .page-rich-content h4 { font-size: 1.05rem; }
    .page-rich-content h5,
    .page-rich-content h6 {
        font-size: 0.88rem;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: var(--ink-soft);
    }

    /* paragraph */
    .page-rich-content p { margin: 0 0 1.1rem; }

    /* links */
    .page-rich-content a {
        color: var(--teal);
        text-decoration: underline;
        text-decoration-thickness: 1px;
        text-underline-offset: 3px;
        transition: color 0.2s;
        word-break: break-word;
    }
    .page-rich-content a:hover { color: var(--teal-dark); }
    
    .page-rich-content h1 a,
    .page-rich-content h2 a,
    .page-rich-content h3 a,
    .page-rich-content h4 a,
    .page-rich-content h5 a,
    .page-rich-content h6 a {
        color: inherit;
        text-decoration: none;
        font-weight: inherit;
    }
    .page-rich-content h1 a:hover,
    .page-rich-content h2 a:hover,
    .page-rich-content h3 a:hover,
    .page-rich-content h4 a:hover,
    .page-rich-content h5 a:hover,
    .page-rich-content h6 a:hover {
        color: var(--theme-color2);
        text-decoration: underline;
    }

    /* images */
    .page-rich-content img {
        max-width: 100%;
        height: auto;
        border-radius: 14px;
        box-shadow: 0 8px 28px rgba(13,43,62,0.10);
        display: block;
        margin: 1.4rem 0;
    }
    .page-rich-content img.img-float-left,
    .page-rich-content img[style*="float: left"] {
        float: left;
        margin: 0.2rem 1.4rem 1rem 0;
    }
    .page-rich-content img.img-float-right,
    .page-rich-content img[style*="float: right"] {
        float: right;
        margin: 0.2rem 0 1rem 1.4rem;
    }
    .page-rich-content img.img-centered {
        margin-left: auto;
        margin-right: auto;
    }
    .page-rich-content img.img-inline {
        display: inline-block;
        vertical-align: middle;
        margin: 0 0.3rem;
        box-shadow: none;
    }
    .page-rich-content .is-member-grid-wrap {
        margin: 2rem 0 !important;
        overflow: visible !important;
    }
    .page-rich-content .is-member-grid {
        width: 100% !important;
        border-collapse: collapse !important;
    }
    .page-rich-content .is-member-grid > tbody > tr {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)) !important;
        gap: 28px !important;
        width: 100% !important;
        align-items: start !important;
    }
    .page-rich-content .is-member-grid > tbody > tr > td {
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        width: auto !important;
        vertical-align: initial !important;
        display: flex !important;
        justify-content: center !important;
    }
    /* Redesigned member card */
    .page-rich-content .is-member-grid-card,
    .page-rich-content .member-card-embed {
        display: block !important;
        width: 100% !important;
        max-width: 280px !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        background: var(--surface) !important;
        border: 1px solid rgba(18,88,117,0.06) !important;
        box-shadow: 0 10px 28px rgba(13,43,62,0.06) !important;
        transition: transform 180ms ease, box-shadow 180ms ease !important;
        position: relative !important;
    }
    .page-rich-content .is-member-grid-card::before,
    .page-rich-content .member-card-embed::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        height: 6px !important;
        background: linear-gradient(90deg, var(--teal) 0%, var(--teal-light) 55%, var(--gold) 100%) !important;
    }
    .page-rich-content .is-member-grid-card:hover,
    .page-rich-content .member-card-embed:hover {
        transform: translateY(-6px) !important;
        box-shadow: 0 18px 40px rgba(13,43,62,0.12) !important;
    }
    .page-rich-content .is-member-grid-card tbody,
    .page-rich-content .is-member-grid-card tr,
    .page-rich-content .member-card-embed tbody,
    .page-rich-content .member-card-embed tr {
        display: block !important;
        width: 100% !important;
    }
    .page-rich-content .is-member-grid-card td,
    .page-rich-content .member-card-embed td {
        display: block !important;
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        text-align: center !important;
    }
    .page-rich-content .is-member-grid-card tr:first-child td,
    .page-rich-content .member-card-embed tr:first-child td {
        padding: 0 !important;
    }
    .page-rich-content .is-member-grid-card img,
    .page-rich-content .member-card-embed img {
        display: block !important;
        width: 100% !important;
        height: 220px !important;
        object-fit: cover !important;
        object-position: center !important;
    }
    .page-rich-content .is-member-grid-card tr:nth-child(2) td,
    .page-rich-content .member-card-embed tr:nth-child(2) td {
        padding: 10px 14px 4px !important;
    }
    .page-rich-content .is-member-grid-link,
    .page-rich-content .member-card-link {
        color: var(--teal) !important;
        text-decoration: none !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
        line-height: 1.18 !important;
        display: block !important;
        margin: 0 !important;
    }
    .page-rich-content .is-member-grid-link:hover,
    .page-rich-content .member-card-link:hover {
        text-decoration: underline !important;
        color: var(--teal-dark) !important;
    }
    .page-rich-content .is-member-grid-card tr:nth-child(3) td,
    .page-rich-content .member-card-embed tr:nth-child(3) td {
        padding: 4px 14px 12px !important;
        font-size: 0.92rem !important;
        color: var(--ink-soft) !important;
        line-height: 1.35 !important;
    }
    /* Simple card look: image + name + designation inside white card with grey shadow */
    .page-rich-content .is-member-grid-card,
    .page-rich-content .member-card-embed {
        background: #ffffff !important;
        border-radius: 12px !important;
        box-shadow: 0 8px 20px rgba(60,64,67,0.10) !important;
        border: 1px solid rgba(60,64,67,0.06) !important;
        overflow: hidden !important;
    }
    /* remove decorative accent bar */
    .page-rich-content .is-member-grid-card::before,
    .page-rich-content .member-card-embed::before {
        display: none !important;
        content: none !important;
        height: 0 !important;
    }
    .page-rich-content .is-member-grid-card img,
    .page-rich-content .member-card-embed img {
        height: 200px !important;
        width: 100% !important;
        object-fit: cover !important;
    }

    /* For member rows (multiple columns) let the image scale with column width
       so images are taller on large screens. Single-member embeds keep fixed height. */
    .page-rich-content .is-member-grid .is-member-grid-card img {
        height: auto !important;
        aspect-ratio: 1 / 1 !important;
        max-height: none !important;
        width: 100% !important;
    }
    .page-rich-content .is-member-grid-card tr:nth-child(2) td,
    .page-rich-content .member-card-embed tr:nth-child(2) td,
    .page-rich-content .is-member-grid-card tr:nth-child(3) td,
    .page-rich-content .member-card-embed tr:nth-child(3) td {
        padding: 10px 16px !important;
    }
    /* Ensure single-member embeds use the same card treatment */
    .page-rich-content .member-card-embed {
        display: block !important;
        width: 100% !important;
        max-width: 280px !important;
        margin: 0 auto !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        background: var(--member-card-bg) !important;
        border: 1px solid rgba(60,64,67,0.06) !important;
        box-shadow: 0 8px 20px rgba(60,64,67,0.10) !important;
        transition: transform 180ms ease, box-shadow 180ms ease !important;
        position: relative !important;
    }
    /* alignment helpers added to HTML by editor */
    .page-rich-content .member-card-embed.align-left { margin-left: 0 !important; margin-right: auto !important; }
    .page-rich-content .member-card-embed.align-right { margin-left: auto !important; margin-right: 0 !important; }
    .page-rich-content .member-card-embed.align-center { margin-left: auto !important; margin-right: auto !important; }
    .page-rich-content .is-member-grid-card.align-left { margin-left: 0 !important; margin-right: auto !important; }
    .page-rich-content .is-member-grid-card.align-right { margin-left: auto !important; margin-right: 0 !important; }
    .page-rich-content .is-member-grid-card.align-center { margin-left: auto !important; margin-right: auto !important; }
    .page-rich-content .member-card-embed tbody,
    .page-rich-content .member-card-embed tr {
        display: block !important;
        width: 100% !important;
    }
    .page-rich-content .member-card-embed td {
        display: block !important;
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        text-align: center !important;
    }
    /* tighten spacing between image and name for single-member embeds */
    .page-rich-content .member-card-embed tr:nth-child(2) td {
        padding: 6px 6px 0 !important;
    }
    .page-rich-content .member-card-embed tr:nth-child(3) td {
        padding: 0 6px 10px !important;
    }
    .page-rich-content .member-card-embed img {
        width: 100% !important;
        height: auto !important;
        max-height: 260px !important;
        object-fit: cover !important;
        object-position: center !important;
        display: block !important;
        margin: 0 auto !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }
    /* stronger overrides to remove any remaining gap */
    .page-rich-content .member-card-embed td a,
    .page-rich-content .member-card-embed td a.member-card-link {
        padding: 0 !important;
        margin: 0 !important;
        line-height: 1.15 !important;
        display: inline-block !important;
    }
    .page-rich-content .member-card-embed img {
        margin-bottom: 4px !important;
    }
    .page-rich-content .member-card-embed tr:nth-child(2) td {
        padding-top: 4px !important;
    }
    /* override inline heights set by the editor generator */
    .page-rich-content .member-card-embed,
    .page-rich-content .member-card-embed tbody,
    .page-rich-content .member-card-embed tr,
    .page-rich-content .member-card-embed td {
        height: auto !important;
        min-height: 0 !important;
    }
    .page-rich-content .member-card-embed td img {
        /* make the image fill the inline-heighted cell to avoid whitespace */
        height: 100% !important;
        max-height: none !important;
        width: 100% !important;
        max-width: 100% !important;
        object-fit: cover !important;
    }
    .page-rich-content .member-card-link {
        color: #0f3a4f !important;
        text-decoration: none !important;
        font-weight: 700 !important;
        font-size: 0.95rem !important;
        line-height: 1.25 !important;
        display: block !important;
        margin: 2px 0 0 !important;
        padding: 0 !important;
    }
    .page-rich-content .member-card-link:hover {
        text-decoration: underline !important;
        color: #125875 !important;
    }
    .page-rich-content::after { content: ''; display: block; clear: both; }

    /* figure */
    .page-rich-content figure { margin: 1.6rem 0; }
    .page-rich-content figure img { margin: 0; }
    .page-rich-content figcaption {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: var(--ink-soft);
        text-align: center;
        font-style: italic;
    }

    /* lists */
    .page-rich-content ul,
    .page-rich-content ol {
        padding-left: 1.5rem;
        margin: 0 0 1.1rem;
    }
    .page-rich-content li + li { margin-top: 0.38rem; }

    /* member inline links */
    .page-rich-content .member-inline-link {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        background-color: var(--teal) !important;
        color: #ffffff !important;
        padding: 5px 10px !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 0.9rem !important;
        text-decoration: none !important;
        line-height: 1.25 !important;
        transition: all 0.2s ease-in-out !important;
        margin: 2px 2px !important;
        box-shadow: 0 2px 4px rgba(18, 88, 117, 0.12) !important;
        vertical-align: middle !important;
    }
    .page-rich-content .member-inline-link span {
        font-family: 'DM Sans', sans-serif !important;
        font-size: inherit !important;
        color: inherit !important;
        line-height: inherit !important;
        font-weight: inherit !important;
        display: inline !important;
    }
    .page-rich-content .member-inline-link:hover {
        background-color: var(--teal-dark) !important;
        color: #ffffff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(18, 88, 117, 0.22) !important;
        text-decoration: none !important;
    }
    .page-rich-content .member-inline-link.align-left {
        float: none !important;
    }

    /* blockquote */
    .page-rich-content blockquote {
        margin: 1.6rem 0;
        padding: 1.1rem 1.4rem;
        background: #f2f8fc;
        border-left: 4px solid var(--teal);
        border-radius: 0 12px 12px 0;
        color: var(--ink-mid);
        font-style: italic;
        font-size: 1.02rem;
    }

    /* hr */
    .page-rich-content hr {
        border: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(18,88,117,0.25), transparent);
        margin: 2rem 0;
    }

    /* tables */
    .table-responsive-wrap {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 1.4rem 0;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(13,43,62,0.07);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .page-rich-content table:not(.is-member-grid):not(.member-card-embed):not(.is-member-grid-card) {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        font-size: 0.94rem;
    }
    .page-rich-content thead th {
        background: linear-gradient(135deg, var(--teal-dark), var(--teal));
        color: #fff;
        font-weight: 600;
        padding: 0.9rem 1rem;
        text-align: left;
        border-bottom: 2px solid rgba(255,255,255,0.1);
    }
    .page-rich-content td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid var(--border);
        border-right: 1px solid var(--border);
        background: var(--surface);
        vertical-align: top;
    }
    .page-rich-content td:last-child { border-right: 0; }
    .page-rich-content tbody tr:last-child td { border-bottom: 0; }
    .page-rich-content tbody tr:nth-child(even) td { background: #f6fafd; }
    .page-rich-content tbody tr:hover td { background: #eef6fc; }
    .page-rich-content table:not(.is-member-grid):not(.member-card-embed):not(.is-member-grid-card) td img {
        margin: 4px 0 !important;
        box-shadow: none !important;
        border-radius: 6px !important;
        max-width: 100% !important;
        height: auto !important;
        display: inline-block !important;
        vertical-align: middle;
    }

    /* Lightbox Modal for Full Screen Image View */
    .lightbox-modal {
        display: none;
        position: fixed;
        z-index: 99999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(13, 27, 34, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .lightbox-modal.show {
        display: flex;
        opacity: 1;
    }
    
    .lightbox-content {
        max-width: 90%;
        max-height: 90%;
        border-radius: 12px;
        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
        transform: scale(0.9);
        transition: transform 0.3s ease;
        object-fit: contain;
    }
    
    .lightbox-modal.show .lightbox-content {
        transform: scale(1);
    }
    
    .lightbox-close {
        position: absolute;
        top: 24px;
        right: 28px;
        color: #ffffff;
        font-size: 38px;
        font-weight: 300;
        cursor: pointer;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transition: background-color 0.2s, transform 0.2s;
    }
    
    .lightbox-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.05);
    }
    
    .page-rich-content img:not(.is-member-grid-card img):not(.member-card-embed img) {
        cursor: zoom-in;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }
    
    .page-rich-content img:not(.is-member-grid-card img):not(.member-card-embed img):hover {
        opacity: 0.95;
    }

    /* builder sections */
    .page-builder {
        display: grid;
        gap: 22px;
    }

    .page-builder-section {
        border: 1px solid var(--border);
        border-radius: 22px;
        background: linear-gradient(180deg, #fff 0%, #f8fbfd 100%);
        padding: 26px;
        box-shadow: 0 10px 26px rgba(13, 43, 62, 0.06);
    }

    .page-builder-section-title {
        font-family: 'Saira Extra Condensed', sans-serif;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--teal-dark);
        margin: 0 0 0.45rem;
        font-size: clamp(1.4rem, 2.2vw, 2rem);
    }

    .page-builder-section-subtitle {
        color: var(--ink-soft);
        margin-bottom: 1rem;
    }

    .page-builder-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 22px;
        align-items: start;
    }

    .page-builder-grid.is-reversed {
        grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
    }

    .page-builder-flow {
        display: block;
        margin-top: 10px;
    }

    .page-builder-flow-media {
        width: min(42%, 360px);
        margin-bottom: 12px;
    }

    .page-builder-flow.image-left .page-builder-flow-media {
        float: left;
        margin: 0.25rem 1.35rem 1rem 0;
    }

    .page-builder-flow.image-right .page-builder-flow-media {
        float: right;
        margin: 0.25rem 0 1rem 1.35rem;
    }

    .page-builder-content-flow {
        min-width: 0;
    }

    .page-builder-flow.image-left .page-builder-content-flow,
    .page-builder-flow.image-right .page-builder-content-flow {
        display: block;
    }

    .page-builder-flow .page-builder-media img {
        border-radius: 18px;
        width: 100%;
        display: block;
        box-shadow: 0 12px 28px rgba(13,43,62,0.12);
    }

    .page-builder-media img {
        width: 100%;
        display: block;
        border-radius: 18px;
        box-shadow: 0 12px 28px rgba(13,43,62,0.12);
    }

    .page-builder-media-center {
        max-width: 820px;
        margin: 0 auto 18px;
    }

    .page-builder-nav-wrap .page-builder-menu-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 18px;
    }

    .page-builder-menu-card {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 160px;
        padding: 0.9rem 1.2rem;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--teal), var(--teal-light));
        box-shadow: 0 10px 22px rgba(18, 88, 117, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        text-decoration: none;
        font-weight: 700;
        transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
    }

    .page-builder-menu-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 28px rgba(18, 88, 117, 0.18);
        color: #fff;
        opacity: 0.98;
    }

    .page-builder-menu-card:active {
        transform: translateY(0);
    }

    .page-builder-menu-card.is-inactive {
        opacity: 0.6;
        filter: grayscale(0.2);
    }

    /* code */
    .page-rich-content code {
        background: #eef4f8;
        color: var(--teal-dark);
        padding: 0.13rem 0.4rem;
        border-radius: 5px;
        font-size: 0.87em;
        font-family: 'Fira Mono', monospace;
        border: 1px solid rgba(18,88,117,0.09);
    }
    .page-rich-content pre {
        background: #0d1f2d;
        color: #cfe8f5;
        padding: 1.3rem 1.5rem;
        border-radius: 14px;
        overflow-x: auto;
        margin: 1.4rem 0;
        font-size: 0.9rem;
        line-height: 1.7;
    }
    .page-rich-content pre code {
        background: none;
        color: inherit;
        padding: 0;
        border: 0;
        font-size: 1em;
    }

    /* media */
    .page-rich-content iframe,
    .page-rich-content video,
    .page-rich-content embed {
        max-width: 100%;
        border: 0;
        border-radius: 14px;
        display: block;
        margin: 1.4rem 0;
        box-shadow: 0 8px 28px rgba(13,43,62,0.10);
    }

    /* builder layout */
    .page-builder {
        display: grid;
        gap: 22px;
    }

    .page-builder-section {
        border: 1px solid rgba(18, 88, 117, 0.10);
        border-radius: 22px;
        background: linear-gradient(180deg, #fff 0%, #f8fbfd 100%);
        padding: 26px;
        box-shadow: 0 10px 26px rgba(13,43,62,0.06);
    }

    .page-builder-section-title {
        font-family: 'Saira Extra Condensed', sans-serif;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--teal-dark);
        margin: 0 0 0.45rem;
        font-size: clamp(1.4rem, 2.2vw, 2rem);
    }

    .page-builder-section-subtitle {
        color: var(--ink-soft);
        margin-bottom: 1rem;
    }

    .page-builder-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) minmax(0, 0.9fr);
        gap: 22px;
        align-items: start;
    }

    .page-builder-grid.is-reversed {
        grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
    }

    .page-builder-layout {
        display: grid;
        gap: 22px;
        grid-template-columns: minmax(220px, 0.7fr) minmax(0, 1.3fr);
        align-items: start;
    }

    .page-builder-layout.nav-right {
        grid-template-columns: minmax(0, 1.3fr) minmax(220px, 0.7fr);
    }

    .page-builder-nav-column {
        min-width: 0;
    }

    .page-builder-main-column {
        min-width: 0;
    }

    .page-builder-layout.nav-left .page-builder-nav-column {
        order: 0;
    }

    .page-builder-layout.nav-left .page-builder-main-column {
        order: 1;
    }

    .page-builder-layout.nav-right .page-builder-main-column {
        order: 0;
    }

    .page-builder-layout.nav-right .page-builder-nav-column {
        order: 1;
    }

    @media (max-width: 991px) {
        .page-builder-layout,
        .page-builder-layout.nav-right {
            grid-template-columns: minmax(0, 1fr);
        }

        .page-builder-flow-media {
            float: none !important;
            width: 100%;
            margin: 0 0 16px;
        }

        .page-builder-flow.image-left .page-builder-content-flow,
        .page-builder-flow.image-right .page-builder-content-flow {
            overflow: visible;
        }

        .page-builder-layout.nav-left .page-builder-nav-column,
        .page-builder-layout.nav-left .page-builder-main-column,
        .page-builder-layout.nav-right .page-builder-main-column,
        .page-builder-layout.nav-right .page-builder-nav-column {
            order: initial;
        }
    }

    /* ===== Styles for the page-level sidebar outside the card ===== */
    .page-card-with-sidebar {
        display: grid;
        gap: 28px;
        align-items: start;
        grid-template-columns: minmax(220px, 0.28fr) minmax(0, 0.72fr);
    }

    .page-card-with-sidebar.nav-right {
        grid-template-columns: minmax(0, 0.72fr) minmax(220px, 0.28fr);
    }

    .page-card-with-sidebar .page-card {
        margin: 0; /* reset card spacing when inside grid */
    }

    /* When using a page-level sidebar, de-emphasize individual builder sections
       so they don't appear as separate cards inside the main card. */
    .page-card-with-sidebar .page-builder-section {
        background: transparent;
        border: 0;
        box-shadow: none;
        padding: 0;
        margin: 0 0 18px 0;
    }

    .page-card-with-sidebar .page-builder-section-title {
        margin-top: 0.6rem;
        margin-bottom: 0.45rem;
    }

    .page-builder-page-sidebar .page-builder-menu-grid {
        display: grid;
        gap: 12px;
    }

    @media (max-width: 991px) {
        .page-card-with-sidebar {
            grid-template-columns: 1fr;
        }

        .page-builder-page-sidebar {
            order: -1;
        }
    }

    .page-builder-media img {
        width: 100%;
        display: block;
        border-radius: 18px;
        box-shadow: 0 12px 28px rgba(13,43,62,0.12);
    }

    .page-builder-menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 14px;
        margin-top: 18px;
    }

    .page-builder-menu-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 140px;
        padding: 18px;
        border-radius: 18px;
        background: #fff;
        border: 1px solid rgba(18, 88, 117, 0.10);
        text-decoration: none;
        color: inherit;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .page-builder-menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 30px rgba(13,43,62,0.10);
    }

    .page-builder-menu-card small {
        color: var(--ink-soft);
        margin-top: 0.45rem;
    }

    /* ===== Custom page-builder navigation/sidebar styles ===== */
    .page-builder-nav-column {
        padding: 6px 0;
    }

    .page-builder-nav-wrap {
        display: block;
    }

    /* Make the nav column sticky on larger screens so it follows the reader */
    .page-builder-nav-column {
        position: sticky;
        top: 120px;
        align-self: start;
    }

    /* Button-like nav items */
    .page-builder-menu-card {
        position: relative;
        display: flex;
        gap: 10px;
        align-items: center;
        justify-content: space-between;
        padding: 16px 18px;
        border-radius: 16px;
        background: linear-gradient(180deg, #ffffff 0%, #f8fcfd 100%);
        border: 1px solid rgba(18, 88, 117, 0.10);
        color: var(--ink-mid);
        box-shadow: 0 10px 22px rgba(13, 43, 62, 0.06);
        transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease, border-color 0.18s ease;
        text-decoration: none;
        min-height: 68px;
        overflow: hidden;
    }

    .page-builder-menu-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: linear-gradient(180deg, var(--teal-light), var(--gold));
        opacity: 0.92;
    }

    .page-builder-menu-card .title {
        font-weight: 800;
        font-size: 0.98rem;
        color: var(--teal-dark);
        display: block;
        line-height: 1.18;
        letter-spacing: 0.01em;
    }

    .page-builder-menu-card .meta {
        display: block;
        font-size: 0.84rem;
        color: var(--ink-soft);
        margin-top: 6px;
    }

    .page-builder-menu-card:hover {
        transform: translateY(-5px);
        border-color: rgba(18, 88, 117, 0.18);
        background: linear-gradient(180deg, #ffffff 0%, #f3fbfd 100%);
        box-shadow: 0 20px 40px rgba(18, 88, 117, 0.18);
    }

    .page-builder-menu-card:hover::before {
        background: linear-gradient(180deg, var(--gold), var(--teal-light));
    }

    .page-builder-menu-card.is-inactive {
        opacity: 0.62;
        filter: grayscale(0.18);
        pointer-events: none;
        cursor: default;
    }

    .page-builder-menu-card.active {
        position: relative;
        overflow: hidden;
        border-color: rgba(18, 88, 117, 0.34);
        background: linear-gradient(135deg, #125875 0%, #1b8aad 100%);
        box-shadow: 0 18px 36px rgba(18, 88, 117, 0.22);
        color: #fff;
        transform: translateY(-1px);
    }

    .page-builder-menu-card.active::before {
        content: '';
        position: absolute;
        inset: 0 auto 0 0;
        width: 6px;
        background: rgba(255, 255, 255, 0.35);
    }

    .page-builder-menu-card.active .title,
    .page-builder-menu-card.active span {
        color: #fff;
    }

    .page-builder-menu-card:active {
        transform: translateY(-1px) scale(0.995);
    }

    /* Make the menu a vertical stack on desktop */
    .page-builder-menu-grid {
        display: grid;
        grid-auto-rows: min-content;
        gap: 12px;
    }

    /* Narrower sidebar visuals */
    .page-builder-layout .page-builder-nav-column {
        padding-left: 6px;
        padding-right: 6px;
        max-width: 360px;
    }

    /* Content column should take available space and not overflow */
    .page-builder-main-column {
        min-width: 0;
    }

    /* Responsive: on small screens keep the sidebar as a stacked vertical block above content */
    @media (max-width: 991px) {
        .page-builder-layout {
            grid-template-columns: 1fr !important;
        }

        .page-builder-nav-column {
            position: relative;
            top: auto;
            width: 100%;
            margin-bottom: 12px;
        }

        .page-builder-menu-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            overflow: visible;
            padding-bottom: 0;
        }

        .page-builder-menu-card {
            min-width: 0;
            width: 100%;
            flex: 1 1 auto;
        }
    }

    /* Global responsive tuning */
    @media (max-width: 1199px) {
        .page-card-body {
            padding: 36px 34px 40px;
        }

        .page-card-with-sidebar,
        .page-card-with-sidebar.nav-right {
            grid-template-columns: minmax(240px, 0.33fr) minmax(0, 0.67fr);
            gap: 22px;
        }
    }

    @media (max-width: 991px) {
        .page-shell {
            padding: 26px 0 46px;
        }

        .page-content-wrap {
            margin-top: 0;
            opacity: 1;
            animation: none;
        }

        .page-card-with-sidebar,
        .page-card-with-sidebar.nav-right {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .page-card-with-sidebar > .page-builder-page-sidebar {
            order: -1;
            position: relative;
            top: auto;
            width: 100%;
            margin-bottom: 2px;
        }

        .page-card-with-sidebar > .page-card {
            order: 1;
        }

        .page-builder-layout,
        .page-builder-layout.nav-right {
            grid-template-columns: 1fr !important;
            gap: 14px;
        }

        .page-builder-layout .page-builder-nav-column {
            order: -1 !important;
            position: relative;
            top: auto;
            max-width: 100%;
            width: 100%;
            margin: 0 0 14px;
            padding: 0;
        }

        .page-builder-nav-wrap .page-builder-menu-grid,
        .page-builder-menu-grid {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 10px;
            margin-top: 0;
        }

        .page-builder-menu-card {
            min-height: 60px;
            width: 100%;
        }

        .page-builder-flow-media {
            float: none !important;
            width: 100%;
            max-width: 100%;
            margin: 0 0 14px;
        }

        .page-builder-flow.image-right,
        .page-builder-flow.image-left {
            padding-left: 2px;
            padding-right: 2px;
        }

        .page-builder-flow.image-right .page-builder-flow-media,
        .page-builder-flow.image-left .page-builder-flow-media {
            float: none !important;
            width: 100%;
            max-width: 100%;
            margin: 0 0 14px !important;
        }

        .page-builder-flow .page-builder-media img {
            width: 100%;
            max-width: 100%;
        }

        .page-rich-content table:not(.is-member-grid):not(.member-card-embed):not(.is-member-grid-card) {
            display: table;
            width: 100%;
        }
        .page-rich-content thead th {
            white-space: nowrap;
        }
    }

    @media (max-width: 575px) {
        .page-card-body {
            padding: 22px 16px 28px;
        }

        .page-builder-section {
            padding: 18px;
            border-radius: 16px;
        }

        .page-rich-content {
            font-size: 0.95rem;
            line-height: 1.72;
        }

        .page-rich-content blockquote {
            padding: 0.9rem 1rem;
        }

        .page-builder-menu-card {
            padding: 13px 14px;
        }

        .page-builder-flow.image-right,
        .page-builder-flow.image-left {
            padding-left: 4px;
            padding-right: 4px;
        }
    }

    /* Small polish: ensure long titles wrap nicely */
    .page-builder-menu-card span {
        word-break: break-word;
    }

    /* Accessibility: focus styles */
    .page-builder-menu-card:focus-visible {
        outline: 3px solid rgba(18, 136, 165, 0.18);
        outline-offset: 3px;
    }


    /* animations */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0);    }
    }
    /* Final overrides for member cards to ensure consistent look */
    .page-rich-content .is-member-grid-card,
    .page-rich-content .member-card-embed {
        background: var(--member-card-bg, #f5fbff) !important;
        border-radius: 12px !important;
        box-shadow: 0 8px 20px rgba(60,64,67,0.10) !important;
        border: 1px solid rgba(60,64,67,0.06) !important;
        overflow: hidden !important;
    }
    .page-rich-content .is-member-grid-card img,
    .page-rich-content .member-card-embed img {
        height: 200px !important;
        width: 100% !important;
        object-fit: cover !important;
    }
    .page-rich-content .is-member-grid-card tr:nth-child(2) td,
    .page-rich-content .member-card-embed tr:nth-child(2) td {
        padding: 14px 18px 6px !important;
    }
    .page-rich-content .is-member-grid-card tr:nth-child(3) td,
    .page-rich-content .member-card-embed tr:nth-child(3) td {
        padding: 6px 18px 16px !important;
        color: var(--ink-soft) !important;
        line-height: 1.35 !important;
    }
    /* Final override: remove global table/td chrome for member tables */
    .page-rich-content table.is-member-grid,
    .page-rich-content table.member-card-embed,
    .page-rich-content table.is-member-grid-card {
        border: 0 !important;
        box-shadow: none !important;
        background: transparent !important;
    }
    .page-rich-content .is-member-grid > tbody > tr > td,
    .page-rich-content .is-member-grid td,
    .page-rich-content .is-member-grid-card td,
    .page-rich-content .member-card-embed td {
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
        padding: 0 !important;
    }

    @media (max-width: 767px) {
        .page-rich-content .is-member-grid > tbody > tr {
            width: 100% !important;
            grid-template-columns: minmax(0, 1fr) !important;
            gap: 18px !important;
        }

        .page-rich-content .is-member-grid > tbody > tr > td {
            width: 100% !important;
        }

        .page-rich-content .is-member-grid-card,
        .page-rich-content .member-card-embed {
            width: 100% !important;
            max-width: none !important;
        }
    }

    /* File attachment links */
    .page-rich-content a.editor-file-link {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 14px 22px;
        background: #f4f8fa;
        border: 1.5px solid rgba(18, 88, 117, 0.12);
        border-radius: 14px;
        color: var(--teal-dark) !important;
        text-decoration: none !important;
        font-weight: 700;
        margin: 12px 0;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 6px 18px rgba(13, 43, 62, 0.04);
        max-width: 100%;
    }

    .page-rich-content a.editor-file-link:hover {
        background: #eef6fa;
        border-color: var(--teal);
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(13, 43, 62, 0.08);
    }

    .page-rich-content a.editor-file-link::before {
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        font-size: 1.35rem;
        display: inline-block;
        margin-right: 2px;
    }

    .page-rich-content a.editor-file-link::before {
        content: "\f15b"; /* default file */
        color: var(--teal-light);
    }
    .page-rich-content a.editor-file-link.ext-pdf::before {
        content: "\f1c1"; /* pdf */
        color: #e74c3c;
    }
    .page-rich-content a.editor-file-link.ext-doc::before,
    .page-rich-content a.editor-file-link.ext-docx::before {
        content: "\f1c2"; /* word */
        color: #2b579a;
    }
    .page-rich-content a.editor-file-link.ext-xls::before,
    .page-rich-content a.editor-file-link.ext-xlsx::before {
        content: "\f1c3"; /* excel */
        color: #217346;
    }
    .page-rich-content a.editor-file-link.ext-ppt::before,
    .page-rich-content a.editor-file-link.ext-pptx::before {
        content: "\f1c4"; /* powerpoint */
        color: #d24726;
    }
    .page-rich-content a.editor-file-link.ext-zip::before,
    .page-rich-content a.editor-file-link.ext-rar::before {
        content: "\f1c6"; /* zip */
        color: #f39c12;
    }
    .page-rich-content a.editor-file-link.ext-jpg::before,
    .page-rich-content a.editor-file-link.ext-jpeg::before,
    .page-rich-content a.editor-file-link.ext-png::before,
    .page-rich-content a.editor-file-link.ext-gif::before,
    .page-rich-content a.editor-file-link.ext-webp::before {
        content: "\f1c5"; /* image */
        color: #3498db;
    }

    /* PDF Embed Frame Styles */
    .page-rich-content .pdf-frame-container {
        position: relative;
        background: #fff;
        transition: all 0.3s ease;
    }
    
    .page-rich-content .pdf-frame-container.align-left {
        width: 48%;
        float: left;
        margin-right: 24px;
        margin-bottom: 24px;
    }
    
    .page-rich-content .pdf-frame-container.align-right {
        width: 48%;
        float: right;
        margin-left: 24px;
        margin-bottom: 24px;
    }

    .page-rich-content .pdf-frame-container.align-center {
        width: 100%;
        clear: both;
    }

    .page-rich-content a.pdf-simple-link {
        color: var(--teal);
        text-decoration: underline;
        font-weight: 600;
        transition: color 0.15s ease;
    }

    .page-rich-content a.pdf-simple-link:hover {
        color: var(--teal-dark);
    }
    
    @media (max-width: 767px) {
        .page-rich-content .pdf-frame-container.align-left,
        .page-rich-content .pdf-frame-container.align-right {
            width: 100% !important;
            float: none !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            margin-bottom: 20px !important;
        }
    }
</style>





<section class="page-shell">
    <div class="container">
        <div class="page-content-wrap">
            <?php if(($page->layout_mode ?? 'editor') === 'builder' && !empty($builderSections)): ?>
                <?php
                    // Prefer page-stored nav items when available; otherwise aggregate from sections (backwards compatibility)
                    $pageNavItems = collect($page->page_nav_items ?? []);
                    if ($pageNavItems->isEmpty()) {
                        $pageNavItems = collect($builderSections)
                            ->flatMap(function ($s) {
                                $items = collect($s['nav_items'] ?? [])->filter()->values();
                                return $items->map(function ($it) use ($s) {
                                    return [
                                        'title' => is_array($it) ? ($it['title'] ?? '') : '',
                                        'page_id' => is_array($it) ? (int) ($it['page_id'] ?? 0) : (int) $it,
                                        'active' => is_array($it) ? (string) ($it['active'] ?? '1') === '1' : true,
                                        'section' => $s['title'] ?? '',
                                    ];
                                });
                            })->filter()->values();
                    }

                    // Determine page-level nav position: prefer explicit page setting if present, else use first section preference
                    $pageNavPosition = $page->page_nav_position ?? (collect($builderSections)->pluck('nav_position')->filter()->first() ?? 'right');
                ?>

                <?php if($pageNavItems->isNotEmpty()): ?>
                    <div class="page-card-with-sidebar <?php echo e($pageNavPosition === 'left' ? 'nav-left' : 'nav-right'); ?>">
                        <?php if($pageNavPosition === 'left'): ?>
                            <aside class="page-builder-nav-column page-builder-page-sidebar">
                                <div class="page-builder-nav-wrap">
                                    <div class="page-builder-menu-grid">
                                        <?php $__currentLoopData = $pageNavItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $linkedPage = $pagesById->get($navItem['page_id']);
                                                $navHref = $linkedPage ? route('page.single', $linkedPage->slug) : null;
                                                $currentPageSlug = request()->route('slug');
                                                $isActivePage = $linkedPage && $currentPageSlug === $linkedPage->slug;
                                            ?>
                                            <?php if($linkedPage || !empty($navItem['title'])): ?>
                                                <?php if($linkedPage): ?>
                                                    <a class="page-builder-menu-card <?php if(!$navItem['active']): ?> is-inactive <?php endif; ?> <?php if($isActivePage): ?> active <?php endif; ?>" href="<?php echo e($navHref); ?>" <?php if($isActivePage): ?> aria-current="page" <?php endif; ?>>
                                                        <span class="title"><?php echo e($navItem['title'] ?: ($linkedPage->display_text ?? $linkedPage->title)); ?></span>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="page-builder-menu-card is-inactive" aria-disabled="true">
                                                        <span class="title"><?php echo e($navItem['title']); ?></span>
                                                    </span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </aside>
                        <?php endif; ?>

                        <div class="page-card"> 
                            <div class="page-card-bar"></div>
                            <div class="page-card-body">
                                <?php echo $__env->make('web.page-builder', ['builderSections' => $builderSections, 'pagesById' => $pagesById, 'renderSectionNavInside' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>

                        <?php if($pageNavPosition === 'right'): ?>
                            <aside class="page-builder-nav-column page-builder-page-sidebar">
                                <div class="page-builder-nav-wrap">
                                    <div class="page-builder-menu-grid">
                                        <?php $__currentLoopData = $pageNavItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $linkedPage = $pagesById->get($navItem['page_id']);
                                                $navHref = $linkedPage ? route('page.single', $linkedPage->slug) : null;
                                                $currentPageSlug = request()->route('slug');
                                                $isActivePage = $linkedPage && $currentPageSlug === $linkedPage->slug;
                                            ?>
                                            <?php if($linkedPage || !empty($navItem['title'])): ?>
                                                <?php if($linkedPage): ?>
                                                    <a class="page-builder-menu-card <?php if(!$navItem['active']): ?> is-inactive <?php endif; ?> <?php if($isActivePage): ?> active <?php endif; ?>" href="<?php echo e($navHref); ?>" <?php if($isActivePage): ?> aria-current="page" <?php endif; ?>>
                                                        <span class="title"><?php echo e($navItem['title'] ?: ($linkedPage->display_text ?? $linkedPage->title)); ?></span>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="page-builder-menu-card is-inactive" aria-disabled="true">
                                                        <span class="title"><?php echo e($navItem['title']); ?></span>
                                                    </span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </aside>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="page-card">
                        <div class="page-card-bar"></div>
                        <div class="page-card-body">
                            <?php echo $__env->make('web.page-builder', ['builderSections' => $builderSections, 'pagesById' => $pagesById], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="page-card">
                    <div class="page-card-bar"></div>
                    <div class="page-card-body">
                        <div class="page-rich-content">
                            <?php
                                $content = $page->content_html ?? $page->description;
                                if (!empty($content)) {
                                    $content = preg_replace_callback(
                                        '/((?:src|href)\s*=\s*)(["\']?)(.*?)uploads\/([^"\'>\s]+)(["\']?)/i',
                                        function ($m) {
                                            return $m[1] . '"' . asset('uploads/' . $m[4]) . '"';
                                        },
                                        $content
                                    );

                                    // Normalize legacy member-grid classes to the new isolated identifiers
                                    $content = str_replace(
                                        [
                                            'class="member-grid-wrap"',
                                            'class="member-grid"',
                                            'class="member-grid-card"',
                                            'class="member-grid-link"'
                                        ],
                                        [
                                            'class="is-member-grid-wrap"',
                                            'class="is-member-grid"',
                                            'class="is-member-grid-card"',
                                            'class="is-member-grid-link"'
                                        ],
                                        $content
                                    );
                                }
                            ?>
                            <?php echo $content; ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    (function() {
        // 1. Table responsiveness wrapping
        function wrapTables() {
            document.querySelectorAll('.page-rich-content table:not(.is-member-grid):not(.member-card-embed):not(.is-member-grid-card)').forEach(function(table) {
                if (table.parentNode.classList.contains('table-responsive-wrap')) {
                    return;
                }
                var wrapper = document.createElement('div');
                wrapper.className = 'table-responsive-wrap';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            });
        }

        // 2. Lightbox functionality for content images
        function initLightbox() {
            var modal = document.createElement('div');
            modal.className = 'lightbox-modal';
            modal.innerHTML = '<span class="lightbox-close">&times;</span><img class="lightbox-content" src="" alt="Enlarged Image">';
            document.body.appendChild(modal);

            var modalImg = modal.querySelector('.lightbox-content');
            var closeBtn = modal.querySelector('.lightbox-close');

            document.addEventListener('click', function(e) {
                var target = e.target;
                if (target.tagName === 'IMG' && target.closest('.page-rich-content') && !target.closest('.is-member-grid-card') && !target.closest('.member-card-embed')) {
                    var parentLink = target.closest('a');
                    if (parentLink) {
                        var href = parentLink.getAttribute('href') || '';
                        var isImageUrl = /\.(jpeg|jpg|gif|png|webp|svg)/i.test(href);
                        if (!isImageUrl) {
                            return;
                        }
                        e.preventDefault();
                    }
                    
                    modalImg.src = target.src;
                    modal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            });

            function closeModal() {
                modal.classList.remove('show');
                document.body.style.overflow = '';
                setTimeout(function() {
                    modalImg.src = '';
                }, 300);
            }

            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', function(e) {
                if (e.target === modal || e.target === closeBtn) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('show')) {
                    closeModal();
                }
            });
        }

        function initAll() {
            wrapTables();
            initLightbox();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAll);
        } else {
            initAll();
        }
    })();
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.custom.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\office_project\cust\resources\views/web/page.blade.php ENDPATH**/ ?>