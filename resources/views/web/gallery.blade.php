@extends('web.custom.layouts.app')
@section('title', __('navbar_gallery'))
@section('content')

    <section class="bg-body-tertiary py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($galleries as $gallery)
                    @php
                        $image = !empty($gallery->attach)
                            ? asset('uploads/gallery/' . $gallery->attach)
                            : asset('dist/images/homepage/news-1.jpg');
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <article class="card h-100 border-0 shadow-sm bg-white overflow-hidden">
                            <div class="position-relative">
                                <a href="{{ $image }}" class="d-block popup-image">
                                    <img src="{{ $image }}" class="card-img-top" alt="{{ $gallery->title ?? '' }}">
                                </a>
                            </div>

                            <div class="card-body p-3 p-md-4 d-flex flex-column">
                                <h3 class="h5 fw-semibold text-body mb-2">{{ $gallery->title ?? '' }}</h3>
                                <p class="text-body-secondary small mb-3">{{ Illuminate\Support\Str::limit(strip_tags($gallery->description ?? ''), 80, ' ...') }}</p>

                                {{-- <div class="mt-auto d-grid gap-2">
                                    <a class="btn btn-outline-danger mt-2 popup-image" href="{{ $image }}">{{ __('View') }}</a>
                                </div> --}}
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0">
                            {{ __('No gallery items found.') }}
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row mt-4 mt-md-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{-- No pagination for gallery (all items) --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection