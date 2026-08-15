@extends('admin.layouts.master')
@section('title', $title)
@section('page_css')
<link rel="stylesheet" href="{{ asset('plugins/lightbox2-master/css/lightbox.min.css') }}">
<style>
    :root {
        --primary-color: #3EA1E4;
        --primary-light: #6bb5ed;
        --primary-dark: #2c7bc0;
    }

    body {
        background: #f5f7fb;
    }

    /* Card Styles */
    .modern-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e5e9f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .card-header-modern {
        background: var(--primary-color);
        padding: 0.875rem 1.25rem;
        border-bottom: none;
    }

    .card-header-modern h5, .card-header-modern h6 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .card-header-modern i {
        margin-right: 8px;
    }

    /* Profile Sidebar */
    .profile-sidebar {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e9f0;
        margin-bottom: 1.5rem;
    }

    .profile-header {
        background: var(--primary-color);
        height: 80px;
        position: relative;
    }

    .profile-avatar {
        text-align: center;
        margin-top: -40px;
        position: relative;
        z-index: 1;
    }

    .profile-avatar img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        object-fit: cover;
        background: white;
    }

    .profile-info {
        padding: 0.75rem 1.25rem 1.25rem;
        text-align: center;
    }

    /* Info Lists */
    .info-list {
        padding: 0;
        margin: 0;
        list-style: none;
        border-top: 1px solid #eef2f7;
    }

    .info-list-item {
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
    }

    .info-list-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #6c757d;
        font-weight: 500;
    }

    .info-value {
        color: #2c3e50;
        font-weight: 500;
        text-align: right;
    }

    /* Detail Sections */
    .detail-section {
        padding: 1.25rem;
        border-bottom: 1px solid #eef2f7;
    }

    .detail-section:last-child {
        border-bottom: none;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 0.75rem;
    }

    .detail-item {
        background: #f8f9fc;
        padding: 0.625rem 0.875rem;
        border-radius: 8px;
        border: 1px solid #eef2f7;
    }

    .detail-item-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #8898aa;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .detail-item-value {
        font-size: 0.85rem;
        color: #2c3e50;
        font-weight: 500;
        word-break: break-word;
    }

    /* Document Grid - Simple & Clean */
    .document-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1.25rem;
    }

    .document-card {
        background: #f8f9fc;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
        border: 1px solid #e5e9f0;
    }

    .document-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .document-card a {
        text-decoration: none;
        display: block;
    }

    .document-preview {
        height: 160px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .document-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .file-icon {
        text-align: center;
    }

    .file-icon i {
        font-size: 4rem;
        color: var(--primary-color);
    }

    .document-info {
        padding: 0.625rem;
        text-align: center;
        background: white;
        border-top: 1px solid #eef2f7;
    }

    .document-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
        
        .document-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
        
        .info-list-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .info-value {
            text-align: left;
        }
    }

    @media print {
        /* Hide layout navigation and tab selection elements */
        .pcoded-navbar,
        .pcoded-header,
        .header-user-list,
        .header-chat,
        .loader-bg,
        .mb-4, /* Back button row */
        .btn,
        .btn-outline-secondary,
        #pills-tab, /* Hides the tab buttons */
        .p-3.border-bottom.bg-light /* Hides tab background panel */
        {
            display: none !important;
        }

        /* Reset container margins/paddings and layout shifts */
        .pcoded-navbar ~ .pcoded-main-container,
        .pcoded-navbar.navbar-collapsed ~ .pcoded-main-container,
        .pcoded-main-container,
        .pcoded-wrapper,
        .pcoded-content,
        .pcoded-inner-content,
        .main-body,
        .page-wrapper {
            margin: 0 !important;
            padding: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            background: none !important;
            position: relative !important;
        }

        /* Print Header (Visible only in print) */
        div.print-header {
            display: block !important;
            text-align: center;
            margin-top: 10px !important;
            margin-bottom: 25px !important;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        /* Structure columns to print properly */
        .row {
            display: block !important;
            margin: 0 !important;
            width: 100% !important;
        }
        
        .col-lg-4, .col-md-5, .col-lg-8, .col-md-7, .col-md-12, .col-md-6 {
            width: 100% !important;
            display: block !important;
            float: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Format profile-sidebar as a header block with photo on the right */
        .profile-sidebar {
            border: none !important;
            margin-bottom: 25px !important;
            padding: 0 !important;
            display: grid !important;
            grid-template-columns: 1fr 150px !important;
            gap: 20px !important;
            border-bottom: 2px solid #333 !important;
            padding-bottom: 15px !important;
        }

        .profile-header {
            display: none !important;
        }

        .profile-avatar {
            margin-top: 0 !important;
            grid-column: 2 !important;
            grid-row: 1 !important;
            text-align: right !important;
        }

        .profile-avatar img {
            width: 130px !important;
            height: 130px !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            object-fit: cover !important;
        }

        .profile-info {
            grid-column: 1 !important;
            grid-row: 1 !important;
            text-align: left !important;
            padding: 0 !important;
        }

        .profile-info h5 {
            font-size: 1.4rem !important;
            font-weight: bold !important;
            margin-bottom: 5px !important;
            color: #000 !important;
        }

        .profile-info p {
            font-size: 0.95rem !important;
            margin-bottom: 10px !important;
            color: #333 !important;
        }

        .profile-info .badge {
            display: inline-block !important;
            border: 1px solid #000 !important;
            padding: 3px 10px !important;
            border-radius: 4px !important;
            font-size: 0.8rem !important;
            background: none !important;
            color: #000 !important;
        }

        .info-list {
            grid-column: 1 / span 2 !important;
            grid-row: 2 !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 10px 30px !important;
            border-top: none !important;
            margin-top: 15px !important;
        }

        .info-list-item {
            border: none !important;
            border-bottom: 1px solid #eee !important;
            padding: 6px 0 !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            font-size: 0.85rem !important;
            background: none !important;
        }

        .info-label {
            font-weight: bold !important;
            color: #555 !important;
        }

        .info-label i {
            display: none !important;
        }

        .info-value {
            color: #000 !important;
            text-align: right !important;
        }

        /* Cards and Tab Panes */
        .modern-card, .tab-content {
            border: none !important;
            box-shadow: none !important;
            margin-bottom: 20px !important;
            background: none !important;
            padding: 0 !important;
        }

        .card-header-modern, .card-header {
            background: none !important;
            padding: 0 !important;
            border-bottom: 1.5px solid #333 !important;
            margin-bottom: 15px !important;
        }

        .card-header-modern h6, .card-header h6 {
            color: #000 !important;
            font-size: 1.05rem !important;
            font-weight: bold !important;
            text-transform: uppercase;
        }

        .card-header-modern i, .card-header i {
            display: none !important;
        }

        /* Display all tab panes in print */
        .tab-content > .tab-pane {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            background: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Detail Grid & Items */
        .detail-section, .card-body {
            padding: 0 !important;
        }

        .detail-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 10px 30px !important;
        }

        .detail-item {
            background: none !important;
            border: none !important;
            border-bottom: 1px solid #eee !important;
            border-radius: 0 !important;
            padding: 6px 0 !important;
            margin: 0 !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            box-shadow: none !important;
        }

        .detail-item-label {
            font-size: 0.85rem !important;
            color: #555 !important;
            font-weight: bold !important;
            margin: 0 !important;
            text-transform: none !important;
            letter-spacing: normal !important;
        }

        .detail-item-value {
            font-size: 0.85rem !important;
            color: #000 !important;
            text-align: right !important;
        }

        /* Address sections - full width rows for layout */
        .row.g-3 {
            display: flex !important;
            flex-direction: column !important;
            gap: 15px !important;
        }

        /* Educational qualifications layout subheadings */
        .card-body h6 {
            font-size: 0.95rem !important;
            color: #000 !important;
            border-bottom: 1px dashed #333 !important;
            margin-top: 15px !important;
            margin-bottom: 10px !important;
            display: block !important;
            width: 100% !important;
        }

        /* Document grid list in print */
        .document-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 10px 30px !important;
            padding: 0 !important;
            margin-top: 15px !important;
        }

        .document-card {
            background: none !important;
            border: none !important;
            border-bottom: 1px solid #eee !important;
            border-radius: 0 !important;
            padding: 6px 0 !important;
            margin: 0 !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            box-shadow: none !important;
        }

        .document-preview {
            display: none !important;
        }

        .document-info {
            text-align: left !important;
            padding: 0 !important;
            background: none !important;
            border: none !important;
            width: 100% !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }

        .document-title {
            font-size: 0.85rem !important;
            font-weight: bold !important;
            color: #555 !important;
        }

        .document-info small {
            display: none !important;
        }
        
        .document-info:after {
            content: "Submitted" !important;
            font-size: 0.85rem !important;
            color: #000 !important;
            font-weight: normal !important;
        }

        .photo-sig-doc {
            display: none !important;
        }

        /* Signature styling */
        div.print-signature.d-none {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-end !important;
            margin-top: 50px !important;
            page-break-inside: avoid;
        }

        .print-signature:after {
            content: "Student's Signature" !important;
            display: block !important;
            font-weight: bold !important;
            margin-top: 10px !important;
            border-top: 1px solid #000 !important;
            width: 200px !important;
            text-align: center !important;
            font-size: 0.9rem !important;
        }

        .print-signature img {
            max-height: 60px !important;
            border: none !important;
            padding: 0 !important;
        }
    }
</style>
@endsection
@section('content')

@php
    $student = $row;
    $curr_enroll = \App\Models\Student::enroll($row->id);
    if (!function_exists('field')) {
        function field($slug) {
            return \App\Models\Field::field($slug);
        }
    }
    if (!function_exists('student_has_file')) {
        function student_has_file($dir, $file) {
            if (empty($file)) return false;
            return is_file($dir . '/' . $file) || is_file('public/' . $dir . '/' . $file);
        }
    }
@endphp

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Print-only Header -->
        <div class="print-header d-none">
            @if(isset($setting))
                @if(is_file('uploads/setting/'.$setting->logo_path))
                    <img src="{{ asset('uploads/setting/'.$setting->logo_path) }}" alt="Logo" style="max-height: 60px; margin-bottom: 10px;">
                @endif
                <h3>{{ $setting->title }}</h3>
            @else
                <h3>Central University of Science and Technology</h3>
            @endif
            <h4>Student Profile</h4>
        </div>

        <!-- Page Header -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">
                    <i class="fas fa-user-graduate" style="color: var(--primary-color);"></i> 
                    {{ $title }}
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary text-white btn-sm me-2">
                        <i class="fas fa-print me-1"></i>Print
                    </button>
                    <a href="{{ route('admin.student.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>{{ __('btn_back') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- [ Main Content ] start -->
        <div class="row g-4">
            <!-- Left Sidebar -->
            <div class="col-lg-4 col-md-5">
                <div class="profile-sidebar">
                    <div class="profile-header"></div>
                    <div class="profile-avatar">
                        @if(student_has_file('uploads/'.$path, $row->photo))
                        <img src="{{ asset('uploads/'.$path.'/'.$row->photo) }}" alt="{{ __('field_photo') }}" onerror="this.src='{{ asset('images/user/avatar-2.jpg') }}';">
                        @else
                        <img src="{{ asset('images/user/avatar-2.jpg') }}" alt="{{ __('field_photo') }}">
                        @endif
                    </div>
                    <div class="profile-info">
                        <h5 class="mb-1" style="font-size: 1rem;">{{ $row->first_name }} {{ $row->last_name }}</h5>
                        @if(isset($row->student_id))
                        <p class="text-muted small mb-2">ID: #{{ $row->student_id }}</p>
                        @endif
                        
                        <div class="mt-2">
                            @foreach($row->statuses as $status)
                                <span class="badge bg-primary text-white" style="font-size: 0.75rem; padding: 4px 8px;">{{ $status->title }}</span>
                            @endforeach
                        </div>
                    </div>

                    <ul class="info-list">
                        <li class="info-list-item">
                            <span class="info-label"><i class="far fa-envelope me-2"></i>{{ __('field_email') }}</span>
                            <span class="info-value">{{ $row->email }}</span>
                        </li>
                        <li class="info-list-item">
                            <span class="info-label"><i class="fas fa-phone-alt me-2"></i>{{ __('field_phone') }}</span>
                            <span class="info-value">{{ $row->phone }}</span>
                        </li>
                        <li class="info-list-item">
                            <span class="info-label"><i class="fas fa-users me-2"></i>{{ __('field_batch') }}</span>
                            <span class="info-value">{{ $row->batch->title ?? 'N/A' }}</span>
                        </li>
                        <li class="info-list-item">
                            <span class="info-label"><i class="fas fa-graduation-cap me-2"></i>{{ __('field_program') }}</span>
                            <span class="info-value">{{ $row->program->title ?? 'N/A' }}</span>
                        </li>
                        <li class="info-list-item">
                            <span class="info-label"><i class="far fa-calendar-alt me-2"></i>{{ __('field_admission_date') }}</span>
                            <span class="info-value">
                                @if(isset($setting->date_format))
                                {{ date($setting->date_format, strtotime($row->admission_date)) }}
                                @else
                                {{ date("Y-m-d", strtotime($row->admission_date)) }}
                                @endif
                            </span>
                        </li>
                        @if(isset($row->registration_no))
                        <li class="info-list-item">
                            <span class="info-label"><i class="far fa-question-circle me-2"></i>{{ __('field_registration_no') }}</span>
                            <span class="info-value">#{{ $row->registration_no }}</span>
                        </li>
                        @endif
                    </ul>

                    @php
                        $total_credits = 0;
                        $total_cgpa = 0;
                    @endphp
                    @foreach( $row->studentEnrolls as $key => $item )
                        @if(isset($item->subjectMarks))
                        @foreach($item->subjectMarks as $mark)
                            @php
                            $marks_per = round($mark->total_marks);
                            @endphp

                            @foreach($grades as $grade)
                            @if($marks_per >= $grade->min_mark && $marks_per <= $grade->max_mark)
                            @php
                            if($grade->point > 0){
                            $total_cgpa = $total_cgpa + ($grade->point * $mark->subject->credit_hour);
                            $total_credits = $total_credits + $mark->subject->credit_hour;
                            }
                            @endphp
                            @break
                            @endif
                            @endforeach
                        @endforeach
                        @endif
                    @endforeach

                    {{-- Commented out Credits / GPA block --}}
                    {{--
                    <div class="card-body border-top">
                        <div class="row text-center">
                            <div class="col">
                                <h6 class="mb-1">{{ number_format((float)$total_credits, 2, '.', '') }}</h6>
                                <p class="mb-0 text-muted small">{{ __('field_total_credit_hour') }}</p>
                            </div>
                            <div class="col border-start">
                                <h6 class="mb-1">
                                    @php
                                    if($total_credits <= 0){
                                        $total_credits = 1;
                                    }
                                    $com_gpa = $total_cgpa / $total_credits;
                                    echo number_format((float)$com_gpa, 2, '.', '');
                                    @endphp
                                </h6>
                                <p class="mb-0 text-muted small">{{ __('field_cumulative_gpa') }}</p>
                            </div>
                        </div>
                    </div>
                    --}}
                </div>
            </div>

            <!-- Right Workspace -->
            <div class="col-lg-8 col-md-7">
                <!-- Personal Information -->
                <div class="modern-card">
                    <div class="card-header-modern">
                        <h6><i class="fas fa-user-circle"></i> {{ __('field_personal_info') }}</h6>
                    </div>
                    <div class="detail-section">
                        <div class="detail-grid">
                            @if(field('student_father_name')->status == 1 && $row->father_name)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_father_name') }}</div>
                                <div class="detail-item-value">{{ $row->father_name }}</div>
                            </div>
                            @endif
                            
                            @if(field('student_father_occupation')->status == 1 && $row->father_occupation)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_father_occupation') }}</div>
                                <div class="detail-item-value">{{ $row->father_occupation }}</div>
                            </div>
                            @endif
                            
                            @if(field('student_mother_name')->status == 1 && $row->mother_name)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_mother_name') }}</div>
                                <div class="detail-item-value">{{ $row->mother_name }}</div>
                            </div>
                            @endif
                            
                            @if(field('student_mother_occupation')->status == 1 && $row->mother_occupation)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_mother_occupation') }}</div>
                                <div class="detail-item-value">{{ $row->mother_occupation }}</div>
                            </div>
                            @endif

                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_gender') }}</div>
                                <div class="detail-item-value">
                                    @if( $row->gender == 1 )
                                    {{ __('gender_male') }}
                                    @elseif( $row->gender == 2 )
                                    {{ __('gender_female') }}
                                    @elseif( $row->gender == 3 )
                                    {{ __('gender_other') }}
                                    @endif
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_dob') }}</div>
                                <div class="detail-item-value">
                                    @if(isset($setting->date_format))
                                    {{ date($setting->date_format, strtotime($row->dob)) }}
                                    @else
                                    {{ date("Y-m-d", strtotime($row->dob)) }}
                                    @endif
                                </div>
                            </div>

                            @if(field('student_emergency_phone')->status == 1 && $row->emergency_phone)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_emergency_phone') }}</div>
                                <div class="detail-item-value">{{ $row->emergency_phone }}</div>
                            </div>
                            @endif

                            @if(field('student_religion')->status == 1 && $row->religion)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_religion') }}</div>
                                <div class="detail-item-value">{{ $row->religion }}</div>
                            </div>
                            @endif

                            @if(field('student_caste')->status == 1 && $row->caste)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_caste') }}</div>
                                <div class="detail-item-value">{{ $row->caste }}</div>
                            </div>
                            @endif

                            @if(field('student_mother_tongue')->status == 1 && $row->mother_tongue)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_mother_tongue') }}</div>
                                <div class="detail-item-value">{{ $row->mother_tongue }}</div>
                            </div>
                            @endif

                            @if(field('student_nationality')->status == 1 && $row->nationality)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_nationality') }}</div>
                                <div class="detail-item-value">{{ $row->nationality }}</div>
                            </div>
                            @endif

                            @if(field('student_marital_status')->status == 1 && $row->marital_status)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_marital_status') }}</div>
                                <div class="detail-item-value">
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
                                </div>
                            </div>
                            @endif

                            @if(field('student_blood_group')->status == 1 && $row->blood_group)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_blood_group') }}</div>
                                <div class="detail-item-value">
                                    @if( $row->blood_group == 1 ) A+
                                    @elseif( $row->blood_group == 2 ) A-
                                    @elseif( $row->blood_group == 3 ) B+
                                    @elseif( $row->blood_group == 4 ) B-
                                    @elseif( $row->blood_group == 5 ) AB+
                                    @elseif( $row->blood_group == 6 ) AB-
                                    @elseif( $row->blood_group == 7 ) O+
                                    @elseif( $row->blood_group == 8 ) O-
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if(field('student_national_id')->status == 1 && $row->national_id)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_national_id') }}</div>
                                <div class="detail-item-value">{{ $row->national_id }}</div>
                            </div>
                            @endif

                            @if(field('student_passport_no')->status == 1 && $row->passport_no)
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_passport_no') }}</div>
                                <div class="detail-item-value">{{ $row->passport_no }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                @if(field('student_address')->status == 1)
                <div class="modern-card">
                    <div class="card-header-modern">
                        <h6><i class="fas fa-map-marked-alt"></i> {{ __('field_address') }}</h6>
                    </div>
                    <div class="detail-section">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="h6 text-muted mb-2 font-weight-bold" style="font-size: 0.8rem;">{{ __('field_present') }} {{ __('field_address') }}</div>
                                <div class="detail-grid" style="grid-template-columns: 1fr; gap: 0.5rem;">
                                    <div class="detail-item">
                                        <div class="detail-item-label">{{ __('field_province') }}</div>
                                        <div class="detail-item-value">{{ $row->presentProvince->title ?? 'N/A' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-item-label">{{ __('field_district') }}</div>
                                        <div class="detail-item-value">{{ $row->presentDistrict->title ?? 'N/A' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-item-label">{{ __('field_address') }}</div>
                                        <div class="detail-item-value">{{ $row->present_address ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="h6 text-muted mb-2 font-weight-bold" style="font-size: 0.8rem;">{{ __('field_permanent') }} {{ __('field_address') }}</div>
                                <div class="detail-grid" style="grid-template-columns: 1fr; gap: 0.5rem;">
                                    <div class="detail-item">
                                        <div class="detail-item-label">{{ __('field_province') }}</div>
                                        <div class="detail-item-value">{{ $row->permanentProvince->title ?? 'N/A' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-item-label">{{ __('field_district') }}</div>
                                        <div class="detail-item-value">{{ $row->permanentDistrict->title ?? 'N/A' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-item-label">{{ __('field_address') }}</div>
                                        <div class="detail-item-value">{{ $row->permanent_address ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Commented out Hostel & Transport block --}}
                {{--
                @if(field('student_hostel')->status == 1 || field('student_transport')->status == 1)
                <div class="modern-card">
                    <div class="card-header-modern">
                        <h6><i class="fas fa-hotel"></i> Hostel &amp; Transport</h6>
                    </div>
                    <div class="detail-section">
                        <div class="detail-grid">
                            @if(field('student_hostel')->status == 1 && isset($row->hostelRoom))
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_hostel') }}</div>
                                <div class="detail-item-value">{{ $row->hostelRoom->room->hostel->name ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_room') }}</div>
                                <div class="detail-item-value">{{ $row->hostelRoom->room->name ?? 'N/A' }}</div>
                            </div>
                            @endif

                            @if(field('student_transport')->status == 1 && isset($row->transport))
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_route') }}</div>
                                <div class="detail-item-value">{{ $row->transport->transportRoute->title ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-item-label">{{ __('field_vehicle') }}</div>
                                <div class="detail-item-value">{{ $row->transport->transportVehicle->number ?? 'N/A' }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                --}}
            </div>
        </div>

        <!-- Tabs Content section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="modern-card">
                    <div class="card-body p-0">
                        <div class="p-3 border-bottom bg-light">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-educational-tab" data-bs-toggle="pill" href="#pills-educational" role="tab" aria-controls="pills-educational" aria-selected="true">
                                        <i class="fas fa-graduation-cap me-1"></i>{{ __('tab_educational_info') }}
                                    </a>
                                </li>
                                {{-- Commented out bottom tabs --}}
                                {{--
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-fees-tab" data-bs-toggle="pill" href="#pills-fees" role="tab" aria-controls="pills-fees" aria-selected="false">{{ __('tab_fees_assign') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-book-tab" data-bs-toggle="pill" href="#pills-book" role="tab" aria-controls="pills-book" aria-selected="false">{{ __('tab_book_issues') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-notes-tab" data-bs-toggle="pill" href="#pills-notes" role="tab" aria-controls="pills-notes" aria-selected="false">{{ __('tab_notes') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-leave-tab" data-bs-toggle="pill" href="#pills-leave" role="tab" aria-controls="pills-leave" aria-selected="false">{{ __('tab_leave') }}</a>
                                </li>
                                --}}
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-documents-tab" data-bs-toggle="pill" href="#pills-documents" role="tab" aria-controls="pills-documents" aria-selected="false">
                                        <i class="fas fa-paperclip me-1"></i>{{ __('tab_documents') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="tab-content p-4" id="pills-tabContent">
                            <!-- Educational Info Tab -->
                            <div class="tab-pane fade show active" id="pills-educational" role="tabpanel" aria-labelledby="pills-educational-tab">
                                <!-- Academic Info Subcard -->
                                <div class="modern-card border border-light">
                                    <div class="card-header bg-light border-bottom p-3">
                                        <h6 class="mb-0 text-dark"><i class="fas fa-university me-2 text-primary"></i>Academic Details</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="detail-grid">
                                            <div class="detail-item">
                                                <div class="detail-item-label">{{ __('field_batch') }}</div>
                                                <div class="detail-item-value">{{ $row->batch->title ?? 'N/A' }}</div>
                                            </div>
                                            <div class="detail-item">
                                                <div class="detail-item-label">{{ __('field_program') }}</div>
                                                <div class="detail-item-value">{{ $row->program->title ?? 'N/A' }}</div>
                                            </div>
                                            <div class="detail-item">
                                                <div class="detail-item-label">{{ __('field_session') }}</div>
                                                <div class="detail-item-value">{{ $curr_enroll->session->title ?? 'N/A' }}</div>
                                            </div>

                                            <div class="detail-item">
                                                <div class="detail-item-label">{{ __('field_status') }}</div>
                                                <div class="detail-item-value">
                                                    @foreach($row->statuses as $status)
                                                        <span class="badge bg-primary text-white" style="font-size: 0.7rem; padding: 4px 6px;">{{ $status->title }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Secondary & Higher Secondary Info -->
                                <div class="row">
                                    @if(field('student_school_info')->status == 1 && $row->school_name)
                                    <div class="col-md-6 mb-4">
                                        <div class="modern-card h-100 border border-light">
                                            <div class="card-header bg-light border-bottom p-3">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-school me-2 text-primary"></i>{{ __('field_school_information') }}</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="detail-grid" style="grid-template-columns: 1fr; gap: 0.5rem;">
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">{{ __('field_school_name') }}</div>
                                                        <div class="detail-item-value">{{ $row->school_name }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Board/University</div>
                                                        <div class="detail-item-value">{{ $row->school_board ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Group/Discipline</div>
                                                        <div class="detail-item-value">{{ $row->school_group ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">{{ __('field_exam_id') }}</div>
                                                        <div class="detail-item-value">{{ $row->school_exam_id ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">{{ __('field_graduation_year') }}</div>
                                                        <div class="detail-item-value">{{ $row->school_graduation_year ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">{{ __('field_graduation_point') }}</div>
                                                        <div class="detail-item-value">{{ $row->school_graduation_point ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(field('student_collage_info')->status == 1 && $row->collage_name)
                                    <div class="col-md-6 mb-4">
                                        <div class="modern-card h-100 border border-light">
                                            <div class="card-header bg-light border-bottom p-3">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-building me-2 text-primary"></i>{{ __('field_college_information') }}</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="detail-grid" style="grid-template-columns: 1fr; gap: 0.5rem;">
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">{{ __('field_collage_name') }}</div>
                                                        <div class="detail-item-value">{{ $row->collage_name }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Board/University</div>
                                                        <div class="detail-item-value">{{ $row->collage_board ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Group/Discipline</div>
                                                        <div class="detail-item-value">{{ $row->collage_group ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">{{ __('field_exam_id') }}</div>
                                                        <div class="detail-item-value">{{ $row->collage_exam_id ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">{{ __('field_graduation_year') }}</div>
                                                        <div class="detail-item-value">{{ $row->collage_graduation_year ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">{{ __('field_graduation_point') }}</div>
                                                        <div class="detail-item-value">{{ $row->collage_graduation_point ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Diploma & Bachelor Degree -->
                                <div class="row">
                                    @if(field('student_diploma_info')->status == 1 && $row->diploma_name)
                                    <div class="col-md-6 mb-4">
                                        <div class="modern-card h-100 border border-light">
                                            <div class="card-header bg-light border-bottom p-3">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-scroll me-2 text-primary"></i>Diploma Information</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="detail-grid" style="grid-template-columns: 1fr; gap: 0.5rem;">
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Institution Name</div>
                                                        <div class="detail-item-value">{{ $row->diploma_name }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Board/University</div>
                                                        <div class="detail-item-value">{{ $row->diploma_board ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Group/Discipline</div>
                                                        <div class="detail-item-value">{{ $row->diploma_group ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Roll No / Exam ID</div>
                                                        <div class="detail-item-value">{{ $row->diploma_exam_id ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Graduation Year</div>
                                                        <div class="detail-item-value">{{ $row->diploma_graduation_year ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Result / GPA / CGPA</div>
                                                        <div class="detail-item-value">{{ $row->diploma_graduation_point ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(field('student_bachelor_info')->status == 1 && $row->bachelor_name)
                                    <div class="col-md-6 mb-4">
                                        <div class="modern-card h-100 border border-light">
                                            <div class="card-header bg-light border-bottom p-3">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-user-graduate me-2 text-primary"></i>Bachelor's Degree</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="detail-grid" style="grid-template-columns: 1fr; gap: 0.5rem;">
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Institution Name</div>
                                                        <div class="detail-item-value">{{ $row->bachelor_name }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Board/University</div>
                                                        <div class="detail-item-value">{{ $row->bachelor_board ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Group/Discipline</div>
                                                        <div class="detail-item-value">{{ $row->bachelor_group ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Roll No / Exam ID</div>
                                                        <div class="detail-item-value">{{ $row->bachelor_exam_id ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Graduation Year</div>
                                                        <div class="detail-item-value">{{ $row->bachelor_graduation_year ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Result / GPA / CGPA</div>
                                                        <div class="detail-item-value">{{ $row->bachelor_graduation_point ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Other Qualification -->
                                @if(field('student_other_edu_info')->status == 1 && $row->other_edu_name)
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="modern-card border border-light">
                                            <div class="card-header bg-light border-bottom p-3">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-certificate me-2 text-primary"></i>Other Qualification</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="detail-grid">
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Institution Name</div>
                                                        <div class="detail-item-value">{{ $row->other_edu_name }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Board/University</div>
                                                        <div class="detail-item-value">{{ $row->other_edu_board ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Group/Discipline</div>
                                                        <div class="detail-item-value">{{ $row->other_edu_group ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Roll No / Exam ID</div>
                                                        <div class="detail-item-value">{{ $row->other_edu_exam_id ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Graduation Year</div>
                                                        <div class="detail-item-value">{{ $row->other_edu_graduation_year ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Result / GPA / CGPA</div>
                                                        <div class="detail-item-value">{{ $row->other_edu_graduation_point ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Guardians Info -->
                                @if(field('student_relatives')->status == 1 && count($row->relatives) > 0)
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="modern-card border border-light">
                                            <div class="card-header bg-light border-bottom p-3">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-users me-2 text-primary"></i>{{ __('field_guardians_information') }}</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                @foreach($row->relatives as $key => $relative)
                                                <div class="mb-4 @if(!$loop->last) border-bottom pb-4 @endif">
                                                    <div class="h6 text-muted mb-2 font-weight-bold" style="font-size: 0.8rem;">Guardian {{ $key + 1 }} (Relation: {{ $relative->relation }})</div>
                                                    <div class="detail-grid">
                                                        <div class="detail-item">
                                                            <div class="detail-item-label">{{ __('field_name') }}</div>
                                                            <div class="detail-item-value">{{ $relative->name }}</div>
                                                        </div>
                                                        <div class="detail-item">
                                                            <div class="detail-item-label">{{ __('field_occupation') }}</div>
                                                            <div class="detail-item-value">{{ $relative->occupation ?? 'N/A' }}</div>
                                                        </div>
                                                        <div class="detail-item">
                                                            <div class="detail-item-label">{{ __('field_phone') }}</div>
                                                            <div class="detail-item-value">{{ $relative->phone ?? 'N/A' }}</div>
                                                        </div>
                                                        <div class="detail-item" style="grid-column: span 2;">
                                                            <div class="detail-item-label">{{ __('field_address') }}</div>
                                                            <div class="detail-item-value">{{ $relative->address ?? 'N/A' }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Additional Info -->
                                @if(field('student_disclosures')->status == 1 && ($row->medical_condition || $row->hostel_accommodation || $row->employment_status || $row->english_proficiency || $row->offense || $row->criminally_convicted))
                                <div class="row">
                                    <div class="col-12">
                                        <div class="modern-card border border-light">
                                            <div class="card-header bg-light border-bottom p-3">
                                                <h6 class="mb-0 text-dark"><i class="fas fa-info-circle me-2 text-primary"></i>Additional Information</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="detail-grid">
                                                    @if($row->medical_condition)
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Medical Condition</div>
                                                        <div class="detail-item-value">{{ $row->medical_condition }}</div>
                                                    </div>
                                                    @endif

                                                    @if($row->hostel_accommodation)
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Hostel Accommodation Request</div>
                                                        <div class="detail-item-value">
                                                            {{ $row->hostel_accommodation }}
                                                            @if($row->hostel_accommodation_text) - {{ $row->hostel_accommodation_text }} @endif
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if($row->employment_status)
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Employment Status</div>
                                                        <div class="detail-item-value">
                                                            {{ $row->employment_status }}
                                                            @if($row->employment_text) - {{ $row->employment_text }} @endif
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if($row->english_proficiency)
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">English Proficiency</div>
                                                        <div class="detail-item-value">
                                                            {{ $row->english_proficiency }}
                                                            @if($row->ielts_score) (IELTS: {{ $row->ielts_score }}) @endif
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if($row->offense)
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Disciplinary Offense</div>
                                                        <div class="detail-item-value">
                                                            {{ $row->offense }}
                                                            @if($row->offense_text) - {{ $row->offense_text }} @endif
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if($row->criminally_convicted)
                                                    <div class="detail-item">
                                                        <div class="detail-item-label">Criminal Conviction</div>
                                                        <div class="detail-item-value">
                                                            {{ $row->criminally_convicted }}
                                                            @if($row->criminal_convicted_text) - {{ $row->criminal_convicted_text }} @endif
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            {{-- Commented out panes --}}
                            {{--
                            <div class="tab-pane fade" id="pills-fees" role="tabpanel" aria-labelledby="pills-fees-tab">
                                @isset($fees)
                                <div class="table-responsive">
                                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('field_session') }}</th>
                                                <th>{{ __('field_semester') }}</th>
                                                <th>{{ __('field_fees_type') }}</th>
                                                <th>{{ __('field_fee') }}</th>
                                                <th>{{ __('field_discount') }}</th>
                                                <th>{{ __('field_fine') }}</th>
                                                <th>{{ __('field_payment') }}</th>
                                                <th>{{ __('field_status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fees as $key => $fee)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $fee->studentEnroll->session->title ?? '' }}</td>
                                                <td>{{ $fee->studentEnroll->semester->title ?? '' }}</td>
                                                <td>{{ $fee->feesCategory->title ?? '' }}</td>
                                                <td>{{ number_format((float)$fee->fee_amount, 2, '.', '') }} {!! $setting->currency_symbol !!}</td>
                                                <td>{{ number_format((float)$fee->discount_amount, 2, '.', '') }} {!! $setting->currency_symbol !!}</td>
                                                <td>{{ number_format((float)$fee->fine_amount, 2, '.', '') }} {!! $setting->currency_symbol !!}</td>
                                                <td>{{ number_format((float)$fee->paid_amount, 2, '.', '') }} {!! $setting->currency_symbol !!}</td>
                                                <td>
                                                    @if($fee->status == 1)
                                                    <span class="badge badge-light-danger">{{ __('status_unpaid') }}</span>
                                                    @elseif($fee->status == 2)
                                                    <span class="badge badge-light-success">{{ __('status_paid') }}</span>
                                                    @elseif($fee->status == 3)
                                                    <span class="badge badge-light-warning">{{ __('status_semi_paid') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endisset
                            </div>
                            <div class="tab-pane fade" id="pills-book" role="tabpanel" aria-labelledby="pills-book-tab">
                                @isset($books)
                                <div class="table-responsive">
                                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('field_isbn') }}</th>
                                                <th>{{ __('field_book') }}</th>
                                                <th>{{ __('field_author') }}</th>
                                                <th>{{ __('field_issue_date') }}</th>
                                                <th>{{ __('field_due_return_date') }}</th>
                                                <th>{{ __('field_return_date') }}</th>
                                                <th>{{ __('field_status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($books as $key => $book)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $book->book->isbn ?? '' }}</td>
                                                <td>{{ $book->book->title ?? '' }}</td>
                                                <td>{{ $book->book->author ?? '' }}</td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($book->issue_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($book->issue_date)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($book->due_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($book->due_date)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($book->status == 2)
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($book->return_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($book->return_date)) }}
                                                    @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($book->status == 1)
                                                    <span class="badge badge-light-warning">{{ __('status_issued') }}</span>
                                                    @elseif($book->status == 2)
                                                    <span class="badge badge-light-success">{{ __('status_returned') }}</span>
                                                    @elseif($book->status == 3)
                                                    <span class="badge badge-light-danger">{{ __('status_lost') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endisset
                            </div>
                            <div class="tab-pane fade" id="pills-notes" role="tabpanel" aria-labelledby="pills-notes-tab">
                                @isset($notes)
                                <div class="table-responsive">
                                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('field_title') }}</th>
                                                <th>{{ __('field_note') }}</th>
                                                <th>{{ __('field_created_by') }}</th>
                                                <th>{{ __('field_created_at') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($notes as $key => $note)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $note->title }}</td>
                                                <td>{!! $note->note !!}</td>
                                                <td>{{ $note->noteBy->first_name ?? '' }} {{ $note->noteBy->last_name ?? '' }}</td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($note->created_at)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($note->created_at)) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endisset
                            </div>
                            <div class="tab-pane fade" id="pills-leave" role="tabpanel" aria-labelledby="pills-leave-tab">
                                @isset($leaves)
                                <div class="table-responsive">
                                    <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('field_leave_type') }}</th>
                                                <th>{{ __('field_apply_date') }}</th>
                                                <th>{{ __('field_start_date') }}</th>
                                                <th>{{ __('field_end_date') }}</th>
                                                <th>{{ __('field_status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leaves as $key => $leave)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $leave->leaveType->title ?? '' }}</td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($leave->apply_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($leave->apply_date)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($leave->start_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($leave->start_date)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($leave->end_date)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($leave->end_date)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($leave->status == 1)
                                                    <span class="badge badge-light-warning">{{ __('status_pending') }}</span>
                                                    @elseif($leave->status == 2)
                                                    <span class="badge badge-light-success">{{ __('status_approved') }}</span>
                                                    @elseif($leave->status == 3)
                                                    <span class="badge badge-light-danger">{{ __('status_rejected') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endisset
                            </div>
                            --}}

                            <!-- Documents Tab -->
                            <div class="tab-pane fade" id="pills-documents" role="tabpanel" aria-labelledby="pills-documents-tab">
                                @php
                                    $documentList = [];
                                    if(field('student_photo')->status == 1 && !empty($student->photo) && student_has_file('uploads/'.$path, $student->photo)) {
                                        $documentList[] = ['file' => $student->photo, 'label' => __('field_photo'), 'class' => 'photo-sig-doc'];
                                    }
                                    if(field('student_signature')->status == 1 && !empty($student->signature) && student_has_file('uploads/'.$path, $student->signature)) {
                                        $documentList[] = ['file' => $student->signature, 'label' => __('field_signature'), 'class' => 'photo-sig-doc'];
                                    }
                                    if(field('application_national_id_file')->status == 1 && !empty($student->national_id_file) && student_has_file('uploads/'.$path, $student->national_id_file)) {
                                        $documentList[] = ['file' => $student->national_id_file, 'label' => 'NID / Birth Certificate File'];
                                    }
                                    if(field('student_school_transcript')->status == 1 && !empty($student->school_transcript) && student_has_file('uploads/'.$path, $student->school_transcript)) {
                                        $documentList[] = ['file' => $student->school_transcript, 'label' => __('field_school_transcript')];
                                    }
                                    if(field('student_school_certificate')->status == 1 && !empty($student->school_certificate) && student_has_file('uploads/'.$path, $student->school_certificate)) {
                                        $documentList[] = ['file' => $student->school_certificate, 'label' => __('field_school_certificate')];
                                    }
                                    if(field('student_collage_transcript')->status == 1 && !empty($student->collage_transcript) && student_has_file('uploads/'.$path, $student->collage_transcript)) {
                                        $documentList[] = ['file' => $student->collage_transcript, 'label' => __('field_collage_transcript')];
                                    }
                                    if(field('student_collage_certificate')->status == 1 && !empty($student->collage_certificate) && student_has_file('uploads/'.$path, $student->collage_certificate)) {
                                        $documentList[] = ['file' => $student->collage_certificate, 'label' => __('field_collage_certificate')];
                                    }
                                    if(field('student_diploma_info')->status == 1 && !empty($student->diploma_transcript) && student_has_file('uploads/'.$path, $student->diploma_transcript)) {
                                        $documentList[] = ['file' => $student->diploma_transcript, 'label' => 'Diploma Transcript'];
                                    }
                                    if(field('student_diploma_info')->status == 1 && !empty($student->diploma_certificate) && student_has_file('uploads/'.$path, $student->diploma_certificate)) {
                                        $documentList[] = ['file' => $student->diploma_certificate, 'label' => 'Diploma Certificate'];
                                    }
                                    if(field('student_bachelor_info')->status == 1 && !empty($student->bachelor_transcript) && student_has_file('uploads/'.$path, $student->bachelor_transcript)) {
                                        $documentList[] = ['file' => $student->bachelor_transcript, 'label' => 'Bachelor Transcript'];
                                    }
                                    if(field('student_bachelor_info')->status == 1 && !empty($student->bachelor_certificate) && student_has_file('uploads/'.$path, $student->bachelor_certificate)) {
                                        $documentList[] = ['file' => $student->bachelor_certificate, 'label' => 'Bachelor Certificate'];
                                    }
                                    if(field('student_other_edu_info')->status == 1 && !empty($student->other_edu_transcript) && student_has_file('uploads/'.$path, $student->other_edu_transcript)) {
                                        $documentList[] = ['file' => $student->other_edu_transcript, 'label' => 'Other Transcript'];
                                    }
                                    if(field('student_other_edu_info')->status == 1 && !empty($student->other_edu_certificate) && student_has_file('uploads/'.$path, $student->other_edu_certificate)) {
                                        $documentList[] = ['file' => $student->other_edu_certificate, 'label' => 'Other Certificate'];
                                    }
                                    foreach($student->documents as $doc) {
                                        if(!empty($doc->attach) && student_has_file('uploads/'.$path, $doc->attach)) {
                                            $documentList[] = ['file' => $doc->attach, 'label' => $doc->title];
                                        }
                                    }
                                @endphp

                                <div class="document-grid">
                                    @forelse($documentList as $docItem)
                                        @php
                                            $fileUrl = asset('uploads/'.$path.'/'.$docItem['file']);
                                            $ext = strtolower(pathinfo($docItem['file'], PATHINFO_EXTENSION));
                                            $isImageFile = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        @endphp
                                        <div class="document-card {{ $docItem['class'] ?? '' }}">
                                            <a href="{{ $fileUrl }}" target="_blank">
                                                <div class="document-preview">
                                                    @if($isImageFile)
                                                        <img src="{{ $fileUrl }}" alt="{{ $docItem['label'] }}" style="width: 100%; height: 100%; object-fit: contain; background: #f5f7fb;">
                                                    @elseif($ext == 'pdf')
                                                        <div class="file-icon text-center">
                                                            <i class="fas fa-file-pdf" style="font-size: 3rem; color: #e74c3c;"></i>
                                                            <div style="font-size: 0.7rem; margin-top: 5px;">PDF Document</div>
                                                        </div>
                                                    @elseif(in_array($ext, ['doc', 'docx']))
                                                        <div class="file-icon text-center">
                                                            <i class="fas fa-file-word" style="font-size: 3rem; color: #3498db;"></i>
                                                            <div style="font-size: 0.7rem; margin-top: 5px;">Word Document</div>
                                                        </div>
                                                    @elseif(in_array($ext, ['xls', 'xlsx']))
                                                        <div class="file-icon text-center">
                                                            <i class="fas fa-file-excel" style="font-size: 3rem; color: #2ecc71;"></i>
                                                            <div style="font-size: 0.7rem; margin-top: 5px;">Excel Document</div>
                                                        </div>
                                                    @else
                                                        <div class="file-icon text-center">
                                                            <i class="fas fa-file-alt" style="font-size: 3rem; color: #95a5a6;"></i>
                                                            <div style="font-size: 0.7rem; margin-top: 5px;">{{ strtoupper($ext) }} File</div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="document-info">
                                                    <div class="document-title">{{ $docItem['label'] }}</div>
                                                    <small class="text-muted" style="font-size: 0.65rem;">Click to open</small>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="text-center p-4 text-muted w-100" style="grid-column: 1/-1;">
                                            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                            <p class="mb-0">No documents uploaded yet.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(field('student_signature')->status == 1 && !empty($student->signature) && student_has_file('uploads/'.$path, $student->signature))
        <div class="print-signature d-none">
            <img src="{{ asset('uploads/'.$path.'/'.$student->signature) }}" alt="Signature">
        </div>
        @endif

        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
<script src="{{ asset('plugins/lightbox2-master/js/lightbox.min.js') }}"></script>
@if(request()->has('print'))
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        setTimeout(() => {
            window.print();
        }, 500);
    });
</script>
@endif
@endsection