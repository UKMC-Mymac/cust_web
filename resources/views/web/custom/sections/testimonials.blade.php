<div id="testimonial_section" class="story-area-1 overflow-hidden space-top">
    <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-center">
            <div class="col-lg-8 col-12">
                @isset($contentSections['testimonial'])
                    @php
                        $section = $contentSections['testimonial'];
                    @endphp
                <div class="title-area text-center text-lg-start">
                    <span class="sub-title text-anim">{{ $section->subtitle}}</span>
                    <h2 class="sec-title text-anim2">{{$section->title}}</h2>
                </div>
                @endisset
            </div>
            <div class="col-auto align-self-end">
                <div class="sec-btn wow fadeInUp" data-wow-delay=".3s">
                    <a href="{{ route('testimonial') }}" class="th-btn style-border1 th-icon">Discover More Stories</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="swiper th-slider story-slider1" id="storySlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"1400":{"slidesPerView":"5"},"1200":{"slidesPerView":"4"},"992":{"slidesPerView":"4"},"768":{"slidesPerView":"3"},"576":{"slidesPerView":"2"}},"spaceBetween":"0","pagination":{"el":".th-pag-testimonial","type":"bullets","clickable":true}}'>
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="story-card">
                        <div class="box-img">
                            <img src="{{ asset('uploads/testimonial/' . $testimonial['attach']) }}" alt="testimonial">
                        </div>
                        <div class="story-content story-content-before-hover">
                            <h3 class="box-title"><a href="#">{{ $testimonial['name'] }}</a></h3>
                        </div>
                        <div class="story-content hover-style">
                            <div class="quote-icon">
                                <img src="{{ asset('dist/img/icon/quote.svg') }}" alt="quote">
                            </div>
                            <p class="box-text">
                                {{ $testimonial['description'] }}
                            </p>
                            <h3 class="box-title"><a href="#">{{ $testimonial['name'] }}</a></h3>
                             <p class="box-designation text-white">{{ $testimonial['designation'] }}</p>                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="th-pag-testimonial d-flex justify-content-center gap-1 pt-1"></div>
        </div>
    </div>
</div>
