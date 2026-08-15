<!-- Edit modal content -->
<div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="needs-validation apply-items-form" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data" data-items='@json($row->items ?? [])'>
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ __('modal_edit') }} {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Checklist Items</label>
                    <div class="text-muted mb-2">Update the checklist items that appear in the admission area.</div>
                    <input type="hidden" name="items" class="apply-items-json" value='@json($row->items ?? [])'>
                    <div class="apply-items-list"></div>
                    <button type="button" class="btn btn-outline-info btn-sm mt-3 add-apply-item-btn">
                        <i class="fas fa-plus"></i> Add Item
                    </button>
                </div>

                <div class="form-group">
                    <label for="description-{{ $row->id }}" class="form-label">Description</label>
                    <textarea class="form-control" name="description" id="description-{{ $row->id }}" rows="4">{{ $row->description }}</textarea>
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
                                    <option value="{{ $page->id }}" @selected(old('page_id', $row->page_id ?? '') == $page->id)>{{ $page->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block mt-1">Select a page</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Internal Link</label>
                            <select class="form-control" name="route_name" id="route_name" data-link-type="route">
                                <option value="">Select Internal Link</option>
                                @foreach ($internalRoutes as $routeName => $label)
                                    <option value="{{ $routeName }}" @selected(old('route_name', $row->route_name ?? '') == $routeName)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block mt-1">Or select internal link</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Custom URL</label>
                            <input type="url" class="form-control" name="url" id="url-{{ $row->id }}" value="{{ old('url', $row->url) }}">
                            <small class="text-muted d-block mt-1">If no page/link selected</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="button_text-{{ $row->id }}" class="form-label">Button Text</label>
                    <input type="text" class="form-control" name="button_text" id="button_text-{{ $row->id }}" value="{{ $row->button_text }}">
                </div>

                <div class="form-group">
                    <label for="attach-{{ $row->id }}" class="form-label">{{ __('field_image') }}</label>
                    <input type="file" class="form-control" name="attach" id="attach-{{ $row->id }}" accept="image/*">
                    @if($row->attach)
                        <small class="text-muted">Current: <a href="{{ asset('uploads/apply/' . $row->attach) }}" target="_blank">View Image</a></small>
                    @endif
                    <small class="text-muted d-block">Recommended size: 1024x900 pixels</small>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('select_status') }}</label>
                    <div class="d-flex gap-3 flex-wrap">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-active-{{ $row->id }}" value="1" @checked($row->status == 1)>
                            <label class="form-check-label" for="status-active-{{ $row->id }}">{{ __('status_active') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-inactive-{{ $row->id }}" value="0" @checked($row->status == 0)>
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
