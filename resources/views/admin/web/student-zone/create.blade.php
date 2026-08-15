@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle"></i> Create New Zone
                        </h5>
                    </div>
                                        @include('admin.web.inc.errors')


                    <form method="POST" action="{{ route($route.'.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-block">

                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Zone Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g., Student Portal" required autofocus>
                                @error('title')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="icon_url" class="form-label">Zone Icon</label>
                                <input type="file" class="form-control @error('icon_url') is-invalid @enderror" id="icon_url" name="icon_url" accept="image/*">
                                <small class="text-muted">Upload a PNG or JPG image. Leave blank to use default icon (st-zone-N.png)</small>
                                @error('icon_url')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Link To</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Link to Page</label>
                                        <select class="form-control" name="page_id" id="page_id">
                                            <option value="">Select Page</option>
                                            @foreach ($pages as $page)
                                                <option value="{{ $page->id }}" {{ old('page_id') == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Internal Link</label>
                                        <select class="form-control" name="route_name" id="route_name">
                                            <option value="">Select Internal Link</option>
                                            @foreach ($internalRoutes as $routeName => $label)
                                                <option value="{{ $routeName }}" {{ old('route_name') == $routeName ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Custom URL</label>
                                        <input type="text" class="form-control" id="link" name="link" value="{{ old('link') }}" placeholder="https://example.com">
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">Choose one: page, internal link, or custom URL</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', 0) }}">
                                <small class="text-muted">Lower numbers appear first (0, 1, 2, ...)</small>
                                @error('order')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="status" value="0">
                                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">
                                        Active (show on homepage)
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Zone
                            </button>
                            <a href="{{ route($route.'.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pageSelect = document.getElementById('page_id');
    const routeSelect = document.getElementById('route_name');
    const linkInput = document.getElementById('link');

    function updateExclusive() {
        // If page is selected, disable route and link
        if (pageSelect.value) {
            routeSelect.disabled = true;
            routeSelect.value = '';
            linkInput.disabled = true;
            linkInput.value = '';
        } 
        // If route is selected, disable page and link
        else if (routeSelect.value) {
            pageSelect.disabled = true;
            pageSelect.value = '';
            linkInput.disabled = true;
            linkInput.value = '';
        } 
        // If link is filled, disable page and route
        else if (linkInput.value.trim()) {
            pageSelect.disabled = true;
            pageSelect.value = '';
            routeSelect.disabled = true;
            routeSelect.value = '';
        }
        // None selected, enable all
        else {
            pageSelect.disabled = false;
            routeSelect.disabled = false;
            linkInput.disabled = false;
        }
    }

    pageSelect.addEventListener('change', updateExclusive);
    routeSelect.addEventListener('change', updateExclusive);
    linkInput.addEventListener('input', updateExclusive);

    // Run on page load
    updateExclusive();
});
</script>

@endsection
