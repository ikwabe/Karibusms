<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;

class CronJobController extends Controller {

    /**
     * This file will be used just temporally, we will create a best
     * option in background process by laravel
     */
    /*
     * 
     * Queu process required to be processed
     * 
     * 1. someone upload an excel file and contacts need to be processed
     * 
     * 2. when business is using karibuSMS pro
     * 
     * 3. creating a database backup files
     * 
     * 4. perform database optimization
     */

    private $que;
    public $business_id;
    private $total_businesses;

    private function checkQueu() {
	$this->que = DB::select("SELECT a.content, a.phone_number,a.from_smart, a.pending_sms_id, a.username,b.gcm_id FROM pending_sms a JOIN client b ON a.client_id=b.client_id WHERE a.status='0' ORDER BY a.reg_time DESC LIMIT 2");
	return $this->que;
    }

    public function index() {
	$que = $this->checkQueu();
	if (!empty($que)) {

	    foreach ($this->que as $qsms) {

		if ($qsms->from_smart == 1) {
		    //send SMS from smart phone

		    $this->sendPhoneSMS($qsms);
		} else {
		    //send BULK SMS
		    $this->sendInternetSMS($qsms);
		}
	    }
	}
	//$this->sendReports();
    }

    public function sendPhoneSMS($message) {
	$status = \Gcm::send($message->content, $message->phone_number, $message->username, $message->gcm_id);
	DB::table('pending_sms')
		->where('pending_sms_id', $message->pending_sms_id)
		->update(['status' => $status->success]);
	return $status;
    }

    private function format_sms($business, $message) {
	$return["posts"] = array();
	$post = array();
	$post["phonenumber"] = $business->phone_number;
	array_push($return["posts"], $post);
	$sms = array("Notice" => $this->wrap_sms($message, $business->username), "server" => $return);
	return $sms;
    }

    private function process_file($qsms) {

	require_once RT . 'modules/general/process/excel_reader.php';
	$excel = new excel_reader();
	$excel->business_id = $qsms->business_id;
	$excel->set_file(RT . $qsms->isfile_to_process);
	$excel->extract();
    }

    private function sendInternetSMS($message) {
	$sender = new \SmsSender();
	$number = validate_phone_number($message->phone_number);
	$sender->set_phone_number($number[1]);
	$sender->set_message($message->content);
	$sender->set_from_name($message->username);
	$send = $sender->send();
	$status = json_decode($send);
	
	$return_sms = $status->code . ' | ' . $status->message;
	
	return DB::table('pending_sms')
			->where('pending_sms_id', $message->pending_sms_id)
			->update(['status' => $status->success, 'return_message' => $return_sms]);
    }

    private function is_midday() {
	return (date('H') >= 7 && date('H') <= 16) ? TRUE : FALSE;
    }

    private function is_evening() {
	return (date('H') >= 13 && date('H') <= 16) ? TRUE : FALSE;
    }

    private function is_morning() {
	return (date('H') >= 7 && date('H') <= 13) ? TRUE : FALSE;
    }

    private function is_night() {
	return (date('H') >= 18 && date('H') <= 24) ? TRUE : FALSE;
    }

    private function sendReports() {

	if ($this->is_night()) {
	    //testing to send SMS to my phone

	    return mail('swillae1@gmail.com', "Testing cron status message", 'Hello, This is the cron status message');
	}
	return false;
	if ($this->is_evening()) {
	    $business = business::find_all();
	    foreach ($business as $busines) {

		$this->page_summary($busines);
	    }
	}
	if ($this->is_midday()) {
	    $this->total_businesses = business::find_all();
	    foreach ($this->total_businesses as $busines) {

		$this->system_updates($busines);
	    }
	}
	if ($this->is_morning() && (date('l') == 'Monday' || date('l') == 'Wednesday')) {
	    $business = business::find_all();
	    foreach ($business as $busines) {

		$this->bundle_status($busines);
	    }
	}
    }

    public function wrap_sms($sms, $username) {
	$short_url = 'www.karibusms.com/' . $username;
	$message = $username . ': 
' . $sms . '
' . $short_url;
	return $message;
    }

    private function page_summary($business) {
	$sql = "SELECT * FROM karibu_pv WHERE pv_business_page='" . $business->username . "' AND pv_time LIKE '%" . date('Y-m-d') . "%'";
	$viewers = pv::find_by_sql($sql);
	if (!empty($viewers)) {


	    $view_profile = count($viewers) == 1 ? count($viewers) . ' person ' : count($viewers) . ' people';
	    $message = "Hello " . $business->name . ', ' . $view_profile . ' view your profile page today. Continue to update your profile for people to know more about you.';

	    $ntfn = nfcn::find_where(array('type' => 'PAGE_SUMMARY',
			'business_id' => $business->id, 'content_lenght' => strlen($message)));

	    if (empty($ntfn)) {
		$sms = $this->format_sms($business, $message);

		//some business don't have GCM id so we use our company ID
		$gcm_id = $business->gcm_id != '' ? $business->gcm_id : gcm::INETS_ID;
		\Gcm::push_to_id($sms, $gcm_id);

		global $db;
		$data = array(
		    'type' => 'PAGE_SUMMARY',
		    'business_id' => $business->id,
		    'sms_sent' => 1,
		    'content' => $message,
		    'content_lenght' => strlen($message));
		$db->insert('nfcn', $data);
	    }
	}
    }

    private function system_updates($business) {
	// new version has been released
	//some changes have been made
	//blog post
	$data = array(
	    'sent_complete' => 0);
	$su_info = su::find_where($data);
	if (!empty($su_info)) {
	    $su = array_shift($su_info);
	    $sent_to = explode(',', $su->sent_to);
	    if (!in_array($business->id, $sent_to)) {
		$sms = $this->format_sms($business, $su->message);
		//some business don't have GCM id so we use our company ID
		$gcm_id = $business->gcm_id != '' ? $business->gcm_id : gcm::INETS_ID;
		\Gcm::push_to_id($sms, $gcm_id);

		//update database
		global $db;
		$new_sent_to = array_merge($sent_to, array($business->id));
		$complete = count($new_sent_to) == count($this->total_businesses) ? 1 : 0;
		$set = array('sent_to' => implode(',', $new_sent_to), 'sent_complete' => $complete);
		$db->update('su', $set, array('id' => $su->id));
	    }
	}
    }

    private function bundle_status($business) {
	// days remain for try/offer period
	// 7 days remain for bundle to expire
	// you are using a free version
	$type = date('M') . 'STATUS';
	$check_sent_status = su::find_where(array('sent_to' => $business->id, 'type' => $type));
	if (empty($check_sent_status)) {
	    if ($business->messaging_type == 1) {
		$table = 'pro_bundles';
	    } else {
		$table = 'smart_bundles';
	    }
	    global $db;
	    $db->query("select * from " . $table . " where business_id='" . $business->id . "'");
	    $row = $db->fetchArray();
	    if (empty($row)) {
		$message = "Hello " . $business->name . ", Your are using FREE version of karibuSMS. You can send up to 50sms per day only and get only limited features. Upgrade now in karibusms.com to start interact with your people.";
		$sms = $this->format_sms($business, $message);
		$gcm_id = $business->gcm_id != '' ? $business->gcm_id : gcm::INETS_ID;
		gcm::push_to_id($sms, $gcm_id);
	    } else {
		// there is an active bundle, check the number of contacts depending on the bundle enrolled.
		if ($row['days_remain'] < 7) {
		    $message = "Hello " . $business->name . ", " . $row['days_remain'] . " days remain for your karibuSMS bundle to expire. You can upgrade now in karibusms.com and continue to interact more with your people with karibuSMS. ";

		    $sms = $this->format_sms($business, $message);
		    $gcm_id = $business->gcm_id != '' ? $business->gcm_id : gcm::INETS_ID;
		    gcm::push_to_id($sms, $gcm_id);
		}
	    }

	    $data = array('sent_to' => $business->id, 'message' => $message, 'type' => $type);
	    $db->insert('su', $data);
	}
    }

    public function mail() {
	$user = Controller::user_info();
	$total_people = Controller::count_all_people();

	$pending = DB::table('pending_sms')
			->where('client_id', $this->client_id)
			->where('status', 0)->get();
	$internet_sms = DB::select("select count(message_id) as internet_sms FROM pending_sms WHERE client_id='{$this->client_id}' AND from_smart='0'");
	$phone_sms = DB::select("select count(message_id) as phone_sms FROM pending_sms WHERE client_id='{$this->client_id}' AND from_smart='1'");
	$pending_sms = count($pending);
	$sms_sent = DB::table('pending_sms')->where('client_id', $this->client_id)->count();
	return view('auth.cron.mail')->with(array
		    ('user' => $user, 'total_people' => $total_people, 'pending_sms' => $pending_sms, 'sms_sent' => $sms_sent, 'internet_sms' => $internet_sms, 'phone_sms' => $phone_sms));
	;
    }

}
