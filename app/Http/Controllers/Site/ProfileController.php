<?php

namespace App\Http\Controllers\Site;

use App\Biz;
use App\User;
use App\Service\DifferentFunctionsService;
use App\Service\EmailSenderService;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use File;
use Image;
use Auth;

class ProfileController extends Controller
{
    // Services
    use DifferentFunctionsService, EmailSenderService;

    // user
    protected $user;


    /**
     * ProfileController constructor.
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
     * Display a user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        // get biz
        $business = Biz::where('user_id', $this->user->id)->first();

        return view('profile.index', ['user' => $this->user, 'business' => $business ]);
    }



    /**
     * Update user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request)
    {

        // validate
        $this->validate($request, [
            'profile_id'    => 'required|integer',
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            'email'         => 'email',
            'company'       => 'max:255',
            'company_url'   => 'url|max:255',
            'old_password'  => 'required_with:password',
            'password'      => 'sometimes|confirmed|min:6',
            'photo'         => 'sometimes|mimes:jpeg,png|max:1024'
        ],[
            'old_password.required_with'    => 'The old password is required in order to change your password.'
        ]);

        // find user profile for edit
        $editUser = User::findOrFail($request->input('profile_id'));

        // access check
        if ($this->user->id !== $editUser->id){
            abort(403);
        }

        // clean data
        $cleanData = $this->cleanData($request->all());

        // set new data
        $editUser->first_name = $cleanData['first_name'];
        $editUser->last_name = $cleanData['last_name'];
        $editUser->company = $cleanData['company'];
        $editUser->company_url = $request->input('company_url');
        $editUser->phone = $cleanData['phone'];
        $editUser->address = $cleanData['address'];
        $editUser->description = $cleanData['description'];

        // if need change password
        if( $request->has(['password', 'old_password'])){

            // check old password
            if (Hash::check($request->input('old_password'), $editUser->password )){
                // set new password
                $editUser->password = bcrypt($request->input('password'));
            }else{
                return redirect()->back()->with('error', 'Old password is incorrect!');
            }

        }

        // if set photo or change photo
        if ($request->hasFile('photo')){

            // get file, his name and extension
            $file = $request->file('photo');
            $fileExtension = $file->getClientOriginalExtension();

            // generate name for attachment
            $photoName = str_random(35).'.'.$fileExtension;

            $file->move(public_path('images/avatars'), $photoName);

            // resize
            Image::make(public_path('images/avatars/').$photoName)->fit(200)->save();

            // if user change photo - delete old photo
            if($editUser->photo){
                File::delete('images/avatars/'.$editUser->photo);
            }

            // set photo
            $editUser->photo = $photoName;

        }

        // if need change email
        if ($request->has('email') && $cleanData['email'] !== $editUser->email){
            // new email must be unique
            if ( $email = User::where('email', $cleanData['email'])->count() ){
                return redirect()->back()->with('error', 'This email address is already in use!');
            }else{
                // set new email, and send confirmation email
                $editUser->email = $cleanData['email'];
                $editUser->activation_code = str_random(50);
                // need save user before send email
                $editUser->save();

                // send email with confirmation link
                if( config('settings.sendEmail') ){
                    // $this->sendConfirmEmail($editUser);
                    $refer = null;
                    sendConfirmEmailjob::dispatch($editUser,$refer);

                }
            }
        }else{
            // save user data
            $editUser->save();
        }


        return redirect()->back()->with('success', 'Saved!');

    }


    /**
     * View profile
     * @param $id
     * @return mixed
     */
    public function getView($id)
    {
        // get user with referrals
        $user = User::findOrFail($id);
        
        return view('profile.view', compact('user'));
    }
}
