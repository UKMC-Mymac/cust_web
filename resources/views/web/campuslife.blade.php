@extends('web.custom.layouts.app')
@section('title', __('Campus Life'))

@section('content')

    <section class="bg-body-tertiary py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($campuslife as $item)
                    @php
                        $itemImage = !empty($item->attach)
                            ? asset('uploads/campus-life/' . $item->attach)
                            : asset('dist/images/homepage/news-1.jpg');
                        $itemSlug = $item->slug;
                        $itemTitle = $item->title;
                        $itemSummary = \Illuminate\Support\Str::limit(
                            strip_tags($item->feature_text ?? $item->description ?? ''),
                            120,
                            ' ...'
                        );
                        $itemRoute = route('campus-life.single', ['slug' => $itemSlug]);
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <article class="card h-100 border-0 shadow-sm bg-white overflow-hidden">
                            <div class="position-relative">
                                <a href="{{ $itemRoute }}" class="d-block">
                                    <img src="{{ $itemImage }}" class="card-img-top" alt="{{ $itemTitle }}">
                                </a>
                            </div>

                            <div class="card-body p-3 p-md-4 d-flex flex-column">
                                <span class="badge rounded-pill bg-danger text-white align-self-start mb-3">{{ __('Campus Life') }}</span>
                                <h3 class="h4 fw-bold text-body mb-3">
                                    <a class="text-decoration-none text-body" href="{{ $itemRoute }}">{{ $itemTitle }}</a>
                                </h3>

                                @if(!empty($itemSummary))
                                    <p class="text-body-secondary mb-3">{{ $itemSummary }}</p>
                                @endif

                                <div class="mt-auto d-grid gap-2">
                                    {{-- @if(!empty($item->feature_text))
                                        <div class="d-flex align-items-center gap-2 text-body-secondary small">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-book-open"></i>
                                            </span>
                                            <span class="fw-semibold">{{ \Illuminate\Support\Str::limit($item->feature_text, 40, ' ...') }}</span>
                                        </div>
                                    @endif --}}

                                    <a class="btn btn-outline-danger mt-2" href="{{ $itemRoute }}">
                                        {{ __('Read More') }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0">
                            {{ __('No campus life items found.') }}
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row mt-4 mt-md-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $campuslife->appends(Request::only('search'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
