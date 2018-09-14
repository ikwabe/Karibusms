<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LoginController;

class AndroidController extends Controller {

    public function __construct() {
	parent::__construct();
	header("Content-Type: application/json", true);
    }

    public function index() {
	$tag = request('tag');
	return $this->$tag();
    }
    public function getSMS() {
	return response()->json(
			
			   DB::select("SELECT * FROM message WHERE client_id='" . request('business_id') . "'")
	);
  
    }
    public function faq() {
	$landing = new LandingController();
	return $landing->faq();
    }

    public function feedback() {
	$message = request('message');
	$contact = request('phone_number');
	$this->sendEmail('info@inetstz.com', 'Feedback message from karibuSMS Customers. Customer contact ' . $contact, $message);
	return json_encode(array(
	    'status' => 'success',
	    'message' => 'message sent successfully'
	));
    }

    public function getGroup() {
	return response()->json(
			[
			    'status' => 'group',
			    'groups' => DB::select("SELECT name as group FROM category WHERE client_id='" . request('business_id') . "'")
	]);
    }

    public function contact() {
	$sub = validate_phone_number(request('sub_phone'));
	$notification = DB::table('notification')->insertGetId([
	    'from_phone_number' => $sub[1],
	    'content' => request('message'),
	    'client_id' => request('business_id')
		], 'notification_id');
	//$this->sendSms($phone_number, $message);
	if ($notification > 0) {
	    return json_encode(array(
		'status' => 'success',
		'message' => 'Message received successfully'
	    ));
	}
    }

    public function subscribe() {
	$phone = $this->validatePhone(request('sub_phone'));
	$info = DB::select("select * from subscriber_info where client_id='" . $this->client_id . "' and phone_number='" . $phone . "'");
	if (empty($info)) {
	    $people = new PeopleController();
	    $request = array(
		'phone_number' => $phone,
		'added_by' => 'android_subscription',
		'imei' => request('phone_imei'),
		'category' => 'subscribers'
	    );
	    $people->addSubscriberInfo($request);
	    $return = json_encode(array(
		'status' => 'success',
		'message' => 'subscribed successfully'
	    ));
	} else {
	    $return = json_encode(array(
		'status' => 'success',
		'message' => 'contact already exist'
	    ));
	}
	return $return;
    }

    private function validatePhone($phone) {
	$number = validate_phone_number($phone);
	$phone_number = (is_array($number)) ? $number[1] : die(json_encode(['status' => 'warning', 'message' => 'Phone number is not valid']));
	return $phone_number;
    }

    public function profile() {
	$page = request('page') ? request('page') : 1;
	$firstpage = 10 * ($page - 1);
	$lastpage = 10 * $page;
	return response()->json(['business' => DB::select("select a.client_id as business_id, case when b.total is null then 0 end as subscribers,a.about as description, case when a.profile_pic is null then 'null' else   'http://karibusms.com/media/images/business/' || a.client_id || '/' || a.profile_pic end as url, a.name as business_name, a.location, a.phone_number FROM client a left JOIN client_subscribers b ON a.client_id=b.client_id  WHERE a.client_id > {$firstpage} and a.client_id <= {$lastpage} ")]);
    }

    public function searchProfile() {
	$name = strtolower(preg_replace('/[^ A-Za-z0-9_\-]/', '', request('name')));

	return response()->json(['business' => DB::select("select a.client_id as business_id, case when b.total is null then 0 end as subscribers,a.about as description, case when a.profile_pic is null then 'null' else   'http://karibusms.com/media/images/business/' || a.client_id || '/' || a.profile_pic end as url, a.name as business_name, a.location, a.phone_number FROM client a left JOIN client_subscribers b ON a.client_id=b.client_id  WHERE lower(a.name) like '%{$name}%' ")]);
    }

    public function statistics() {
	$user = \App\Http\Controllers\Controller::user_info($this->client_id);
	$total_people = \App\Http\Controllers\Controller::count_all_people();
	$pending = DB::table('pending_sms')
			->where('client_id', $this->client_id)
			->where('status', 0)->get();
	$sms_sent = DB::table('pending_sms')->where('client_id', $this->client_id)->count();
	echo json_encode([
	    'subscribers' => $total_people,
	    'sentsms' => $sms_sent,
	    'remainingsms' => $user->message_left,
	    'pendingsms' => count($pending)
	]);
    }

    public function sendMessage() {
	$message = new MessageController();
	$message->sendSmsByCategory();
    }

    public function sync() {
	$contacts = json_decode(request('contacts'));
	$people = new PeopleController();
	if (!empty($contacts)) {
	    foreach ($contacts as $contact) {
		$request = array(
		    'firstname' => $contact->name,
		    'phone_number' => $contact->phone_number,
		    'added_by' => 'android_upload',
		    'category' => request('category_name')=='all' ? '' : request('category_name')
		);
		echo $people->addSubscriberInfo($request);
	    }
	} else {
	    echo json_encode(['status' => 'success', 'message' => 'Invalid contact format uploaded']);
	}
    }

    public function storeContacts() {
	$people = new PeopleController();
	$numbers = $this->filterPhoneNumbers(request('phone_number'));
	foreach ($numbers as $number) {
	    $request = array(
		'phone_number' => $number[1],
		'category' => ''
	    );
	    echo $people->addSubscriberInfo($request);
	}
    }

    private function filterPhoneNumbers($phone_numbers) {
	$numbers = explode(',', trim(rtrim($phone_numbers, ','), ','));
	$valid_numbers = array();
	foreach ($numbers as $number) {

	    $valid = validate_phone_number($number);
	    if (is_array($valid)) {
		array_push($valid_numbers, $valid);
	    } else {
		die(json_encode(['status' => 'warning', 'message' => 'Phone number ' . $number . ' is not valid']));
	    }
	}
	return $valid_numbers;
    }

    public function login() {
	$this->log();
	$phone = validate_phone_number(request('phone_number'));
	$password = sha1(md5(sha1(request('password'))));
	$results = DB::table('client')->where(array('phone_number' => $phone[1], 'password' => $password))->first();
	if (!empty($results)) {
	    //this user is successful login
	    DB::table('client')->where('client_id', $results->client_id)->update(['gcm_id' => request('gcm_id')]);
	    //user images
	    $filename = 'media/images/business/' . $results->client_id . '/' . $results->profile_pic;
	    $default = 'media/images/business/0/default.png';

	    $login = new LoginController();
	    $device = request('manufacturer') . ' ' . request('model');
	    $login->storeLoginInformation($results->client_id, $device);

	    echo json_encode(
		    [
			'status' => 'success',
			'business_name' => $results->name,
			'phone_number' => $results->phone_number,
			'business_id' => $results->client_id,
			'username' => $results->username,
			'profile_link' => 'http://karibusms.com/' . is_file($filename) ? $filename : $default
		    ]
	    );
	} else {
	    //user is not available
	    echo json_encode(['status' => 'warning', 'message' => 'wrong phone number or password']);
	}
    }

    public function register() {
	$signup = new SignupController();
	$codes = rand(1, 999999);
	$data = array(
	    'name' => request('business_name'),
	    'phone_number' => request('phone_number'),
		//  'email' => request('email')
	);
	$signup->validateSignupData($data);
	$phone = validate_phone_number(request('phone_number'));

	$client_id = DB::table('client')->insertGetId(
		[
	    'name' => request('business_name'),
	    'username' => str_limit(str_replace(' ', '_', request('business_name')), 10),
	    'phone_number' => $phone[1],
	    /// 'email' => request('email'),
	    'password' => sha1(md5(sha1(request('password')))),
	    'gcm_id' => request('gcm_id'),
	    'imei' => request('imei'),
	    'register_by' => 'Android',
	    'phone_verification_code' => $codes,
	    'type' => request('business_type')
		], 'client_id'
	);
	echo $client_id > 1 ?
		json_encode([
		    'business_id' => $client_id,
		    'status' => 'success',
		    'phone_number' => $phone[1],
		    'business_name' => request('business_name')
		]) :
		json_encode([
		    'message' => 'Error occurs, please try later',
		    'status' => 'warning',
	]);
    }

}
