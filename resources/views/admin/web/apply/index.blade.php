@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Section Heading Management -->
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Section Heading</h5>
                    </div>
                    <div class="card-block">
                        @php
                            $applySection = \App\Models\Web\ContentSection::query()
                                                                         ->where('key', 'apply')
                                                                         ->first();
                        @endphp
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <strong>Subtitle:</strong>
                                    <span class="text-muted">{{ $applySection->subtitle ?? 'Not set' }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Title:</strong>
                                    <span class="text-muted">{{ $applySection->title ?? 'Not set' }}</span>
                                </div>
                                <div>
                                    <strong>Description:</strong>
                                    <span class="text-muted">{!! str_limit($applySection->description ?? 'Not set', 100) !!}</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                @if($applySection && $applySection->status == 1)
                                    <div class="mb-2"><span class="badge badge-pill badge-success">{{ __('status_active') }}</span></div>
                                @else
                                    <div class="mb-2"><span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span></div>
                                @endif
                                <a href="{{ route('admin.content-section.manage', 'apply') }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Section
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Heading Management -->

            @can($access.'-create')
            <div class="col-lg-4 col-xl-4">
                <form class="needs-validation apply-items-form" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data" data-items='[]'>
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <div class="form-group">
                                <label class="form-label">Checklist Items</label>
                                <div class="text-muted mb-2">Add one apply item per row. The frontend renders these as the admission checklist.</div>
                                <input type="hidden" name="items" class="apply-items-json" value="{{ old('items', '[]') }}">
                                <div class="apply-items-list"></div>
                                <button type="button" class="btn btn-outline-info btn-sm mt-3 add-apply-item-btn">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="4" placeholder="Admission overview">{{ old('description') }}</textarea>
                            </div>

                            <!-- Hidden select options for JavaScript to access -->
                            <div style="display:none;">
                                <select id="pages-list">
                                    <option value="">Select Page</option>
                                    @foreach ($pages as $page)
                                        <option value="{{ $page->id }}">{{ $page->title }}</option>
                                    @endforeach
                                </select>
                                <select id="routes-list">
                                    <option value="">Select Internal Link</option>
                                    @foreach ($internalRoutes as $routeName => $label)
                                        <option value="{{ $routeName }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label fw-bold">Link To</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Link to Page</label>
                                        <select class="form-control" name="page_id" id="page_id" data-link-type="page">
                                            <option value="">Select Page</option>
                                            @foreach ($pages as $page)
                                                <option value="{{ $page->id }}">{{ $page->title }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted d-block mt-1">Select a page</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Internal Link</label>
                                        <select class="form-control" name="route_name" id="route_name" data-link-type="route">
                                            <option value="">Select Internal Link</option>
                                            @foreach ($internalRoutes as $routeName => $label)
                                                <option value="{{ $routeName }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted d-block mt-1">Or select internal link</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Custom URL</label>
                                        <input type="url" class="form-control" name="url" id="url" value="{{ old('url') }}" placeholder="https://example.com/admission">
                                        <small class="text-muted d-block mt-1">If no page/link selected</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" name="button_text" id="button_text" value="{{ old('button_text') }}" placeholder="More About Admission">
                            </div>

                            <div class="form-group">
                                <label for="attach" class="form-label">{{ __('field_image') }}</label>
                                <input type="file" class="form-control" name="attach" id="attach" accept="image/*">
                                <small class="text-muted">Recommended size: 1024x900 pixels</small>
                            </div>

                            <div class="form-group">
                                <label for="status" class="form-label">{{ __('select_status') }}</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1" @selected(old('status', '1') === '1')>{{ __('status_active') }}</option>
                                    <option value="0" @selected(old('status', '1') === '0')>{{ __('status_inactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan

            <div class="col-lg-{{ auth()->user()->can($access.'-create') ? '8' : '12' }} col-xl-{{ auth()->user()->can($access.'-create') ? '8' : '12' }}">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_image') }}</th>
                                        <th>Items</th>
                                        <th>Description</th>
                                        <th>URL</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if($row->attach)
                                                <img src="{{ asset('uploads/apply/' . $row->attach) }}" alt="{{ $title }}" style="height: 50px; width: 80px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>{{ is_array($row->items) ? count($row->items) : 0 }}</td>
                                        <td>{!! $row->description ? str_limit($row->description, 60, '...') : '-' !!}</td>
                                        <td>{!! $row->url ? str_limit($row->url, 40, '...') : '-' !!}</td>
                                        <td>
                                            @if($row->status == 1)
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-{{ $row->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @include($view.'.show')

                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            @include($view.'.edit')
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<script>
document.addEventListener('DOMContentLoaded', function () {
    function escapeHtml(value) {
        const element = document.createElement('div');
        element.textContent = value ?? '';
        return element.innerHTML;
    }

    function parseItems(value) {
        if (!value) {
            return [];
        }

        if (Array.isArray(value)) {
            return value;
        }

        try {
            return JSON.parse(value);
        } catch (error) {
            return [];
        }
    }

    function buildRow(value) {
        return `
            <div class="apply-item-row border rounded p-3 mb-3">
                <div class="d-flex gap-2 align-items-start">
                    <div class="flex-grow-1">
                        <label class="form-label">Item</label>
                        <input type="text" class="form-control apply-item-field" value="${escapeHtml(value ?? '')}" placeholder="Undergraduate Admissions" required>
                    </div>
                    <div class="pt-4">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-apply-item-btn">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    function syncItems(form) {
        const hiddenField = form.querySelector('.apply-items-json');
        const items = Array.from(form.querySelectorAll('.apply-item-field'))
            .map(function (input) {
                return input.value.trim();
            })
            .filter(function (item) {
                return item !== '';
            });

        hiddenField.value = JSON.stringify(items);
    }

    function renderForm(form) {
        const list = form.querySelector('.apply-items-list');
        const hiddenField = form.querySelector('.apply-items-json');
        const items = parseItems(hiddenField.value);

        list.innerHTML = items.length ? items.map(function (item) {
            return buildRow(item);
        }).join('') : '';

        if (!list.children.length) {
            list.insertAdjacentHTML('beforeend', buildRow(''));
        }

        syncItems(form);
    }

    document.querySelectorAll('.apply-items-form').forEach(function (form) {
        const list = form.querySelector('.apply-items-list');
        const addButton = form.querySelector('.add-apply-item-btn');
        const pageField = form.querySelector('#page_id');
        const routeField = form.querySelector('#route_name');

        // Add mutual disable logic for page/route fields
        function updateLinkFieldStates() {
            if (pageField && routeField) {
                const pageValue = pageField.value;
                const routeValue = routeField.value;
                routeField.disabled = !!pageValue;
                pageField.disabled = !!routeValue;
            }
        }

        if (pageField) {
            pageField.addEventListener('change', updateLinkFieldStates);
        }
        if (routeField) {
            routeField.addEventListener('change', updateLinkFieldStates);
        }

        // Initialize disabled states
        updateLinkFieldStates();

        renderForm(form);

        addButton.addEventListener('click', function () {
            list.insertAdjacentHTML('beforeend', buildRow(''));
            syncItems(form);
        });

        form.addEventListener('click', function (event) {
            const removeButton = event.target.closest('.remove-apply-item-btn');
            if (!removeButton) {
                return;
            }

            const row = removeButton.closest('.apply-item-row');
            if (row) {
                row.remove();
            }

            if (!list.querySelector('.apply-item-row')) {
                list.insertAdjacentHTML('beforeend', buildRow(''));
            }

            syncItems(form);
        });

        form.addEventListener('input', function () {
            syncItems(form);
        });
    });
});
</script>

@endsection
