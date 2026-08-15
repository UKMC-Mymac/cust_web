@php
    $builderSections = $builderSections ?? [];
    $pagesById = $pagesById ?? collect();
    $renderSectionNavInside = $renderSectionNavInside ?? true;
@endphp

<div class="page-builder">
    @foreach($builderSections as $section)
        @php
            $title = $section['title'] ?? '';
            $subtitle = $section['subtitle'] ?? '';
            $content = $section['content'] ?? '';
            if (!empty($content)) {
                $content = preg_replace_callback(
                    '/((?:src|href)\s*=\s*)(["\']?)(.*?)uploads\/([^"\'>\s]+)(["\']?)/i',
                    function ($m) {
                        return $m[1] . '"' . asset('uploads/' . $m[4]) . '"';
                    },
                    $content
                );
            }
            $image = $section['image'] ?? null;
            $navItems = collect($section['nav_items'] ?? $section['page_ids'] ?? [])->filter()->values();
            $imagePosition = $section['image_position'] ?? 'right';
            $navPosition = $section['nav_position'] ?? 'right';
            $imageAlt = $section['image_alt'] ?? $title;
            $imageUrl = $image ? asset('uploads/page-builder/'.$image) : null;
            $hasImage = !empty($imageUrl);
            $isLeft = $imagePosition === 'left';
            $isCenter = $imagePosition === 'center';
            $flowClass = $isLeft ? 'image-left' : 'image-right';
            $hasNav = $navItems->isNotEmpty();
            $navOnLeft = $navPosition === 'left';
        @endphp

        <section class="page-builder-section">
            @if($title)
                <h2 class="page-builder-section-title">{{ $title }}</h2>
            @endif
            @if($subtitle)
                <div class="page-builder-section-subtitle">{{ $subtitle }}</div>
            @endif

            @if($isCenter && $imageUrl)
                <div class="page-builder-media page-builder-media-center">
                    <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}">
                </div>
            @endif

            @if($hasNav && $renderSectionNavInside)
                <div class="page-builder-layout {{ $navOnLeft ? 'nav-left' : 'nav-right' }}">
                    @if($navOnLeft)
                        <aside class="page-builder-nav-column">
                            <div class="page-builder-nav-wrap">
                                <div class="page-builder-menu-grid">
                                    @foreach($navItems as $navItem)
                                        @php
                                            $navTitle = is_array($navItem) ? ($navItem['title'] ?? '') : '';
                                            $navActive = is_array($navItem) ? (string) ($navItem['active'] ?? '1') === '1' : true;
                                            $navPageId = is_array($navItem) ? (int) ($navItem['page_id'] ?? 0) : (int) $navItem;
                                            $linkedPage = $pagesById->get($navPageId);
                                            $navHref = $linkedPage ? route('page.single', $linkedPage->slug) : null;
                                            $currentPageSlug = request()->route('slug');
                                            $isActivePage = $linkedPage && $currentPageSlug === $linkedPage->slug;
                                        @endphp
                                        @if($linkedPage || $navTitle)
                                            @if($linkedPage)
                                                <a class="page-builder-menu-card page-builder-menu-button @if(!$navActive) is-inactive @endif @if($isActivePage) active @endif" href="{{ $navHref }}">
                                                    <span>{{ $navTitle ?: ($linkedPage->display_text ?? $linkedPage->title) }}</span>
                                                </a>
                                            @else
                                                <span class="page-builder-menu-card page-builder-menu-button is-inactive" aria-disabled="true">
                                                    <span>{{ $navTitle }}</span>
                                                </span>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </aside>
                    @endif

                    <div class="page-builder-main-column">
                        @if($isCenter && $hasImage)
                            <div class="page-builder-media page-builder-media-center">
                                <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}">
                            </div>
                        @endif

                        @if($hasImage)
                            <div class="page-builder-flow {{ $flowClass }}">
                                @if(!$isCenter)
                                    <div class="page-builder-media page-builder-flow-media">
                                        <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}">
                                    </div>
                                @endif

                                @if($content)
                                    <div class="page-rich-content page-builder-content-flow">{!! $content !!}</div>
                                @endif
                            </div>
                        @else
                            @if($content)
                                <div class="page-rich-content page-builder-content-only">{!! $content !!}</div>
                            @endif
                        @endif
                    </div>

                    @if(!$navOnLeft)
                        <aside class="page-builder-nav-column">
                            <div class="page-builder-nav-wrap">
                                <div class="page-builder-menu-grid">
                                    @foreach($navItems as $navItem)
                                        @php
                                            $navTitle = is_array($navItem) ? ($navItem['title'] ?? '') : '';
                                            $navActive = is_array($navItem) ? (string) ($navItem['active'] ?? '1') === '1' : true;
                                            $navPageId = is_array($navItem) ? (int) ($navItem['page_id'] ?? 0) : (int) $navItem;
                                            $linkedPage = $pagesById->get($navPageId);
                                            $navHref = $linkedPage ? route('page.single', $linkedPage->slug) : null;
                                            $currentPageSlug = request()->route('slug');
                                            $isActivePage = $linkedPage && $currentPageSlug === $linkedPage->slug;
                                        @endphp
                                        @if($linkedPage || $navTitle)
                                            @if($linkedPage)
                                                <a class="page-builder-menu-card page-builder-menu-button @if(!$navActive) is-inactive @endif @if($isActivePage) active @endif" href="{{ $navHref }}">
                                                    <span>{{ $navTitle ?: ($linkedPage->display_text ?? $linkedPage->title) }}</span>
                                                </a>
                                            @else
                                                <span class="page-builder-menu-card page-builder-menu-button is-inactive" aria-disabled="true">
                                                    <span>{{ $navTitle }}</span>
                                                </span>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </aside>
                    @endif
                </div>
            @else
                @if($hasImage)
                    @if($isCenter)
                        <div class="page-builder-media page-builder-media-center">
                            <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}">
                        </div>
                    @endif

                    <div class="page-builder-flow {{ $flowClass }}">
                        @if(!$isCenter)
                            <div class="page-builder-media page-builder-flow-media">
                                <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}">
                            </div>
                        @endif

                        @if($content)
                            <div class="page-rich-content page-builder-content-flow">{!! $content !!}</div>
                        @endif
                    </div>
                @else
                    @if($content)
                        <div class="page-rich-content page-builder-content-only">{!! $content !!}</div>
                    @endif
                @endif
            @endif
        </section>
    @endforeach
</div>