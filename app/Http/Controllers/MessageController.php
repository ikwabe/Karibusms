<?php

/**
 * Description of Message
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class MessageController extends Controller {

    public $username;
    private $sms_count_per_sms;

    /**
     *
     * @return type
     */
    public function __construct($client_id = NULL) {
        parent::__construct();
        $this->client_id = $client_id == NULL ? $this->client_id : $client_id;

        $this->username = DB::table('client')->where('client_id', $this->client_id)->value('username');
    }

    public function sms($offset = 0) {
        $skip = $offset * 10;
        $sms = DB::select("SELECT * from message WHERE "
                        . "client_id='" . $this->client_id . "' ORDER BY time DESC OFFSET {$skip} LIMIT 10");
        if ($offset == 0) {
            $return = view('message.sms')->with(array('sms' => $sms, 'gcm_id' => $this->gcmId()));
        } else {
            $return = $this->loadMoreSms($sms);
        }
        return $return;
    }

    public function pendingSms() {
        $sms = DB::select("SELECT * from pending_sms WHERE "
                        . "client_id='" . $this->client_id . "' AND status='0' ORDER BY reg_time DESC");

        $return = view('message.pending_sms')->with(array('sms' => $sms, 'gcm_id' => $this->gcmId()));
        return $return;
    }

    public function loadMoreSms($sms) {
        $user = self::user_info();
        $link = 'media/images/business/' . $user->client_id . '/' . $user->profile_pic;
        $path = file_exists($link) ? $link : 'media/images/business/0/default.png';
        $return = '';
        foreach ($sms as $message) {
            $return .= '<li class="list-group-item animated fadeInRightBig" onmousedown="call_page(\'sms_content/' . encryptApp($message->message_id) . '\', \'#sms_content_div\')
    						$(\'#lists\').toggle();">
    					    <a href="#" class="thumb-xs pull-left m-r-sm"> 
    						<img src="' . $path . '" class="img-circle">
    					    </a> 
    					    <a href="#" class="clear"> 
    						<small class="pull-right text-muted">
						' . date("d M Y h:m", strtotime($message->time)) . '</small><span>' . str_limit($message->content, 60) . '<span class="text-success">read more....</span></span> </a></li>';
        }
        return $return;
    }

    /**
     *
     * @param type $message_id : integer, message ID from DB
     * @return type View: SMS content
     */
    public function show($message_id) {
        $message = DB::table('message')->where('message_id', decryptApp($message_id))
                ->where('message.client_id', $this->client_id)
                ->leftJoin('category', 'message.category_id', '=', 'category.category_id')
                ->first();
        $phone_numbers = DB::table('pending_sms')->where('message_id', decryptApp($message_id))->get();
        return view('message.sms_content')->with(array('message' => $message, 'phone_numbers' => $phone_numbers));
    }

    /**
     *
     * @return HTML : view to send SMS
     */
    public function send_sms() {
        $username = DB::table('client')->where('client_id', $this->client_id)->value('username');
        return view('message.send_sms')->with(array('gcm_id' => $this->gcmId(), 'username' => $username));
    }

    /**
     *
     * @return HTML : view to send Email
     */
    public function send_email() {
        $username = DB::table('client')->where('client_id', $this->client_id)->value('username');
        return view('message.send_email')->with(array('gcm_id' => $this->gcmId(), 'username' => $username));
    }

    /**
     *
     * @return type
     */
    public function getCategoryId() {
        $id = DB::table('category')->where('name', request('category_name'))->where('client_id', request('business_id'))->value('category_id');
        if (empty($id)) {
            $category_id = 0;
        } else {
            $category_id = $id;
        }
        return $category_id;
    }

    /**
     * @uses Send SMS function by category
     */
    public function sendSmsByCategory() {
        $category_id = request('category') == NULL ? $this->getCategoryId() : request('category');
        $content = htmlspecialchars(request('content'));
        $this->sms_count_per_sms = ceil(strlen($content) / 160);
        if ($category_id == 0 || $category_id == NULL) {
            //Send SMS to all people
            $numbers = DB::select("SELECT a.phone_number FROM subscriber_info a WHERE client_id='" . $this->client_id . "'");
        } else {
            //send SMS to a certain category only
            $numbers = DB::select("SELECT a.phone_number FROM subscriber_info a WHERE client_id='" . $this->client_id . "' AND category_id='" . $category_id . "' ");
        }


        //check available SMS
        //save in DB for cronjob to run
        $message_type = request('message_type') == NULL ? 1 : request('message_type');

        $message_type == 1 ? $this->checkSmsStatus(count($numbers)) : 0;

        $this->saveSms($content, $numbers, $message_type, $category_id);


        return json_encode(array(
            'message' => 'Message Sent Successfully',
            'status' => 'success'
        ));
    }

    /**
     *
     * @param String $sms_content Content to be sent
     * @param String $phone_number List of phone numbers separated by comma
     * @param Integer $sms_type Either 1 for internet sms or 0 for phone sms
     * @depends saveSms method is called inside. The main advantage of this method is it validate sms remain
     *                   while calling saveSms directly does not
     */
    public function sendSmsByNumbers($sms_content = NULL, $phone_number = NULL, $sms_type = 1) {
        $content = $sms_content == NULL ? htmlspecialchars(request('content')) : $sms_content;
        $phone = $phone_number == NULL ? request('phone_numbers') : $phone_number;

        $numbers = $this->filter_phone_numbers(htmlspecialchars($phone));
        $this->sms_count_per_sms = ceil(strlen($content) / 160);
        if (!empty($numbers)) {
            if (request('sub_id') != '' && !empty(request('sub_id'))) {
                //send MESSAGE to page admin. this message comes from clients
                $this->send_to_id(htmlspecialchars($_GET['sub_id']));
            } else {
                //send bulkSMS here

                $message_type = request('message_type') == NULL || request('message_type') == '' ? $sms_type : request('message_type');


                //check available SMS
                $message_type == 1 ? $this->checkSmsStatus(count($numbers)) : '';

                //save in DB for queue to run
                $this->saveSms($content, $numbers, $message_type);
            }
            return json_encode(array(
                'message' => 'Message Sent Successfully',
                'status' => 'success'
            ));
        }
    }

    /**
     *
     * @param Integer $type : Type of request
     * @return Method to be called
     */
    public function sms_send($type = null) {
        if ($type == 1) {
            $return = $this->sendSmsByCategory();
        } else {
            $return = $this->sendSmsByNumbers();
        }
        return $return;
    }

    public function sendEmailByCategory() {
        $category_id = request('category') == NULL ? $this->getCategoryId() : request('category');
        $content = nl2br(request('content'));
        $subject = request('subject');
        if ($category_id == 0 || $category_id == NULL) {
            //Send SMS to all people
            $emails = DB::select("SELECT a.email FROM subscriber_info a WHERE client_id='" . $this->client_id . "'");
        } else {
            //send SMS to a certain category only
            $emails = DB::select("SELECT a.email FROM subscriber_info a WHERE client_id='" . $this->client_id . "' AND category_id='" . $category_id . "' ");
        }
        $username = DB::table('client')->where('client_id', $this->client_id)->value('username');
        $data = ['content' => $content, 'client_name' => $username];
        foreach ($emails as $mail) {
            Mail::queue('emails.notification', $data, function ($m) use ($mail, $subject, $username) {
                $m->from('info@karibusms.com', $username);
                $m->to($mail->email)->subject($subject);
            });
        }
        echo json_encode(array(
            'message' => 'Email Sent Successfully',
            'status' => 'success'
        ));
    }

    public function sendEmailByList($email = NULL, $subject = NULL, $content = null) {
        $email_body = $content == NULL ? nl2br(request('content')) : $content;
        $emails = $email == NULL ? request('emails') : $email;
        $email_subject = $subject == NULL ? request('subject') : $subject;
        $mails = explode(',', $emails);
        $username = DB::table('client')->where('client_id', $this->client_id)->value('username');
        $data = ['content' => $email_body, 'client_name' => $username];
        foreach ($mails as $mail) {
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                Mail::queue('emails.notification', $data, function ($m) use ($mail, $email_subject, $username) {
                    $m->from('info@karibusms.com', $username);
                    $m->to($mail)->subject($email_subject);
                });
            }
        }
        echo json_encode(array(
            'message' => 'Email Sent Successfully',
            'status' => 'success'
        ));
    }

    /**
     *
     * @param Integer $type : Type of request
     * @return Method to be called
     */
    public function email_send($type = null) {
        if ($type == 1) {
            $return = $this->sendEmailByCategory();
        } else {
            $return = $this->sendEmailByList();
        }
        return $return;
    }

    private function sendAndroid($numbers, $messaging_type) {
        if (request('tag') == 'sendMessage' && $messaging_type == 0) {
            $res = array();
            foreach ($numbers as $number) {
                $no = is_object($number) ? $number->phone_number : $number[1];
                $data = [
                    'phone_number' => $no
                ];
                array_push($res, $data);
            }

            $return = array(
                'message' => $this->customizeContent(request('content'), $number[1], $this->client_id),
                'link' => 'www.karibusms.com/' . $this->username,
                'status' => 'success',
                'phone_post' => $res
            );
            echo json_encode($return);
        } else if (request('tag') == 'sendMessage' && $messaging_type == 1) {
            echo json_encode(array(
                'message' => 'Message Sent Successfully',
                'status' => 'internet'
            ));
        }
    }

    /**
     *
     * @param String $content
     * @param Array $numbers
     * @param integer $messaging_type
     * @param integer $category_id Option value
     * @param String $username Option
     * @param int $developer_id Mandatory only for API sms
     */
    public function saveSms($content, $numbers, $messaging_type, $category_id = NULL, $username = NULL, $developer_id = NULL) {

        $name = $username == NULL ? $this->username : $username;
        $sms_count_per_sms = ceil(strlen($content) / 160);
        $message_id = DB::table('message')->insertGetId(
                [
            'is_bulk' => $messaging_type == NULL ? 0 : $messaging_type,
            'content' => $content,
            'client_id' => $this->client_id,
            'developer_id' => $developer_id,
            'to_ids' => count($numbers),
            'messaging_type' => $messaging_type,
            'message_count' => count($numbers) * $sms_count_per_sms,
            'category_id' => $category_id
                ], 'message_id'
        );

        foreach ($numbers as $number) {
            if (is_object($number)) {
                $phone_number = $number->phone_number;
            } else if (is_array($number)) {
                $phone_number = $number[1];
            } else {
                $phone_number = $number;
            }
            $number = validate_phone_number($phone_number);

            DB::table('pending_sms')->insert(
                    [
                        'phone_number' => $number[1],
                        'content' => $this->customizeContent($content, $number[1], $this->client_id),
                        'client_id' => $this->client_id,
                        'message_id' => $message_id,
                        'from_smart' => $messaging_type == 1 ? 0 : 1,
                        'status' => 0,
                        'username' => substr($name, 0, 11)
                    ]
            );
        }

        //request('tag') == 'sendMessage' ? sleep(5) :'';
        //new: sends a pull request to the mobile
        if (request('tag') == 'store') {
            
        } else {
            $this->sendPullRequest($this->client_id);
        }
        echo request('tag') == 'sendMessage' ?
                json_encode(array(
                    'message' => 'Message Sent Successfully',
                    'status' => 'internet'
                )) : '';
    }

    /**
     * Defined variables are as follows
     * $name,
     * $phone_number
     * $country
     * $email,
     * $location,
     * $organization_name
     * $organization_position
     */
    public function customizeContent($content, $phone_number, $client_id) {

        $user = DB::table('subscriber_info')
                        ->where('client_id', $client_id)
                        ->where('phone_number', $phone_number)->first();

        $patterns = array(
            '/#name/', '/#phone_number/', '/#country/', '/#email/',
            '/#location/', '/#organization_name/', '/#organization_position/', '/#promised/', '/#promise_submitted/', '/#promise_remain/'
        );
        if (!empty($user)) {
            $name = $user->title . ' ' . $user->firstname . ' ' . $user->lastname;
            $promise_remain = (int) $user->promise - (int) $user->promise_submitted;
            $replacements = array(
                $name, $user->phone_number, $user->country, $user->email,
                $user->location, $user->organization_name, $user->organization_position, $user->promise, $user->promise_submitted, $promise_remain
            );

            $message = preg_replace($patterns, $replacements, $content);
        } else {
            $replacements = array('', '', '', '', '', '', '', '', '', '');

            $message = preg_replace($patterns, $replacements, $content);
        }
        return $message;
    }

    public function send($message_id) {
        //FIXME: send notification to device that there is a pending messages
        return $this->dispatch(new \App\Jobs\sendSMSMessages($message_id));
    }

    //NEW:
    /**
     * Notifies client with client Id, there is new sms
     * @param $client_id
     */
    public function sendPullRequest($client_id) {
        $client = DB::table('client')->where('client_id', $client_id)->first();
      return  \Gcm::sendAction("PULL_SMS_TO_SEND", null, $client->gcm_id);
    }

    public function checkSmsStatus($phone_numbers_count = null) {

        $sms_info = DB::table('sms_status')->where('client_id', $this->client_id)->first();
        if (!empty($sms_info)) {
            //not empty, so check available SMS

            if ($sms_info->message_left < $phone_numbers_count * $this->sms_count_per_sms) {
                die(json_encode(array(
                    'status' => 'warning',
                    'message' => 'You have few SMS to send than available phone numbers selected. Contact us via sales@karibusms.com to buy more SMS to send'
                )));
            } else {
                return 1;
            }
        } else {
            die(json_encode(array(
                'status' => 'warning',
                'message' => 'You have no SMS to send. Contact us via sales@karibusms.com to buy SMS to send'
            )));
        }
    }

    private function filter_phone_numbers($phone_numbers) {
        $numbers = explode(',', trim(rtrim($phone_numbers, ','), ','));
        $valid_numbers = array();
        foreach ($numbers as $number) {

            $valid = validate_phone_number($number);
            if (is_array($valid)) {
                array_push($valid_numbers, $valid);
            } else {
                die(json_encode(array(
                    'message' => '' . $number . ' is not a valid number',
                    'status' => 'warning'
                )));
            }
        }
        return $valid_numbers;
    }

    public function mail() {
        $mail = DB::table('request_mail')->where("client_id", $this->client_id)->first();
        if (empty($mail)) {
            return view('message.mail');
        } else {
            if ($mail->status == 0) {
                echo '<div class="alert alert-info"> <button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-info-sign"></i><strong>Hello!</strong> This <a href="#" class="alert-link">Your request is in process now</a>, we will contact you soon. </div>';
            } else if ($mail->status == 2) {
                echo '<div class="alert alert-info"> <button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-info-sign"></i><strong>Hello!</strong> This <a href="#" class="alert-link">You have reject to use karibuSMS to send emails to your clients. If you want to easily send emails to your clients, click here to appy </a>. <br/>'
                . '<a href="#email_request" onclick="call_page(\'email_request\')" class="btn btn-default btn-xs"><i class="fa fa-mail-reply text-muted"></i>Click Request Email account</a> </div>';
            } else if ($mail->status == 3) {
                return view('message.email');
            } else {

                $offset = 0;
                $skip = $offset * 10;
                $sms = DB::select("SELECT * from message WHERE "
                                . "client_id='" . $this->client_id . "' ORDER BY time DESC OFFSET {$skip} LIMIT 10");
                if ($offset == 0) {
                    $return = view('message.mail_account')->with(array('sms' => $sms, 'gcm_id' => $this->gcmId()));
                } else {
                    $return = $this->loadMoreSms($sms);
                }
                return $return;
            }
        }
    }

    public function send_email_view() {
        $username = DB::table('client')->where('client_id', $this->client_id)->value('username');
        return view('message.send_email')->with(array('gcm_id' => $this->gcmId(), 'username' => $username));
    }

    public function request_mail() {
        DB::table('request_mail')->insert(
                [
                    'client_id' => $this->client_id,
                    'status' => 0
                ]
        );
        echo '<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-ok-sign"></i><strong>Well done!</strong> You application has been received.<a href="#" class="alert-link"> You will be contacted soon</a>. </div>';
    }

    public function reject_mail() {
        DB::table('request_mail')->insert(
                [
                    'client_id' => $this->client_id,
                    'status' => 2
                ]
        );
        echo '<div class="alert alert-warning alert-block"> <button type="button" class="close" data-dismiss="alert">×</button> <h4><i class="fa fa-bell-alt"></i>Thanks !</h4> <p>We have received your feedback</p> </div>';
    }

    public function deleteMessage($message_id) {
        return DB::table('message')
                        ->where('message_id', $message_id)
                        ->where('client_id', $this->client_id)->delete();
    }

    public function resendSms($message_id) {
        $numbers = DB::select("SELECT phone_number FROM pending_sms WHERE message_id='{$message_id}'");
        $message_content = DB::table('message')->where('message_id', $message_id)->first();
        $this->saveSms($message_content->content, $numbers, $message_content->messaging_type);
        return 1;
    }

    public function receivedSms($sms_id = NULL) {
        return view('message.received_sms');
    }

}
