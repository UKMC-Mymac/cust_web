<header class="th-header header-layout1">
    <div class="header-top">
        <div class="container-fluid th-container4">
            <div class="row justify-content-start justify-content-md-between align-items-top gy-2">
                <div class="col-auto mt-0 mt-sm-2">
                    <div class="header-logo p-0 ms-0">
                        <a href="{{ route('home') }}">
                            <img class="d-block" src="{{ asset('dist/images/logo-white.png') }}" alt="CUST logo">
                        </a>
                    </div>
                </div>
                <div class="col-auto d-none d-md-block">
                    <div class="header-links">
                        <ul class="header-right-wrap">
                            @if(auth()->guard('web')->check())
                                <li>
                                    <i class="fa-solid fa-user"></i><a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                                </li>
                            @else
                                <li>
                                    <i class="fa-solid fa-user"></i><a href="{{ isset($custom_urls['student_login']) ? $custom_urls['student_login']->resolved_url : '#' }}">Student Login</a>
                                </li>
                                <li>
                                    <i class="fa-solid fa-user-tie"></i><a href="{{ isset($custom_urls['staff_login']) ? $custom_urls['staff_login']->resolved_url : '#' }}">Staff Login</a>
                                </li>
                            @endif
                           @isset($topbarSetting->email)
                            <li>
                                <a href="mailto:{{ $topbarSetting->email ?? '' }}">
                                    <i class="fa-sharp fa-solid fa-envelope pe-1"></i>
                                    {{ $topbarSetting->email ?? '' }}
                                </a>
                            </li>
                            @endisset

                              @isset($topbarSetting->phone)
                          <li>
                            <a href="tel:{{ $topbarSetting->phone ?? '' }}">
                                <i class="fa-sharp fa-solid fa-phone pe-1"></i>
                                {{ $topbarSetting->phone ?? '' }}
                            </a>
                        </li>
                            @endisset
                            {{-- <li>
                                <a href="javascript:void(0)" class="header-search searchBoxToggler">
                                    <i class="fa-regular fa-magnifying-glass"></i>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-menu-wrap d-inline-block d-lg-none">
        <button type="button" class="th-menu-toggle d-inline-block me-0">
            <i class="far fa-bars"></i>
        </button>
    </div>

    <!-- Main Menu -->
    @include('web.custom.components.navigation')

    <!-- Mobile Menu -->
    @include('web.custom.components.mobile-navigation')
</header>
