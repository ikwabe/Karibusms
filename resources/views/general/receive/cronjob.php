<?php

ini_set('max_execution_time', 300); //300 seconds = 5 minutes
/**
 * @author Ephraim Swilla<swillae1@gmail.com>
 * @uses  Used to receive all sms forwarded from a server
 */
/// we include this to take all basic requirements
include_once '../../../include/bootstrap.php';
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

class cronjob {

    private $que;
    public $business_id;
    private $total_businesses;

    public function __construct() {
	$this->init();
	// $this->init_business_status();
    }

    private function check_queu() {
	$this->que = pending_sms::find_by_sql("SELECT * FROM pending_sms LIMIT 10");
	return $this->que;
    }

    private function init() {
	$que = $this->check_queu();
	if (!empty($que)) {
	    foreach ($this->que as $qsms) {
		$user = $this->get_business_info($qsms->message_id);
		if ($qsms->from_smart == 1) {
		    //send SMS from smart phone
		   
		    $this->send_smart_sms($qsms, $user);
		    $this->delete_que($qsms->id);
		} else {
		    //send BULK SMS
		    $this->send_sms($qsms->content, $qsms->phone_number, $user->name,$qsms->client_id);
		    $this->delete_que($qsms->id);
		}
	    }
	}
    }

    function get_business_info($id) {
	global $db;
	$users_info = $db->fetch_object("SELECT a.gcm_id, a.name FROM client a JOIN message b ON b.client_id=a.client_id WHERE b.message_id='" . $id . "'");
	$user = array_shift($users_info);
	return $user;
    }

    public function send_smart_sms($que, $user) {
	
	$return["posts"] = array();
	$return["success"] = 1;
	$return['message'] = 'Message sent successfully';
	$return["messagetosend"] = $que->content;
	$post = array();

	$post["phonenumber"] = '' . $que->phone_number;
	$post["name"] = '' . $user->name;
	array_push($return["posts"], $post);

 
	$message = array("Notice" => $this->format_smart_sms($user,$que->content), "server" => $return);
	 $push = gcm::push_to_id($message, $user->gcm_id);
	return $push;
    }

    public function format_smart_sms($user,$message_content) {
	$short_url = 'www.karibusms.com/' . $user->name;
	$message = $user->name . ': 
' . $message_content . '
' . $short_url;
	return $message;
    }

    private function notify_business() {
	$business_info = client::find_by_id($this->business_id);
	$business = array_shift($business_info);
	$message = "Hello " . $business->name . ". Your excel file contacts have been successful extracted and inserted in your account. You can now start to send SMS to your contacts list";
	$sms = $this->format_sms($business, $message);
	gcm::push_from_platform($sms);
    }

    private function format_sms($business, $message) {
	$return["posts"] = array();
	$post = array();
	$post["phonenumber"] = $business->phone_number;
	array_push($return["posts"], $post);
	$sms = array("Notice" => $this->wrap_sms($message, $business->username), "server" => $return);
	return $sms;
    }

    public function delete_que($qsms_id) {
	global $db;
	$where = 'id=' . $qsms_id;
	$db->delete('pending_sms', $where);
    }

    private function process_file($qsms) {

	require_once RT . 'modules/general/process/excel_reader.php';
	$excel = new excel_reader();
	$excel->business_id = $qsms->business_id;
	$excel->set_file(RT . $qsms->isfile_to_process);
	$excel->extract();
    }

    /**
     * 
     * In this part, we send SMS to subscribers
     * this part will be changed later for sending many SMS to 
     * users using ftp connection
     */
    private function process_pro_sms($sms_id, $subscriber_id) {

	$user_info = subscriber::find_by_id($subscriber_id);
	$user = array_shift($user_info);

	$sms_info = sms::find_by_id($sms_id);
	$sms = array_shift($sms_info);

	$buseness_info = business::find_by_id($sms->business_id);
	$buseness = array_shift($buseness_info);

	$send = $this->send_sms($sms->content, $user->phone_number, $buseness->username);
	if ($send == FALSE) {
	    error_record('Error occur in sending sms to user ' . $user->id . ' from page SMS id  ' . $sms->sms_id, $send, TRUE);
	}
    }

    private function send_sms($message, $phone_number, $from_name,$id='') {
	$sms = new sms_sender();
	$sms->set_client_id($id);
	$sms->set_from_name($from_name);
	$sms->set_message($message);
	$sms->set_phone_number($phone_number);
	$send = $sms->send();
	return $send;
    }

    /**
     * @author Ephraim Swilla<swillae1@gmail.com>
     * @uses Used to process and detect payments received
     */
    private function make_payment($rps) {
	global $db;
	$data = array(
	    "verification_code" => $rps->confirmation_code,
	    "processed" => 0
	);
	$payment_info = payment::find_where($data);
	if (!empty($payment_info)) {
	    //we know the payment is not yet to be done
	    $payment = array_shift($payment_info);

	    //we know that payment is successful
	    $data = array(
		'rps_id' => $rps->id,
		'processed' => 1
	    );
	    $where = array(
		'business_id' => $payment->business_id,
	    );
	    $result = $db->update('payment', $data, $where);

	    if ($result == true) {
		$business_info = business::find_by_id($payment->business_id);
		$business = array_shift($business_info);
		$message = 'Payment is done successful. Amount received was Tsh' . $payment->amount;
		$this->send_sms('karibuSMS', $message, $business->phone_number);
	    } else {
		error_record("Error occur in processing payment from id payment id" . $payment->id, $result, $json = FALSE);
	    }
	}
    }

    /**
     * @author Ephraim Swilla<swillae1@gmail.com>
     * @uses Used to process and detect payments received
     */
    public function process_payment() {
	//save the content first in database
	$received_payments = rps::find_where(array('ready' => 0));
	if (!empty($received_payments)) {
	    foreach ($received_payments as $rps) {
		$this->make_payment($rps);
	    }
	}
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

    private function init_business_status() {

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
		gcm::push_to_id($sms, $gcm_id);

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
		gcm::push_to_id($sms, $gcm_id);

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

}

new cronjob();

?>