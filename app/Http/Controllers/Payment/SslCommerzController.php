<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use App\Traits\FeesStudent;
use App\Models\Fee;
use App\Models\Application;
use Exception;

class SslCommerzController extends Controller
{
    use FeesStudent;

    /**
     * Process the payment and display simulation screen.
     */
    public function process(Request $request)
    {
        $paymentType = $request->input('payment_type', 'fees');
        $referenceId = $request->input('fee_id') ?? $request->input('application_id') ?? $request->input('reference_id');
        $amount = $request->input('amount');

        if ($paymentType === 'fees' && isset($request->fee_id)) {
            $amount = $this->netAmount($request->fee_id);
            $referenceId = $request->fee_id;
        } elseif ($paymentType === 'application' && isset($request->application_id)) {
            $application = Application::find($request->application_id);
            $amount = $application ? ($application->fee_amount ?? 0) : 0;
            $referenceId = $request->application_id;
        }

        $amount = $amount ?? 0;

        if ($amount <= 0) {
            Flasher::addError(__('msg_something_went_wrong'), __('msg_error'));
            return redirect()->back();
        }

        // Store configuration and transaction info in session
        session()->put('payment_amount', $amount);
        session()->put('payment_type', $paymentType);
        session()->put('payment_reference_id', $referenceId);
        
        $defaultReturnUrl = $paymentType === 'fees' ? route('student.fees.index') : url('/');
        session()->put('payment_return_url', $request->input('return_url') ?? $defaultReturnUrl);
        session()->put('payment_cancel_url', $request->input('cancel_url') ?? $defaultReturnUrl);

        $storeId = config('payment.sslcommerz.store_id');
        $storePass = config('payment.sslcommerz.store_password');
        $mode = config('payment.sslcommerz.mode', 'sandbox');

        if (!$storeId || $storeId === 'none' || !$storePass || $storePass === 'none') {
            return view('payment.sslcommerz', [
                'amount' => $amount,
                'referenceId' => $referenceId,
                'paymentType' => $paymentType
            ]);
        }

        // Real SSLCommerz integration
        $customerName = 'Student';
        $customerEmail = 'student@example.com';
        $customerPhone = '01700000000';

        if ($paymentType === 'application') {
            $application = Application::find($referenceId);
            if ($application) {
                $customerName = $application->first_name . ' ' . $application->last_name;
                $customerEmail = $application->email;
                $customerPhone = $application->phone;
            }
        }

        $post_data = [
            'store_id' => $storeId,
            'store_pass' => $storePass,
            'total_amount' => $amount,
            'currency' => 'BDT',
            'tran_id' => 'APP_' . $referenceId . '_' . time(),
            'success_url' => route('payment.sslcommerz.success'),
            'fail_url' => route('payment.sslcommerz.cancel'),
            'cancel_url' => route('payment.sslcommerz.cancel'),
            'ipn_url' => route('payment.sslcommerz.cancel'),
            'cus_name' => $customerName,
            'cus_email' => $customerEmail,
            'cus_phone' => $customerPhone,
            'cus_add1' => 'Dhaka',
            'cus_city' => 'Dhaka',
            'cus_country' => 'Bangladesh',
            'shipping_method' => 'NO',
            'product_name' => 'Application Fee',
            'product_category' => 'Admission',
            'product_profile' => 'non-physical-goods',
        ];

        try {
            $baseUrl = ($mode === 'live') ? 'https://securepay.sslcommerz.com/' : 'https://sandbox.sslcommerz.com/';
            $response = \Illuminate\Support\Facades\Http::asForm()->post($baseUrl . 'gwprocess/v4/api.php', $post_data);
            if ($response->successful()) {
                $resData = $response->json();
                if (isset($resData['status']) && $resData['status'] == 'SUCCESS' && isset($resData['GatewayPageURL'])) {
                    return redirect()->away($resData['GatewayPageURL']);
                } else {
                    Flasher::addError($resData['failedreason'] ?? 'SSLCommerz payment initiation failed', __('msg_error'));
                    return redirect()->back();
                }
            } else {
                Flasher::addError('SSLCommerz gateway did not respond', __('msg_error'));
                return redirect()->back();
            }
        } catch (Exception $e) {
            Flasher::addError('Error communicating with SSLCommerz gateway', __('msg_error'));
            return redirect()->back();
        }
    }

    /**
     * Successful callback.
     */
    public function success(Request $request)
    {
        try {
            $paymentType = session()->get('payment_type', 'fees');
            $referenceId = session()->get('payment_reference_id');
            $returnUrl = session()->get('payment_return_url', route('student.fees.index'));

            if (!$referenceId) {
                Flasher::addError(__('msg_something_went_wrong'), __('msg_error'));
                return redirect()->route('student.fees.index');
            }

            // If real SSLCommerz callback verification
            if ($request->has('val_id')) {
                $val_id = $request->input('val_id');
                $storeId = config('payment.sslcommerz.store_id');
                $storePass = config('payment.sslcommerz.store_password');
                $mode = config('payment.sslcommerz.mode', 'sandbox');
                
                if ($storeId && $storeId !== 'none') {
                    if ($mode === 'live') {
                        $verifyUrl = "https://securepay.sslcommerz.com/validator/api/validationserverAPI.php?val_id={$val_id}&store_id={$storeId}&store_passwd={$storePass}&format=json";
                    } else {
                        $verifyUrl = "https://sandbox.sslcommerz.com/validator/api/valid.php?val_id={$val_id}&store_id={$storeId}&store_pass={$storePass}&format=json";
                    }
                    $response = \Illuminate\Support\Facades\Http::get($verifyUrl);
                    if ($response->successful()) {
                        $resData = $response->json();
                        if (!isset($resData['status']) || ($resData['status'] !== 'VALID' && $resData['status'] !== 'VALIDATED')) {
                            Flasher::addError('Payment validation failed with SSLCommerz', __('msg_error'));
                            return redirect()->to(session()->get('payment_cancel_url', '/'));
                        }
                    } else {
                        Flasher::addError('Failed to verify payment with SSLCommerz', __('msg_error'));
                        return redirect()->to(session()->get('payment_cancel_url', '/'));
                    }
                }
            }

            // Complete the payment (SSLCommerz = 13)
            $this->completePayment($paymentType, $referenceId, 13);

            Flasher::addSuccess(__('msg_your_payment_successful'), __('msg_success'));

            $this->clearSession();

            return redirect()->to($returnUrl);
        } catch (Exception $e) {
            Flasher::addError(__('msg_something_went_wrong'), __('msg_error'));
            return redirect()->route('student.fees.index');
        }
    }

    /**
     * Cancelled callback.
     */
    public function cancel(Request $request)
    {
        $cancelUrl = session()->get('payment_cancel_url', route('student.fees.index'));
        
        Flasher::addError(__('msg_your_payment_cancelled'), __('msg_error'));
        
        $this->clearSession();

        return redirect()->to($cancelUrl);
    }

    /**
     * Core function to update fee or application state
     */
    protected function completePayment($paymentType, $referenceId, $methodId)
    {
        if ($paymentType === 'fees') {
            $this->payStudentFee($referenceId, $methodId);
        } elseif ($paymentType === 'application') {
            $application = Application::find($referenceId);
            if ($application) {
                $application->pay_status = 1; // 1 = Paid
                $application->payment_method = $methodId;
                $application->save();
            }
        }
    }

    /**
     * Clean up session
     */
    protected function clearSession()
    {
        session()->forget([
            'payment_amount',
            'payment_type',
            'payment_reference_id',
            'payment_return_url',
            'payment_cancel_url'
        ]);
    }
}
