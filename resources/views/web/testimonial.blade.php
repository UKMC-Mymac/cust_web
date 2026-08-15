@extends('web.custom.layouts.app')
@section('title', __('Testimonials'))

@section('content')

    <section class="bg-body-tertiary py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($testimonials as $item)
                    @php
                        $itemImage = !empty($item->attach)
                            ? asset('uploads/testimonial/' . $item->attach)
                            : asset('dist/images/homepage/news-1.jpg');
                        $itemSlug = $item->slug;
                        $itemName = $item->name;
                        $itemSummary = \Illuminate\Support\Str::limit(
                            strip_tags($item->description ?? ''),
                            120,
                            ' ...'
                        );
                        $itemRoute = route('testimonial.single', ['slug' => $itemSlug]);
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <article class="card h-100 border-0 shadow-sm bg-white overflow-hidden">
                            <div class="position-relative p-4 text-center">
                                <img src="{{ $itemImage }}" class="rounded-circle" alt="{{ $itemName }}" style="width:120px; height:120px; object-fit:cover;">
                            </div>

                            <div class="card-body p-3 p-md-4 d-flex flex-column text-center">
                                <h3 class="h5 fw-bold text-body mb-1">{{ $itemName }}</h3>
                                @if(!empty($item->designation))
                                    <div class="small text-body-secondary mb-3">{{ $item->designation }}</div>
                                @endif

                                {{-- @if(!empty($itemSummary))
                                    <p class="text-body-secondary mb-3">{{ $itemSummary }}</p>
                                @endif --}}

                                <div class="mt-auto d-grid gap-2">
                                    <a class="btn btn-outline-danger mt-2" href="{{ $itemRoute }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0">
                            {{ __('No testimonials found.') }}
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row mt-4 mt-md-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $testimonials->appends(Request::only('search'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
