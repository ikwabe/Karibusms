<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class AdminController extends Controller {

    private $ticket_API_KEY = '157E6587D3917E455C8EC209B5958890';
    private $ticket_url = 'http://support.karibusms.com/api/tickets.json';

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
    public function show($report) {
	//
	if ($report == 'statistics') {
	    $users = DB::select("SELECT a.phone_number,a.client_id,a.name,a.country,a.reg_time,a.email, a.location, b.message_left, a.gcm_id,a.register_by, a.type, c.total as subscribers FROM client a LEFT JOIN sms_status b ON a.client_id=b.client_id LEFT JOIN client_subscribers c ON c.client_id=a.client_id ");
	    $view = view('admin.user_statistics', compact('users'));
	} else {
	    $view = view('admin.' . $report);
	}
	return $view;
    }

    public function createExcel() {
	$users = \App\User::select('id', 'name', 'phone_number')->get();
	Excel::create('users', function($excel) use($users) {
	    $excel->sheet('Sheet 1', function($sheet) use($users) {
		$sheet->fromArray($users);
	    });
	})->export('xls');
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
	DB::table('message')->where('client_id', $id)->delete();
	$delete = DB::table('client')->where('client_id', $id)->delete();
	echo $delete == 1 ? json_encode(array(
		    'status' => 'success',
		    'message' => 'User deleted successfully'
		)) : json_encode(array(
		    'status' => 'warning',
		    'message' => 'Error occurs, try again later'
	));
    }

    public function createTicket() {
	$user = DB::table('client')->where('client_id', $this->client_id)->first();
	$data = array(
	    'name' => $user->name,
	    'email' => $user->email,
	    'subject' => request('title'),
	    'message' => request('message'),
	    'ip' => $_SERVER['REMOTE_ADDR'],
	    'attachments' => array(),
	);
	$ticket_id = $this->pushTicket($data);
	echo $ticket_id > 0 ? json_encode(array(
		    'status' => 'success',
		    'message' => 'Message sent successfully. Your ticket ID is ' . $ticket_id
		)) : json_encode(array(
		    'status' => 'warning',
		    'message' => 'Error occurs, please try again later'
	));
    }

    private function pushTicket($data) {

	/*
	 * Add in attachments here if necessary

	  $data['attachments'][] =
	  array('filename.pdf' =>
	  'data:image/png;base64,' .
	  base64_encode(file_get_contents('/path/to/filename.pdf')));
	 */
#set timeout
	set_time_limit(30);

#curl post
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $this->ticket_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.7');
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:', 'X-API-Key: ' . $this->ticket_API_KEY));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($code != 201) {
	    die(json_encode(array(
		'status' => 'warning',
		'message' => 'Unable to create ticket. Please try again later '
	    )));
	}

	return $ticket_id = (int) $result;
    }

    public function getTickets() {

#set timeout
	set_time_limit(30);

#curl post
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $this->ticket_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, '');
	curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.7');
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:', 'X-API-Key: ' . $this->ticket_API_KEY));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	curl_close($ch);

	if (preg_match('/HTTP\/.* ([0-9]+) .*/', $result, $status) && $status[1] == 200)
	    exit(0);

	echo $result;
    }

    public function smsSend($type) {
	if ($type == 1) {
	    //send SMS to all members

	    $message = new MessageController();
	    $message_id = $this->createAdminMessage();

	    request('message_type') != 2 ? $message->send($message_id) : '';
	    echo json_encode(array(
		'message' => 'Message Sent Successfully',
		'status' => 'success'
	    ));
	}
    }

    public function emailSend($type) {
	if ($type == 1) {
	    $clients=  $this->getClients(request('category'));
	    foreach ($clients as $client) {
		$this->sendEmail($client->email, request('subject'), request('content'));
	    }
	     echo json_encode(array(
		'message' => 'Email Sent Successfully',
		'status' => 'success'
	    ));
	}
    }
    private function sendPushNotification($clients, $content) {
	foreach ($clients as $client) {
	    \Gcm::push_to_phoneid($this->customizeSms($content, $client), $client->gcm_id);
	}
    }

    private function getClients($category) {
	switch ($category) {
	    case 'developers':
		$clients = DB::select('select  * from client where client_id IN (select distinct client_id from developer_app)');
		break;
	    case 'android_yes':
		$clients = DB::select('select  * from client where gcm_id is not null');
		break;
	    case 'android_no':
		$clients = DB::select('select  * from client where gcm_id is null');
		break;
	    case 'no_subscriber':
		$clients = DB::select('select  * from client c LEFT JOIN  client_subscribers b ON c.client_id=b.client_id WHERE b.client_id IS NULL');
		break;
	    case 'with_email':
		$clients = DB::select("select  * from client where email is NOT null OR email !='' ");
		break;

	    case 'no_email':
		$clients = DB::select("select  * from client where email is null OR email ='' ");
		break;

	    default:
		$clients = DB::table('clients')->get();
		break;
	}
	return $clients;
    }

    private function createAdminMessage() {

	$clients = $this->getClients(request('category'));
	$content = request('content');
	$messaging_type = request('message_type');
	$messaging_type == 2 ? $this->sendPushNotification($clients, $content) : '';
	$sms_count_per_sms = ceil(strlen($content / 160));

	$message_id = DB::table('message')->insertGetId(
		[
	    'is_bulk' => $messaging_type,
	    'content' => $content,
	    'client_id' => $this->client_id,
	    'developer_id' => null,
	    'to_ids' => count($clients),
	    'messaging_type' => $messaging_type,
	    'message_count' => count($clients) * $sms_count_per_sms,
	    'category_id' => null
		], 'message_id'
	);


	foreach ($clients as $client) {

	    DB::table('pending_sms')->insert(
		    [
			'phone_number' => $client->phone_number,
			'content' => $this->customizeSms($content, $client),
			'client_id' => $this->client_id,
			'message_id' => $message_id,
			'from_smart' => $messaging_type == 1 ? 0 : 1,
			'status' => 0,
			'username' => 'karibuSMS'
		    ]
	    );
	}
	return $message_id;
    }

    private function customizeSms($content, $client) {
	$patterns = array(
	    '/#name/', '/#username/', '/#phone_number/', '/#phone_verification_code/', '/#country/', '/#email/', '/#location/', '/#imei/', '/#city/', '/#type/'
	);


	$replacements = array(
	    $client->name, $client->username, $client->phone_number, $client->phone_verification_code, $client->country, $client->email, $client->location, $client->imei, $client->city, $client->type
	);

	return preg_replace($patterns, $replacements, $content);
    }

}
