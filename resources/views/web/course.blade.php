@extends('web.custom.layouts.app')
@section('title', __('Academics'))

@section('content')

    <section class="bg-body-tertiary py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($schools as $item)
                    @php
                        $itemImage = !empty($item->attach)
                            ? asset('uploads/school/' . $item->attach)
                            : asset('dist/images/homepage/news-1.jpg');
                        $itemSlug = $item->slug;
                        $itemTitle = $item->title;
                        $itemRoute = route('academic.single', ['slug' => $itemSlug]);
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <article class="card h-100 border-0 shadow-sm bg-white overflow-hidden">
                            <div class="position-relative">
                                <a href="{{ $itemRoute }}" class="d-block">
                                    <img src="{{ $itemImage }}" class="card-img-top" alt="{{ $itemTitle }}">
                                </a>
                            </div>

                            <div class="card-body p-3 p-md-4 d-flex flex-column">
                                <span class="badge rounded-pill bg-danger text-white align-self-start mb-3">{{ __('School') }}</span>
                                <h3 class="h4 fw-bold text-body mb-3">
                                    <a class="text-decoration-none text-body" href="{{ $itemRoute }}">{{ $itemTitle }}</a>
                                </h3>

                                @if(!empty($item->short_description))
                                    <div class="text-body-secondary mb-3">{!! $item->short_description !!}</div>
                                @endif

                                <div class="mt-auto d-grid gap-2">
                                    <a class="btn btn-outline-danger mt-2" href="{{ $itemRoute }}">
                                        {{ __('View More') }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0">
                            {{ __('No schools found.') }}
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row mt-4 mt-md-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $schools->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection