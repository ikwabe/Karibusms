<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

class api {

    public $status;
    private $message;
    private $api_secret;
    private $api_key;
    private $phone_number;
    private $business;
    private $developer;
    private $name;
    private $dgr_id;
    private $sms_remain;
    private $karibusmspro;
    private $business_sms_id;
    private $error = array(
	'error' => 1,
	'error_message' => "system error",
	"success" => 0,
    );

    public function __construct() {
	if (!empty($_POST)) {
	    foreach ($_POST as $key => $value) {
		if ($_POST[$key] == '') {
		    echo $key . " is empty";
		    exit();
		}
	    }
	    
	    $this->message = $_POST['message'];
	    $this->phone_number = $_POST['phone_number'];
	    $this->api_key = $_POST['api_key'];
	    $this->api_secret = $_POST['api_secret'];
	    $this->karibusmspro = $_POST['karibusmspro'];
	    $this->name = $_POST['name'];
	    $this->start();
	}
    }

    public function js_init($param) {
	if (!empty($param)) {
	    $this->message = $param['message'];
	    $this->phone_number = $param['phone_number'];
	    $this->api_key = $param['api_key'];
	    $this->api_secret = $param['api_secret'];
	    $this->karibusmspro = $param['karibusmspro'];
	    $this->start();
	}
    }

    private function start() {
	$this->check_errors();
	$business = $this->find_business();
	if ($business == TRUE) {
	    if ($this->karibusmspro == 1) {
		$this->karibusmspro();
	    } else {
		//$this->karibusms_payment_status();
		if ($this->business->gcm_id == '') {
		    echo json_encode(array(
			'error' => 1,
			"success" => 0,
			'error_message' => 'You do not have a latest karibuSMS app in your phone. Please download the latest version of '
			. 'karibuSMS in google play: http://goo.gl/msamgD and login first in the android app'
		    ));
		    exit();
		}
		gcm::push_to_id($this->get_message(), $this->business->gcm_id);

		echo json_encode(array(
		    'success' => '1',
		    'error' => 0
		));
	    }
	}
    }

    private function karibusmspro() {

	$payment = $this->pro_check_payment_status();
	if ($this->save_message() == TRUE && $payment == TRUE) {
	    $sms = new sms_sender();
	    $phone_numbers = explode(',', $this->phone_number);

	    $name = $this->name == '0' ? $this->developer->app_name : $this->name;

	    foreach ($phone_numbers as $number) {
		$x = validate_phone_number($number)[1];
		$sms->set_phone_number($x);
		$sms->set_from_name($name);
		$sms->sms_remain = $this->sms_remain;
		$sms->set_message($this->message);
		echo $sms->send();
	    }
//	    if ($result == 1) {
//		echo json_encode(array(
//		    'success' => '1',
//		    'error' => 0
//		));
//	    }
	}
    }

    private function check_errors() {
//	$phone_numbers=  decrypt($this->phone_number, $this->secret_key);
//	echo $phone_numbers;
	$numbers = explode(',', $this->phone_number);
	foreach ($numbers as $number) {
	   
	    $valid_number = validate_phone_number($number);
	    if (!is_array($valid_number)) {
		echo json_encode(array(
		    "error" => 1,
		    "success" => 0,
		    "error_message" => $number . ' is not a valid number'
		));
		exit;
	    }
	}
    }

    private function find_business() {
	$developer_info = developer_app::find_where(array('api_key' => $this->api_key, 'api_secret' => $this->api_secret));
	if (!empty($developer_info)) {
	    $this->developer = array_shift($developer_info);
	    $business_id = $this->developer->client_id;
	    $business_info = client::find_by_id($business_id);
	    $this->business = array_shift($business_info);
	    return TRUE;
	} else {
	    echo json_encode(array(
		"error" => 1,
		"success" => 0,
		"error_message" => "Wrong API_KEY or SECRET_KEY is supplied"
	    ));
	    exit;
	}
    }

    private function save_message() {
	global $db;

	//we need to first store these phone numbers in subscriber and subscription
	$numbers = explode(',', trim(rtrim($this->phone_numbers, ','), ','));
	foreach ($numbers as $phone_number) {
	    $this->add_new_number($phone_number);
	}
	//then we need to count these numbers and save them in message count

	$data = array(
	    'client_id' => $this->business->id,
	    'content' => $this->message,
	    'is_bulk' => $this->karibusmspro,
	    'message_count' => count($numbers),
	    'developer_app_id' => $this->developer->id
	);
	$result = $db->insert('message', $data);
	if ($result) {
	    $this->dgr_id = $db->id();
	    return true;
	} else {
	    echo json_encode($this->error);
	    return FALSE;
	}
    }

    function add_new_number($phone_number, $name = '') {
	global $db;
	$validate = validate_phone_number(str_replace(' ', '', $phone_number));
	if (is_array($validate)) {
	    //lets check if this number is in our database
	    $subscriber_info = subscriber::find_where(array("phone_number" => $validate[1]));
	    if (!empty($subscriber_info)) {
		//this number is on our database
		$subscriber = array_shift($subscriber_info);
		$id = $subscriber->id;
	    } else {
		//this is the new user
		$data = array(
		    'othernames' => $name,
		    'phone_number' => $validate[1],
		    'country' => $validate[0]
		);
		$db->insert('subscriber', $data);
		$id = $db->id();
	    }
	    $subscriber_data = array(
		'client_id' => $this->business->id,
		'subscriber_id' => $id
	    );
	    $db->insert('subscription', $subscriber_data);
	    return TRUE;
	} else {
	    return FALSE;
	}
    }

    private function get_message() {

	if ($this->save_message()) {
	    $return["posts"] = array();
	    $phone_numbers = explode(',', $this->phone_number);
	    foreach ($phone_numbers as $number) {
		$post = array();
		$post["phonenumber"] = validate_phone_number($number)[1];
		array_push($return["posts"], $post);
	    }
	    $message = array("Notice" => $this->message, "server" => $return);
	    return $message;
	}
    }

    public function pro_check_payment_status() {
	$record = sms_status::find_where(array('client_id' => $this->business->id));
	if (!empty($record)) {
	    //this user has some SMS remain
	    $business_sms = array_shift($record);
	    $this->sms_remain = $business_sms->message_left;
	    return TRUE;
	} else {
	    //check the status if business exist
	    $status = array(
		'error' => 1,
		'msg' => 'Insufficient credit, send your payments to us or contact us via info@karibusms.com',
		'success' => 0);
	    echo json_encode($status);
	    exit();
	}
    }

    public function karibusms_payment_status() {
	global $db;
	$business_info = business::find_where(array('imei' => $this->IMEI));
	$business = array_shift($business_info);

	//check start offer
	$db->query("select * from smart_start_offer where business_id = '" . $business->id . "'");
	$row = $db->fetchArray();

	if (empty($row)) {
	    //no start offer continue...
	    unset($row);
	    $db->query("select * from smart_bundles where business_id='" . $business->id . "'");
	    $row = $db->fetchArray();
	    if (empty($row)) {

		$message = "Package is over. Please add payment to access this service.";
		$status = array(
		    'error' => 1,
		    'error_message' => $message,
		    'success' => 0
		);
		$this->status = $status;
		echo json_encode($status);
		exit;
	    } else {
		// there is an active bundle, check the number of contacts depending on the bundle enrolled.
		//unset($row);  
		$this->max_contacts = $row['total_contacts'];
	    }
	} else {
	    //there is a start offer, count all number of subscribers.
	    //$subscribers = subscription::find_where(array('business_id' => $business->id));  
	    //$this->max_contacts = count($subscribers);
	    $this->max_contacts = 400; //maximum number of contacts for the start offer.   
	    $this->offer_days = $row['days_remain'];
	}
    }

}

if (isset($_GET['js'])) {
    include_once 'modules/api/process/js_api.php';
    exit();
} else {
    new api();
}

