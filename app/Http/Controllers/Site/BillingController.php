<?php

namespace App\Http\Controllers\Site;

use App\Billing;
use App\DirectDebit;
use App\User;
use App\Service\DifferentFunctionsService;
use App\Service\EmailSenderService;
use App\Service\EwayService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Jobs\sendAuthorityRequestJob;

class BillingController extends Controller
{

    use DifferentFunctionsService, EmailSenderService;

    // user
    protected $user;


    /**
     * BillingController constructor.
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
     * Billing Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        // get billing info
        $billing = $this->user->billing()->with('directDebit')->first();

        // if user have billing info
        if ($billing){

            // if user have card or direct debit
            if ($billing->card_id ){

                $eway = new EwayService();
                $card = $eway->getCreditCard($billing->card_id);

            }else{

                $card = null;

            }

            // show billing info
            return view('billing.view', compact('billing', 'card'));

        }else{

            // show form for create
            return view('billing.create', ['user' => $this->user]);
        }
    }


    /**
     * Save billing details
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(Request $request)
    {
        // validate data
        $this->validate($request, [
            'first_name'    => 'max:255',
            'last_name'     => 'max:255',
            'business_name' => 'max:255',
            'address'       => 'max:255',
            'suburb'        => 'max:255',
            'city'          => 'max:255',
            'country'       => 'max:255',
            'phone'         => 'required|max:255|'
        ]);

        // clean data
        $cleanData = $this->cleanData($request->all());

        // save billing details
        $billing = new Billing();
        $billing->user_id = $this->user->id;
        $billing->first_name = $cleanData['first_name'];
        $billing->last_name = $cleanData['last_name'];
        $billing->business_name = $cleanData['business_name'];
        $billing->address = $cleanData['address'];
        $billing->suburb = $cleanData['suburb'];
        $billing->city = $cleanData['city'];
        $billing->country = $cleanData['country'];
        $billing->phone = $cleanData['phone'];
        $billing->save();

        return redirect()->route('site.billing')->with('success', 'Billing details saved!');
    }


    /**
     * Edit billing details
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit()
    {
        // get billing details
        $billing = $this->user->billing()->firstOrFail();

        return view('billing.edit', compact('billing'));
    }


    /**
     * Update billing details
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate(Request $request)
    {
        // get billing details
        $billing = $this->user->billing()->firstOrFail();

        // validate data
        $this->validate($request, [
            'first_name'    => 'max:255',
            'last_name'     => 'max:255',
            'business_name' => 'max:255',
            'address'       => 'max:255',
            'suburb'        => 'max:255',
            'city'          => 'max:255',
            'country'       => 'max:255',
            'phone'         => 'required|max:255|'
        ]);

        // clean data
        $cleanData = $this->cleanData($request->all());

        // update billing details
        $billing->user_id = $this->user->id;
        $billing->first_name = $cleanData['first_name'];
        $billing->last_name = $cleanData['last_name'];
        $billing->business_name = $cleanData['business_name'];
        $billing->address = $cleanData['address'];
        $billing->suburb = $cleanData['suburb'];
        $billing->city = $cleanData['city'];
        $billing->country = $cleanData['country'];
        $billing->phone = $cleanData['phone'];
        $billing->save();

        return redirect()->route('site.billing')->with('success', 'Billing details updated!');
    }


    /*******************************************************************************************************************
     * Credit card - form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAddCard()
    {
        // get billing info
        $billing = $this->user->billing()->first();

        // if user don't have billing info
        if ( !$billing ){
            return redirect()->route('site.billing')->with('error', 'First create billing details!');
        }

        return view('billing.add-card');
    }


    /**
     * Save card
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postSaveCard(Request $request)
    {
        // validate data
        $this->validate($request, [
            'holder-name'       => 'required|max:25',
            'EWAY_CARDNUMBER'   => 'required',
            'expire-month'      => 'required|regex:/^[0-9]{1,2}$/i',
            'expire-year'       => 'required|regex:/^[0-9]{4}$/i',
            'type'              => 'required',
            'EWAY_CARDCVN'      => 'required'
        ]);

        // get billing info
        $billing = $this->user->billing()->firstOrFail();

        // add new card
        $eway = new EwayService();
        $card = $eway->setCreditCard($billing, $request->all());

        // if stored
        if ($card->Customer->TokenCustomerID){

            // save credit card id in DB
            $billing->card_id = $card->Customer->TokenCustomerID;
            $billing->save();

            return redirect()->route('site.billing')->with('success', 'Payment details are stored!');

        }else{

            return redirect()->route('site.billing')->with('error', 'It appears that your credit card details are invalid. Please try entering them again.');
        }

    }


    /*******************************************************************************************************************
     * Add new direct debit
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAddDirect()
    {
        // get billing info
        $billing = $this->user->billing()->with('directDebit')->first();

        // if user don't have billing info
        if ( !$billing ){
            return redirect()->route('site.billing')->with('error', 'First create billing details!');
        }

        // if user have credit card
        if ( $billing->directDebit ){
            return redirect()->route('site.billing')->with('error', 'First, remove the existing direct debit!');
        }

        return view('billing.add-direct');
    }


    /**
     * Save direct debit
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSaveDirect(Request $request)
    {
        // validate data
        $this->validate($request, [
            'account_number'=> 'required|max:255',
            'account_name'  => 'required|max:255',
            'bank_name'     => 'required|max:255'
        ]);

        // clean
        $cleanData = $this->cleanData($request->all());

        // get billing info
        $billing = $this->user->billing()->firstOrFail();

        // add new direct debit
        $direct = new DirectDebit();
        $direct->billing_id = $billing->id;
        $direct->account_number = $cleanData['account_number'];
        $direct->account_name = $cleanData['account_name'];
        $direct->bank_name = $cleanData['bank_name'];
        $direct->save();

        // get biz
        $biz = $this->user->biz()->first();

        // find admin
        $admin = User::where('type', 'admin')->firstOrFail();

        // send email to admin
        if( config('settings.sendEmail') ){
            // $this->sendAuthorityRequest($admin, $direct, $biz);
            sendAuthorityRequestJob::dispatch($admin, $direct, $biz);
        }

        return redirect()->route('site.billing')->with('success', 'Thank you for requesting direct debit - someone will be in touch shortly!');

    }


    /**
     * Delete direct debit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeleteDirect()
    {
        // get billing details
        $billing = $this->user->billing()->with('directDebit')->firstOrFail();

        if ( !$billing->directDebit ){
            abort(404);
        }

        // delete direct debit
        $directDebit = $billing->directDebit;
        $directDebit->delete();

        return redirect()->back()->with('success', 'Direct debit deleted!');

    }
}
