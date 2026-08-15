<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use App\Traits\FeesStudent;
use App\Models\Fee;
use App\Models\Application;
use Exception;

class NagadController extends Controller
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

        $merchantId = config('payment.nagad.merchant_id');
        $merchantPrivateKey = config('payment.nagad.merchant_private_key');
        $pgPublicKey = config('payment.nagad.pg_public_key');
        $mode = config('payment.nagad.mode', 'sandbox');

        // Fallback to simulator if credentials are not configured
        if (!$merchantId || $merchantId === 'none' || !$merchantPrivateKey || $merchantPrivateKey === 'none' || !$pgPublicKey || $pgPublicKey === 'none') {
            return view('payment.nagad', [
                'amount' => $amount,
                'referenceId' => $referenceId,
                'paymentType' => $paymentType
            ]);
        }

        // Real Nagad DFS checkout flow
        try {
            $orderId = 'APP_' . $referenceId . '_' . time();
            $dateTime = date('YmdHis');
            $random = bin2hex(random_bytes(20));

            // Step 1: Initialize Payment request
            $plainSensitiveData = [
                'merchantId' => $merchantId,
                'datetime' => $dateTime,
                'orderId' => $orderId,
                'random' => $random
            ];

            $sensitiveDataJson = json_encode($plainSensitiveData);
            $encryptedSensitiveData = $this->encryptWithPublicKey($sensitiveDataJson);
            $signature = $this->signatureGenerate($sensitiveDataJson);

            $baseUrl = ($mode === 'live') ? 'https://api.mynagad.com/api/dfs/check-out/' : 'https://sandbox.impay.biz:38000/api/dfs/check-out/';
            $initUrl = $baseUrl . "initialize/{$merchantId}/{$orderId}";
            
            $response = \Illuminate\Support\Facades\Http::post($initUrl, [
                'dateTime' => $dateTime,
                'sensitiveData' => $encryptedSensitiveData,
                'signature' => $signature
            ]);

            if ($response->successful()) {
                $resData = $response->json();
                
                if (isset($resData['sensitiveData'])) {
                    // Decrypt the initialization response to get paymentReferenceId and challenge
                    $decryptedJson = $this->decryptWithPrivateKey($resData['sensitiveData']);
                    $decryptedData = json_decode($decryptedJson, true);

                    if (isset($decryptedData['paymentReferenceId']) && isset($decryptedData['challenge'])) {
                        $paymentRefId = $decryptedData['paymentReferenceId'];
                        $challenge = $decryptedData['challenge'];

                        // Step 2: Complete Checkout request
                        $plainCompleteData = [
                            'merchantId' => $merchantId,
                            'orderId' => $orderId,
                            'amount' => (string)number_format($amount, 2, '.', ''),
                            'currencyCode' => '050', // BDT
                            'challenge' => $challenge,
                            'callBackUrl' => route('payment.nagad.success'),
                            'paymentType' => 'TRN',
                            'productType' => 'CSD'
                        ];

                        $completeDataJson = json_encode($plainCompleteData);
                        $encryptedCompleteData = $this->encryptWithPublicKey($completeDataJson);
                        $completeSignature = $this->signatureGenerate($completeDataJson);

                        $completeUrl = $baseUrl . "complete/{$paymentRefId}";
                        $completeResponse = \Illuminate\Support\Facades\Http::post($completeUrl, [
                            'dateTime' => $dateTime,
                            'sensitiveData' => $encryptedCompleteData,
                            'signature' => $completeSignature
                        ]);

                        if ($completeResponse->successful()) {
                            $completeResData = $completeResponse->json();
                            if (isset($completeResData['callBackUrl'])) {
                                return redirect()->away($completeResData['callBackUrl']);
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // Log error and fallback to simulator
            logger()->error('Nagad initialization error: ' . $e->getMessage());
        }

        return view('payment.nagad', [
            'amount' => $amount,
            'referenceId' => $referenceId,
            'paymentType' => $paymentType
        ]);
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

            // Real Nagad verification if query parameters like merchantId and paymentRefId are present
            if ($request->has('payment_ref_id') || $request->has('paymentRefId')) {
                $paymentRefId = $request->input('payment_ref_id') ?? $request->input('paymentRefId');
                $merchantId = config('payment.nagad.merchant_id');
                $merchantPrivateKey = config('payment.nagad.merchant_private_key');
                $mode = config('payment.nagad.mode', 'sandbox');
                
                if ($merchantId && $merchantId !== 'none' && $merchantPrivateKey && $merchantPrivateKey !== 'none') {
                    $baseUrl = ($mode === 'live') ? 'https://api.mynagad.com/api/dfs/check-out/' : 'https://sandbox.impay.biz:38000/api/dfs/check-out/';
                    $verifyUrl = $baseUrl . "verify/{$paymentRefId}";
                    
                    $response = \Illuminate\Support\Facades\Http::get($verifyUrl);
                    
                    if ($response->successful()) {
                        $resData = $response->json();
                        
                        if (isset($resData['sensitiveData'])) {
                            // Decrypt the verification response
                            $decryptedJson = $this->decryptWithPrivateKey($resData['sensitiveData']);
                            $decryptedData = json_decode($decryptedJson, true);
                            
                            if (!isset($decryptedData['status']) || $decryptedData['status'] !== 'Success') {
                                Flasher::addError('Payment validation failed with Nagad', __('msg_error'));
                                return redirect()->to(session()->get('payment_cancel_url', '/'));
                            }
                        } else {
                            Flasher::addError('Invalid verification response from Nagad', __('msg_error'));
                            return redirect()->to(session()->get('payment_cancel_url', '/'));
                        }
                    } else {
                        Flasher::addError('Failed to verify payment with Nagad', __('msg_error'));
                        return redirect()->to(session()->get('payment_cancel_url', '/'));
                    }
                }
            }

            // Complete the payment (Nagad = 12)
            $this->completePayment($paymentType, $referenceId, 12);

            Flasher::addSuccess(__('msg_your_payment_successful'), __('msg_success'));

            $this->clearSession();

            return redirect()->to($returnUrl);
        } catch (Exception $e) {
            logger()->error('Nagad callback verification error: ' . $e->getMessage());
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
     * Format Private Key to standard PEM
     */
    protected function formatPrivateKey($rawKey)
    {
        if (empty($rawKey) || $rawKey === 'none') {
            return null;
        }
        $cleaned = preg_replace('/[\s\r\n]+/', '', str_replace(['-----BEGIN PRIVATE KEY-----', '-----END PRIVATE KEY-----'], '', $rawKey));
        return "-----BEGIN PRIVATE KEY-----\n" . wordwrap($cleaned, 64, "\n", true) . "\n-----END PRIVATE KEY-----";
    }

    /**
     * Format Public Key to standard PEM
     */
    protected function formatPublicKey($rawKey)
    {
        if (empty($rawKey) || $rawKey === 'none') {
            return null;
        }
        $cleaned = preg_replace('/[\s\r\n]+/', '', str_replace(['-----BEGIN PUBLIC KEY-----', '-----END PUBLIC KEY-----'], '', $rawKey));
        return "-----BEGIN PUBLIC KEY-----\n" . wordwrap($cleaned, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
    }

    /**
     * Generate Signature using SHA1withRSA
     */
    protected function signatureGenerate($data)
    {
        $rawPrivateKey = config('payment.nagad.merchant_private_key');
        $privateKey = $this->formatPrivateKey($rawPrivateKey);
        
        $signature = '';
        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA1);
        return base64_encode($signature);
    }

    /**
     * Encrypt data with Nagad PG Public Key using PKCS1 padding
     */
    protected function encryptWithPublicKey($data)
    {
        $rawPublicKey = config('payment.nagad.pg_public_key');
        $publicKey = $this->formatPublicKey($rawPublicKey);
        
        $encrypted = '';
        openssl_public_encrypt($data, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);
        return base64_encode($encrypted);
    }

    /**
     * Decrypt data with Merchant Private Key using PKCS1 padding
     */
    protected function decryptWithPrivateKey($data)
    {
        $rawPrivateKey = config('payment.nagad.merchant_private_key');
        $privateKey = $this->formatPrivateKey($rawPrivateKey);
        
        $decrypted = '';
        openssl_private_decrypt(base64_decode($data), $decrypted, $privateKey, OPENSSL_PKCS1_PADDING);
        return $decrypted;
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
