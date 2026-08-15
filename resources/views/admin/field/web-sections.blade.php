@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $title }}</h5>
                        </div>
                        <div class="card-block">
                          <div class="row">
                            <!-- Form Start -->
                            <div class="table-responsive">
                                <table class="table nowrap table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Section Name') }}</th>
                                            <th>{{ __('field_status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sections = [
                                                'hero' => 'Hero Banner',
                                                'academics' => 'Academics Details',
                                                'why-choose-us' => 'Why Choose Us',
                                                'campus-life' => 'Campus Life',
                                                'clubs' => 'Student Clubs',
                                                'testimonials' => 'Testimonials',
                                                'student-zone' => 'Student Zone',
                                                'news-and-events' => 'News & Events',
                                                'apply' => 'Apply Banner',
                                                'faq' => 'Frequently Asked Questions (FAQ)',
                                            ];
                                        @endphp

                                        @foreach($sections as $key => $label)
                                        <tr>
                                            <td>{{ $label }}</td>
                                            <td>
                                                <div class="switch d-inline" style="float:left; margin-top: -15px;">
                                                    <input type="checkbox" id="status-{{ $key }}" name="sections[{{ $key }}]" value="1" @if(!isset($row->web_sections[$key]) || $row->web_sections[$key] == 1) checked @endif>
                                                    <label for="status-{{ $key }}" class="cr"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Form End -->
                          </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
