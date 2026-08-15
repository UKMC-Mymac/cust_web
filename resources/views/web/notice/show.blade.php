@extends('web.custom.layouts.app')
@section('title', $notice->title)

@section('content')

<section class="py-5 bg-light">
    <div class="container">

        <!-- Top Navigation -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">

            <a href="{{ route('notice') }}"
               class="text-decoration-none text-dark fw-medium">
                <i class="fa-solid fa-arrow-left me-2"></i>
                {{ __('Back to Notices') }}
            </a>

            <div class="d-flex align-items-center gap-2">

                @php
                    $dayDiff = \Carbon\Carbon::parse($notice->date)
                        ->diffInDays(\Carbon\Carbon::today(), false);

                    $isNew = $dayDiff >= 0 && $dayDiff <= 7;
                @endphp

                @if($notice->categories->isNotEmpty())
                    @foreach($notice->categories as $cat)
                        <span class="badge text-bg-light border px-3 py-2 rounded-pill">
                            {{ $cat->title }}
                        </span>
                    @endforeach
                @else
                    <span class="badge text-bg-light border px-3 py-2 rounded-pill">
                        {{ $notice->category->title ?? __('Notice') }}
                    </span>
                @endif

                @if($isNew)
                    <span class="badge bg-danger px-3 py-2 rounded-pill">
                        {{ __('NEW') }}
                    </span>
                @endif

            </div>

        </div>

        <div class="row g-4">

            <!-- Main Content -->
            <div class="col-lg-8">

                <div class="bg-white border rounded-4 overflow-hidden shadow-sm">

                    <!-- Title Block (moved above attachments) -->
                    <div class="p-4 p-lg-5 border-bottom">
                        <h1 class="fw-bold text-dark mb-2"
                            style="font-size: clamp(2rem, 3vw, 2.4rem); line-height: 1.2;">
                            {{ $notice->title }}
                        </h1>

                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted small">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ \Carbon\Carbon::parse($notice->date)->format('d F Y') }}</span>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ __('Updated') }}: {{ \Carbon\Carbon::parse($notice->updated_at)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Attachment / Media Preview -->
                    @if(!empty($notice->attach))
                        @php
                            $ext = strtolower(pathinfo($notice->attach, PATHINFO_EXTENSION));
                            $attachUrl = asset('uploads/notice/' . $notice->attach);
                        @endphp

                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp','svg']))
                            <div class="border-bottom">
                                <img src="{{ $attachUrl }}" alt="{{ $notice->title }}" class="img-fluid w-100">
                            </div>

                        @elseif($ext === 'pdf')
                            <div class="border-bottom">
                                <div style="min-height:600px;">
                                    <iframe src="{{ $attachUrl }}" width="100%" height="800" style="border:0"></iframe>
                                </div>
                            </div>

                        @else
                            <div class="border-bottom p-4">
                                <p class="mb-2 small text-muted">{{ __('Attachment') }}:</p>
                                <a href="{{ $attachUrl }}" target="_blank" rel="noopener" class="d-inline-flex align-items-center gap-2">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                    {{ basename($notice->attach) }}
                                </a>
                            </div>
                        @endif
                    @endif

                    <!-- Content Body -->
                    <div class="p-4 p-lg-5">

                        <!-- Description -->
                        @if(!empty($notice->description))
                            <div class="notice-content text-secondary lh-lg">
                                {!! $notice->description !!}
                            </div>
                        @endif

                    </div>

                </div>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <div class="sticky-lg-top" style="top: 100px;">

                    <!-- Information Card -->
                    <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

                        <h5 class="fw-bold mb-4">
                            {{ __('Notice Information') }}
                        </h5>

                        <div class="d-flex flex-column gap-4">

                            <div>
                                <small class="text-muted d-block mb-1">
                                    {{ __('Category') }}
                                </small>

                                <div class="fw-semibold text-dark">
                                    @if($notice->categories->isNotEmpty())
                                        {{ $notice->categories->pluck('title')->implode(', ') }}
                                    @else
                                        {{ $notice->category->title ?? __('Notice') }}
                                    @endif
                                </div>
                            </div>

                            <div>
                                <small class="text-muted d-block mb-1">
                                    {{ __('Published Date') }}
                                </small>

                                <div class="fw-semibold text-dark">
                                    {{ \Carbon\Carbon::parse($notice->date)->format('d F Y') }}
                                </div>
                            </div>

                            <div>
                                <small class="text-muted d-block mb-1">
                                    {{ __('Last Updated') }}
                                </small>

                                <div class="fw-semibold text-dark">
                                    {{ \Carbon\Carbon::parse($notice->updated_at)->format('d M Y, h:i A') }}
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white border rounded-4 shadow-sm p-4 mb-4">

                        <h5 class="fw-bold mb-4">
                            {{ __('Quick Links') }}
                        </h5>

                        <div class="d-grid gap-3">

                            <a href="{{ route('notice') }}"
                               class="btn btn-dark rounded-3 py-3">

                                <i class="fa-solid fa-bell me-2"></i>
                                {{ __('All Notices') }}

                            </a>

                            @if($notice->categories->isNotEmpty())
                                @foreach($notice->categories as $cat)
                                    <a href="{{ route('notice', ['category' => $cat->slug]) }}"
                                       class="btn btn-outline-dark rounded-3 py-3">

                                        <i class="fa-solid fa-layer-group me-2"></i>
                                        {{ $cat->title }} {{ __('Notices') }}

                                    </a>
                                @endforeach
                            @elseif(!empty($notice->category_id))
                                <a href="{{ route('notice', ['category' => $notice->category->slug]) }}"
                                   class="btn btn-outline-dark rounded-3 py-3">

                                    <i class="fa-solid fa-layer-group me-2"></i>
                                    {{ $notice->category->title }} {{ __('Notices') }}

                                </a>
                            @endif

                        </div>

                    </div>

                    <!-- Related Notices -->
                    @if($related_notices->count() > 0)

                        <div class="bg-white border rounded-4 shadow-sm p-4">

                            <h5 class="fw-bold mb-4">
                                {{ __('Related Notices') }}
                            </h5>

                            <div class="d-flex flex-column gap-3">

                                @foreach($related_notices as $related)

                                    <a href="{{ route('notice.show', ['notice' => $related->id]) }}"
                                       class="text-decoration-none">

                                        <div class="border rounded-3 p-3 transition">

                                            <small class="text-muted d-block mb-2">
                                                {{ \Carbon\Carbon::parse($related->date)->format('d M Y') }}
                                            </small>

                                            <h6 class="fw-semibold text-dark mb-0"
                                                style="
                                                    line-height: 1.5;
                                                    display: -webkit-box;
                                                    -webkit-line-clamp: 2;
                                                    -webkit-box-orient: vertical;
                                                    overflow: hidden;
                                                ">

                                                {{ $related->title }}

                                            </h6>

                                        </div>

                                    </a>

                                @endforeach

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>
</section>

@endsection

