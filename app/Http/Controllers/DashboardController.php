<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	//

	return $this->statistics('home_ajax');
    }

    public function show_page() {
	if (session('client_id') == null) {
	    return view('landing.landing');
	} else {
	    return $this->statistics('home');
	}
    }

    public function statistics($page) {
	$user = Controller::user_info();
	$total_people = Controller::count_all_people();

	$pending = DB::table('pending_sms')
			->where('client_id', $this->client_id)
			->where('status', 0)->get();

	$pending_sms = count($pending);
	$sms_sent = DB::table('pending_sms')->where('client_id', $this->client_id)->count();
	return view('dashboard.' . $page)->with(array
		    ('user' => $user, 'total_people' => $total_people, 'pending_sms' => $pending_sms, 'sms_sent' => $sms_sent));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
	//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
	//
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
	//
    }

}
