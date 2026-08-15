@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        @can($access.'-create')
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                        @endcan

                        <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <!-- Search Form -->
                    <div class="card-block border-bottom">
                        <form method="get" action="{{ route($route.'.index') }}">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search" value="{{ request()->get('search') }}" placeholder="{{ __('field_name') }} / {{ __('field_designation') }}...">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                    <a href="{{ route($route.'.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i> {{ __('btn_reset') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-block">
                        <div class="table-responsive">
                            <table id="members-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Serial No</th>
                                        <th>{{ __('field_name') }}</th>
                                        <th>{{ __('field_designation') }}</th>
                                        <th>{{ __('field_description') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        {{-- <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $key + 1 }}</td> --}}
                                        <td>{{ $row->serial_no }}</td>
                                        <td>{!! str_limit($row->name, 50, ' ...') !!}</td>
                                        <td>{!! $row->designation ? str_limit($row->designation, 40, ' ...') : '-' !!}</td>
                                        <td>{!! $row->description ? str_limit(strip_tags($row->description), 100, ' ...') : '-' !!}</td>
                                        <td>
                                            @if( $row->status == 1 )
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-{{ $row->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @include($view.'.show')

                                            @can($access.'-edit')
                                            <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
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

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                            <div class="text-muted">
                                {{ __('Showing') }} {{ $rows->firstItem() ?? 0 }} {{ __('to') }} {{ $rows->lastItem() ?? 0 }} {{ __('of') }} {{ $rows->total() ?? 0 }} {{ __('entries') }}
                            </div>
                            <div>
                                {{ $rows->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection