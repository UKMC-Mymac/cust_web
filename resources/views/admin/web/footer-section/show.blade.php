<!-- Show Modal -->
<div class="modal fade" id="showModal-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="showModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showModalLabel-{{ $row->id }}">{{ $row->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Title:</strong></label>
                    <p>{{ $row->title }}</p>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Sort Order:</strong></label>
                    <p>{{ $row->sort_order }}</p>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Status:</strong></label>
                    <p>
                        @if( $row->status == 1 )
                        <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                        @else
                        <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('btn_close') }}</button>
            </div>
        </div>
    </div>
</div>
