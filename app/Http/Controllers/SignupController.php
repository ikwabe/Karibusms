<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class SignupController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	//
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
	//
    }

    public function addPayment($client_id) {
//	$data = array(
//	    'client_id' => $client_id,
//	    'method' => 'registration',
//	    'amount' => 100,
//	    'transaction_code' => 'NULL',
//	    'approved' => 1,
//	    'payment_per_sms' => 1,
//	    'currency' => 'TZS',
//	    'cost_per_sms' => 20,
//	    'sms_provided' => 5,
//	    'confirmed' => 1
//	);
//	DB::table('payment')->insertGetId($data, "payment_id");
    }

    public function validateSignupData($data) {

	foreach ($data as $key => $value) {
	    if ($value == '') {
		die(json_encode(array(
		    'status' => 'warning',
		    'message' => 'Sorry !, ' . ucfirst(str_replace('_', ' ', $key)) . ' cannot be empty'
		)));
	    }
	    if ($key == 'password' && strlen($value) < 6) {
		die(json_encode(array(
		    'status' => 'warning',
		    'message' => 'Sorry !, Password length should have at least SIX characters'
		)));
	    }
	    if ($key == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
		die(json_encode(array(
		    'status' => 'warning',
		    'message' => 'Sorry !, Email seems not to be valid. Please enter a valid email address'
		)));
	    }
	    if ($key == 'name' && preg_match('/[^a-zA-Z0-9 ]/i', $data['name'])) {
		die(json_encode(array(
		    'status' => 'warning',
		    'message' => 'Sorry !, Invalid characters in a name. Please enter letters and numbers only'
		)));
	    }
	    if ($key == 'phone_number' || $key == 'phonenumber') {
		$number = validate_phone_number($data['phone_number']);
		if (!is_array($number)) {
		    die(json_encode(array(
			'status' => 'warning',
			'message' => 'Sorry !, Phone number seems to be invalid, please enter it correctly'
		    )));
		}
	    }
	}
	$user = $this->checkAvailableData($data['name'], $number[1]);

	if (!empty($user)) {
	    die(json_encode(array(
		'status' => 'warning',
		'message' => 'Sorry !, Phone Number or Name is already registered in karibuSMS. Please use other one'
	    )));
	}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
	$data = array();
	parse_str($request['datastring'], $data);
	$this->validateSignupData($data);

	$password = sha1(md5(sha1($data['password'])));
	$codes = rand(1, 999999);
	$number = validate_phone_number($data['phone_number']);
	$token = rand(time(), date('Y'));
	$username = preg_replace("/[^A-Za-z0-9 ]/", '', $data['name']);
	$limit = substr($username, 0, 10);
	$client_id = DB::table('client')->insertGetId(
		[
	    'name' => $data['name'],
	    'username' =>$limit,
	    'phone_number' => $number[1],
	    'phone_verification_code' => $codes,
	    'email' => $data['email'],
	    'email_token' => '_' . $token,
	    'password' => $password,
	    'country' => $number[0],
	    'register_by' => 'Website',
	    'type' => $data['type']
		], 'client_id'
	);
	$this->addPayment($client_id);
	$subject = 'Welcome to karibuSMS';
	$message = 'Verify your email account. click a link below'
		. '<br/>'
		. '' . url('/') . '/verify/?token=_' . $token;
	$this->sendEmail($data['email'], $subject, $message);

	die(json_encode(array(
	    'status' => 'success',
	    'message' => 'Successfully registered. Check your email after short time to activate account. 5 FREE SMS has been added to your account'
	)));
    }

    public function checkAvailableData($name, $phone_number) {
	return $users = DB::table('client')
		->where('name', $name)
		->orWhere('phone_number', $phone_number)
		->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL) {
	//
	return view('signup.' . request()->route()->uri());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
	//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
	//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
	//
    }

    public function addUsername() {
	$username = $_GET['username'];
	$bad_worlds = array('kikwete', 'mkapa', 'serikali', 'polisi', 'mahakama');
	$error = '<div class="alert alert-danger"> '
		. '<button type="button" class="close" data-dismiss="alert">×</button> '
		. '<i class="fa fa-ban-circle"></i><strong>Error!</strong> '
		. '<a href="#" class="alert-link">';
	$business_info = business::find_where("username='" . $username . "'");
	if (!empty($business_info)) {
	    echo $error . 'this username is in use. Try another one</a> </div>';
	    exit();
	} else if (strlen($username) < 3) {
	    echo $error . ' use at least 3 characters </a> </div>';
	    exit();
	} else if (in_array(strtolower($username), $bad_worlds)) {
	    echo $error . 'this name ' . $username . ' is not allowed</a> </div>';
	    exit();
	} else {
	    $db->update('business', array('username' => $username), "id='" . $ses_user->id . "'");
	    echo '<div class="alert alert-success">'
	    . ' <button type="button" class="close" data-dismiss="alert">×</button> '
	    . '<i class="fa fa-ok-sign"></i><strong>Well done!</strong> '
	    . 'Username has been taken successful.'
	    . ' </div><br/></br/>'
	    . '<button class="btn-success" data-dismiss="modal">Click to close</button> ';
	}
    }

    public function verifyPhoneNumber() {

	$business_info = client::find_where("phone_verification_code='" . $this->codes . "'");
	if (!empty($business_info)) {
	    $this->business = array_shift($business_info);

	    $data = array(
		'phone_number_valid' => 1
	    );
	    $db->update('client', $data, array("id" => $this->business->id));
	    $this->set_session();
	} else {
	    echo 'Codes are invalid, please enter correct codes';
	    exit();
	}
    }

    public function verifyEmail() {

	$token = request('token');
	$client = DB::table('client')->where('email_token', $token)->first();
	if (!empty($client)) {
	    DB::table('client')->where('client_id', $client->client_id)->update(['email_valid' => 1]);
	    return view('signup.email_validated');
	} else {
	    echo 'Invalid parameters, please click a link correctly or copy and paste in a browser';
	    exit();
	}
    }

    public function resendCodes() {
	$phone_number = validate_phone_number($_GET['phone_number']);
	$codes = rand(1, 999999);
	$new_data = array(
	    'verification_code' => $codes,
	);
	$db->update('business', $new_data, "phone_number='" . $phone_number[1] . "'");

//lets send sms to validate phone number if is in use

	$verification_message = "Verification codes are: " . $codes;
	$return["posts"] = array();
	$post = array();
	$post["phonenumber"] = $phone_number[1];
	array_push($return["posts"], $post);
	$sms = array("Notice" => $verification_message, "server" => $return);
	$send = gcm::push_from_platform($sms);
	if ($send == TRUE) {
	    echo 'Enter codes you have just received in your phone now. It may take up to 5 minutes according to your network. If not receive, click the resend button again';
	} else {
	    echo 'Error occurs, please click a resend button again';
	}
    }

}
