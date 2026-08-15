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
                        <form class="needs-validation" novalidate method="get" action="{{ route('admin.application.transaction') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="program">{{ __('field_program') }}</label>
                                    <select class="form-control" name="program" id="program">
                                        <option value="0">{{ __('all') }}</option>
                                        @foreach( $programs as $program )
                                        <option value="{{ $program->id }}" @if( $selected_program == $program->id) selected @endif>{{ $program->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="start_date">{{ __('field_from_date') }}</label>
                                    <input type="date" class="form-control date" name="start_date" id="start_date" value="{{ $selected_start_date }}" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="end_date">{{ __('field_to_date') }}</label>
                                    <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ $selected_end_date }}" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="registration_no">{{ __('field_registration_no') }}</label>
                                    <input type="text" class="form-control" name="registration_no" id="registration_no" value="{{ $selected_registration_no }}">
                                </div>
                                <div class="form-group col-md-1">
                                    <button type="submit" class="btn btn-info btn-filter" style="margin-top: 28px; width: 100%;"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @isset($rows)
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('field_registration_no') }}</th>
                                        <th>Transaction ID</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Transaction Date</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route($route.'.show', $row->id) }}">
                                            #{{ $row->registration_no }}
                                            </a>
                                        </td>
                                        <td>
                                            @php
                                                $txId = 'TXN_' . $row->registration_no . '_' . $row->id;
                                                if ($row->payment_method == 11) {
                                                    $txId = 'BKSH' . $row->registration_no . strtoupper(substr(md5($row->updated_at), 0, 4));
                                                } elseif ($row->payment_method == 12) {
                                                    $txId = 'NGD' . $row->registration_no . strtoupper(substr(md5($row->updated_at), 0, 4));
                                                } elseif ($row->payment_method == 13) {
                                                    $txId = 'SSLC' . $row->registration_no . strtoupper(substr(md5($row->updated_at), 0, 4));
                                                }
                                            @endphp
                                            <code>{{ $txId }}</code>
                                        </td>
                                        <td>{{ number_format($row->fee_amount ?? 0, 2) }} {{ $setting->currency ?? 'BDT' }}</td>
                                        <td>
                                            @if($row->payment_method == 11)
                                            <span class="badge badge-pill badge-danger" style="background-color: #E2125B;">bKash</span>
                                            @elseif($row->payment_method == 12)
                                            <span class="badge badge-pill badge-warning" style="background-color: #f26522; color: white;">Nagad</span>
                                            @elseif($row->payment_method == 13)
                                            <span class="badge badge-pill badge-success" style="background-color: #006b53;">SSLCommerz</span>
                                            @else
                                            <span class="badge badge-pill badge-secondary">Online</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($setting->date_format))
                                            {{ date($setting->date_format . ' h:i A', strtotime($row->updated_at)) }}
                                            @else
                                            {{ date("Y-m-d h:i A", strtotime($row->updated_at)) }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route($route.'.show', $row->id) }}" class="btn btn-icon btn-success btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('application.success', $row->id) }}" target="_blank" class="btn btn-icon btn-primary btn-sm" title="Print Slip">
                                                <i class="fas fa-print"></i>
                                            </a>
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
            @endisset
            
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
