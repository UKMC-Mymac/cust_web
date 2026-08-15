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
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <p><mark class="text-primary">{{ __('field_sub_title') }}:</mark> {{ $row->sub_title }}</p><hr/>
                            <p><mark class="text-primary">{{ __('field_button_text') }}:</mark> {{ $row->button_text }}</p><hr/>
                            <p><mark class="text-primary">{{ __('field_button_link') }}:</mark> {{ $row->button_link }}</p><hr/>
                            @if($row->page_id || $row->route_name || $row->button_link)
                                @php
                                    $buttonOneUrl = $row->button_link ?? '';
                                    if (!empty($row->page_id)) {
                                        $page = \App\Models\Web\Page::find($row->page_id);
                                        if ($page) {
                                            $buttonOneUrl = route('page.single', $page->slug);
                                        }
                                    } elseif (!empty($row->route_name)) {
                                        try {
                                            $buttonOneUrl = route($row->route_name);
                                        } catch (\Exception $e) {
                                            $buttonOneUrl = $row->button_link ?? '';
                                        }
                                    }
                                @endphp
                                <p><mark class="text-primary">Button 1 Link Type:</mark>
                                    @if(!empty($row->page_id))
                                        <span class="badge badge-info">Page: {{ \App\Models\Web\Page::find($row->page_id)->title ?? 'N/A' }}</span>
                                    @elseif(!empty($row->route_name))
                                        <span class="badge badge-warning">Route: {{ $row->route_name }}</span>
                                    @else
                                        <span class="badge badge-secondary">Custom URL</span>
                                    @endif
                                </p><hr/>
                                @if($buttonOneUrl)
                                <p><mark class="text-primary">Button 1 Resolved URL:</mark> <a href="{{ $buttonOneUrl }}" target="_blank">{{ $buttonOneUrl }}</a></p><hr/>
                                @endif
                            @endif

                            @if($row->button_text_2)
                            <p><mark class="text-primary">Button Text 2:</mark> {{ $row->button_text_2 }}</p><hr/>
                            @endif
                            @if($row->page_id_2 || $row->route_name_2 || $row->button_link_2)
                                @php
                                    $buttonTwoUrl = $row->button_link_2 ?? '';
                                    if (!empty($row->page_id_2)) {
                                        $page = \App\Models\Web\Page::find($row->page_id_2);
                                        if ($page) {
                                            $buttonTwoUrl = route('page.single', $page->slug);
                                        }
                                    } elseif (!empty($row->route_name_2)) {
                                        try {
                                            $buttonTwoUrl = route($row->route_name_2);
                                        } catch (\Exception $e) {
                                            $buttonTwoUrl = $row->button_link_2 ?? '';
                                        }
                                    }
                                @endphp
                                <p><mark class="text-primary">Button 2 Link Type:</mark>
                                    @if(!empty($row->page_id_2))
                                        <span class="badge badge-info">Page: {{ \App\Models\Web\Page::find($row->page_id_2)->title ?? 'N/A' }}</span>
                                    @elseif(!empty($row->route_name_2))
                                        <span class="badge badge-warning">Route: {{ $row->route_name_2 }}</span>
                                    @else
                                        <span class="badge badge-secondary">Custom URL</span>
                                    @endif
                                </p><hr/>
                                @if($buttonTwoUrl)
                                <p><mark class="text-primary">Button 2 Resolved URL:</mark> <a href="{{ $buttonTwoUrl }}" target="_blank">{{ $buttonTwoUrl }}</a></p><hr/>
                                @endif
                            @endif

                            @if(!empty($row->video_url))
                                <p><mark class="text-primary">Video URL:</mark> <a href="{{ $row->video_url }}" target="_blank">{{ $row->video_url }}</a></p><hr/>
                            @endif

                            <p><mark class="text-primary">{{ __('field_status') }}:</mark>
                                @if( $row->status == 1 )
                                <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                @else
                                <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                @endif
                            </p>
                        </div>
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
