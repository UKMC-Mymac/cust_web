<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nagad Payment Sandbox</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .nagad-container {
            width: 400px;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e8ed;
            position: relative;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .nagad-header {
            background: linear-gradient(135deg, #f7941d, #e52e27);
            padding: 25px 20px;
            text-align: center;
            position: relative;
        }

        .nagad-logo {
            height: 55px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #ffffff;
            font-size: 22px;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s;
            opacity: 0.8;
        }

        .close-btn:hover {
            transform: scale(1.1);
            opacity: 1;
        }

        .nagad-body {
            padding: 35px 30px;
        }

        .step-container {
            display: none;
        }

        .step-container.active {
            display: block;
        }

        .payment-summary {
            background-color: #fff9f5;
            border: 1px solid #ffe6d5;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-label {
            font-size: 13px;
            color: #777777;
            font-weight: 500;
        }

        .summary-value {
            font-size: 18px;
            font-weight: 700;
            color: #e52e27;
        }

        .input-label {
            font-size: 14px;
            font-weight: 600;
            color: #333333;
            margin-bottom: 8px;
            display: block;
        }

        .nagad-input-wrapper {
            position: relative;
            margin-bottom: 25px;
        }

        .nagad-input-icon {
            position: absolute;
            left: 15px;
            top: 13px;
            color: #b0bec5;
            font-size: 16px;
        }

        .nagad-input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1.5px solid #cfd8dc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            font-weight: 600;
            color: #37474f;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .nagad-input:focus {
            outline: none;
            border-color: #f7941d;
            box-shadow: 0 0 0 3px rgba(247, 148, 29, 0.15);
        }

        .instruction-box {
            font-size: 12px;
            color: #607d8b;
            line-height: 1.6;
            margin-bottom: 25px;
            background-color: #eceff1;
            padding: 12px;
            border-radius: 6px;
            text-align: center;
        }

        .nagad-btn {
            width: 100%;
            padding: 14px 0;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-nagad-primary {
            background: linear-gradient(135deg, #f7941d, #e52e27);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(229, 46, 39, 0.2);
            margin-bottom: 12px;
        }

        .btn-nagad-primary:hover {
            filter: brightness(1.05);
        }

        .btn-nagad-primary:active {
            transform: scale(0.99);
        }

        .btn-nagad-cancel {
            background-color: #ffffff;
            color: #546e7a;
            border: 1.5px solid #cfd8dc;
            display: inline-block;
            box-sizing: border-box;
            text-decoration: none;
        }

        .btn-nagad-cancel:hover {
            background-color: #f8f9fa;
            color: #37474f;
        }

        .sandbox-ribbon {
            background: #ffe082;
            color: #5d4037;
            text-align: center;
            padding: 6px 0;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="nagad-container">
        <div class="sandbox-ribbon">
            <i class="fas fa-flask"></i> Sandbox Mode / Simulation
        </div>

        <div class="nagad-header">
            <img class="nagad-logo" src="https://services.nagad.com.bd:30000/content/images/nagad-logo.png" alt="Nagad Logo" onerror="this.src='https://nagad.com.bd/wp-content/uploads/2021/04/nagad-logo.png'">
            <a href="{{ route('payment.nagad.cancel') }}" class="close-btn"><i class="fas fa-times"></i></a>
        </div>

        <div class="nagad-body">
            <div class="payment-summary">
                <span class="summary-label">Pay To: University Portal</span>
                <span class="summary-value">৳{{ number_format($amount, 2) }}</span>
            </div>

            <!-- STEP 1: Account Number -->
            <div id="step1" class="step-container active">
                <label class="input-label" for="nagad_number">Nagad Account Number</label>
                <div class="nagad-input-wrapper">
                    <i class="fas fa-mobile-alt nagad-input-icon"></i>
                    <input type="text" id="nagad_number" class="nagad-input" placeholder="e.g. 01XXXXXXXXX" maxlength="11">
                </div>
                <div class="instruction-box">
                    Enter your Nagad wallet account number to proceed with testing payment callback simulation.
                </div>
            </div>

            <!-- STEP 2: OTP -->
            <div id="step2" class="step-container">
                <label class="input-label" for="nagad_otp">Enter Verification Code (OTP)</label>
                <div class="nagad-input-wrapper">
                    <i class="fas fa-key nagad-input-icon"></i>
                    <input type="text" id="nagad_otp" class="nagad-input" placeholder="123456" maxlength="6">
                </div>
                <div class="instruction-box">
                    Please use the test code <strong style="color: #e52e27;">123456</strong> for the simulation.
                </div>
            </div>

            <!-- STEP 3: PIN -->
            <div id="step3" class="step-container">
                <label class="input-label" for="nagad_pin">Enter Nagad PIN</label>
                <div class="nagad-input-wrapper">
                    <i class="fas fa-lock nagad-input-icon"></i>
                    <input type="password" id="nagad_pin" class="nagad-input" placeholder="••••" maxlength="4">
                </div>
                <div class="instruction-box">
                    Enter any 4-digit PIN code to authorize the sandbox fee payment.
                </div>
            </div>

            <!-- Actions -->
            <button type="button" id="confirm-btn" class="nagad-btn btn-nagad-primary">Proceed</button>
            <a href="{{ route('payment.nagad.cancel') }}" class="nagad-btn btn-nagad-cancel">Cancel</a>
        </div>
    </div>

    <!-- Hidden form for success callback -->
    <form id="success-form" action="{{ route('payment.nagad.success') }}" method="GET" style="display: none;">
        @csrf
    </form>

    <script>
        let currentStep = 1;
        const confirmBtn = document.getElementById('confirm-btn');
        const walletInput = document.getElementById('nagad_number');
        const otpInput = document.getElementById('nagad_otp');
        const pinInput = document.getElementById('nagad_pin');

        confirmBtn.addEventListener('click', function () {
            if (currentStep === 1) {
                const wallet = walletInput.value.trim();
                if (wallet.length < 11 || !wallet.startsWith('01')) {
                    alert('Please enter a valid 11-digit Nagad account number starting with 01');
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

        // Auto digit filtering
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
