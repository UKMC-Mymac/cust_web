<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Flasher\Laravel\Facade\Flasher;
use App\Traits\EnvironmentVariable;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    use EnvironmentVariable;

    protected $title, $route, $view, $path, $access;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_payment_setting', 1);
        $this->route = 'admin.payment-setting';
        $this->view = 'admin.payment-setting';
        $this->access = 'setting';


        $this->middleware('permission:'.$this->access.'-payment');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        return view($this->view.'.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'status' => 'required',
        ]);


        // Update to Env
        $this->updateEnvVariable('PAYMENT_GATEWAY', '"'.$request->status.'"' ?? '"none"');

        $this->updateEnvVariable('PAYPAL_CLIENT_ID', '"'.$request->paypal_client_id.'"' ?? '"none"');
        $this->updateEnvVariable('PAYPAL_SECRET', '"'.$request->paypal_secret.'"' ?? '"none"');

        $this->updateEnvVariable('STRIPE_KEY', '"'.$request->stripe_key.'"' ?? '"none"');
        $this->updateEnvVariable('STRIPE_SECRET', '"'.$request->stripe_secret.'"' ?? '"none"');

        $this->updateEnvVariable('RAZORPAY_KEY', '"'.$request->razorpay_key.'"' ?? '"none"');
        $this->updateEnvVariable('RAZORPAY_SECRET', '"'.$request->razorpay_secret.'"' ?? '"none"');

        $this->updateEnvVariable('PAYSTACK_KEY', '"'.$request->paystack_key.'"' ?? '"none"');
        $this->updateEnvVariable('PAYSTACK_SECRET', '"'.$request->paystack_secret.'"' ?? '"none"');
        $this->updateEnvVariable('MERCHANT_EMAIL', '"'.$request->paystack_email.'"' ?? '"none"');

        $this->updateEnvVariable('FLW_PUBLIC_KEY', '"'.$request->flutterwave_key.'"' ?? '"none"');
        $this->updateEnvVariable('FLW_SECRET_KEY', '"'.$request->flutterwave_secret.'"' ?? '"none"');
        $this->updateEnvVariable('FLW_SECRET_HASH', '"'.$request->flutterwave_hash.'"' ?? '"none"');

        $this->updateEnvVariable('SKRILL_EMAIL', '"'.$request->skrill_email.'"' ?? '"none"');
        $this->updateEnvVariable('SKRILL_SECRET', '"'.$request->skrill_secret.'"' ?? '"none"');

        $this->updateEnvVariable('BKASH_MERCHANT_NUMBER', '"'.$request->bkash_merchant_number.'"' ?? '"none"');
        $this->updateEnvVariable('BKASH_APP_KEY', '"'.$request->bkash_app_key.'"' ?? '"none"');
        $this->updateEnvVariable('BKASH_APP_SECRET', '"'.$request->bkash_app_secret.'"' ?? '"none"');
        $this->updateEnvVariable('BKASH_USERNAME', '"'.$request->bkash_username.'"' ?? '"none"');
        $this->updateEnvVariable('BKASH_PASSWORD', '"'.$request->bkash_password.'"' ?? '"none"');
        $this->updateEnvVariable('BKASH_BASE_URL', '"'.$request->bkash_base_url.'"' ?? '"none"');

        $nagadMerchantPrivateKey = $request->nagad_merchant_private_key;
        if ($nagadMerchantPrivateKey) {
            $nagadMerchantPrivateKey = preg_replace('/[\s\r\n]+/', '', str_replace(['-----BEGIN PRIVATE KEY-----', '-----END PRIVATE KEY-----'], '', $nagadMerchantPrivateKey));
        }

        $nagadPgPublicKey = $request->nagad_pg_public_key;
        if ($nagadPgPublicKey) {
            $nagadPgPublicKey = preg_replace('/[\s\r\n]+/', '', str_replace(['-----BEGIN PUBLIC KEY-----', '-----END PUBLIC KEY-----'], '', $nagadPgPublicKey));
        }

        $this->updateEnvVariable('NAGAD_MERCHANT_ID', '"'.$request->nagad_merchant_id.'"' ?? '"none"');
        $this->updateEnvVariable('NAGAD_MERCHANT_NUMBER', '"'.$request->nagad_merchant_number.'"' ?? '"none"');
        $this->updateEnvVariable('NAGAD_MERCHANT_PRIVATE_KEY', '"'.$nagadMerchantPrivateKey.'"' ?? '"none"');
        $this->updateEnvVariable('NAGAD_PG_PUBLIC_KEY', '"'.$nagadPgPublicKey.'"' ?? '"none"');
        $this->updateEnvVariable('NAGAD_MODE', '"'.$request->nagad_mode.'"' ?? '"sandbox"');

        $this->updateEnvVariable('SSL_STORE_ID', '"'.$request->ssl_store_id.'"' ?? '"none"');
        $this->updateEnvVariable('SSL_STORE_PASSWORD', '"'.$request->ssl_store_password.'"' ?? '"none"');
        $this->updateEnvVariable('SSL_MODE', '"'.$request->ssl_mode.'"' ?? '"sandbox"');

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
