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
                                        @include('admin.web.inc.errors')


                    <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="title">{{ __('field_title') }} <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_title') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="feature_text">{{ __('field_feature_text') }} <span>*</span></label>
                            <input type="text" class="form-control" name="feature_text" id="feature_text" value="{{ old('feature_text') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_feature_text') }}
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="button_text">{{ __('field_button_text') }}</label>
                            <input type="text" class="form-control" name="button_text" id="button_text" value="{{ old('button_text') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="sort_order">{{ __('field_sort_order') }}</label>
                            <input type="number" class="form-control" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="attach">{{ __('field_image') }}: <span>{{ __('image_size', ['height' => 500, 'width' => 850]) }}</span> <span>*</span></label>
                            <input type="file" class="form-control" name="attach" id="attach" value="{{ old('attach') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_image') }}
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">{{ __('field_description') }} <span>*</span></label>
                            <textarea class="form-control texteditor" name="description" id="description" required>{{ old('description') }}</textarea>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_description') }}
                            </div>
                        </div>
                        <!-- Form End -->
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
