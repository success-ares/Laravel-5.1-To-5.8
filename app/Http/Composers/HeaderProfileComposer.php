<?php namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use Auth;

class HeaderProfileComposer
{
    // user
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }


    /**
     * @param View $view
     */
    public function compose(View $view){

        // If the user is authorized
        if($this->user){
            $view->with(['user' => $this->user]);
        }else{
            $view->with(['user' => null]);
        }


    }
}