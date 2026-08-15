<!-- Show modal content -->
<div id="showModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ __('modal_view') }} {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h4><mark class="text-primary">{{ __('field_status') }}:</mark>
                    @if($row->status == 1)
                    <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                    @else
                    <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                    @endif
                </h4>
                <hr/>

                <div class="row">
                    <div class="col-md-12">
                        @if($row->attach)
                        <p><mark class="text-primary">{{ __('field_image') }}:</mark></p>
                        <div class="mb-3">
                            <img src="{{ asset('uploads/apply/' . $row->attach) }}" alt="{{ $title }}" style="max-width: 100%; height: auto;">
                        </div>
                        <hr/>
                        @endif

                        @if($row->description)
                        <p><mark class="text-primary">Description:</mark> {{ $row->description }}</p><hr/>
                        @endif

                        @php
                            $displayUrl = $row->url ?? '';
                            if (!empty($row->page_id)) {
                                $page = \App\Models\Web\Page::find($row->page_id);
                                if ($page) {
                                    $displayUrl = route('page.single', $page->slug);
                                }
                            } elseif (!empty($row->route_name)) {
                                try {
                                    $displayUrl = route($row->route_name);
                                } catch (\Exception $e) {
                                    $displayUrl = $row->url ?? '';
                                }
                            }
                        @endphp
                        
                        @if($displayUrl)
                        <p><mark class="text-primary">Link Type:</mark>
                            @if(!empty($row->page_id))
                                <span class="badge badge-info">Page: {{ \App\Models\Web\Page::find($row->page_id)->title ?? 'N/A' }}</span>
                            @elseif(!empty($row->route_name))
                                <span class="badge badge-warning">Route: {{ $row->route_name }}</span>
                            @else
                                <span class="badge badge-secondary">Custom URL</span>
                            @endif
                        </p><hr/>
                        
                        <p><mark class="text-primary">Resolved URL:</mark> <a href="{{ $displayUrl }}" target="_blank">{{ $displayUrl }}</a></p><hr/>
                        @endif

                        @if($row->button_text)
                        <p><mark class="text-primary">Button Text:</mark> {{ $row->button_text }}</p><hr/>
                        @endif

                        @php
                            $items = is_array($row->items) ? $row->items : (json_decode($row->items, true) ?? []);
                        @endphp

                        <p><mark class="text-primary">Checklist Items:</mark></p>
                        @if(count($items))
                            <ul class="list-group mb-3">
                                @foreach($items as $item)
                                    <li class="list-group-item">{{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No items added.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
            </div>
        </div>
    </div>
</div>
