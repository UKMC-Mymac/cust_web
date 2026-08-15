<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('web.custom.components.head-meta')
</head>
<body>
    @include('web.custom.components.preloader')
    
    @include('web.custom.components.header')
    
    @include('web.custom.components.mobile-navigation')
    
    @include('web.custom.components.search-box')
    
    @include('web.custom.components.login-modal')
    
    <main>
        @if($showBreadcrumb ?? false)
            @include('web.custom.components.breadcrumb', [
                'title' => $breadcrumbTitle ?? 'Page',
                'breadcrumbs' => $breadcrumbs ?? [],
                'breadcrumbThemeClass' => $breadcrumbThemeClass ?? 'non-hero2'
            ])
        @endif
        
        @yield('content')
    </main>
    
    @include('web.custom.components.footer')
    
    @include('web.custom.components.scroll-top')
    
    @include('web.custom.components.chat')
    
    @include('web.custom.components.scripts')
    @if(session('show_login'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            try {
                if (typeof jQuery !== 'undefined' && typeof $.magnificPopup !== 'undefined') {
                    $.magnificPopup.open({ items: { src: '#login-form' }, type: 'inline' });
                } else {
                    var el = document.getElementById('login-form');
                    if (el) {
                        el.style.display = 'block';
                    }
                }
            } catch (e) {
                // ignore
            }
        });
    </script>
    @endif
</body>
</html>
