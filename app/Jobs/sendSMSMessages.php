<?php
namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class sendSMSMessages extends Job implements ShouldQueue {
    /*
      |--------------------------------------------------------------------------
      | Queueable Jobs Sending SMS
      |--------------------------------------------------------------------------
      |
      | This job is highly useful in sending SMS
      |
     */

use InteractsWithQueue,
    SerializesModels;

    protected $message_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message_id) {
	//
	$this->message_id = $message_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() { 
	$messages = DB::select("SELECT a.content, a.phone_number,a.from_smart, a.pending_sms_id, a.username,b.gcm_id FROM pending_sms a JOIN client b ON a.client_id=b.client_id WHERE a.status='0' AND a.message_id='{$this->message_id}'");

	foreach ($messages as $message) {
	    if ($message->from_smart == 0) {
		$sender = new \SmsSender();
		$sender->set_phone_number($message->phone_number);
		$sender->set_message($message->content);
		$sender->set_from_name($message->username);
		$status = (object) json_decode($sender->send());
		$delivered = $status->code == '1701' ? 'success' : 'pending';
		$return_sms = $status->code .' | '.$status->message;
	    } else {
		$status = \Gcm::send($message->content, $message->phone_number, $message->username, $message->gcm_id);
		$delivered = $status->success == 1 ? 'success' : 'pending';
		$return_sms = '';
	    }
	    DB::table('pending_sms')
		    ->where('pending_sms_id', $message->pending_sms_id)
		    ->update(
			    [
				'status' => $status->success,
				'delivered_status' => $delivered,
				'return_message' => $return_sms
			    ]
	    );
	}
    }

}
