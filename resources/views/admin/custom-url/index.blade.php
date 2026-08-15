@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>Create {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group mb-3">
                                <label for="key" class="form-label fw-bold">Key/Identifier <span>*</span></label>
                                <input type="text" class="form-control" name="key" id="key" value="{{ old('key') }}" required placeholder="e.g. student_login">
                                <div class="invalid-feedback">
                                  Please enter a unique key identifier.
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="title" class="form-label fw-bold">Title <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Student Login">
                                <div class="invalid-feedback">
                                  Please enter a title.
                                </div>
                            </div>

                            <div class="form-group mb-3 bg-light p-3 rounded border">
                                <label class="form-label fw-bold text-primary mb-2">Link To (Choose One):</label>
                                
                                <div class="mb-2">
                                    <label class="form-label small fw-semibold">Link to Page</label>
                                    <select class="form-control page-select-create" name="page_id" id="page_id_create">
                                        <option value="">Select Page</option>
                                        @foreach ($pages as $page)
                                            <option value="{{ $page->id }}" {{ old('page_id') == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small fw-semibold">Internal Link</label>
                                    <select class="form-control route-select-create" name="route_name" id="route_name_create">
                                        <option value="">Select Internal Link</option>
                                        @foreach ($internalRoutes as $routeName => $label)
                                            <option value="{{ $routeName }}" {{ old('route_name') == $routeName ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-1">
                                    <label class="form-label small fw-semibold">Custom URL</label>
                                    <input type="text" class="form-control url-input-create" id="url_create" name="url" value="{{ old('url') }}" placeholder="https://example.com or #">
                                </div>
                                <small class="text-muted d-block mt-2">Specify either a page, internal link, or custom URL.</small>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Key/Identifier</th>
                                        <th>Title</th>
                                        <th>Resolved URL</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    @php
                                        $linkHref = $row->url;
                                        $linkType = 'Custom URL';
                                        if (empty($linkHref) && !empty($row->page)) {
                                            $linkHref = url('page/' . ($row->page->slug ?? $row->page->id));
                                            $linkType = 'Page: ' . $row->page->title;
                                        } elseif (empty($linkHref) && !empty($row->route_name)) {
                                            try {
                                                $linkHref = route($row->route_name);
                                                $linkType = 'Internal Route: ' . $row->route_name;
                                            } catch (\Exception $e) {
                                                $linkHref = '#';
                                                $linkType = 'Invalid Route';
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><code>{{ $row->key }}</code></td>
                                        <td>{{ $row->title }}</td>
                                        <td>
                                            <a href="{{ $linkHref ?? '#' }}" target="_blank" class="fw-bold text-primary">{{ $linkHref }}</a>
                                            <div class="text-muted small">{{ $linkType }}</div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')

                                            @if(!in_array($row->key, ['student_login', 'staff_login', 'privacy_policy', 'terms_of_service', 'copyright_link']))
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endif
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Setup exclusive inputs for Create Form
    const pageSelectCreate = document.getElementById('page_id_create');
    const routeSelectCreate = document.getElementById('route_name_create');
    const urlInputCreate = document.getElementById('url_create');

    function updateCreateExclusive() {
        if (pageSelectCreate.value) {
            routeSelectCreate.disabled = true;
            routeSelectCreate.value = '';
            urlInputCreate.disabled = true;
            urlInputCreate.value = '';
        } else if (routeSelectCreate.value) {
            pageSelectCreate.disabled = true;
            pageSelectCreate.value = '';
            urlInputCreate.disabled = true;
            urlInputCreate.value = '';
        } else if (urlInputCreate.value.trim()) {
            pageSelectCreate.disabled = true;
            pageSelectCreate.value = '';
            routeSelectCreate.disabled = true;
            routeSelectCreate.value = '';
        } else {
            pageSelectCreate.disabled = false;
            routeSelectCreate.disabled = false;
            urlInputCreate.disabled = false;
        }
    }

    pageSelectCreate.addEventListener('change', updateCreateExclusive);
    routeSelectCreate.addEventListener('change', updateCreateExclusive);
    urlInputCreate.addEventListener('input', updateCreateExclusive);
});
</script>
@endsection
