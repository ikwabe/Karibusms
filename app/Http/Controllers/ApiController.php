<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MessageController;
use DB;

class ApiController extends Controller {

    public $status;
    private $message;
    private $api_secret;
    private $api_key;
    private $phone_number;
    private $business;
    private $developer;
    private $name;
    private $sms_remain;
    private $karibusmspro;
    public $client_id;
    private $error = array(
        'error' => 1,
        'error_message' => "system error",
        "success" => 0,
    );

    public function addInvoice() {
        $payments = DB::table('payment')->get();
        foreach ($payments as $payment) {
            $invoice = random_int(10000, str_replace(1465, NULL, time()));
            if ($payment->invoice == '' || $payment->invoice == 'null') {

                DB::table('payment')->where('payment_id', $payment->payment_id)->update([
                    'invoice' => $invoice
                ]);
            }
        }
    }

    public function test() {
//	$messages = DB::select("SELECT a.content, a.phone_number,a.from_smart, a.pending_sms_id, b.username,b.gcm_id FROM pending_sms a JOIN client b ON a.client_id=b.client_id WHERE a.status='0' AND a.message_id='61763'");
//
//	foreach ($messages as $message) {
//
//	    $status = \Gcm::send($message->content, $message->phone_number, $message->username, $message->gcm_id);
//	    print_r($status);
//	}
//	print_r($status);
//	//$device=  $this->getBrowser();
//	//$agent=$this->userAgent();
//	//print_r($device);
//	//print_r($agent);
//
//	$string = 'The quick brown fox <a href="www.quick.com" title="quick box">www.quick.com</a> overquick the lazy dog quick quick.';
//	$patterns = array();
//	$patterns[0] = '/[quick]/';
//	$replacements = array();
//	$replacements[0] = '<b>slow</b>';
//	htmlentities($string);
//	echo preg_replace('/\bquick /i', '<b>slow</b>  ', $string);
//	$gcm_id = 'cr397ttHmI8:APA91bFM7Mt2uT-oUuC-YAIrTy2GgdM1rwC-bf5dR5ydFbfn4QoN3ffdjz971BDQTpmDrAI-O8oM_nQ8Ag_3NHxsWu649UZ6Nt9CQYghuOCVzLcdLElzmM1BDfTDs8RU3rvN9nNHEcMN';
//	$content = 'Dear KaribuSMS user , new version of karibuSMS API for software developers has been released .Visit www.karibusms.com/api and get started. API supports both internet and phone SMS';
//	//$push = \Gcm::push_to_phoneid($content, $gcm_id);
//	$push2 = \Gcm::send($content, '255714825469', 'Ephraim', $gcm_id);
//	print_r($push2);

        $users = DB::table('pending_sms')->select('phone_number', 'pending_sms_id')->where(['status' => 1])->get();
        foreach ($users as $user) {
            // echo $user->phone_number . '<br/>';
            // $username = preg_replace("/[^A-Za-z0-9]/", '', $user->phone_number);
            $number = validate_phone_number($user->phone_number);
            print_r($number);
            echo '<br/>';
//	    $limit = substr($username, 0, 10);
            // $phone_number = str_replace(' ', '', $user->phone_number);
//	    DB::table('pending_sms')
//		    ->where('pending_sms_id', $user->pending_sms_id)
//		    ->update(['phone_number' => $username]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
    }

    public function api($data) {
        if (isset($_GET['callback']) === TRUE) {
            header('Content-Type: text/javascript;');
            header('Access-Control-Allow-Origin: http://client');
            header('Access-Control-Max-Age: 3628800');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
            //lets call the api class now
            $data = json_encode(array(
                'success' => 0,
                'message' => "All is well and not empty"
            ));
            return request('callback') . '(' . $this->call($data) . ')';
        } else {
            return $this->call($data);
        }
    }

    public function init(Request $request) {
        $data = $request->all();
        return $this->api($data);
    }

    private function call($data) {
        foreach ($data as $key => $value) {
            if ($data[$key] == '') {
                return (json_encode(array(
                            'success' => 0,
                            'message' => $key . " is empty"
                )));
            }
            $this->$key = $value;
        }
        if ($this->findApp() == TRUE) {
            if (request('tag') == 'get_statistics') {

                return json_encode($this->getStatistics($this->developer->name, $this->developer->client_id));
            } else if (request('tag') == 'get_report') {

                return $this->getReport($this->developer->name, $this->developer->client_id);
            } else if (request('tag') == 'get_phone_status') {
                return $this->checkPhoneStatus();
            } if (request('tag') == 'push_sms') {
                return $this->pushSms();
            } else {
                return $this->start();
            }
        } else {
            return (json_encode(array(
                        'success' => 0,
                        'message' => "Wrong API_KEY or SECRET_KEY is supplied"
            )));
        }
    }

    private function getStatistics($name, $client_id = NULL) {
        $id = $client_id == NULL ? $this->client_id : $client_id;
        $statistics = DB::table('pending_sms')->where('username', $name)->get();
        $sms_status = DB::table('sms_status')->where('client_id', $id)->first();
        $sms_used = count($statistics);
        return array(
            'sms_used' => $sms_used,
            'sms_remain' => $sms_status->message_left,
            'app_name' => $name
        );
    }

    private function getReport($name, $client_id = NULL) {
        $id = $client_id == NULL ? $this->client_id : $client_id;
        $range = " and (reg_time::date >= '" . request('start_date') . "' AND reg_time::date <= '" . request('end_date') . "')";
        $date = (request('start_date') !== null ) ?
                $range :
                '';
        return response()->json(
                        [
                            'success' => '1',
                            'messages' => DB::select("select content as message, phone_number as phone, from_smart as karibusmspro, status, reg_time as sent_time, username as sender_name, delivered_status FROM pending_sms where client_id={$id} $date")
        ]);
    }

    /**
     * 
     * @param type $client_id
     * @return Object
     */
    public static function getDeveloperApp($client_id) {
        return DB::select("SELECT * FROM developer_app WHERE client_id='" . $client_id . "' ");
    }

    /**
     * 
     * @param type $developer_id
     * @return Object
     */
    public static function getAppStat($developer_id) {
        return DB::table('developer_message')->where('developer_id', $developer_id)->first();
    }

    private function start() {

        $numbers = $this->getNumbers();

        foreach ($numbers as $phone_number) {
            $this->addNewNumber($phone_number);
        }
        if ($this->business->gcm_id == '' && $this->karibusmspro == FALSE) {
            die(json_encode(array(
                "success" => 0,
                'message' => 'You do not have a latest karibuSMS app in your phone. Please download the latest version of karibuSMS in google play: https://goo.gl/APJaej and login first in the android app'
            )));
        }
        if ($this->karibusmspro == TRUE || $this->karibusmspro == 1) {
            $this->proCheckPaymentStatus();
        }

        $message = new MessageController($this->developer->client_id);
        $name = ($this->name == '0' || $this->name == NULL || $this->name == '') ? $this->developer->name : $this->name;

        $message->saveSms($this->message, $numbers, $this->karibusmspro, NULL, $name, $this->developer->developer_id);

        $message_left = DB::table('sms_status')
                ->where('client_id', $this->developer->client_id)
                ->value('message_left');
        $this->pushSms();
        return json_encode(array(
            'success' => 1,
            'phone' => $this->phone_number,
            'sms_remain' => $message_left,
            'message' => 'message sent successfully'
        ));
    }

    public function pushSms() {
        $message = new MessageController($this->developer->client_id);
        return $message->sendPullRequest($this->developer->client_id);
    }

    private function getNumbers() {
        $numbers = explode(',', $this->phone_number);
        $phone_numbers = array();
        foreach ($numbers as $number) {
            $valid_number = validate_phone_number($number);
            if (!is_array($valid_number)) {
                die(json_encode(array(
                    "success" => 0,
                    "message" => $number . ' is not a valid number'
                )));
            } else {
                array_push($phone_numbers, $valid_number[1]);
            }
        }
        return $phone_numbers;
    }

    private function findApp() {
        $developer_info = DB::table('developer_app')
                        ->where('api_key', $this->api_key)
                        ->where('api_secret', $this->api_secret)->first();
        if (count($developer_info)==1) {
            $this->developer = $developer_info;
            $this->business = DB::table('client')->where('client_id', $this->developer->client_id)->first();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Returns decrypted original string
     */
    private function decryptApp($encrypted_string, $encryption_key) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, ECRYPTION_KEY, base64_decode($encrypted_string), MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }

    private function encryptApp($pure_string) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, ECRYPTION_KEY, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        return base64_encode($encrypted_string);
    }

    public function addNewNumber($phone_number, $name = '') {

        $subscriber_info = DB::table('subscriber_info')
                        ->where("phone_number", $phone_number)
                        ->where('client_id', $this->developer->client_id)->first();

        if (empty($subscriber_info)) {
            $people = new PeopleController();
            $request = array(
                'firstname' => $name,
                'phone_number' => $phone_number,
                'category' => $this->developer->name,
                'client_id' => $this->developer->client_id,
                'added_by' => 'api_call'
            );
            $people->addSubscriberInfo($request);
        }
    }

    public function proCheckPaymentStatus() {

        $record = DB::table('sms_status')->where('client_id', $this->developer->client_id)->first();
        if (!empty($record)) {
            //this user has some SMS remain

            $phone_numbers = explode(',', $this->phone_number);
            $sms_count_per_sms = ceil(strlen($this->message) / 160);
            $total_sms = $sms_count_per_sms * count($phone_numbers);
            if ((int) $record->message_left < (int) $total_sms || (int) $record->message_left <= 0) {
                die(json_encode(array(
                    'message' => 'Insufficient credit, send your payments to us or contact us via info@karibusms.com',
                    'success' => 0)));
            } else {
                return TRUE;
            }
        } else {
            //check the status if business exist
            die(json_encode(array(
                'message' => 'Insufficient credit, send your payments to us or contact us via info@karibusms.com',
                'success' => 0)));
        }
    }

    public function karibusms_payment_status() {
        global $db;
        $business_info = business::find_where(array('imei' => $this->IMEI));
        $business = array_shift($business_info);

        //check start offer
        $db->query("select * from smart_start_offer where business_id = '" . $business->client_id . "'");
        $row = $db->fetchArray();

        if (empty($row)) {
            //no start offer continue...
            unset($row);
            $db->query("select * from smart_bundles where business_id='" . $business->client_id . "'");
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
            $this->max_contacts = 400; //maximum number of contacts for the start offer.   
            $this->offer_days = $row['days_remain'];
        }
    }

    public function checkPhoneStatus() {

        \Gcm::sendAction("REPORT_ONLINE_PRESENCE", null, $this->business->gcm_id);
        sleep(5);
        $client = \DB::table('client')->where('client_id', $this->developer->client_id)->first();
        return json_encode(['gcm_id' => $this->business->gcm_id, 'last_online' => $client->last_reported_online]);
    }

    public function setSmsTimeInterval() {
        
    }

}
