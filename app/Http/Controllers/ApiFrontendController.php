<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class ApiFrontendController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	return view('api.landing');
    }

    public function page() {
	$page = request()->route()->parameters()['page'];

	if (view()->exists('api.' . $page)) {
	    $view = view('api.' . $page);
	} else {
	    $view = view('landing.404');
	}
	return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
	//
	return view('api.create');
    }

    public function login() {
	return view('api.login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $name = null) {
	//

	$app_name = $name;
	if ($app_name == '') {
	    echo json_encode(array(
		'error' => "App name can not be empty",
		'success' => 0
	    ));
	    exit();
	}
	$app_info = DB::table('developer_app')->where('name', $app_name)->first();
	if (!empty($app_info)) {
	    die(json_encode(array(
		'error' => "This app name is in use, choose a different one",
		'success' => 0
	    )));
	} else {
	    $api_key = time() * date('y');
	    $api_secret = sha1(md5($api_key));
	    $result = DB::table('developer_app')->insertGetId([
		'name' => $app_name,
		'client_id' => session('client_id'),
		'api_key' => $api_key,
		'api_secret' => $api_secret
		    ], 'developer_id');

	    if ($result > 1) {
		echo json_encode(array(
		    'success' => 1,
		    'status' => '<h4 class="m-t-none">Your App info <small>(you may copy)</small></h4>'
		    . '<table class="table table-striped m-b-none text-sm">
    <thead> <tr> <th></th> <th></th> <th width="70"></th> </tr> </thead> 
    <tbody> 
	<tr> 
	    <td>Your App key:</td> 
	    <td>' . $api_key . '</td> 
	    <td class="text-right"> </td>
	</tr> 
	<tr> 
	    <td>Your App Secret:</td>
	    <td>' . $api_secret . '</td> 
	    <td class="text-right"> 
	<div class="btn-group"> 
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-pencil"></i></a>
	</div>
	    </td> 
	</tr> 
    </tbody> 
</table>'
		));
	    } else {
		echo json_encode(array(
		    'error' => "Error, occur, please try again later",
		    'success' => 0
		));
	    }
	}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function show($name = null) {

	$app = ApiController::getAppStat($name);
	if (empty($app)) {
	    die('App name is not available');
	}
	return view('api.loadapp', compact('app'));
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
    public function destroy($id) {
	DB::table('developer_app')
		->where('developer_id', $id)
		->where('client_id', session('client_id'))->delete();
	echo 'Success';
    }

}
