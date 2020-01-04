<?php namespace App\Http\Controllers\Site;

use App\Biz;
use App\Plan;
use App\Product;
use App\Proposal;
use Carbon\Carbon;
use DB;
use App\Referral;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\EmailSenderService;
use App\Service\DifferentFunctionsService;
use Auth;
use App\Jobs\sendInviteEmailJob;
use App\Jobs\sendJoinDetailsJob;
use App\Jobs\sendJoinApprovedJob;
use App\Jobs\sendJoinDeclinedJob;

class SalesController extends Controller
{
    use DifferentFunctionsService, EmailSenderService;

    // user
    protected $user;


    /**
     * SalesController constructor.
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
     * Sales people lists
     * @return mixed
     */
    public function getIndex()
    {
        $referrals = [];

        if ( $this->user->biz ){

            // get all product for this business
            $products = $this->user->load('biz.product');

            // check - has user products
            if ( !$products->biz->product->isEmpty() ){

                $productsId = $products->biz->product->pluck('id')->toArray();

                //get all referrals - for biz products
                $referrals = DB::table('referrals')
                    ->join('users', 'referrals.user_id', '=', 'users.id')
                    ->join('products', 'referrals.product_id', '=', 'products.id')
                    ->select( 'referrals.id', 'referrals.user_id', 'users.first_name', 'users.last_name', 'users.company', 'users.email',
                        DB::raw('SUM(referrals.value) AS total_value, SUM(
                            CASE
                                WHEN products.measure = \'$\' THEN products.amount
                                WHEN products.measure = \'%\' THEN ((products.amount * referrals.value) / 100)
                                ELSE 0
                            END
                         ) AS total_bonus')
                    )
                    ->where('seller', 1)
                    ->whereIn('product_id', $productsId)
                    ->groupBy('user_id')->get();
            }

        }

        return view('sales.index', compact('referrals'));
    }


    /**
     * View sales people
     * @param $id
     * @return mixed
     */
    public function getView($id)
    {
        // find user
        $user = User::findOrFail($id);

        // get products
        $products = $user->product()->where('biz_id', $this->user->biz->id)->get();

        // get referrals
        $referrals = Referral::where('parent_id', $id)->whereIn('product_id', $products->pluck('id')->toArray())
            ->with('user', 'product')->get();

        return view('sales.view', compact('user', 'products', 'referrals'));
    }


    /**
     * Show invite sales-people form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getInvite()
    {
        // check access
        if( !$this->user->business ){
            abort(403);
        }

        //get business products
        $products = $this->user->load('biz.product');

        // check - have user biz and any products
        if( !$products->biz ){
            return redirect()->route('site.biz.create')->with('error', 'Please add your business!');
        }else{

            if ( $products->biz->product->isEmpty() ){
                return redirect()->route('site.product.create')->with('error', 'Please add services or products!');
            }
        }

        // get sellers
        $sellers = Referral::where('parent_id', $this->user->id)->where('seller', 1)->get()->count();

        // check user plan
        $userPlan = Plan::where('user_id', $this->user->id)->first();

        // if user have many sellers
        if ($sellers >= 1){
            // if user have subscription
            if ($userPlan){
                // check subscription date
                if ( $userPlan->finished_at->lt(Carbon::now()) ){
                    return redirect()->route('site.plan')->with('error', 'Your subscription has ended, please renew it!');
                }
            }else{
                return redirect()->route('site.plan')->with('error', 'Please create new subscription!');
            }
        }

        return view('sales.invite', compact('products'));
    }


    /**
     * Post Invite sales-people form
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postInvite(Request $request)
    {
        // validate
        $this->validate($request, [
            'product_id'=> 'required',
            'email'     => 'required|email',
            'first_name'=> 'required|max:255',
            'last_name' => 'max:255',
            'address'   => 'max:255'
        ]);

        //clean data
        $cleanData = $this->cleanData($request->all());

        // find or create user
        $user = User::where('email', $cleanData['email'])->first();

        // create new user if not found
        if( !$user ){
            $user = new User();
            $user->email = $cleanData['email'];
            $user->first_name = $cleanData['first_name'];
            $user->last_name = $cleanData['last_name'];
            $user->address = $cleanData['address'];
            $user->activation_code = str_random(50);
            $user->status = 1;
            $user->save();
        }else{
            // search register a user to the referral program twice
            $products = $user->refer()->get()->pluck('product_id')->toArray();

            foreach($products as $product){
                if ( in_array($product, $cleanData['product_id']) ){

                    return redirect()->back()->with('error', 'You can not register a user to the referral program twice');
                }
            }

        }

        // create new referral/referrals
        foreach($cleanData['product_id'] as $productId){
            $refer = new Referral();
            $refer->user_id = $user->id;
            $refer->product_id = $productId;
            $refer->code = str_random(50);
            $refer->seller = 1;
            $refer->parent_id = $this->user->id;
            $refer->save();
        }

        // get biz and send email
        $biz = $this->user->load('biz');
        if( config('settings.sendEmail') ){
            // $this->sendInviteEmail($user, $biz->biz, $this->user);
            sendInviteEmailJob::dispatch($user, $biz->biz, $this->user);
        }

        if ( $request->ajax() ){
            return response()->json(['new_user_id' => $user->id, 'new_user_email' => $user->email]);
        }else{
            return redirect()->route('site.dashboard')->with('success', 'Success!');
        }
    }


    //======================================= Apply to be a referrer ===================================================

    /**
     * apply to join referral program
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getJoin($alias)
    {
        // get business user
        $business = Biz::where('name_alias', $alias)->firstOrFail();

        // create proposal
        $proposal = new Proposal();
        $proposal->user_id = $this->user->id;
        $proposal->biz_id = $business->id;
        $proposal->code = str_random(50);
        $proposal->save();

        // send email to business owner
        if( config('settings.sendEmail') ) {
            // $this->sendJoinDetails($business, $this->user, $proposal->code);
            sendJoinDetailsJob::dispatch($business, $this->user, $proposal->code);
        }

        return redirect()->back()->with('success', 'Thank you we\'ll get in touch soon');
    }


    /**
     * Approve or Decline new seller
     * @param $id
     * @param $decision
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getJoinDecision($code, $decision)
    {
        // get proposal with user and business
        $proposal = Proposal::where('code', $code)->with('user', 'biz')->firstOrFail();

        // access control
        if ($this->user->id !== $proposal->biz->user_id){
            abort(403);
        }

        // select decision
        if ($decision == 'approve'){

            // get all business products
            $products = $proposal->biz->load('product');

            return view('sales.join', ['user' => $proposal->user, 'products' => $products, 'code' => $proposal->code]);

        }elseif ($decision == 'decline'){

            // send email
            if( config('settings.sendEmail') ) {
                // $this->sendJoinDeclined($proposal->user);
                sendJoinDeclinedJob::dispatch($proposal->user);
            }

            // delete proposal
            $proposal->delete();

            return redirect()->route('site.dashboard')->with('success', 'You have rejected a request from the new seller!');

        }else{
            abort(404);
        }
    }


    /**
     * Create new sales person
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postJoin(Request $request)
    {
        // validate form data
        $this->validate($request, [
            'code'      => 'required|alpha_dash',
            'product'   => 'required'
        ]);

        // get proposal with user and business
        $proposal = Proposal::where('code', $request->input('code'))->with('user.product', 'biz')->firstOrFail();

        // access control
        if ($this->user->id !== $proposal->biz->user_id){
            abort(403);
        }

        // user products id
        $userProducts = $proposal->user->product->pluck('id')->toArray();

        // get products
        $products = Product::whereIn('id', $request->input('product'))->where('biz_id', $proposal->biz->id)->get();

        // create referrals
        foreach ($products as $product){

            //if the user is already a participant of the program
            if ( in_array($product->id, $userProducts)){

                Referral::where('user_id', $proposal->user->id)->where('product_id', $product->id)->update(['seller' => 1]);

            }else{

                $referral = new Referral();
                $referral->user_id = $proposal->user->id;
                $referral->parent_id = $this->user->id;
                $referral->product_id = $product->id;
                $referral->code = str_random(50);
                $referral->seller = 1;
                $referral->save();
            }

        }

        // send email
        if( config('settings.sendEmail') ) {
            // $this->sendJoinApproved($proposal->user, $proposal->biz->biz_name);
            sendJoinApprovedJob::dispatch($proposal->user, $proposal->biz->biz_name);
        }

        // delete proposal
        $proposal->delete();

        return redirect()->route('site.dashboard')->with('success', 'New seller approved!');
    }
}
