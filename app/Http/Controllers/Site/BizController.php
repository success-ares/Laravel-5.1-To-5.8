<?php namespace App\Http\Controllers\Site;

use Auth;
use App\Biz;
use App\Category;
use App\Product;
use App\Referral;
use App\Service\DifferentFunctionsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use File;

class BizController extends Controller
{
    use DifferentFunctionsService;


    // user
    protected $user;


    /**
     * BizController constructor.
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
     * Show user business
     * @return mixed
     */
    public function getIndex()
    {
        // get user biz
        $biz = $this->user->biz()->first();

        // if user don't have any business in DB
        if( !$biz ){
            return redirect()->route('site.biz.create')->with('success', 'Please add your business!');
        }

        // load product category and products
        $biz = $biz->load('category', 'product');

        return view('biz.index', compact('biz'));
    }


    /**
     * View business for all registered user
     * @param $alias
     * @return mixed
     */
    public function getView($alias)
    {
        // get biz and public products
        $biz = Biz::where('name_alias', $alias)->with('category', 'user')->firstOrFail();
		
		// get public refer program
		$products = Product::where('biz_id', $biz->id)->where('public', 1)->get();
        return view('biz.view', compact('biz', 'alias', 'products'));
    }


    /**
     * Become a business
     * @return mixed
     */
    public function getAccept()
    {
        return view('biz.accept');
    }


    /**
     * Become a business - add user
     * @param Request $request
     * @return mixed
     */
    public function postAccept(Request $request)
    {
        // form validation
        $this->validate($request, [
            'accept'    => 'accepted'
        ]);

        // edit user
        $this->user->business = 1;
        $this->user->save();

        return redirect()->route('site.biz.create')->with('success', 'You are business user now! Please add your business!');
    }


    /**
     * Create new business
     * @return mixed
     */
    public function getCreate()
    {
        // get business categories and sub categories
        $categories = Category::whereNull('parent_code')->get();
        $subCategories = Category::whereNotNull('parent_code')->get();

        return view('biz.create', compact('categories', 'subCategories'));
    }


    /**
     * Save new business
     * @param Request $request
     * @return mixed
     */
    public function postStore(Request $request)
    {
        // validate
        $this->validate($request, [
            'biz_name'      => 'required|max:255',
            'phone'         => 'max:255',
            'contact_person'=> 'required|max:255',
            'email'         => 'required|email',
            'category_code' => 'required|integer',
            'logo'          => 'sometimes|mimes:jpeg,png|max:1024'
        ]);

        // clean data
        $cleanData = $this->cleanData($request->all());

        // get user biz
        $biz = $this->user->biz()->first();

        // if user don't have any business in DB
        if( !$biz ){
            // create new biz
            $biz = new Biz();

            $logo = false;
            
            // add biz name alias
            $biz->name_alias = str_slug( $cleanData['biz_name']);
            
        }else{
            $logo = $biz->logo;
        }


        $biz->user_id = $this->user->id;
        $biz->biz_name = $cleanData['biz_name'];
        $biz->phone = $cleanData['phone'];
        $biz->email = $cleanData['email'];
        $biz->contact_person = $cleanData['contact_person'];
        $biz->description = $cleanData['description'];
        $biz->category_code = $cleanData['category_code'];

        // if set logo
        if ($request->hasFile('logo')){

            // get file, his name and extension
            $file = $request->file('logo');
            $fileExtension = $file->getClientOriginalExtension();

            // generate name for attachment
            $logoName = str_random(35).'.'.$fileExtension;

            $file->move(public_path('images/logos'), $logoName);

            // resize
            Image::make(public_path('images/logos/').$logoName)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();

            // if user change logo - delete old logo
            if($logo){
                File::delete('images/logos/'.$biz->logo);
            }

            $biz->logo = $logoName;

        }

        // save new biz
        $biz->save();

        return redirect()->route('site.biz.index')->with('success', 'Successful!');
    }


    /**
     * @return mixed
     */
    public function getEdit()
    {
        // get user biz
        $biz = $this->user->biz()->with('category')->firstOrFail();

        // get business categories and sub categories
        $categories = Category::whereNull('parent_code')->get();
        $subCategories = Category::whereNotNull('parent_code')->get();

        return view('biz.edit', compact('biz', 'categories', 'subCategories'));
    }
}
