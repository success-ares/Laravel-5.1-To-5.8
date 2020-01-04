<?php namespace App\Http\Composers;

use App\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Auth;

class NotificationComposer
{
    // user
    protected $user;

    /**
     * NotificationComposer constructor.
     * @param Request $request
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }


    /**
     * @param View $view
     */
    public function compose(View $view){

        // get notifications
        $notifications = Notification::where('user_id', $this->user->id)->where('notification_status', 0)
            ->orderBy('created_at', 'desc')->take(10)->get();

        $view->with('notifications', $notifications);



    }
}