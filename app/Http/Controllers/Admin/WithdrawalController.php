<?php namespace App\Http\Controllers\Admin;

use DB;
use App\User;
use App\Withdrawal;
use App\Service\EmailSenderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Jobs\sendWithdrawalRequestJob;

class WithdrawalController extends Controller
{
    use EmailSenderService;

    // user
    protected $user;


    /**
     * BizController constructor.
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
     * Show all withdrawals
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        // get withdrawals
        $withdrawals = Withdrawal::with('user')->get();

        return view('withdrawal.index', compact('withdrawals'));
    }


    /**
     * Request payment
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRequest(Request $request)
    {
        $this->validate($request, [
            'amount'    => 'required|numeric|min:50'
        ]);


        // check withdrawal funds
        if ($this->user->balance < $request->input('amount')){
            return redirect()->back()->with('error', 'Insufficient funds in your account, please amend withdrawal amount');
        }

        // save in DB
        $withdrawal = new Withdrawal();
        $withdrawal->user_id = $this->user->id;
        $withdrawal->amount = $request->input('amount');
        $withdrawal->save();

        // find admin
        $admin = User::where('type', 'admin')->firstOrFail();

        // send email to admin
        if (config('settings.sendEmail')){
            // $this->sendWithdrawalRequest($admin, $this->user, $request->input('amount'), $withdrawal->id);
            sendWithdrawalRequestJob::dispatch($admin, $this->user, $request->input('amount'), $withdrawal->id);
        }

        return redirect()->route('site.dashboard')->with('success', 'Your request has been accepted');

    }


    /**
     * Show payment request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShow($id)
    {
        // get withdrawal
        $withdrawal = Withdrawal::where('id', $id)->with('user')->firstOrFail();

        return view('withdrawal.show', compact('withdrawal'));
    }
}
