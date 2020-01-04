<?php namespace App\Http\Controllers\Site;

use App\Biz;
use App\Product;
use App\Referral;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\DifferentFunctionsService;
use Auth;

class ProductController extends Controller
{

    use DifferentFunctionsService;


    // user
    protected $user;


    /**
     * ProductController constructor.
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
     * Form - add new product
     * @return mixed
     */
    public function getCreate()
    {
        //get biz
        $biz = $this->user->biz()->with('product')->firstOrFail();

        return view('product.create', compact('biz'));
    }


    /**
     * Save new product
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStore(Request $request)
    {
        // validate
        $this->validate($request, [
            'name'          => 'required|max:255',
            'description'   => 'required',
            'amount'        => 'required|numeric',
            'measure'       => 'required',
            'lead_reward'   => 'sometimes|numeric',
        ]);

        $cleanData = $this->cleanData($request->all());

        // get user business
        $biz = $this->user->biz()->firstOrFail();

        // create new product
        $product = new Product();
        $product->biz_id = $biz->id;
        $product->name = $cleanData['name'];
        $product->description = $cleanData['description'];
        $product->amount = $cleanData['amount'];
        $product->measure = $cleanData['measure'];

        // if lead not null
        if ($request->has('lead_reward') && $request->input('lead_reward') != 0){
            $product->lead_reward = $request->input('lead_reward');
        }


        if ($request->has('public')){
            $product->public = 1;
        }

        /*if ($request->has('auto_approve')){
            $product->auto_approve = 1;
        }*/

        // save new product
        $product->save();

        return redirect()->back()->with('success', 'New product successfully created!');
    }


    /**
     * Edit Product
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        // find product and check access
        $product = Product::where('id', $id)->where('biz_id', $this->user->biz->id)->firstOrFail();

        return view('product.edit', compact('product'));
    }


    /**
     * Update product
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate(Request $request)
    {
        // validate data
        $this->validate($request, [
            'product_id'    => 'required|integer',
            'name'          => 'required|max:255',
            'description'   => 'required',
            'amount'        => 'required|numeric',
            'measure'       => 'required',
            'lead_reward'   => 'sometimes|numeric',
        ]);

        // find product and check access
        $product = Product::where('id', $request->input('product_id'))->where('biz_id', $this->user->biz->id)->firstOrFail();

        // clean data
        $cleanData = $this->cleanData($request->all());

        // update data
        $product->name = $cleanData['name'];
        $product->description = $cleanData['description'];
        $product->amount = $cleanData['amount'];
        $product->measure = $cleanData['measure'];
        $product->lead_reward = $request->input('lead_reward');

        if ($request->has('public')){
            $product->public = 1;
        }else{
            $product->public = 0;
        }

        if ($request->has('auto_approve')){
            $product->auto_approve = 1;
        }else{
            $product->auto_approve = 0;
        }

        $product->save();

        return redirect()->route('site.biz.index')->with('success', 'Product/Service updated!');
    }


    /**
     * Delete product
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        // find product and check access
        $product = Product::where('id', $id)->where('biz_id', $this->user->biz->id)->firstOrFail();

        // delete referrals relations
        $product->referrals()->detach();

        // delete product
        $product->delete();

        return redirect()->route('site.biz.index')->with('success', 'Product/Service deleted!');
    }


    /*******************************************************************************************************************
     * View all referral programs
     * @param $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAllProducts($alias)
    {
        // get biz
        $biz = Biz::where('name_alias', $alias)->firstOrFail();

        // access control
        if ($biz->user_id == $this->user->id){

            // get all refer program
            $products = Product::where('biz_id', $biz->id)->get();
        }else{
            // get only public programs, if user not referral for product
            $refers = Referral::where('user_id', $this->user->id)->get()->lists('product_id')->toArray();

            $products = Product::where('biz_id', $biz->id)->where('public', 1)->orWhere(function($query) use ($refers, $biz){
                $query->whereIn('id', $refers)->where('biz_id', $biz->id);
            })->get();
        }

        // get user favourite products
        $favourites = $this->user->favourite()->get()->lists('id')->toArray();

        return view('product.view-all', compact('products', 'favourites'));
    }
}
