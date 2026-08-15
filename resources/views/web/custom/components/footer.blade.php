<footer class="footer-wrapper footer-default footer-overlay" data-bg-src="{{ asset('dist/img/bg/footer-bg-1.jpg') }}">
    <div class="container">
        <div class="widget-area">
            <div class="row justify-content-between">
                <div class="col-md-6 col-xl-auto">
                    <div class="widget footer-widget">
                        <div class="th-widget-about">
                            @isset($contentSections['footer_section'])
                            <h3 class="widget_title">{{$contentSections['footer_section']->title}}</h3>
                            <p class="about-text">
                                {!! $contentSections['footer_section']->description !!}
                            </p>
                            @endisset
                            <div class="footer-info">
                             @isset($topbarSetting->address)
                                <a href="https://maps.app.goo.gl/Wd2UDYjrZ646zAvr9">
                                    <span class="footer-info-icon"><i class="fa-solid fa-location-dot"></i></span>{{ $topbarSetting->address }}
                                </a>
                            @endisset
                                @isset($topbarSetting->email)
                                <a href=mailto:"{{ $topbarSetting->email }}">
                                    <span class="footer-info-icon"><i class="fa-solid fa-envelope"></i></span>{{ $topbarSetting->email }}
                                </a>
                                @endisset

                                @isset($topbarSetting->phone)
                                <a href="tel:{{ $topbarSetting->phone }}">
                                    <span class="footer-info-icon"><i class="fa-solid fa-phone"></i></span>{{ $topbarSetting->phone }}
                                </a>
                                @endisset
                            </div>
                        
                            <div class="th-social mt-4">
                                 @if(isset($socialSetting->facebook))
                                <a href="{{ $socialSetting->facebook }}">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                @endif
                                    @if(isset($socialSetting->youtube)) 
                                <a href="{{ $socialSetting->youtube }}">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                                    @endif
                                        @if(isset($socialSetting->instagram))
                                <a href="{{ $socialSetting->instagram }}">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                @endif
                                    @if(isset($socialSetting->twitter))
                                <a href="{{ $socialSetting->twitter }} ">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                @endif
                                    @if(isset($socialSetting->linkedin))
                                <a href="{{ $socialSetting->linkedin }}">
                                    <i class="fa-brands fa-linkedin"></i>
                                </a>
                                @endif
                                    @if(isset($socialSetting->pinterest))
                                <a href="{{ $socialSetting->pinterest }}">
                                    <i class="fa-brands fa-wikipedia-w"></i>
                                </a>
                                @endif 
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($footerSections as $section)
                <div class="col-sm-6 col-xl-auto">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">{{ $section->title }}</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">
                                @foreach ($section->links as $link)
                                @php
                                    $linkHref = $link->url;

                                    if (empty($linkHref) && !empty($link->page) && !empty($link->page->slug)) {
                                        $linkHref = route('page.single', $link->page->slug);
                                    } elseif (empty($linkHref) && !empty($link->route_name)) {
                                        try {
                                            $linkHref = route($link->route_name);
                                        } catch (Exception $e) {
                                            $linkHref = '#';
                                        }
                                    }

                                    $linkHref = $linkHref ?: '#';
                                @endphp
                                <li><a href="{{ $linkHref }}">{{ $link->label }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="copyright-wrap z-index-common">
        <div class="container">
            <div class="row justify-content-center gy-3 align-items-center">
                <div class="col-lg-6">
                    <p class="copyright-text">
                        <i class="fal fa-copyright"></i> Copyright {{ date('Y') }} <a href="{{ isset($custom_urls['copyright_link']) ? $custom_urls['copyright_link']->resolved_url : '#' }}">CUST</a>. All Rights
                        Reserved.
                    </p>
                </div>
                <div class="col-lg-6 text-lg-end text-center">
                    <div class="footer-links">
                        <ul>
                            <li><a href="{{ isset($custom_urls['privacy_policy']) ? $custom_urls['privacy_policy']->resolved_url : '#' }}">{{ isset($custom_urls['privacy_policy']) ? $custom_urls['privacy_policy']->title : 'Privacy Policy' }}</a></li>
                            <li><a href="{{ isset($custom_urls['terms_of_service']) ? $custom_urls['terms_of_service']->resolved_url : '#' }}">{{ isset($custom_urls['terms_of_service']) ? $custom_urls['terms_of_service']->title : 'Terms of services' }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
