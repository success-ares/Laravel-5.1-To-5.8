<?php

namespace App\Http\Controllers\Admin;

use App\DirectDebit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DirectDebitController extends Controller
{

    /**
     * Show all requests
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        // get direct debit authority requests
        $directDebits = DirectDebit::with('billing.user')->get();

        return view('directDebit.index', compact('directDebits'));

    }


    /**
     * Edit form
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        // get direct debit
        $directDebit = DirectDebit::findOrFail($id);

        return view('directDebit.edit', compact('directDebit'));
    }


    /**
     * Update record
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate(Request $request)
    {
        // validate data
        $this->validate($request, [
            'id'        => 'required|integer',
            'status'    => 'required|alpha'
        ]);

        // find direct debit
        $directDebit = DirectDebit::findOrFail($request->input('id'));
        $directDebit->status = $request->input('status');
        $directDebit->save();

        return redirect()->route('admin.directDebit.index')->with('success', 'Update successful');
    }
}
