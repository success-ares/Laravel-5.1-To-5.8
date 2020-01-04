<?php namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class FavouriteController extends Controller
{
    // user
    protected $user;


    /**
     * FavouriteController constructor.
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
     * Add new favourite product
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCreate($id)
    {
        // add new favourite
        $this->user->favourite()->attach($id);

        return redirect()->back()->with('success', 'New favourite product added!');
    }


    /**
     * Delete favourite product
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        // delete favourite
        $this->user->favourite()->detach($id);

        return redirect()->back()->with('success', 'Favourite product deleted!');
    }

}
