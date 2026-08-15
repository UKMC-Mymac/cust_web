<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bKash Payment Sandbox</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: rgba(0, 0, 0, 0.75);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .bkash-container {
            width: 380px;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .bkash-header {
            background-color: #E2125B;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .bkash-logo {
            height: 50px;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #ffffff;
            font-size: 20px;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .close-btn:hover {
            transform: scale(1.1);
        }

        .bkash-merchant-info {
            background-color: #f5f5f5;
            padding: 15px 20px;
            border-bottom: 2px solid #E2125B;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .merchant-label {
            color: #666;
            font-weight: 600;
        }

        .merchant-value {
            color: #E2125B;
            font-weight: 700;
        }

        .bkash-body {
            padding: 30px 25px;
            background: #E2125B;
            color: #ffffff;
            min-height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .step-container {
            display: none;
            animation: fadeIn 0.3s ease-in-out forwards;
        }

        .step-container.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.98); }
            to { opacity: 1; transform: scale(1); }
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        .bkash-input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
            background: #ffffff;
            color: #333333;
            text-align: center;
            font-weight: 600;
            letter-spacing: 1px;
            transition: box-shadow 0.3s;
        }

        .bkash-input:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        .bkash-input::placeholder {
            color: #999999;
            font-weight: 400;
            letter-spacing: 0;
        }

        .amount-display {
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.4);
            padding-bottom: 15px;
        }

        .amount-display span {
            font-size: 16px;
            font-weight: 400;
        }

        .instruction-text {
            font-size: 12px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.85);
            text-align: center;
            margin-top: 15px;
        }

        .bkash-footer-buttons {
            display: flex;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            margin-top: 20px;
            padding-top: 15px;
        }

        .btn-bkash {
            flex: 1;
            padding: 12px 0;
            border: none;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-bkash-confirm {
            background-color: #B30E46;
            color: #ffffff;
            margin-left: 8px;
        }

        .btn-bkash-confirm:hover {
            background-color: #8c0a36;
        }

        .btn-bkash-close {
            background-color: #ffffff;
            color: #E2125B;
            margin-right: 8px;
            text-decoration: none;
        }

        .btn-bkash-close:hover {
            background-color: #f2f2f2;
        }

        .sandbox-ribbon {
            background: #ffc107;
            color: #000000;
            text-align: center;
            padding: 5px 0;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="bkash-container">
        <div class="sandbox-ribbon">
            <i class="fas fa-flask"></i> Sandbox Mode / Simulation
        </div>

        <div class="bkash-header">
            <img class="bkash-logo" src="https://www.logo.wine/a/logo/BKash/BKash-Logo.wine.svg" alt="bKash Logo">
            <a href="{{ route('payment.bkash.cancel') }}" class="close-btn"><i class="fas fa-times"></i></a>
        </div>

        <div class="bkash-merchant-info">
            <div>
                <span class="merchant-label">Merchant:</span>
                <span class="merchant-value">University Portal</span>
            </div>
            <div>
                <span class="merchant-label">Amount:</span>
                <span class="merchant-value">৳{{ number_format($amount, 2) }}</span>
            </div>
        </div>

        <div class="bkash-body">
            <!-- STEP 1: Enter Number -->
            <div id="step1" class="step-container active">
                <div class="amount-display">
                    ৳{{ number_format($amount, 2) }} <span>BDT</span>
                </div>
                <div class="input-group">
                    <label for="wallet_number">Your bKash Account Number</label>
                    <input type="text" id="wallet_number" class="bkash-input" placeholder="e.g. 01712345678" maxlength="11">
                </div>
                <p class="instruction-text">
                    By clicking confirm, you agree to our terms and conditions. Standard bKash transaction policies apply.
                </p>
            </div>

            <!-- STEP 2: Enter OTP -->
            <div id="step2" class="step-container">
                <div class="amount-display">
                    Verification Code
                </div>
                <div class="input-group">
                    <label for="otp">Enter 6-digit OTP sent to your phone</label>
                    <input type="text" id="otp" class="bkash-input" placeholder="123456" maxlength="6">
                </div>
                <p class="instruction-text">
                    Use <strong style="color: #ffc107;">123456</strong> for testing callback simulation.
                </p>
            </div>

            <!-- STEP 3: Enter PIN -->
            <div id="step3" class="step-container">
                <div class="amount-display">
                    Enter PIN
                </div>
                <div class="input-group">
                    <label for="pin">Enter your bKash PIN</label>
                    <input type="password" id="pin" class="bkash-input" placeholder="•••••" maxlength="5">
                </div>
                <p class="instruction-text">
                    Enter any 5-digit PIN to complete this checkout.
                </p>
            </div>

            <!-- Buttons -->
            <div class="bkash-footer-buttons">
                <a href="{{ route('payment.bkash.cancel') }}" class="btn-bkash btn-bkash-close">Close</a>
                <button type="button" id="confirm-btn" class="btn-bkash btn-bkash-confirm">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Hidden form for success callback -->
    <form id="success-form" action="{{ route('payment.bkash.success') }}" method="GET" style="display: none;">
        @csrf
    </form>

    <script>
        let currentStep = 1;
        const confirmBtn = document.getElementById('confirm-btn');
        const walletInput = document.getElementById('wallet_number');
        const otpInput = document.getElementById('otp');
        const pinInput = document.getElementById('pin');

        confirmBtn.addEventListener('click', function () {
            if (currentStep === 1) {
                const wallet = walletInput.value.trim();
                if (wallet.length < 11 || !wallet.startsWith('01')) {
                    alert('Please enter a valid 11-digit bKash account number starting with 01');
                    return;
                }
                document.getElementById('step1').classList.remove('active');
                document.getElementById('step2').classList.add('active');
                currentStep = 2;
            } else if (currentStep === 2) {
                const otp = otpInput.value.trim();
                if (otp.length < 4) {
                    alert('Please enter a valid verification code');
                    return;
                }
                document.getElementById('step2').classList.remove('active');
                document.getElementById('step3').classList.add('active');
                currentStep = 3;
            } else if (currentStep === 3) {
                const pin = pinInput.value.trim();
                if (pin.length < 4) {
                    alert('Please enter a valid PIN');
                    return;
                }
                // Submit hidden form to simulate gateway success
                document.getElementById('success-form').submit();
            }
        });

        // Add auto-focus and digits validation
        [walletInput, otpInput, pinInput].forEach(input => {
            input.addEventListener('keypress', function (e) {
                if (e.which < 48 || e.which > 57) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
