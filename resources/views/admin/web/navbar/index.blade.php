@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        @can($access.'-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <div class="card-block">
                        <div class="menu-builder" data-reorder-url="{{ route($route.'.reorder') }}">
                            @php
                                $internalLinks = config('navbars.internal_links', []);
                            @endphp

                            <div class="alert alert-info mb-3">
                                Drag items to reorder. Nest items by dragging slightly right under a parent.
                            </div>

                            <ul class="menu-tree" id="menu-tree">
                                @include('admin.web.navbar.partials.tree', [
                                    'items' => $rows,
                                    'route' => $route,
                                    'access' => $access,
                                    'internalLinks' => $internalLinks,
                                ])
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@section('page_css')
<style>
    .menu-builder {
        background: #f6f7fb;
        border-radius: 10px;
        padding: 16px;
    }

    .menu-tree {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }

    .menu-tree .menu-item {
        margin-bottom: 10px;
        border: 1px solid #e3e7ef;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 1px 1px rgba(24, 32, 44, 0.04);
    }

    .menu-item-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        background: #ffffff;
    }

    .menu-handle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: #f1f3f7;
        color: #6c757d;
        margin-right: 10px;
        cursor: grab;
    }

    .menu-handle:active {
        cursor: grabbing;
    }

    .menu-item-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .menu-item-label {
        font-weight: 600;
    }

    .menu-item-meta {
        font-size: 12px;
        color: #6c757d;
    }

    .menu-children {
        list-style: none;
        margin: 0;
        padding: 8px 12px 12px 36px;
    }

    .menu-children .menu-item {
        margin-bottom: 8px;
    }

    .menu-actions .btn {
        margin-left: 6px;
    }

    .menu-item.is-collapsed > .menu-children {
        display: none;
    }

    .menu-children[hidden] {
        display: none;
    }

    .menu-item.is-collapsed .menu-toggle i {
        transform: rotate(-90deg);
    }

    .menu-toggle i {
        transition: transform 0.15s ease-in-out;
    }

    .menu-ghost {
        opacity: 0.6;
    }

    .menu-chosen {
        background: #eef3ff;
    }
</style>
@endsection

@section('page_js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    (function () {
        var tree = document.getElementById('menu-tree');
        if (!tree) {
            return;
        }

        tree.addEventListener('click', function (event) {
            var toggle = event.target.closest('.menu-toggle');
            if (!toggle) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            var item = toggle.closest('.menu-item');
            if (!item) {
                return;
            }

            var controlsId = toggle.getAttribute('aria-controls');
            var childrenList = controlsId ? document.getElementById(controlsId) : null;
            var isCollapsed = item.classList.toggle('is-collapsed');

            if (childrenList) {
                childrenList.hidden = isCollapsed;
            }

            toggle.setAttribute('aria-expanded', (!isCollapsed).toString());
        });

        function updateToggles() {
            var items = tree.querySelectorAll('.menu-item');

            items.forEach(function (item) {
                var childrenList = item.querySelector(':scope > ul.menu-children');
                var hasChildren = childrenList && childrenList.children.length > 0;
                var actions = item.querySelector(':scope > .menu-item-header .menu-actions');
                var existingToggle = actions ? actions.querySelector('.menu-toggle') : null;

                if (!actions) {
                    return;
                }

                if (hasChildren && !existingToggle) {
                    var button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'btn btn-icon btn-light btn-sm menu-toggle';
                    button.setAttribute('aria-expanded', 'true');
                    if (childrenList && childrenList.id) {
                        button.setAttribute('aria-controls', childrenList.id);
                    }
                    button.innerHTML = '<i class="fas fa-chevron-down"></i>';
                    actions.prepend(button);
                }

                if (!hasChildren && existingToggle) {
                    existingToggle.remove();
                    item.classList.remove('is-collapsed');
                }

                if (hasChildren && childrenList) {
                    var isCollapsed = item.classList.contains('is-collapsed');
                    childrenList.hidden = isCollapsed;
                    if (existingToggle) {
                        existingToggle.setAttribute('aria-expanded', (!isCollapsed).toString());
                    }
                }
            });
        }

        function initSortable(list) {
            Sortable.create(list, {
                group: 'menu-tree',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                handle: '.menu-handle',
                ghostClass: 'menu-ghost',
                chosenClass: 'menu-chosen',
                onEnd: function () {
                    updateToggles();
                    saveTree();
                },
            });
        }

        function buildTree(list) {
            var items = [];
            var children = list.querySelectorAll(':scope > li');

            children.forEach(function (child) {
                var item = { id: child.dataset.id };
                var sublist = child.querySelector(':scope > ul');
                if (sublist && sublist.children.length > 0) {
                    item.children = buildTree(sublist);
                }
                items.push(item);
            });

            return items;
        }

        function saveTree() {
            var treeData = buildTree(tree);
            var url = document.querySelector('.menu-builder').dataset.reorderUrl;
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ tree: treeData })
            }).catch(function () {
                console.error('Failed to save menu order.');
            });
        }

        initSortable(tree);
        tree.querySelectorAll('ul.menu-children').forEach(initSortable);
        updateToggles();
    })();
</script>
@endsection

@endsection
