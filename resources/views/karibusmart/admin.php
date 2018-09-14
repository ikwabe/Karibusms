<?php

/**
 * Description of admin
 *
 * @author user
 */
class admin {

    /**
     *
     * @var keyword used to send SMS to all business registed in karibusms 
     */
    public static $MESSAGE_TO_BUSINESS = array('BIASHARA', 'BUSINESS',
        'BUSINESSES', 'BUSSINESS');

    /**
     *
     * @var keyword used to send SMS to all users (all businessess and customers)
     */
    public static $MESSAGE_TO_ALL_USERS = array('ALL', 'WOTE');

    /**
     *
     * @var Keyword used to send testing message to people during demonstration
     */
    public static $MESSAGE_FOR_TEST = array('TEST', 'JARIBU');

    /**
     *
     * @var keyword used to send SMS to all business customers 
     */
    public static $MESSAGE_TO_BUSINESS_CUSTOMERS = array('WATEJA', 'CUSTOMERS', 'CUSTOMER');

    /**
     *
     * @var keyword password
     */
    public static $MESSAGE_FOR_PASSWORD = array('PASSWORD');
    public $message_to_send;
    private $ret = array();

    public function message_for_password() {
        global $db;
        $businesses = business::find_where(array('password' => ''));
        $this->ret["success"] = 1;
        $this->ret["posts"] = array();
        $this->ret['message'] = "Message sent successfully to " . count($businesses) . ' business';
        $codes = rand(1, 999999);
        $password = sha1(md5(sha1($codes)));

        $new_data = array(
            'password' => $password
        );
        $message = 'Hello, katika kuboresha huduma zetu za karibuSMS, utatumia namba ya siri ' . $codes . ' kuingia katika programu. Pia unaweza badilisha namba ya siri ukiingia www.karibusms.com. Endelea kutumia karibuSMS';
         $this->ret["messagetosend"] = 'inets:. 
' . $message . '
' . 'www.karibusms.com/inets'; 
        foreach ($businesses as $business) {
            $post = array();

            $db->update('business', $new_data, "id='" . $business->id . "'");

            $post["phonenumber"] = '+' . $business->phone_number;
            array_push($this->ret["posts"], $post);
        }
        echo json_encode($this->ret);
    }

    public function message_for_test($test_number) {
        $this->ret["success"] = 1;
        $this->ret["messagetosend"] = $this->message_to_send;
        $this->ret["posts"] = array();
        $this->ret['message'] = "Message sent successfully to " . $test_number . ' business';
        $number = validate_phone_number($test_number);

        $post = array();
        $post["phonenumber"] = '+' . $number[1];
        array_push($this->ret["posts"], $post);
        echo json_encode($this->ret);
    }

    public function message_to_business($message) {
        $businesses = business::find_all();
        $this->ret["success"] = 1;
        $this->ret["messagetosend"] = $message;
        $this->ret["posts"] = array();
        $this->ret['message'] = "Message sent successfully to " . count($businesses) . ' business';
        foreach ($businesses as $business) {
            $post = array();
            $post["phonenumber"] = '+' . $business->phone_number;
            array_push($this->ret["posts"], $post);
        }
        echo json_encode($this->ret);
    }

    public function message_to_all_users() {
        $phone_numbers = array_merge($this->get_business_numbers(), $this->get_subscribers_numbers());
        $this->ret['message'] = "Message sent successfully to all " . count($phone_numbers) . ' users';
        $this->ret["success"] = 1;
        $this->ret["messagetosend"] = $this->message_to_send;
        $this->ret["posts"] = array();
        foreach ($phone_numbers as $phone) {
            $post = array();
            $post["phonenumber"] = '+' . $phone;
            array_push($this->ret["posts"], $post);
        }
        echo json_encode($this->ret);
    }

    private function get_business_numbers() {
        $businesses = business::find_all();
        $business_numbers = array();
        foreach ($businesses as $business) {
            $bus = array();
            $bus['phone_number'] = $business->phone_number;
            array_push($business_numbers, $bus);
        }
        return $business_numbers;
    }

    private function get_subscribers_numbers() {
        $subscribers = subscriber::find_all();
        $subscriber_numbers = array();
        foreach ($subscribers as $subscriber) {
            $number = array();
            $number['phone_number'] = $subscriber->phone_number;
            array_push($subscriber_numbers, $number);
        }
        return $subscriber_numbers;
    }

    public function message_to_business_customers() {
        $subscriber_numbers = $this->get_subscribers_numbers();
        $this->ret['message'] = "Message sent successfully to " . count($subscriber_numbers) . ' business customers';
        $this->ret["success"] = 1;
        $this->ret["messagetosend"] = $this->message_to_send;
        $this->ret["posts"] = array();
        foreach ($subscriber_numbers as $number) {
            $post = array();
            $post["phonenumber"] = '+' . $number;
            array_push($this->ret["posts"], $post);
        }
        echo json_encode($this->ret);
    }

}
