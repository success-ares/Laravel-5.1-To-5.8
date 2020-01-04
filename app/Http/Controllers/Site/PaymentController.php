<?php

namespace App\Http\Controllers\Site;

use App\Deal;
use App\PayPal;
use App\Referral;
use App\Service\PayPalService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{


    public function getExecutePayment(Request $request, $status)
    {
        // find payment
        $payPal = PayPal::where('payment_id', clean($request->input('paymentId'), ['HTML.Allowed' => '']) )->firstOrFail();

        if ($status == 'true'){

            // get referral
            $referral = Referral::findOrFail($payPal->item_id);

            // execute payment
            $execute = new PayPalService();
            $paymentResult = $execute->executePayment(
                $payPal->payment_id,
                clean($request->input('PayerID'), ['HTML.Allowed' => ''])
            );

            // save payment result
            $payPal->state = $paymentResult->state;
            $payPal->save();

            // if payment approved
            if ($paymentResult->state == 'approved'){

                // approve referral
                $referral->status = 'Approved';
                $referral->save();

                // create new deal
                $deal = new Deal();
                $deal->referral_id = $referral->id;
                $deal->payment_id = $payPal->id;
                $deal->payment_type = 'pay_pal';
                $deal->amount = $payPal->amount;
                $deal->save();

            }elseif ($paymentResult->state == 'failed'){

                // failed payment
                return redirect()->route('site.ref.bizReferrals')->with('error', 'Payment failed!');
            }

        }else{

            // user declined payment

            // save payment result
            $payPal->state = 'declined';
            $payPal->save();

            return redirect()->route('site.ref.bizReferrals')->with('error', 'Payment declined!');
        }

        // all ok
        return redirect()->route('site.ref.bizReferrals')->with('success', 'Referral approved!');

    }
}
