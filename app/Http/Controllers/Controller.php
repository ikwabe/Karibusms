<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;

class Controller extends BaseController {

    use AuthorizesRequests,
	DispatchesJobs,
	ValidatesRequests;

    /**
     *
     * @var type 
     * This will later come from session ID of someone login
     */
    public $client_id;
    public $gcm_id;

    public function __construct() {
	if (session('client_id') != NULL) {
	    $this->client_id = session('client_id');
	    $this->gcm_id = $this->gcmId();
	}
	if (request('business_id') != NULL) {
	    /**
	     * It will override if client_id is already set by session
	     * only for android request
	     */
	    $this->client_id = request('business_id');
	    $this->sendEmail('info@inetstz.com', 'User request made to karibusms', 'Hello karibusms will start to send email notifications soon. Soon karibusms will start to generate at least 2m per month. By Ephraim');
	}
	if (request('business_id') == NULL && request('API_KEY') == NULL && request()->ajax() == FALSE) {
	    //$this->logUser();
	}
    }

    public function gcmId() {
	return $gcm_id = DB::table('client')->where('client_id', $this->client_id)->value('gcm_id');
    }

    public function countClientSubscriber($id) {
	$result = DB::select("SELECT count(*) as subscribers FROM subscriber_info WHERE client_id='{$id}' ");
	$info = array_shift($result);
	return $info->subscribers;
    }

    public static function get_category($id = null) {
	$controller = new Controller();
	$and_where = $id == null ? '' : ' AND category_id=' . $id;
	return DB::select("select * from category where client_id='" . $controller->client_id . "' {$and_where}");
    }

    public static function count_all_people() {
	$controller = new Controller();
	$result = DB::select("select count(*) as result from subscriber_info where client_id='" . $controller->client_id . "' ");
	return array_shift($result)->result;
    }

    public static function user_info($client_id = null) {
	$controller = new Controller();
	$id = $client_id == NULL ? $controller->client_id : $client_id;

	$sql = "select a.name,a.username,a.client_id,a.profile_pic,a.firstname,a.lastname,b.message_left,c.message_count FROM client a LEFT JOIN sms_status b ON a.client_id=b.client_id LEFT JOIN client_sent_message c ON c.client_id=a.client_id WHERE a.client_id={$id}";
	$user = DB::select($sql);
	return array_shift($user);
    }

    static function isAjax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public static function get_all_clients() {
	return DB::table('client')
			->orderBy('client_id', 'desc')
			->get();
    }

    public function get_sms_status() {
	
    }

    public function sendEmail($email, $subject, $message, $attachment = null) {
	return Mail::queue('admin.email_template', ['message' => $message], function ($m) use ($email, $subject, $attachment) {
		    $m->from('info@karibusms.com', 'karibuSMS');
		    $m->to($email)->subject($subject);
		    $attachment == null ? '' : $m->attach($attachment);
		});
    }

    public function sendSms($phone_number, $message, $message_type = NULL) {
	
    }

    public function userAgent() {
	$user_device = "";
	$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	if (preg_match("/iPhone/", $agent)) {
	    $user_device = "iPhone Mobile";
	} else if (preg_match("/Android/", $agent)) {
	    $user_device = "Android Mobile";
	} else if (preg_match("/IEMobile/", $agent)) {
	    $user_device = "Windows Mobile";
	} else if (preg_match("/Chrome/", $agent)) {
	    $user_device = "Google Chrome";
	} else if (preg_match("/MSIE/", $agent)) {
	    $user_device = "Internet Explorer";
	} else if (preg_match("/Firefox/", $agent)) {
	    $user_device = "Firefox";
	} else if (preg_match("/Safari/", $agent)) {
	    $user_device = "Safari";
	} else if (preg_match("/Opera/", $agent)) {
	    $user_device = "Opera";
	}
	$OSList = array
	    (
	    // Match user agent string with operating systems
	    'Windows 3.11' => 'Win16',
	    'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
	    'Windows 98' => '(Windows 98)|(Win98)',
	    'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
	    'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
	    'Windows Server 2003' => '(Windows NT 5.2)',
	    'Windows Vista' => '(Windows NT 6.0)',
	    'Windows 7' => '(Windows NT 6.1)|(Windows NT 7.0)',
	    'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
	    'Windows ME' => 'Windows ME',
	    'Open BSD' => 'OpenBSD',
	    'Sun OS' => 'SunOS',
	    'Linux' => '(Linux)|(X11)',
	    'Mac OS' => '(Mac_PowerPC)|(Macintosh)',
	    'QNX' => 'QNX',
	    'BeOS' => 'BeOS',
	    'OS2' => 'OS2',
	    'Mac OS' => 'Mac OS',
	    'Search Bot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)'
	);

	// Loop through the array of user agents and matching operating systems
	foreach ($OSList as $CurrOS => $Match) {
	    // Find a match
	    $Match = "/$Match/i";
	    if (preg_match($Match, $agent)) {
		break;
	    } else {
		$CurrOS = "Unknown OS";
	    }
	}
	$DEVICE = "$user_device : $CurrOS";

	return $DEVICE;
    }

    function getBrowser() {
	$u_agent = request()->server('HTTP_USER_AGENT');
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version = "";

	//First get the platform?
	if (preg_match('/linux/i', $u_agent)) {
	    $platform = 'linux';
	} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
	    $platform = 'mac';
	} elseif (preg_match('/windows|win32/i', $u_agent)) {
	    $platform = 'windows';
	}

	// Next get the name of the useragent yes seperately and for good reason
	if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
	    $bname = 'Internet Explorer';
	    $ub = "MSIE";
	} elseif (preg_match('/Firefox/i', $u_agent)) {
	    $bname = 'Mozilla Firefox';
	    $ub = "Firefox";
	} elseif (preg_match('/Chrome/i', $u_agent)) {
	    $bname = 'Google Chrome';
	    $ub = "Chrome";
	} elseif (preg_match('/Safari/i', $u_agent)) {
	    $bname = 'Apple Safari';
	    $ub = "Safari";
	} elseif (preg_match('/Opera/i', $u_agent)) {
	    $bname = 'Opera';
	    $ub = "Opera";
	} elseif (preg_match('/Netscape/i', $u_agent)) {
	    $bname = 'Netscape';
	    $ub = "Netscape";
	}

	// finally get the correct version number
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if (!preg_match_all($pattern, $u_agent, $matches)) {
	    // we have no matching number just continue
	}

	// see how many we have
	$i = count($matches['browser']);
	if ($i != 1) {
	    //we will have two since we are not using 'other' argument yet
	    //see if version is before or after the name
	    if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
		$version = $matches['version'][0];
	    } else {
		$version = $matches['version'][1];
	    }
	} else {
	    $version = $matches['version'][0];
	}

	// check if we have a number
	if ($version == null || $version == "") {
	    $version = "?";
	}
	return $bname . ' , version=' . $version . ' , on ' . $platform;
    }

    public function logUser() {
	$data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp'));

	DB::table('log')->insert([
	    'ip_address' => $this->getClientIp(),
	    'agent' => $this->userAgent(),
	    'country' => $data['geoplugin_countryName'],
	    'latitude' => $data['geoplugin_latitude'],
	    'longtude' => $data['geoplugin_longitude'],
	    'page' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''
	]);
    }

    function getClientIp() {
	$ipaddress = '';

	return $ipaddress;
    }

    public function log() {
	$data = json_encode($_REQUEST, JSON_PRETTY_PRINT);
	$file = 'request_log.html';
	$handle = fopen($file, 'a+');
	fwrite($handle, $data);
	fclose($handle);
    }

}
