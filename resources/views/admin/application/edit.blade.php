@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('css/pages/wizard.css') }}">
@endsection

@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_add') }} {{ __('field_student') }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>

                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>

                        {{-- Validation Alert --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        {{-- Error Alert --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mt-3 text-center" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    @php
                        function field($slug){
                            return \App\Models\Field::field($slug);
                        }
                    @endphp
                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data" style="display: none;">
                    @csrf

                        <input type="text" name="registration_no" value="{{ $row->registration_no }}" hidden>

                        <h3>{{ __('tab_basic_info') }}</h3>
                        <content class="form-step">
                            <!-- Form Start -->
                            <div class="row">
                            <div class="col-md-12">
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-12">
                                <label for="first_name">{{ __('field_first_name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $row->first_name }}" required>
                                <input type="hidden" name="last_name" value="">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_first_name') }}
                                </div>
                            </div>

                            @if(field('application_father_name')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="father_name">{{ __('field_father_name') }}</label>
                                <input type="text" class="form-control" name="father_name" id="father_name" value="{{ $row->father_name }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_father_name') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_father_occupation')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="father_occupation">{{ __('field_father_occupation') }}</label>
                                <input type="text" class="form-control" name="father_occupation" id="father_occupation" value="{{ $row->father_occupation }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_father_occupation') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_mother_name')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="mother_name">{{ __('field_mother_name') }}</label>
                                <input type="text" class="form-control" name="mother_name" id="mother_name" value="{{ $row->mother_name }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_mother_name') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_mother_occupation')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="mother_occupation">{{ __('field_mother_occupation') }}</label>
                                <input type="text" class="form-control" name="mother_occupation" id="mother_occupation" value="{{ $row->mother_occupation }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_mother_occupation') }}
                                </div>
                            </div>
                            @endif

                            <div class="form-group col-md-6">
                                <label for="phone">{{ __('field_phone') }} <span>*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone" value="{{ $row->phone }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_phone') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email">{{ __('field_email') }} <span>*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ $row->email }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_email') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="gender">{{ __('field_gender') }} <span>*</span></label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value="">{{ __('select') }}</option>
                                    <option value="1" @if( $row->gender == 1 ) selected @endif>{{ __('gender_male') }}</option>
                                    <option value="2" @if( $row->gender == 2 ) selected @endif>{{ __('gender_female') }}</option>
                                    <option value="3" @if( $row->gender == 3 ) selected @endif>{{ __('gender_other') }}</option>
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_gender') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="dob">{{ __('field_dob') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="dob" id="dob" value="{{ $row->dob }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_dob') }}
                                </div>
                            </div>

                            @if(field('application_emergency_phone')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="emergency_phone">{{ __('field_emergency_phone') }}</label>
                                <input type="text" class="form-control" name="emergency_phone" id="emergency_phone" value="{{ $row->emergency_phone }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_emergency_phone') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_religion')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="religion">{{ __('field_religion') }}</label>
                                <input type="text" class="form-control" name="religion" id="religion" value="{{ $row->religion }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_religion') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_caste')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="caste">{{ __('field_caste') }}</label>
                                <input type="text" class="form-control" name="caste" id="caste" value="{{ $row->caste }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_caste') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_mother_tongue')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="mother_tongue">{{ __('field_mother_tongue') }}</label>
                                <input type="text" class="form-control" name="mother_tongue" id="mother_tongue" value="{{ $row->mother_tongue }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_mother_tongue') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_nationality')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="nationality">{{ __('field_nationality') }}</label>
                                <input type="text" class="form-control" name="nationality" id="nationality" value="{{ $row->nationality }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_nationality') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_marital_status')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="marital_status">{{ __('field_marital_status') }}</label>
                                <select class="form-control" name="marital_status" id="marital_status">
                                    <option value="">{{ __('select') }}</option>
                                    <option value="1" @if( $row->marital_status == 1 ) selected @endif>{{ __('marital_status_single') }}</option>
                                    <option value="2" @if( $row->marital_status == 2 ) selected @endif>{{ __('marital_status_married') }}</option>
                                    <option value="3" @if( $row->marital_status == 3 ) selected @endif>{{ __('marital_status_widowed') }}</option>
                                    <option value="4" @if( $row->marital_status == 4 ) selected @endif>{{ __('marital_status_divorced') }}</option>
                                    <option value="5" @if( $row->marital_status == 5 ) selected @endif>{{ __('marital_status_other') }}</option>
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_marital_status') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_blood_group')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="blood_group">{{ __('field_blood_group') }}</label>
                                <select class="form-control" name="blood_group" id="blood_group">
                                    <option value="">{{ __('select') }}</option>
                                    <option value="1" @if( $row->blood_group == 1 ) selected @endif>{{ __('A+') }}</option>
                                    <option value="2" @if( $row->blood_group == 2 ) selected @endif>{{ __('A-') }}</option>
                                    <option value="3" @if( $row->blood_group == 3 ) selected @endif>{{ __('B+') }}</option>
                                    <option value="4" @if( $row->blood_group == 4 ) selected @endif>{{ __('B-') }}</option>
                                    <option value="5" @if( $row->blood_group == 5 ) selected @endif>{{ __('AB+') }}</option>
                                    <option value="6" @if( $row->blood_group == 6 ) selected @endif>{{ __('AB-') }}</option>
                                    <option value="7" @if( $row->blood_group == 7 ) selected @endif>{{ __('O+') }}</option>
                                    <option value="8" @if( $row->blood_group == 8 ) selected @endif>{{ __('O-') }}</option>
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_blood_group') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_national_id')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="national_id">{{ __('field_national_id') }}</label>
                                <input type="text" class="form-control" name="national_id" id="national_id" value="{{ $row->national_id }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_national_id') }}
                                </div>
                            </div>
                            @endif

                            @if(field('application_passport_no')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="passport_no">{{ __('field_passport_no') }}</label>
                                <input type="text" class="form-control" name="passport_no" id="passport_no" value="{{ $row->passport_no }}">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_passport_no') }}
                                </div>
                            </div>
                            @endif

                            <div class="form-group col-md-6">
                                <label for="admission_date">{{ __('field_admission_date') }} <span>*</span></label>
                                <input type="date" class="form-control date" name="admission_date" id="admission_date" value="{{ date('Y-m-d') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_admission_date') }}
                                </div>
                            </div>
                            </fieldset>
                            </div>
                            </div>

                            @if(field('application_address')->status == 1)
                            <div class="row">
                              <div class="col-md-6">
                                <fieldset class="row scheduler-border">
                                <legend>{{ __('field_present') }} {{ __('field_address') }}</legend>
                                @include('common.inc.present_province')

                                <div class="form-group col-md-12">
                                    <label for="present_address">{{ __('field_address') }}</label>
                                    <input type="text" class="form-control" name="present_address" id="present_address" value="{{ $row->present_address }}">

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_address') }}
                                    </div>
                                </div>
                                </fieldset>
                              </div>

                              <div class="col-md-6">
                                <fieldset class="row scheduler-border">
                                <legend>{{ __('field_permanent') }} {{ __('field_address') }}</legend>

                                @include('common.inc.permanent_province')

                                <div class="form-group col-md-12">
                                    <label for="permanent_address">{{ __('field_address') }}</label>
                                    <input type="text" class="form-control" name="permanent_address" id="permanent_address" value="{{ $row->permanent_address }}">

                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_address') }}
                                    </div>
                                </div>
                                </fieldset>
                              </div>
                            </div>
                            @endif
                            <!-- Form End -->
                        </content>

                        @if(field('application_school_info')->status == 1 || field('application_collage_info')->status == 1 || field('application_diploma_info')->status == 1 || field('application_bachelor_info')->status == 1 || field('application_other_edu_info')->status == 1)
                        <h3>{{ __('tab_educational_info') }}</h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            @if(field('application_school_info')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>{{ __('field_school_information') }}</legend>
                            <div class="form-group col-md-3">
                                <label for="school_name">{{ __('field_school_name') }}</label>
                                <input type="text" class="form-control" name="school_name" id="school_name" value="{{ $row->school_name }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="school_board">Board / University</label>
                                <input type="text" class="form-control" name="school_board" id="school_board" value="{{ $row->school_board }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="school_group">Group / Discipline</label>
                                <input type="text" class="form-control" name="school_group" id="school_group" value="{{ $row->school_group }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="school_exam_id">{{ __('field_exam_id') }}</label>
                                <input type="text" class="form-control" name="school_exam_id" id="school_exam_id" value="{{ $row->school_exam_id }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="school_graduation_year">{{ __('field_graduation_year') }}</label>
                                <input type="text" class="form-control" name="school_graduation_year" id="school_graduation_year" value="{{ $row->school_graduation_year }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="school_graduation_point">{{ __('field_graduation_point') }}</label>
                                <input type="text" class="form-control" name="school_graduation_point" id="school_graduation_point" value="{{ $row->school_graduation_point }}">
                            </div>
                            </fieldset>
                            @endif

                            @if(field('application_collage_info')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>{{ __('field_college_information') }}</legend>
                            <div class="form-group col-md-3">
                                <label for="collage_name">{{ __('field_collage_name') }}</label>
                                <input type="text" class="form-control" name="collage_name" id="collage_name" value="{{ $row->collage_name }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="collage_board">Board / University</label>
                                <input type="text" class="form-control" name="collage_board" id="collage_board" value="{{ $row->collage_board }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="collage_group">Group / Discipline</label>
                                <input type="text" class="form-control" name="collage_group" id="collage_group" value="{{ $row->collage_group }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="collage_exam_id">{{ __('field_exam_id') }}</label>
                                <input type="text" class="form-control" name="collage_exam_id" id="collage_exam_id" value="{{ $row->collage_exam_id }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="collage_graduation_year">{{ __('field_graduation_year') }}</label>
                                <input type="text" class="form-control" name="collage_graduation_year" id="collage_graduation_year" value="{{ $row->collage_graduation_year }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="collage_graduation_point">{{ __('field_graduation_point') }}</label>
                                <input type="text" class="form-control" name="collage_graduation_point" id="collage_graduation_point" value="{{ $row->collage_graduation_point }}">
                            </div>
                            </fieldset>
                            @endif

                            {{-- Diploma --}}
                            @if(field('application_diploma_info')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>Diploma (if applicable)</legend>
                            <div class="form-group col-md-3">
                                <label for="diploma_name">Institution Name</label>
                                <input type="text" class="form-control" name="diploma_name" id="diploma_name" value="{{ $row->diploma_name }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="diploma_board">Board / University</label>
                                <input type="text" class="form-control" name="diploma_board" id="diploma_board" value="{{ $row->diploma_board }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="diploma_group">Group / Discipline</label>
                                <input type="text" class="form-control" name="diploma_group" id="diploma_group" value="{{ $row->diploma_group }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="diploma_exam_id">Roll No / Exam ID</label>
                                <input type="text" class="form-control" name="diploma_exam_id" id="diploma_exam_id" value="{{ $row->diploma_exam_id }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="diploma_graduation_year">Graduation Year</label>
                                <input type="text" class="form-control" name="diploma_graduation_year" id="diploma_graduation_year" value="{{ $row->diploma_graduation_year }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="diploma_graduation_point">Result / GPA / CGPA</label>
                                <input type="text" class="form-control" name="diploma_graduation_point" id="diploma_graduation_point" value="{{ $row->diploma_graduation_point }}">
                            </div>
                            </fieldset>
                            @endif

                            {{-- Bachelor --}}
                            @if(field('application_bachelor_info')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>Bachelor's Degree (if applicable)</legend>
                            <div class="form-group col-md-3">
                                <label for="bachelor_name">Institution Name</label>
                                <input type="text" class="form-control" name="bachelor_name" id="bachelor_name" value="{{ $row->bachelor_name }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bachelor_board">Board / University</label>
                                <input type="text" class="form-control" name="bachelor_board" id="bachelor_board" value="{{ $row->bachelor_board }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bachelor_group">Group / Discipline</label>
                                <input type="text" class="form-control" name="bachelor_group" id="bachelor_group" value="{{ $row->bachelor_group }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bachelor_exam_id">Roll No / Exam ID</label>
                                <input type="text" class="form-control" name="bachelor_exam_id" id="bachelor_exam_id" value="{{ $row->bachelor_exam_id }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bachelor_graduation_year">Graduation Year</label>
                                <input type="text" class="form-control" name="bachelor_graduation_year" id="bachelor_graduation_year" value="{{ $row->bachelor_graduation_year }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bachelor_graduation_point">Result / GPA / CGPA</label>
                                <input type="text" class="form-control" name="bachelor_graduation_point" id="bachelor_graduation_point" value="{{ $row->bachelor_graduation_point }}">
                            </div>
                            </fieldset>
                            @endif

                            {{-- Other Education --}}
                            @if(field('application_other_edu_info')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>Other Qualification (if applicable)</legend>
                            <div class="form-group col-md-3">
                                <label for="other_edu_name">Institution Name</label>
                                <input type="text" class="form-control" name="other_edu_name" id="other_edu_name" value="{{ $row->other_edu_name }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="other_edu_board">Board / University</label>
                                <input type="text" class="form-control" name="other_edu_board" id="other_edu_board" value="{{ $row->other_edu_board }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="other_edu_group">Group / Discipline</label>
                                <input type="text" class="form-control" name="other_edu_group" id="other_edu_group" value="{{ $row->other_edu_group }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="other_edu_exam_id">Roll No / Exam ID</label>
                                <input type="text" class="form-control" name="other_edu_exam_id" id="other_edu_exam_id" value="{{ $row->other_edu_exam_id }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="other_edu_graduation_year">Graduation Year</label>
                                <input type="text" class="form-control" name="other_edu_graduation_year" id="other_edu_graduation_year" value="{{ $row->other_edu_graduation_year }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="other_edu_graduation_point">Result / GPA / CGPA</label>
                                <input type="text" class="form-control" name="other_edu_graduation_point" id="other_edu_graduation_point" value="{{ $row->other_edu_graduation_point }}">
                            </div>
                            </fieldset>
                            @endif
                            <!-- Form End--->
                        </content>
                        @endif

                        @if(
                            field('application_medical_condition')->status == 1 ||
                            field('application_hostel_accommodation')->status == 1 ||
                            field('application_employment_status')->status == 1 ||
                            field('application_english_proficiency')->status == 1 ||
                            field('application_disciplinary_offense')->status == 1 ||
                            field('application_criminally_convicted')->status == 1
                        )
                        <h3>Additional Information</h3>
                        <content class="form-step">
                            @if(field('application_medical_condition')->status == 1 || field('application_hostel_accommodation')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>Support & Welfare</legend>

                            @if(field('application_medical_condition')->status == 1)
                            <div class="form-group col-md-12">
                                <label for="medical_condition">Do you have any medical condition the university should be aware of?</label>
                                <input type="text" class="form-control" name="medical_condition" id="medical_condition" value="{{ $row->medical_condition }}" placeholder="If yes, please describe. Leave blank if none.">
                            </div>
                            @endif

                            @if(field('application_hostel_accommodation')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="hostel_accommodation">Do you require hostel accommodation?</label>
                                <select class="form-control" name="hostel_accommodation" id="hostel_accommodation">
                                    <option value="">{{ __('select') }}</option>
                                    <option value="Yes" @if($row->hostel_accommodation == 'Yes') selected @endif>Yes</option>
                                    <option value="No" @if($row->hostel_accommodation == 'No') selected @endif>No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="hostel_accommodation_text_group" style="{{ $row->hostel_accommodation == 'Yes' ? '' : 'display:none;' }}">
                                <label for="hostel_accommodation_text">Hostel Preference / Additional Notes</label>
                                <textarea class="form-control" name="hostel_accommodation_text" id="hostel_accommodation_text" rows="2">{{ $row->hostel_accommodation_text }}</textarea>
                            </div>
                            @endif
                            </fieldset>
                            @endif

                            @if(field('application_employment_status')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>Employment Status</legend>
                            <div class="form-group col-md-6">
                                <label for="employment_status">Are you currently employed?</label>
                                <select class="form-control" name="employment_status" id="employment_status">
                                    <option value="">{{ __('select') }}</option>
                                    <option value="Employed" @if($row->employment_status == 'Employed') selected @endif>Yes, Employed</option>
                                    <option value="Self-Employed" @if($row->employment_status == 'Self-Employed') selected @endif>Yes, Self-Employed</option>
                                    <option value="Unemployed" @if($row->employment_status == 'Unemployed') selected @endif>No, Unemployed</option>
                                    <option value="Student" @if($row->employment_status == 'Student') selected @endif>Student (Full-time)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="employment_text_group" style="{{ in_array($row->employment_status, ['Employed','Self-Employed']) ? '' : 'display:none;' }}">
                                <label for="employment_text">Employer / Business Details</label>
                                <textarea class="form-control" name="employment_text" id="employment_text" rows="2">{{ $row->employment_text }}</textarea>
                            </div>
                            </fieldset>
                            @endif

                            @if(field('application_english_proficiency')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>English Proficiency</legend>
                            <div class="form-group col-md-6">
                                <label for="english_proficiency">English Language Proficiency Level</label>
                                <select class="form-control" name="english_proficiency" id="english_proficiency">
                                    <option value="">{{ __('select') }}</option>
                                    <option value="Native" @if($row->english_proficiency == 'Native') selected @endif>Native / Fluent</option>
                                    <option value="Advanced" @if($row->english_proficiency == 'Advanced') selected @endif>Advanced</option>
                                    <option value="Intermediate" @if($row->english_proficiency == 'Intermediate') selected @endif>Intermediate</option>
                                    <option value="Beginner" @if($row->english_proficiency == 'Beginner') selected @endif>Beginner</option>
                                    <option value="IELTS" @if($row->english_proficiency == 'IELTS') selected @endif>IELTS Certified</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="ielts_score_group" style="{{ $row->english_proficiency == 'IELTS' ? '' : 'display:none;' }}">
                                <label for="ielts_score">IELTS Overall Band Score</label>
                                <input type="text" class="form-control" name="ielts_score" id="ielts_score" value="{{ $row->ielts_score }}" placeholder="e.g. 7.5">
                            </div>
                            </fieldset>
                            @endif

                            @if(field('application_disciplinary_offense')->status == 1 || field('application_criminally_convicted')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>Disciplinary & Criminal History</legend>
                            @if(field('application_disciplinary_offense')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="offense">Have you ever been subject to any disciplinary offense at an educational institution?</label>
                                <select class="form-control" name="offense" id="offense">
                                    <option value="">{{ __('select') }}</option>
                                    <option value="Yes" @if($row->offense == 'Yes') selected @endif>Yes</option>
                                    <option value="No" @if($row->offense == 'No') selected @endif>No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="offense_text_group" style="{{ $row->offense == 'Yes' ? '' : 'display:none;' }}">
                                <label for="offense_text">Please provide details</label>
                                <textarea class="form-control" name="offense_text" id="offense_text" rows="2">{{ $row->offense_text }}</textarea>
                            </div>
                            @endif

                            @if(field('application_criminally_convicted')->status == 1)
                            <div class="form-group col-md-6">
                                <label for="criminally_convicted">Have you ever been criminally convicted?</label>
                                <select class="form-control" name="criminally_convicted" id="criminally_convicted">
                                    <option value="">{{ __('select') }}</option>
                                    <option value="Yes" @if($row->criminally_convicted == 'Yes') selected @endif>Yes</option>
                                    <option value="No" @if($row->criminally_convicted == 'No') selected @endif>No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="criminal_convicted_text_group" style="{{ $row->criminally_convicted == 'Yes' ? '' : 'display:none;' }}">
                                <label for="criminal_convicted_text">Please provide details</label>
                                <textarea class="form-control" name="criminal_convicted_text" id="criminal_convicted_text" rows="2">{{ $row->criminal_convicted_text }}</textarea>
                            </div>
                            @endif
                            </fieldset>
                            @endif
                        </content>
                        @endif

                        <h3>Enrollment Information</h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                            <legend>{{ __('field_academic_information') }}</legend>
                            <div class="form-group col-md-6">
                                <label for="student_id">{{ __('field_student_id') }} <span>*</span></label>
                                <input type="text" class="form-control" name="student_id" id="student_id" value="{{ old('student_id') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_student_id') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="batch">{{ __('field_batch') }} <span>*</span></label>
                                <select class="form-control batch" name="batch" id="batch" required>
                                    <option value="">{{ __('select') }}</option>
                                    @foreach( $batches as $batch )
                                    <option value="{{ $batch->id }}" @if(old('batch') == $batch->id) selected @endif>{{ $batch->title }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_batch') }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                            <label for="program">{{ __('field_program') }} <span>*</span></label>
                                <select class="form-control program" name="program" id="program" required>
                                  <option value="">{{ __('select') }}</option>
                                  @foreach($programs as $program)
                                    <option value="{{ $program->id }}" @if($row->program_id == $program->id) selected @endif>{{ $program->title }}</option>
                                  @endforeach
                                </select>

                              <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_program') }}
                              </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="session">{{ __('field_session') }} <span>*</span></label>
                                <select class="form-control session" name="session" id="session" required>
                                  <option value="">{{ __('select') }}</option>
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_session') }}
                                </div>
                            </div>

                            {{-- <div class="form-group col-md-6">
                                <label for="semester">{{ __('field_semester') }} <span>*</span></label>
                                <select class="form-control semester" name="semester" id="semester" required>
                                  <option value="">{{ __('select') }}</option>
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_semester') }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="section">{{ __('field_section') }} <span>*</span></label>
                                <select class="form-control section" name="section" id="section" required>
                                  <option value="">{{ __('select') }}</option>
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_section') }}
                                </div>
                            </div> --}}

                            <div class="form-group col-md-6">
                                <label for="status">{{ __('field_status') }}</label>
                                <select class="form-control select2" name="statuses[]" id="status" multiple>
                                    @foreach( $statuses as $status )
                                    <option value="{{ $status->id }}" @if(old('status') == $status->id) selected @endif>{{ $status->title }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_status') }}
                                </div>
                            </div>

                            @php
                                $isPaidOnline = ($row->pay_status == 1 && in_array($row->payment_method, [11, 12, 13]));
                            @endphp

                            <div class="form-group col-md-6">
                                <label for="collected_fees">Collected fees @if(!$isPaidOnline) <span>*</span> @endif</label>
                                <input type="number" class="form-control" name="collected_fees" id="collected_fees" 
                                    @if($isPaidOnline)
                                        value="{{ $row->fee_amount ?? 0 }}" readonly
                                    @else
                                        value="{{ old('collected_fees', $row->fee_amount) }}" required
                                    @endif
                                    step="0.01">

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} Collected fees
                                </div>
                            </div>
                            </fieldset>
                            
                            @if(field('student_relatives')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>{{ __('field_guardians_information') }}</legend>
                            <div class="container-fluid">
                            <div id="inputFormField" class="row">

                            <div class="form-group col-md-4">
                                <label for="relation" class="form-label">{{ __('field_relation') }} <span>*</span></label>
                                <input type="text" class="form-control" name="relations[]" id="relation" value="{{ old('relation') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_relation') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="relative_name" class="form-label">{{ __('field_name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="relative_names[]" id="relative_name" value="{{ old('relative_name') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_name') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="occupation" class="form-label">{{ __('field_occupation') }} <span>*</span></label>
                                <input type="text" class="form-control" name="occupations[]" id="occupation" value="{{ old('occupation') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_occupation') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="relative_phone" class="form-label">{{ __('field_phone') }} <span>*</span></label>
                                <input type="text" class="form-control" name="relative_phones[]" id="relative_phone" value="{{ old('relative_phone') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_phone') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="address" class="form-label">{{ __('field_address') }} <span>*</span></label>
                                <input type="text" class="form-control" name="addresses[]" id="address" value="{{ old('address') }}" required>

                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_address') }}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <button id="removeField" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</button>
                            </div>

                            </div>

                            <div id="newField" class="clearfix"></div>
                            <div class="form-group">
                                <button id="addField" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</button>
                            </div>
                            </div>
                            </fieldset>
                            @endif
                            <!-- Form End--->
                        </content>

                        <h3>{{ __('tab_documents') }}</h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                            <legend>School &amp; College Documents</legend>
                            @if(field('application_school_transcript')->status == 1)
                                @include('admin.application.inc.file-field', ['name' => 'school_transcript', 'label' => __('field_school_transcript'), 'file' => $row->school_transcript, 'path' => $path])
                            @endif
                            @if(field('application_school_certificate')->status == 1)
                                @include('admin.application.inc.file-field', ['name' => 'school_certificate', 'label' => __('field_school_certificate'), 'file' => $row->school_certificate, 'path' => $path])
                            @endif
                            @if(field('application_collage_transcript')->status == 1)
                                @include('admin.application.inc.file-field', ['name' => 'collage_transcript', 'label' => __('field_collage_transcript'), 'file' => $row->collage_transcript, 'path' => $path])
                            @endif
                            @if(field('application_collage_certificate')->status == 1)
                                @include('admin.application.inc.file-field', ['name' => 'collage_certificate', 'label' => __('field_collage_certificate'), 'file' => $row->collage_certificate, 'path' => $path])
                            @endif
                            </fieldset>

                            @if(field('application_diploma_info')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>Diploma Documents (if applicable)</legend>
                            @include('admin.application.inc.file-field', ['name' => 'diploma_transcript', 'label' => 'Diploma Transcript', 'file' => $row->diploma_transcript, 'path' => $path])
                            @include('admin.application.inc.file-field', ['name' => 'diploma_certificate', 'label' => 'Diploma Certificate', 'file' => $row->diploma_certificate, 'path' => $path])
                            </fieldset>
                            @endif

                            @if(field('application_bachelor_info')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>Bachelor's Documents (if applicable)</legend>
                            @include('admin.application.inc.file-field', ['name' => 'bachelor_transcript', 'label' => 'Bachelor Transcript', 'file' => $row->bachelor_transcript, 'path' => $path])
                            @include('admin.application.inc.file-field', ['name' => 'bachelor_certificate', 'label' => 'Bachelor Certificate', 'file' => $row->bachelor_certificate, 'path' => $path])
                            </fieldset>
                            @endif

                            @if(field('application_other_edu_info')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>Other Qualification Documents (if applicable)</legend>
                            @include('admin.application.inc.file-field', ['name' => 'other_edu_transcript', 'label' => 'Transcript', 'file' => $row->other_edu_transcript, 'path' => $path])
                            @include('admin.application.inc.file-field', ['name' => 'other_edu_certificate', 'label' => 'Certificate', 'file' => $row->other_edu_certificate, 'path' => $path])
                            </fieldset>
                            @endif

                            <fieldset class="row scheduler-border">
                            <legend>Photo &amp; Signature</legend>
                            @if(field('application_photo')->status == 1)
                                @include('admin.application.inc.file-field', ['name' => 'photo', 'label' => __('field_photo').': '.__('image_size', ['height' => 300, 'width' => 300]), 'file' => $row->photo, 'path' => $path])
                            @endif
                            @if(field('application_signature')->status == 1)
                                @include('admin.application.inc.file-field', ['name' => 'signature', 'label' => __('field_signature').': '.__('image_size', ['height' => 100, 'width' => 300]), 'file' => $row->signature, 'path' => $path])
                            @endif
                            </fieldset>

                            @if(field('application_national_id_file')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>National ID / Birth Certificate</legend>
                                @include('admin.application.inc.file-field', ['name' => 'national_id_file', 'label' => 'NID / Birth Certificate File', 'file' => $row->national_id_file, 'path' => $path])
                            </fieldset>
                            @endif

                            @if(field('student_documents')->status == 1)
                            <fieldset class="row scheduler-border">
                            <legend>{{ __('field_upload') }} {{ __('field_document') }}</legend>
                            <div class="container-fluid">
                            <div id="newDocument" class="clearfix"></div>
                            <div class="form-group">
                                <button id="addDocument" type="button" class="btn btn-info"><i class="fas fa-plus"></i> {{ __('btn_add_new') }}</button>
                            </div>
                            </div>
                            </fieldset>
                            @endif
                            <!-- Form End--->
                        </content>
                    </form>
                    </div>

                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
    <!-- validate Js -->
    <script src="{{ asset('plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>

    <!-- Wizard Js -->
    <script src="{{ asset('js/pages/jquery.steps.js') }}"></script>

    <script type="text/javascript">
        "use strict";

        var fileSizeLimits = {
            photo: 1024 * 1024,
            signature: 300 * 1024,
            school_transcript: 512 * 1024,
            school_certificate: 512 * 1024,
            collage_transcript: 512 * 1024,
            collage_certificate: 512 * 1024,
            diploma_transcript: 512 * 1024,
            diploma_certificate: 512 * 1024,
            bachelor_transcript: 512 * 1024,
            bachelor_certificate: 512 * 1024,
            other_edu_transcript: 512 * 1024,
            other_edu_certificate: 512 * 1024,
            national_id_file: 512 * 1024,
        };

        $.validator.addMethod('maxfilesize', function (value, element, maxBytes) {
            if (element.type !== 'file' || !element.files || element.files.length === 0) {
                return true;
            }
            return element.files[0].size <= maxBytes;
        }, function (maxBytes) {
            var label = maxBytes >= 1024 * 1024
                ? (maxBytes / (1024 * 1024)) + ' MB'
                : Math.round(maxBytes / 1024) + ' KB';
            return 'The file must not be larger than ' + label + '.';
        });

        var form = $("#wizard-advanced-form").show();

        form.steps({
            headerTag: "h3",
            bodyTag: "content",
            transitionEffect: "slideLeft",
            labels: 
            {
                finish: "{{ __('btn_finish') }}",
                next: "{{ __('btn_next') }}",
                previous: "{{ __('btn_previous') }}",
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                $("#wizard-advanced-form").submit();
            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
                photo: { maxfilesize: fileSizeLimits.photo },
                signature: { maxfilesize: fileSizeLimits.signature },
                school_transcript: { maxfilesize: fileSizeLimits.school_transcript },
                school_certificate: { maxfilesize: fileSizeLimits.school_certificate },
                collage_transcript: { maxfilesize: fileSizeLimits.collage_transcript },
                collage_certificate: { maxfilesize: fileSizeLimits.collage_certificate },
                diploma_transcript: { maxfilesize: fileSizeLimits.diploma_transcript },
                diploma_certificate: { maxfilesize: fileSizeLimits.diploma_certificate },
                bachelor_transcript: { maxfilesize: fileSizeLimits.bachelor_transcript },
                bachelor_certificate: { maxfilesize: fileSizeLimits.bachelor_certificate },
                other_edu_transcript: { maxfilesize: fileSizeLimits.other_edu_transcript },
                other_edu_certificate: { maxfilesize: fileSizeLimits.other_edu_certificate },
                national_id_file: { maxfilesize: fileSizeLimits.national_id_file },
            }
        });

        form.find('input[type="file"]').on('change', function () {
            $(this).valid();
        });

        // --- Conditional Field Toggles ---
        $('#hostel_accommodation').on('change', function () {
            $('#hostel_accommodation_text_group').toggle($(this).val() === 'Yes');
        });

        $('#employment_status').on('change', function () {
            var v = $(this).val();
            $('#employment_text_group').toggle(v === 'Employed' || v === 'Self-Employed');
        });

        $('#english_proficiency').on('change', function () {
            $('#ielts_score_group').toggle($(this).val() === 'IELTS');
        });

        $('#offense').on('change', function () {
            $('#offense_text_group').toggle($(this).val() === 'Yes');
        });

        $('#criminally_convicted').on('change', function () {
            $('#criminal_convicted_text_group').toggle($(this).val() === 'Yes');
        });
    </script>

    <script type="text/javascript">
    (function ($) {
        "use strict";
        // add Field
        $(document).on('click', '#addField', function () {
            var html = '';
            html += '<hr/>';
            html += '<div id="inputFormField" class="row">';
            html += '<div class="form-group col-md-4"><label for="relation" class="form-label">{{ __('field_relation') }} <span>*</span></label><input type="text" class="form-control" name="relations[]" id="relation" value="{{ old('relation') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_relation') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="relative_name" class="form-label">{{ __('field_name') }} <span>*</span></label><input type="text" class="form-control" name="relative_names[]" id="relative_name" value="{{ old('relative_name') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_name') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="occupation" class="form-label">{{ __('field_occupation') }} <span>*</span></label><input type="text" class="form-control" name="occupations[]" id="occupation" value="{{ old('occupation') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_occupation') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="relative_phone" class="form-label">{{ __('field_phone') }} <span>*</span></label><input type="text" class="form-control" name="relative_phones[]" id="relative_phone" value="{{ old('relative_phone') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_phone') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="address" class="form-label">{{ __('field_address') }} <span>*</span></label><input type="text" class="form-control" name="addresses[]" id="address" value="{{ old('address') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_address') }}</div></div>';
            html += '<div class="form-group col-md-4"><button id="removeField" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</button></div>';
            html += '</div>';

            $('#newField').append(html);
        });

        // remove Field
        $(document).on('click', '#removeField', function () {
            $(this).closest('#inputFormField').remove();
        });
    }(jQuery));
    </script>

    <script type="text/javascript">
    (function ($) {
        "use strict";
        // add Field
        $(document).on('click', '#addDocument', function () {
            var html = '';
            html += '<hr/>';
            html += '<div id="documentFormField" class="row">';
            html += '<div class="form-group col-md-4"><label for="title" class="form-label">{{ __('field_title') }} <span>*</span></label><input type="text" class="form-control" name="titles[]" id="title" value="{{ old('title') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_title') }}</div></div>';
            html += '<div class="form-group col-md-4"><label for="document" class="form-label">{{ __('field_document') }} <span>*</span></label><input type="file" class="form-control" name="documents[]" id="document" value="{{ old('document') }}" required><div class="invalid-feedback">{{ __('required_field') }} {{ __('field_document') }}</div></div>';
            html += '<div class="form-group col-md-4"><button id="removeDocument" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> {{ __('btn_remove') }}</button></div>';
            html += '</div>';

            $('#newDocument').append(html);
        });

        // remove Field
        $(document).on('click', '#removeDocument', function () {
            $(this).closest('#documentFormField').remove();
        });
    }(jQuery));
    </script>


<!-- Filter Search -->
@include('common.js.batch_filter')
@endsection