@extends('web.custom.layouts.app')
@section('title', __('navbar_event'))

@section('content')

    <section class="bg-body-tertiary py-5">
        <div class="container">
            {{-- <div class="row justify-content-center mb-4 mb-md-5">
                <div class="col-lg-8 text-center">
                    <span class="badge rounded-pill bg-danger text-white mb-3">{{ __('navbar_event') }}</span>
                    <h1 class="display-5 fw-bold text-body mb-3">{{ __('navbar_event') }}</h1>
                    <p class="lead text-body-secondary mb-0">{{ __('Stay updated with upcoming university events, academic gatherings, and campus activities.') }}</p>
                </div>
            </div> --}}

            <div class="row g-4">
                @forelse($events as $event)
                    @php
                        $eventImage = !empty($event->attach)
                            ? asset('uploads/web-event/'.$event->attach)
                            : asset('dist/images/homepage/news-1.jpg');
                        $eventDate = \Carbon\Carbon::parse($event->date);
                        $eventTimeLabel = null;

                        if (!empty($event->time)) {
                            $timeFormat = $setting->time_format ?? 'h:i A';
                            $eventTimeLabel = date($timeFormat, strtotime($event->time));
                        }

                        $eventSummary = \Illuminate\Support\Str::limit(strip_tags($event->feature_text ?? ''), 120, ' ...');
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <article class="card h-100 border-0 shadow-sm bg-white overflow-hidden">
                            <div class="position-relative">
                                <a href="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}" class="d-block">
                                    <img src="{{ $eventImage }}" class="card-img-top" alt="{{ $event->title }}">
                                </a>
                                <div class="position-absolute top-0 start-0 m-3 p-3 rounded bg-danger text-white text-center shadow-sm">
                                    <strong class="d-block h2 lh-1 mb-1">{{ $eventDate->format('d') }}</strong>
                                    <span class="d-block small fw-bold text-uppercase">{{ $eventDate->format('M') }}</span>
                                </div>
                                @if(!empty($event->pinned))
                                    <div class="position-absolute top-0 end-0 m-3 p-2 rounded bg-warning text-dark text-center shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" title="{{ __('field_pinned') }}: {{ $event->pinned }}">
                                        <i class="fa-solid fa-thumbtack"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body p-3 p-md-4 d-flex flex-column">
                                <span class="badge rounded-pill bg-danger text-white align-self-start mb-3">{{ __('navbar_event') }}</span>
                                <h3 class="h5 fw-bold text-body mb-3">
                                    <a class="text-decoration-none text-body" href="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}">{{ \Illuminate\Support\Str::limit($event->title, 100) }}</a>
                                </h3>

                                @if(!empty($eventSummary))
                                    <p class="text-body-secondary mb-3">{{ $eventSummary }}</p>
                                @endif

                                <div class="mt-auto d-grid gap-2">
                                    <div class="d-flex align-items-center gap-2 text-body-secondary small">
                                        <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                            <i class="fa-regular fa-calendar-days"></i>
                                        </span>
                                        <span class="fw-semibold">{{ $eventDate->format('d F, Y') }}</span>
                                    </div>

                                    @if(!empty($eventTimeLabel))
                                        <div class="d-flex align-items-center gap-2 text-body-secondary small">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-clock"></i>
                                            </span>
                                            <span class="fw-semibold">{{ $eventTimeLabel }}</span>
                                        </div>
                                    @endif

                                    @if(!empty($event->address))
                                        <div class="d-flex align-items-center gap-2 text-body-secondary small">
                                            <span class="btn btn-light text-danger border rounded d-inline-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </span>
                                            <span class="fw-semibold">{{ $event->address }}</span>
                                        </div>
                                    @endif

                                    <a class="btn btn-outline-danger mt-2" href="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}">
                                        {{ __('Read More') }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0">
                            {{ __('No events found.') }}
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row mt-4 mt-md-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $events->appends(Request::only('search'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection