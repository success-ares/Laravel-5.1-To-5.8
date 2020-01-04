<?php

namespace App\Http\Controllers\Auth;

use App\Friend;
use App\Notification;
use App\User;
use App\Service\DifferentFunctionsService;
use App\Service\EmailSenderService;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Jobs\sendConfirmEmailJob;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    use AuthenticatesUsers, RegistersUsers {
        AuthenticatesUsers::redirectPath insteadof RegistersUsers;
        AuthenticatesUsers::guard insteadof RegistersUsers;
    }
    use DifferentFunctionsService, EmailSenderService;

    // Redirect after registration
    protected $redirectTo = 'dashboard';

    protected $loginPath = '/';

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout','getConfirmEmail'] ]);
    }


    public function getRegisterFriend($id)
    {
        return view('auth.register')->with('friendId', $id);
    }


    /**
     * Post Login
     * @param Request $request
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        // validate data
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('auth.login')->withErrors($validator);
        }

        // login
        if (Auth::attempt([
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
            'status'    => 1
        ], $request->has('remember'))) {
            // Authentication passed...
            return redirect()->intended('dashboard')->with('success', 'You are logged in!' );

        }else{
            return redirect()->back()->with('error', 'If you already signed up, check your email!' );
        }
    }


    /**
     * Handle a registration request for the application.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(Request $request)
    {
        // validate
        $validator = \Validator::make($request->all(), [
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|confirmed|min:6',
            'first_name'=> 'max:255',
            'last_name' => 'max:255',
            'terms'     => 'accepted',
            'friend_id' => 'sometimes|integer'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('auth.register')->withErrors($validator)->withInput();
        }
        // clean data
        $cleanData = $this->cleanData($request->all());

        
        // create new user
        $user = new User();
        $user->email = $cleanData['email'];
        $user->first_name = $cleanData['first_name'];
        $user->last_name = $cleanData['last_name'];
        $user->password = bcrypt($request->input('password'));
        $user->activation_code = str_random(50);
        $user->save();
        
        // save user data to session
        $request->session()->flash('userEmail', $user->email);

        // if it's a invite from a friend
        if ($request->has('friend_id')){
            // search a friend
            $friend = User::find($request->input('friend_id'));

            if ($friend){
                // connect friend
                Friend::create([
                    'user_id'   => $friend->id,
                    'friend_id' => $user->id
                ]);

                // create new notification for new user
                $notification = new Notification();
                $notification->user_id                  = $user->id;
                $notification->notification_header      = 'You have been added to friends!';
                $notification->notification_text        = $friend->first_name.' has added you to his friends list';
                if ($friend->photo){
                    $notification->notification_image   = asset('images/avatars/'.$friend->photo);
                }else{
                    $notification->notification_image   = asset('assets/images/no_avatar.png');
                }
                $notification->notification_link        = '<a href="'. route('site.friend.connect', $friend->id ).
                    '" role="button" class="btn btn-xs btn-primary">Connect</a>';
                $notification->save();

                // create new notification for his friend
                $notification = new Notification();
                $notification->user_id                  = $friend->id;
                $notification->notification_header      = 'Your friend is registered on the site!';
                $notification->notification_text        = $user->first_name.' added in your friends list';
                $notification->notification_icon        = 'accounts-add';
                $notification->notification_icon_style  = 'primary';
                $notification->save();
            }
        }

        // send confirmation email
        // $this->sendConfirmEmail($user);
        $refer = null;
        sendConfirmEmailjob::dispatch($user,$refer);
        
        return redirect()->route('auth.register.confirmInfo');
    }


    /**
     * Confirm email info page, after registration
     * @return mixed
     */
    public function getConfirmInfo()
    {
        // echo 2; exit;
        // get user email from session
        if( !$userEmail = session('userEmail') ){
            abort(404);
        }
        
        return view('auth.confirm-info', compact('userEmail'));
    }


    /**
     * Email confirmation
     * @param $id
     * @param $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getConfirmEmail($id, $code)
    {
        // find user
        $user = User::find($id);

        // user not found
        if(!$user)
        {
            abort(403);
        }

        // bad activation code
        if($user->activation_code !== $code)
        {
            abort(403);
        }

        // update user data
        $user->activation_code = null;
        $user->status = 1;
        $user->save();

        // log in
        if ( !Auth::check() )
        {
            Auth::login($user);
        }

        return redirect()->route('site.dashboard')->with('success', 'Your email is confirmed, thank you.');
    }


    /**
     * Confirm email and set password for new refer
     * @param $id
     * @param $code
     * @return mixed
     */
    public function getConfirmReferralEmail($id, $code)
    {
        // find user
        $user = User::where('id', $id)->where('activation_code', $code)->firstOrFail();

        return view('auth.set-password', compact('user'));
    }


    /**
     * Invite confirmation
     * @param $id
     * @param null $code
     * @return mixed
     */
    public function getConfirmInvite($id, $code = null)
    {
        // get user
        $user = User::findOrFail($id);

        // it's new user or not
        if ( $code && $user->activation_code ){
            // set password
            return view('auth.invite-set-password', compact('user'));

        }else{
            
            return redirect()->route('site.dashboard');
        }
    }

}
