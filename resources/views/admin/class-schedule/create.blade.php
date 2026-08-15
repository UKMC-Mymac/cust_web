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
                        <h5>{{ __('modal_add') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                        <a href="{{ route($route.'.create') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <div class="px-4">
                        @include('admin.web.inc.errors')
                    </div>
                    
                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-block">
                        <div class="row">
                            <!-- Dropdown Filters -->
                            <div class="form-group col-md-4">
                                <label for="faculty">{{ __('field_faculty') }} <span>*</span></label>
                                <select class="form-control faculty" name="faculty" id="faculty" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach( $faculties as $faculty )
                                    <option value="{{ $faculty->id }}" @if(old('faculty') == $faculty->id) selected @endif>{{ $faculty->title }}</option>
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
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_program') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="session">{{ __('field_session') }} <span>*</span></label>
                                <select class="form-control session" name="session" id="session" required>
                                    <option value="">{{ __('select') }}</option>
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_session') }}
                                </div>
                            </div>



                            <div class="form-group col-md-4">
                                <label for="batch">{{ __('field_batch') }} <span>* ({{ __('select_multiple') }})</span></label>
                                <select class="form-control select2 batch" name="batches[]" id="batch" multiple required>
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_batch') }}
                                </div>
                            </div>

                            <!-- Basic Fields -->
                            <div class="form-group col-md-4">
                                <label for="title">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_title') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="date">{{ __('field_date') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="date" id="date" value="{{ date('Y-m-d') }}" required>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_date') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="attach">{{ __('field_attach') }}</label>
                                <input type="file" class="form-control" name="attach" id="attach">
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_attach') }}
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="description">{{ __('field_description') }}</label>
                                <textarea class="form-control texteditor" name="description" id="description">{{ old('description') }}</textarea>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_description') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
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
    $(document).ready(function() {
        if ($.fn.select2) {
            $('.select2').select2({
                placeholder: "{{ __('select') }}"
            });
        }
    });

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
                $('.batch').html('').trigger('change');
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
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.title
                    }).appendTo('.batch');
                });
                $('.batch').trigger('change');
            }
        });
    });
</script>

@endsection
