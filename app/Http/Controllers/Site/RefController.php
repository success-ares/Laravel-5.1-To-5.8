<?php namespace App\Http\Controllers\Site;

use App\Deal;
use App\Eway;
use App\Friend;
use App\Notification;
use App\Product;
use App\Referral;
use App\Transaction;
use App\User;
use App\Service\DifferentFunctionsService;
use App\Service\EmailSenderService;
use App\Service\EwayService;
use App\Service\MessageService;
use App\Service\PayPalService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Jobs\sendEmailAboutProductJob;
use App\Jobs\sendReferralDetailsJob;
use App\Jobs\sendInviteEmailJob;

class RefController extends Controller
{

    use DifferentFunctionsService, EmailSenderService, MessageService;

    // user
    protected $user;


    /**
     * RefController constructor.
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
     * Referrals I Made list
     * @return mixed
     */
    public function getReferralsList()
    {
        if ( $this->user->business && $this->user->biz ){

            // get all product for this business
            $products = $this->user->load('biz.product');

            // if user have products
            if( $products->biz->product ){

                // user products id's
                $productsId = $products->biz->product->pluck('id')->toArray();

                //get referrals for business user
                $referrals = Referral::where('parent_id', $this->user->id)->whereNotIn('product_id', $productsId)
                    ->with('user', 'product')->get();

            }else{

                // get referrals for business user if he isn't have any products or services
                $referrals = Referral::where('parent_id', $this->user->id)->with('user', 'product')->get();
            }

        }else{

            //get referrals for non business user
            $referrals = Referral::where('parent_id', $this->user->id)->with('user', 'product')->get();
        }

        return view('ref.referrals-list', compact('referrals'));

    }


    /**
     * List referrals for business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getMyBusinessReferrals()
    {
        // get business for this user
        $products = $this->user->load('biz.product');

        // check - have user biz and any products
        if( !$products->biz ){

            return redirect()->route('site.biz.create')->with('error', 'Please add your business!');

        }else{

            // check - have user any products?
            if ( $products->biz->product->isEmpty() ){
                return redirect()->route('site.product.create')->with('error', 'Please add services or products!');
            }

        }

        // products id's
        $productsId = $products->biz->product->pluck('id')->toArray();

        // get referrals for this business
        $referrals = Referral::whereIn('product_id', $productsId)->where('seller', 0)->with('user', 'product', 'parent')->get();

        return view('ref.biz-referrals-list', compact('referrals'));

    }


    /**
     * View selected referral
     * @param $id
     * @return mixed
     */
    public function getViewReferral($id)
    {
        // get referral
        $referral = Referral::where('id', $id)->with('user', 'product')->firstOrFail();

        // get messages
        $messages = $this->getMessages($referral->id);

        // If this user is business
        if ($this->user->business){

            // get all product for this business
            $products = $this->user->load('biz.product');

            // if user not have business or products
            if( !$products->biz ){
                abort(403);
            }else{
                if ($products->biz->product->isEmpty()){
                    abort(403);
                }
            }

            $productsId = $products->biz->product->pluck('id')->toArray();

            // check access
            if( in_array($referral->product_id, $productsId) ){

                // business owner can edit referral
                return view('ref.referral-edit', [
                    'referral'  => $referral,
                    'messages'  => $messages,
                    'user'      => $this->user,
                    'product'   => $referral->product
                ]);
            }

        }

        // check access
        if ($this->user->id !== $referral->parent_id){
            abort(403);
        }

        // only view referral
        return view('ref.referral-view', ['referral' => $referral, 'messages' => $messages, 'user' => $this->user]);

    }


    /**
     * View form - add new refer
     * @param $id
     * @return mixed
     */
    public function getAddNewRefer($id)
    {
        // get refer program
        $product = Product::where('id', $id)->with('biz')->firstOrFail();

        // if product not public - access control
        if ( !$product->public && $product->biz->user_id !== $this->user->id ){

            $productsId = Referral::where('user_id', $this->user->id)->get()->pluck('product_id')->toArray();

            if ( !in_array($id, $productsId) ){
                abort(403);
            }
        }

        // check - this user is owner for this business
        if ($this->user->id == $product->biz->user_id){
            $owner = true;
        }else{
            $owner = false;
        }

        return view('ref.add-refer', ['product' => $product, 'owner' => $owner]);
    }


    /**
     * Add new refer
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function postAddNewRefer(Request $request)
    {
        // validate form data
        $this->validate($request, [
            'referrer'  => 'sometimes|required|integer',
            'product_id'=> 'sometimes|required|integer',
            'first_name'=> 'sometimes|required|max:255',
            'last_name' => 'sometimes|required|max:255',
            'company'   => 'sometimes|max:255',
            'phone' => 'sometimes|required',
            'email' => 'required|email',
            'terms' => 'accepted',
            'value' => 'integer'
        ]);

        // clean data
        $cleanData = $this->cleanData($request->all());

        // get refer program
        $product = Product::where('id', $request->input('product_id'))->with('biz')->firstOrFail();

        // try find user
        $user = User::where('email', $cleanData['email'])->first();

        // if user not found create new user
        if ( !$user ){

            // new user flag
            $newUser = true;

            $user = new User();
            $user->first_name = $cleanData['first_name'];
            $user->last_name = $cleanData['last_name'];
            $user->company = $cleanData['company'];
            $user->phone = $cleanData['phone'];
            $user->email = $cleanData['email'];
            $user->description = $cleanData['description'];
            $user->type = 'user';
            $user->activation_code = str_random(50);
            $user->save();
        }else{

            // not new user flag
            $newUser = false;

            // if we found user check his referral programs
            $userProducts = $user->product()->get()->pluck('id')->toArray();

            if( in_array( $cleanData['product_id'], $userProducts ) ){
                return redirect()->back()->with('error', 'You can not register a user to the referral program twice');
            }
        }

        // create refer
        $refer = new Referral();
        $refer->user_id = $user->id;

        // if referrer added by businessmen
        if ($request->has('referrer')){
            $referFromForm = User::findOrFail($request->input('referrer'));
            $refer->parent_id = $referFromForm->id;
        }else{
            $refer->parent_id = $this->user->id;
        }

        $refer->product_id = $product->id;
        $refer->code = str_random(50);
        if ($request->has('value')){
            $refer->value = $cleanData['value'];
        }
        $refer->save();


        // send confirmation email if user new
        if ( $newUser && config('settings.sendEmail') ){
            // confirm email and set password
            // $this->sendConfirmEmail($user, true);
                    sendConfirmEmailjob::dispatch($user,true);

        }elseif ( !$newUser && config('settings.sendEmail')){
            // send email - about product
            // $this->sendEmailAboutProduct($user, $this->user, $product);
            sendEmailAboutProductJob::dispatch($user, $this->user, $product);
        }
        
        // send email to company
        if( config('settings.sendEmail') ){
            // $this->sendReferralDetails($this->user, $product->biz, $user, $refer->id);
            sendReferralDetailsJob::dispatch($this->user, $product->biz, $user, $refer->id);
        }

        return redirect()->route('site.biz.view', [$product->biz->name_alias])->with('success', 'New referral added');

    }



    /**
     * Edit referral info from view page
     * User
     */
    public function postEditRef(Request $request)
    {
        // validate data
        $this->validate($request, [
            'referral_id'   => 'required|integer',
            'first_name'    => 'required|max:100',
            'last_name'     => 'max:100',
            'phone'         => 'max:20',
            'company'       => 'max:255',
            'address'       => 'max:255',
            'value'         => 'required_if:status,Approved|numeric',
            'status'        => 'sometimes|required'
        ]);

        // find referral
        $referral = Referral::where('id', $request->input('referral_id'))->with('parent', 'user', 'product')->firstOrFail();

        // get all product for business user
        $products = $this->user->load('biz.product');
        $productsId = $products->biz->product->pluck('id')->toArray();

        // check access
        if ( !in_array($referral->product_id, $productsId) ){
            abort('403');
        }

        // clean data
        $cleanData = $this->cleanData($request->all());

        // change user data
        $referral->user->first_name = $cleanData['first_name'];
        $referral->user->last_name = $cleanData['last_name'];
        $referral->user->phone = $cleanData['phone'];
        $referral->user->company = $cleanData['company'];
        $referral->user->address = $cleanData['address'];
        $referral->user->description = $cleanData['description'];

        // change referral data
        if ($request->has('value')){
            $referral->value = $request->input('value');
        }

        if ($request->has('status') && $request->input('status') !== 'Approved'){
            $referral->status = $request->input('status');
        }


        // create new deal
        if ($request->input('status') == 'Approved' || $request->input('lead_status') == 'Approved'){

            // load billing info
            $billing = $this->user->billing()->with('directDebit')->first();

            // check - user billing info
            if ($billing) {

                // calculate price and create messages
                if ($request->input('status') == 'Approved' && $request->input('lead_status') == 'Approved'){

                    if ($referral->product->measure == '%') {

                        $price = ($referral->value * $referral->product->amount) / 100 + $referral->product->lead_reward;

                    } else {

                        $price = $referral->product->amount + $referral->product->lead_reward;;
                    }

                    $transactionDescription = 'Pyramd - approve referral and lead';

                    $referral->status = 'Approved';
                    $referral->lead_status = 'Approved';

                    $notificationText = 'Your referral and lead has been approved!';

                    $onlyLead = null;

                }elseif ($request->input('status') == 'Approved'){

                    if ($referral->product->measure == '%') {

                        $price = ($referral->value * $referral->product->amount) / 100;

                    } else {

                        $price = $referral->product->amount;
                    }

                    $transactionDescription = 'Pyramd - approve referral';

                    $referral->status = 'Approved';
                    $notificationText = 'Your referral has been approved!';

                    $onlyLead = null;

                }else{
                    // $request->input('lead_status') == 'Approved'
                    $price = $referral->product->lead_reward;
                    $transactionDescription = 'Pyramd - approve lead';

                    $referral->lead_status = 'Approved';
                    $notificationText = 'Your lead has been approved!';

                    $onlyLead = 1;
                }
				


                // check card or direct debit
                if ($billing->card_id) {

                    // create payment
                    $ewayService = new EwayService();

                    $response = $ewayService->createPayment([
                        'card-id' => $billing->card_id,
                        'price' => $price * 100,
                        'item-description' => $referral->product->name,
                        'transaction-description' => $transactionDescription,
                    ]);

                    // save payment
                    $eway = new Eway();
                    $eway->item_id = $referral->id;
                    $eway->transaction_id = $response['transaction-id'];
                    $eway->amount = $price;
                    $eway->status = $response['transaction-status'];
                    $eway->save();

                    // if payment status true, create deal
                    if($response['transaction-status']){

                        $dealId = $this->createDeal([
                            'referral-id'	 => $referral->id,
							'payment-id'	 => $eway->id,
							'payment-type'	 => 'eway',
							'amount'		 => $price,
							'paid_status'	 => 'Paid',
							'lead'          => $onlyLead
                        ]);
						
						// create new transaction
						$this->createTransaction([
                            'user-id'	 => $referral->parent->id,
							'source-id'	 => $dealId,
							'source-type'	 => 'deal',
							'type'		 => 'debit',
							'amount'	 => $price
                        ]);

						// update referral balance
						$referral->parent->balance += $price;
						$referral->parent->save();
						
                        //save user
                        $referral->user->save();

                        $referral->save();

                        // add notification
                        $this->addNotification($referral->parent_id, $referral->id, $notificationText);

                        // all ok
                        return redirect()->route('site.ref.bizReferrals')->with('success', $notificationText);

                    }else{

                        // failed payment
                        return redirect()->route('site.ref.bizReferrals')->with('error', 'Payment failed!');

                    }

                // check direct debit
                }elseif($billing->directDebit){

                    // if user direct debit account approved - create new deal
                    if ($billing->directDebit->status == 'approved'){

                        // create new deal
                        $dealId = $this->createDeal([
                            'referral-id'	 => $referral->id,
							'payment-id'	 => $billing->directDebit->id,
							'payment-type'	 => 'direct_debit',
							'amount'		 => $price,
							'paid_status'	 => 'Paid',
							'lead'			 => $onlyLead
						]);
						
						// create new transaction
						$this->createTransaction([
                            'user-id'	 => $referral->parent->id,
							'source-id'	 => $dealId,
							'source-type'	 => 'deal',
							'type'		 => 'debit',
							'amount'	 => $price
                        ]);

						// update referral balance
						$referral->parent->balance += $price;
						$referral->parent->save();
						
                        //save user
                        $referral->user->save();

                        // save referral
                        $referral->save();

                        // add notification
                        $this->addNotification($referral->parent_id, $referral->id, $notificationText);

                        // all ok
                        return redirect()->route('site.ref.bizReferrals')->with('success', 'Referral approved!');

                    }else{
                        return redirect()->route('site.billing')->with('error', 'Your direct debit has not yet been approved!');
                    }

                }else{
                    return redirect()->route('site.billing')->with('error', 'Please add payment details!');
                }

            }else{
                return redirect()->route('site.billing')->with('error', 'Please complete your payment details to approve this referral!');
            }

        }else{

            //save user
            $referral->user->save();

            // save referral
            $referral->save();
        }


        return redirect()->back()->with('success', 'Edited successfully');

    }


    /**
     * Manual add referral
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAddBusinessReferrals()
    {
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

        return view('ref.add-biz-referral', compact('products'));

    }


    /**
     * Add new referral and seller, for business user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAddBusinessReferrals(Request $request)
    {
        // validate form data
        $this->validate($request, [
            'product_id'        => 'required|integer',
            'seller_email'      => 'required|email',
            'seller_first_name' => 'max:255',
            'seller_last_name'  => 'max:255',
            'seller_address'    => 'max:255',
            'email'             => 'required|email',
            'first_name'        => 'max:255',
            'last_name'         => 'max:255',
            'address'           => 'max:255',
        ]);

        // clean data
        $cleanData = $this->cleanData($request->all());

        // search seller
        $seller = User::where('email', $request->input('seller_email'))->first();

        // search referral
        $referral = User::where('email', $request->input('email'))->first();

        // if not find seller
        if (!$seller){
            // create new user
            $seller = new User();
            $seller->email = $request->input('seller_email');
            $seller->first_name = $cleanData['seller_first_name'];
            $seller->last_name = $cleanData['seller_last_name'];
            $seller->address = $cleanData['seller_address'];
            $seller->activation_code = str_random(50);
            $seller->status = 1;
            $seller->save();

            // get biz and send email
            $biz = $this->user->load('biz');
            // $this->sendInviteEmail($seller, $biz->biz, $this->user);
            sendInviteEmailJob::dispatch($seller, $biz->biz, $this->user);
        }

        // if not find referral
        if (!$referral){
            // create new user
            $referral = new User();
            $referral->email = $request->input('email');
            $referral->first_name = $cleanData['first_name'];
            $referral->last_name = $cleanData['last_name'];
            $referral->address = $cleanData['address'];
            $referral->activation_code = str_random(50);
            $referral->status = 1;
            $referral->save();

            // confirm email and set password
            // $this->sendConfirmEmail($referral, true);
            sendConfirmEmailjob::dispatch($referral,true);

        }


        // if user seller for needed product
        $sellerForThisProduct = \DB::table('users')
            ->join('referrals', 'users.id', '=', 'referrals.user_id')
            ->join('products', 'referrals.product_id', '=', 'products.id')
            ->where('users.id', $seller->id)
            ->where('referrals.seller', 1)
            ->where('products.id', $request->input('product_id'))
            ->count();

        if (!$sellerForThisProduct){

            // create seller for this product
            $refSeller = new Referral();
            $refSeller->user_id = $seller->id;
            $refSeller->parent_id = $this->user->id;
            $refSeller->product_id = $request->input('product_id');
            $refSeller->code = str_random(50);
            $refSeller->seller = 1;
            $refSeller->save();
        }

        // create new referral
        $newReferral = new Referral();
        $newReferral->user_id = $referral->id;
        $newReferral->parent_id = $seller->id;
        $newReferral->product_id = $request->input('product_id');
        $newReferral->code = str_random(50);
        $newReferral->save();

        return redirect()->route('site.ref.bizReferrals')->with('success', 'New referral successfully added');
    }


    //================================================== AJAX ==========================================================

    /**
     * Search user - auto complete invite/add-referral form
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearchUser(Request $request)
    {
        if($request->has('term')){

            $email = $request->input('term');

            // find users
            $users = User::where('email', 'like', '%'.$email.'%')->get();

            // get friends for this user
            $friends = Friend::where('user_id', $this->user->id)->get()->pluck('friend_id')->toArray();


            $data = [];

            // create array
            foreach($users as $user){

                // if this user is a friend of mine
                if ( in_array($user->id, $friends) ){
                    $friend = true;
                }else{
                    $friend = false;
                }

                // user photo
                if ( $user->photo ){
                    $photo = asset('images/avatars/'.$user['photo']);
                }else{
                    $photo = null;
                }

                $data[] = [
                    'value' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'address' => $user['address'],
                    'company' => $user['company'],
                    'phone'   => $user['phone'],
                    'description' => $user['description'],
                    'photo'   => $photo,
                    'friend'    => $friend
                ];
            }

            return response()->json($data);

        }else{
            return response()->json([], 400);
        }
    }


    /**
     * Search sales person
     * @param Request $request
     * @param $product_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearchSalesPerson(Request $request, $product_id)
    {
        // find sales person for this product
        $product = Product::findOrFail($product_id);

        //find user/users
        if ($request->has('q')){
            $search = $request->input('q');

            $referrals = $product->referrals()->where('email', 'like', '%'.$search.'%')->get()->toArray();
        }else{
            $referrals = $product->referrals()->get()->toArray();
        }

        $data = [];

        // create array
        foreach($referrals as $user){
            $data[] = [
                'id' => $user['id'],
                'text' => $user['email']
            ];
        }

        return response()->json($data);
    }


    /*******************************************************************************************************************
     * Create new Deal
     */
    public function createDeal(array $data)
    {
        // create new deal
        $deal = new Deal();
        $deal->referral_id = $data['referral-id'];
        $deal->payment_id = $data['payment-id'];
        $deal->payment_type = $data['payment-type'];
        $deal->amount = $data['amount'];
        $deal->paid_status = $data['paid_status'];
        $deal->lead = $data['lead'];
        $deal->save();
		
		return $deal->id;
    }
	
    /*******************************************************************************************************************
     * Create new Transaction
     */
    public function createTransaction(array $data)
    {
        // create new transaction
        $transaction = new Transaction();
        $transaction->user_id = $data['user-id'];
        $transaction->source_id = $data['source-id'];
        $transaction->source_type = $data['source-type'];
        $transaction->type = $data['type'];
        $transaction->amount = $data['amount'];
        $transaction->save();

    }


    /**
     * Add notification, when approve referral
     * @param $sellerId
     * @param $referralId
     */
    public function addNotification($sellerId, $referralId, $notificationText)
    {
        // create new notification
        $notification = new Notification();
        $notification->user_id                  = $sellerId;
        $notification->notification_header      = $notificationText;
        $notification->notification_icon        = 'account-add';
        $notification->notification_icon_style  = 'success';
        $notification->notification_link        = '<a href="'. route('site.ref.view', $referralId ).
            '" role="button" class="btn btn-xs btn-primary">See More</a>';
        $notification->save();
    }

}
