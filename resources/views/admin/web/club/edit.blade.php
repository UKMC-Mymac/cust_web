@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-gradient text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-edit"></i> Edit Club Assignment: {{ $row->title }}
                        </h5>
                    </div>
                    @include('admin.web.inc.errors')

                    <form method="POST" action="{{ route($route.'.update', $row->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="card-block">

                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Club Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title', $row->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Club Icon <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i id="icon-preview" class="{{ old('icon', $row->icon) }} fa-lg text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" id="icon" value="{{ old('icon', $row->icon) }}" required placeholder="e.g. fas fa-laptop-code">
                                    @error('icon')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted d-block mt-1">
                                    Enter a FontAwesome class string. Find free icons in the 
                                    <a href="https://fontawesome.com/v6/search?m=free" target="_blank" rel="noopener noreferrer">FontAwesome v6 Free Library</a>.
                                </small>

                                <!-- Quick Selector UI -->
                                <div class="mt-3 p-3 bg-light rounded border">
                                    <label class="form-label fw-semibold text-secondary mb-2 small"><i class="fas fa-magic me-1"></i> Quick Select Common Icons:</label>
                                    <div class="d-flex flex-wrap icon-picker-container">
                                        @php
                                            $quickIcons = [
                                                'fas fa-laptop' => 'Computer',
                                                'fas fa-laptop-code' => 'Tech/Coding',
                                                'fas fa-language' => 'Language',
                                                'fas fa-briefcase' => 'Business',
                                                'fas fa-music' => 'Music',
                                                'fas fa-palette' => 'Art/Design',
                                                'fas fa-atom' => 'Science',
                                                'fas fa-book-open' => 'Literature/Book',
                                                'fas fa-user-friends' => 'Social/Debate',
                                                'fas fa-basketball-ball' => 'Sports',
                                                'fas fa-camera' => 'Photography',
                                                'fas fa-globe' => 'International'
                                            ];
                                        @endphp
                                        @foreach($quickIcons as $iconClass => $label)
                                            <button type="button" class="btn btn-outline-secondary btn-sm d-flex align-items-center py-1 px-2 me-2 mb-2 icon-select-btn" data-select-icon="{{ $iconClass }}">
                                                <i class="{{ $iconClass }} me-2 text-primary"></i> {{ $label }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Link To</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Link to Page</label>
                                        <select class="form-control" name="page_id" id="page_id">
                                            <option value="">Select Page</option>
                                            @foreach ($pages as $page)
                                                <option value="{{ $page->id }}" {{ old('page_id', $row->page_id) == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Internal Link</label>
                                        <select class="form-control" name="route_name" id="route_name">
                                            <option value="">Select Internal Link</option>
                                            @foreach ($internalRoutes as $routeName => $label)
                                                <option value="{{ $routeName }}" {{ old('route_name', $row->route_name) == $routeName ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Custom URL</label>
                                        <input type="text" class="form-control" id="link" name="link" value="{{ old('link', $row->link) }}" placeholder="https://example.com">
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">Choose one: page, internal link, or custom URL</small>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
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

    // Live update icon preview when typing/copy-pasting
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('icon-preview');

    if (iconInput && iconPreview) {
        iconInput.addEventListener('input', function() {
            iconPreview.className = '';
            const val = this.value.trim() || 'fas fa-question';
            iconPreview.className = val + ' fa-lg text-primary';
        });
    }

    // Populate when clicking a quick-select button
    const pickerBtns = document.querySelectorAll('.icon-select-btn');
    pickerBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const selectedIcon = this.getAttribute('data-select-icon');
            if (iconInput) {
                iconInput.value = selectedIcon;
                // Trigger input event to update preview
                iconInput.dispatchEvent(new Event('input'));
            }
        });
    });
});
</script>

@endsection
