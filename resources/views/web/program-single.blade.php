@extends('web.custom.layouts.app')
@section('title', $course->title)

@section('social_meta_tags')
    @php
        $itemImage = !empty($course->attach)
            ? asset('uploads/course/' . $course->attach)
            : asset('dist/images/homepage/news-1.jpg');
        $itemSummary = \Illuminate\Support\Str::limit(
            strip_tags($course->description ?: ($course->feature_text ?? '')),
            160,
            ' ...'
        );
        $itemUrl = route('program.single', ['slug' => $course->slug]);
    @endphp

    @if(isset($setting))
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $setting->title }}">
    <meta property="og:title" content="{{ $course->title }}">
    <meta property="og:description" content="{{ $itemSummary }}">
    <meta property="og:url" content="{{ $itemUrl }}">
    <meta property="og:image" content="{{ $itemImage }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{!! '@'.str_replace(' ', '', $setting->title) !!}">
    <meta name="twitter:creator" content="@HiTechParks">
    <meta name="twitter:url" content="{{ $itemUrl }}">
    <meta name="twitter:title" content="{{ $course->title }}">
    <meta name="twitter:description" content="{{ $itemSummary }}">
    <meta name="twitter:image" content="{{ $itemImage }}">
    @endif
@endsection

@section('content')

    <section class="bg-body-tertiary py-5 overflow-hidden">
        <div class="container">
            <div class="row g-4 g-xl-5 align-items-start">
                <div class="col-lg-8">
                    <article>
                        <figure class="position-relative overflow-hidden rounded shadow-sm bg-white mb-4">
                            <img class="img-fluid w-100" src="{{ $itemImage }}" alt="{{ $course->title }}">
                        </figure>

                        <div class="mb-4">
                            <span class="badge rounded-pill bg-danger text-white mb-3">{{ __('Program') }}</span>
                            <h2 class="display-5 fw-bold lh-sm mb-3 text-body">{{ $course->title }}</h2>
                        </div>

                        <div class="rounded shadow-sm bg-white p-3 p-md-4 lh-lg text-body-secondary mb-4">
                            {!! $course->description !!}
                        </div>

                        @if($course->department)
                            <a class="btn btn-danger d-inline-flex align-items-center gap-2" href="{{ route('department.programs', ['slug' => $course->department->slug]) }}">
                                <i class="fa-solid fa-arrow-left"></i>
                                {{ __('Back to Department') }}
                            </a>
                        @else
                            <a class="btn btn-danger d-inline-flex align-items-center gap-2" href="{{ route('academic') }}">
                                <i class="fa-solid fa-arrow-left"></i>
                                {{ __('Back to Academics') }}
                            </a>
                        @endif
                    </article>
                </div>

                <div class="col-lg-4">
                    <aside class="sticky-lg-top" style="top: 2rem;">
                        <div class="card border-0 shadow-sm mb-4 bg-white">
                            <div class="card-body p-3 p-md-4">
                                <h3 class="h4 fw-bold mb-4 text-body border-bottom pb-2">
                                    {{ __('Program Details') }}
                                </h3>

                                <div class="d-grid gap-3">
                                    @if($course->department)
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-building"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary">{{ __('Department') }}</span>
                                                <strong class="d-block">
                                                    <a href="{{ route('department.programs', ['slug' => $course->department->slug]) }}" class="text-decoration-none text-body hover-danger">
                                                        {{ $course->department->title }}
                                                    </a>
                                                </strong>
                                            </span>
                                        </div>
                                    @endif


                                    @if(!empty($course->duration))
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-clock"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary">{{ __('field_duration') }}</span>
                                                <strong class="d-block">{{ $course->duration }}</strong>
                                            </span>
                                        </div>
                                    @endif

                                    @if(!empty($course->credits))
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-book"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary">{{ __('field_total_credit_hour') }}</span>
                                                <strong class="d-block">{{ $course->credits }}</strong>
                                            </span>
                                        </div>
                                    @endif

                                    @if(!empty($course->semesters))
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-layer-group"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary">{{ __('Semesters') }}</span>
                                                <strong class="d-block">{{ $course->semesters }}</strong>
                                            </span>
                                        </div>
                                    @endif

                                    @if(!empty($course->courses))
                                        <div class="d-flex gap-3 pb-3 border-bottom">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-list-check"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary">{{ __('Total Courses') }}</span>
                                                <strong class="d-block">{{ $course->courses }}</strong>
                                            </span>
                                        </div>
                                    @endif

                                    @if(!empty($course->fee))
                                        <div class="d-flex gap-3">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-tag"></i>
                                            </span>
                                            <span>
                                                <span class="d-block small fw-bold text-uppercase text-body-secondary">{{ __('field_total') }} {{ __('field_fee') }}</span>
                                                <strong class="d-block">{{ round($course->fee, $setting->decimal_place ?? 2) }} {!! $setting->currency_symbol !!}</strong>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

@endsection
