<section class="academic1-area space overflow-hidden" id="program-sec">
    <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-center">
            <div class="col-lg-9 col-12">
                @isset($contentSections['course'])
                    @php
                        $section = $contentSections['course'];
                    @endphp
                    <div class="title-area text-center text-lg-start mb-75">
                        <span class="sub-title text-anim">{{ $section->subtitle }}</span>
                        <h2 class="sec-title text-anim2">{{$section->title}}</h2>
                    </div>
                @endisset
            </div>
            <div class="col-lg-3 col-12 text-center text-lg-end mb-75">
                <a href="{{ route('program') }}" class="th-btn style-border1 th-icon">View All</a>
            </div>
        </div>
        <div class="academic-wrapp">
            <div class="slider-area">
                <div class="swiper th-slider has-shadow" id="academicSlider2" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"3", "spaceBetween": "24"}},"autoHeight": "true", "autoplay": {"delay": 5000, "disableOnInteraction": false}, "pagination": {"el": ".th-pag2", "type": "bullets", "clickable": true}}'>
                    <div class="swiper-wrapper">
                        @foreach($courses as $course)
                        
                        <div class="swiper-slide">
                            <div class="academic-card">
                                <div class="academic-img">
                                    <a href="{{ route('program.single', ['slug' => $course->slug]) }}">
                                        <img src="{{ asset('uploads/course/' . ($course->attach ?? '')) }}" alt="program image">
                                    </a>
                                    <div class="academic-tag">
                                        <span><i class="fa-solid fa-building"></i> {{ $course->department->title ?? '' }}</span>
                                    </div>
                                </div>
                                <div class="academic-content">
                                    <h3 class="box-title">
                                        <a href="{{ route('program.single', ['slug' => $course->slug]) }}">{{ $course->title }}</a>
                                    </h3>
                                    <p class="box-text style2 mt-2">
                                        {{ $course->feature_text }}
                                    </p>
                                </div>
                                <div class="academic-meta-wrap">
                                    <div class="academic-meta">
                                        <a href="{{ route('program.single', ['slug' => $course->slug]) }}" class="subject">
                                            <i class="fa-solid fa-messages"></i> {{ $course->credits }} Credits
                                        </a>
                                        <a href="{{ route('program.single', ['slug' => $course->slug]) }}" class="duration"><i class="fa-solid fa-clock"></i> {{ $course->duration }}</a>
                                    </div>
                                    <a href="{{ route('program.single', ['slug' => $course->slug]) }}" class="th-btn style-border1 th-icon">Explore More</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="th-pag2 d-flex justify-content-center gap-2 pt-4"></div>
                </div>
            </div>
        </div>
    </div>
</section>
