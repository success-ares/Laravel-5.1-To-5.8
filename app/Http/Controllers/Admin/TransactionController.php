<?php

namespace App\Http\Controllers\Admin;

use App\Deal;
use App\Referral;
use App\Transaction;
use App\Withdrawal;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{


    /**
     * All transactions list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        // get transactions
        $query = DB::table('deals')
            ->join('referrals', 'deals.referral_id', '=', 'referrals.id')
            ->join('users', 'referrals.parent_id', '=', 'users.id')
            ->join('products', 'referrals.product_id', '=', 'products.id')
            ->join('biz', 'products.biz_id', '=', 'biz.id')
            ->select( 'deals.id', 'deals.paid_status', 'deals.lead', 'deals.amount',
                'referrals.value', 'biz.biz_name',
                'users.first_name', 'users.last_name'
            )->get();

        // create collection
        $transactions = collect($query);

        // total value
        $totalValue = $transactions->sum(function($item) {
            if (!$item->lead){
                return $item->value;
            }else{
                return 0;
            }
        });

        // total commission
        $totalCommission = $transactions->sum('amount');

        // commission to pay
        $toPay = $transactions->sum(function ( $item ){
            if ($item->paid_status !== 'Paid'){
                return $item->amount;
            }else{
                return 0;
            }
        });

        return view('transaction.index', compact('transactions', 'totalValue', 'totalCommission', 'toPay'));
    }


    /**
     * Edit paid status - form
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        // get transaction
        $transaction = DB::table('deals')
            ->join('referrals', 'deals.referral_id', '=', 'referrals.id')
            ->join('users', 'referrals.parent_id', '=', 'users.id')
            ->join('products', 'referrals.product_id', '=', 'products.id')
            ->join('biz', 'products.biz_id', '=', 'biz.id')
            ->select( 'deals.id', 'deals.paid_status', 'deals.lead', 'deals.amount',
                'referrals.value', 'biz.biz_name',
                'users.first_name', 'users.last_name'
            )->where('deals.id', $id)->first();

        return view('transaction.edit', compact('transaction'));
    }


    /**
     * Update paid status
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate(Request $request)
    {
        // validate data
        $this->validate($request, [
            'id'            => 'required|integer',
            'paid_status'   => 'required|alpha'
        ]);

        // find deal
        $deal = Deal::where('id', $request->input('id'))->with('referral.parent')->firstOrFail();

        // if select paid status
        if ( $request->input('paid_status') == 'Paid' ){

            DB::transaction(function () use ($deal){

                // change status
                $deal->paid_status = 'Paid';
                $deal->save();

                // create transaction
                $transaction = new Transaction();
                $transaction->user_id = $deal->referral->parent->id;
                $transaction->source_id = $deal->id;
                $transaction->source_type = 'deal';
                $transaction->type = 'debit';
                $transaction->amount = $deal->amount;
                $transaction->save();

                // change user balance
                $deal->referral->parent->balance += $transaction->amount;
                $deal->referral->parent->save();
            });


        }else{

            // change status
            $deal->paid_status = $request->input('paid_status');
            $deal->save();
        }

        return redirect()->route('admin.transaction.index')->with('success', 'Paid status changed!');
    }


    /**
     * Withdrawal confirm
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCredit(Request $request)
    {
        // validate data
        $this->validate($request, [
            'withdrawal_id' => 'required|integer'
        ]);

        // find withdrawal
        $withdrawal = Withdrawal::where('id', $request->input('withdrawal_id'))->with('user')->firstOrFail();

        // create transaction and confirm withdrawal
        DB::transaction(function () use ($withdrawal){

            $transaction = new Transaction();
            $transaction->user_id = $withdrawal->user_id;
            $transaction->source_id = $withdrawal->id;
            $transaction->source_type = 'withdrawal';
            $transaction->type = 'credit';
            $transaction->amount = $withdrawal->amount;
            $transaction->save();

            // change user balance
            $withdrawal->user->balance -= $withdrawal->amount;
            $withdrawal->user->save();

            // change status
            $withdrawal->status = 1;
            $withdrawal->save();
        });

        //todo withdrawal to the card

        return redirect()->route('admin.withdrawal.index')->with('success', 'Withdrawal confirmed!');

    }
}
