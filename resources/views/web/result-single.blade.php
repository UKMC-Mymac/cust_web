@extends('web.custom.layouts.app')
@section('title', $result->title)

@section('content')

<section class="py-5 bg-light">
    <div class="container">

        <!-- Top Navigation -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <a href="{{ route('result') }}" class="text-decoration-none text-dark fw-medium">
                <i class="fa-solid fa-arrow-left me-2"></i>
                {{ __('Back to Results') }}
            </a>

            <div class="d-flex align-items-center gap-2">
                @php
                    $dayDiff = \Carbon\Carbon::parse($result->date)
                        ->diffInDays(\Carbon\Carbon::today(), false);
                    $isNew = $dayDiff >= 0 && $dayDiff <= 7;
                @endphp

                @if($result->program)
                    <span class="badge text-bg-light border px-3 py-2 rounded-pill">
                        {{ $result->program->title }}
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
                    <!-- Title Block -->
                    <div class="p-4 p-lg-5 border-bottom">
                        <h1 class="fw-bold text-dark mb-2" style="font-size: clamp(2rem, 3vw, 2.4rem); line-height: 1.2;">
                            {{ $result->title }}
                        </h1>

                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted small">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ \Carbon\Carbon::parse($result->date)->format('d F Y') }}</span>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ __('Updated') }}: {{ \Carbon\Carbon::parse($result->updated_at)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Attachment / Media Preview -->
                    @if(!empty($result->attach))
                        @php
                            $ext = strtolower(pathinfo($result->attach, PATHINFO_EXTENSION));
                            $attachUrl = asset('uploads/result/' . $result->attach);
                        @endphp

                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp','svg']))
                            <div class="border-bottom">
                                <img src="{{ $attachUrl }}" alt="{{ $result->title }}" class="img-fluid w-100">
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
                                    {{ basename($result->attach) }}
                                </a>
                            </div>
                        @endif
                    @endif

                    <!-- Content Body -->
                    <div class="p-4 p-lg-5">
                        @if(!empty($result->description))
                            <div class="result-content text-secondary lh-lg">
                                {!! $result->description !!}
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
                            {{ __('Result Information') }}
                        </h5>

                        <div class="d-flex flex-column gap-4">
                            @if($result->faculty)
                            <div>
                                <small class="text-muted d-block mb-1">
                                    {{ __('field_faculty') }}
                                </small>
                                <div class="fw-semibold text-dark">
                                    {{ $result->faculty->title }}
                                </div>
                            </div>
                            @endif

                            @if($result->program)
                            <div>
                                <small class="text-muted d-block mb-1">
                                    {{ __('Program') }}
                                </small>
                                <div class="fw-semibold text-dark">
                                    {{ $result->program->title }}
                                </div>
                            </div>
                            @endif



                            @if($result->batch)
                            <div>
                                <small class="text-muted d-block mb-1">
                                    {{ __('Batch') }}
                                </small>
                                <div class="fw-semibold text-dark">
                                    {{ $result->batch->title }}
                                </div>
                            </div>
                            @endif

                            @if($result->session)
                            <div>
                                <small class="text-muted d-block mb-1">
                                    {{ __('Session') }}
                                </small>
                                <div class="fw-semibold text-dark">
                                    {{ $result->session->title }}
                                </div>
                            </div>
                            @endif

                            <div>
                                <small class="text-muted d-block mb-1">
                                    {{ __('Published Date') }}
                                </small>
                                <div class="fw-semibold text-dark">
                                    {{ \Carbon\Carbon::parse($result->date)->format('d F Y') }}
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
                            <a href="{{ route('result') }}" class="btn btn-dark rounded-3 py-3">
                                <i class="fa-solid fa-graduation-cap me-2"></i>
                                {{ __('All Results') }}
                            </a>

                            @if($result->program)
                                <a href="{{ route('result', ['faculty' => $result->faculty_id, 'program' => $result->program_id]) }}"
                                   class="btn btn-outline-dark rounded-3 py-3">
                                    <i class="fa-solid fa-layer-group me-2"></i>
                                    {{ $result->program->title }} {{ __('Results') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Related Results -->
                    @if($related_results->count() > 0)
                        <div class="bg-white border rounded-4 shadow-sm p-4">
                            <h5 class="fw-bold mb-4">
                                {{ __('Related Results') }}
                            </h5>

                            <div class="d-flex flex-column gap-3">
                                @foreach($related_results as $related)
                                    <a href="{{ route('result.show', ['result' => $related->id]) }}" class="text-decoration-none">
                                        <div class="border rounded-3 p-3 transition related-result-item">
                                            <small class="text-muted d-block mb-2">
                                                {{ \Carbon\Carbon::parse($related->date)->format('d M Y') }}
                                            </small>
                                            <h6 class="fw-semibold text-dark mb-0" style="
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

<style>
    .related-result-item {
        transition: background-color 0.15s ease-in-out;
    }
    .related-result-item:hover {
        background-color: #f8fafc;
    }
</style>

@endsection
