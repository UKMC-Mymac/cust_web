@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $role->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.update', [$role->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-block">

                        <!-- Form Start -->
                        <div class="form-group">
                            <label for="name">{{ __('field_title') }} <span>*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $role->name }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_title') }}
                            </div>
                        </div>


                        {{--
                            ORIGINAL: show all permissions grouped. Commented out temporarily so we can filter by group for the client demo.
                        
                        @php
                            $separation = '0';
                        @endphp
                              
                        @foreach($permission as $value) 

                        @if($separation != $value->group)
                            <hr/>
                            <h6 class="mt-4 text-primary">{{ $value->group }}</h6>
                        @endif

                        <div class="form-group d-inline" style="margin-right: 40px;">
                            <div class="checkbox d-inline">
                                <input type="checkbox" id="checkbox-{{ $value->id }}" name="permission[]" value="{{ $value->id }}"

                                @foreach($rolePermissions as $rolePermission)
                                    @if($rolePermission->permission_id == $value->id) checked @endif
                                @endforeach  
                                >

                                <label for="checkbox-{{ $value->id }}" class="cr">{{ $value->title }}</label>
                            </div>
                        </div>

                        @php
                            $separation = $value->group;
                        @endphp

                        @endforeach
                        --}}

                        @php
                            // Temporary filter for demo: only show permissions that belong to the groups listed here.
                            // Update the array below with group names you want visible for the client demo.
                    $visibleGroups = [
                                        'Application',
                                        'Status Type',
                                        'Student',
                                        'Faculty',
                                        'Program',
                                        'Batch',
                                        'Session',
                                        'Contact Setting',
                                        'Social Setting',
                                        'About Us',
                                        'Feature',
                                        'Course',
                                        'Slider',
                                        'Web Event',
                                        'Gallery',
                                        'Why Choose Us',
                                        'Faq',
                                        'State/Province',
                                        'Campus Life',
                                        'Testimonial',
                                        'Page',
                                        'Club',
                                        'Student Zone',
                                        'Notice List',
                                        'Notice Category',
                                        'Class Schedule',
                                        'Academic Calender',
                                        'Chat',
                                        'Navbar',
                                        'Result',
                                        'Language',
                                        'Department',
                                        'District/City',
                                        'Designation',
                                        'Application Setting',
                                        'Setting',
                                        'Apply',
                                        'Translation',
                                        'Work Shift Type',
                                        'Role and Permissions',
                                        'Field Setting',
                                        'Members',
                                        'Footer Section',
                                        'My Profile',
                                        'Contact Page',
                                        'Application Setting'
                                    ];
                            $separation = '0';
                        @endphp

                        @foreach($permission->whereIn('group', $visibleGroups) as $value)

                            @if($separation != $value->group)
                                <hr/>
                                <h6 class="mt-4 text-primary">{{ $value->group == 'Faculty' ? 'Department' : $value->group }}</h6>
                            @endif

                            <div class="form-group d-inline" style="margin-right: 40px;">
                                <div class="checkbox d-inline">
                                    <input type="checkbox" id="checkbox-{{ $value->id }}" name="permission[]" value="{{ $value->id }}"

                                    @foreach($rolePermissions as $rolePermission)
                                        @if($rolePermission->permission_id == $value->id) checked @endif
                                    @endforeach
                                    >

                                    <label for="checkbox-{{ $value->id }}" class="cr">{{ $value->title }}</label>
                                </div>
                            </div>

                            @php
                                $separation = $value->group;
                            @endphp

                        @endforeach
                        <!-- Form End -->

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection