<!-- Edit modal content -->
<div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                                @include('admin.web.inc.errors')

            <form class="needs-validation why-reasons-form" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data" data-reasons='@json($row->items ?? [])'>
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ __('modal_edit') }} {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                {{-- Title/subtitle managed via ContentSection; reasons stored here --}}

                <div class="form-group">
                    <label class="form-label fw-bold">Reasons</label>
                    <div class="alert alert-light border border-info mb-3" style="font-size: 0.9rem;">
                        <i class="fas fa-lightbulb text-info"></i> <strong>Edit reasons</strong> why students should choose your institution. Each reason can link to a page, internal link, or external URL.
                    </div>
                    <input type="hidden" name="items" class="why-items-json" value='@json($row->items ?? [])'>
                    <div class="reasons-list"></div>
                    <button type="button" class="btn btn-outline-info btn-sm mt-3 add-reason-btn">
                        <i class="fas fa-plus"></i> Add Reason
                    </button>
                </div>

                <!-- Hidden select for page/route options (used by JavaScript) -->
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
                    <label for="url" class="form-label">Main URL</label>
                    <input type="url" class="form-control" name="url" id="url" value="{{ old('url', $row->url) }}">
                    <small class="text-muted">Main URL for the section (deprecated - use reason URLs instead)</small>
                </div>

                {{-- <div class="form-group">
                    <label for="button_text" class="form-label">Button Text</label>
                    <input type="text" class="form-control" name="button_text" id="button_text" value="{{ $row->button_text }}">
                </div> --}}

                <div class="form-group">
                    <label for="attach" class="form-label">{{ __('field_image') }}</label>
                    <input type="file" class="form-control" name="attach" id="attach" accept="image/*">
                    @if($row->attach)
                        <small class="text-muted">Current: <a href="{{ asset('uploads/why-choose-us/' . $row->attach) }}" target="_blank">View Image</a></small>
                    @endif
                    <small class="text-muted d-block">Recommended size: 850x500 pixels</small>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('select_status') }}</label>
                    <div class="d-flex gap-3 flex-wrap">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-active-{{ $row->id }}" value= 1 @checked($row->status == 1)>
                            <label class="form-check-label" for="status-active-{{ $row->id }}">{{ __('status_active') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-inactive-{{ $row->id }}" value= 0 @checked($row->status == 0)>
                            <label class="form-check-label" for="status-inactive-{{ $row->id }}">{{ __('status_inactive') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
            </div>

            </form>
        </div>
    </div>
</div>

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
        // If the page_id exists in the reason but isn't present in the current pages list
        // (e.g. language/status mismatch), add a placeholder selected option so the editor shows it.
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
        const normalizedReasons = initialReasons.length ? initialReasons : [{ number: 1, title: '', description: '' }];

        // Clear existing rows before rendering initial reasons to avoid duplicates
        list.innerHTML = '';
        normalizedReasons.forEach(function (reason, index) {
            list.insertAdjacentHTML('beforeend', buildRow(index, reason));
        });

        refreshNumbers(form);

        if (addButton) {
            addButton.addEventListener('click', function () {
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
