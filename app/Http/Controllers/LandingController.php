<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PeopleController;

class LandingController extends Controller {

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
    }

    public function faq() {
	return json_encode(array('success' => 1, 'faq' => trans('faq')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
	//
	if (session('client_id') == NULL && $request['email'] == '') {
	    return json_encode(array('status' => 'warning', 'message' => 'Please write your email address first'));
	}
	$email = $request['email'] == '' ? $this->client_id : $request['email'];
	$comment = $request['comment'];
	$send = mail('info@inetstz.com', 'contact from KARIBUSMS', $comment . ', email.=' . $email);
	return $send == 1 ? json_encode(array('status' => 'success', 'message' => 'Thank you. Message sent successfully')) :
		json_encode(array('status' => 'warning', 'message' => 'message failed to be sent. Please retry'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($page) {
	define('COUNTRTY_CODE', 'TZ');
	//$this->logUser();
	if (view()->exists('landing.' . $page)) {
	    $data =  '';
	    $view = view('landing.' . $page, compact('data'));
	} else if ($page == 'signup') {
	    $view = view('signup.signup');
	} else {
	    $view = $this->showProfile($page);
	}
	return $view;
    }

    public function showProfile($name) {
	//check if this page exists
	$tag=  strtolower($name);
	$client = \collect(DB::select("select client_id from client where lower(username) = '{$tag}' OR lower(name)='{$tag}'" ))->first();
	$client_id= count($client)==1 ?   $client->client_id : null;
	if (empty($client_id)) {
	    return view('landing.404');
	} else {
	    $profile = new PeopleController();
	    return $profile->profile($client_id);
	}
    }

    public function search($keyword) {
	$client = DB::select("SELECT name, username,profile_pic,client_id from client where name like '%{$keyword}%' or username like '%{$keyword}%'");
	echo '<h4 class="title">Search Results</h4>';
	if (!empty($client)) {
	    echo '<section class="panel panel-default">'
	    . '<ul class="list-group alt">';
	    foreach ($client as $business) {

		$re_fname = '<b>' . $keyword . '</b>';
		$re_lname = '<b>' . $keyword . '</b>';
		$name = str_ireplace($keyword, $re_fname, $business->name);

		$link = $business->profile_pic != '' ?
			'media/images/business/' . $business->client_id . '/' . $business->profile_pic :
			'media/images/avatar_default.jpg';

		echo '
      
    <li class="list-group-item">
        <div class="media"> 
            <span class="pull-left thumb-sm">
                <img src="' . $link . '" alt="' . $business->username . '" class="img-circle">
            </span> 
            <div class="pull-right text-success m-t-sm"></div>
            <div class="media-body">
                <div><a href="' . url('/') . '/' . $business->username . '">' . $name . '</a></div> 
                <small class="text-muted">' . $business->username . '</small> 
            </div> 
        </div> 
    </li> 
   </ul>';
	    }
	    echo '</ul></section>';
	} else {
	    echo 'No Match Found';
	}
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $mail, $id) {
	//
	$mail->mail();
    }

    public function subscribe($type) {
	if (request('email') == '') {
	    $return = json_encode(array('status' => 'warning', 'message' => 'Email cannot be empty'));
	} else if (!filter_var(request('email'), FILTER_VALIDATE_EMAIL)) {
	    $return = json_encode(array('status' => 'warning', 'message' => 'Email ' . request('email') . '  is not valid'));
	} else {
	    DB::table('news_subscriber')->insertGetId([
		'email' => request('email'),
		'type' => $type
		    ]
		    , 'news_subscriber_id');
	    $return= json_encode(array('status' => 'success', 'message' => 'Email ' . request('email') . '  added successfully to '.$type.' news letter'));
	}
	return $return;
    }

}
