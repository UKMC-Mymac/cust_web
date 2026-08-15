@extends('web.custom.layouts.app')
@section('title', e($testimonial->name ?? __('Testimonial')))

@section('social_meta_tags')
    @php
        $item = $testimonial;
        $itemUrl = route('testimonial.single', ['slug' => $item->slug]);
        $itemImage = !empty($item->attach)
            ? asset('uploads/testimonial/' . $item->attach)
            : asset('dist/images/homepage/news-1.jpg');
        $itemSummary = \Illuminate\Support\Str::limit(strip_tags($item->description ?: ''), 160, ' ...');
    @endphp

    @if(isset($setting))
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $setting->title }}">
    <meta property="og:title" content="{{ $item->name }}">
    <meta property="og:description" content="{{ $itemSummary }}">
    <meta property="og:url" content="{{ $itemUrl }}">
    <meta property="og:image" content="{{ $itemImage }}">
    @endif
@endsection

@section('content')

    <section class="py-5 bg-body-tertiary overflow-hidden">
        <div class="container">
            <div class="row g-4 g-xl-5 align-items-start">
                <div class="col-lg-8">
                    <article>
                        <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
                            <div class="d-flex align-items-center gap-4 mb-4">
                                <img src="{{ $itemImage }}" alt="{{ $item->name }}" class="rounded-circle" style="width:120px; height:120px; object-fit:cover;">
                                <div>
                                    <h2 class="h4 fw-bold mb-1">{{ $item->name }}</h2>
                                    @if(!empty($item->designation))
                                        <div class="small text-body-secondary">{{ $item->designation }}</div>
                                    @endif
                                    @if(!empty($item->rating))
                                        <div class="mt-2 text-warning">
                                            {!! str_repeat('<i class="fa-solid fa-star"></i>', (int)$item->rating) !!}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="lh-lg fs-6 text-body-secondary">
                                {!! $item->description !!}
                            </div>

                            <a class="btn btn-danger mt-4 d-inline-flex align-items-center gap-2" href="{{ route('testimonial') }}">
                                <i class="fa-solid fa-arrow-left"></i>
                                {{ __('btn_back') }}
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

@endsection
