<!-- Edit modal content -->
<div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                                @include('admin.web.inc.errors')

            <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ __('modal_edit') }} {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- Form Start -->
                <div class="form-group">
                    <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                    <input type="text" class="form-control" name="title" id="title" value="{{ $row->title }}" required>

                    <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_title') }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control" name="category" id="category" value="{{ $row->category }}">
                </div>

                <div class="form-group">
                    <label for="program_language" class="form-label">Language</label>
                    <input type="text" class="form-control" name="program_language" id="program_language" value="{{ $row->program_language }}">
                </div>

                <div class="form-group">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" class="form-control" name="duration" id="duration" value="{{ $row->duration }}">
                </div>

                <div class="form-group">
                    <label for="button_text" class="form-label">Button Text</label>
                    <input type="text" class="form-control" name="button_text" id="button_text" value="{{ $row->button_text }}">
                </div>

                <div class="form-group">
                    <label for="button_url" class="form-label">Button URL</label>
                    <input type="url" class="form-control" name="button_url" id="button_url" value="{{ $row->button_url }}">
                </div>

                <div class="form-group">
                    <label for="attach" class="form-label">Program Image</label>
                    <input type="file" class="form-control" name="attach" id="attach" accept="image/*">
                    @if($row->attach)
                        <small class="text-muted">Current: <a href="{{ asset('uploads/feature/' . $row->attach) }}" target="_blank">View Image</a></small>
                    @endif
                    <small class="text-muted d-block">Recommended size: 500x280 pixels</small>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">{{ __('field_description') }} <span>*</span></label>
                    <textarea name="description" id="description" class="form-control" required>{{ $row->description }}</textarea>

                    <div class="invalid-feedback">
                        {{ __('required_field') }} {{ __('field_description') }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">{{ __('select_status') }}</label>
                    <select class="form-control" name="status" id="status">
                        <option value="1" @if( $row->status == 1 ) selected @endif>{{ __('status_active') }}</option>
                        <option value="0" @if( $row->status == 0 ) selected @endif>{{ __('status_inactive') }}</option>
                    </select>
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
