<?php

/**
 * @author Ephraim Swilla<swillae1@gmail.com>
 * @uses  Used to receive all sms forwarded from a server
 */
/// we include this to take all basic requirements
require_once '../../include/bootstrap.php';

class smart {

    public $IMEI;
    public $phonenumber;
    public $message;
    public $username;
    public $business;
    public $businessname;
    public $country;
    public $max_contacts;
    public $offer_days = '';
    public $return = array();

    public function __construct() {

        $this->initialize();
        $this->create_log();
        $status = isset($_POST['status']) ? $_POST['status'] : '';

        if ($status === 'login') {
            $this->login();
        } elseif ($status === 'register') {
            $this->check();
        } elseif ($status === 'upload') {
            $this->upload_contact();
        } elseif ($status === 'payment') {
            $this->receive_payment_receipt($_POST['status']);
        } else if ($status === 'gcm_id') {
            $this->register_gcm_id();
        } else {
            if ($this->IMEI == '868438019307183' || $this->IMEI == '866516012024954' || $this->IMEI == '357514052665469') {
                //this phone number is for company
                $this->admin_functions();
            } else {
                $this->send_sms();
            }
        }
    }

    private function initialize() {

        $received_number = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
        if ($received_number != '') {
            $number = validate_phone_number($received_number);

            if (is_array($number)) {
                $this->phonenumber = $number[1];
                $this->country = $number[0];
            } else {
                $this->return['success'] = 0;
                $this->return['message'] = "Phonenumber is incorrect";
                echo json_encode($this->return);
                exit();
            }
        }
        $this->IMEI = isset($_POST['IME']) ? $_POST['IME'] : '';
        $this->message = isset($_POST['message']) ? $_POST['message'] : '';
        $this->password = isset($_POST['password']) ? sha1(md5(sha1($_POST['password']))) : '';
        $this->businessname = isset($_POST['businessname']) ? $_POST['businessname'] : '';
    }

    private function admin_functions() {
        global $db;
        include_once RT . 'modules/karibusmart/admin.php';
        $admin = new admin();
        $keyword = explode(' ', $this->message);
        $this->message = rtrim(trim(preg_replace("/" . $keyword[0] . "/i", '', $this->message, 1)));
        $data = array(
            'content' => $this->message,
            'business_id' => 1
        );
        $db->insert('sms', $data);
        if (in_array(strtoupper($keyword[0]), admin::$MESSAGE_TO_ALL_USERS)) {

            $admin->message_to_all_users();
        } elseif (in_array(strtoupper($keyword[0]), admin::$MESSAGE_TO_BUSINESS)) {
            $message = $this->format_smart_sms('inets');
            $admin->message_to_business($message);
        } elseif (in_array(strtoupper($keyword[0]), admin::$MESSAGE_TO_BUSINESS_CUSTOMERS)) {

            $admin->message_to_business_customers();
        } elseif (in_array(strtoupper($keyword[0]), admin::$MESSAGE_FOR_PASSWORD)) {

            $admin->message_for_password();
        } elseif (in_array(strtoupper($keyword[0]), admin::$MESSAGE_FOR_TEST)) {

            $this->message = rtrim(trim(preg_replace("/" . $keyword[1] . "/i", '', $this->message, 1)));
            $admin->message_to_send = $this->format_smart_sms('inets');
            $admin->message_for_test($keyword[1]);
        } else {
            exit();
            $this->send_sms();
        }
        exit();
    }

    private function register_gcm_id() {
        global $db;
        $business_info = business::find_where(array('imei' => $this->IMEI));
        if (!empty($business_info)) {
            $business = array_shift($business_info);
            $regId = $_GET['regId'];
            $data = array('gcm_id' => $regId);
            $db->update('business', $data, "id='" . $business->id . "'");
        }
    }

    private function login() {
        global $db;
        $user_info = business::find_where(array('phone_number' => $this->phonenumber, 'password' => $this->password));

        if (!empty($user_info)) {
            $user_info = array_shift($user_info);
            $db->update('business', array('imei' => $this->IMEI, 'phone_number_valid' => 1), array('id' => $user_info->id));
            $db->insert('login', array('business_id' => $user_info->id, 'device' => 'android app', 'imei' => $this->IMEI));

            $this->return['success'] = 1;
            $this->return['message'] = "login successively";
            $this->return['total_contacts'] = "You have ".$this->getContacts()." in store";
        } else {
            $this->return['success'] = 0;
            $this->return['message'] = "Phonenumber or password is incorrect";
        }
        echo json_encode($this->return);
    }

    private function check() {

        $user_info = business::find_where(array('phone_number' => $this->phonenumber, 'name' => $this->businessname), 'OR');
        if (!empty($user_info)) {
            $this->return['success'] = 0;
            $this->return['message'] = "This phonenumber or name is in use1 !";
            echo json_encode($this->return);
            exit();
        } 
        else {
                $this->register();           
        }
    }

    private function register() {
        global $db;

        $result = $db->insert('business', array('phone_number' => $this->phonenumber,
            'country' => $this->country, 'phone_number_valid' => 1,
            'name' => $this->businessname,
            'username' => str_replace(' ', '_', $this->businessname),
            'password' => $this->password, 'imei' => $this->IMEI));
        if ($result) {
            
//            $business = business::find_where("imei='" . $this->IMEI . "'");
//            $bus = array_shift($business);
//            $data = array('bsoffr_business_id'=>$bus->id,'bsoffr_offer_id'=>1);
//            $result2 = $db->insert('bsoffr', $data);
//            if ($result2){
                
            $this->return['success'] = 1;
            $this->return['message'] = "Registration successively";
//            } else {
//                $this->return['success'] = 1;
//                $this->return['message'] = "Registration successively, offer registration failed";
//            }
        } else {
            $this->return['success'] = 0;
            $this->return['message'] = "Registration failed, try again later!";
        }
        echo json_encode($this->return);
    }
    
    private function getContacts(){
        $business_info = business::find_where(array('phone_number' => $this->phonenumber));
        $business = array_shift($business_info);
        $subscribers = subscription::find_where(array('business_id' => $business->id));
        return count($subscribers);
    }

    private function create_log() {
        $content = ' <table style="min-width:80%;">
            <tbody>
                <tr class="odd">=
                    <td class="">Phone imei: ' . $this->IMEI . '</td>
                    <td class="">Message received:  ' . $this->message . '</td>
                         <td class="">Message received:  ' . $_POST['contacts'] . '</td>
                        <td class="">Business username: ' . $this->business . '</td>
                    <td class="">phonenumber:  ' . $this->phonenumber . '</td>
                        <td class="">received time: ' . date('y-m-d h:m:s') . '</td>
                </tr>
            </tbody>
        </table>';
        $filename = RT . 'media/doc/smart/smart_sms.html';
        write_file($filename, $content);
    }

    public function format_smart_sms($username) {
        $short_url = 'www.karibusms.com/' . $username;
        $message = $username . ': 
' . $this->message . '
' . $short_url;
        return $message;
    }
    
    public function send_sms() {

        if (!empty($this->message) && !empty($this->IMEI)) {
            //$this->check_bundle();
            $business_info = business::find_where(array('imei' => $this->IMEI));
            if (empty($business_info)) {
                $this->return["success"] = 0;
                $this->return['message'] = "This business is not registered";
            } else {
                global $db;
                $business = array_shift($business_info);
                $data = array(
                    'content' => $this->message,
                    'business_id' => $business->id
                );
                $result = $db->insert('sms', $data);
                if ($result == 1) {
                    $message = $this->format_smart_sms($business->username);
                    //check the list of all subscribers belongs to this business
                    $subscriptions = subscription::find_where(array('business_id' => $business->id));
                    if (!empty($subscriptions)) {
                        $this->return["success"] = 1;
                        if (empty($this->offer_days)){
                            $msg = '';
                        } else {
                            $msg = ', '.$this->offer_days.' left for the startup offer';
                        }
                        $this->return['message'] = 'Message sent successfully'.$msg;
                        $this->return["messagetosend"] = $message;
                        $this->return["posts"] = array();
                        $i = 1;
                        foreach ($subscriptions as $subscription) {
                            $post = array();

                            $users_info = subscriber::find_by_id($subscription->subscriber_id);
                            $user = array_shift($users_info);
                            $post["phonenumber"] = '+' . $user->phone_number;
                            array_push($this->return["posts"], $post);
                            if ($i == $this->max_contacts) {
                                break;
                            }
                            $i++;
                        }
                    } else {
                        $this->return["success"] = 0;
                        $this->return['message'] = "You have no subscribers yet";
                    }
                }
            }
        } else {
            $this->return["success"] = 0;
            $this->return['message'] = "Error, Missing some parameters";
        }
        echo json_encode($this->return);
    }

    public function check_bundle() {
        global $db;
        $business_info = business::find_where(array('phone_number' => $this->IMEI));
        $business = array_shift($business_info);
        
        //check start offer
        $db->query("select * from smart_start_offer where business_id = '". $business->id . "'");
        $row = $db->fetchArray();
        
        if (empty($row)){
        //no start offer continue...
        unset($row);
        $db->query("select * from smart_bundles where business_id='" . $business->id . "'");
        $row = $db->fetchArray();
        if (empty($row)) {
            $this->return["success"] = 0;
            $this->return['message'] = "Package is over. Please add payment to access this service.";
            echo json_encode($this->return);
            exit();
        } else {
          // there is an active bundle, check the number of contacts depending on the bundle enrolled.
          //unset($row);  
            $this->max_contacts = $row['total_contacts'];
        }
        } else {
        //there is a start offer, count all number of subscribers.
        $subscribers = subscription::find_where(array('business_id' => $business->id));
        $this->max_contacts = count($subscribers);
        $this->offer_days = $row['days_remain'];
        }
    }

    public function upload_contact() {
         
        global $db;
        $counterr = 0;
        $numbers = array();
        $errors = false;
        $contact_array = explode(',', $_POST['contacts']);
        if (is_array($contact_array)) {
            $business = business::find_where("imei='" . $this->IMEI . "'");
            $bus = array_shift($business);
            foreach ($contact_array as $contact) {
                //$i++;  //to be removed
                $valid_number = validate_phone_number($contact);
                if (is_array($valid_number)) {
                    $data = array(
                        'phone_number' => $valid_number[1],
                        'country' => $valid_number[0]
                    );

                    $user_info = subscriber::find_where("phone_number='" . $valid_number[1] . "'");
                    if (!empty($user_info)) {
                        $user = array_shift($user_info);
                        $id = $user->id;
                    } else {
                        $db->insert('subscriber', $data);
                        $id = $db->id();
                    }

                    $subscriber_data = array(
                        'business_id' => $bus->id,
                        'subscriber_id' => $id
                    );
                    $subscriber_info = subscription::find_where($subscriber_data);
                    if (empty($subscriber_info)) {
                        $db->insert('subscription', $subscriber_data);
                    }
                    
                } else {
                    $errors = true;
                    $counterr++;
                    error_record("Invalid number " . $contact . " is uploaded by business id " . $bus->id . " ", FALSE);
                    //array_push($numbers, $contact);
                }
            }
        }
        $x = count($contact_array());
        if ($errors == true){
            
            if ($counterr == $x){    
                $this->return["success"] = 0;
                $this->return['message'] = "Invalid number(s)";
                //$this->return['total_contacts'] = "9";//"You have ".$this->getContacts()." in store";
            } else {
                $this->return["success"] = 1;
                //$this->return['invalid_numbers'] = "0817171717, 1919191";//'Ignored numbers:'.implode(', ',$numbers);
                $this->return['message'] = "Contacts uploaded, invalid number(s) ignored";
                //$this->return['total_contacts'] = "10";//"You have ".$this->getContacts()." in store";
            }
        } else {
        $this->return["success"] = 1;
        $this->return['message'] = "Contacts are successful uploaded";
        //$this->return['total_contacts'] = "7"; //You have ".$this->getContacts()." in store";
        
        }
        echo json_encode($this->return);
        exit();
    }

    public function receive_payment_receipt($receipt) {

        global $db;
        
        //Later: check if there is a current active bundle then dont process these codes.
        
        $receive_payment = rps::find_where("confirmation_code='" . $receipt . "'");
        if (!empty($receive_payment)) {

            $business = business::find_where("imei='" . $this->IMEI . "'");
            $bus = array_shift($business);

            $payment = array_shift($receive_payment);
            if ($payment->amount == '20000') {
                $bundle_id = 7;
            } elseif ($payment->amount == '60000') {
                $bundle_id = 6;
            } elseif ($payment->amount == '100000') {
                $bundle_id = 5;
            }
            $data = array('payment_id' => $payment->id, 'business_id' => $bus->id, 'bundle_id' => $bundle_id);
            $db->insert('bp', $data);

            $py_data = array(
                'business_id' => $bus->id,
                'verification_code' => $receipt,
                'rps_id' => $payment->id,
                'method' => $payment->vendor,
                'verified_by' => 'android_app',
                'currency' => 'Tsh',
                'amount' => $payment->amount,
                'processed' => 1
            );
            $db->insert('payment', $py_data);

            $message = "Your payment is successful received. You have month payment has been upgraded"
                    . 'Amount received is Tsh ' . $payment->amount;
            $this->return["success"] = 1;
            $this->return['message'] = $message;
        } else {
            $this->return["success"] = 0;
            $this->return['message'] = "Wrong reference number, please try again correctly";
        }
        echo json_encode($this->return);
    }

}

new smart();
?>
