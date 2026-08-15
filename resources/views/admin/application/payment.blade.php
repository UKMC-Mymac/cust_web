<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | {{ $applicationSetting->title ?? 'Portal' }}</title>
    @include('admin.layouts.common.header_script')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        .billing-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e9f0;
            width: 100%;
            max-width: 480px;
            overflow: hidden;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .billing-header {
            background: #3EA1E4;
            padding: 30px;
            color: #ffffff;
            text-align: center;
            position: relative;
        }

        .billing-header h3 {
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .billing-header p {
            margin: 5px 0 0;
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .billing-body {
            padding: 30px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f3f8;
            font-size: 0.925rem;
        }

        .info-row:last-of-type {
            border-bottom: none;
            padding-bottom: 25px;
        }

        .info-label {
            color: #7f8c8d;
            font-weight: 500;
        }

        .info-value {
            color: #2c3e50;
            font-weight: 600;
            text-align: right;
        }

        .amount-box {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        .amount-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .amount-value {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0f172a;
        }

        .amount-currency {
            font-size: 1rem;
            font-weight: 500;
            color: #64748b;
            margin-left: 2px;
        }

        /* Branded Payment Buttons */
        .btn-pay {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .btn-bkash {
            background-color: #E2125B;
            color: #ffffff;
        }
        .btn-bkash:hover {
            background-color: #c90f50;
        }

        .btn-nagad {
            background: linear-gradient(135deg, #f26522 0%, #ed1c24 100%);
            color: #ffffff;
        }
        .btn-nagad:hover {
            background: linear-gradient(135deg, #df5413 0%, #db141c 100%);
        }

        .btn-sslcommerz {
            background-color: #006b53;
            color: #ffffff;
        }
        .btn-sslcommerz:hover {
            background-color: #005642;
        }

        .alert-error-gateway {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            font-size: 0.875rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="billing-card">
        <div class="billing-header">
            <h3>Checkout Payment</h3>
            <p>Application Fee Clearance</p>
        </div>

        <div class="billing-body">
            <div class="amount-box">
                <div class="amount-label">Payable Amount</div>
                <div class="amount-value">
                    {{ number_format($application->fee_amount, 2) }}<span class="amount-currency">BDT</span>
                </div>
            </div>

            <div class="info-row">
                <span class="info-label">Application ID</span>
                <span class="info-value">#{{ $application->registration_no }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Applicant Name</span>
                <span class="info-value">{{ $application->first_name }} {{ $application->last_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Applied Program</span>
                <span class="info-value">{{ $application->program->title ?? 'N/A' }}</span>
            </div>
            <div class="info-row" style="margin-bottom: 25px;">
                <span class="info-label">Submission Date</span>
                <span class="info-value">{{ date('d M Y', strtotime($application->apply_date)) }}</span>
            </div>

            @if($gateway === 'bkash')
                <form action="{{ route('payment.bkash.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_type" value="application">
                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                    <input type="hidden" name="amount" value="{{ $application->fee_amount }}">
                    <input type="hidden" name="return_url" value="{{ route('application.success', $application->id) }}">
                    <input type="hidden" name="cancel_url" value="{{ route('application.payment', $application->id) }}">
                    <button type="submit" class="btn text-white btn-pay btn-bkash">
                        <i class="fa-solid fa-wallet"></i> Pay with bKash
                    </button>
                </form>
            @elseif($gateway === 'nagad')
                <form action="{{ route('payment.nagad.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_type" value="application">
                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                    <input type="hidden" name="amount" value="{{ $application->fee_amount }}">
                    <input type="hidden" name="return_url" value="{{ route('application.success', $application->id) }}">
                    <input type="hidden" name="cancel_url" value="{{ route('application.payment', $application->id) }}">
                    <button type="submit" class="btn text-white btn-pay btn-nagad">
                        <i class="fa-solid fa-wallet"></i> Pay with Nagad
                    </button>
                </form>
            @elseif($gateway === 'sslcommerz')
                <form action="{{ route('payment.sslcommerz.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_type" value="application">
                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                    <input type="hidden" name="amount" value="{{ $application->fee_amount }}">
                    <input type="hidden" name="return_url" value="{{ route('application.success', $application->id) }}">
                    <input type="hidden" name="cancel_url" value="{{ route('application.payment', $application->id) }}">
                    <button type="submit" class="btn text-white btn-pay btn-sslcommerz">
                        <i class="fa-solid fa-credit-card"></i> Pay via SSLCommerz
                    </button>
                </form>
            @else
                <div class="alert-error-gateway">
                    <i class="fa-solid fa-triangle-exclamation mb-2"></i>
                    <div>No online payment gateway is currently enabled. Please contact support or try again later.</div>
                </div>
                <a href="{{ route('application.index') }}" class="btn btn-outline-secondary w-100 py-3 rounded-3 fw-bold">
                    Back to Application
                </a>
            @endif
        </div>
    </div>

</body>
</html>
