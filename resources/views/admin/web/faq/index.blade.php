@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <!-- Section Heading Management -->
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class=""></i> Section Heading</h5>
                    </div>
                    <div class="card-block">
                        @php
                            $faqSection = \App\Models\Web\ContentSection::query()
                                                                           ->where('key', 'faq')
                                                                           ->first();
                        @endphp
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <strong>Subtitle:</strong> 
                                    <span class="text-muted">{{ $faqSection->subtitle ?? 'Not set' }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Title:</strong> 
                                    <span class="text-muted">{{ $faqSection->title ?? 'Not set' }}</span>
                                </div>
                                <div>
                                    <strong>Description:</strong> 
                                    <span class="text-muted">{!! str_limit($faqSection->description ?? 'Not set', 100) !!}</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                @if($faqSection && $faqSection->status == 1)
                                    <div class="mb-2"><span class="badge badge-pill badge-success">{{ __('status_active') }}</span></div>
                                @else
                                    <div class="mb-2"><span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span></div>
                                @endif
                                <a href="{{ route('admin.content-section.manage', 'faq') }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Section
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Heading Management -->
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_title') }}
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                <label for="icon" class="form-label">{{ __('field_icon') }} </label>
                                <input type="text" class="form-control" name="icon" id="icon" value="{{ old('icon') }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_icon') }}
                                </div>
                            </div> --}}

                            <div class="form-group">
                                <label for="description" class="form-label">{{ __('field_description') }} <span>*</span></label>
                                <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>

                                <div class="invalid-feedback">
                                    {{ __('required_field') }} {{ __('field_description') }}
                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form method="GET" action="{{ route($route.'.index') }}" class="d-flex justify-content-end">
                                    <input type="text" name="search" class="form-control" placeholder="Search question..." value="{{ request()->get('search') }}" style="width: 250px; margin-right: 8px;">
                                    <button type="submit" class="btn btn-info" style="margin-right: 8px;"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                    @if(request()->filled('search'))
                                        <a href="{{ route($route.'.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{!! str_limit($row->title, 50, ' ...') !!}</td>
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
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
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
