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
                            <div class="form-group col-md-6">
                                <label for="session">{{ __('field_session') }} <span>*</span></label>
                                <select class="form-control" name="session" id="session" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach($sessions as $session)
                                    <option value="{{ $session->id }}" @if(old('session') == $session->id) selected @endif>{{ $session->title }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_session') }}
                                </div>
                            </div>

                            <!-- Basic Fields -->
                            <div class="form-group col-md-6">
                                <label for="title">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_title') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="date">{{ __('field_date') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="date" id="date" value="{{ date('Y-m-d') }}" required>
                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_date') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
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

@endsection
