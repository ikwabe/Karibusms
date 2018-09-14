<?php

class js_api {

    private $message;
    private $api_secret;
    private $api_key;
    private $phone_number;
    private $business;
    private $developer;
    private $dgr_id;
    public $result;
    private $karibusmspro;

    public function js_init($param) {
        //initialize our variables here to be used
        foreach ($param as $key => $value) {
            if ($value == '') {
                $status = array(
                'success' => '0',
                'error_message' => $key . ' is empty',
                'error' => 1
                );
                return $this->result = $status;
            } else {
                $this->$key = $value;
            }
        }

//find on the database if this user exist
        $developer_info = developer::find_where(array('api_key' => $this->api_key, 'api_secret' => $this->api_secret));
        if (!empty($developer_info)) {
            $this->developer = array_shift($developer_info);
            $business_id = $this->developer->business_id;
            $business_info = business::find_by_id($business_id);
            $this->business = array_shift($business_info);

            //store values in database first
            global $db;
            $data = array(
            'number' => $this->phone_number,
            'message' => $this->message,
            'developer_id' => $this->developer->id
            );

            $db->insert('dgr', $data);
            $this->dgr_id = $db->id();
            $api = new api();
            //check messaging type if it is karibusmspro
            if ($this->karibusmspro == 1) {

                $api->pro_check_payment_status();
                $sms = new sms_sender();
                $phone_numbers = explode(',', $this->phone_number);
                foreach ($phone_numbers as $number) {
                    $x = validate_phone_number($number)[1];
                    $sms->set_phone_number($x);
                    $sms->set_from_name($this->developer->app_name);
                    $sms->set_message($this->message);
                    $result = $sms->send();
                }
                if ($result == 1) {
                    $status = array(
                    'success' => '1',
                    'error_message' => '',
                    'error' => 0
                    );
                    return $this->result = $status;
                }
            }
            $api->karibusms_payment_status();
            //messsaging is karibusms so, send sms now to gcm id
            $return["posts"] = array();
            $phone_numbers = explode(',', $this->phone_number);
            foreach ($phone_numbers as $number) {
                $post = array();
                $post["phonenumber"] = validate_phone_number($number)[1];
                array_push($return["posts"], $post);
            }
            $message = array("Notice" => $this->message, "server" => $return);

            //detect the gcm id if exists
            if ($this->business->gcm_id == '') {
                $error = array(
                'error' => 1,
                'error_message' => 'Old version: Please download the latest version of '
                . 'karibuSMS in google play: http://goo.gl/msamgD and login first'
                );
                return $this->result = $error;
            } else {
                //push the message to the gcm number
                gcm::push_to_id($message, $this->business->gcm_id);

                $result = array(
                'success' => '1',
                'error' => 0,
                'error_message' => ''
                );
                return $this->result = $result;
            }
        } else {
            $result = array(
            'success' => '0',
            'error' => 1,
            'error_message' => 'Wrong API_KEY or API_SECRET supplied'
            );
            return $this->result = $result;
        }
    }

}

if (isset($_GET['callback']) === TRUE) {
    header('Content-Type: text/javascript;');
    header('Access-Control-Allow-Origin: http://client');
    header('Access-Control-Max-Age: 3628800');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    $object = array(
    "api_key" => $_GET['api_key'],
    "api_secret" => $_GET['api_secret'],
    "phone_number" => $_GET['phone_number'],
    "message" => $_GET['message'],
    "karibusmspro" => $_GET['karibusmspro'],
    );
    //lets call the api class now
    $api = new js_api();
    $api->js_init($object);
    $result = $api->result;
    echo $_GET['callback'] . '(' . json_encode($result) . ')';
}

