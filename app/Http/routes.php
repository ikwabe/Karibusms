<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */




/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */
Route::any('facebook',function(){
    echo 'facebook'; exit;
});
//Dashboard routes
Route::group(['middleware' => ['web']], function () {

    /*
     * Android Requests
     */
    Route::get('_android', 'AndroidController@index');

    Route::get('android_test', 'AndroidTestController@index');
    /**
     * constants
     * 
     */
    define('LOADER', '<p class="m-t-lg" align="center"><i class="fa fa-spinner fa fa-spin fa fa-2x"></i></p>');

    Route::get('/test', 'ApiController@test');
    Route::get('cron_job', 'CronJobController@index');

    /**
     * *** Landing pages load here ***********
     * @author Ephraim Swilla <ephraim@inetstz.com>
     */
    Route::get('/', 'DashboardController@show_page');

    Route::get('/customer', 'PeopleController@customer');

    //Signup
    Route::get('/signup/store', 'SignupController@store');
    Route::get('/email_verify/{user_id}', 'SignupController@store');
    Route::get('/privacy', 'SignupController@show');
    Route::get('/payment_terms', 'SignupController@show');
    Route::get('/verify', 'SignupController@verifyEmail');
    /**
     * ---------------------------------------------------------------------------
     * Pages after login
     * ---------------------------------------------------------------------------
     */
//People's Controller pages

    Route::get('/add_people', 'PeopleController@create');
    Route::get('/add_by_excel', 'PeopleController@uploadByExcel');
    Route::post('/upload_excel_submit', 'PeopleController@submitExcel');
    Route::get('/add_people_submit', 'PeopleController@store');
    Route::get('/people/{type}', 'PeopleController@index');
    Route::get('/edit_person/{id}', 'PeopleController@update');
    Route::get('/edit_category/{id}', 'PeopleController@updateCategory');
    Route::get('/add_category', 'PeopleController@addCategory');
    Route::get('/delete_person/{id}', 'PeopleController@destroy');
    Route::get('/view/{id}', 'PeopleController@show');
    Route::get('/settings/{page}', 'PeopleController@settings');
    Route::get('/delete_file', 'FileController@deleteFile');
    Route::post('/change_password/', 'PeopleController@changePassword');
    Route::post('/change_photo/', 'PeopleController@changePhoto');
    Route::get('/download_file/{file}', 'FileController@downloadFile');

//home page
    Route::get('/home', 'DashboardController@index');

//API page
    //Route::resource('api', 'Api');

    Route::get('/api', 'ApiFrontendController@index');
    Route::get('/api/{page}', 'ApiFrontendController@page');
    Route::get('/api_create_app', 'ApiFrontendController@create');
    Route::get('/api_login', 'ApiFrontendController@login');
    Route::get('/api_store/{name?}', 'ApiFrontendController@store');
    Route::get('/api_show/{name?}', 'ApiFrontendController@show');
    Route::get('/api_delete/{id}', 'ApiFrontendController@destroy');
    Route::get('/api_call', 'ApiController@init');
//API REMOTE call 

    Route::post('/api', 'ApiController@init');



//message page
    Route::get('/sms/{offset?}', 'MessageController@sms');
    Route::post('/sms_send/{type}', 'MessageController@sms_send');
    Route::post('/email_send/{type}', 'MessageController@email_send');
    Route::post('/sms_send_admin/{type}', 'AdminController@smsSend');
    Route::post('/email_send_admin/{type}', 'AdminController@emailSend');
    Route::get('/sms_content/{message_id}', 'MessageController@show');
    Route::get('/send_sms_dialog', 'MessageController@send_sms');
    Route::get('/send_email_dialog', 'MessageController@send_email');
    Route::get('/send_email_dialog', 'MessageController@send_email_view');
    Route::get('/email', 'MessageController@mail');
    Route::get('/pending_sms', 'MessageController@pendingSms');
    Route::get('/email_request', 'MessageController@request_mail');
    Route::get('/delete_message/{message_id}', 'MessageController@deleteMessage');
    Route::get('/email_reject', 'MessageController@reject_mail');
    Route::get('/load_address', 'PeopleController@load_address');
    Route::get('/resend_message/{message_id}', 'MessageController@resendSms');
    Route::get('/received_sms/{message_id?}', 'MessageController@receivedSms');
    /*
     * 
     * processing requests
     */

// login
    Route::get('/login/store', 'LoginController@store');
    Route::get('/logout', 'LoginController@destroy');
    Route::controllers(['password' => 'Auth\PasswordController']);
    Route::get('/password/{_missing}', 'LoginController@resetPassword');
    Route::get('/validate_code', 'LoginController@validateCode');
    Route::get('/password/reset_password_form/{code}', 'LoginController@resetPasswordForm');
    Route::post('/password/{_missing}', 'LoginController@resetPasswordFormSubmit');
    /**
     * ----------------------------------
     * Admin Pages Routes
     */
    Route::get('/payment_report', 'PaymentController@report');
    Route::get('/create_payment', 'PaymentController@create');
    Route::get('/store_payment', 'PaymentController@store');
    Route::get('/user/{report}', 'AdminController@show');
    Route::get('/delete_user/{user_id}', 'AdminController@destroy');
    Route::post('/create_ticket', 'AdminController@createTicket');
    Route::get('/getcron', 'AdminController@getTickets');


    //Payment  Controller
    Route::get('/user_payment', 'PaymentController@userPayment');
    Route::get('/add_payment', 'PaymentController@addPayment');
    Route::get('/pay_by_card', 'PaymentController@addCardPayment');
    Route::get('/view_report', 'PaymentController@viewPaymentReports');
    Route::get('/invoice/{quantity}', 'PaymentController@getInvoice');
    Route::get('/submit_receipt', 'PaymentController@addReceipt');
    Route::post('/credit_card_payment', 'PaymentController@bankCard');
    Route::get('/tocheckout', 'PaymentController@tocheckout');
    Route::get('/payment/status', 'PaymentController@status');
    //messages
    Route::get('/message', 'MessageController@show');


    //User
    Route::get('/client_setting', 'PeopleController@settings');
    Route::get('/profile', 'PeopleController@profile');
    Route::get('/profile', 'PeopleController@profile');
    Route::get('/user_download', 'PeopleController@download');

    //general page
    Route::get('/search/{report}', 'LandingController@search');
    Route::get('/contact_us_submit', 'LandingController@store');
    Route::get('/subscribe/{type}', 'LandingController@subscribe');
    Route::get('/mail', 'CronJobController@mail');
    Route::get('/{page?}', 'LandingController@show');
     
});
define('HOME', url('/') . '/');
define('SMS_PRICE', 20);
define('EXCHANGE_RATE', 2300);
