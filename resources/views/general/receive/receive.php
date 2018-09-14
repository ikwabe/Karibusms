<?php

/**
 * @author Ephraim Swilla<swillae1@gmail.com>
 * @uses  Used to receive all sms forwarded from a server
 */
/// we include this to take all basic requirements
include_once '../../../include/bootstrap.php';

class receive {

    /**
     *
     * @var integer 
     */
    private $phone_number;

    /**
     *
     * @var String 
     */
    private $content;

    /**
     *
     * @var String, pre defined 
     */
    private $country;

    /**
     *
     * @var timestamp
     */
    private $time;

    /**
     *
     * @var object carry business information 
     */
    private $business;

    /**
     *
     * @var static variable hold defined upload keywords 
     */
    public static $UPLOAD_CONTACT_KEYWORD = array('WATEJA', 'MTEJA', 'NUMBER',
	'NAMBA', 'CUSTOMER', 'CUSTOMERS');

    /**
     *
     * @var String, present register keywords used 
     */
    public static $REGISTER_KEYWORDS = array('REGISTER', 'SAJILI', 'REGISTERS',
	'JISAJILI', 'JIUNGE', 'UNGA');

    /**
     *
     * @var String
     */
    public static $PAYMENT_KEYWORD = array('LIPA', 'MALIPO', 'MPESA', 'TIGOPESA', 'M-PESA',
	'TIGO-PESA', 'MPESA MALIPO', 'TIGOPESA MALIPO');

    /**
     *
     * @var String
     */
    public static $UNSUBSCRIBE_KEYWORD = array('ONDOA', 'JITOE', 'UNSUBSCRIBE', 'UN SUBSCRIBE',
	'JIONDOE');

    public function __construct() {
	if (!empty($_GET)) {

	    $number = htmlspecialchars($_GET['sender']);
	    $validate = validate_phone_number(rtrim(trim($number)));
	    if (!is_array($validate)) {
		error_record("Phone number is not valid " . $number, $validate);
	    } else {
		$this->phone_number = $validate[1];
		$this->country = $validate[0];
	    }
	    $this->content = rtrim(trim(preg_replace("/karibu/i", '', $_GET['msgdata'], 1)));

	    $this->time = $time = date("D, d-M-Y  H:i:s", time() + 60 * 60); //TZ time
	    $this->log_file();
	    $this->get_logic();
	}
    }

    /**
     * @uses : provide the general logic of the class here
     */
    private function get_logic() {


	//Check all the logics here
	$business_admin = $this->get_business();
	$content_array = explode(' ', $this->content);

	$this->connect();

	if (!empty($business_admin)) {

	    /**
	     *  This request comes from admin of certain business
	     * 
	     * we now process content request keyword
	     */
	    if (in_array(strtoupper($content_array[0]), self::$UPLOAD_CONTACT_KEYWORD)) {
		//upload these contacts
		$this->upload_customer_contact();
	    } elseif (in_array(strtoupper($content_array[0]), self::$PAYMENT_KEYWORD)) {
		//this user send sms to process payment after payment
		$this->make_payment(str_ireplace(self::$PAYMENT_KEYWORD, '', $this->content));
	    } else if (in_array(strtoupper($content_array[0]), self::$UNSUBSCRIBE_KEYWORD)) {

		$this->unsubscribe();
	    } else if ($this->business->phone_number == $this->phone_number) {
		//here, there is no initial keyword we get, so we send that sms to subscribers
		$this->foward_sms();
	    } else {
		//This is the new customer who want to subscribe to a given page
		$this->connect();
	    }
	} else {
	    //
	    //This request come from normal user

	    if (in_array(strtoupper($content_array[0]), self::$REGISTER_KEYWORDS)) {
		//
		//register new business here
		$this->register_business();
	    }
	}
    }

    /**
     * 
     */
    private function log_file() {
	$error_msg = '<ul>
                        <li>Message: <strong>phone number=' . $this->phone_number . ' and <br/><br/> content=' . $this->content . '</strong></li>
                        <li>Time: <strong>' . $this->time . 'tz time</strong></li> 
                     </ul>';
	$filename = RT . 'media/doc/errors/all_received_sms.html';
	write_file($filename, $error_msg);
    }

    public function connect() {
	global $db;
	if (!empty($this->content) && !empty($this->phone_number)) {

	    $page = $this->get_business();

	    if (!empty($page)) {

		//we get the page name so process 
		//we check if this user our registered user
		$user_info = subscriber::find_where("phone_number='" . $this->phone_number . "'");

		if (!empty($user_info)) {

		    //this is our registered user so we connect user with a page
		    $user = array_shift($user_info);

		    //we first check if user is connected with a page or not
		    $follower_data = array(
			"subscriber_id" => $user->id,
			"business_id" => $page->id
		    );
		    $page_follower = subscription::find_where($follower_data);

		    if (empty($page_follower)) {

			//user is not yet connected so we connect
			$this->subscribe($user->id, $page);
		    } else {
			//check if subscriber is unsubscribe and want to subscribe again

			$subscriber = array_shift($page_follower);
			if ($subscriber->accept_sms == 0) {
			    //connect him again
			    $this->subscribe($user->id, $page, TRUE);
			} else {
			    //user is already connected so let's us notify him/her back
			    $message = ' You already connected with : ' . $page->name . " page";
			    $this->send_sms($page, $message);
			}
		    }
		} else {

		    //this user is not yet registered so we register him/her and connect with a page  
		    $data = array(
			'phone_number' => $this->phone_number,
			'country' => $this->country
		    );

		    $db->insert('subscriber', $data) ? $this->subscribe($db->id(), $page) : '';
		}
	    } else {
		/* this content does not match either of our existing page so lets save
		  this user in our database */
		$data = array(
		    'phone_number' => $this->phone_number,
		    'country' => $this->country,
		);
		$result = $db->insert('subscriber', $data);
		$this->forward_to_cstts();
		error_record('Unknown subscription request received: ' . $this->content . ' from number ' . $this->phone_number . '', $result);
	    }
	}
    }

    function forward_to_cstts() {
	$context = stream_context_create(array(
	'http' => array(
	    'protocol_version' => '1.0',
	    'method' => 'GET'
	)));
	$live_url = 'http://cstts.org/receivesms.php/?user=content=' . $this->content . '&phone_number=' . $this->phone_number;
	$parse_url = file_get_contents($live_url, false, $context);
	$result = substr($parse_url, 0, 4);
	return $this->status_code($result);
    }

    public function foward_sms() {
	global $db;
	$data = array(
	    'content' => $this->content,
	    'business_id' => $this->business->id
	);
	$result = $db->insert('sms', $data);
	if ($result) {
	    $sub_data = array(
		"business_id" => $this->business->id,
		"accept_sms" => 1
	    );
	    $subscriptions = subscription::find_where($sub_data);
	    $user_id = '';
	    $sms_id = $db->id();
	    $i = 0;
	    foreach ($subscriptions as $subscription) {

		if ($i < 4) {
		    $user_info = subscriber::find_by_id($subscription->subscriber_id);
		    $user = array_shift($user_info);
		    $this->send_sms($this->business, $this->content, $user->phone_number);
		} else {
		    $db->insert('queue_sms', $data); //put in queue for cron job
		    $user_id.=$subscription->subscriber_id . ",";
		}

		$i++;


		$data = array(
		    'business_id' => $this->business->id,
		    'sms_id' => $sms_id,
		    'subscriber_id' => $subscription->subscription_id
		);
		$db->insert('qsms', $data); //put in queue for cron job
	    }
	    $user_id = rtrim($user_id, ',');

	    $db->update('sms', array('to_id' => $user_id), "id='" . $db->id() . "'");
	} else {
	    $message = 'Error occur in forward sms to clients of business id' . $this->business->id;
	    error_record($message, $result);
	}
    }

    public function get_business() {
	//we get the page name so process 
	//we check if this user our registered page admin user
	//let us remove all keywords in content
	$replacement = array_merge(self::$PAYMENT_KEYWORD, self::$REGISTER_KEYWORDS, self::$UNSUBSCRIBE_KEYWORD, self::$UPLOAD_CONTACT_KEYWORD);

	foreach ($replacement as $value) {
	    if (preg_match('/' . $value . '/i', $this->content)) {
		$content = rtrim(trim(preg_replace("/$value/i", '', $this->content, 1)));
	    }
	}
	$name = isset($content) && $content != '' ? $content : $this->content;
	$where = array("username" => $name, "name" => $name);
	$business_info = business::find_where($where, 'OR');
	if (!empty($business_info)) {
	    $business = array_shift($business_info);
	    $this->business = $business;
	    return $this->business;
	} else {
	    return array();
	}
    }

    private function send_sms($page, $message = '', $phone_number = '') {
	$sms = new sms_sender();
	if (!is_object($page)) {
	    $page = $this->get_business();
	}
	//we also notify subscriber that he/she successful connected with this page
	$message = $message == '' ? ' You are successful connected with : ' . $page->username . " page" : $message;
	// if ($page->total_sms > 0) {
	if ($page->messaging_type == 1) {
	    $phone_number = $phone_number != '' ? $phone_number : $this->phone_number;
	    $sms->set_from_name($page->username);
	    $sms->set_phone_number($phone_number);
	    $sms->set_message($message);
	    $sms->send();
	} else {
	    $return["posts"] = array();
	    $post = array();
	    $post["phonenumber"] = $phone_number;
	    array_push($return["posts"], $post);
	    $sms = array("Notice" => $this->wrap_sms($message, $page->username), "server" => $return);
	    if ($page->gcm_id != '') {
		gcm::push_to_id($message, $page->gcm_id);
	    } else {
		gcm::push_from_platform($sms);
	    }
	}


	// } else {
	// $message = 'Your message balance is 0. One member subscribe to your page ' . $page->username . ' and receive no success message';
	// }
    }

    public function wrap_sms($sms, $username) {
	$short_url = 'www.karibusms.com/' . $username;
	$message = $username . ': 
' . $sms . '
' . $short_url;
	return $message;
    }

    private function subscribe($subscriber_id, $page, $reconect = FALSE) {
	global $db;

	$data = array(
	    'subscriber_id' => $subscriber_id,
	    'business_id' => $page->id
	);
	if ($reconect == TRUE) {
	    $where = array(
		'business_id' => $page->id,
		'subscriber_id' => $subscriber_id
	    );
	    $connect = $db->update('subscription', array_merge(array('accept_sms' => 1)), $where);
	} else {
	    $connect = $db->insert('subscription', $data);
	}

	if ($connect) {
	    $message = " New customer subscribe to your page at " . $this->time;
	    $notification = array(
		'business_id' => $page->id,
		'content' => $message
	    );
	    $db->insert('nfcn', $notification);
	    $message = ' You successful connected with : ' . $page->name . " page";
	    $this->send_sms($page, $message);
	} else {
	    error_record("Error occurs in data insertion for subscription  of user id" . $ $subscriber_id . ' in page' . $page->id, $connect, TRUE);
	}
    }

    public function unsubscribe() {
	global $db;

	$page = $this->get_business();
	$subscriber_info = subscriber::find_where("phone_number='" . $this->phone_number . "'");
	$subscriber = array_shift($subscriber_info);
	$data = array(
	    'accept_sms' => 0
	);
	$where = array(
	    'subscriber_id' => $subscriber->id,
	    'business_id' => $page->id
	);
	$double_check_subscription = subscription::find_where(array_merge($where, $data));
	if (empty($double_check_subscription)) {
	    $db->update('subscription', $data, $where);
	    if ($db->affected() > 0) {
		$message = " One customer unsubscribe to your page at " . $this->time;
		$notification = array(
		    'business_id' => $page->id,
		    'content' => $message
		);
		$db->insert('nfcn', $notification);
		$message = ' You are successful unsubscribe to : ' . $page->name . " page";
		$this->send_sms($page, $message);
	    } else {
		error_record("Error occurs in table update for unsubscription  of subscriber id" . $subscriber->id . ' in page' . $page->id, '', TRUE);
	    }
	}
    }

    public function register_business() {
	global $db;
	$business_name = str_ireplace(self::$REGISTER_KEYWORDS, '', $this->content);
	$codes = rand(1, 999999);
	$password = sha1(md5(sha1($codes)));
	$data = array(
	    'name' => $business_name,
	    'username' => preg_replace('/ /', '', substr($business_name, 0, 10)),
	    'phone_number' => $this->phone_number,
	    'phone_number_valid' => 1,
	    'password' => $password,
	    'country' => $this->country
	);
	$db->insert('business', $data);
	$message = "An account with name" . $business_name . ' is successful creared';
	$this->send_sms($this->business, $message);
    }

    public function upload_customer_contact() {
	global $db;
	$contact_array = explode(',', preg_replace('/[^,0-9]/', '', $this->content));
	if (!empty($contact_array)) {
	    foreach ($contact_array as $contact) {
		$valid_number = validate_phone_number($contact);
		if (is_array($valid_number)) {
		    $data = array(
			'phone_number' => $valid_number[1],
			'country' => $valid_number[0]
		    );

		    $subscriber_info = subscriber::find_where("phone_number='" . $valid_number[1] . "'");
		    if (!empty($subscriber_info)) {
			$subscriber = array_shift($subscriber_info);
			$id = $subscriber_id->id;
		    } else {
			$db->insert('user', $data);
			$id = $db->id();
		    }
		    $subscriber_data = array(
			'business_id' => $this->business->id,
			'subscriber_id' => $id
		    );
		    $sub = subscription::find_where($subscriber_data);
		    if (empty($sub)) {
			$db->insert('subscription', $subscriber_data);
		    }
		} else {
		    error_record("number is not valid" . $this->content, $valid_number);
		}
	    }
	}
    }

    /**
     * @author Ephraim Swilla<swillae1@gmail.com>
     * @uses Used to process and detect payments received
     */
    private function make_payment($verification_code) {

	$pmt = new pmt();
	$pmt->business_id = $this->business->id;
	$check = $pmt->check_receipt($verification_code);
	if ($check) {
	    $pmt->make();

	    $message = "Your payment is successful received. Your monthly payment has been upgraded"
		    . 'Amount received is Tsh ' . $pmt->pmt_info->amount;
	} else {
	    $message = "Wrong reference number, wait for at least 10 minutes and try again";
	    error_record("Error occur in processing payment from business id " . $this->business->id, $check, $json = FALSE);
	}
	$this->send_sms('KaribuSMS', $message, $this->business->phone_number);
    }

}

new receive();
?>
