@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')

               <!-- Section Heading Management -->
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class=""></i> Section Heading</h5>
                    </div>
                    <div class="card-block">
                        @php
                            $whyChooseUsSection = \App\Models\Web\ContentSection::query()
                                                                           ->where('key', 'why_choose_us')
                                                                           ->first();
                        @endphp
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <strong>Title:</strong> 
                                    <span class="text-muted">{{ $whyChooseUsSection->title ?? 'Not set' }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Subtitle:</strong> 
                                    <span class="text-muted">{{ $whyChooseUsSection->subtitle ?? 'Not set' }}</span>
                                </div>
                                <div>
                                    <strong>Description:</strong> 
                                    <span class="text-muted">{!! str_limit($whyChooseUsSection->description ?? 'Not set', 100) !!}</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                @if($whyChooseUsSection && $whyChooseUsSection->status == 1)
                                    <div class="mb-2"><span class="badge badge-pill badge-success">{{ __('status_active') }}</span></div>
                                @else
                                    <div class="mb-2"><span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span></div>
                                @endif
                                <a href="{{ route('admin.content-section.manage', 'why_choose_us') }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Section
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Heading Management -->
            <div class="col-lg-5 col-xl-5">
                <form class="needs-validation why-reasons-form" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data" data-reasons="[]">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">

                            <div class="form-group">
                                <label class="form-label fw-bold">Reasons</label>
                                <div class="alert alert-light border border-info mb-3" style="font-size: 0.9rem;">
                                    <i class="fas fa-lightbulb text-info"></i> <strong>Add reasons</strong> why students should choose your institution. Each reason can link to a page, internal link, or external URL.
                                </div>
                                <input type="hidden" name="items" class="why-items-json" value="{{ old('items', '[]') }}">
                                
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

                                <div class="reasons-list"></div>
                                <button type="button" class="btn btn-outline-info btn-sm mt-3 add-reason-btn">
                                    <i class="fas fa-plus"></i> Add Reason
                                </button>
                            </div>

                            {{-- <div class="form-group">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" name="button_text" id="button_text" value="{{ old('button_text') }}" placeholder="Explore More">
                            </div> --}}

                            <div class="form-group">
                                <label for="attach" class="form-label">{{ __('field_image') }}</label>
                                <input type="file" class="form-control" name="attach" id="attach" accept="image/*">
                                <small class="text-muted">Recommended size: 850x500 pixels</small>
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

            <div class="col-lg-7 col-xl-7">
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
                                            <th>Reasons</th>
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
                                                <img src="{{ asset('uploads/why-choose-us/' . $row->attach) }}" alt="{{ $row->title }}" style="height: 50px; width: 80px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>{{ is_array($row->items) ? count($row->items) : 0 }}</td>
                                        <td>{!! $row->url ? str_limit($row->url, 40, '...') : '-' !!}</td>
                                        <td>
                                            @if($row->status)
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

    function parseReasons(value) {
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

    function buildRow(index, reason) {
        const number = reason.number ?? (index + 1);
        const title = reason.title ?? '';
        const description = reason.description ?? '';
        const pageId = reason.page_id ?? '';
        const routeName = reason.route_name ?? '';
        const url = reason.url ?? '';
        const buttonText = reason.button_text ?? '';

        let pageOptions = '<option value="">Select Page</option>';
        const pagesList = document.querySelector('#pages-list');
        let foundPage = false;
        if (pagesList) {
            pagesList.querySelectorAll('option').forEach(option => {
                if (option.value !== '') {
                    const selected = pageId == option.value ? 'selected' : '';
                    if (selected) foundPage = true;
                    pageOptions += `<option value="${option.value}" ${selected}>${option.textContent}</option>`;
                }
            });
        }
        if (pageId && !foundPage) {
            pageOptions += `<option value="${pageId}" selected>Selected page (ID: ${pageId})</option>`;
        }

        let routeOptions = '<option value="">Select Internal Link</option>';
        const routesList = document.querySelector('#routes-list');
        let foundRoute = false;
        if (routesList) {
            routesList.querySelectorAll('option').forEach(option => {
                if (option.value !== '') {
                    const selected = routeName == option.value ? 'selected' : '';
                    if (selected) foundRoute = true;
                    routeOptions += `<option value="${option.value}" ${selected}>${option.textContent}</option>`;
                }
            });
        }
        if (routeName && !foundRoute) {
            routeOptions += `<option value="${routeName}" selected>Selected internal link (${routeName})</option>`;
        }

        return `
            <div class="reason-item-row border-start border-5 border-info rounded p-3 mb-4 bg-light">
                <input type="hidden" class="reason-number-field" value="${escapeHtml(number)}">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0"><span class="badge bg-info reason-number-badge">Reason #${escapeHtml(number)}</span></h6>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-reason-btn">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Reason Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control reason-title-field" value="${escapeHtml(title)}" placeholder="e.g., Quality Education" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Button Text</label>
                        <input type="text" class="form-control reason-button-field" value="${escapeHtml(buttonText)}" placeholder="e.g., Learn More">
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control reason-description-field" rows="3" placeholder="Provide a detailed description of this reason" required>${escapeHtml(description)}</textarea>
                    </div>
                    
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Link to Page</label>
                                <select class="form-control reason-page-field">
                                    ${pageOptions}
                                </select>
                                <small class="text-muted d-block mt-1">Select a page</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Internal Link</label>
                                <select class="form-control reason-route-field">
                                    ${routeOptions}
                                </select>
                                <small class="text-muted d-block mt-1">Or select internal link</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Custom URL</label>
                                <input type="url" class="form-control reason-url-field" value="${escapeHtml(url)}" placeholder="https://example.com">
                                <small class="text-muted d-block mt-1">If no page/link selected</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function refreshNumbers(form) {
        form.querySelectorAll('.reason-item-row').forEach(function (row, index) {
            const numberField = row.querySelector('.reason-number-field');
            const badge = row.querySelector('.reason-number-badge');
            const newNumber = index + 1;
            if (numberField) {
                numberField.value = newNumber;
            }
            if (badge) {
                badge.textContent = 'Reason #' + newNumber;
            }
        });
    }

    function syncItems(form) {
        refreshNumbers(form);

        const reasons = Array.from(form.querySelectorAll('.reason-item-row')).map(function (row) {
            const pageId = row.querySelector('.reason-page-field')?.value || '';
            const routeName = row.querySelector('.reason-route-field')?.value || '';
            const url = row.querySelector('.reason-url-field')?.value || '';
            
            // Only use URL if no page or route is selected
            const finalUrl = (pageId || routeName) ? '' : url;

            return {
                number: row.querySelector('.reason-number-field')?.value || '',
                title: row.querySelector('.reason-title-field')?.value || '',
                description: row.querySelector('.reason-description-field')?.value || '',
                page_id: pageId,
                route_name: routeName,
                url: finalUrl,
                button_text: row.querySelector('.reason-button-field')?.value || ''
            };
        }).filter(function (reason) {
            return reason.title.trim() !== '' || reason.description.trim() !== '';
        });

        const hiddenItems = form.querySelector('.why-items-json');
        if (hiddenItems) {
            hiddenItems.value = JSON.stringify(reasons);
        }
    }

    document.querySelectorAll('.why-reasons-form').forEach(function (form) {
        const list = form.querySelector('.reasons-list');
        const addButton = form.querySelector('.add-reason-btn');
        const initialReasons = parseReasons(form.dataset.reasons);
        const itemsField = form.querySelector('.why-items-json');
        // Only show initial reasons if they exist, don't create empty one on create form
        const normalizedReasons = initialReasons.length ? initialReasons : [];

        // Clear existing rows before rendering initial reasons to avoid duplicates
        list.innerHTML = '';
        normalizedReasons.forEach(function (reason, index) {
            list.insertAdjacentHTML('beforeend', buildRow(index, reason));
        });
        
        // Add initial helper text if no reasons
        if (normalizedReasons.length === 0) {
            list.insertAdjacentHTML('beforeend', '<div class="alert alert-info mb-3"><i class="fas fa-info-circle"></i> Click "Add Reason" below to add reasons</div>');
        }

        refreshNumbers(form);

        if (addButton) {
            addButton.addEventListener('click', function () {
                // Remove helper text if it exists
                const helperText = list.querySelector('.alert-info');
                if (helperText) {
                    helperText.remove();
                }
                
                const nextIndex = list.querySelectorAll('.reason-item-row').length;
                list.insertAdjacentHTML('beforeend', buildRow(nextIndex, { number: nextIndex + 1, title: '', description: '', page_id: '', route_name: '', url: '', button_text: '' }));
                syncItems(form);
            });
        }

        list.addEventListener('click', function (event) {
            const removeButton = event.target.closest('.remove-reason-btn');
            if (!removeButton) {
                return;
            }

            const rows = list.querySelectorAll('.reason-item-row');
            const row = removeButton.closest('.reason-item-row');

            if (rows.length > 1 && row) {
                row.remove();
            } else if (row) {
                row.querySelector('.reason-title-field').value = '';
                row.querySelector('.reason-description-field').value = '';
            }

            syncItems(form);
        });

        list.addEventListener('input', function () {
            syncItems(form);
        });

        // Add mutual disable logic: prevent selecting both page and internal link
        list.addEventListener('change', function (event) {
            const pageField = event.target.closest('.reason-page-field');
            const routeField = event.target.closest('.reason-route-field');
            
            if (pageField || routeField) {
                const row = event.target.closest('.reason-item-row');
                if (row) {
                    const pageSel = row.querySelector('.reason-page-field');
                    const routeSel = row.querySelector('.reason-route-field');
                    
                    if (pageSel && routeSel) {
                        const pageValue = pageSel.value;
                        const routeValue = routeSel.value;
                        
                        // Disable route field if page is selected
                        routeSel.disabled = !!pageValue;
                        // Disable page field if route is selected
                        pageSel.disabled = !!routeValue;
                    }
                }
            }
        });

        // Set initial disabled state based on loaded data
        document.querySelectorAll('.reason-item-row').forEach(function (row) {
            const pageSel = row.querySelector('.reason-page-field');
            const routeSel = row.querySelector('.reason-route-field');
            if (pageSel && routeSel) {
                const pageValue = pageSel.value;
                const routeValue = routeSel.value;
                routeSel.disabled = !!pageValue;
                pageSel.disabled = !!routeValue;
            }
        });

        form.addEventListener('submit', function (event) {
            syncItems(form);
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                form.classList.add('was-validated');
                return;
            }
            if (itemsField && itemsField.value === '') {
                itemsField.value = '[]';
            }
        });

        syncItems(form);
    });
});
</script>

@endsection
