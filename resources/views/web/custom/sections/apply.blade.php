<style>
    .apply-stadum-titlebox .sub-title::before,
    .apply-stadum-titlebox .sub-title::after {
        background-color: #ffffff !important;
    }
</style>
<section class="apply-stadum-area bg-title position-relative space overflow-hidden">
    <div class="container">
        <div class="row gy-4 align-items-center justify-content-between">
            <div class="col-xl-6 order-1 order-xl-0">
                <div class="apply-stadum-titlebox title-area">
                    @isset($contentSections['apply'])
                    <div class="sec-title-wrap">
                        <span class="sub-title text-white text-anim">{{ $contentSections['apply']->subtitle }}</span>
                        <h2 class="sec-title text-white text-anim2">{{ $contentSections['apply']->title }}</h2>
                    </div>
                    @endisset

                    @isset($apply->description)
                        <div class="box-text-wrap">
                            <p class="box-text text-white mt-25 wow fadeInUp" data-wow-delay=".2s">
                                {{ $apply->description }}
                            </p>
                        </div>  
                    @endisset
                  
                </div>
                <div class="apply-stadum-wrapp">
                    <div class="apply-stadum-box">
                        @php
                            $applyItems = is_array($apply->items ?? null) ? $apply->items : (json_decode($apply->items ?? '[]', true) ?? []);
                            $applyItemColumns = count($applyItems) ? array_chunk($applyItems, (int) ceil(count($applyItems) / 2)) : [];
                        @endphp

                        @forelse($applyItemColumns as $column)
                            <div class="checklist">
                                <ul class="list-unstyled">
                                    @foreach($column as $item)
                                        @php
                                            $delay = 0.2 + (($loop->parent->index * 0.4) + ($loop->index * 0.1));
                                            $text = is_array($item) ? ($item['title'] ?? $item['value'] ?? '') : $item;
                                            $text = is_string($text) ? $text : '';
                                        @endphp
                                        @if(trim($text) !== '')
                                            <li class="wow fadeInUp" data-wow-delay=".{{ str_replace('.', '', number_format($delay, 1)) }}s">{{ $text }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @empty
                            {{-- <div class="checklist">
                                <ul class="list-unstyled">
                                    <li class="text-white">No apply items available.</li>
                                </ul>
                            </div> --}}
                        @endforelse
                    </div>
                    <div class="apply-stadum-action th-btn-wrap wow fadeInUp" data-wow-delay=".10s">
                        @php
                            $link = $apply->url ?? '#';
                            if (!empty($apply->page_id)) {
                                $page = \App\Models\Web\Page::find($apply->page_id);
                                if ($page && \Illuminate\Support\Facades\Route::has('page.single')) {
                                    try {
                                        $link = route('page.single', $page->slug);
                                    } catch (\Exception $e) {
                                        $link = url('page/' . $page->slug);
                                    }
                                }
                            } elseif (!empty($apply->route_name)) {
                                try {
                                    $link = route($apply->route_name);
                                } catch (\Exception $e) {
                                    $link = $apply->url ?? '#';
                                }
                            }
                        @endphp
                        <a href="{{ $link }}" class="th-btn th-icon white-hover">
                            {{ $apply->button_text ?? 'More About Admission' }}
                        </a>
                    </div>
                </div>
            </div>
            @isset($apply->attach)
            <div class="col-xl-6 order-0 order-xl-1">
                <div class="apply-stadum-thumb reveal">
                    <img src="{{ asset('uploads/apply/' . $apply->attach) }}" alt="image" class="">
                </div>
            </div>
            @endisset
        </div>
    </div>
    <span class="apply-stadum-shape wow fadeInRight" data-wow-delay=".3s"></span>
</section>
