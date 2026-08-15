@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $section_name }}</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate action="{{ route('admin.content-section.store', $key) }}" method="post">
                            @csrf
                            <input type="hidden" name="return_url" value="{{ $return_url ?? url()->previous() }}">

                            <!-- Title -->
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">{{ __('field_title') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" 
                                       value="{{ old('title', $section?->title ?? '') }}" 
                                       placeholder="Main heading" required>

                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Subtitle -->
                            <div class="form-group mb-3">
                                <label for="subtitle" class="form-label">Subtitle</label>
                                <input type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" id="subtitle" 
                                       value="{{ old('subtitle', $section?->subtitle ?? '') }}" 
                                       placeholder="e.g., ACADEMICS">

                                @error('subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">{{ __('field_description') }}</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="4" placeholder="Section description">{{ old('description', $section?->description ?? '') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                                           @if(old('status', $section?->status ?? 1) == 1) checked @endif>
                                    <label class="form-check-label" for="status">
                                        {{ __('field_status') }} - {{ __('status_active') }}
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="card-footer d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> {{ __('btn_save') }}
                                </button>

                                <a href="{{ $return_url ?? url()->previous() }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('btn_cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
