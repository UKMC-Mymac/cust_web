<div id="club" class="counter-area1 overflow-hidden">
    <div class="container th-container2">
        <div class="counter-wrap1">
            @if(isset($clubs) && $clubs->count() > 0)
                @foreach($clubs as $index => $club)
                @php
                    $linkHref = $club->link;
                    if (empty($linkHref) && !empty($club->page)) {
                        $linkHref = url('page/' . ($club->page->slug ?? $club->page->id));
                    } elseif (empty($linkHref) && !empty($club->route_name)) {
                        try {
                            $linkHref = route($club->route_name);
                        } catch (\Exception $e) {
                            $linkHref = '#';
                        }
                    }
                @endphp
                <a href="{{ $linkHref ?? '#' }}" class="counter-card wow fadeInUp" data-wow-delay="{{ 0.2 * ($index + 1) }}s" style="text-decoration: none;">
                    <div class="box-icon">
                        <i class="{{ $club->icon ?? 'fa-solid fa-users' }}"></i>
                    </div>
                    <div class="media-body">
                        <p class="box-text">{{ $club->title }}</p>
                    </div>
                </a>
                @if($index < $clubs->count() - 1)
                <div class="divider"></div>
                @endif
                @endforeach
            @endif
        </div>
    </div>
</div>

<style>
    @media (min-width: 1200px) {
        .counter-wrap1 .divider:last-of-type {
            display: block !important;
        }
    }
</style>
