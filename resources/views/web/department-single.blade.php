@extends('web.custom.layouts.app')
@section('title', $department->title)

@section('social_meta_tags')
    @php
        $itemImage = !empty($department->attach)
            ? asset('uploads/department/' . $department->attach)
            : asset('dist/images/homepage/news-1.jpg');
        $itemSummary = \Illuminate\Support\Str::limit(
            strip_tags($department->short_description ?? ''),
            160,
            ' ...'
        );
        $itemUrl = route('department.programs', ['slug' => $department->slug]);
    @endphp

    @if(isset($setting))
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $setting->title }}">
    <meta property="og:title" content="{{ $department->title }}">
    <meta property="og:description" content="{{ $itemSummary }}">
    <meta property="og:url" content="{{ $itemUrl }}">
    <meta property="og:image" content="{{ $itemImage }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{!! '@'.str_replace(' ', '', $setting->title) !!}">
    <meta name="twitter:creator" content="@HiTechParks">
    <meta name="twitter:url" content="{{ $itemUrl }}">
    <meta name="twitter:title" content="{{ $department->title }}">
    <meta name="twitter:description" content="{{ $itemSummary }}">
    <meta name="twitter:image" content="{{ $itemImage }}">
    @endif
@endsection

@section('content')

    <section class="bg-body-tertiary py-5 overflow-hidden">
        <div class="container">
            <!-- Department Details Header -->
            <div class="row g-4 mb-5 align-items-center">
                <div class="col-md-5">
                    <figure class="position-relative overflow-hidden rounded shadow-sm bg-white mb-0">
                        <img class="img-fluid w-100" src="{{ $itemImage }}" alt="{{ $department->title }}">
                    </figure>
                </div>
                <div class="col-md-7">
                    <span class="badge rounded-pill bg-danger text-white mb-2">{{ __('Department') }}</span>
                    <h2 class="display-6 fw-bold lh-sm mb-3 text-body">{{ $department->title }}</h2>
                    @if(!empty($department->short_description))
                        <p class="text-body-secondary lh-lg fs-5 mb-4">{{ $department->short_description }}</p>
                    @endif
                    @if($department->school)
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small">{{ __('School:') }}</span>
                            <a href="{{ route('academic.single', ['slug' => $department->school->slug]) }}" class="fw-semibold text-danger text-decoration-none">
                                {{ $department->school->title }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <hr class="my-5 border-light-subtle">

            <!-- Programs List -->
            <h3 class="h3 fw-bold mb-4 text-body">{{ __('Offered Programs') }}</h3>
            
            <div class="row g-4">
                @forelse($courses as $item)
                    @php
                        $itemImage = !empty($item->attach)
                            ? asset('uploads/course/' . $item->attach)
                            : asset('dist/images/homepage/news-1.jpg');
                        $itemRoute = route('program.single', ['slug' => $item->slug]);
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <article class="card h-100 border-0 shadow-sm bg-white overflow-hidden">
                            <div class="position-relative">
                                <a href="{{ $itemRoute }}" class="d-block">
                                    <img src="{{ $itemImage }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                                </a>
                            </div>

                            <div class="card-body p-3 p-md-4 d-flex flex-column">
                                <span class="badge rounded-pill bg-danger text-white align-self-start mb-3">{{ __('Program') }}</span>
                                <h3 class="h5 fw-bold text-body mb-3">
                                    <a class="text-decoration-none text-body hover-danger" href="{{ $itemRoute }}">{{ $item->title }}</a>
                                </h3>

                                @if(!empty($item->feature_text))
                                    <p class="text-body-secondary small mb-3">{{ \Illuminate\Support\Str::limit(strip_tags($item->feature_text), 120) }}</p>
                                @elseif(!empty($item->description))
                                    <p class="text-body-secondary small mb-3">{{ \Illuminate\Support\Str::limit(strip_tags($item->description), 120) }}</p>
                                @endif

                                <div class="mt-auto pt-3 border-top d-grid gap-2">
                                    @if(!empty($item->duration))
                                        <div class="d-flex align-items-center gap-2 text-body-secondary small mb-1">
                                            <i class="fa-solid fa-clock text-danger"></i>
                                            <span><strong>{{ __('Duration:') }}</strong> {{ $item->duration }}</span>
                                        </div>
                                    @endif

                                    @if(!empty($item->credits))
                                        <div class="d-flex align-items-center gap-2 text-body-secondary small mb-2">
                                            <i class="fa-solid fa-book text-danger"></i>
                                            <span><strong>{{ __('Credits:') }}</strong> {{ $item->credits }}</span>
                                        </div>
                                    @endif

                                    <a class="btn btn-outline-danger btn-sm mt-2" href="{{ $itemRoute }}">
                                        {{ __('View Details') }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0">
                            {{ __('No programs found under this department.') }}
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="row mt-4 mt-md-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
