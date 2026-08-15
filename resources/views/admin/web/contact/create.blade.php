@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                @include('admin.web.inc.errors')

                <form action="{{ route($route.'.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_add') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="title">{{ __('field_title') }} <span>*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="subtitle">{{ __('field_subtitle') }}</label>
                                    <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ old('subtitle') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('field_email') }} <span>*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="phone">{{ __('field_phone') }}</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="website">{{ __('field_website') }}</label>
                                    <input type="text" name="website" id="website" class="form-control" value="{{ old('website') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="address">{{ __('field_address') }}</label>
                                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="map_link">{{ __('field_map_link') }}</label>
                                    <input type="url" name="map_link" id="map_link" class="form-control" value="{{ old('map_link') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status">{{ __('field_status') }} <span>*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>{{ __('active') }}</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>{{ __('inactive') }}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="description">{{ __('field_description') }}</label>
                                    <textarea name="description" id="description" class="form-control texteditor">{{ old('description') }}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">{{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection