@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
                     <!-- Section Heading Management -->
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class=""></i> Section Heading</h5>
                    </div>
                    <div class="card-block">
                        @php
                            $StudentZoneSection = \App\Models\Web\ContentSection::query()
                                                                           ->where('key', 'student_zone')
                                                                           ->first();
                        @endphp
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <strong>Subtitle:</strong> 
                                    <span class="text-muted">{{ $StudentZoneSection->subtitle ?? 'Not set' }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Title:</strong> 
                                    <span class="text-muted">{{ $StudentZoneSection->title ?? 'Not set' }}</span>
                                </div>
                                <div>
                                    <strong>Description:</strong> 
                                    <span class="text-muted">{!! str_limit($StudentZoneSection->description ?? 'Not set', 100) !!}</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                @if($StudentZoneSection && $StudentZoneSection->status == 1)
                                    <div class="mb-2"><span class="badge badge-pill badge-success">{{ __('status_active') }}</span></div>
                                @else
                                    <div class="mb-2"><span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span></div>
                                @endif
                                <a href="{{ route('admin.content-section.manage', 'student_zone') }}" class="btn btn-info">
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
                            <small class="text-muted">Manage student zones for the portal</small>
                        </div>
                    </div>

                    <div class="card-block">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                @can($access.'-create')
                                <a href="{{ route($route.'.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add New Zone
                                </a>
                                @endcan

                                <a href="{{ route($route.'.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-info mb-0" role="alert">
                                    <i class="fas fa-info-circle"></i> 
                                    <strong>{{ count($rows) }}</strong> zone(s) total
                                </div>
                            </div>
                        </div>

                        @if(count($rows) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 25%">Title</th>
                                        <th style="width: 25%">Link To</th>
                                        <th style="width: 15%">Order</th>
                                        <th style="width: 15%">Status</th>
                                        <th style="width: 15%">Actions</th>
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
                                        </td>
                                        <td>
                                            @php
                                                $display = '—';
                                                if (!empty($row->link)) {
                                                    $display = $row->link;
                                                } elseif (!empty($row->page)) {
                                                    $display = $row->page->title;
                                                } elseif (!empty($row->route_name)) {
                                                    $display = $row->route_name;
                                                }
                                            @endphp
                                            <small class="text-muted">{{ $display }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $row->order }}</span>
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
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>No zones found!</strong> Create your first zone to get started.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
