<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('page_css'); ?>
    <!-- Wizard css -->
    <link rel="stylesheet" href="<?php echo e(asset('css/pages/wizard.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>New Application</h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>

                        
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><i class="fas fa-exclamation-triangle"></i> <?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show mt-3 text-center" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> <?php echo e(session('error')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php
                        if (!function_exists('field')) {
                            function field($slug){
                                return \App\Models\Field::field($slug);
                            }
                        }
                    ?>
                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="<?php echo e(route($route.'.store-offline')); ?>" method="post" enctype="multipart/form-data" style="display: none;">
                    <?php echo csrf_field(); ?>

                        <h3><?php echo e(__('tab_basic_info')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start -->
                            <div class="row">
                            <div class="col-md-12">
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-12">
                                <label for="first_name"><?php echo e(__('field_first_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo e(old('first_name')); ?>" required>
                                <input type="hidden" name="last_name" value="">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_first_name')); ?>

                                </div>
                            </div>

                            <?php if(field('application_father_name')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="father_name"><?php echo e(__('field_father_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="father_name" id="father_name" value="<?php echo e(old('father_name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_name')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_father_occupation')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="father_occupation"><?php echo e(__('field_father_occupation')); ?></label>
                                <input type="text" class="form-control" name="father_occupation" id="father_occupation" value="<?php echo e(old('father_occupation')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_occupation')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_mother_name')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="mother_name"><?php echo e(__('field_mother_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="mother_name" id="mother_name" value="<?php echo e(old('mother_name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_name')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_mother_occupation')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="mother_occupation"><?php echo e(__('field_mother_occupation')); ?></label>
                                <input type="text" class="form-control" name="mother_occupation" id="mother_occupation" value="<?php echo e(old('mother_occupation')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_occupation')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="form-group col-md-6">
                                <label for="phone"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e(old('phone')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email"><?php echo e(__('field_email')); ?> <span>*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo e(old('email')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_email')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="gender"><?php echo e(__('field_gender')); ?> <span>*</span></label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( old('gender') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('gender_male')); ?></option>
                                    <option value="2" <?php if( old('gender') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('gender_female')); ?></option>
                                    <option value="3" <?php if( old('gender') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('gender_other')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_gender')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="dob"><?php echo e(__('field_dob')); ?> <span>*</span></label>
                                <input type="date" class="form-control date" name="dob" id="dob" value="<?php echo e(old('dob')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_dob')); ?>

                                </div>
                            </div>

                            <?php if(field('application_emergency_phone')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="emergency_phone"><?php echo e(__('field_emergency_phone')); ?></label>
                                <input type="text" class="form-control" name="emergency_phone" id="emergency_phone" value="<?php echo e(old('emergency_phone')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_emergency_phone')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_religion')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="religion"><?php echo e(__('field_religion')); ?></label>
                                <input type="text" class="form-control" name="religion" id="religion" value="<?php echo e(old('religion')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_religion')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_caste')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="caste"><?php echo e(__('field_caste')); ?></label>
                                <input type="text" class="form-control" name="caste" id="caste" value="<?php echo e(old('caste')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_caste')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_mother_tongue')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="mother_tongue"><?php echo e(__('field_mother_tongue')); ?></label>
                                <input type="text" class="form-control" name="mother_tongue" id="mother_tongue" value="<?php echo e(old('mother_tongue')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_tongue')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_nationality')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="nationality"><?php echo e(__('field_nationality')); ?></label>
                                <input type="text" class="form-control" name="nationality" id="nationality" value="<?php echo e(old('nationality')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_nationality')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_marital_status')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="marital_status"><?php echo e(__('field_marital_status')); ?></label>
                                <select class="form-control" name="marital_status" id="marital_status">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( old('marital_status') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_single')); ?></option>
                                    <option value="2" <?php if( old('marital_status') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_married')); ?></option>
                                    <option value="3" <?php if( old('marital_status') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_widowed')); ?></option>
                                    <option value="4" <?php if( old('marital_status') == 4 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_divorced')); ?></option>
                                    <option value="5" <?php if( old('marital_status') == 5 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_other')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_marital_status')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_blood_group')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="blood_group"><?php echo e(__('field_blood_group')); ?></label>
                                <select class="form-control" name="blood_group" id="blood_group">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( old('blood_group') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('A+')); ?></option>
                                    <option value="2" <?php if( old('blood_group') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('A-')); ?></option>
                                    <option value="3" <?php if( old('blood_group') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('B+')); ?></option>
                                    <option value="4" <?php if( old('blood_group') == 4 ): ?> selected <?php endif; ?>><?php echo e(__('B-')); ?></option>
                                    <option value="5" <?php if( old('blood_group') == 5 ): ?> selected <?php endif; ?>><?php echo e(__('AB+')); ?></option>
                                    <option value="6" <?php if( old('blood_group') == 6 ): ?> selected <?php endif; ?>><?php echo e(__('AB-')); ?></option>
                                    <option value="7" <?php if( old('blood_group') == 7 ): ?> selected <?php endif; ?>><?php echo e(__('O+')); ?></option>
                                    <option value="8" <?php if( old('blood_group') == 8 ): ?> selected <?php endif; ?>><?php echo e(__('O-')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_blood_group')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_national_id')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="national_id"><?php echo e(__('field_national_id')); ?></label>
                                <input type="text" class="form-control" name="national_id" id="national_id" value="<?php echo e(old('national_id')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_national_id')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_passport_no')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="passport_no"><?php echo e(__('field_passport_no')); ?></label>
                                <input type="text" class="form-control" name="passport_no" id="passport_no" value="<?php echo e(old('passport_no')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_passport_no')); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                            </fieldset>
                            </div>
                            </div>

                            <?php if(field('application_address')->status == 1): ?>
                            <div class="row">
                              <div class="col-md-6">
                                <fieldset class="row scheduler-border">
                                <legend><?php echo e(__('field_present')); ?> <?php echo e(__('field_address')); ?></legend>
                                
                                <?php echo $__env->make('common.inc.present_province', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-12">
                                    <label for="present_address"><?php echo e(__('field_address')); ?></label>
                                    <input type="text" class="form-control" name="present_address" id="present_address" value="<?php echo e(old('present_address')); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

                                    </div>
                                </div>
                                </fieldset>
                              </div>

                              <div class="col-md-6">
                                <fieldset class="row scheduler-border">
                                <legend><?php echo e(__('field_permanent')); ?> <?php echo e(__('field_address')); ?></legend>
                                
                                <?php echo $__env->make('common.inc.permanent_province', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-12">
                                    <label for="permanent_address"><?php echo e(__('field_address')); ?></label>
                                    <input type="text" class="form-control" name="permanent_address" id="permanent_address" value="<?php echo e(old('permanent_address')); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

                                    </div>
                                </div>
                                </fieldset>
                              </div>
                            </div>
                            <?php endif; ?>

                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_academic_information')); ?></legend>
                            <div class="form-group col-md-6">
                            <label for="program"><?php echo e(__('field_program')); ?> <span>*</span></label>
                                <select class="form-control program" name="program" id="program" required>
                                  <option value=""><?php echo e(__('select')); ?></option>
                                  <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($program->id); ?>" <?php if(old('program') == $program->id): ?> selected <?php endif; ?>><?php echo e($program->title); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                              <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

                              </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="collected_fees">Collected fees <span>*</span></label>
                                <input type="number" class="form-control" name="collected_fees" id="collected_fees" value="<?php echo e(old('collected_fees')); ?>" required step="0.01">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> Collected fees
                                </div>
                            </div>
                            </fieldset>
                            <!-- Form End -->
                        </content>

                        <?php if(field('application_school_info')->status == 1 || field('application_collage_info')->status == 1 || field('application_diploma_info')->status == 1 || field('application_bachelor_info')->status == 1 || field('application_other_edu_info')->status == 1): ?>
                        <h3><?php echo e(__('tab_educational_info')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <?php if(field('application_school_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_school_information')); ?></legend>
                            <div class="form-group col-md-3">
                                <label for="school_name"><?php echo e(__('field_school_name')); ?> </label>
                                <input type="text" class="form-control" name="school_name" id="school_name" value="<?php echo e(old('school_name')); ?>">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_school_name')); ?></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="school_board">Board / University </label>
                                <input type="text" class="form-control" name="school_board" id="school_board" value="<?php echo e(old('school_board')); ?>">
                                <div class="invalid-feedback">This field is required.</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="school_group">Group / Discipline </label>
                                <input type="text" class="form-control" name="school_group" id="school_group" value="<?php echo e(old('school_group')); ?>">
                                <div class="invalid-feedback">This field is required.</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="school_exam_id"><?php echo e(__('field_exam_id')); ?> </label>
                                <input type="text" class="form-control" name="school_exam_id" id="school_exam_id" value="<?php echo e(old('school_exam_id')); ?>">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_exam_id')); ?></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="school_graduation_year"><?php echo e(__('field_graduation_year')); ?> </label>
                                <input type="text" class="form-control" name="school_graduation_year" id="school_graduation_year" value="<?php echo e(old('school_graduation_year')); ?>">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_year')); ?></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="school_graduation_point"><?php echo e(__('field_graduation_point')); ?> </label>
                                <input type="text" class="form-control" name="school_graduation_point" id="school_graduation_point" value="<?php echo e(old('school_graduation_point')); ?>">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_point')); ?></div>
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('application_collage_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_college_information')); ?></legend>
                            <div class="form-group col-md-3">
                                <label for="collage_name"><?php echo e(__('field_collage_name')); ?> </label>
                                <input type="text" class="form-control" name="collage_name" id="collage_name" value="<?php echo e(old('collage_name')); ?>">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_collage_name')); ?></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="collage_board">Board / University </label>
                                <input type="text" class="form-control" name="collage_board" id="collage_board" value="<?php echo e(old('collage_board')); ?>">
                                <div class="invalid-feedback">This field is required.</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="collage_group">Group / Discipline </label>
                                <input type="text" class="form-control" name="collage_group" id="collage_group" value="<?php echo e(old('collage_group')); ?>">
                                <div class="invalid-feedback">This field is required.</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="collage_exam_id"><?php echo e(__('field_exam_id')); ?> </label>
                                <input type="text" class="form-control" name="collage_exam_id" id="collage_exam_id" value="<?php echo e(old('collage_exam_id')); ?>">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_exam_id')); ?></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="collage_graduation_year"><?php echo e(__('field_graduation_year')); ?> </label>
                                <input type="text" class="form-control" name="collage_graduation_year" id="collage_graduation_year" value="<?php echo e(old('collage_graduation_year')); ?>">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_year')); ?></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="collage_graduation_point"><?php echo e(__('field_graduation_point')); ?> </label>
                                <input type="text" class="form-control" name="collage_graduation_point" id="collage_graduation_point" value="<?php echo e(old('collage_graduation_point')); ?>">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_point')); ?></div>
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('application_diploma_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>Diploma (if applicable)</legend>
                            <div class="form-group col-md-3">
                                <label for="diploma_name">Institution Name</label>
                                <input type="text" class="form-control" name="diploma_name" id="diploma_name" value="<?php echo e(old('diploma_name')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="diploma_board">Board / University</label>
                                <input type="text" class="form-control" name="diploma_board" id="diploma_board" value="<?php echo e(old('diploma_board')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="diploma_group">Group / Discipline</label>
                                <input type="text" class="form-control" name="diploma_group" id="diploma_group" value="<?php echo e(old('diploma_group')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="diploma_exam_id">Roll No / Exam ID</label>
                                <input type="text" class="form-control" name="diploma_exam_id" id="diploma_exam_id" value="<?php echo e(old('diploma_exam_id')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="diploma_graduation_year">Graduation Year</label>
                                <input type="text" class="form-control" name="diploma_graduation_year" id="diploma_graduation_year" value="<?php echo e(old('diploma_graduation_year')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="diploma_graduation_point">Result / GPA / CGPA</label>
                                <input type="text" class="form-control" name="diploma_graduation_point" id="diploma_graduation_point" value="<?php echo e(old('diploma_graduation_point')); ?>">
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('application_bachelor_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>Bachelor's Degree (if applicable)</legend>
                            <div class="form-group col-md-3">
                                <label for="bachelor_name">Institution Name</label>
                                <input type="text" class="form-control" name="bachelor_name" id="bachelor_name" value="<?php echo e(old('bachelor_name')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bachelor_board">Board / University</label>
                                <input type="text" class="form-control" name="bachelor_board" id="bachelor_board" value="<?php echo e(old('bachelor_board')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bachelor_group">Group / Discipline</label>
                                <input type="text" class="form-control" name="bachelor_group" id="bachelor_group" value="<?php echo e(old('bachelor_group')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bachelor_exam_id">Roll No / Exam ID</label>
                                <input type="text" class="form-control" name="bachelor_exam_id" id="bachelor_exam_id" value="<?php echo e(old('bachelor_exam_id')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bachelor_graduation_year">Graduation Year</label>
                                <input type="text" class="form-control" name="bachelor_graduation_year" id="bachelor_graduation_year" value="<?php echo e(old('bachelor_graduation_year')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bachelor_graduation_point">Result / GPA / CGPA</label>
                                <input type="text" class="form-control" name="bachelor_graduation_point" id="bachelor_graduation_point" value="<?php echo e(old('bachelor_graduation_point')); ?>">
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('application_other_edu_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>Other Qualification (if applicable)</legend>
                            <div class="form-group col-md-3">
                                <label for="other_edu_name">Institution Name</label>
                                <input type="text" class="form-control" name="other_edu_name" id="other_edu_name" value="<?php echo e(old('other_edu_name')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="other_edu_board">Board / University</label>
                                <input type="text" class="form-control" name="other_edu_board" id="other_edu_board" value="<?php echo e(old('other_edu_board')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="other_edu_group">Group / Discipline</label>
                                <input type="text" class="form-control" name="other_edu_group" id="other_edu_group" value="<?php echo e(old('other_edu_group')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="other_edu_exam_id">Roll No / Exam ID</label>
                                <input type="text" class="form-control" name="other_edu_exam_id" id="other_edu_exam_id" value="<?php echo e(old('other_edu_exam_id')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="other_edu_graduation_year">Graduation Year</label>
                                <input type="text" class="form-control" name="other_edu_graduation_year" id="other_edu_graduation_year" value="<?php echo e(old('other_edu_graduation_year')); ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="other_edu_graduation_point">Result / GPA / CGPA</label>
                                <input type="text" class="form-control" name="other_edu_graduation_point" id="other_edu_graduation_point" value="<?php echo e(old('other_edu_graduation_point')); ?>">
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <!-- Form End--->
                        </content>
                        <?php endif; ?>

                        <?php if(
                            field('application_medical_condition')->status == 1 ||
                            field('application_hostel_accommodation')->status == 1 ||
                            field('application_employment_status')->status == 1 ||
                            field('application_english_proficiency')->status == 1 ||
                            field('application_disciplinary_offense')->status == 1 ||
                            field('application_criminally_convicted')->status == 1
                        ): ?>
                        <h3>Additional Information</h3>
                        <content class="form-step">
                            <?php if(field('application_medical_condition')->status == 1 || field('application_hostel_accommodation')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>Support & Welfare</legend>

                            <?php if(field('application_medical_condition')->status == 1): ?>
                            <div class="form-group col-md-12">
                                <label for="medical_condition">Do you have any medical condition the university should be aware of?</label>
                                <input type="text" class="form-control" name="medical_condition" id="medical_condition" value="<?php echo e(old('medical_condition')); ?>" placeholder="If yes, please describe. Leave blank if none.">
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_hostel_accommodation')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="hostel_accommodation">Do you require hostel accommodation?</label>
                                <select class="form-control" name="hostel_accommodation" id="hostel_accommodation">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="Yes" <?php if(old('hostel_accommodation') == 'Yes'): ?> selected <?php endif; ?>>Yes</option>
                                    <option value="No" <?php if(old('hostel_accommodation') == 'No'): ?> selected <?php endif; ?>>No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="hostel_accommodation_text_group" style="<?php echo e(old('hostel_accommodation') == 'Yes' ? '' : 'display:none;'); ?>">
                                <label for="hostel_accommodation_text">Hostel Preference / Additional Notes</label>
                                <textarea class="form-control" name="hostel_accommodation_text" id="hostel_accommodation_text" rows="2"><?php echo e(old('hostel_accommodation_text')); ?></textarea>
                            </div>
                            <?php endif; ?>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('application_employment_status')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>Employment Status</legend>
                            <div class="form-group col-md-6">
                                <label for="employment_status">Are you currently employed?</label>
                                <select class="form-control" name="employment_status" id="employment_status">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="Employed" <?php if(old('employment_status') == 'Employed'): ?> selected <?php endif; ?>>Yes, Employed</option>
                                    <option value="Self-Employed" <?php if(old('employment_status') == 'Self-Employed'): ?> selected <?php endif; ?>>Yes, Self-Employed</option>
                                    <option value="Unemployed" <?php if(old('employment_status') == 'Unemployed'): ?> selected <?php endif; ?>>No, Unemployed</option>
                                    <option value="Student" <?php if(old('employment_status') == 'Student'): ?> selected <?php endif; ?>>Student (Full-time)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="employment_text_group" style="<?php echo e(in_array(old('employment_status'), ['Employed','Self-Employed']) ? '' : 'display:none;'); ?>">
                                <label for="employment_text">Employer / Business Details</label>
                                <textarea class="form-control" name="employment_text" id="employment_text" rows="2"><?php echo e(old('employment_text')); ?></textarea>
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('application_english_proficiency')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>English Proficiency</legend>
                            <div class="form-group col-md-6">
                                <label for="english_proficiency">English Language Proficiency Level</label>
                                <select class="form-control" name="english_proficiency" id="english_proficiency">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="Native" <?php if(old('english_proficiency') == 'Native'): ?> selected <?php endif; ?>>Native / Fluent</option>
                                    <option value="Advanced" <?php if(old('english_proficiency') == 'Advanced'): ?> selected <?php endif; ?>>Advanced</option>
                                    <option value="Intermediate" <?php if(old('english_proficiency') == 'Intermediate'): ?> selected <?php endif; ?>>Intermediate</option>
                                    <option value="Beginner" <?php if(old('english_proficiency') == 'Beginner'): ?> selected <?php endif; ?>>Beginner</option>
                                    <option value="IELTS" <?php if(old('english_proficiency') == 'IELTS'): ?> selected <?php endif; ?>>IELTS Certified</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="ielts_score_group" style="<?php echo e(old('english_proficiency') == 'IELTS' ? '' : 'display:none;'); ?>">
                                <label for="ielts_score">IELTS Overall Band Score</label>
                                <input type="text" class="form-control" name="ielts_score" id="ielts_score" value="<?php echo e(old('ielts_score')); ?>" placeholder="e.g. 7.5">
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('application_disciplinary_offense')->status == 1 || field('application_criminally_convicted')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>Disciplinary & Criminal History</legend>
                            <?php if(field('application_disciplinary_offense')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="offense">Have you ever been subject to any disciplinary offense at an educational institution?</label>
                                <select class="form-control" name="offense" id="offense">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="Yes" <?php if(old('offense') == 'Yes'): ?> selected <?php endif; ?>>Yes</option>
                                    <option value="No" <?php if(old('offense') == 'No'): ?> selected <?php endif; ?>>No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="offense_text_group" style="<?php echo e(old('offense') == 'Yes' ? '' : 'display:none;'); ?>">
                                <label for="offense_text">Please provide details</label>
                                <textarea class="form-control" name="offense_text" id="offense_text" rows="2"><?php echo e(old('offense_text')); ?></textarea>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_criminally_convicted')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="criminally_convicted">Have you ever been criminally convicted?</label>
                                <select class="form-control" name="criminally_convicted" id="criminally_convicted">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="Yes" <?php if(old('criminally_convicted') == 'Yes'): ?> selected <?php endif; ?>>Yes</option>
                                    <option value="No" <?php if(old('criminally_convicted') == 'No'): ?> selected <?php endif; ?>>No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="criminal_convicted_text_group" style="<?php echo e(old('criminally_convicted') == 'Yes' ? '' : 'display:none;'); ?>">
                                <label for="criminal_convicted_text">Please provide details</label>
                                <textarea class="form-control" name="criminal_convicted_text" id="criminal_convicted_text" rows="2"><?php echo e(old('criminal_convicted_text')); ?></textarea>
                            </div>
                            <?php endif; ?>
                            </fieldset>
                            <?php endif; ?>
                        </content>
                        <?php endif; ?>

                        <h3><?php echo e(__('tab_documents')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <fieldset class="row scheduler-border">
                            <legend>School &amp; College Documents</legend>
                            <?php if(field('application_school_transcript')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="school_transcript"><?php echo e(__('field_school_transcript')); ?> <span>(Max: 512 KB)</span> </label>
                                <input type="file" class="form-control" name="school_transcript" id="school_transcript">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_school_transcript')); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if(field('application_school_certificate')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="school_certificate"><?php echo e(__('field_school_certificate')); ?> <span>(Max: 512 KB)</span> </label>
                                <input type="file" class="form-control" name="school_certificate" id="school_certificate">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_school_certificate')); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if(field('application_collage_transcript')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="collage_transcript"><?php echo e(__('field_collage_transcript')); ?> <span>(Max: 512 KB)</span> </label>
                                <input type="file" class="form-control" name="collage_transcript" id="collage_transcript">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_collage_transcript')); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if(field('application_collage_certificate')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="collage_certificate"><?php echo e(__('field_collage_certificate')); ?> <span>(Max: 512 KB)</span> </label>
                                <input type="file" class="form-control" name="collage_certificate" id="collage_certificate">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_collage_certificate')); ?></div>
                            </div>
                            <?php endif; ?>
                            </fieldset>

                            <?php if(field('application_diploma_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>Diploma Documents (if applicable)</legend>
                            <div class="form-group col-md-6">
                                <label for="diploma_transcript">Diploma Transcript <span>(Max: 512 KB)</span></label>
                                <input type="file" class="form-control" name="diploma_transcript" id="diploma_transcript">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="diploma_certificate">Diploma Certificate <span>(Max: 512 KB)</span></label>
                                <input type="file" class="form-control" name="diploma_certificate" id="diploma_certificate">
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('application_bachelor_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>Bachelor's Documents (if applicable)</legend>
                            <div class="form-group col-md-6">
                                <label for="bachelor_transcript">Bachelor Transcript <span>(Max: 512 KB)</span></label>
                                <input type="file" class="form-control" name="bachelor_transcript" id="bachelor_transcript">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="bachelor_certificate">Bachelor Certificate <span>(Max: 512 KB)</span></label>
                                <input type="file" class="form-control" name="bachelor_certificate" id="bachelor_certificate">
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('application_other_edu_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>Other Qualification Documents (if applicable)</legend>
                            <div class="form-group col-md-6">
                                <label for="other_edu_transcript">Transcript <span>(Max: 512 KB)</span></label>
                                <input type="file" class="form-control" name="other_edu_transcript" id="other_edu_transcript">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="other_edu_certificate">Certificate <span>(Max: 512 KB)</span></label>
                                <input type="file" class="form-control" name="other_edu_certificate" id="other_edu_certificate">
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <fieldset class="row scheduler-border">
                            <legend>Photo &amp; Signature</legend>
                            <?php if(field('application_photo')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="photo"><?php echo e(__('field_photo')); ?>: <span><?php echo e(__('image_size', ['height' => 300, 'width' => 300])); ?> (Max: 1 MB)</span> </label>
                                <input type="file" class="form-control" name="photo" id="photo">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_photo')); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if(field('application_signature')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="signature"><?php echo e(__('field_signature')); ?>: <span><?php echo e(__('image_size', ['height' => 100, 'width' => 300])); ?> (Max: 300 KB)</span> </label>
                                <input type="file" class="form-control" name="signature" id="signature">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_signature')); ?></div>
                            </div>
                            <?php endif; ?>
                            </fieldset>

                            <?php if(field('application_national_id_file')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend>National ID / Birth Certificate</legend>
                            <div class="form-group col-md-6">
                                <label for="national_id_file">NID / Birth Certificate File <span>(Max: 512 KB)</span> </label>
                                <input type="file" class="form-control" name="national_id_file" id="national_id_file">
                                <div class="invalid-feedback"><?php echo e(__('required_field')); ?> NID / Birth Certificate File</div>
                            </div>
                            </fieldset>
                            <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
    <!-- validate Js -->
    <script src="<?php echo e(asset('plugins/jquery-validation/js/jquery.validate.min.js')); ?>"></script>

    <!-- Wizard Js -->
    <script src="<?php echo e(asset('js/pages/jquery.steps.js')); ?>"></script>

    <script type="text/javascript">
        "use strict";

        var fileSizeLimits = {
            photo: 1024 * 1024,
            signature: 300 * 1024,
            school_transcript: 512 * 1024,
            school_certificate: 512 * 1024,
            collage_transcript: 512 * 1024,
            collage_certificate: 512 * 1024,
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
                finish: "<?php echo e(__('btn_finish')); ?>",
                next: "<?php echo e(__('btn_next')); ?>",
                previous: "<?php echo e(__('btn_previous')); ?>",
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\office_project\cust\resources\views/admin/application/create-offline.blade.php ENDPATH**/ ?>