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
                    @include('admin.web.inc.errors')

                    <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="label">Label <span>*</span></label>
                            <input type="text" class="form-control" name="label" id="label" value="{{ old('label', $row->label) }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} Label
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="parent_id">Parent Item</label>
                            <select class="form-control" name="parent_id" id="parent_id">
                                <option value="">None</option>
                                @foreach ($parents as $parent)
                                    <option value="{{ $parent->id }}" @if(old('parent_id', $row->parent_id) == $parent->id) selected @endif>{{ $parent->label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="page_id">Page</label>
                            <select class="form-control" name="page_id" id="page_id">
                                <option value="">Select Page</option>
                                @foreach ($pages as $page)
                                    <option value="{{ $page->id }}" @if(old('page_id', $row->page_id) == $page->id) selected @endif>{{ $page->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Select a page or choose an internal link</small>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="route_name">Internal Link</label>
                            <select class="form-control" name="route_name" id="route_name">
                                <option value="">Select Internal Link</option>
                                @foreach (config('navbars.internal_links', []) as $routeName => $label)
                                    <option value="{{ $routeName }}" @if(old('route_name', $row->route_name) == $routeName) selected @endif>{{ $label }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Uses built-in routes and works on any domain</small>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="url">Custom URL</label>
                            <input type="text" class="form-control" name="url" id="url" value="{{ old('url', $row->url) }}" placeholder="https://example.com">
                            <small class="text-muted">Required if no page or internal link is selected</small>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="target">Target</label>
                            <select class="form-control" name="target" id="target">
                                <option value="_self" @if(old('target', $row->target ?: '_self') == '_self') selected @endif>Same Tab</option>
                                <option value="_blank" @if(old('target', $row->target) == '_blank') selected @endif>New Tab</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="status">{{ __('select_status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" @if(old('status', $row->status) == 1) selected @endif>{{ __('status_active') }}</option>
                                <option value="0" @if(old('status', $row->status) == 0) selected @endif>{{ __('status_inactive') }}</option>
                            </select>
                        </div>
                        <!-- Form End -->
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

@endsection
