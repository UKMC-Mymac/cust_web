@foreach ($items as $item)
    @php
        $hasChildren = $item->activeChildrenRecursive->isNotEmpty();
        $currentPageSlug = request()->route('slug');
        $isActive = $item->page && $currentPageSlug === $item->page->slug;
        if ($item->page) {
            $linkUrl = route('page.single', $item->page->slug);
        } elseif ($item->route_name && \Illuminate\Support\Facades\Route::has($item->route_name)) {
            $linkUrl = route($item->route_name);
        } else {
            $linkUrl = $item->url ?: '#';
        }
        $target = $item->target ?: '_self';
    @endphp
    <li class="{{ $hasChildren ? 'menu-item-has-children' : '' }}">
        <a class="{{ $isActive ? 'active' : '' }}" href="{{ $linkUrl }}" target="{{ $target }}" @if($isActive) aria-current="page" @endif>{{ $item->label }}</a>
        @if ($hasChildren)
            <ul class="sub-menu">
                @include('web.custom.components.partials.nav-items', ['items' => $item->activeChildrenRecursive])
            </ul>
        @endif
    </li>
@endforeach
