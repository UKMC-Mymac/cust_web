<!-- Sidemenu -->
<div class="navbar-content scroll-div ps ps--active-y">
    <ul class="nav pcoded-inner-navbar">

        <li class="nav-item <?php echo e(Request::is('admin/dashboard*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.dashboard.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-home"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_dashboard', 1)); ?></span>
            </a>
        </li>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['application-create', 'application-view', 'student-create', 'student-view', 'student-import', 'student-password-print', 'student-password-change', 'student-card', 'student-transfer-in-create', 'student-transfer-in-view', 'student-transfer-out-create', 'student-transfer-out-view', 'status-type-create', 'status-type-view', 'id-card-setting-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/admission*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-university"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_admission', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['application-create', 'application-view'])): ?>
                <li class="<?php echo e(Request::is('admin/admission/application*') && !Request::is('admin/admission/application-transaction*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.application.index')); ?>" class=""><?php echo e(trans_choice('module_application', 2)); ?></a></li>
                <li class="<?php echo e(Request::is('admin/admission/application-transaction*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.application.transaction')); ?>" class="">Application Fees</a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-view'])): ?>
                <li class="<?php echo e(Request::is('admin/admission/student') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student.index')); ?>" class=""><?php echo e(trans_choice('module_student', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['status-type-create', 'status-type-view'])): ?>
                <li class="<?php echo e(Request::is('admin/admission/status-type*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.status-type.index')); ?>" class=""><?php echo e(trans_choice('module_status_type', 2)); ?></a></li>
                <?php endif; ?>


            </ul>
        </li>
        <?php endif; ?>


        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['faculty-create', 'faculty-view', 'program-create', 'program-view', 'batch-create', 'batch-view', 'session-create', 'session-view', 'semester-create', 'semester-view', 'section-create', 'section-view', 'class-room-create', 'class-room-view', 'subject-create', 'subject-view', 'enroll-subject-create', 'enroll-subject-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/academic*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fab fa-accusoft"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_academic', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['faculty-create', 'faculty-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/faculty*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.faculty.index')); ?>" class=""><?php echo e(trans_choice('module_faculty', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['program-create', 'program-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/program*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.program.index')); ?>" class=""><?php echo e(trans_choice('module_program', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['batch-create', 'batch-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/batch*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.batch.index')); ?>" class=""><?php echo e(trans_choice('module_batch', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['session-create', 'session-view'])): ?>
                <li class="<?php echo e(Request::is('admin/academic/session*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.session.index')); ?>" class=""><?php echo e(trans_choice('module_session', 2)); ?></a></li>
                <?php endif; ?>. 

                
                
            </ul>
        </li>
        <?php endif; ?>

        

        

        

        

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-create', 'user-view', 'user-password-print', 'user-password-change', 'staff-note-create', 'staff-note-view', 'payroll-view', 'payroll-action', 'payroll-print', 'payroll-report', 'work-shift-type-create', 'work-shift-type-view', 'designation-create', 'designation-view', 'department-create', 'department-view', 'tax-setting-create', 'tax-setting-view', 'pay-slip-setting-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/staff*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-users-cog"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_human_resource', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-create', 'user-view', 'user-password-print', 'user-password-change',])): ?>
                <li class="<?php echo e(Request::is('admin/staff/user*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.user.index')); ?>" class=""><?php echo e(trans_choice('module_staff', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>


                


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['work-shift-type-create', 'work-shift-type-view'])): ?>
                <li class="<?php echo e(Request::is('admin/staff/work-shift-type*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.work-shift-type.index')); ?>" class=""><?php echo e(trans_choice('module_work_shift_type', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['designation-create', 'designation-view'])): ?>
                <li class="<?php echo e(Request::is('admin/staff/designation*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.designation.index')); ?>" class=""><?php echo e(trans_choice('module_designation', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['department-create', 'department-view'])): ?>
                <li class="<?php echo e(Request::is('admin/staff/department*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.department.index')); ?>" class=""><?php echo e(trans_choice('module_department', 2)); ?></a></li>
                <?php endif; ?>

                
            </ul>
        </li>
        <?php endif; ?>


        

        

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['email-notify-create', 'email-notify-view', 'sms-notify-create', 'sms-notify-view', 'event-create', 'event-view', 'event-calendar', 'notice-create', 'notice-view', 'notice-category-create', 'notice-category-view', 'result-create', 'result-view', 'class-schedule-create', 'class-schedule-view', 'academic-calendar-create', 'academic-calendar-view','chat-manage'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/communicate*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-bullhorn"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_communicate', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                

                
                
                
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['notice-create', 'notice-view'])): ?>
                <li class="<?php echo e(Request::is('admin/communicate/notice*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.notice.index')); ?>" class=""><?php echo e(trans_choice('module_notice', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('notice-category-create', 'notice-category-view')): ?>
                <li class="<?php echo e(Request::is('admin/communicate/notice-category*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.notice-category.index')); ?>" class=""><?php echo e(trans_choice('module_notice_category', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['result-create', 'result-view'])): ?>
                <li class="<?php echo e(Request::is('admin/communicate/result*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.result.index')); ?>" class=""><?php echo e(trans_choice('module_result', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['class-schedule-create', 'class-schedule-view'])): ?>
                <li class="<?php echo e(Request::is('admin/communicate/class-schedule*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.class-schedule.index')); ?>" class=""><?php echo e(trans_choice('module_class_schedule', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['academic-calendar-create', 'academic-calendar-view'])): ?>
                <li class="<?php echo e(Request::is('admin/communicate/academic-calendar*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.academic-calendar.index')); ?>" class=""><?php echo e(trans_choice('module_academic_calendar', 1)); ?> <?php echo e(__('list')); ?></a></li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('chat-manage')): ?>
                <li class="<?php echo e(Request::is('admin/chat*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.live-chat.index')); ?>" class="">Live Chat Inbox</a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        


        

        

        


        
                

                

                

                



                

                

                

                


                

                

                
            

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['topbar-setting-view', 'social-setting-view', 'footer-section-view', 'student-zone-view', 'club-view', 'navbar-view', 'navbar-create', 'slider-view', 'slider-create', 'about-us-view', 'feature-view', 'feature-create', 'campus-life-view', 'campus-life-create', 'why-choose-us-view', 'why-choose-us-create', 'apply-view', 'apply-create', 'course-view', 'course-create', 'web-event-view', 'web-event-create', 'news-view', 'news-create', 'gallery-view', 'gallery-create', 'faq-view', 'faq-create', 'testimonial-view', 'testimonial-create', 'page-view', 'page-create', 'members-view', 'members-create', 'call-to-action-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/web*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-globe"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_front_web', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('topbar-setting-view')): ?>
                <li class="<?php echo e(Request::is('admin/web/topbar-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.topbar-setting.index')); ?>" class=""><?php echo e(trans_choice('module_topbar_setting', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('social-setting-view')): ?>
                <li class="<?php echo e(Request::is('admin/web/social-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.social-setting.index')); ?>" class=""><?php echo e(trans_choice('module_social_setting', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['navbar-view', 'navbar-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/navbar*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.navbar.index')); ?>" class="">Navbar</a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['slider-view', 'slider-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/slider*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.slider.index')); ?>" class=""><?php echo e(trans_choice('module_slider', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['course-view', 'course-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/course*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.course.index')); ?>" class=""><?php echo e(trans_choice('module_course', 2)); ?></a></li>
                <li class="<?php echo e(Request::is('admin/web/school*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.school.index')); ?>" class="">Schools</a></li>
                <li class="<?php echo e(Request::is('admin/web/department*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.web-department.index')); ?>" class="">Departments</a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['why-choose-us-view', 'why-choose-us-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/why-choose-us*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.why-choose-us.index')); ?>" class="">Why Choose Us</a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['campus-life-view', 'campus-life-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/campus-life*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.campus-life.index')); ?>" class="">Campus Life</a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['testimonial-view', 'testimonial-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/testimonial*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.testimonial.index')); ?>" class=""><?php echo e(trans_choice('module_testimonial', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student-zone-view')): ?>
                <li class="<?php echo e(Request::is('admin/web/student-zone*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.student-zone.index')); ?>" class="">Student Zone</a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('club-view')): ?>
                <li class="<?php echo e(Request::is('admin/web/club*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.club.index')); ?>" class="">Student Clubs</a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['web-event-view', 'web-event-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/web-event*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.web-event.index')); ?>" class=""><?php echo e(trans_choice('module_event', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['apply-view', 'apply-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/apply*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.apply.index')); ?>" class="">Apply</a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['faq-view', 'faq-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/faq*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.faq.index')); ?>" class=""><?php echo e(trans_choice('module_faq', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('footer-section-view')): ?>
                <li class="<?php echo e(Request::is('admin/web/footer-section*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.footer-section.index')); ?>" class="">Footer Section</a></li>
                <?php endif; ?>

             

                

                

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['page-view', 'page-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/page*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.page.index')); ?>" class=""><?php echo e(trans_choice('module_page', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['members-view', 'members-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/members*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.members.index')); ?>" class=""><?php echo e(trans_choice('module_member', 2)); ?></a></li>
                <?php endif; ?>

                

              

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['gallery-view', 'gallery-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/gallery*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.gallery.index')); ?>" class=""><?php echo e(trans_choice('module_gallery', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['contact-view', 'contact-create'])): ?>
                <li class="<?php echo e(Request::is('admin/web/contact*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.contact.index')); ?>" class=""><?php echo e(trans_choice('module_contact', 1)); ?></a></li>
                <?php endif; ?>

            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['setting-view', 'province-view', 'province-create', 'district-view', 'district-create', 'language-view', 'language-create', 'translations-view', 'translations-create', 'setting-mail', 'setting-sms', 'setting-payment', 'application-setting-view', 'schedule-setting-view', 'role-view', 'role-edit', 'field-staff', 'field-student', 'field-application', 'student-panel-view'])): ?>
        <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/setting*') ? 'pcoded-trigger active' : ''); ?> <?php echo e(Request::is('admin/translations*') ? 'pcoded-trigger active' : ''); ?>">
            <a href="#!" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-cog"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_setting', 2)); ?></span>
            </a>
            <ul class="pcoded-submenu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-view')): ?>
                <li class="<?php echo e(Request::is('admin/setting') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.setting.index')); ?>" class=""><?php echo e(trans_choice('module_general_setting', 1)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['province-view', 'province-create'])): ?>
                <li class="<?php echo e(Request::is('admin/setting/province*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.province.index')); ?>" class=""><?php echo e(trans_choice('module_province', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['district-view', 'district-create'])): ?>
                <li class="<?php echo e(Request::is('admin/setting/district*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.district.index')); ?>" class=""><?php echo e(trans_choice('module_district', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['language-view', 'language-create'])): ?>
                <li class="<?php echo e(Request::is('admin/setting/language*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.language.index')); ?>" class=""><?php echo e(trans_choice('module_language', 2)); ?></a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['translations-view', 'translations-create'])): ?>
                <li class="<?php echo e(Request::is('admin/translations*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.translations.index')); ?>" class=""><?php echo e(trans_choice('module_translate', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-mail')): ?>
                <li class="<?php echo e(Request::is('admin/setting/mail-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.mail-setting.index')); ?>" class=""><?php echo e(trans_choice('module_mail_setting', 1)); ?></a></li>
                <?php endif; ?>

                

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-payment')): ?>
                <li class="<?php echo e(Request::is('admin/setting/payment-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.payment-setting.index')); ?>" class=""><?php echo e(trans_choice('module_payment_setting', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('application-setting-view')): ?>
                <li class="<?php echo e(Request::is('admin/setting/application-setting*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.application-setting.index')); ?>" class=""><?php echo e(trans_choice('module_application_setting', 1)); ?></a></li>
                <?php endif; ?>

                

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['role-view', 'role-edit'])): ?>
                <li class="<?php echo e(Request::is('admin/setting/role*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.role.index')); ?>" class=""><?php echo e(trans_choice('module_role', 2)); ?></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['field-staff', 'field-student', 'field-application'])): ?>
                <li class="nav-item pcoded-hasmenu <?php echo e(Request::is('admin/setting/field*') ? 'pcoded-trigger active' : ''); ?>">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-mtext"><?php echo e(trans_choice('module_field_setting', 2)); ?></span>
                    </a>

                    <ul class="pcoded-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['field-staff'])): ?>
                        <li class="<?php echo e(Request::is('admin/setting/field-user*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.field.user')); ?>" class=""><?php echo e(trans_choice('module_staff', 2)); ?></a></li>
                        <?php endif; ?>

                        

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['field-application'])): ?>
                        <li class="<?php echo e(Request::is('admin/setting/field-application*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.field.application')); ?>" class=""><?php echo e(trans_choice('module_application', 2)); ?></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-view')): ?>
                        <li class="<?php echo e(Request::is('admin/setting/web-sections*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.web-sections.index')); ?>" class="">Web Sections</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                
                <?php if(Auth::user()->hasRole('Super Admin')): ?>
                <li class="<?php echo e(Request::is('admin/setting/custom-url*') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.custom-url.index')); ?>" class="">Custom URLs</a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['profile-view', 'profile-edit'])): ?>
        <li class="nav-item <?php echo e(Request::is('admin/profile*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.profile.index')); ?>" class="nav-link">
                <span class="pcoded-micon"><i class="fas fa-user-edit"></i></span>
                <span class="pcoded-mtext"><?php echo e(trans_choice('module_profile', 2)); ?></span>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</div>
<!-- End Sidebar --><?php /**PATH D:\office_project\cust\resources\views/admin/layouts/inc/sidebar.blade.php ENDPATH**/ ?>