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
                        <div class="form-group col-md-12">
                            <label for="title">{{ __('field_title') }} <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_title') }}
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="sub_title">{{ __('field_sub_title') }}</label>
                            <textarea class="form-control" name="sub_title" id="sub_title" rows="4">{{ old('sub_title') }}</textarea>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_sub_title') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="video_url">{{ __('field_video_url') ?? 'Video URL' }}</label>
                          <input type="url" class="form-control" name="video_url" id="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                        </div>
                            <div class="form-group col-md-6">
                            <label for="attach">{{ __('field_thumbnail') }}: <span>{{ __('image_size', ['height' => 850, 'width' => 1920]) }}</span> <span>*</span></label>
                            <input type="file" class="form-control" name="attach" id="attach" value="{{ old('attach') }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_thumbnail') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="button_text">{{ __('field_button_text') }}</label>
                            <input type="text" class="form-control" name="button_text" id="button_text" value="{{ old('button_text') }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_button_text') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label class="form-label fw-bold">Button 1 Link</label>
                          <div class="row g-2">
                            <div class="col-md-4">
                              <label for="page_id">Link to Page</label>
                              <select class="form-control" name="page_id" id="page_id">
                                <option value="">Select Page</option>
                                @foreach($pages as $page)
                                  <option value="{{ $page->id }}" @selected(old('page_id') == $page->id)>{{ $page->title }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label for="route_name">Internal Link</label>
                              <select class="form-control" name="route_name" id="route_name">
                                <option value="">Select Internal Link</option>
                                @foreach($internalRoutes as $routeName => $label)
                                  <option value="{{ $routeName }}" @selected(old('route_name') == $routeName)>{{ $label }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label for="button_link">Custom URL</label>
                              <input type="url" class="form-control" name="button_link" id="button_link" value="{{ old('button_link') }}" placeholder="https://example.com">
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="button_text_2">Button Text 2</label>
                          <input type="text" class="form-control" name="button_text_2" id="button_text_2" value="{{ old('button_text_2') }}">
                        </div>

                        <div class="form-group col-md-6">
                          <label class="form-label fw-bold">Button 2 Link</label>
                          <div class="row g-2">
                            <div class="col-md-4">
                              <label for="page_id_2">Link to Page</label>
                              <select class="form-control" name="page_id_2" id="page_id_2">
                                <option value="">Select Page</option>
                                @foreach($pages as $page)
                                  <option value="{{ $page->id }}" @selected(old('page_id_2') == $page->id)>{{ $page->title }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label for="route_name_2">Internal Link</label>
                              <select class="form-control" name="route_name_2" id="route_name_2">
                                <option value="">Select Internal Link</option>
                                @foreach($internalRoutes as $routeName => $label)
                                  <option value="{{ $routeName }}" @selected(old('route_name_2') == $routeName)>{{ $label }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label for="button_link_2">Custom URL</label>
                              <input type="url" class="form-control" name="button_link_2" id="button_link_2" value="{{ old('button_link_2') }}" placeholder="https://example.com">
                            </div>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  function updateButtonLinkState(pageField, routeField) {
    if (!pageField || !routeField) {
      return;
    }

    routeField.disabled = !!pageField.value;
    pageField.disabled = !!routeField.value;
  }

  [
    { pageId: 'page_id', routeId: 'route_name' },
    { pageId: 'page_id_2', routeId: 'route_name_2' },
  ].forEach(function (pair) {
    const pageField = document.getElementById(pair.pageId);
    const routeField = document.getElementById(pair.routeId);

    if (!pageField || !routeField) {
      return;
    }

    pageField.addEventListener('change', function () {
      updateButtonLinkState(pageField, routeField);
    });

    routeField.addEventListener('change', function () {
      updateButtonLinkState(pageField, routeField);
    });

    updateButtonLinkState(pageField, routeField);
  });
});
</script>

@endsection
