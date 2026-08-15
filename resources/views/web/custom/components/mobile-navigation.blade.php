<div class="th-menu-wrapper">
    <div class="th-menu-area text-center">
        <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
        <div class="mobile-logo">
            <a href="{{ route('home') }}"><img src="{{ asset('dist/images/logo.png') }}" alt="CUST"></a>
        </div>
        <div class="th-mobile-menu">
            <ul>
                @if ($navbarItems->isNotEmpty())
                    @include('web.custom.components.partials.nav-items', ['items' => $navbarItems])
                @else
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                @endif
                @if(auth()->guard('web')->check())
                    <li class="d-block d-md-none">
                        <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                    </li>
                @elseif(auth()->guard('student')->check())
                    <li class="d-block d-md-none">
                        <a href="{{ route('student.dashboard.index') }}">Student Dashboard</a>
                    </li>
                @else
                    <li class="d-block d-md-none">
                       <a href="#">Student Login</a>
                    </li>
                    <li class="d-block d-md-none">
                       <a href="#">Staff Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
