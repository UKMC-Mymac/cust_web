<!-- Show modal start -->
<div class="modal fade" id="showModal-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ $title }} {{ __('details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Details Start -->
                <div class="row">
                    <div class="col-md-6">
                        <p><mark class="text-primary">{{ __('field_title') }}:</mark> {{ $row->title }}</p>
                        <p><mark class="text-primary">School:</mark> {{ $row->school->title ?? 'N/A' }}</p>
                        <p><mark class="text-primary">{{ __('field_status') }}:</mark> 
                            @if( $row->status == 1 )
                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                            @else
                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                            @endif
                        </p>
                        <div class="mb-3">
                            <mark class="text-primary">Short Description:</mark>
                            <div class="border rounded p-2 mt-1">{{ $row->short_description }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if(is_file('uploads/'.$path.'/'.$row->attach))
                        <img class="img-fluid rounded" src="{{ asset('uploads/'.$path.'/'.$row->attach) }}" alt="Thumbnail">
                        @endif
                    </div>
                </div>
                <!-- Details End -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('btn_close') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- Show modal end -->
