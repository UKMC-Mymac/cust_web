@extends('admin.layouts.master')
@section('title', $title)
@section('page_css')
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

    /* Badges */
    .badge-custom {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-pending {
        background: #fff3e0;
        color: #ff9800;
    }

    .badge-approved {
        background: #e8f5e9;
        color: #4caf50;
    }

    .badge-rejected {
        background: #ffebee;
        color: #f44336;
    }

    /* Detail Sections */
    .detail-section {
        padding: 1.25rem;
        border-bottom: 1px solid #eef2f7;
    }

    .detail-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
        display: inline-block;
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
        /* Hide layout navigation elements */
        .pcoded-navbar,
        .pcoded-header,
        .header-user-list,
        .header-chat,
        .loader-bg,
        .mb-4, /* Back button row */
        .btn,
        .btn-outline-secondary,
        .document-grid, /* Hide document previews */
        .modern-card:has(.document-grid) /* Hide uploaded documents card */
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
        
        .col-lg-4, .col-lg-12 {
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

        .profile-info .badge-custom {
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

        /* Cards */
        .modern-card {
            border: none !important;
            box-shadow: none !important;
            margin-bottom: 20px !important;
            background: none !important;
        }

        .card-header-modern {
            background: none !important;
            padding: 0 !important;
            border-bottom: 1.5px solid #333 !important;
            margin-bottom: 15px !important;
        }

        .card-header-modern h6 {
            color: #000 !important;
            font-size: 1.05rem !important;
            font-weight: bold !important;
            text-transform: uppercase;
        }

        .card-header-modern i {
            display: none !important;
        }

        /* Detail Grid & Items */
        .detail-section {
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

        /* Section title */
        .section-title {
            font-size: 0.95rem !important;
            color: #000 !important;
            border-bottom: 1px dashed #333 !important;
            margin-top: 15px !important;
            margin-bottom: 10px !important;
            display: block !important;
            width: 100% !important;
        }

        /* Address sections - full width rows for layout */
        .row.g-3 {
            display: flex !important;
            flex-direction: column !important;
            gap: 15px !important;
        }

        .col-md-6 {
            width: 100% !important;
            margin-bottom: 15px !important;
            padding: 0 !important;
        }

        /* Educational lists */
        .detail-grid.mb-3 {
            margin-bottom: 15px !important;
            border-bottom: 1px dashed #ddd !important;
            padding-bottom: 10px !important;
        }

        /* Signature styling */
        .modern-card:has(.fa-signature) {
            margin-top: 50px !important;
            page-break-inside: avoid;
        }

        .modern-card:has(.fa-signature) .card-header-modern {
            display: none !important;
        }

        .modern-card:has(.fa-signature) .detail-section {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-end !important;
            padding-top: 20px !important;
        }

        .modern-card:has(.fa-signature) .detail-section:after {
            content: "Applicant's Signature" !important;
            display: block !important;
            font-weight: bold !important;
            margin-top: 10px !important;
            border-top: 1px solid #000 !important;
            width: 200px !important;
            text-align: center !important;
            font-size: 0.9rem !important;
        }

        .modern-card:has(.fa-signature) img {
            max-height: 60px !important;
            border: none !important;
            padding: 0 !important;
        }
    }
</style>
@endsection

@section('content')
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
            <h4>Admission Application Form</h4>
        </div>

        <!-- Page Header -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt" style="color: var(--primary-color);"></i> 
                    Application Details
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary text-white btn-sm me-2">
                        <i class="fas fa-print me-1"></i>Print
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-4">
                <div class="profile-sidebar">
                    <div class="profile-header"></div>
                    <div class="profile-avatar">
                        @if(is_file('uploads/'.$path.'/'.$row->photo))
                        <img src="{{ asset('uploads/'.$path.'/'.$row->photo) }}" alt="Photo" onerror="this.src='{{ asset('images/user/avatar-2.jpg') }}';">
                        @else
                        <img src="{{ asset('images/user/avatar-2.jpg') }}" alt="Photo">
                        @endif
                    </div>
                    <div class="profile-info">
                        <h5 class="mb-1" style="font-size: 1rem;">{{ $row->first_name }} {{ $row->last_name }}</h5>
                        @if(isset($row->registration_no))
                        <p class="text-muted small mb-2">ID: {{ $row->registration_no }}</p>
                        @endif
                        
                        @if($row->status == 1)
                        <span class="badge-custom badge-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                        @elseif($row->status == 2)
                        <span class="badge-custom badge-approved"><i class="fas fa-check-circle me-1"></i>Approved</span>
                        @else
                        <span class="badge-custom badge-rejected"><i class="fas fa-times-circle me-1"></i>Rejected</span>
                        @endif
                    </div>

                    <ul class="info-list">
                        <li class="info-list-item">
                            <span class="info-label"><i class="far fa-envelope me-2"></i>Email</span>
                            <span class="info-value">{{ $row->email }}</span>
                        </li>
                        <li class="info-list-item">
                            <span class="info-label"><i class="fas fa-phone-alt me-2"></i>Phone</span>
                            <span class="info-value">{{ $row->phone }}</span>
                        </li>
                        <li class="info-list-item">
                            <span class="info-label"><i class="fas fa-graduation-cap me-2"></i>Program</span>
                            <span class="info-value">{{ $row->program->title ?? 'N/A' }}</span>
                        </li>
                        <li class="info-list-item">
                            <span class="info-label"><i class="far fa-calendar-alt me-2"></i>Apply Date</span>
                            <span class="info-value">
                                @if(isset($setting->date_format))
                                {{ date($setting->date_format, strtotime($row->apply_date)) }}
                                @else
                                {{ date("Y-m-d", strtotime($row->apply_date)) }}
                                @endif
                            </span>
                        </li>
                        <li class="info-list-item">
                            <span class="info-label"><i class="fas fa-money-bill-wave me-2"></i>Fee Amount</span>
                            <span class="info-value">{{ number_format($row->fee_amount ?? 0, 2) }} {{ $setting->currency ?? 'BDT' }}</span>
                        </li>
                        <li class="info-list-item">
                            <span class="info-label"><i class="fas fa-credit-card me-2"></i>Payment Status</span>
                            <span class="info-value">
                                @if( ($row->fee_amount ?? 0) <= 0 )
                                <span class="badge badge-pill badge-info" style="font-size: 0.75rem; padding: 3px 6px;">N/A</span>
                                @elseif( $row->pay_status == 1 )
                                <span class="badge badge-pill badge-success" style="font-size: 0.75rem; padding: 3px 6px;">Paid</span>
                                @else
                                <span class="badge badge-pill badge-warning" style="font-size: 0.75rem; padding: 3px 6px;">Unpaid</span>
                                @endif
                            </span>
                        </li>
                        @if($row->pay_status == 1 && $row->payment_method)
                        <li class="info-list-item">
                            <span class="info-label"><i class="fas fa-wallet me-2"></i>Method</span>
                            <span class="info-value">
                                @if($row->payment_method == 11) bKash
                                @elseif($row->payment_method == 12) Nagad
                                @elseif($row->payment_method == 13) SSLCommerz
                                @else Online
                                @endif
                            </span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-12">
                @php
                    function field($slug){
                        return \App\Models\Field::field($slug);
                    }
                    $docPath = $path ?? 'student';
                @endphp

                <!-- Personal Information -->
                <div class="modern-card">
                    <div class="card-header-modern">
                        <h6><i class="fas fa-user-circle"></i> Personal Information</h6>
                    </div>
                    <div class="detail-section">
                        <div class="detail-grid">
                            @if(field('application_father_name')->status == 1 && $row->father_name)
                            <div class="detail-item">
                                <div class="detail-item-label">Father's Name</div>
                                <div class="detail-item-value">{{ $row->father_name }}</div>
                            </div>
                            @endif
                            
                            @if(field('application_father_occupation')->status == 1 && $row->father_occupation)
                            <div class="detail-item">
                                <div class="detail-item-label">Father's Occupation</div>
                                <div class="detail-item-value">{{ $row->father_occupation }}</div>
                            </div>
                            @endif
                            
                            @if(field('application_mother_name')->status == 1 && $row->mother_name)
                            <div class="detail-item">
                                <div class="detail-item-label">Mother's Name</div>
                                <div class="detail-item-value">{{ $row->mother_name }}</div>
                            </div>
                            @endif
                            
                            @if(field('application_mother_occupation')->status == 1 && $row->mother_occupation)
                            <div class="detail-item">
                                <div class="detail-item-label">Mother's Occupation</div>
                                <div class="detail-item-value">{{ $row->mother_occupation }}</div>
                            </div>
                            @endif

                            <div class="detail-item">
                                <div class="detail-item-label">Gender</div>
                                <div class="detail-item-value">
                                    @if($row->gender == 1) Male
                                    @elseif($row->gender == 2) Female
                                    @elseif($row->gender == 3) Other
                                    @endif
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item-label">Date of Birth</div>
                                <div class="detail-item-value">
                                    @if(isset($setting->date_format))
                                    {{ date($setting->date_format, strtotime($row->dob)) }}
                                    @else
                                    {{ date("Y-m-d", strtotime($row->dob)) }}
                                    @endif
                                </div>
                            </div>

                            @if(field('application_emergency_phone')->status == 1 && $row->emergency_phone)
                            <div class="detail-item">
                                <div class="detail-item-label">Emergency Phone</div>
                                <div class="detail-item-value">{{ $row->emergency_phone }}</div>
                            </div>
                            @endif

                            @if(field('application_religion')->status == 1 && $row->religion)
                            <div class="detail-item">
                                <div class="detail-item-label">Religion</div>
                                <div class="detail-item-value">{{ $row->religion }}</div>
                            </div>
                            @endif

                            @if(field('application_caste')->status == 1 && $row->caste)
                            <div class="detail-item">
                                <div class="detail-item-label">Caste</div>
                                <div class="detail-item-value">{{ $row->caste }}</div>
                            </div>
                            @endif

                            @if(field('application_mother_tongue')->status == 1 && $row->mother_tongue)
                            <div class="detail-item">
                                <div class="detail-item-label">Mother Tongue</div>
                                <div class="detail-item-value">{{ $row->mother_tongue }}</div>
                            </div>
                            @endif

                            @if(field('application_nationality')->status == 1 && $row->nationality)
                            <div class="detail-item">
                                <div class="detail-item-label">Nationality</div>
                                <div class="detail-item-value">{{ $row->nationality }}</div>
                            </div>
                            @endif

                            @if(field('application_marital_status')->status == 1 && $row->marital_status)
                            <div class="detail-item">
                                <div class="detail-item-label">Marital Status</div>
                                <div class="detail-item-value">
                                    @if($row->marital_status == 1) Single
                                    @elseif($row->marital_status == 2) Married
                                    @elseif($row->marital_status == 3) Widowed
                                    @elseif($row->marital_status == 4) Divorced
                                    @elseif($row->marital_status == 5) Other
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if(field('application_blood_group')->status == 1 && $row->blood_group)
                            <div class="detail-item">
                                <div class="detail-item-label">Blood Group</div>
                                <div class="detail-item-value">
                                    @if($row->blood_group == 1) A+ @elseif($row->blood_group == 2) A-
                                    @elseif($row->blood_group == 3) B+ @elseif($row->blood_group == 4) B-
                                    @elseif($row->blood_group == 5) AB+ @elseif($row->blood_group == 6) AB-
                                    @elseif($row->blood_group == 7) O+ @elseif($row->blood_group == 8) O-
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if(field('application_national_id')->status == 1 && $row->national_id)
                            <div class="detail-item">
                                <div class="detail-item-label">National ID</div>
                                <div class="detail-item-value">{{ $row->national_id }}</div>
                            </div>
                            @endif

                            @if(field('application_passport_no')->status == 1 && $row->passport_no)
                            <div class="detail-item">
                                <div class="detail-item-label">Passport No</div>
                                <div class="detail-item-value">{{ $row->passport_no }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                @if(field('application_address')->status == 1)
                <div class="modern-card">
                    <div class="card-header-modern">
                        <h6><i class="fas fa-map-marker-alt"></i> Address Information</h6>
                    </div>
                    <div class="detail-section">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6 class="section-title">Present Address</h6>
                                @if(field('application_province')->status == 1)
                                <div class="detail-item mb-2">
                                    <div class="detail-item-label">Province</div>
                                    <div class="detail-item-value">{{ $row->presentProvince->title ?? 'N/A' }}</div>
                                </div>
                                @endif
                                @if(field('application_district')->status == 1)
                                <div class="detail-item mb-2">
                                    <div class="detail-item-label">District</div>
                                    <div class="detail-item-value">{{ $row->presentDistrict->title ?? 'N/A' }}</div>
                                </div>
                                @endif
                                <div class="detail-item">
                                    <div class="detail-item-label">Address</div>
                                    <div class="detail-item-value">{{ $row->present_address ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="section-title">Permanent Address</h6>
                                @if(field('application_province')->status == 1)
                                <div class="detail-item mb-2">
                                    <div class="detail-item-label">Province</div>
                                    <div class="detail-item-value">{{ $row->permanentProvince->title ?? 'N/A' }}</div>
                                </div>
                                @endif
                                @if(field('application_district')->status == 1)
                                <div class="detail-item mb-2">
                                    <div class="detail-item-label">District</div>
                                    <div class="detail-item-value">{{ $row->permanentDistrict->title ?? 'N/A' }}</div>
                                </div>
                                @endif
                                <div class="detail-item">
                                    <div class="detail-item-label">Address</div>
                                    <div class="detail-item-value">{{ $row->permanent_address ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Educational Qualifications -->
                <div class="modern-card">
                    <div class="card-header-modern">
                        <h6><i class="fas fa-university"></i> Educational Qualifications</h6>
                    </div>
                    <div class="detail-section">
                        @if(field('application_school_info')->status == 1 && ($row->school_name || $row->school_board))
                        <h6 class="section-title">Secondary Education</h6>
                        <div class="detail-grid mb-3">
                            @if($row->school_name)<div class="detail-item"><div class="detail-item-label">School Name</div><div class="detail-item-value">{{ $row->school_name }}</div></div>@endif
                            @if($row->school_board)<div class="detail-item"><div class="detail-item-label">Board</div><div class="detail-item-value">{{ $row->school_board }}</div></div>@endif
                            @if($row->school_group)<div class="detail-item"><div class="detail-item-label">Group</div><div class="detail-item-value">{{ $row->school_group }}</div></div>@endif
                            @if($row->school_exam_id)<div class="detail-item"><div class="detail-item-label">Exam ID</div><div class="detail-item-value">{{ $row->school_exam_id }}</div></div>@endif
                            @if($row->school_graduation_year)<div class="detail-item"><div class="detail-item-label">Year</div><div class="detail-item-value">{{ $row->school_graduation_year }}</div></div>@endif
                            @if($row->school_graduation_point)<div class="detail-item"><div class="detail-item-label">GPA</div><div class="detail-item-value">{{ $row->school_graduation_point }}</div></div>@endif
                        </div>
                        @endif

                        @if(field('application_collage_info')->status == 1 && ($row->collage_name || $row->collage_board))
                        <h6 class="section-title">Higher Secondary Education</h6>
                        <div class="detail-grid mb-3">
                            @if($row->collage_name)<div class="detail-item"><div class="detail-item-label">College Name</div><div class="detail-item-value">{{ $row->collage_name }}</div></div>@endif
                            @if($row->collage_board)<div class="detail-item"><div class="detail-item-label">Board</div><div class="detail-item-value">{{ $row->collage_board }}</div></div>@endif
                            @if($row->collage_group)<div class="detail-item"><div class="detail-item-label">Group</div><div class="detail-item-value">{{ $row->collage_group }}</div></div>@endif
                            @if($row->collage_exam_id)<div class="detail-item"><div class="detail-item-label">Exam ID</div><div class="detail-item-value">{{ $row->collage_exam_id }}</div></div>@endif
                            @if($row->collage_graduation_year)<div class="detail-item"><div class="detail-item-label">Year</div><div class="detail-item-value">{{ $row->collage_graduation_year }}</div></div>@endif
                            @if($row->collage_graduation_point)<div class="detail-item"><div class="detail-item-label">GPA</div><div class="detail-item-value">{{ $row->collage_graduation_point }}</div></div>@endif
                        </div>
                        @endif

                        @if(field('application_diploma_info')->status == 1 && $row->diploma_name)
                        <h6 class="section-title">Diploma</h6>
                        <div class="detail-grid mb-3">
                            @if($row->diploma_name)<div class="detail-item"><div class="detail-item-label">Institution</div><div class="detail-item-value">{{ $row->diploma_name }}</div></div>@endif
                            @if($row->diploma_board)<div class="detail-item"><div class="detail-item-label">Board</div><div class="detail-item-value">{{ $row->diploma_board }}</div></div>@endif
                            @if($row->diploma_group)<div class="detail-item"><div class="detail-item-label">Group</div><div class="detail-item-value">{{ $row->diploma_group }}</div></div>@endif
                            @if($row->diploma_exam_id)<div class="detail-item"><div class="detail-item-label">Exam ID</div><div class="detail-item-value">{{ $row->diploma_exam_id }}</div></div>@endif
                            @if($row->diploma_graduation_year)<div class="detail-item"><div class="detail-item-label">Year</div><div class="detail-item-value">{{ $row->diploma_graduation_year }}</div></div>@endif
                            @if($row->diploma_graduation_point)<div class="detail-item"><div class="detail-item-label">GPA</div><div class="detail-item-value">{{ $row->diploma_graduation_point }}</div></div>@endif
                        </div>
                        @endif

                        @if(field('application_bachelor_info')->status == 1 && $row->bachelor_name)
                        <h6 class="section-title">Bachelor's Degree</h6>
                        <div class="detail-grid mb-3">
                            @if($row->bachelor_name)<div class="detail-item"><div class="detail-item-label">Institution</div><div class="detail-item-value">{{ $row->bachelor_name }}</div></div>@endif
                            @if($row->bachelor_board)<div class="detail-item"><div class="detail-item-label">Board</div><div class="detail-item-value">{{ $row->bachelor_board }}</div></div>@endif
                            @if($row->bachelor_group)<div class="detail-item"><div class="detail-item-label">Group</div><div class="detail-item-value">{{ $row->bachelor_group }}</div></div>@endif
                            @if($row->bachelor_exam_id)<div class="detail-item"><div class="detail-item-label">Exam ID</div><div class="detail-item-value">{{ $row->bachelor_exam_id }}</div></div>@endif
                            @if($row->bachelor_graduation_year)<div class="detail-item"><div class="detail-item-label">Year</div><div class="detail-item-value">{{ $row->bachelor_graduation_year }}</div></div>@endif
                            @if($row->bachelor_graduation_point)<div class="detail-item"><div class="detail-item-label">GPA</div><div class="detail-item-value">{{ $row->bachelor_graduation_point }}</div></div>@endif
                        </div>
                        @endif

                        @if(field('application_other_edu_info')->status == 1 && $row->other_edu_name)
                        <h6 class="section-title">Other Qualification</h6>
                        <div class="detail-grid">
                            @if($row->other_edu_name)<div class="detail-item"><div class="detail-item-label">Institution</div><div class="detail-item-value">{{ $row->other_edu_name }}</div></div>@endif
                            @if($row->other_edu_board)<div class="detail-item"><div class="detail-item-label">Board</div><div class="detail-item-value">{{ $row->other_edu_board }}</div></div>@endif
                            @if($row->other_edu_group)<div class="detail-item"><div class="detail-item-label">Group</div><div class="detail-item-value">{{ $row->other_edu_group }}</div></div>@endif
                            @if($row->other_edu_exam_id)<div class="detail-item"><div class="detail-item-label">Exam ID</div><div class="detail-item-value">{{ $row->other_edu_exam_id }}</div></div>@endif
                            @if($row->other_edu_graduation_year)<div class="detail-item"><div class="detail-item-label">Year</div><div class="detail-item-value">{{ $row->other_edu_graduation_year }}</div></div>@endif
                            @if($row->other_edu_graduation_point)<div class="detail-item"><div class="detail-item-label">GPA</div><div class="detail-item-value">{{ $row->other_edu_graduation_point }}</div></div>@endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Additional Information -->
                @if(
                    (field('application_medical_condition')->status == 1 && $row->medical_condition) ||
                    (field('application_hostel_accommodation')->status == 1 && $row->hostel_accommodation) ||
                    (field('application_employment_status')->status == 1 && $row->employment_status) ||
                    (field('application_english_proficiency')->status == 1 && $row->english_proficiency) ||
                    (field('application_disciplinary_offense')->status == 1 && $row->offense) ||
                    (field('application_criminally_convicted')->status == 1 && $row->criminally_convicted)
                )
                <div class="modern-card">
                    <div class="card-header-modern">
                        <h6><i class="fas fa-info-circle"></i> Additional Information</h6>
                    </div>
                    <div class="detail-section">
                        <div class="detail-grid">
                            @if(field('application_medical_condition')->status == 1 && $row->medical_condition)
                            <div class="detail-item">
                                <div class="detail-item-label">Medical Condition</div>
                                <div class="detail-item-value">{{ $row->medical_condition }}</div>
                            </div>
                            @endif
                            @if(field('application_hostel_accommodation')->status == 1 && $row->hostel_accommodation)
                            <div class="detail-item">
                                <div class="detail-item-label">Hostel Accommodation</div>
                                <div class="detail-item-value">{{ $row->hostel_accommodation }} @if($row->hostel_accommodation_text) - {{ $row->hostel_accommodation_text }} @endif</div>
                            </div>
                            @endif
                            @if(field('application_employment_status')->status == 1 && $row->employment_status)
                            <div class="detail-item">
                                <div class="detail-item-label">Employment Status</div>
                                <div class="detail-item-value">{{ $row->employment_status }} @if($row->employment_text) - {{ $row->employment_text }} @endif</div>
                            </div>
                            @endif
                            @if(field('application_english_proficiency')->status == 1 && $row->english_proficiency)
                            <div class="detail-item">
                                <div class="detail-item-label">English Proficiency</div>
                                <div class="detail-item-value">{{ $row->english_proficiency }} @if($row->ielts_score) (IELTS: {{ $row->ielts_score }}) @endif</div>
                            </div>
                            @endif
                            @if(field('application_disciplinary_offense')->status == 1 && $row->offense)
                            <div class="detail-item">
                                <div class="detail-item-label">Disciplinary Offense</div>
                                <div class="detail-item-value">{{ $row->offense }} @if($row->offense_text) - {{ $row->offense_text }} @endif</div>
                            </div>
                            @endif
                            @if(field('application_criminally_convicted')->status == 1 && $row->criminally_convicted)
                            <div class="detail-item">
                                <div class="detail-item-label">Criminal Conviction</div>
                                <div class="detail-item-value">{{ $row->criminally_convicted }} @if($row->criminal_convicted_text) - {{ $row->criminal_convicted_text }} @endif</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Signature -->
                @if(field('application_signature')->status == 1 && is_file('uploads/'.$docPath.'/'.$row->signature))
                <div class="modern-card">
                    <div class="card-header-modern">
                        <h6><i class="fas fa-signature"></i> Signature</h6>
                    </div>
                    <div class="detail-section text-center">
                        <a href="{{ asset('uploads/'.$docPath.'/'.$row->signature) }}" target="_blank">
                            <img src="{{ asset('uploads/'.$docPath.'/'.$row->signature) }}" style="max-height: 80px; border: 1px solid #e5e9f0; padding: 5px;">
                        </a>
                    </div>
                </div>
                @endif

                <!-- Documents Section - Simple URL opening -->
                <div class="modern-card">
                    <div class="card-header-modern">
                        <h6><i class="fas fa-paperclip"></i> Uploaded Documents</h6>
                    </div>
                    <div class="document-grid">
                        @php
                            $documentList = [
                                'school_transcript' => ['label' => 'School Transcript', 'setting' => 'application_school_transcript'],
                                'school_certificate' => ['label' => 'School Certificate', 'setting' => 'application_school_certificate'],
                                'collage_transcript' => ['label' => 'College Transcript', 'setting' => 'application_collage_transcript'],
                                'collage_certificate' => ['label' => 'College Certificate', 'setting' => 'application_collage_certificate'],
                                'diploma_transcript' => ['label' => 'Diploma Transcript', 'setting' => 'application_diploma_info'],
                                'diploma_certificate' => ['label' => 'Diploma Certificate', 'setting' => 'application_diploma_info'],
                                'bachelor_transcript' => ['label' => 'Bachelor Transcript', 'setting' => 'application_bachelor_info'],
                                'bachelor_certificate' => ['label' => 'Bachelor Certificate', 'setting' => 'application_bachelor_info'],
                                'other_edu_transcript' => ['label' => 'Other Transcript', 'setting' => 'application_other_edu_info'],
                                'other_edu_certificate' => ['label' => 'Other Certificate', 'setting' => 'application_other_edu_info'],
                                'national_id_file' => ['label' => 'NID / Birth Certificate File', 'setting' => 'application_national_id_file'],
                            ];
                            $hasAnyDoc = false;
                        @endphp
                        
                        @foreach($documentList as $field => $docInfo)
                            @if(field($docInfo['setting'])->status == 1 && !empty($row->$field) && is_file('uploads/'.$docPath.'/'.$row->$field))
                                @php 
                                    $hasAnyDoc = true; 
                                    $label = $docInfo['label'];
                                    $fileUrl = asset('uploads/'.$docPath.'/'.$row->$field);
                                    $ext = strtolower(pathinfo($row->$field, PATHINFO_EXTENSION));
                                    $isImageFile = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                <div class="document-card">
                                    <a href="{{ $fileUrl }}" target="_blank">
                                        <div class="document-preview">
                                            @if($isImageFile)
                                                <img src="{{ $fileUrl }}" alt="{{ $label }}" style="width: 100%; height: 100%; object-fit: contain; background: #f5f7fb;">
                                            @elseif($ext == 'pdf')
                                                <div class="file-icon">
                                                    <i class="fas fa-file-pdf" style="font-size: 3rem;"></i>
                                                    <div style="font-size: 0.7rem; margin-top: 5px;">PDF Document</div>
                                                </div>
                                            @elseif(in_array($ext, ['doc', 'docx']))
                                                <div class="file-icon">
                                                    <i class="fas fa-file-word" style="font-size: 3rem;"></i>
                                                    <div style="font-size: 0.7rem; margin-top: 5px;">Word Document</div>
                                                </div>
                                            @elseif(in_array($ext, ['xls', 'xlsx']))
                                                <div class="file-icon">
                                                    <i class="fas fa-file-excel" style="font-size: 3rem;"></i>
                                                    <div style="font-size: 0.7rem; margin-top: 5px;">Excel Document</div>
                                                </div>
                                            @else
                                                <div class="file-icon">
                                                    <i class="fas fa-file-alt" style="font-size: 3rem;"></i>
                                                    <div style="font-size: 0.7rem; margin-top: 5px;">{{ strtoupper($ext) }} File</div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="document-info">
                                            <div class="document-title">{{ $label }}</div>
                                            <small class="text-muted" style="font-size: 0.65rem;">Click to open</small>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                        
                        @if(!$hasAnyDoc)
                        <div class="text-center p-4 text-muted" style="grid-column: 1/-1;">
                            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                            <p class="mb-0">No documents uploaded yet.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
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