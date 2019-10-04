<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */
if (preg_match('/api/', url()->current())) {
    $controller = new \App\Http\Controllers\ApiController();
    die($controller->init());
   
}

//API page
    //Route::resource('api', 'Api');




//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//    
//});
