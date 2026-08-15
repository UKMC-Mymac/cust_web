<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSLCommerz Payment Gateway Sandbox</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #333333;
        }

        .gateway-wrapper {
            max-width: 900px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .gateway-header {
            background-color: #002f6c;
            color: #ffffff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .gateway-logo {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #ffffff;
            text-transform: uppercase;
        }

        .gateway-logo span {
            color: #00a896;
        }

        .order-summary {
            text-align: right;
        }

        .order-summary h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .order-summary p {
            margin: 2px 0 0 0;
            font-size: 13px;
            color: #b0bec5;
        }

        .sandbox-alert {
            background-color: #e0f2f1;
            color: #00796b;
            padding: 10px 30px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #b2dfdb;
        }

        .sandbox-alert i {
            margin-right: 10px;
        }

        .gateway-content {
            display: flex;
            min-height: 450px;
        }

        .payment-sidebar {
            width: 250px;
            background-color: #f8fafc;
            border-right: 1px solid #e2e8f0;
            padding: 20px 0;
        }

        .tab-btn {
            display: block;
            width: 100%;
            padding: 15px 25px;
            text-align: left;
            background: none;
            border: none;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .tab-btn:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .tab-btn.active {
            background-color: #ffffff;
            color: #002f6c;
            border-left-color: #002f6c;
        }

        .tab-btn i {
            margin-right: 12px;
            width: 18px;
        }

        .payment-panel {
            flex: 1;
            padding: 30px 40px;
            display: none;
        }

        .payment-panel.active {
            display: block;
        }

        .panel-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .payment-item {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 90px;
        }

        .payment-item:hover {
            border-color: #94a3b8;
            transform: translateY(-2px);
        }

        .payment-item.selected {
            border-color: #002f6c;
            background-color: #f0f4f8;
            box-shadow: 0 0 0 1px #002f6c;
        }

        .payment-item img {
            max-height: 40px;
            max-width: 100%;
            margin-bottom: 8px;
        }

        .payment-item span {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
        }

        .gateway-footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-success {
            background-color: #00a896;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(0, 168, 150, 0.2);
        }

        .btn-success:hover {
            background-color: #028074;
        }

        .btn-success:disabled {
            background-color: #cbd5e1;
            color: #94a3b8;
            cursor: not-allowed;
            box-shadow: none;
        }

        .btn-cancel {
            background-color: #ffffff;
            color: #64748b;
            border: 1px solid #cbd5e1;
        }

        .btn-cancel:hover {
            background-color: #f1f5f9;
            color: #334155;
        }

        .ssl-info-text {
            font-size: 12px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>

    <div class="gateway-wrapper">
        <div class="gateway-header">
            <div class="gateway-logo">SSL<span>Commerz</span></div>
            <div class="order-summary">
                <h4>৳{{ number_format($amount, 2) }} BDT</h4>
                <p>Order Ref: #{{ $referenceId }}</p>
            </div>
        </div>

        <div class="sandbox-alert">
            <i class="fas fa-flask"></i> Sandbox Mode: Simulated environment. No real funds will be processed.
        </div>

        <div class="gateway-content">
            <!-- Sidebar Navigation -->
            <div class="payment-sidebar">
                <button type="button" class="tab-btn active" data-tab="cards">
                    <i class="far fa-credit-card"></i> Cards
                </button>
                <button type="button" class="tab-btn" data-tab="mobile">
                    <i class="fas fa-mobile-screen"></i> Mobile Banking
                </button>
                <button type="button" class="tab-btn" data-tab="net">
                    <i class="fas fa-building-columns"></i> Net Banking
                </button>
            </div>

            <!-- Panel Contents -->
            <div class="payment-panel active" id="panel-cards">
                <div class="panel-title">Choose your Card</div>
                <div class="payment-grid">
                    <div class="payment-item" data-value="visa">
                        <img src="https://images.squarespace-cdn.com/content/v1/5be9357df8370aa10a307c87/1569426915152-Q8G61A39D9B23JIPOM4J/visa-logo.png" alt="Visa" onerror="this.style.display='none'">
                        <span>VISA</span>
                    </div>
                    <div class="payment-item" data-value="mastercard">
                        <img src="https://assets.brandfolder.com/5f6a96n9/original/Mastercard_logo.png" alt="Mastercard" onerror="this.style.display='none'">
                        <span>MasterCard</span>
                    </div>
                    <div class="payment-item" data-value="amex">
                        <img src="https://static.vecteezy.com/system/resources/previews/020/336/364/original/american-express-editorial-logo-free-vector.jpg" alt="AMEX" onerror="this.style.display='none'">
                        <span>AMEX</span>
                    </div>
                    <div class="payment-item" data-value="dbbl">
                        <i class="fas fa-credit-card fa-2x" style="color:#00796b; margin-bottom: 6px;"></i>
                        <span>DBBL Nexus</span>
                    </div>
                </div>
            </div>

            <div class="payment-panel" id="panel-mobile">
                <div class="panel-title">Choose your Wallet</div>
                <div class="payment-grid">
                    <div class="payment-item" data-value="bkash">
                        <img src="https://www.logo.wine/a/logo/BKash/BKash-Logo.wine.svg" alt="bKash" onerror="this.style.display='none'">
                        <span>bKash</span>
                    </div>
                    <div class="payment-item" data-value="nagad">
                        <img src="https://services.nagad.com.bd:30000/content/images/nagad-logo.png" alt="Nagad" onerror="this.style.display='none'">
                        <span>Nagad</span>
                    </div>
                    <div class="payment-item" data-value="rocket">
                        <i class="fas fa-wallet fa-2x" style="color:#6a1b9a; margin-bottom: 6px;"></i>
                        <span>Rocket</span>
                    </div>
                    <div class="payment-item" data-value="upay">
                        <i class="fas fa-wallet fa-2x" style="color:#e65100; margin-bottom: 6px;"></i>
                        <span>Upay</span>
                    </div>
                </div>
            </div>

            <div class="payment-panel" id="panel-net">
                <div class="panel-title">Choose your Bank</div>
                <div class="payment-grid">
                    <div class="payment-item" data-value="city">
                        <i class="fas fa-building-columns fa-2x" style="color:#003366; margin-bottom: 6px;"></i>
                        <span>City Touch</span>
                    </div>
                    <div class="payment-item" data-value="ibbl">
                        <i class="fas fa-building-columns fa-2x" style="color:#008000; margin-bottom: 6px;"></i>
                        <span>Islami Bank</span>
                    </div>
                    <div class="payment-item" data-value="mtb">
                        <i class="fas fa-building-columns fa-2x" style="color:#cc0000; margin-bottom: 6px;"></i>
                        <span>MTB Net</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="gateway-footer">
            <div class="ssl-info-text">
                <i class="fas fa-shield-halved"></i> 128-bit SSL Secured Connection
            </div>
            <div class="action-buttons">
                <!-- Cancel form and button -->
                <form action="{{ route('payment.sslcommerz.cancel') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-cancel">Cancel Payment</button>
                </form>

                <!-- Success confirmation form and button -->
                <form action="{{ route('payment.sslcommerz.success') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" id="pay-button" class="btn btn-success" disabled>Pay Now</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tab switching
        const tabBtns = document.querySelectorAll('.tab-btn');
        const panels = document.querySelectorAll('.payment-panel');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                tabBtns.forEach(b => b.classList.remove('active'));
                panels.forEach(p => p.classList.remove('active'));

                btn.classList.add('active');
                const tabId = btn.getAttribute('data-tab');
                document.getElementById(`panel-${tabId}`).classList.add('active');
            });
        });

        // Payment item selection
        const items = document.querySelectorAll('.payment-item');
        const payBtn = document.getElementById('pay-button');

        items.forEach(item => {
            item.addEventListener('click', () => {
                items.forEach(i => i.classList.remove('selected'));
                item.classList.add('selected');
                payBtn.removeAttribute('disabled');
            });
        });
    </script>
</body>
</html>
