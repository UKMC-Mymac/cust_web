@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Section Details Card -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Section Details</h5>
                    </div>
                    @include('admin.web.inc.errors')

                    <form method="POST" action="{{ route($route.'.update', $row->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-block">

                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Section Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $row->title) }}" placeholder="e.g., Useful Links" required>
                                @error('title')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="sort_order" class="form-label">Display Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $row->sort_order) }}" placeholder="1, 2, 3..." required>
                                <small class="text-muted">Lower numbers appear first in footer</small>
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
                                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', $row->status) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">
                                        {{ old('status', $row->status) == 1 ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                                <small class="text-muted">Inactive sections won't show in footer</small>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Preview Card -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Footer Preview</h6>
                    </div>
                    <div class="card-block">
                        <div class="badge bg-secondary p-2">
                            <strong>{{ $row->title }}</strong>
                        </div>
                        <hr>
                        <small class="text-muted">
                            <strong>Total Links:</strong> {{ count($row->links) }}<br>
                            <strong>Active Links:</strong> {{ count($row->links->where('status', 1)) }}<br>
                            <strong>Status:</strong> 
                            @if($row->status == 1)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </small>
                    </div>
                </div>
            </div>

            <!-- Links Management Card -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Manage Links</h5>
                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addLinkModal">
                            <i class="fas fa-plus"></i> Add Link
                        </button>
                    </div>

                    <div class="card-block">
                        @if(count($row->links) > 0)
                        <!-- Links Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 35%">Link Label</th>
                                        <th style="width: 35%">URL</th>
                                        <th style="width: 10%">Order</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($row->links as $key => $link)
                                    <tr class="align-middle">
                                        <td><span class="badge bg-secondary">{{ $key + 1 }}</span></td>
                                        <td>
                                            <strong>{{ $link->label }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                $linkHref = $link->url;
                                                $display = $link->url;
                                                if (empty($linkHref) && !empty($link->page)) {
                                                    $linkHref = url('page/' . ($link->page->slug ?? $link->page->id));
                                                    $display = $link->page->title;
                                                } elseif (empty($linkHref) && !empty($link->route_name)) {
                                                    try {
                                                        $linkHref = route($link->route_name);
                                                        $display = $link->route_name;
                                                    } catch (\Exception $e) {
                                                        $linkHref = '#';
                                                        $display = $link->route_name;
                                                    }
                                                }
                                            @endphp
                                            <a href="{{ $linkHref }}" target="_blank" class="text-decoration-none" title="{{ $linkHref }}">
                                                {{ \Illuminate\Support\Str::limit($display, 35, '...') }}
                                                <i class="fas fa-external-link-alt fa-xs"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $link->sort_order }}</span>
                                        </td>
                                        <td>
                                            @if( $link->status == 1 )
                                            <span class="badge bg-success">Active</span>
                                            @else
                                            <span class="badge bg-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editLinkModal-{{ $link->id }}" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteLinkModal-{{ $link->id }}" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Link Modal -->
                                    <div class="modal fade" id="editLinkModal-{{ $link->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Link: {{ $link->label }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route($route.'.updateLink', $link->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label for="edit_label_{{ $link->id }}" class="form-label">Link Label <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="edit_label_{{ $link->id }}" name="label" value="{{ $link->label }}" placeholder="e.g., Programs" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Link To</label>
                                                            <div class="row g-3">
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Link to Page</label>
                                                                    <select class="form-control" name="page_id">
                                                                        <option value="">Select Page</option>
                                                                        @foreach ($pages as $page)
                                                                            <option value="{{ $page->id }}" @selected(old('page_id', $link->page_id ?? '') == $page->id)>{{ $page->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Internal Link</label>
                                                                    <select class="form-control" name="route_name">
                                                                        <option value="">Select Internal Link</option>
                                                                        @foreach ($internalRoutes as $routeName => $label)
                                                                            <option value="{{ $routeName }}" @selected(old('route_name', $link->route_name ?? '') == $routeName)>{{ $label }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Custom URL</label>
                                                                    <input type="text" class="form-control" name="url" value="{{ old('url', $link->url) }}" placeholder="https://example.com/programs">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="edit_sort_order_{{ $link->id }}" class="form-label">Display Order</label>
                                                            <input type="number" class="form-control" id="edit_sort_order_{{ $link->id }}" name="sort_order" value="{{ $link->sort_order }}">
                                                            <small class="text-muted">Lower numbers appear first</small>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input type="hidden" name="status" value="0">
                                                            <input class="form-check-input" type="checkbox" name="status" id="edit_status_{{ $link->id }}" value="1" {{ $link->status == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="edit_status_{{ $link->id }}">
                                                                Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save"></i> Update Link
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Link Modal -->
                                    <div class="modal fade" id="deleteLinkModal-{{ $link->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Link</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mb-0">Are you sure you want to delete <strong>{{ $link->label }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route($route.'.destroyLink', $link->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info text-center mb-0">
                            <i class="fas fa-info-circle"></i> No links added yet. Click "Add Link" button to create one.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Link Modal -->
        <div class="modal fade" id="addLinkModal" tabindex="-1" role="dialog" aria-labelledby="addLinkModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLinkModalLabel">
                            <i class="fas fa-link"></i> Add New Link
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route($route.'.storeLink', $row->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="label" class="form-label">Link Label <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="label" name="label" placeholder="e.g., Undergraduate Programs" required autofocus>
                                <small class="text-muted">Text shown in footer</small>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Link To</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Link to Page</label>
                                        <select class="form-control" name="page_id" id="page_id">
                                            <option value="">Select Page</option>
                                            @foreach ($pages as $page)
                                                <option value="{{ $page->id }}">{{ $page->title }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted d-block mt-1">Select a page to link internally</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Internal Link</label>
                                        <select class="form-control" name="route_name" id="route_name">
                                            <option value="">Select Internal Link</option>
                                            @foreach ($internalRoutes as $routeName => $label)
                                                <option value="{{ $routeName }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted d-block mt-1">Or choose an internal link</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Custom URL</label>
                                        <input type="text" class="form-control" id="url" name="url" placeholder="https://example.com/programs">
                                        <small class="text-muted d-block mt-1">If no page/link selected</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="link_sort_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control" id="link_sort_order" name="sort_order" value="0">
                                <small class="text-muted">Lower numbers appear first (0, 1, 2, ...)</small>
                            </div>
                            <div class="form-check form-switch">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" name="status" id="link_status" value="1" checked>
                                <label class="form-check-label" for="link_status">
                                    Active (show in footer)
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->


<style>
    .table-hover tbody tr:hover { background-color: #f5f5f5; }
    .btn-icon { padding: 0.25rem 0.5rem; }
    .modal-lg { max-width: 900px; }
</style>

@endsection
