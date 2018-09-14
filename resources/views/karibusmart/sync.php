<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../include/bootstrap.php';

/**
 * Description of sync
 *
 * @author user
 */
class sync {

    //put your code here
    /*
     * we use this file to check
     * 
     * if user subscribe to a certain business page, a message is needed to be sent
     * to subscriber but it should come from the business mobile phone
     * 
     * if user send message from a web based interface and message is not yet sent
     * to users so we sync information to make business phone send sms
     * 
     * 
     */
    private $return=array();
    
    private $ntfn;

    public function __construct() {
        //$this->check();
       // $this->notify_business();
    }

    public function check() {
        $this->ntfn = nfcn::find_all();
        if (!empty($this->ntfn)) {
            $this->notify_business();
        }
    }

    public function send_sms_to_subscriber() {


        $this["success"] = 0;
        $this['message'] = "Message sent successfully";
        $this["messagetosend"] = "helo, test send sms after every 5 seconds";
        $this["posts"] = array();
        $subscribers = array('+255714825469', '+255652160360', '+255718344741');
        foreach ($subscribers as $subscriber) {
            $post = array();
            $post["phonenumber"] = $subscriber;
            array_push($this["posts"], $post);
        }
        echo json_encode($this);
    }

    public function send_sms_to_clients() {
        $this["success"] = 0;
        $this['message'] = "Message sent successfully";
        $this["messagetosend"] = "helo, test send sms after every 5 seconds";
        $this["posts"] = array();
        $subscribers = array('+255714825469', '+255652160360', '+255718344741');
        foreach ($subscribers as $subscriber) {
            $post = array();
            $post["phonenumber"] = $subscriber;
            array_push($this["posts"], $post);
        }
        echo json_encode($this);
    }

    public function notify_business() {

        $this->return["success"] =0;
        $this->return['message'] = "Message sent successfully";
        $this->return["messagetosend"] = "helo, test send sms after every 5 seconds";
        $this->return["posts"] = array();
        $subscribers = array('+255714825469');
       
        foreach ($subscribers as $subscriber) {
            $post = array();
            $post["phonenumber"] = $subscriber;
            array_push($this->return["posts"], $post);
        }
        echo json_encode($this->return);
    }

}
new sync();