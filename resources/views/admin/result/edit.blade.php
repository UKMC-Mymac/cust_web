@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <div class="px-4">
                        @include('admin.web.inc.errors')
                    </div>
                    
                    <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-block">
                        <div class="row">
                            <!-- Dropdown Filters -->
                            <div class="form-group col-md-4">
                                <label for="faculty">{{ __('field_faculty') }} <span>*</span></label>
                                <select class="form-control faculty" name="faculty" id="faculty" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach( $faculties as $faculty )
                                    <option value="{{ $faculty->id }}" @if(old('faculty', $row->faculty_id) == $faculty->id) selected @endif>{{ $faculty->title }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_faculty') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="program">{{ __('field_program') }} <span>*</span></label>
                                <select class="form-control program" name="program" id="program" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach( $programs as $program )
                                    <option value="{{ $program->id }}" @if(old('program', $row->program_id) == $program->id) selected @endif>{{ $program->title }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_program') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="session">{{ __('field_session') }} <span>*</span></label>
                                <select class="form-control session" name="session" id="session" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach( $sessions as $session )
                                    <option value="{{ $session->id }}" @if(old('session', $row->session_id) == $session->id) selected @endif>{{ $session->title }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_session') }}
                                </div>
                            </div>



                            <div class="form-group col-md-4">
                                <label for="batch">{{ __('field_batch') }} <span>*</span></label>
                                <select class="form-control batch" name="batch" id="batch" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach( $batches as $batch )
                                    <option value="{{ $batch->id }}" @if(old('batch', $row->batch_id) == $batch->id) selected @endif>{{ $batch->title }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_batch') }}
                                </div>
                            </div>

                            <!-- Basic Fields -->
                            <div class="form-group col-md-4">
                                <label for="title">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $row->title) }}" required>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_title') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="date">{{ __('field_publish_date') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="date" id="date" value="{{ old('date', $row->date) }}" required>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_publish_date') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="attach">{{ __('field_attach') }}</label>
                                <input type="file" class="form-control" name="attach" id="attach">
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_attach') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="status" class="form-label">{{ __('select_status') }}</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1" @selected(old('status', $row->status) == 1)>{{ __('status_active') }}</option>
                                    <option value="0" @selected(old('status', $row->status) == 0)>{{ __('status_inactive') }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="description">{{ __('field_description') }}</label>
                                <textarea class="form-control texteditor" name="description" id="description">{{ old('description', $row->description) }}</textarea>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_description') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                    </div>
                    </form>                   
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

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
                $('.program').append('<option value="">{{ __("select") }}</option>');
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.title
                    }).appendTo('.program');
                });
                // reset dependables
                $('.session').html('<option value="">{{ __("select") }}</option>');
                $('.batch').html('<option value="">{{ __("select") }}</option>');
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
                $('.session').append('<option value="">{{ __("select") }}</option>');
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
                $('.batch').append('<option value="">{{ __("select") }}</option>');
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
