@extends('web.custom.layouts.app')
@section('title', __('navbar_faqs'))
@section('content')

    <!-- faq-area -->
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
                        <div class="faq-box">
                            <div class="faq-wrap1">
                                <div class="accordion" id="faqAccordion">

                                    @foreach($faqs as $index => $faq)
                                    <div class="accordion-card wow fadeInUp" data-wow-delay=".{{ $index + 1 }}s">
                                        <div class="accordion-header" id="collapse-item-{{ $index + 1 }}">
                                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index + 1 }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $index + 1 }}">
                                                {{ $faq->title }}
                                            </button>
                                        </div>
                                        <div id="collapse-{{ $index + 1 }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="collapse-item-{{ $index + 1 }}" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <div class="faq-text">{!! $faq->description !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="row mt-4 mt-md-5">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-center">
                                            {{ $faqs->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- faq-area-end -->

@endsection