@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} Details</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="far fa-edit"></i> {{ __('btn_edit') }}</a>
                    </div>
                    <div class="card-block">
                        <h4 class="mb-3">{{ $row->name }}</h4>
                        @if($row->designation)
                        <p class="mb-3 text-muted">{{ $row->designation }}</p>
                        @endif
                        <div class="border rounded p-3 bg-white">
                            {!! $row->description !!}
                        </div>
                        <div class="mt-3">
                            <strong>{{ __('field_status') }}:</strong>
                            @if( $row->status == 1 )
                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                            @else
                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content-->

@endsection