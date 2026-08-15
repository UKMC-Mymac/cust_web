<section class="faq-area-1 position-relative space overflow-hidden">
    <div class="faq-shape1 shape-mockup" data-top="0%" data-left="0%">
        <img src="{{ asset('dist/img/shape/feature-shep-home-1.png') }}" alt="shape">
    </div>
    <div class="faq-shape2 shape-mockup" data-bottom="0%" data-right="0%">
        <img src="{{ asset('dist/img/shape/feature-shep-2-home-1.png') }}" alt="shape">
    </div>
    <div class="faq-shape3 movingX shape-mockup" data-bottom="0%" data-right="2%">
        <img src="{{ asset('dist/img/shape/faq-1-1.png') }}" alt="shape">
    </div>
    <div class="ripple-shape d-none d-xl-block">
        <span class="ripple-1"></span>
        <span class="ripple-2"></span>
        <span class="ripple-3"></span>
        <span class="ripple-4"></span>
        <span class="ripple-5"></span>
    </div>
    <div class="container">
        <div class="row gy-30 gx-30 align-items-center justify-content-center">
            <div class="col-12">
                <div class="faq-content">
                    <div class="row justify-content-lg-between justify-content-center align-items-center mb-40">
                        <div class="col-lg-9 col-12">
                            <div class="faq-wrap">
                                @isset($contentSections['faq'])
                                    @php
                                        $section = $contentSections['faq'];
                                    @endphp
                                <div class="title-area mb-0">
                                    <span class="sub-title text-anim">{{ $section->subtitle }}</span>
                                    <h2 class="sec-title text-anim2">{{ $section->title }}</h2>
                                    <p class="box-text mt-20 wow fadeInUp" data-wow-delay=".3s">
                                        {{ $section->description }}
                                    </p>
                                </div>
                                @endisset
                            </div>
                        </div>
                        <div class="col-lg-3 col-12 text-center text-lg-end mb-40">
                            <a href="{{ route('faq') }}" class="th-btn style-border1 th-icon">Explore All</a>
                        </div>
                    </div>
                    <div class="faq-box">
                        <div class="faq-wrap1">
                            <div class="accordion" id="faqAccordion">

                                @foreach($faqs as $index => $faq)
                                <div class="accordion-card wow fadeInUp" data-wow-delay=".{{ $index + 1 }}s">
                                    <div class="accordion-header" id="collapse-item-{{ $index + 1 }}">
                                        <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index + 1 }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $index + 1 }}">
                                            {{ $faq['title'] }}
                                        </button>
                                    </div>
                                    <div id="collapse-{{ $index + 1 }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="collapse-item-{{ $index + 1 }}" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">{{ $faq['description'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
