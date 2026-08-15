<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | {{ $applicationSetting->title ?? 'Portal' }}</title>
    @include('admin.layouts.common.header_script')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fb 0%, #eef2f7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e9f0;
            width: 100%;
            max-width: 520px;
            overflow: hidden;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .success-banner {
            background-color: #2ec4b6;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .success-banner i {
            font-size: 3.5rem;
            margin-bottom: 15px;
            animation: pulse 1s infinite alternate;
        }

        @keyframes pulse {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }

        .success-banner h3 {
            margin: 0;
            font-weight: 800;
            font-size: 1.5rem;
        }

        .success-banner p {
            margin: 5px 0 0;
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .receipt-container {
            padding: 30px;
        }

        /* Printable Slip Styles */
        .slip-box {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background-color: #fafbfd;
            padding: 25px;
            margin-bottom: 25px;
            position: relative;
        }

        .slip-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
        }

        .slip-header h5 {
            margin: 0;
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .slip-header h4 {
            margin: 5px 0 0;
            font-size: 1.15rem;
            color: #1e293b;
            font-weight: 800;
        }

        .slip-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.875rem;
        }

        .slip-row:last-of-type {
            margin-bottom: 0;
        }

        .slip-label {
            color: #64748b;
            font-weight: 500;
        }

        .slip-value {
            color: #1e293b;
            font-weight: 600;
            text-align: right;
        }

        .slip-divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 15px 0;
        }

        .slip-status-badge {
            background-color: #dcfce7;
            color: #15803d;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .buttons-group {
            display: flex;
            gap: 12px;
        }

        .btn-action {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-print {
            background-color: #0f172a;
            color: #ffffff;
            border: none;
        }
        .btn-print:hover {
            background-color: #1e293b;
        }

        .btn-done {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            text-decoration: none;
        }
        .btn-done:hover {
            background-color: #e2e8f0;
        }

        /* Printable Media Queries */
        @media print {
            body {
                background: none !important;
                padding: 0 !important;
                margin: 0 !important;
                display: block !important;
            }

            .success-card {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
            }

            .success-banner, .buttons-group {
                display: none !important;
            }

            .receipt-container {
                padding: 0 !important;
            }

            .slip-box {
                border: 1px solid #000000 !important;
                border-radius: 0 !important;
                background: none !important;
                padding: 30px !important;
                margin: 20px auto !important;
                max-width: 600px !important;
            }
        }
    </style>
</head>
<body>

    <div class="success-card">
        <div class="success-banner">
            <i class="fa-solid fa-circle-check"></i>
            <h3>Submission Successful!</h3>
            @if($applicationSetting->pay_online == 1 && $applicationSetting->fee_amount > 0)
            <p>Your application and payment have been cleared.</p>
            @else
            <p>Your application has been submitted successfully.</p>
            @endif
        </div>

        <div class="receipt-container">
            <!-- Payment Slip Card -->
            <div class="slip-box" id="payment-slip">
                <div class="slip-header">
                    @if($applicationSetting->pay_online == 1 && $applicationSetting->fee_amount > 0)
                    <h5>Official Payment Receipt</h5>
                    @else
                    <h5>Application Submission Slip</h5>
                    @endif
                    <h4>{{ $applicationSetting->title ?? 'University Portal' }}</h4>
                </div>

                <div class="slip-row">
                    <span class="slip-label">Registration No / App ID</span>
                    <span class="slip-value">#{{ $application->registration_no }}</span>
                </div>
                <div class="slip-row">
                    <span class="slip-label">Applicant Name</span>
                    <span class="slip-value">{{ $application->first_name }} {{ $application->last_name }}</span>
                </div>
                <div class="slip-row">
                    <span class="slip-label">Email ID</span>
                    <span class="slip-value">{{ $application->email }}</span>
                </div>
                <div class="slip-row">
                    <span class="slip-label">Phone Number</span>
                    <span class="slip-value">{{ $application->phone }}</span>
                </div>
                <div class="slip-row">
                    <span class="slip-label">Applied Program</span>
                    <span class="slip-value">{{ $application->program->title ?? 'N/A' }}</span>
                </div>
                <div class="slip-row">
                    <span class="slip-label">Date of Application</span>
                    <span class="slip-value">{{ date('d M Y', strtotime($application->apply_date)) }}</span>
                </div>

                @if($applicationSetting->pay_online == 1 && $applicationSetting->fee_amount > 0)
                <div class="slip-divider"></div>

                <div class="slip-row">
                    <span class="slip-label">Fee Amount Cleared</span>
                    <span class="slip-value">{{ number_format($application->fee_amount, 2) }} BDT</span>
                </div>
                <div class="slip-row">
                    <span class="slip-label">Payment Gateway</span>
                    <span class="slip-value">{{ $method_name }}</span>
                </div>
                <div class="slip-row">
                    <span class="slip-label">Payment Date / Time</span>
                    <span class="slip-value">{{ $application->updated_at->format('d M Y, h:i A') }}</span>
                </div>

                <div class="slip-divider"></div>

                <div class="slip-row" style="align-items: center;">
                    <span class="slip-label">Payment Status</span>
                    <span class="slip-value">
                        <span class="slip-status-badge">PAID</span>
                    </span>
                </div>
                @else
                <div class="slip-divider"></div>

                <div class="slip-row" style="align-items: center;">
                    <span class="slip-label">Application Status</span>
                    <span class="slip-value">
                        <span class="slip-status-badge" style="background-color: #dbeafe; color: #1e40af;">SUBMITTED</span>
                    </span>
                </div>
                @endif
            </div>

            <!-- Page Buttons -->
            <div class="buttons-group">
                <button type="button" class="btn text-white btn-action btn-print" onclick="window.print()">
                    <i class="fa-solid fa-print"></i> Print Slip
                </button>
                <a href="{{ route('home') }}" class="btn-action btn-done">
                    <i class="fa-solid fa-house"></i> Go to Home
                </a>
            </div>
        </div>
    </div>

</body>
</html>
