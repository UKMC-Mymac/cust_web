@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ $title }}</h5>
                        <a href="{{ route($route.'.create') }}" class="btn btn-primary">Add</a>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_title') }}</th>
                                        <th>{{ __('field_email') }}</th>
                                        <th>{{ __('field_phone') }}</th>
                                        <th>{{ __('field_website') }}</th>
                                        <th>{{ __('field_address') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->title }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->phone }}</td>
                                            <td>{{$row->website }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($row->address, 50) }}</td>
                                            <td>{{ ($row->status == 1) ? __('Active') : __('Inactive') }}</td>
                                            <td>
                                                <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-sm btn-info">{{ __('edit') }}</a>

                                                <form action="{{ route($route.'.destroy', $row->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('{{ __('are_you_sure') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">{{ __('delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection