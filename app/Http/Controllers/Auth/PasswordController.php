<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Referral;
use App\User;
use App\Service\EmailSenderService;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Auth;
use App\Jobs\sendToReferralJob;


class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords, EmailSenderService;

    // redirect after password reset
    protected $redirectTo = '/';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });
        
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect('/')
                    ->with('success', 'Your password has been reset. If your email is in our system you will receive the instructions shortly.');
            case Password::INVALID_USER:
                return redirect()->back()->with('error', 'We can\'t find user with that email.');
        }
    }


    /**
     * Reset password info-page
     * @return mixed
     */
    public function getResetInfo()
    {
        // get user email from session
        if( !$userEmail = session('userEmail')){
            abort(404);
        }

        return view('auth.password-reset-info', compact('userEmail'));
    }


    /**
     * Set password for refer
     * @param Request $request
     * @return mixed
     */
    public function postSetPassword(Request $request)
    {
        // set password
        $user = $this->setPassword($request);

        // get refer
        $refer = Referral::where('user_id', $user->id)->with('product.biz', 'parent')->orderBy('created_at', 'desc')->first();

        // send email to user
        // $this->sendToReferral($user, $refer);
        sendToReferralJob::dispatch($user, $refer);

        return redirect()->route('site.dashboard')->with('success', 'Thank you for referring '. $user->first_name . ' to us! We will be in touch once the referral is approved. Best regards '. $refer->product->biz->biz_name);
    }


    /**
     * Set password for new invited user
     * @param Request $request
     * @return mixed
     */
    public function postInviteSetPassword(Request $request)
    {
        // set password
        $this->setPassword($request);

        return redirect()->route('site.dashboard');
    }



    /**=================================================================================================================
     * Set password function
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    protected function setPassword(Request $request)
    {
        // validate
        $this->validate($request, [
            'id'        => 'required|integer',
            'activation_code' => 'required|alpha-num',
            'password'  => 'required|confirmed'
        ]);

        // find user
        $user = User::where('id', $request->input('id'))
            ->where('activation_code', $request->input('activation_code'))->firstOrFail();

        // set password
        $user->password = bcrypt($request->input('password'));
        $user->status = 1;
        $user->activation_code = null;
        $user->save();

        // log in
        if ( !Auth::check() )
        {
            Auth::login($user);
        }

        return $user;
    }

}
