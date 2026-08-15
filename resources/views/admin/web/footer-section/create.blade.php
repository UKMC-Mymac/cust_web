@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle"></i> Create New Footer Section
                        </h5>
                    </div>
                                        @include('admin.web.inc.errors')


                    <form method="POST" action="{{ route($route.'.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-block">

                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Section Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g., Useful Links, Resources, About Us" required autofocus>
                                <small class="text-muted">This title will appear as a heading in the footer</small>
                                @error('title')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="sort_order" class="form-label">Display Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" placeholder="0, 1, 2, ..." required>
                                <small class="text-muted">Lower numbers appear first. Example: 0 (first), 1 (second), 2 (third)</small>
                                @error('sort_order')
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
                                        Active (show in footer)
                                    </label>
                                </div>
                                <small class="text-muted">Inactive sections won't appear in the website footer</small>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Section
                            </button>
                            <a href="{{ route($route.'.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Info Card -->
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle"></i> Tips
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="small mb-0">
                            <li>After creating a section, you can add links to it</li>
                            <li>Each section is independent and can have multiple links</li>
                            <li>Use clear, descriptive titles for better UX</li>
                            <li>You can edit or delete sections anytime</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
