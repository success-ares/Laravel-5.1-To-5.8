<?php

//********************************************* Only for Admin users ***************************************************
Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'access:admin']], function (){
    //========================================= Transactions =====================================================
    // all transactions
    Route::get('transaction/index', ['as' => 'admin.transaction.index', 'uses' => 'TransactionController@getIndex'] );
    // change transaction status
    Route::get('transaction/edit/{id}', ['as' => 'admin.transaction.edit', 'uses' => 'TransactionController@getEdit'] );
    Route::post('transaction/update', ['as' => 'admin.transaction.update', 'uses' => 'TransactionController@postUpdate'] );
    Route::post('transaction/credit', ['as' => 'admin.transaction.credit', 'uses' => 'TransactionController@postCredit'] );

    //======================================== Withdrawal ==============================================================
    Route::get('withdrawal/index', ['as' => 'admin.withdrawal.index', 'uses' => 'WithdrawalController@getIndex'] );
    Route::get('withdrawal/show/{id}', ['as' => 'admin.withdrawal.show', 'uses' => 'WithdrawalController@getShow'] );
    Route::post('withdrawal/update', ['as' => 'admin.withdrawal.update', 'uses' => 'WithdrawalController@getUpdate'] );

    //====================================== Direct debit ==============================================================
    Route::get('direct-debit/index', ['as' => 'admin.directDebit.index', 'uses' => 'DirectDebitController@getIndex'] );
    Route::get('direct-debit/edit/{id}', ['as' => 'admin.directDebit.edit', 'uses' => 'DirectDebitController@getEdit'] );
    Route::post('direct-debit/update', ['as' => 'admin.directDebit.update', 'uses' => 'DirectDebitController@postUpdate'] );
});

Route::group(['middleware' => 'auth'], function (){
    //======================================== Withdrawal ==============================================================business
    Route::post('withdrawal/request', ['as' => 'admin.withdrawal.request', 'uses' => 'Admin\WithdrawalController@postRequest'] );
});


//******************************************* Only for business users **************************************************
Route::group(['namespace' => 'Site', 'middleware' => ['auth', 'biz']], function(){

    //======================================= Plans ====================================================================
    Route::get('plan', ['as' => 'site.plan', 'uses' => 'PlanController@getIndex'] );
    Route::get('plan/buy', ['as' => 'site.plan.buy', 'uses' => 'PlanController@getBuy'] );
    Route::get('plan/create', ['as' => 'site.plan.create', 'uses' => 'PlanController@getCreate'] );
	Route::get('plan/active', ['as' => 'site.plan.active', 'uses' => 'PlanController@getActive'] );

    //========================================= Referrals programs =====================================================
    // create program
    Route::get('referral/create-program', ['as' => 'site.product.create', 'uses' => 'ProductController@getCreate'] );
    Route::post('referral/create-program', ['as' => 'site.product.store', 'uses' => 'ProductController@postStore'] );
    // edit program
    Route::get('referral/edit-program/{id}', ['as' => 'site.product.edit', 'uses' => 'ProductController@getEdit'] );
    Route::post('referral/update-program', ['as' => 'site.product.update', 'uses' => 'ProductController@postUpdate'] );
    // delete program
    Route::get('referral/delete-program/{id}', ['as' => 'site.product.delete', 'uses' => 'ProductController@getDelete'] );

    //============================================ Sales people ========================================================
    Route::get('sales-people', ['as' => 'site.sales.index', 'uses' => 'SalesController@getIndex'] );
    Route::get('sales-people/view/{id}', ['as' => 'site.sales.view', 'uses' => 'SalesController@getView'] );

    // Invite sales people
    Route::get('sales-people/invite', ['as' => 'site.sales.invite', 'uses' => 'SalesController@getInvite'] );
    Route::post('sales-people/invite', ['as' => 'site.sales.postInvite', 'uses' => 'SalesController@postInvite'] );

    // Approve or Decline to join referral program
    Route::get('sales-people/join/{code}/{decision}', ['as' => 'site.sales.joinDecision', 'uses' => 'SalesController@getJoinDecision'] )
        ->where('code', '[a-zA-Z0-9-]+')->where('decision', '[a-zA-Z0-9-]+');
    Route::post('sales-people/join', ['as' => 'site.sales.postJoin', 'uses' => 'SalesController@postJoin'] );

    //========================================== Referrals =============================================================
    // edit referral
    Route::post('referral/edit-referral', ['as' => 'site.ref.editRef', 'uses' => 'RefController@postEditRef'] );

    // AJAX - search sales for product
    Route::get('referral/search-sales/{id}', ['as' => 'site.ref.searchSales', 'uses' => 'RefController@getSearchSalesPerson'] );

    // AJAX - set referral value, when selected 'approved'
    Route::post('referral/set-value/{id}', ['as' => 'site.ref.setValue', 'uses' => 'RefController@postSetValue'] );

    //============================================== Business ==========================================================
    Route::get('my-business', ['as' => 'site.biz.index', 'uses' => 'BizController@getIndex'] );

    // create new biz
    Route::get('my-business/create', ['as' => 'site.biz.create', 'uses' => 'BizController@getCreate'] );
    Route::post('my-business/store', ['as' => 'site.biz.store', 'uses' => 'BizController@postStore'] );

    // edit biz
    Route::get('my-business/edit', ['as' => 'site.biz.edit', 'uses' => 'BizController@getEdit'] );

    // My business referrals
    Route::get('my-business-referrals', ['as' => 'site.ref.bizReferrals', 'uses' => 'RefController@getMyBusinessReferrals'] );

    // Add new business referrals
    Route::get('my-business-referrals/add-new', ['as' => 'site.ref.addBizReferrals', 'uses' => 'RefController@getAddBusinessReferrals'] );
    Route::post('my-business-referrals/add-new', ['as' => 'site.ref.createBizReferrals', 'uses' => 'RefController@postAddBusinessReferrals'] );

    //============================================= Billing ============================================================
    Route::get('billing', ['as' => 'site.billing', 'uses' => 'BillingController@getIndex'] );
    Route::post('billing/create', ['as' => 'site.billing.create', 'uses' => 'BillingController@postCreate'] );
    Route::get('billing/edit', ['as' => 'site.billing.edit', 'uses' => 'BillingController@getEdit'] );
    Route::post('billing/update', ['as' => 'site.billing.update', 'uses' => 'BillingController@postUpdate'] );

    Route::get('billing/add-card', ['as' => 'site.billing.addCard', 'uses' => 'BillingController@getAddCard'] );
    Route::post('billing/save-card', ['as' => 'site.billing.saveCard', 'uses' => 'BillingController@postSaveCard'] );

    Route::get('billing/add-direct', ['as' => 'site.billing.addDirect', 'uses' => 'BillingController@getAddDirect'] );
    Route::post('billing/save-direct', ['as' => 'site.billing.saveDirect', 'uses' => 'BillingController@postSaveDirect'] );
    Route::get('billing/delete-direct', ['as' => 'site.billing.deleteDirect', 'uses' => 'BillingController@getDeleteDirect'] );

    //================================== Payment redirect url ==========================================================
    Route::get('execute-payment/{status}', ['as' => 'site.payment.execute', 'uses' => 'PaymentController@getExecutePayment'] )
        ->where('status', '[a-z]+');

});

//************************************** Only for registered users *****************************************************
Route::group(['namespace' => 'Site', 'middleware' => 'auth'], function(){

    //======================================= Friends ==================================================================
    Route::get('friends', ['as' => 'site.friend', 'uses' => 'FriendController@getIndex'] );
    Route::post('friends/store', ['as' => 'site.friend.store', 'uses' => 'FriendController@postStore'] );
    Route::get('friends/delete/{id}', ['as' => 'site.friend.delete', 'uses' => 'FriendController@getDelete'] );
    Route::get('friends/connect/{id}', ['as' => 'site.friend.connect', 'uses' => 'FriendController@getConnect'] );
    
    //======================================= User profile =============================================================
    Route::get('my-profile', ['as' => 'site.profile', 'uses' => 'ProfileController@getIndex'] );
    Route::post('my-profile-update', ['as' => 'site.profile.update', 'uses' => 'ProfileController@postUpdate'] );
    // view user profiles
    Route::get('profile/{id}', ['as' => 'site.profile.view', 'uses' => 'ProfileController@getView'] );
    
    //========================================= Business ===============================================================
    Route::get('my-business/accept-page', ['as' => 'site.biz.accept', 'uses' => 'BizController@getAccept'] );
    Route::post('my-business/accept-page', ['as' => 'site.biz.postAccept', 'uses' => 'BizController@postAccept'] );

    // all referrals program
    Route::get('business/{alias}/programs', ['as' => 'site.product.all', 'uses' => 'ProductController@getAllProducts'] )
        ->where('alias', '[a-zA-Z0-9-]+');

    //========================================== Referrals =============================================================
    // view list program -> referrals
    Route::get('my-referrals', ['as' => 'site.ref.programList', 'uses' => 'RefController@getReferralsList'] );

    // view referral
    Route::get('referral/view/{id}', ['as' => 'site.ref.view', 'uses' => 'RefController@getViewReferral'] );

    // add new refer
    Route::get('referral/add-new/{id}', ['as' => 'site.ref.add', 'uses' => 'RefController@getAddNewRefer'] );
    Route::post('referral/add-new', ['as' => 'site.ref.postAdd', 'uses' => 'RefController@postAddNewRefer'] );

    // search user - AJAX
    Route::get('referral/search-user', ['as' => 'site.ref.searchUser', 'uses' => 'RefController@getSearchUser'] );
    Route::post('referral/search-seller', ['as' => 'site.ref.searchSeller', 'uses' => 'RefController@postSearchSeller'] );

    //=============================== apply to join referral program ===================================================
    Route::get('sales-people/join/{alias}', ['as' => 'site.sales.join', 'uses' => 'SalesController@getJoin'] )
        ->where('alias', '[a-zA-Z0-9-]+');

    //========================================= Favourites =============================================================
    Route::get('favourites/add/{id}', ['as' => 'site.favour.create', 'uses' => 'FavouriteController@getCreate'] );
    Route::get('favourites/remove/{id}', ['as' => 'site.favour.delete', 'uses' => 'FavouriteController@getDelete'] );

    //==================================== Messages ====================================================================
    Route::post('message/send-message', ['as' => 'site.message.postSend', 'uses' => 'MessageController@postSendMessage'] );
    Route::get('message/get-attachment/{name}', ['as' => 'site.message.attachment', 'uses' => 'MessageController@getAttachment'] )
        ->where('name', '[a-zA-Z0-9]+');
    
    //================================ Dashboard index page ============================================================
    Route::get('dashboard', ['as' => 'site.dashboard', 'uses' => 'DashboardController@getIndex'] );

    //========================================= Notifications ==========================================================
    Route::post('notification/delete', ['as' => 'site.notification.delete', 'uses' => 'NotificationController@postDelete'] );

});


//*************************************************** For all users ****************************************************
Route::group(['namespace' => 'Site'], function(){

    // public business page
    Route::get('business/{alias}', ['as' => 'site.biz.view', 'uses' => 'BizController@getView'] )->where('alias', '[a-zA-Z0-9-]+');

});


//********************************** Authentication and registration routes ********************************************
Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function(){
    
    // Authentication routes...
    Route::get('login', ['as' => 'auth.login', 'uses' => 'AuthController@showLoginForm'] );
    Route::post('login', ['as' => 'auth.postLogin', 'uses' => 'AuthController@postLogin'] );
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'AuthController@logout'] );

    // Registration routes...
    Route::get('register', ['as' => 'auth.register', 'uses' => 'AuthController@showRegistrationForm'] );
    Route::post('register', ['as' => 'auth.postRegister', 'uses' => 'AuthController@postRegister'] );
    Route::get('register/confirm-info', ['as' => 'auth.register.confirmInfo', 'uses' => 'AuthController@getConfirmInfo'] );
    Route::get('register/friend/{id}', ['as' => 'auth.register.friend', 'uses' => 'AuthController@getRegisterFriend'] );

    // Confirm Email
    Route::get('email-confirmation/{id}/{code}', ['as' => 'auth.confirm.email', 'uses' => 'AuthController@getConfirmEmail'])
        ->where('code', '[a-zA-Z0-9]+');
    // Confirm Account - Email
    Route::get('email-referral/{id}/{code}', ['as' => 'auth.confirm.referEmail', 'uses' => 'AuthController@getConfirmReferralEmail'])
        ->where('code', '[a-zA-Z0-9]+');
    // Confirm Invite
    Route::get('invite/{id}/{code?}', ['as' => 'auth.confirm.invite', 'uses' => 'AuthController@getConfirmInvite'])
        ->where('code', '[a-zA-Z0-9]+');

    // Password reset link request routes...
    Route::get('password/email', ['as' => 'auth.password.email', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'auth.password.postEmail', 'uses' => 'PasswordController@postEmail']);
    Route::get('password/reset-info', ['as' => 'auth.password.resetInfo', 'uses' => 'PasswordController@getResetInfo'] );
    
    // Password set
    Route::post('password/set', ['as' => 'auth.password.set', 'uses' => 'PasswordController@postSetPassword']);
    Route::post('password/invite-set', ['as' => 'auth.password.inviteSet', 'uses' => 'PasswordController@postInviteSetPassword']);

    // Password reset routes...
    Route::get('password/reset', ['as' => 'auth.password.token', 'uses' => 'PasswordController@showResetForm'])
        ->where('token', '[a-zA-Z0-9]+');
    Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'PasswordController@reset']);
    
    //modified password reset routes for receiving confirm mail.
    Route::get('password/email/reset', ['as' => 'auth.password.email.token', 'uses' => 'PasswordController@showResetForm'])
        ->where('token', '[a-zA-Z0-9]+');
    Route::post('password/email/reset', ['as' => 'password.reset', 'uses' => 'PasswordController@postEmail']);

    
});


//************************************************* Static pages *******************************************************

// Terms and conditions page
Route::get('terms-and-conditions', ['as' => 'terms', function () { return view('pages.terms');}]);

// About page
Route::get('about', ['as' => 'about', function () { return view('pages.about'); }]);

// Contact page
Route::get('contact', ['as' => 'contact', function () { return view('pages.contact'); }]);
Route::post('contact', ['as' => 'postcontact', 'uses' => 'ContactController@postSendMessage'] );

// Help page
Route::get('help', ['as' => 'help', function () { return view('pages.help'); }]);

 // Business Page (app/views/business.blade.php) 
Route::get('business', function() { return View::make('pages.business'); });

// Salespeople page (app/views/salespeople.blade.php)
Route::get('salespeople', function() { return View::make('pages.salespeople'); });

// Index page
Route::get('/', function () {
    return view('pages.index');
});
