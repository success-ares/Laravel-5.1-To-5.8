<?php

namespace App\Http\Controllers\Site;

use App\Friend;
use App\Notification;
use App\User;
use App\Service\EmailSenderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Jobs\sendAddFriendJob;

class FriendController extends Controller
{
    use EmailSenderService;

    // user
    protected $user;

    /**
     * FriendController constructor.
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $friends = $this->user->friends()->get();

        return view('friend.index', compact('friends'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        // search user
        $newFriend = User::where('email', $request->input('email'))->first();

        // if user not exist
        if (!$newFriend){

            // create link for registration new user and send email for him
            // $this->sendAddFriend($request->input('email'), $this->user);
            sendAddFriendJob::dispatch($request->input('email'), $this->user);

            return redirect()->back()->with('success', 'We sent an invitation to your friend!');

        }else{

            // if user is adding yourself
            if ( $newFriend->id == $this->user->id ){
                return redirect()->back()->with('error', 'You can\'t add yourself!');
            }

            // get user friends
            $friends = $this->user->friends()->get();

            if ( !$friends->isEmpty() ){
                // search new user in user friends list
                if ( $friends->contains('id', $newFriend->id) ){
                    return redirect()->back()->with('error', 'This friend is exist in your list');
                }
            }

            // create new friend
            Friend::create([
                'user_id'   => $this->user->id,
                'friend_id' => $newFriend->id
            ]);

            // create new notification
            $notification = new Notification();
            $notification->user_id                  = $newFriend->id;
            $notification->notification_header      = 'You have been added to friends!';
            $notification->notification_text        = $this->user->first_name.' has added you to his friends list';
            if ($this->user->photo){
                $notification->notification_image   = asset('images/avatars/'.$this->user->photo);
            }else{
                $notification->notification_image   = asset('assets/images/no_avatar.png');
            }

            $notification->notification_link        = '<a href="'. route('site.friend.connect', $this->user->id ).
                '" role="button" class="btn btn-xs btn-primary notification-link">Connect</a>';
            $notification->save();

            return redirect()->back()->with('success', 'New friend added!');
        }
    }


    /**
     * Connect friends
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getConnect($id)
    {
        // get user for connecting
        $newFriend = User::where('id', $id)->firstOrFail();

        // get user friends
        $friends = $this->user->friends()->get();

        if ( !$friends->isEmpty() ){
            // search new user in user friends list
            if ( $friends->contains('id', $newFriend->id) ){
                return redirect()->back()->with('error', 'This friend is exist in your list');
            }
        }

        // create new friend
        Friend::create([
            'user_id'   => $this->user->id,
            'friend_id' => $newFriend->id
        ]);

        // create new notification
        $notification = new Notification();
        $notification->user_id                  = $newFriend->id;
        $notification->notification_header      = 'You have been added to friends!';
        $notification->notification_text        = $this->user->first_name.' has added you to his friends list';
        if ($this->user->photo){
            $notification->notification_image   = asset('images/avatars/'.$this->user->photo);
        }else{
            $notification->notification_image   = asset('assets/images/no_avatar.png');
        }
        $notification->save();

        return redirect()->route('site.friend')->with('success', 'New friend added!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDelete($id)
    {
        // get friend
        $friend = Friend::where('id', $id)->firstOrfail();

        // check access
        if ($friend->user_id !== $this->user->id){
            return abort('403');
        }

        // delete friend
        $friend->delete();

        return redirect()->back()->with('success', 'Deleted!');
    }
}
