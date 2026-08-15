<!-- Show modal content -->
<div id="showModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="myModalLabel">{{ __('modal_view') }} {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <div class="modal-body">
                @php
                    $reasons = is_array($row->items) ? $row->items : (json_decode($row->items, true) ?? []);
                @endphp

                <!-- Section Info -->
                <div class="mb-4">
                    <h6 class="text-muted text-uppercase fw-bold mb-3">Section Information</h6>
                    <div class="row g-3">
                        @if($row->url)
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body p-3">
                                    <small class="text-muted d-block mb-1">Main URL</small>
                                    <a href="{{ $row->url }}" target="_blank" class="text-primary">{{ $row->url }}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($row->button_text)
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body p-3">
                                    <small class="text-muted d-block mb-1">Button Text</small>
                                    <span class="badge bg-info">{{ $row->button_text }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <hr class="my-4">

                <!-- Reasons -->
                <div class="mb-4">
                    <h6 class="text-muted text-uppercase fw-bold mb-3">Reasons ({{ count($reasons) }})</h6>
                    @if(count($reasons))
                        <div class="row g-3">
                            @foreach($reasons as $reason)
                                @php
                                    $reasonUrl = '';
                                    if (!empty($reason['page_id'])) {
                                        $page = \App\Models\Web\Page::find($reason['page_id']);
                                        if ($page) {
                                            if (\Illuminate\Support\Facades\Route::has('page.single')) {
                                                try {
                                                    $reasonUrl = route('page.single', $page->slug);
                                                } catch (Exception $e) {
                                                    $reasonUrl = url('page/' . $page->slug);
                                                }
                                            } else {
                                                $reasonUrl = url('page/' . $page->slug);
                                            }
                                        }
                                    } elseif (!empty($reason['route_name'])) {
                                        $routes = config('navbars.internal_links', []);
                                        if (isset($routes[$reason['route_name']])) {
                                            try {
                                                $reasonUrl = route($reason['route_name']);
                                            } catch (\Exception $e) {
                                                $reasonUrl = '';
                                            }
                                        }
                                    } else {
                                        $reasonUrl = $reason['url'] ?? '';
                                    }
                                @endphp
                                <div class="col-12">
                                    <div class="card border-start border-4 border-info">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start justify-content-between mb-2">
                                                <span class="badge bg-info">Reason #{{ $reason['number'] ?? $loop->iteration }}</span>
                                                @if(!empty($reason['button_text']))
                                                    <span class="badge bg-secondary">{{ $reason['button_text'] }}</span>
                                                @endif
                                            </div>
                                            <h6 class="card-title fw-bold">{{ $reason['title'] ?? '' }}</h6>
                                            @if(!empty($reason['description']))
                                                <p class="card-text text-muted small">{{ $reason['description'] }}</p>
                                            @endif
                                            @if(!empty($reasonUrl))
                                                <div class="mt-2">
                                                    <a href="{{ $reasonUrl }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-external-link-alt"></i> View Link
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> No reasons added.
                        </div>
                    @endif
                </div>

                <hr class="my-4">

                <!-- Status -->
                <div class="mb-2">
                    <h6 class="text-muted text-uppercase fw-bold mb-3">Status</h6>
                    @if($row->status)
                        <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                    @else
                        <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                    @endif
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> {{ __('btn_close') }}</button>
            </div>
        </div>
    </div>
</div>
