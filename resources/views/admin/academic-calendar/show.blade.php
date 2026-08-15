<!-- Show modal content -->
<div id="showModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ __('modal_view') }} {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- Details View Start -->
                <h4><mark class="text-primary">{{ __('field_title') }}:</mark> {{ $row->title }}</h4>
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        <p><mark class="text-primary">{{ __('field_session') }}:</mark> {{ $row->session->title ?? '' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><mark class="text-primary">{{ __('field_date') }}:</mark> 
                            @if(isset($setting->date_format))
                            {{ date($setting->date_format, strtotime($row->date)) }}
                            @else
                            {{ date("Y-m-d", strtotime($row->date)) }}
                            @endif
                        </p>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <p><mark class="text-primary">{{ __('field_description') }}:</mark></p>
                        <div class="border p-3 bg-light rounded">
                            {!! $row->description !!}
                        </div>
                        <hr/>

                        <p><mark class="text-primary">{{ __('field_status') }}:</mark>
                            @if( $row->status == 1 )
                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                            @else
                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                            @endif
                        </p>

                        @if(!empty($row->attach) && (is_file('uploads/'.$path.'/'.$row->attach) || is_file('public/uploads/'.$path.'/'.$row->attach)))
                        <p>
                            <mark class="text-primary">{{ __('field_attach') }}:</mark>
                            <a href="{{ asset('uploads/'.$path.'/'.$row->attach) }}" class="btn btn-sm btn-dark" download>
                                <i class="fas fa-download"></i> {{ __('btn_download') }}
                            </a>
                        </p>
                        @endif
                    </div>
                </div>
                <!-- Details View End -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
            </div>
        </div>
    </div>
</div>
