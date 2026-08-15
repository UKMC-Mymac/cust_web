@foreach ($items as $item)
    @php
        $linkType = '-';
        if ($item->page) {
            $linkType = 'Page: ' . $item->page->title;
        } elseif ($item->route_name) {
            $linkType = 'Internal: ' . ($internalLinks[$item->route_name] ?? $item->route_name);
        } elseif ($item->url) {
            $linkType = 'URL: ' . $item->url;
        }
    @endphp
    @php
        $hasChildren = $item->childrenRecursive->isNotEmpty();
    @endphp
    <li class="menu-item" data-id="{{ $item->id }}">
        <div class="menu-item-header">
            <div class="menu-item-title">
                <span class="menu-handle" title="Drag to reorder">
                    <i class="fas fa-grip-vertical"></i>
                </span>
                <div>
                    <div class="menu-item-label">{{ $item->label }}</div>
                    <div class="menu-item-meta">{{ $linkType }}</div>
                </div>
            </div>
            <div class="menu-actions">
                @if ($hasChildren)
                <button type="button" class="btn btn-icon btn-light btn-sm menu-toggle" aria-expanded="true" aria-controls="menu-children-{{ $item->id }}">
                    <i class="fas fa-chevron-down"></i>
                </button>
                @endif
                @can($access.'-edit')
                <a href="{{ route($route.'.edit', $item->id) }}" class="btn btn-icon btn-primary btn-sm">
                    <i class="far fa-edit"></i>
                </a>
                @endcan

                @can($access.'-delete')
                <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id }}">
                    <i class="fas fa-trash-alt"></i>
                </button>
                @include('admin.layouts.inc.delete', ['row' => $item])
                @endcan
            </div>
        </div>

        <ul class="menu-children" id="menu-children-{{ $item->id }}">
            @if ($hasChildren)
                @include('admin.web.navbar.partials.tree', [
                    'items' => $item->childrenRecursive,
                    'route' => $route,
                    'access' => $access,
                    'internalLinks' => $internalLinks,
                ])
            @endif
        </ul>
    </li>
@endforeach
