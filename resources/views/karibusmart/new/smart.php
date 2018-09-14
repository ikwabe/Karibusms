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
    public $contacts;
    public $country;
    public $max_contacts = 400;  //default free for start if not set
    public $offer_days = '';
    public $return = array();

    public function __construct() {

        $this->initialize();
        $this->create_log();
        $this->test_send_sms();
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $this->register_gcm_id();
        if ($status == 'login') {
            $this->login();
        } elseif ($status == 'register') {
            $this->checkBusiness();
        } elseif ($status == 'upload') {
            $this->upload_contact();
        } elseif ($status == 'payment') {
            $this->receive_payment_receipt($_POST['status']);
        } elseif ($status == 'notice') {
            $this->api_call();
        } else {

            if ($this->IMEI == '860557021525991') {
                //this phone number is for company
                $this->admin_functions();
            }
            $this->send_sms();
        }
    }

    public function format_smart_sms2() {
        $short_url = "'Hello, this is sample ads that will appear in message'";
        $message =$this->message . '
            
' . $short_url;
        return $message;
    }

    function test_send_sms() {
        if (!empty($this->message) && isset($_POST['pesasms'])) {
//            if (karibu::is_try_period() == FALSE) {
//                $this->check_bundle();
//            }
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
                $sms_id = $db->id();
                if ($result == 1) {
                    $message = $this->format_smart_sms2();
                    //check the list of all subscribers belongs to this business
                    $this->return["success"] = 1;

                    $this->return['message'] = 'Message sent successfully';
                    $this->return["messagetosend"] = $message;
                    $this->return["posts"] = array();

                    $post = array();

                    $post["phonenumber"] = '+' . $this->phonenumber;
                    array_push($this->return["posts"], $post);
                }
            }
            echo json_encode($this->return);
            exit();
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
        $this->contacts = isset($_POST['contacts']) ? $_POST['contacts'] : '';
    }

    private function admin_functions() {
        global $db;
        include_once RT . 'modules/karibusmart/admin.php';
        $admin = new admin();
        $keyword = explode(' ', $this->message);
        $message = $this->message;
        $this->message = rtrim(trim(preg_replace("/" . $keyword[0] . "/i", '', $this->message, 1)));
        $data = array(
            'content' => $message,
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
            $this->message = $message;
            $this->send_sms();
        }
        exit();
    }

    private function register_gcm_id() {
        global $db;
        $business_info = business::find_where(array('imei' => $this->IMEI));
        if (!empty($business_info)) {
            $business = array_shift($business_info);
            $regId = isset($_POST['reg_id']) ? $_POST['reg_id'] : '';
            if ($regId != '') {
                $data = array('gcm_id' => $regId);
                $db->update('business', $data, "id='" . $business->id . "'");
            }
        }
    }

    private function login() {
        global $db;
        $user_info = business::find_where(array('phone_number' => $this->phonenumber, 'password' => $this->password));

        if (!empty($user_info)) {
            $user_info = array_shift($user_info);
            $business_imei = business::find_where(array('imei' => $this->IMEI));
            if (!empty($business_imei)) {
                $db->update('business', array('imei' => ''), array('imei' => $this->IMEI));
            }
            $db->update('business', array('imei' => $this->IMEI, 'phone_number_valid' => 1), array('id' => $user_info->id));
            $db->insert('login', array('business_id' => $user_info->id, 'device' => 'android app', 'imei' => $this->IMEI));

            $this->return['success'] = 1;
            $this->return['message'] = "login successively";
            $this->return['total_contacts'] = "You have " . $this->getContacts() . " in store";
            $this->return['business_name'] = $user_info->username;
            $this->return['business_id'] = $user_info->id;
        } else {
            $this->return['success'] = 0;
            $this->return['message'] = "Phonenumber or password is incorrect";
        }
        echo json_encode($this->return);
    }

    private function checkBusiness() {
        $user_info = business::find_where(array('phone_number' => $this->phonenumber, 'name' => $this->businessname), 'OR');
        if (empty($user_info)) {
            $this->register();
        } else {
            $this->return['success'] = 1;
            $this->return['message'] = "This phonenumber or name is in use!";
            echo json_encode($this->return);
            exit();
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
            $business = business::find_by_id($db->id());
            $bus = array_shift($business);
            $data = array('business_id' => $bus->id, 'offer_id' => 1);
            $result2 = $db->insert('bsoffr', $data);
            if ($result2) {
                $this->return['success'] = 1;
                $this->return['message'] = "Registration successively";
            } else {
                $this->return['success'] = 1;
                $this->return['message'] = "Registration successively, offer registration failed";
            }
        } else {
            $this->return['success'] = 0;
            $this->return['message'] = "Registration failed, try again later!";
        }
        echo json_encode($this->return);
    }

    private function getContacts() {
        $business_info = business::find_where(array('imei' => $this->IMEI));
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
                         <td class="">Message received:  ' . $this->contacts . '</td>
                        <td class="">Business username: ' . $this->business . '</td>
                    <td class="">phonenumber:  ' . $this->phonenumber . '</td>
                        <td class="">received time: ' . date('y-m-d h:m:s') . '</td>
                            <td class="">gcm id:  ' . isset($_POST['reg_id']) ? $_POST['reg_id'] : '' . '</td>
                        <td class=""></td>
                </tr>
            </tbody>
        </table>';
        $filename = RT . 'media/doc/smart/' . date('m_Y_d') . '.html';
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
//            if (karibu::is_try_period() == FALSE) {
//                $this->check_bundle();
//            }
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
                $sms_id = $db->id();
                if ($result == 1) {
                    $message = $this->format_smart_sms($business->username);
                    //check the list of all subscribers belongs to this business
                    $subscriptions = subscription::find_where(array('business_id' => $business->id));


                    if (!empty($subscriptions)) {


                        if (count($subscriptions) > $this->max_contacts) {
                            $msg = "Message will be sent to only " . $this->max_contacts . ' contacts';
                            array_splice($subscriptions, $this->max_contacts);
                        } else {
                            $msg = '';
                        }

                        $this->return["success"] = 1;
                        if (empty($this->offer_days)) {
                            $msg .= '';
                        } else {
                            $msg .= ', ' . $this->offer_days . ' left for the startup offer';
                        }
                        $this->return['message'] = 'Message sent successfully' . $msg;
                        $this->return["messagetosend"] = $message;
                        $this->return["posts"] = array();
                        $i = 1;
                        $sent_ids = array();
                        $all_ids = array();
                        foreach ($subscriptions as $subscription) {
                            $post = array();

                            $all_ids = array_merge($all_ids, array($subscription->subscriber_id));

                            if ($i < 40) {
                                $sent_ids = array_merge($sent_ids, array($subscription->subscriber_id));
                                $users_info = subscriber::find_by_id($subscription->subscriber_id);

                                $user = array_shift($users_info);
                                $post["phonenumber"] = '+' . $user->phone_number;
                                $post["name"] = '+' . $user->othernames;
                                array_push($this->return["posts"], $post);
                            }
                            $i++;
                        }
                        //check if contacts exceed 100 in $all_ids
                        $remain_ids = array_diff($all_ids, $sent_ids);
                        if (count($remain_ids) > 1) {
                            $data = array(
                                'sms_id' => $sms_id,
                                'subscriber_id' => implode(',', $remain_ids),
                                'issms_to_send' => 1,
                                'type' => 'karibusms',
                                'business_id' => $business->id
                            );
                            $db->insert('qsms', $data);
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
        exit();
    }

    public function get_sms() {
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

    public function check_bundle() {
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
            //$subscribers = subscription::find_where(array('business_id' => $business->id));  
            //$this->max_contacts = count($subscribers);
            $this->max_contacts = 400; //maximum number of contacts for the start offer.   
            $this->offer_days = $row['days_remain'];
        }
    }

    public function upload_contact() {

        global $db;
        $counterr = 0;
        $numbers = array();
        $errors = 0;
        $exist = 0;
        $contact_array = explode(',', $_POST['contacts']);
        if (is_array($contact_array)) {
            $business = business::find_where("imei='" . $this->IMEI . "'");
            $bus = array_shift($business);
            foreach ($contact_array as $contact) {
                //$i++;  //to be removed
                $contact = preg_replace('/\s+/', '', $contact);
                $valid_number = validate_phone_number($contact);
                if (is_array($valid_number)) {
                    $data = array(
                        'phone_number' => $valid_number[1],
                        'country' => $valid_number[0]
                    );

                    $user_info = subscriber::find_where("phone_number='" . $valid_number[1] . "'");
                    if (count($user_info) != 0) {
                        //$exist = 1;
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
                    $errors = 1;
                    $counterr++;
                    error_record("Invalid number " . $contact . " is uploaded by business id " . $bus->id . " ", FALSE);
                    array_push($numbers, $contact);
                }
            }
        }
        $x = count($contact_array);
        if ($errors == 1) {

            if ($counterr == $x) {
                $this->return["success"] = 0;
                $this->return['message'] = "Invalid number(s)";
                $this->return['total_contacts'] = "You have " . $this->getContacts() . " contacts in store";
            } else {
                $this->return["success"] = 2;
                $this->return['invalid_numbers'] = 'Ignored numbers:' . implode(', ', $numbers);
                $this->return['message'] = "Contacts uploaded, invalid number(s) ignored";
                $this->return['total_contacts'] = "You have " . $this->getContacts() . " contacts in store";
            }
        } else {
            if ($exist === 1 && $x === 1) {
                $this->return["success"] = 1;
                $this->return['message'] = "Contact exist";
                $this->return['total_contacts'] = "You have " . $this->getContacts() . " contacts in store";
            } else {
                $this->return["success"] = 1;
                $this->return['message'] = "Contacts are successful uploaded";
                $this->return['total_contacts'] = "You have " . $this->getContacts() . " contacts in store";
            }
        }
        echo json_encode($this->return);
        exit();
    }

    public function receive_payment_receipt($receipt) {

        $business = business::find_where("imei='" . $this->IMEI . "'");
        $bus = array_shift($business);
        $pmt = new pmt();
        $pmt->business_id = $bus->id;
        $check = $pmt->check_receipt($receipt);
        if ($check) {
            $pmt->make();

            $message = "Your payment is successful received. Your monthly payment has been upgraded"
                    . 'Amount received is Tsh ' . $pmt->pmt_info->amount;
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
