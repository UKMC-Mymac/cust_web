@extends('web.custom.layouts.app')
@section('title', 'Academic Calendars')

@section('content')

<section class="py-5 bg-light">
    <div class="container">
    
        <!-- Page Header -->
        <div class="row mb-4 align-items-center">
            <div class="col-lg-6">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width: 42px; height: 42px;">
                        <i class="fa-solid fa-calendar-days text-white"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">
                            {{ __('Academic Calendars') }}
                        </h3>
                        <small class="text-muted">
                            {{ __('Search and view publication of academic calendars') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card border rounded-3 shadow-sm mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('academic-calendar') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-9">
                            <label for="session" class="form-label small fw-semibold text-muted">{{ __('field_session') }}</label>
                            <select class="form-select" name="session" id="session">
                                <option value="">{{ __('All Sessions') }}</option>
                                @foreach($sessions as $session)
                                <option value="{{ $session->id }}" @selected($selected_session == $session->id)>{{ $session->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> {{ __('Search') }}
                            </button>
                             @if($selected_session)
                                <a href="{{ route('academic-calendar') }}" class="btn btn-outline-secondary py-2" title="Reset Filters">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- List -->
        <div class="bg-white rounded-3 shadow-sm overflow-hidden border">

            @forelse($results as $result)
                @php
                    $itemRoute = route('academic-calendar.show', ['academicCalendar' => $result->id]);
                    $dayDiff = \Carbon\Carbon::parse($result->date)
                        ->diffInDays(\Carbon\Carbon::today(), false);
                    $isNew = $dayDiff >= 0 && $dayDiff <= 7;
                @endphp

                <a href="{{ $itemRoute }}" class="text-decoration-none text-dark">
                    <div class="p-4 border-bottom result-row-item">
                        <div class="row align-items-center g-3">
                            <!-- Date -->
                            <div class="col-auto">
                                <div class="text-center bg-light rounded-3 px-3 py-2 border" style="min-width: 72px;">
                                    <div class="fw-bold text-success fs-4 lh-1">
                                        {{ \Carbon\Carbon::parse($result->date)->format('d') }}
                                    </div>
                                    <small class="text-muted text-uppercase">
                                        {{ \Carbon\Carbon::parse($result->date)->format('M Y') }}
                                    </small>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="col">
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                    @if($result->session)
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                            {{ __('field_session') }}: {{ $result->session->title }}
                                        </span>
                                    @endif
                                    @if($isNew)
                                        <span class="badge bg-danger">
                                            {{ __('NEW') }}
                                        </span>
                                    @endif
                                </div>

                                <h5 class="fw-semibold mb-1">
                                    {{ $result->title }}
                                </h5>

                                <small class="text-muted">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($result->date)->format('l, d F Y') }}
                                </small>
                            </div>

                            <!-- Action -->
                            <div class="col-auto">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fa-solid fa-arrow-right text-muted small"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fa-solid fa-file-invoice fa-3x text-muted"></i>
                    </div>
                    <h5 class="fw-bold mb-2">
                        {{ __('No Academic Calendars Found') }}
                    </h5>
                    <p class="text-muted mb-0">
                        {{ __('Try adjusting your filter settings or search criteria.') }}
                    </p>
                </div>
            @endforelse

        </div>

        <!-- Pagination -->
        @if($results->count() > 0 || $results->total() > 0)
            <div class="d-flex justify-content-center mt-4">
                {{ $results->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif

    </div>
</section>

<style>
    .result-row-item {
        transition: background-color 0.15s ease-in-out;
    }
    .result-row-item:hover {
        background-color: #f8fafc;
    }
</style>

@endsection
