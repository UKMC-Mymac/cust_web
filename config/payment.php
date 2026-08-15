<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Payment
	| Get variable from env
	|--------------------------------------------------------------------------
	*/

    'status' => env('PAYMENT_GATEWAY'),
    
    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_SECRET'),
        'mode' => env('PAYPAL_MODE'),
    ],
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'razorpay' => [
        'key' => env('RAZORPAY_KEY'),
        'secret' => env('RAZORPAY_SECRET'),
    ],
    'paystack' => [
        'key' => env('PAYSTACK_KEY'),
        'secret' => env('PAYSTACK_SECRET'),
        'email' => env('MERCHANT_EMAIL'),
    ],
    'flutterwave' => [
        'key' => env('FLW_PUBLIC_KEY'),
        'secret' => env('FLW_SECRET_KEY'),
        'hash' => env('FLW_SECRET_HASH'),
    ],
    'skrill' => [
        'email' => env('SKRILL_EMAIL'),
        'secret' => env('SKRILL_SECRET'),
    ],
    'bkash' => [
        'merchant_number' => env('BKASH_MERCHANT_NUMBER'),
        'app_key' => env('BKASH_APP_KEY'),
        'app_secret' => env('BKASH_APP_SECRET'),
        'username' => env('BKASH_USERNAME'),
        'password' => env('BKASH_PASSWORD'),
        'base_url' => env('BKASH_BASE_URL', 'https://tokenized.sandbox.bka.sh/v1.2.0-beta'),
    ],
    'nagad' => [
        'merchant_id' => env('NAGAD_MERCHANT_ID'),
        'merchant_number' => env('NAGAD_MERCHANT_NUMBER'),
        'merchant_private_key' => env('NAGAD_MERCHANT_PRIVATE_KEY'),
        'pg_public_key' => env('NAGAD_PG_PUBLIC_KEY'),
        'mode' => env('NAGAD_MODE', 'sandbox'),
    ],
    'sslcommerz' => [
        'store_id' => env('SSL_STORE_ID'),
        'store_password' => env('SSL_STORE_PASSWORD'),
        'mode' => env('SSL_MODE', 'sandbox'),
    ],
);