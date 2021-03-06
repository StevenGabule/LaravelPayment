<?php

namespace App\Http\Controllers;

use App\Currency;
use App\PaymentPlatform;
use App\Services\PayPalService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function pay(Request $request)
    {
        $rules = [
            'value' => ['required', 'numeric', 'min:5'],
            'currency' => ['required', 'exists:currencies,iso'],
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
        ];

        $request->validate($rules);

        $paymentPlatForm = resolve(PayPalService::class);

        return $paymentPlatForm->handlePayment($request);
    }

    public function approval()
    {
        $paymentPlatForm = resolve(PayPalService::class);
        return $paymentPlatForm->handleApproval();

    }

    public function cancelled()
    {
        
    }
}
