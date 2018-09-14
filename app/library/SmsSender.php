<?php

/**
  Document   : send_sms
  Created on : 02-03-2014, 22:38:29
  @author     : Ephraim Swilla <swillae1@gmail.com>
 * 
  Description:
  Purpose of the file is to send sms to user mobile phone
 */
//------------------------------------------------------------------------------
/**
  Document   : send_email_processor
  Created on : 26-Jul-2012, 22:38:29
  @author     : Ephraim Swilla <swillae1@gmail.com>
  Description:
  Purpose of the file is to send sms to user mobile phone
 * 
 * Revised: 15-May-2016
 */

/**
 * Add laravel parameters
 */
//use App\Jobs\Job;
//use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Contracts\Queue\ShouldQueue;

class SmsSender {
    /*
      |--------------------------------------------------------------------------
      | Class to send SMS in very simple and effective way
      |--------------------------------------------------------------------------
      |
      | This class use both que option and cron job process to facilitate
      | sending of internet message with connection to more than one vendor
      | which include RouteSMS as our core supplier
      |
      |Please do not touch anything here, for any change please contact us via our emails
     */

    public $phone_number;
    public $message;
    private $name;
    public $sms_remain;
    private $HEADER = array(
	'application/x-www-form-urlencoded'
    );
    private $options = array(
	'http' => array(
	    'protocol_version' => '1.0',
	    'method' => 'GET'
	)
    );

    /**
     * 
     * @param string/integer $phone_number of user
     */
    public function set_phone_number($phone_number) {
	$this->phone_number = $phone_number;
    }

    /**
     * 
     * @param string $message Message to be sent to user phone
     */
    public function set_message($message) {
	$this->message = $message;
    }

    public function set_from_name($name = NULL) {
	global $ses_user;
	if (!empty($ses_user) && $name == NULL) {
	    $this->name = $ses_user->name;
	} else {
	    $this->name = $name;
	}
    }

    function set_client_id($id) {
	if (!empty($id)) {
	    //get user sms remain
	    $sms_status = DB::table('sms_status')->where('client_id', $id)->first();
	    if (!empty($sms_status)) {
		$this->sms_remain = $sms_status->message_left;
	    }
	}
    }

    function route_sms() {
	$context = stream_context_create($this->options);
	$live_url = 'http://121.241.242.114:8080/bulksms/bulksms?username=isne-inets&password=inets123&type=0&dlr=1&destination=' . $this->phone_number . '&source=' . urlencode($this->name) . '&message=' . urlencode($this->message);
	$parse_url = file_get_contents($live_url, false, $context);
	$result = substr($parse_url, 0, 4);
	return $this->status_code($result);
    }

    function nexmo() {
	$url = 'https://rest.nexmo.com/sms/json?' . http_build_query(
			[
			    'api_key' => '1cd0747a',
			    'api_secret' => '1207c65ea4adcf18',
			    'to' => $this->phone_number,
			    'from' => $this->name,
			    'text' => $this->message
			]
	);
	$obj = [];
	$ch = curl_init();
	// Set the url, number of POST vars, POST data

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'application/x-www-form-urlencoded'
	));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj));

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($result);
	$return = json_encode(array(
	    'code' => $data->messages[0]->status == 0 ? '1701' : '',
	    'message' => $data->messages[0]->network,
	    'status' => $data->messages[0]->status == 0 ? '1' : $data->messages[0]->status,
	    'success' => $data->messages[0]->status == 0 ? '1' : $data->messages[0]->status
	));
	return $return;
    }

    function jumbo_sms() {
	$context = stream_context_create($this->options);
	$live_url = "http://platform.jumbosms.biz:8080/bulksms/bulksms?username=tml-inets&password=12345&type=5&dlr=0&destination=" . $this->phone_number . "&source=" . urlencode($this->name) . "&message=" . urlencode($this->message) . "";
	$parse_url = file_get_contents($live_url, false, $context);
	$result = substr($parse_url, 0, 4);

	return $this->status_code($result);
    }

    function infobip_sms() {
	$messageId = rand(10, 1000000);
	$username = 'Inets1';
	$password = 'SMSinets2017$';
	$postUrl = "https://api.infobip.com/sms/1/text/advanced";

	// creating an object for sending SMS
	$destination = array("messageId" => $messageId,
	    "to" => $this->phone_number);

	$message = array("from" => urlencode($this->name),
	    "destinations" => array($destination),
	    "text" =>$this->message,
	    "notifyUrl" => 'www.karibusms.com',
	    "notifyContentType" => "application/json",
	    "callbackData" => 'www.karibusms.com'
	);
	$postData = array("messages" => array($message));
	$postDataJson = json_encode($postData);

	$ch = curl_init();
	$header = array("Content-Type:application/json", "Accept:application/json");

	curl_setopt($ch, CURLOPT_URL, $postUrl);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	// response of the POST request
	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$responseBody = json_decode($response);
	curl_close($ch);
	if ($httpCode >= 200 && $httpCode < 300) {
	    $return= $this->status_code('1701');
	}  else {
	    $return= $this->status_code();
	}
	$FILE='data.txt';
	$handle=  fopen($FILE, 'wr+');
	fwrite($handle, json_encode($responseBody));
	return $return;
    }

    function kenya_sms() {
	$context = stream_context_create($this->options);
	$live_url = 'http://197.248.2.3/karibu/?user=karibu&pass=kar!bup@ss&messageID=12345&ServiceID=%206015002000065912&MESSAGE=' . urlencode($this->message) . '&MSISDN=' . urlencode($this->phone_number);
	$parse_url = file_get_contents($live_url, false, $context);
	$result = substr($parse_url, 0, 4);
	return $this->status_code($result);
    }

    /**
     * 
     * @return boolean true if sms sent
     * @throws Exception if not phone number and message are set
     */
    public function send() {

	if (empty($this->message) && empty($this->phone_number)) {
	    die(json_encode(array(
		'success' => 0,
		'message' => 'You can not send sms without first set message and phone number'
	    )));
	} else {
	    /**
	     * try to send SMS to a user and check different parameters
	     */
	    //our default SMS sender is routeSMS
	    return $this->infobip_sms();
	}
    }

    private function try_to_send() {
	$return = $this->route_sms();
	$data = json_decode($return);
	if ($data->code == 1025) {
	    // We will facilitate other method here to send SMS
	    mail('info@inetstz.com', 'SMS STATUS WARNING', 'PLEASE add SMS in routeSMS immediately to enable operation of karibuSMS');
	    $status = array(
		'success' => 0,
		'message' => 'Message placed into the que'
	    );
	    $return = json_encode($status);
	} else {
	    return $return;
	}
    }

    private function status_code($result) {
	switch ($result) {
	    case '1701':
		$status = array(
		    'success' => 1,
		    'message' => 'Message sent successful'
		);
		break;
	    case '1702':
		$status = array(
		    'success' => 0,
		    'message' => 'Invalid URL Error,one of the parameters was not provided or left blank'
		);
		break;
	    case '1703':
		$status = array(
		    'success' => 0,
		    'message' => 'Invalid value'
		);
		break;
	    case '1704':
		$status = array(
		    'success' => 0,
		    'message' => 'Invalid value type'
		);
		break;
	    case '1705':
		$status = array(
		    'success' => 0,
		    'message' => 'Invalid message'
		);
		break;
	    case '1706':
		$status = array(
		    'success' => 0,
		    'message' => 'Invalid destination'
		);
		break;
	    case '1707':
		$status = array(
		    'success' => 0,
		    'message' => 'Invalid Source (Sender)'
		);
		break;
	    case '1709':
		$status = array(
		    'success' => 0,
		    'message' => 'User validation failed'
		);
		break;
	    case '1710':
		$status = array(
		    'success' => 0,
		    'message' => 'Internal error'
		);
		break;
	    case '1025':
		$status = array(
		    'success' => 0,
		    'message' => 'Insufficient credit, contact sales@karibusms.com to recharge your account'
		);
		break;
	    default :
		$status = array(
		    'success' => 0,
		    'message' => 'No format results specified'
		);
		break;
	}
	$code = array('code' => $result);
	$results = array_merge($status, $code);

	return json_encode($results);
    }

}

?>