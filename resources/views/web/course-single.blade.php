@extends('web.custom.layouts.app')
@section('title', $school->title)

@section('social_meta_tags')
    @php
        $itemImage = !empty($school->attach)
            ? asset('uploads/school/' . $school->attach)
            : asset('dist/images/homepage/news-1.jpg');
        $itemSummary = \Illuminate\Support\Str::limit(
            strip_tags($school->description ?: $school->short_description ?: ''),
            160,
            ' ...'
        );
        $itemUrl = route('academic.single', ['slug' => $school->slug]);
    @endphp

    @if(isset($setting))
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $setting->title }}">
    <meta property="og:title" content="{{ $school->title }}">
    <meta property="og:description" content="{{ $itemSummary }}">
    <meta property="og:url" content="{{ $itemUrl }}">
    <meta property="og:image" content="{{ $itemImage }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{!! '@'.str_replace(' ', '', $setting->title) !!}">
    <meta name="twitter:creator" content="@HiTechParks">
    <meta name="twitter:url" content="{{ $itemUrl }}">
    <meta name="twitter:title" content="{{ $school->title }}">
    <meta name="twitter:description" content="{{ $itemSummary }}">
    <meta name="twitter:image" content="{{ $itemImage }}">
    @endif
@endsection

@section('content')

    <section class="bg-body-tertiary py-5 overflow-hidden">
        <div class="container">
            <div class="row g-4 g-xl-5 align-items-start">
                <div class="col-lg-8">
                    <article class="mb-5">
                        <figure class="position-relative overflow-hidden rounded shadow-sm bg-white mb-4">
                            <img class="img-fluid w-100" src="{{ $itemImage }}" alt="{{ $school->title }}">
                        </figure>

                        <div class="mb-4">
                            <span class="badge rounded-pill bg-danger text-white mb-2">{{ __('School') }}</span>
                            <h2 class="display-5 fw-bold lh-sm mb-3 text-body">{{ $school->title }}</h2>
                        </div>

                        <div class="rounded shadow-sm bg-white p-3 p-md-4 lh-lg text-body-secondary mb-4">
                            {!! $school->description !!}
                        </div>

                        <a class="btn btn-danger d-inline-flex align-items-center gap-2" href="{{ route('academic') }}">
                            <i class="fa-solid fa-arrow-left"></i>
                            {{ __('Back to Schools') }}
                        </a>
                    </article>
                </div>

                <div class="col-lg-4">
                    <aside class="sticky-lg-top" style="top: 2rem;">
                        <div class="card border-0 shadow-sm bg-white">
                            <div class="card-body p-3 p-md-4">
                                <h3 class="h4 fw-bold mb-4 text-body border-bottom pb-2">
                                    {{ __('Departments') }}
                                </h3>
                                
                                <div class="d-grid gap-3">
                                    @forelse($departments as $dept)
                                        @php
                                            $deptImage = !empty($dept->attach)
                                                ? asset('uploads/department/' . $dept->attach)
                                                : asset('dist/images/homepage/news-1.jpg');
                                            $deptRoute = route('department.programs', ['slug' => $dept->slug]);
                                        @endphp
                                        <div class="card border border-light-subtle shadow-none">
                                            <img src="{{ $deptImage }}" class="card-img-top" alt="{{ $dept->title }}" style="height: 120px; object-fit: cover;">
                                            <div class="card-body p-3">
                                                <h4 class="h6 fw-bold mb-2">
                                                    <a href="{{ $deptRoute }}" class="text-decoration-none text-body hover-danger">{{ $dept->title }}</a>
                                                </h4>
                                                @if(!empty($dept->short_description))
                                                    <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($dept->short_description, 80) }}</p>
                                                @endif
                                                <a href="{{ $deptRoute }}" class="btn btn-sm btn-outline-danger w-100">{{ __('Explore Programs') }}</a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-3">
                                            {{ __('No departments found.') }}
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

@endsection