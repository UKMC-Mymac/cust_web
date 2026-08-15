@extends('web.custom.layouts.app')
@section('title', __('Programs'))

@section('content')

    <section class="bg-body-tertiary py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($courses as $item)
                    @php
                        $itemImage = !empty($item->attach)
                            ? asset('uploads/course/' . $item->attach)
                            : asset('dist/images/homepage/news-1.jpg');
                        $itemSlug = $item->slug;
                        $itemTitle = $item->title;
                        $itemSummary = \Illuminate\Support\Str::limit(
                            strip_tags($item->feature_text ?? $item->description ?? ''),
                            120,
                            ' ...'
                        );
                        $itemRoute = route('program.single', ['slug' => $itemSlug]);
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <article class="card h-100 border-0 shadow-sm bg-white overflow-hidden">
                            <div class="position-relative">
                                <a href="{{ $itemRoute }}" class="d-block">
                                    <img src="{{ $itemImage }}" class="card-img-top" alt="{{ $itemTitle }}" style="height: 200px; object-fit: cover;">
                                </a>
                            </div>

                            <div class="card-body p-3 p-md-4 d-flex flex-column">
                                <span class="badge rounded-pill bg-danger text-white align-self-start mb-3">{{ __('Program') }}</span>
                                <h3 class="h4 fw-bold text-body mb-3">
                                    <a class="text-decoration-none text-body hover-danger" href="{{ $itemRoute }}">{{ $itemTitle }}</a>
                                </h3>

                                @if(!empty($itemSummary))
                                    <p class="text-body-secondary mb-3">{{ $itemSummary }}</p>
                                @endif

                                <div class="mt-auto d-grid gap-2 pt-3 border-top">
                                    @if($item->department)
                                        <div class="d-flex align-items-start gap-2 text-body-secondary small mb-1">
                                            <i class="fa-solid fa-building text-danger mt-1"></i>
                                            <span>{{ $item->department->title }}</span>
                                        </div>
                                    @endif
                                    
                                    @if(!empty($item->duration))
                                        <div class="d-flex align-items-center gap-2 text-body-secondary small mb-1">
                                            <i class="fa-solid fa-clock text-danger"></i>
                                            <span><strong>{{ __('Duration:') }}</strong> {{ $item->duration }}</span>
                                        </div>
                                    @endif

                                    <a class="btn btn-outline-danger mt-2" href="{{ $itemRoute }}">
                                        {{ __('View Details') }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0">
                            {{ __('No programs found.') }}
                        </div>
                    </div>
                @endforelse
            </div>

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
