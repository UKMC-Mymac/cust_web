    <!-- Edit modal content -->
    <div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ __('modal_edit') }} {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body text-start">
                    <!-- Form Start -->
                    <div class="form-group mb-3">
                        <label for="key" class="form-label fw-bold">Key/Identifier <span>*</span></label>
                        <input type="text" class="form-control" name="key" id="key-{{ $row->id }}" value="{{ $row->key }}" required @if(in_array($row->key, ['student_login', 'staff_login', 'privacy_policy', 'terms_of_service', 'copyright_link'])) readonly @endif>
                        <div class="invalid-feedback">
                          Please enter a unique key identifier.
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="title" class="form-label fw-bold">Title <span>*</span></label>
                        <input type="text" class="form-control" name="title" id="title-{{ $row->id }}" value="{{ $row->title }}" required>
                        <div class="invalid-feedback">
                          Please enter a title.
                        </div>
                    </div>

                    <div class="form-group mb-3 bg-light p-3 rounded border">
                        <label class="form-label fw-bold text-primary mb-2">Link To (Choose One):</label>
                        
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Link to Page</label>
                            <select class="form-control" name="page_id" id="page_id_edit-{{ $row->id }}">
                                <option value="">Select Page</option>
                                @foreach ($pages as $page)
                                    <option value="{{ $page->id }}" {{ old('page_id', $row->page_id) == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Internal Link</label>
                            <select class="form-control" name="route_name" id="route_name_edit-{{ $row->id }}">
                                <option value="">Select Internal Link</option>
                                @foreach ($internalRoutes as $routeName => $label)
                                    <option value="{{ $routeName }}" {{ old('route_name', $row->route_name) == $routeName ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-1">
                            <label class="form-label small fw-semibold">Custom URL</label>
                            <input type="text" class="form-control" id="url_edit-{{ $row->id }}" name="url" value="{{ old('url', $row->url) }}" placeholder="https://example.com or #">
                        </div>
                        <small class="text-muted d-block mt-2">Specify either a page, internal link, or custom URL.</small>
                    </div>
                    <!-- Form End -->
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
    document.addEventListener('DOMContentLoaded', function() {
        const pageSelect = document.getElementById('page_id_edit-{{ $row->id }}');
        const routeSelect = document.getElementById('route_name_edit-{{ $row->id }}');
        const urlInput = document.getElementById('url_edit-{{ $row->id }}');

        function updateExclusive() {
            if (pageSelect.value) {
                routeSelect.disabled = true;
                routeSelect.value = '';
                urlInput.disabled = true;
                urlInput.value = '';
            } else if (routeSelect.value) {
                pageSelect.disabled = true;
                pageSelect.value = '';
                urlInput.disabled = true;
                urlInput.value = '';
            } else if (urlInput.value.trim()) {
                pageSelect.disabled = true;
                pageSelect.value = '';
                routeSelect.disabled = true;
                routeSelect.value = '';
            } else {
                pageSelect.disabled = false;
                routeSelect.disabled = false;
                urlInput.disabled = false;
            }
        }

        pageSelect.addEventListener('change', updateExclusive);
        routeSelect.addEventListener('change', updateExclusive);
        urlInput.addEventListener('input', updateExclusive);

        // Run on modal open/init
        updateExclusive();
    });
    </script>
