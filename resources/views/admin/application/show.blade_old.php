@extends('admin.layouts.master')
@section('title', $title)
@section('page_css')
<link rel="stylesheet" href="{{ asset('plugins/lightbox2-master/css/lightbox.min.css') }}">
@endsection
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-3">
                <div class="card user-card user-card-1">
                    <div class="card-body pb-0">
                        <div class="media user-about-block align-items-center mt-0 mb-3">
                            <div class="position-relative d-inline-block">
                                @if(is_file('uploads/'.$path.'/'.$row->photo))
                                <img src="{{ asset('uploads/'.$path.'/'.$row->photo) }}" class="img-radius img-fluid wid-80" alt="{{ __('field_photo') }}" onerror="this.src='{{ asset('images/user/avatar-2.jpg') }}';">
                                @else
                                <img src="{{ asset('images/user/avatar-2.jpg') }}" class="img-radius img-fluid wid-80" alt="{{ __('field_photo') }}">
                                @endif
                                <div class="certificated-badge">
                                    <i class="fas fa-certificate text-primary bg-icon"></i>
                                    <i class="fas fa-check front-icon text-white"></i>
                                </div>
                            </div>
                            <div class="media-body ms-3">
                                <h6 class="mb-1">{{ $row->first_name }} {{ $row->last_name }}</h6>
                                @if(isset($row->registration_no))
                                <p class="mb-0 text-muted">#{{ $row->registration_no }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="far fa-envelope m-r-10"></i>{{ __('field_email') }} : </span>
                            <span class="float-end">{{ $row->email }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="fas fa-phone-alt m-r-10"></i>{{ __('field_phone') }} : </span>
                            <span class="float-end">{{ $row->phone }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="fas fa-graduation-cap m-r-10"></i>{{ __('field_program') }} : </span>
                            <span class="float-end">{{ $row->program->title ?? '' }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="f-w-500"><i class="far fa-calendar-alt m-r-10"></i>{{ __('field_apply_date') }} : </span>
                            <span class="float-end">
                                @if(isset($setting->date_format))
                                {{ date($setting->date_format, strtotime($row->apply_date)) }}
                                @else
                                {{ date("Y-m-d", strtotime($row->apply_date)) }}
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item border-bottom-0">
                            <span class="f-w-500"><i class="far fa-question-circle m-r-10"></i>{{ __('field_status') }} : </span>
                            <span class="float-end">
                                @if( $row->status == 1 )
                                <span class="badge badge-pill badge-primary">{{ __('status_pending') }}</span>
                                @elseif( $row->status == 2 )
                                <span class="badge badge-pill badge-success">{{ __('status_approved') }}</span>
                                @else
                                <span class="badge badge-pill badge-danger">{{ __('status_rejected') }}</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            @php
                function field($slug){
                    return \App\Models\Field::field($slug);
                }
            @endphp
            <div class="col-md-9">
                <div class="card">
                    <div class="card-block">
                        <div class="">
                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="row gx-2 scheduler-border">
                                    @if(field('application_father_name')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_father_name') }}:</mark> {{ $row->father_name }}</p><hr/>
                                    @endif
                                    @if(field('application_father_occupation')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_father_occupation') }}:</mark> {{ $row->father_occupation }}</p><hr/>
                                    @endif
                                    @if(field('application_mother_name')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_mother_name') }}:</mark> {{ $row->mother_name }}</p><hr/>
                                    @endif
                                    @if(field('application_mother_occupation')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_mother_occupation') }}:</mark> {{ $row->mother_occupation }}</p><hr/>
                                    @endif

                                    <p><mark class="text-primary">{{ __('field_gender') }}:</mark> 
                                        @if( $row->gender == 1 )
                                        {{ __('gender_male') }}
                                        @elseif( $row->gender == 2 )
                                        {{ __('gender_female') }}
                                        @elseif( $row->gender == 3 )
                                        {{ __('gender_other') }}
                                        @endif
                                    </p><hr/>

                                    <p><mark class="text-primary">{{ __('field_dob') }}:</mark> 
                                        @if(isset($setting->date_format))
                                        {{ date($setting->date_format, strtotime($row->dob)) }}
                                        @else
                                        {{ date("Y-m-d", strtotime($row->dob)) }}
                                        @endif
                                    </p><hr/>

                                    @if(field('application_emergency_phone')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_emergency_phone') }}:</mark> {{ $row->emergency_phone }}</p><hr/>
                                    @endif
                                    @if(field('application_religion')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_religion') }}:</mark> {{ $row->religion }}</p><hr/>
                                    @endif
                                    @if(field('application_caste')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_caste') }}:</mark> {{ $row->caste }}</p><hr/>
                                    @endif
                                    @if(field('application_mother_tongue')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_mother_tongue') }}:</mark> {{ $row->mother_tongue }}</p><hr/>
                                    @endif
                                    @if(field('application_nationality')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_nationality') }}:</mark> {{ $row->nationality }}</p><hr/>
                                    @endif

                                    @if(field('application_marital_status')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_marital_status') }}:</mark> 
                                        @if( $row->marital_status == 1 )
                                        {{ __('marital_status_single') }}
                                        @elseif( $row->marital_status == 2 )
                                        {{ __('marital_status_married') }}
                                        @elseif( $row->marital_status == 3 )
                                        {{ __('marital_status_widowed') }}
                                        @elseif( $row->marital_status == 4 )
                                        {{ __('marital_status_divorced') }}
                                        @elseif( $row->marital_status == 5 )
                                        {{ __('marital_status_other') }}
                                        @endif
                                    </p><hr/>
                                    @endif

                                    @if(field('application_blood_group')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_blood_group') }}:</mark> 
                                        @if( $row->blood_group == 1 )
                                        {{ __('A+') }}
                                        @elseif( $row->blood_group == 2 )
                                        {{ __('A-') }}
                                        @elseif( $row->blood_group == 3 )
                                        {{ __('B+') }}
                                        @elseif( $row->blood_group == 4 )
                                        {{ __('B-') }}
                                        @elseif( $row->blood_group == 5 )
                                        {{ __('AB+') }}
                                        @elseif( $row->blood_group == 6 )
                                        {{ __('AB-') }}
                                        @elseif( $row->blood_group == 7 )
                                        {{ __('O+') }}
                                        @elseif( $row->blood_group == 8 )
                                        {{ __('O-') }}
                                        @endif
                                    </p><hr/>
                                    </fieldset>
                                    @endif

                                    @if(field('application_signature')->status == 1)
                                    <fieldset class="row gx-2 scheduler-border">
                                        @if(is_file('uploads/'.$path.'/'.$row->signature))
                                        <a href="{{ asset('uploads/'.$path.'/'.$row->signature) }}" data-lightbox="gallery">
                                            <img src="{{ asset('uploads/'.$path.'/'.$row->signature) }}" class="img-fluid field-image">
                                        </a>
                                        @endif
                                    </fieldset>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if(field('application_national_id')->status == 1 || field('application_passport_no')->status == 1)
                                    <fieldset class="row gx-2 scheduler-border">
                                    @if(field('application_national_id')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_national_id') }}:</mark> {{ $row->national_id }}</p><hr/>
                                    @endif
                                    @if(field('application_passport_no')->status == 1)
                                    <p><mark class="text-primary">{{ __('field_passport_no') }}:</mark> {{ $row->passport_no }}</p>
                                    @endif
                                    </fieldset>
                                    @endif

                                    @if(field('application_address')->status == 1)
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend>{{ __('field_present') }} {{ __('field_address') }}</legend>
                                    <p><mark class="text-primary">{{ __('field_province') }}:</mark> {{ $row->presentProvince->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_district') }}:</mark> {{ $row->presentDistrict->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_address') }}:</mark> {{ $row->present_address }}</p>
                                    </fieldset>

                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend>{{ __('field_permanent') }} {{ __('field_address') }}</legend>
                                    <p><mark class="text-primary">{{ __('field_province') }}:</mark> {{ $row->permanentProvince->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_district') }}:</mark> {{ $row->permanentDistrict->title ?? '' }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_address') }}:</mark> {{ $row->permanent_address }}</p>
                                    </fieldset>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if(field('application_school_info')->status == 1)
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend>{{ __('field_school_information') }}</legend>
                                    <p><mark class="text-primary">{{ __('field_school_name') }}:</mark> {{ $row->school_name }}</p><hr/>
                                    @if($row->school_board)<p><mark class="text-primary">Board / University:</mark> {{ $row->school_board }}</p><hr/>@endif
                                    @if($row->school_group)<p><mark class="text-primary">Group / Discipline:</mark> {{ $row->school_group }}</p><hr/>@endif
                                    <p><mark class="text-primary">{{ __('field_exam_id') }}:</mark> {{ $row->school_exam_id }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_graduation_year') }}:</mark> {{ $row->school_graduation_year }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_graduation_point') }}:</mark> {{ $row->school_graduation_point }}</p><hr/>
                                    </fieldset>
                                    @endif

                                    @if(field('application_collage_info')->status == 1)
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend>{{ __('field_college_information') }}</legend>
                                    <p><mark class="text-primary">{{ __('field_collage_name') }}:</mark> {{ $row->collage_name }}</p><hr/>
                                    @if($row->collage_board)<p><mark class="text-primary">Board / University:</mark> {{ $row->collage_board }}</p><hr/>@endif
                                    @if($row->collage_group)<p><mark class="text-primary">Group / Discipline:</mark> {{ $row->collage_group }}</p><hr/>@endif
                                    <p><mark class="text-primary">{{ __('field_exam_id') }}:</mark> {{ $row->collage_exam_id }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_graduation_year') }}:</mark> {{ $row->collage_graduation_year }}</p><hr/>
                                    <p><mark class="text-primary">{{ __('field_graduation_point') }}:</mark> {{ $row->collage_graduation_point }}</p><hr/>
                                    </fieldset>
                                    @endif

                                    @if($row->diploma_name)
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend>Diploma</legend>
                                    <p><mark class="text-primary">Institution:</mark> {{ $row->diploma_name }}</p><hr/>
                                    @if($row->diploma_board)<p><mark class="text-primary">Board / University:</mark> {{ $row->diploma_board }}</p><hr/>@endif
                                    @if($row->diploma_group)<p><mark class="text-primary">Group / Discipline:</mark> {{ $row->diploma_group }}</p><hr/>@endif
                                    @if($row->diploma_exam_id)<p><mark class="text-primary">Roll No / Exam ID:</mark> {{ $row->diploma_exam_id }}</p><hr/>@endif
                                    @if($row->diploma_graduation_year)<p><mark class="text-primary">Graduation Year:</mark> {{ $row->diploma_graduation_year }}</p><hr/>@endif
                                    @if($row->diploma_graduation_point)<p><mark class="text-primary">Result / GPA:</mark> {{ $row->diploma_graduation_point }}</p><hr/>@endif
                                    </fieldset>
                                    @endif

                                    @if($row->bachelor_name)
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend>Bachelor's Degree</legend>
                                    <p><mark class="text-primary">Institution:</mark> {{ $row->bachelor_name }}</p><hr/>
                                    @if($row->bachelor_board)<p><mark class="text-primary">Board / University:</mark> {{ $row->bachelor_board }}</p><hr/>@endif
                                    @if($row->bachelor_group)<p><mark class="text-primary">Group / Discipline:</mark> {{ $row->bachelor_group }}</p><hr/>@endif
                                    @if($row->bachelor_exam_id)<p><mark class="text-primary">Roll No / Exam ID:</mark> {{ $row->bachelor_exam_id }}</p><hr/>@endif
                                    @if($row->bachelor_graduation_year)<p><mark class="text-primary">Graduation Year:</mark> {{ $row->bachelor_graduation_year }}</p><hr/>@endif
                                    @if($row->bachelor_graduation_point)<p><mark class="text-primary">Result / GPA:</mark> {{ $row->bachelor_graduation_point }}</p><hr/>@endif
                                    </fieldset>
                                    @endif

                                    @if($row->other_edu_name)
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend>Other Qualification</legend>
                                    <p><mark class="text-primary">Institution:</mark> {{ $row->other_edu_name }}</p><hr/>
                                    @if($row->other_edu_board)<p><mark class="text-primary">Board / University:</mark> {{ $row->other_edu_board }}</p><hr/>@endif
                                    @if($row->other_edu_group)<p><mark class="text-primary">Group / Discipline:</mark> {{ $row->other_edu_group }}</p><hr/>@endif
                                    @if($row->other_edu_exam_id)<p><mark class="text-primary">Roll No / Exam ID:</mark> {{ $row->other_edu_exam_id }}</p><hr/>@endif
                                    @if($row->other_edu_graduation_year)<p><mark class="text-primary">Graduation Year:</mark> {{ $row->other_edu_graduation_year }}</p><hr/>@endif
                                    @if($row->other_edu_graduation_point)<p><mark class="text-primary">Result / GPA:</mark> {{ $row->other_edu_graduation_point }}</p><hr/>@endif
                                    </fieldset>
                                    @endif
                                </div>
                            </div>

                            {{-- Additional Information Row --}}
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <fieldset class="row gx-2 scheduler-border">
                                    <legend>Additional Information</legend>

                                    @if($row->medical_condition)
                                    <div class="col-md-12">
                                        <p><mark class="text-primary">Medical Condition:</mark> {{ $row->medical_condition }}</p><hr/>
                                    </div>
                                    @endif

                                    @if($row->hostel_accommodation)
                                    <div class="col-md-6">
                                        <p><mark class="text-primary">Hostel Accommodation:</mark> {{ $row->hostel_accommodation }}</p>
                                        @if($row->hostel_accommodation_text)<p><mark class="text-primary">Hostel Notes:</mark> {{ $row->hostel_accommodation_text }}</p>@endif
                                        <hr/>
                                    </div>
                                    @endif

                                    @if($row->employment_status)
                                    <div class="col-md-6">
                                        <p><mark class="text-primary">Employment Status:</mark> {{ $row->employment_status }}</p>
                                        @if($row->employment_text)<p><mark class="text-primary">Employment Details:</mark> {{ $row->employment_text }}</p>@endif
                                        <hr/>
                                    </div>
                                    @endif

                                    @if($row->english_proficiency)
                                    <div class="col-md-6">
                                        <p><mark class="text-primary">English Proficiency:</mark> {{ $row->english_proficiency }}</p>
                                        @if($row->ielts_score)<p><mark class="text-primary">IELTS Score:</mark> {{ $row->ielts_score }}</p>@endif
                                        <hr/>
                                    </div>
                                    @endif

                                    @if($row->offense)
                                    <div class="col-md-6">
                                        <p><mark class="text-primary">Disciplinary Offense:</mark> {{ $row->offense }}</p>
                                        @if($row->offense_text)<p><mark class="text-primary">Offense Details:</mark> {{ $row->offense_text }}</p>@endif
                                        <hr/>
                                    </div>
                                    @endif

                                    @if($row->criminally_convicted)
                                    <div class="col-md-6">
                                        <p><mark class="text-primary">Criminally Convicted:</mark> {{ $row->criminally_convicted }}</p>
                                        @if($row->criminal_convicted_text)<p><mark class="text-primary">Conviction Details:</mark> {{ $row->criminal_convicted_text }}</p>@endif
                                        <hr/>
                                    </div>
                                    @endif

                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- School & College Documents --}}
            @if(field('application_school_transcript')->status == 1)
            <div class="col-md-3">
                @if(is_file('uploads/'.$path.'/'.$row->school_transcript))
                <p class="text-muted small">School Transcript</p>
                <a href="{{ asset('uploads/'.$path.'/'.$row->school_transcript) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/'.$path.'/'.$row->school_transcript) }}" class="img-fluid">
                </a>
                @endif
            </div>
            @endif

            @if(field('application_school_certificate')->status == 1)
            <div class="col-md-3">
                @if(is_file('uploads/'.$path.'/'.$row->school_certificate))
                <p class="text-muted small">School Certificate</p>
                <a href="{{ asset('uploads/'.$path.'/'.$row->school_certificate) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/'.$path.'/'.$row->school_certificate) }}" class="img-fluid">
                </a>
                @endif
            </div>
            @endif

            @if(field('application_collage_transcript')->status == 1)
            <div class="col-md-3">
                @if(is_file('uploads/'.$path.'/'.$row->collage_transcript))
                <p class="text-muted small">College Transcript</p>
                <a href="{{ asset('uploads/'.$path.'/'.$row->collage_transcript) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/'.$path.'/'.$row->collage_transcript) }}" class="img-fluid">
                </a>
                @endif
            </div>
            @endif

            @if(field('application_collage_certificate')->status == 1)
            <div class="col-md-3">
                @if(is_file('uploads/'.$path.'/'.$row->collage_certificate))
                <p class="text-muted small">College Certificate</p>
                <a href="{{ asset('uploads/'.$path.'/'.$row->collage_certificate) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/'.$path.'/'.$row->collage_certificate) }}" class="img-fluid">
                </a>
                @endif
            </div>
            @endif

            {{-- Diploma Documents --}}
            @if($row->diploma_transcript)
            <div class="col-md-3">
                @if(is_file('uploads/'.$path.'/'.$row->diploma_transcript))
                <p class="text-muted small">Diploma Transcript</p>
                <a href="{{ asset('uploads/'.$path.'/'.$row->diploma_transcript) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/'.$path.'/'.$row->diploma_transcript) }}" class="img-fluid">
                </a>
                @endif
            </div>
            @endif

            @if($row->diploma_certificate)
            <div class="col-md-3">
                @if(is_file('uploads/'.$path.'/'.$row->diploma_certificate))
                <p class="text-muted small">Diploma Certificate</p>
                <a href="{{ asset('uploads/'.$path.'/'.$row->diploma_certificate) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/'.$path.'/'.$row->diploma_certificate) }}" class="img-fluid">
                </a>
                @endif
            </div>
            @endif

            {{-- Bachelor Documents --}}
            @if($row->bachelor_transcript)
            <div class="col-md-3">
                @if(is_file('uploads/'.$path.'/'.$row->bachelor_transcript))
                <p class="text-muted small">Bachelor Transcript</p>
                <a href="{{ asset('uploads/'.$path.'/'.$row->bachelor_transcript) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/'.$path.'/'.$row->bachelor_transcript) }}" class="img-fluid">
                </a>
                @endif
            </div>
            @endif

            @if($row->bachelor_certificate)
            <div class="col-md-3">
                @if(is_file('uploads/'.$path.'/'.$row->bachelor_certificate))
                <p class="text-muted small">Bachelor Certificate</p>
                <a href="{{ asset('uploads/'.$path.'/'.$row->bachelor_certificate) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/'.$path.'/'.$row->bachelor_certificate) }}" class="img-fluid">
                </a>
                @endif
            </div>
            @endif

            {{-- Other Qualification Documents --}}
            @if($row->other_edu_transcript)
            <div class="col-md-3">
                @if(is_file('uploads/'.$path.'/'.$row->other_edu_transcript))
                <p class="text-muted small">Other Qualification Transcript</p>
                <a href="{{ asset('uploads/'.$path.'/'.$row->other_edu_transcript) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/'.$path.'/'.$row->other_edu_transcript) }}" class="img-fluid">
                </a>
                @endif
            </div>
            @endif

            @if($row->other_edu_certificate)
            <div class="col-md-3">
                @if(is_file('uploads/'.$path.'/'.$row->other_edu_certificate))
                <p class="text-muted small">Other Qualification Certificate</p>
                <a href="{{ asset('uploads/'.$path.'/'.$row->other_edu_certificate) }}" data-lightbox="gallery">
                    <img src="{{ asset('uploads/'.$path.'/'.$row->other_edu_certificate) }}" class="img-fluid">
                </a>
                @endif
            </div>
            @endif
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
<script src="{{ asset('plugins/lightbox2-master/js/lightbox.min.js') }}"></script>
@endsection