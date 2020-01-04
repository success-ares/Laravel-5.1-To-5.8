<?php

namespace App\Http\Controllers\Site;

use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class NotificationController extends Controller
{
    // user
    protected $user;

    /**
     * NotificationController constructor.
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
     * Delete notification
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(Request $request)
    {
        // validate
        $this->validate($request, ['id' => 'required|integer']);

        // get notification
        $notification = Notification::where('id', $request->input('id'))->first();

        // if no result
        if (!$notification){
            return response()->json(false);
        }

        // check access
        if ( $notification->user_id == $this->user->id ){
            // delete notification
            $notification->delete();

            return response()->json(true);
        }else{
            return response()->json(false);
        }

    }
}
