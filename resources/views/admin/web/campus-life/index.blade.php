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
                            $CampusLifeSection = \App\Models\Web\ContentSection::query()
                                                                           ->where('key', 'campus_life')
                                                                           ->first();
                        @endphp
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <strong>Subtitle:</strong> 
                                    <span class="text-muted">{{ $CampusLifeSection->subtitle ?? 'Not set' }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Title:</strong> 
                                    <span class="text-muted">{{ $CampusLifeSection->title ?? 'Not set' }}</span>
                                </div>
                                <div>
                                    <strong>Description:</strong> 
                                    <span class="text-muted">{!! str_limit($CampusLifeSection->description ?? 'Not set', 100) !!}</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                @if($CampusLifeSection && $CampusLifeSection->status == 1)
                                    <div class="mb-2"><span class="badge badge-pill badge-success">{{ __('status_active') }}</span></div>
                                @else
                                    <div class="mb-2"><span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span></div>
                                @endif
                                <a href="{{ route('admin.content-section.manage', 'campus_life') }}" class="btn btn-info">
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
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                @can($access.'-create')
                                <a href="{{ route($route.'.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</a>
                                @endcan
                                <a href="{{ route($route.'.index') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                            </div>
                            <div class="col-md-6">
                                <form method="GET" action="{{ route($route.'.index') }}" class="d-flex justify-content-end">
                                    <input type="text" name="search" class="form-control" placeholder="Search title or text..." value="{{ request()->get('search') }}" style="width: 250px; margin-right: 8px;">
                                    <button type="submit" class="btn btn-info" style="margin-right: 8px;"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                    @if(request()->filled('search'))
                                        <a href="{{ route($route.'.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_feature_text') }}</th>
                                        <th>{{ __('field_image') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{!! str_limit($row->title, 50, ' ...') !!}</td>
                                        <td>{!! str_limit($row->feature_text, 50, ' ...') !!}</td>
                                        <td>
                                            @if(is_file('uploads/'.$path.'/'.$row->attach))
                                            <img style="width:150px; height:150" src="{{asset('uploads/'.$path.'/'.$row->attach)}}" alt="" srcset="">
                                            @endif
                                        </td>
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
                                            <!-- Include Show modal -->
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
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
