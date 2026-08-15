<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Fee;
use App\Traits\FeesStudent;
use Exception;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class BkashController extends Controller
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

        $creds = [
            'app_key' => config('payment.bkash.app_key'),
            'app_secret' => config('payment.bkash.app_secret'),
            'username' => config('payment.bkash.username'),
            'password' => config('payment.bkash.password'),
        ];

        // Fallback check
        if (empty($creds['app_key']) || $creds['app_key'] === 'none' ||
            empty($creds['app_secret']) || $creds['app_secret'] === 'none' ||
            empty($creds['username']) || $creds['username'] === 'none' ||
            empty($creds['password']) || $creds['password'] === 'none') {

            return view('payment.bkash', [
                'amount' => $amount,
                'referenceId' => $referenceId,
                'paymentType' => $paymentType,
            ]);
        }

        // Real tokenized checkout process
        try {
            $idToken = $this->grantToken($creds);
            if (! $idToken) {
                Flasher::addError('bKash Authentication failed', __('msg_error'));

                return redirect()->back();
            }

            session()->put('bkash_token', $idToken);

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$idToken,
                'X-APP-Key' => $creds['app_key'],
            ])->post(config('payment.bkash.base_url').'/tokenized/checkout/create', [
                'mode' => '0011',
                'payerReference' => (string) $referenceId,
                'callbackURL' => route('payment.bkash.success'),
                'amount' => (string) $amount,
                'currency' => 'BDT',
                'intent' => 'sale',
                'merchantInvoiceNumber' => 'INV_'.$referenceId.'_'.time(),
            ]);

            if ($response->successful()) {
                $resData = $response->json();
                if (isset($resData['bkashURL'])) {
                    return redirect()->away($resData['bkashURL']);
                } else {
                    Flasher::addError($resData['errorMessage'] ?? 'bKash payment creation failed', __('msg_error'));

                    return redirect()->back();
                }
            } else {
                Flasher::addError('bKash gateway not responding', __('msg_error'));

                return redirect()->back();
            }

        } catch (Exception $e) {
            Flasher::addError('Error initiating bKash payment', __('msg_error'));

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

            if (! $referenceId) {
                Flasher::addError(__('msg_something_went_wrong'), __('msg_error'));

                return redirect()->route('student.fees.index');
            }

            // Real bKash API handling if query parameter status and paymentID are present
            if ($request->has('paymentID') && $request->has('status')) {
                $paymentID = $request->input('paymentID');
                $status = $request->input('status');

                if ($status !== 'success') {
                    Flasher::addError('bKash payment process failed or was cancelled', __('msg_error'));

                    return redirect()->to(session()->get('payment_cancel_url', '/'));
                }

                $creds = [
                    'app_key' => config('payment.bkash.app_key'),
                    'app_secret' => config('payment.bkash.app_secret'),
                    'username' => config('payment.bkash.username'),
                    'password' => config('payment.bkash.password'),
                ];
                $idToken = session()->get('bkash_token') ?? $this->grantToken($creds);

                if (! $idToken) {
                    Flasher::addError('bKash Authentication verification failed', __('msg_error'));

                    return redirect()->to(session()->get('payment_cancel_url', '/'));
                }

                // Execute the payment
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$idToken,
                    'X-APP-Key' => $creds['app_key'],
                ])->post(config('payment.bkash.base_url').'/tokenized/checkout/execute', [
                    'paymentID' => $paymentID,
                ]);

                if ($response->successful()) {
                    $resData = $response->json();
                    if (! isset($resData['transactionStatus']) || $resData['transactionStatus'] !== 'Completed') {
                        Flasher::addError($resData['errorMessage'] ?? 'bKash payment execution failed', __('msg_error'));

                        return redirect()->to(session()->get('payment_cancel_url', '/'));
                    }
                } else {
                    Flasher::addError('bKash verification service not responding', __('msg_error'));

                    return redirect()->to(session()->get('payment_cancel_url', '/'));
                }
            }

            // Complete the payment (bKash = 11)
            $this->completePayment($paymentType, $referenceId, 11);

            Flasher::addSuccess(__('msg_your_payment_successful'), __('msg_success'));

            $this->clearSession();
            session()->forget('bkash_token');

            return redirect()->to($returnUrl);
        } catch (Exception $e) {
            Flasher::addError(__('msg_something_went_wrong'), __('msg_error'));

            return redirect()->route('student.fees.index');
        }
    }

    protected function grantToken($creds)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Content-Type' => 'application/json',
                'username' => $creds['username'],
                'password' => $creds['password'],
            ])->post(config('payment.bkash.base_url').'/tokenized/checkout/token/grant', [
                'app_key' => $creds['app_key'],
                'app_secret' => $creds['app_secret'],
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return $data['id_token'] ?? null;
            }
        } catch (Exception $e) {
            return null;
        }

        return null;
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
            'payment_cancel_url',
        ]);
    }
}
