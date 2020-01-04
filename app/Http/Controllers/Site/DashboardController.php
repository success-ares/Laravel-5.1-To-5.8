<?php namespace App\Http\Controllers\Site;

use App\Transaction;
use App\Service\MessageService;
use Carbon\Carbon;
use DB;
use App\Referral;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    use MessageService;

    // user
    protected $user;


    /**
     * DashboardController constructor.
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
     * Dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
       
        // if user admin
        if ($this->user->type == 'admin'){
            return view('dashboard.admin');
        }

        // if user business
        if ($this->user->business){
            return $this->businessDashboard();

        }else{

            return $this->salesDashboard();

        }
    }

    
    /**
     * Business dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function businessDashboard()
    {
        // if user don't have any products and business
        $referrals = collect([]);
        $topSellers = collect([]);
        $totalSales = null;
        $thisMonth = null;
        $topProducts = [];
        $perMonth = [];
        $change = null;
        $changeSign = null;

        //get business products
        $products = $this->user->load('biz.product');

        // if user have business and any products
        if($products->biz){

            if ( !$products->biz->product->isEmpty() ){

                // products id array
                $productsId = $products->biz->product->pluck('id')->toArray();

                
                // get all referrals for this business products
                $allReferrals = Referral::whereIn('product_id', $productsId)
                    ->with('user', 'product')
                    ->orderBy('created_at', 'desc')
                    ->get();
                   
                //sellers
                $sellers = $allReferrals->whereStrict('seller', 1);
                // top sellers
                $topSellers = $sellers->unique(function ($item){
                    return $item->user->id;
                });

                // referrals
                $referrals = $allReferrals->whereStrict('seller', 0);


                // approved referrals
                $approvedReferrals = $referrals->whereStrict('status', 'Approved');

                // total sales
                $totalSales = $approvedReferrals->sum('value');

                // get month
                $month = Carbon::now()->month;

                // revenue for this month
                $thisMonth = $approvedReferrals->sum(function ($item) use($month) {

                    if ($month == $item->created_at->month){

                        return $item->value;
                    }
                });

                // revenue for previous month
                $previousMonth = $approvedReferrals->sum(function ($item) use($month) {

                    if ($month - 1 == $item->created_at->month){

                        return $item->value;
                    }
                });

                // if previousMonth == 0
                if ($previousMonth){
                    // change from the previous month
                    $change = round( (100 - $thisMonth * 100 / $previousMonth), 2 );

                    // change sign
                    if ($thisMonth - $previousMonth > 0){
                        $changeSign = true;
                    }else{
                        $changeSign = false;
                    }
                }

                // revenue for 6 month
                $perMonth = $approvedReferrals->groupBy(function($date) {
                    return $date->created_at->format('m');
                })->take(6)->reverse();

                //top products
                $topProducts = $allReferrals->groupBy(function ($item){
                    return $item->product->name;
                });

            }

        }

        return view('dashboard.business', [
            'user' => $this->user,
            'topSellers' => $topSellers,
            'referrals' => $referrals,
            'totalSales'=> $totalSales,
            'thisMonth' => $thisMonth,
            'change'    => $change,
            'changeSign'=> $changeSign,
            'perMonth'  => $perMonth,
            'topProducts' => $topProducts,
        ]);
    }


    /**
     * Sales Dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function salesDashboard()
    {
        // get favourite products
        $favourites = $this->user->favourite()->get();
        // get all referrals
        $referrals = collect( DB::table('referrals')
            ->join('users', 'referrals.user_id', '=', 'users.id')
            ->join('products', 'referrals.product_id', '=', 'products.id')
            ->select( 'referrals.id', 'referrals.value', 'referrals.status', 'referrals.created_at',
                'users.first_name', 'users.last_name', 'users.phone', 'users.company', 'users.email', 'users.photo',
                DB::raw(' products.name AS product_name ')
            )
            ->where('referrals.parent_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->get()
        );

        //get all user transactions
        $transactions = Transaction::where('user_id', $this->user->id)->where('type', 'debit')->orderBy('created_at', 'desc')->get();

        if ($transactions) {

            // group by month
            $transactionsPerMonth = $transactions->groupBy(function($date) {
                return $date->created_at->format('m');
            })->take(6)->reverse();
        }else{

            // if user don't have any transactions
            $transactionsPerMonth = collect([]);
        }

        // total revenue
        $totalRevenue = $transactions->sum('amount');

        // get month
        $month = Carbon::now()->month;

        // revenue for this month
        $thisMonth = $transactions->sum(function ($item) use($month) {

            if ($month == $item->created_at->month){

                return $item->amount;
            }
        });

        // get business this user
        $products = $this->user->product()->with('biz')->get();

        // select unique business for this user
        $business = $products->map(function ($item){
            return $item->biz;
        });

        $business = $business->unique();

        // Dashboard messages
        $referralsId = $referrals->pluck('id')->toArray();

        // get messages
        $messages = $this->getMessagesSeller($this->user->id, $referralsId);

        return view('dashboard.sales', [
            'favourites'=> $favourites,
            'user'      => $this->user,
            'referrals' => $referrals,
            'totalRevenue' => $totalRevenue,
            'thisMonth' => $thisMonth,
            'perMonth'  => $transactionsPerMonth,
            'business'  => $business,
            'messages'  => $messages
        ]);
    }
}
