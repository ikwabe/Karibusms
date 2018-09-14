<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as DB;

class LoginController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	//
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
	//
	$input = request()->except('_token', 'token');

	//$users = DB::table('users')->where($input);
	if (Auth::attempt($input, false)) {
	    /* Add logged in User Type and Name to the session */
	    request()->session()->put('user_type', Auth::user()->user_type);
	    request()->session()->put('name', Auth::user()->name);
	    $data['success'] = true;
	    if (Auth::user()->checked == '1') {
		if (Auth::user()->active == '1') {
		    $data['status'] = 2;
		    DB::table('staff')->where('staff_id', Auth::user()->id)->update(['last_login' => 'NOW()']);
		} else {
		    $data['status'] = 1;
		    $data['name'] = Auth::user()->name;
		    Auth::logout();
		}
	    } else {
		$data['name'] = Auth::user()->name;
		$data['status'] = 0;
		Auth::logout();
	    }
	} else {
	    $data['success'] = false;
	}
	return Response::json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store() {
	//
//	$input = $request->all();
//	/* $input = $request->except(['username']); */
//	//$input['user_type'] = 'staff';
//	//$users = DB::table('users')->where($input);
//	if (Auth::attempt($input, false)) {
//	    $data['success'] = true;
//	} else {
//	    $data['success'] = false;
//	}
//	return Response::json($data);
//

	$data = array();
	parse_str($_GET['datastring'], $data);
	$phone = $data['phone_number'];
	$password = sha1(md5(sha1($data['password'])));
	$number = validate_phone_number($phone);
	
	$results = DB::table('client')->where(array('phone_number' => $number[1], 'password' => $password))->first();
	
	if (!empty($results)) {
	    //this user is successfully login
	    session(['client_id' => $results->client_id]);
	    session(['username' => $results->username]);
	    $this->storeLoginInformation($results->client_id);
	    echo json_encode(array('error' => 0, 'result' => $results));
	} else {
	    //user is not available
	    echo json_encode(array('error' => 1, 'result' => $results));
	}
    }

    public function storeLoginInformation($client_id, $device = null, $ip_address = null) {
	$login_device = $device == null ? 'web' : $device;
	$user_device = $device == 'android' ? request('manufacturer') . ' ' . request('model') : null;
	$login_id = DB::table('login')->insertGetId([
	    'device' => $login_device,
	    'ip_address' => $ip_address,
	    'client_id' => $client_id,
	    'location' => '',
	    'device' => $user_device
		], 'login_id');
	session(['login_id' => $login_id]);
	return $login_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
	//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
	//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
	//
    }

    public function resetPassword(Request $request, $id = NULL) {
	if (request('code') != '') {
	    return $this->validateCode();
	} else if (request('data') != '') {
	    return $this->resetPasswordFormSubmit();
	}
	$phone_number = validate_phone_number($request['phone'])[1];
	$data = DB::table('users')->where('phone_number', $phone_number)->first();
	if (!empty($data)) {
	    //send codes here
	    $this->sendResetCodes($data);
	    echo json_encode(array(
		'status' => 'success',
		'message' => 'Message sent to your phone with validation codes'
	    ));
	} else {
	    echo json_encode(array(
		'status' => 'warning',
		'message' => 'Sorry, This phone number is not available'
	    ));
	}
    }

    private function sendResetCodes($user) {
	$status = DB::table('password_resets')
			->where('status', 0)
			->where('phone', $user->phone_number)->first();
	$code = str_random(6);
	if (empty($status)) {
	    DB::table('password_resets')->insert([
		'phone' => $user->phone_number,
		'token' => $code,
	    ]);
	} else {
	    DB::table('password_resets')
		    ->where('phone', $user->phone_number)
		    ->update(['token' => $code]);
	}
	$content = 'Hello ' . $user->name . ', your reset code is ' . $code;
	$message = new MessageController();
	$message->client_id = 1; //we set client ID to be our company ID for proper tracking SMS status
	$message->saveSms($content, array($user->phone_number), 1, NULL, 'karibuSMS', NULL);
    }

    public function validateCode() {
	$status = DB::table('password_resets')
			->where('status', 0)
			->where('token', request('code'))->first();
	if (!empty($status)) {
	    //these codes are valid
	    //update DB
	    DB::table('password_resets')
		    ->where('password_resets_id', $status->password_resets_id)
		    ->update(['status' => 1]);
	    echo json_encode(array(
		'status' => 'success',
		'message' => 'Success'
	    ));
	} else {
	    echo json_encode(array(
		'status' => 'warning',
		'message' => 'Error, this code is not valid'
	    ));
	}
    }

    public function resetPasswordForm($token) {
	return view('auth.passwords.reset_by_phone', compact('token'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetPasswordFormSubmit($id = NULL) {
	parse_str(request('data'), $data);
	$result = (object) $data;
	if ($result->password != $result->password_confirmation) {
	    die(json_encode(array(
		'status' => 'danger',
		'message' => 'Password do not match'
	    )));
	} else if (strlen($result->password) < 6) {
	    die(json_encode(array(
		'status' => 'warning',
		'message' => 'Password should have at least SIX characters'
	    )));
	} else {
	    //$password = bcrypt($result->password); // we will use this once all users submit their email
	    $password = sha1(md5(sha1($result->password)));

	    //update our DB
	    $user = DB::table('password_resets')->where('token', $result->token)->first();
	    DB::table('client')
		    ->where('phone_number', $user->phone)
		    ->update(['password' => $password]);

	    die(json_encode(array(
		'status' => 'success',
		'message' => 'New password has been reset successfully. You can login now'
	    )));
	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = null) {

	DB::table('login')
		->where('login_id', session('login_id'))
		->update(['logout_time' => 'now()']);
	session(['client_id' => NULL]);
	session(['username' => NULL]);
	session(['login_id' => NULL]);
	echo '1';
    }

}
