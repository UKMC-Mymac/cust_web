@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
                <!-- Section Heading Management -->
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class=""></i> Section Heading</h5>
                    </div>
                    <div class="card-block">
                        @php
                            $footerSection = \App\Models\Web\ContentSection::query()
                                                                           ->where('key', 'footer_section')
                                                                           ->first();
                        @endphp
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <strong>Title:</strong> 
                                    <span class="text-muted">{{ $footerSection->title ?? 'Not set' }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Subtitle:</strong> 
                                    <span class="text-muted">{{ $footerSection->subtitle ?? 'Not set' }}</span>
                                </div>
                                <div>
                                    <strong>Description:</strong> 
                                    <span class="text-muted">{!! str_limit($footerSection->description ?? 'Not set', 100) !!}</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                @if($footerSection && $footerSection->status == 1)
                                    <div class="mb-2"><span class="badge badge-pill badge-success">{{ __('status_active') }}</span></div>
                                @else
                                    <div class="mb-2"><span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span></div>
                                @endif
                                <a href="{{ route('admin.content-section.manage', 'footer_section') }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Section
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Heading Management -->

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-gradient">
                        <div>
                            <h5 class="mb-0">{{ $title }} Management</h5>
                            <small class="text-muted">Manage footer sections and links</small>
                        </div>
                    </div>

                    <div class="card-block">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                @can($access.'-create')
                                <a href="{{ route($route.'.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add New Section
                                </a>
                                @endcan

                                <a href="{{ route($route.'.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-info mb-0" role="alert">
                                    <i class="fas fa-info-circle"></i> 
                                    <strong>{{ count($rows) }}</strong> footer section(s) available
                                </div>
                            </div>
                        </div>

                        @if(count($rows) > 0)
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 30%">Section Title</th>
                                        <th style="width: 15%">Links Count</th>
                                        <th style="width: 15%">Display Order</th>
                                        <th style="width: 15%">Status</th>
                                        <th style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr class="align-middle">
                                        <td>
                                            <span class="badge bg-primary">{{ $key + 1 }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $row->title }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                @if($row->links->count() > 0)
                                                    {{ $row->links->where('status', 1)->count() }} active link(s)
                                                @else
                                                    No links
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-dark">{{ $row->sort_order }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $row->sort_order }}</span>
                                        </td>
                                        <td>
                                            @if( $row->status == 1 )
                                            <span class="badge bg-success">Active</span>
                                            @else
                                            <span class="badge bg-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can($access.'-edit')
                                            <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                        @else
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>No footer sections found!</strong> Create your first section to get started.
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-lightbulb"></i> How to Use
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Click <strong>"Add New Section"</strong> to create footer sections (e.g., "Useful Links", "Resources")</li>
                            <li>Click <strong>"Edit"</strong> on any section to manage its links</li>
                            <li>Use <strong>Display Order</strong> to control which section appears first</li>
                            <li>Set status to <strong>Inactive</strong> to hide a section temporarily</li>
                            <li>Changes appear immediately on your website footer</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<style>
    .bg-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>

@endsection
