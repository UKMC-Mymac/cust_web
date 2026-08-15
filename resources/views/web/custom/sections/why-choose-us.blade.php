<section id="why_choose_us" class="why-area why-bg position-relative space overflow-hidden">
    <div class="why-shape jump shape-mockup" data-left="0%" data-bottom="10%">
        <img src="{{ asset('dist/img/shape/why-1-1.png') }}" alt="shape">
    </div>
    <div class="container">
        <div class="row gy-4">
            <div class="col-xl-8">
                @isset($contentSections['why_choose_us'])
                    @php
                        $why_choose_us_section = $contentSections['why_choose_us'];
                    @endphp
                    <div class="title-area text-center text-lg-start">
                        <span class="sub-title text-anim">{{ $why_choose_us_section->subtitle}}</span>
                        <h2 class="sec-title text-anim2">{{ $why_choose_us_section->title }}</span></h2>
                    </div>
                @endisset

                <div class="row gy-60">
                    @php
                        $reasons = $why_choose_us->items ?? [];
                    @endphp
                    @foreach($reasons as $reason)
                    @php
                        $delay = number_format((($loop->iteration) * 0.2), 1);
                        $link = $reason['url'] ?? '#';
                        if (!empty($reason['page_id'])) {
                            $page = \App\Models\Web\Page::find($reason['page_id']);
                            if ($page) {
                                if (\Illuminate\Support\Facades\Route::has('page.single')) {
                                    try {
                                        $link = route('page.single', $page->slug);
                                    } catch (Exception $e) {
                                        $link = url('page/' . $page->slug);
                                    }
                                } else {
                                    $link = url('page/' . $page->slug);
                                }
                            }
                        } elseif (!empty($reason['route_name'])) {
                            try {
                                $link = route($reason['route_name']);
                            } catch (\Exception $e) {
                                $link = $reason['url'] ?? '#';
                            }
                        }
                    @endphp
                    <div class="col-lg-6 col-md-6">
                        <div class="why-card wow fadeInUp" data-wow-delay="{{ $delay }}s">
                            <div class="why-content">
                                <div class="why-titlebox">
                                    <span class="why-number position-relative">{{ $reason['number'] }}</span>
                                    <h3 class="box-title">
                                        <a href="{{ $link }}">{{ $reason['title'] }}</a>
                                    </h3>
                                </div>
                                <div class="box-text-wrap">
                                    <p class="box-text">
                                        {{ $reason['description'] }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ $link }}" class="th-btn style-border1 th-icon mt-40">{{ $reason['button_text'] ?? 'Explore More' }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4">
                <div class="why-video">
                    <div class="why-video-bg overflow-hidden gsap-parallax">
                        <img src="{{ asset('uploads/why-choose-us/' . $why_choose_us->attach) }}" alt="image">
                        <div class="why-video-btn">
                            <a href="{{ $why_choose_us->url }}" class="play-btn popup-video">
                                <i class="fa-sharp fa-solid fa-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
