@extends('web.custom.layouts.app')
@section('title', 'Class Schedules')

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
                            {{ __('Class Schedules') }}
                        </h3>
                        <small class="text-muted">
                            {{ __('Search and view publication of class schedules') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card border rounded-3 shadow-sm mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('class-schedule') }}" class="result-filter-form">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="faculty" class="form-label small fw-semibold text-muted">{{ __('field_faculty') }}</label>
                            <select class="form-select faculty" name="faculty" id="faculty">
                                <option value="">{{ __('All Departments') }}</option>
                                @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}" @selected($selected_faculty == $faculty->id)>{{ $faculty->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="program" class="form-label small fw-semibold text-muted">{{ __('field_program') }}</label>
                            <select class="form-select program" name="program" id="program">
                                <option value="">{{ __('All Programs') }}</option>
                                @foreach($programs as $program)
                                <option value="{{ $program->id }}" @selected($selected_program == $program->id)>{{ $program->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="session" class="form-label small fw-semibold text-muted">{{ __('field_session') }}</label>
                            <select class="form-select session" name="session" id="session">
                                <option value="">{{ __('All Sessions') }}</option>
                                @foreach($sessions as $session)
                                <option value="{{ $session->id }}" @selected($selected_session == $session->id)>{{ $session->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="batch" class="form-label small fw-semibold text-muted">{{ __('field_batch') }}</label>
                            <select class="form-select batch" name="batch" id="batch">
                                <option value="">{{ __('All Batches') }}</option>
                                @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" @selected($selected_batch == $batch->id)>{{ $batch->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> {{ __('Search') }}
                            </button>
                             @if($selected_faculty || $selected_program || $selected_session || $selected_batch)
                                <a href="{{ route('class-schedule') }}" class="btn btn-outline-secondary py-2" title="Reset Filters">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Result List -->
        <div class="bg-white rounded-3 shadow-sm overflow-hidden border">

            @forelse($results as $result)
                @php
                    $itemRoute = route('class-schedule.show', ['classSchedule' => $result->id]);
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
                                {{-- <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                    @if($result->faculty)
                                        <span class="badge badge-faculty bg-success-subtle text-success border border-success-subtle">
                                            {{ $result->faculty->title }}
                                        </span>
                                    @endif
                                    @if($result->program)
                                        <span class="badge badge-program bg-primary-subtle text-primary border border-primary-subtle">
                                            {{ $result->program->title }}
                                        </span>
                                    @endif
                                    @if($result->session)
                                        <span class="badge badge-session bg-secondary-subtle text-secondary border border-secondary-subtle">
                                            {{ __('field_session') }}: {{ $result->session->title }}
                                        </span>
                                    @endif
                                    @if($result->batches->count() > 0)
                                        @foreach($result->batches as $batch)
                                            <span class="badge badge-batch bg-dark-subtle text-dark border border-dark-subtle">
                                                Batch: {{ $batch->title }}
                                            </span>
                                        @endforeach
                                    @elseif($result->batch)
                                        <span class="badge badge-batch bg-dark-subtle text-dark border border-dark-subtle">
                                            Batch: {{ $result->batch->title }}
                                        </span>
                                    @endif
                                    @if($isNew)
                                        <span class="badge badge-new bg-danger">
                                            {{ __('NEW') }}
                                        </span>
                                    @endif
                                </div> --}}

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
                        {{ __('No Class Schedules Found') }}
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
    /* Override absolute badge positioning from template CSS */
    .result-row-item .badge {
        position: relative !important;
        top: auto !important;
        right: auto !important;
        border-radius: 4px !important;
        display: inline-block !important;
        font-size: 0.85em !important;
        padding: 6px 12px !important;
        font-weight: 500 !important;
    }
    /* Distinct premium colors for each badge type */
    .result-row-item .badge-faculty {
        background-color: #e2f9df !important;
        color: #1e7e34 !important;
        border: 1px solid #c3e6cb !important;
    }
    .result-row-item .badge-program {
        background-color: #e2f0fe !important;
        color: #0056b3 !important;
        border: 1px solid #b8daff !important;
    }
    .result-row-item .badge-session {
        background-color: #f1e6ff !important;
        color: #6f42c1 !important;
        border: 1px solid #e1c2ff !important;
    }
    .result-row-item .badge-batch {
        background-color: #fff3cd !important;
        color: #856404 !important;
        border: 1px solid #ffeeba !important;
    }
    .result-row-item .badge-new {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        border: 1px solid #f5c6cb !important;
    }
</style>

<script src="{{ asset('plugins/jquery/js/jquery.min.js') }}"></script>
<script type="text/javascript">
    "use strict";
    $(".faculty").on('change', function(e){
        e.preventDefault();
        var program = $(".program");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('filter-program') }}",
            data: {
                _token: $('input[name=_token]').val(),
                faculty: $(this).val()
            },
            success: function(response){
                $('option', program).remove();
                $('.program').append('<option value="">{{ __("All Programs") }}</option>');
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.title
                    }).appendTo('.program');
                });
                // reset dependables
                $('.session').html('<option value="">{{ __("All Sessions") }}</option>');
                $('.batch').html('<option value="">{{ __("All Batches") }}</option>');
            }
        });
    });

    $(".program").on('change', function(e){
        e.preventDefault();
        var session = $(".session");
        var batch = $(".batch");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('filter-session') }}",
            data: {
                _token: $('input[name=_token]').val(),
                program: $(this).val()
            },
            success: function(response){
                $('option', session).remove();
                $('.session').append('<option value="">{{ __("All Sessions") }}</option>');
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.title
                    }).appendTo('.session');
                });
            }
        });

        $.ajax({
            type: 'POST',
            url: "{{ route('filter-batch-by-program') }}",
            data: {
                _token: $('input[name=_token]').val(),
                program: $(this).val()
            },
            success: function(response){
                $('option', batch).remove();
                $('.batch').append('<option value="">{{ __("All Batches") }}</option>');
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.title
                    }).appendTo('.batch');
                });
            }
        });
    });
</script>

@endsection
