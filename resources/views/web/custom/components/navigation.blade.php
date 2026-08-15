<div class="sticky-wrapper">
    <!-- Main Menu Area -->
    <div class="menu-area">
        <div class="container-fluid th-container4 th-container2">
            <div class="menu-wrapp">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="header-left d-flex align-items-center">
                            <div class="header-logo d-none">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('dist/images/logo-white.png') }}" alt="CUST Logo" />
                                </a>
                            </div>
                            <nav class="main-menu d-none d-lg-block">
                                <ul>
                                    @if ($navbarItems->isNotEmpty())
                                        @include('web.custom.components.partials.nav-items', ['items' => $navbarItems])
                                    @else
                                        <li>
                                            <a href="{{ route('home') }}">Home</a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                            <div class="sticky-menu-wrap d-inline-blockx d-lg-none">
                                <button type="button" class="th-menu-toggle d-inline-block">
                                    <i class="far fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
