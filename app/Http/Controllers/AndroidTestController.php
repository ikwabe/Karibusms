<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LoginController;

class AndroidTestController extends Controller {

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
                        DB::select("SELECT a.content, a.to_ids, a.time, b.name as category_name FROM message a left join category b ON b.category_id=a.category_id WHERE a.client_id='" . request('business_id') . "' ORDER BY a.time DESC ")
        );
    }

    public function getCategory() {
        return response()->json(
                        DB::select("SELECT b.name as category_name, b.category_id FROM category b WHERE b.client_id='" . request('business_id') . "'")
        );
    }

    public function addCategory() {
        $people = new PeopleController();
        return $people->addCategory();
    }

    public function getContactsByCategory() {
        $people = new PeopleController();
        return response()->json($people->getPeople(request('category_id')));
    }

    public function deleteCategory() {
        $people = new PeopleController();
        return $people->destroy(request('category_id'));
    }

    public function deleteContact() {
        $people = new PeopleController();
        return $people->destroy(request('subscriber_info_id'));
    }

    public function updateCategory() {
        $people = new PeopleController();
        return $people->updateCategory(request('category_id'));
    }

    public function updateContact() {
        $people = new PeopleController();
        $request['tag'] = request('value');
        return $people->update($request, $this->client_id);
    }

    public function get_contacts() {
        return response()->json(
                        DB::select("SELECT a.firstname ||' '|| a.lastname as name, a.phone_number, a.subscriber_info_id FROM subscriber_info a WHERE a.client_id='" . request('business_id') . "' ORDER BY a.regtime DESC ")
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
                            'groups' => DB::select("SELECT name as category, category_id FROM category WHERE client_id='" . request('business_id') . "'")
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

    public function get_profile() {
        $page = request('page') ? request('page') : 1;
        $firstpage = 10 * ($page - 1);
        $lastpage = 10 * $page;
        $business_id = request('business_id');
        $where = $business_id == '' ? ' ' : " and a.client_id='{$business_id}'";
        return response()->json(DB::select("select a.client_id as id, case when b.total is null then 0 end as subscribers,a.about as description, case when a.profile_pic is null then 'null' else   'http://karibusms.com/media/images/business/' || a.client_id || '/' || a.profile_pic end as image_url, a.name as business_name, a.location, a.phone_number, a.email, a.city, a.country FROM client a left JOIN client_subscribers b ON a.client_id=b.client_id  WHERE a.client_id='{$business_id}' "));
    }

    public function sent_sms() {
        return response()->json(
                        DB::select("SELECT m.message_id, m.content as message, to_char(m.time , 'YYYY-MM-DD HH:MI') as time, c.name as category_name, m.messaging_type, m.to_ids as sms_count  FROM message m LEFT JOIN category c ON c.category_id=m.category_id WHERE m.client_id='" . request('business_id') . "' ORDER BY m.message_id DESC")
        );
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
        echo json_encode([array(
        'subscribers' => $total_people,
        'sentsms' => $sms_sent,
        'remainingsms' => $user->message_left,
        'pendingsms' => count($pending)
        )]);
    }

    public function sendMessage() {
        $message = new MessageController(request('business_id'));
        return $message->sendSmsByCategory();
    }

    public function sendByNumber() {
        $message = new MessageController(request('business_id'));
        return $message->sendSmsByNumbers();
    }

    //NEW: Retrieve all messages that are pending, will then be queued on mobile
    public function pullMessagesToSend() {

        $messages = DB::table('pending_sms')
                ->where('status', 0)
                ->where('from_smart', 1)
                ->where('client_id', $this->client_id)
                ->get();

        //update all messages fetched above to SENT TO MOBILE status
        DB::table('pending_sms')
                ->where('status', 0)
                ->where('from_smart', 1)
                ->where('client_id', $this->client_id)
                ->update(
                        [
                            'status' => 1, //sent to mobile/Gateway
                            'delivered_status' => 'success' //fixme: What should be store here?
                        ]
        );

        echo json_encode(['status' => 'success', 'data' => $messages]);
    }

    //NEW: Store the received message
    public function storeIncomingMessage() {
        $content = request('content');
        $phone_number = request('phone_number');
        $fields = [
            'content' => $content,
            'phone_number' => $phone_number,
            'client_id' => (int)$this->client_id==0 ? 1 :$this->client_id ,
            'time' => date('Y-m-d H:i:s'),
        ];
        $incoming_message_id = DB::table('incoming_message')->insertGetId($fields, 'incoming_message_id');
        $this->curl($fields);
        echo json_encode(['status' => 'success', 'data' => ['message_id' => $incoming_message_id]]);
    }

    public function curl($fields,$url=null) {
        // Open connection
        $server_url=$url==null ? config('app.server_url'): $url;
        $ch = curl_init();
        // Set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL,$server_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-type: application/json;charset=\"utf-8\"", "Accept: application/json", "Cache-Control: no-cache"
        ));

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
        
    }

    //NEW: Updates messages with their respective sending/delivery status
    function updateMessageSendingStatus() {
        $messages = json_decode(request('messages'));
        foreach ($messages as $message) {
            DB::table('pending_sms')
                    ->where('client_id', $this->client_id)
                    ->where('pending_sms_id', $message->pending_sms_id)
                    ->update(['status' => $message->status]); //Database field has comments on what the status number mean
        }
        echo json_encode(['status' => 'success', 'message' => 'Messages Updated successful']);
    }

    //NEW:  In some cases token can be null(not generated) during login so we have to update it when it is available
    public function updateGCMToken() {
        DB::table('client')
                ->where('client_id', $this->client_id)
                ->update(['gcm_id' => request('token')]);
        echo json_encode(['status' => 'success', 'message' => 'Messages Updated successful']);
    }

    /**
     * //NEW: A way for an App to notify server that it is online
     *
     * to Request up to send status:  \Gcm::sendAction("REPORT_ONLINE_PRESENCE",null,$client->gcm_id);
     * */
    public function helloFromApp() {
        DB::table('client')
                ->where('client_id', $this->client_id)
                ->update(['last_reported_online' => date('Y-m-d H:i:s')]);
        echo json_encode(['status' => 'success', 'message' => 'Messages Updated successful']);
    }

    /*     * *
     * Hello test
     */

    public function helloToApp() {
        $client = DB::table('client')->where('client_id', $this->client_id)->first();
        print_r(\Gcm::sendAction("REPORT_ONLINE_PRESENCE", null, $client->gcm_id));
    }

    public function deleteMessage() {
        $message = new MessageController();
        $message->deleteMessage(request('message_id'));
        echo json_encode(['status' => 'success', 'message' => 'Message deleted successful']);
        //json_encode(['status' => 'error', 'message' => 'Error occurs in deleting SMS']);
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
                    'category' => request('category_name') == 'all' ? '' : request('category_name')
                );
                echo $people->addSubscriberInfo($request);
            }
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Invalid contact format uploaded']);
        }
    }

    public function createCategory() {
        $cat = DB::table('category')
                ->where(['name' => request('name'), 'client_id' => $this->client_id])
                ->first();
        if (empty($cat)) {
            $id = DB::table('category')->insertGetId(
                    ['name' => request('name'), 'client_id' => $this->client_id], 'category_id'
            );
            $data = json_encode(['status' => 'success', 'message' => 'Category created successfully']);
        } else {
            $data = json_encode(['status' => 'error', 'message' => 'Category already exist']);
        }
        return $data;
    }

    public function storeContacts() {
        $people = new PeopleController();
        $numbers = $this->filterPhoneNumbers(request('phone_number'));
        foreach ($numbers as $number) {
            $request = array(
                'phone_number' => $number[1],
                'firstname' => request('name'),
                'email' => request('email'),
                'category' => request('category_name')
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
