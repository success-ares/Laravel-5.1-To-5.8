<?php

namespace App\Http\Controllers\Site;

use App\Eway;
use App\Plan;
use App\Service\EwayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class PlanController extends Controller
{

    // user
    protected $user;

    /**
     * PlanController constructor.
     * @param Request $request
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Show plans
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        // get user plan, if exist
        $plan = Plan::where('user_id', $this->user->id)->first();

        if ($plan){
            // show my plan
            return view('plan.my-plan', compact('plan'));
        }

        // show all plans
        return view('plan.index');
    }


    /**
     * Show plans
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getBuy()
    {
        // check - user have billing info or not
        $billingInfo = $this->user->billing()->first();

        if ( !$billingInfo ){
            return redirect()->route('site.billing')->with('error', 'Please add billing info and credit card!');
        }

        //if user don't have credit card
        if ( !$billingInfo->card_id ){
            return redirect()->route('site.billing')->with('error', 'Please add credit card!');
        }

        return view('plan.invoice');

    }

    /**
     * Create user plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCreate()
    {
        // get user card
        $billing = $this->user->billing()->firstOrFail();

        // create payment
        $ewayService = new EwayService();

        $response = $ewayService->createPayment([
            'card-id' => $billing->card_id,
            'price' => config('settings.businessPlanPrice') * 100, // 27.00 transaction would have a TotalAmount value of ‘2700’
            'item-description' => 'Business plan',
            'transaction-description' => 'Pyramd - buy business plan',
        ]);

        // save payment
        $eway = new Eway();
        $eway->item_id = $this->user->id;
        $eway->transaction_id = $response['transaction-id'];
        $eway->amount = config('settings.businessPlanPrice');
        $eway->status = $response['transaction-status'];
        $eway->save();

        // if payment status true, create new plan for user
        if($response['transaction-status']){

            // search exist plan
            $plan = Plan::where('user_id', $this->user->id)->first();

            if ($plan){

                // now
                $now = Carbon::now();

                // if user plan active
                if ( $plan->finished_at->gt($now) ){
                    // extend existing plan
                    $plan->finished_at = $plan->finished_at->addMonth();
                    $plan->save();
                }else{
                    // update plan
                    $plan->created_at = $now;
                    $plan->finished_at = $now->addMonth();
                    $plan->save();
                }

            }else{

                // create new plan
                $plan = new Plan();
                $plan->user_id = $this->user->id;
                $plan->plan_name = 'business';
                $plan->finished_at = Carbon::now()->addMonth();
				$plan->active = 1;
                $plan->save();
            }

            // all ok
            return redirect()->route('site.dashboard')->with('success', 'Thank you for buying!');

        }else{

            // failed payment
            return redirect()->route('site.dashboard')->with('error', 'Payment failed!');

        }
    }
	
	/**
     * Toggle plan active
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getActive()
    {
        // get user plan
		$plan = Plan::where('user_id', $this->user->id)->first();
		
		$plan->active = !$plan->active;
		$plan->save();

		if( $plan->active ) {
			return redirect()->route('site.plan')->with('success', 'Auto renew turned on');
		}else{
			return redirect()->route('site.plan')->with('success', 'Subscription cancelled');
		}
    }
	
	/**
     * Toggle plan active
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAutoRenew()
    {
        // get user plan
		$plan = Plan::where('user_id', $this->user->id)->first();
		
		$plan->active = !$plan->active;
		$plan->save();

		if( $plan->active ) {
			return redirect()->route('site.plan')->with('success', 'Auto renew turned on');
		}else{
			return redirect()->route('site.plan')->with('success', 'Subscription cancelled');
		}
    }
}
