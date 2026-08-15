@extends('admin.layouts.master')
@section('title', $title)
@section('page_css')
    <link rel="stylesheet" href="{{ asset('dist/css/fontawesome.min.css') }}">
@endsection
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-gradient">
                        <div>
                            <h5 class="mb-0">{{ $title }} Management</h5>
                            <small class="text-muted">Assign pages and links to student clubs</small>
                        </div>
                    </div>

                    <div class="card-block">
                        @if(count($rows) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 25%">Title</th>
                                        <th style="width: 15%">Icon</th>
                                        <th style="width: 40%">Link To</th>
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
                                            <i class="{{ $row->icon }} fa-lg text-primary" title="{{ $row->icon }}"></i>
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
                                            @can($access.'-edit')
                                            <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
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
                            <strong>No clubs found!</strong>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
