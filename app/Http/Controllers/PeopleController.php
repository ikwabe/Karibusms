<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use DB;
use Excel;

class PeopleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null) {
        /**
         * in the first phase, we keep it very very simple, unless user need it
         * we will do it, otherwise not
         */
        $this->client_id = session('client_id');
        //get all people belong to this client by group or category
        $people = $this->getPeople(decryptApp($type));
        return view('people.show_all')->with(array('people' => $people, 'type' => decryptApp($type)));
    }

    private function getPersonalInfo($subscriber_id) {
        $this->client_id = session('client_id');
        return DB::table('subscriber_info')
                        ->where('client_id', $this->client_id)
                        ->where('subscriber_info_id', $subscriber_id)->first();
    }

    public function getPeople($type) {
        $this->client_id = session('client_id');
        $where = $type == 'all' ? '' : " AND b.category_id='" . $type . "'";
        $sql = "SELECT b.title, b.category_id, c.name as category, b.firstname,b.lastname, b.phone_number,b.email, b.subscriber_info_id, b.regtime, b.accept_sms, b.organization_name  
         FROM subscriber_info b 
         left JOIN category c ON b.category_id=c.category_id
         where b.client_id='" . $this->client_id . "' $where";
        return DB::select($sql);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        $this->client_id = session('client_id');
        $user = DB::table('client')->where('client_id', $this->client_id)->first();
        return view('people.create', compact('user'));
    }

    private function validatePhone($phone) {
        $number = validate_phone_number($phone);
        $phone_number = (is_array($number)) ? $number[1] :
                die(json_encode(['status' => 'warning', 'message' => 'Phone number ' . $phone . ' is not valid']));
        return $phone_number;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        /**
         * This should be the trend
         * 1. check that category to get category ID
         * 2. check in subscriber table to get ID
         * 3. Insert in subscriber_info refer subscriber ID and cateogory ID you have
         * 4. insert into subscription to know which subscriber
         */
        /**
         * check if category exist or not
         */
        return $this->addSubscriberInfo($request);
    }

    public function addSubscriberInfo($request) {
        $this->client_id = session('client_id');
        $cat = DB::table('category')
                ->where(['name' => $request['category'], 'client_id' => $this->client_id])
                ->first();

        if (empty($cat)) {
            $category_id = $request['category'] != '' ? DB::table('category')->insertGetId(
                            ['name' => $request['category'], 'client_id' => $this->client_id], 'category_id'
                    ) : NULL;
        } else {
            $category_id = $cat->category_id;
        }

        /**
         * Check subscriber ID, phone number
         */
        $phone_number = $this->validatePhone(str_replace(' ', '', $request['phone_number']));
        if (!empty($request['email'])) {

            $email = filter_var($request['email'], FILTER_VALIDATE_EMAIL) ?
                    $request['email'] :
                    die(json_encode(['status' => 'warning', 'message' => 'Email ' . $request['email'] . ' is not valid']));
        } else {
            $email = NULL;
        }
        //check in subscriber_info if there are duplicates otherwise insert new records
        $info = DB::table('subscriber_info')
                ->where('client_id', $this->client_id)
                ->where('phone_number', $phone_number);
        $data = [
            'client_id' => $this->client_id,
            'title' => !empty($request['title']) ? $request['title'] : '',
            'firstname' => !empty($request['firstname']) ? $request['firstname'] : '',
            'lastname' => !empty($request['lastname']) ? $request['lastname'] : '',
            'imei' => !empty($request['imei']) ? $request['imei'] : '',
            'phone_number' => $phone_number,
            'other_phone_number' => !empty($request['other_phone_number']) ? $request['other_phone_number'] : '',
            'email' => $email,
            'country' => !empty($request['country']) ? $request['country'] : '',
            'added_by' => !empty($request['added_by']) ? $request['added_by'] : '',
            'category_id' => $category_id,
            'organization_name' => !empty($request['organization_name']) ? $request['organization_name'] : '',
            'promise' => !empty($request['promise']) ? $request['promise'] : '',
            'promise_submitted' => !empty($request['promise_submitted']) ? $request['promise_submitted'] : '',
            'organization_position' => !empty($request['organization_position']) ? $request['organization_position'] : '',
            'organization_description' => !empty($request['organization_description']) ? $request['organization_description'] : ''
        ];
        if (count($info->first())==0) {
            DB::table('subscriber_info')->insertGetId(
                    $data, 'subscriber_info_id'
            );
            $return = json_encode(['status' => 'success',
                'message' => 'Contacts information added successfully','page'=>'#people/all']);

            if (!empty($request['notify']) && $request['notify'] == 'on') {
                //send notification messsage to this user
                $message = new MessageController();
                $message->sendSmsByNumbers($request['notify_sms'], $phone_number, $request['message_type']);
            }
        } else {
            //update this user
            $info->update($data);
            $return = json_encode(['status' => 'success',
                'message' => 'Contacts information exist. Information updated successfully']);
        }
        return $return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null) {
        //
        $person = $this->getPersonalInfo(decryptApp($id));
        return view('people.show_one')->with(array('person' => $person));
    }

    public function customer() {
        $subscriptions['subscriptions'] = DB::table('subscription')->get();
        return view('customer.customer', $subscriptions);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function load_address() {
        //
        $this->client_id = session('client_id');
        $people = DB::select("SELECT b.client_id,b.accept_sms, b.subscriber_info_id as subscriber_id, b.firstname,b.lastname,  b.phone_number,b.email FROM  subscriber_info b  WHERE b.client_id='" . $this->client_id . "'");
        return view('people.address', compact('people'));
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
        /**
         * when someone update phone number and email we must handle this case 
         * very differently.
         * we need to save this in subscriber table but first check if it exist
         * then we need to set null subscriber id available in sub info
         * 
         * This method is used
         * 1. to update subscriber information  #view/{$}
         * 2. Update client information #client_settings
         */
        $this->client_id = session('client_id');
        if (isset($request['tag'])) {
            if ($request['tag'] == 'phone_number') {

                $new_value = $this->checkPhoneNumber($request['new_value']);
            } else if ($request['tag'] == 'email') {
                $new_value = $this->checkEmail($request['new_value']);
            } else if ($request['tag'] == 'username') {
                $new_value = str_limit($request['new_value'], 11, NULL);
            } else if ($request['tag'] == 'category_id') {
                $category_info = Controller::get_category($request['new_value']);
                $category = array_shift($category_info);
                $category_name = $category->name;
                $new_value = $category->category_id;
            } else {
                $new_value = $request['new_value'];
            }

            if (isset($request['client'])) {
                DB::table('client')
                        ->where('client_id', $id)
                        ->update([$request['tag'] => $new_value]);
            } else {
                DB::table('subscriber_info')
                        ->where('subscriber_info_id', $id)
                        ->where('client_id', $this->client_id)
                        ->update([$request['tag'] => $new_value]);
            }
            echo $request['tag'] == 'category_id' ? $category_name : $new_value;
        }
    }

    public function updateCategory($id) {
        DB::table('category')
                ->where('category_id', $id)
                ->update(['name' => request('name')]);
        echo request('name');
    }

    public function addCategory() {
        $this->client_id = session('client_id');
        return DB::table('category')->insertGetId(
                        [
                    'name' => request('name'),
                    'client_id' => $this->client_id
                        ], 'category_id'
        );
    }

    public function checkPhoneNumber($phone_number) {
        $phone = validate_phone_number($phone_number);
        if (is_array($phone)) {
            $new_value = $phone[1];
        } else {
            die("<span class='alert alert-danger'>This phone number is not valid</span>");
        }
        //check in DB if it exists
        $check_number = DB::table('client')->where('phone_number', $new_value)->first();
        if (!empty($check_number)) {
            die("<span class='alert alert-danger'>This phone number already exist</span>");
        } else {
            return $new_value;
        }
    }

    public function checkEmail($email) {
        $new_value = !filter_var($email, FILTER_VALIDATE_EMAIL) ?
                die("<span class='alert alert-danger'>Email is not valid</span>") :
                $email;
        //check in DB if it exists
        $check = DB::table('client')->where('email', $new_value)->first();
        if (!empty($check)) {
            die("<span class='alert alert-danger'>This email already exist</span>");
        } else {
            return $new_value;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->client_id = session('client_id');
        if (request('type') == 'category') {
            DB::table('category')
                    ->where('category_id', $id)
                    ->where('client_id', $this->client_id)->delete();
        } else {
            DB::table('subscriber_info')
                    ->where('subscriber_info_id', $id)
                    ->where('client_id', $this->client_id)->delete();
        }
        return json_encode(array(
            'status' => 'success',
            'message' => 'Record deleted successfully'
        ));
    }

    public function settings($page = null) {
        $this->client_id = session('client_id');
        $client_id = $this->client_id;
        if ($page == 'password') {
            $user_info = array();
            $view = 'password_change';
        } else if ($page == 'category') {
            $user_info = array();
            $view = 'user_category';
        } else if ($page == 'photo') {
            $user_info = DB::table('client')->where('client_id', $this->client_id)->first();
            $view = 'change_photo';
        } else if ($page == 'uploaded_files') {
            $file = new FileController();
            $user_info = $file->getUserFiles();
            $view = 'uploaded_files';
        } else {
            $user_info = DB::table('client')->where('client_id', $this->client_id)->first();
            $view = 'settings';
        }
        return view('people.' . $view, compact('user_info', 'client_id'));
    }

    public function changePhoto() {
        $this->client_id = session('client_id');
        $file = new FileController();
        $file->storage_path = 'media/images/business/' . $this->client_id . '/';
        $file->upload('file');

        $data = DB::table('client')->where('client_id', $this->client_id)->update(['profile_pic' => $file->name]);
        if ($data == 1) {
            return json_encode(array(
                'status' => 'success',
                'message' => 'Image uploaded successfully. Refresh your browser to see changes'
            ));
        } else {
            return json_encode(array(
                'status' => 'warning',
                'message' => 'Image remain, not updated, please try again later'
            ));
        }
    }

    public function changePassword() {
        //check posted password
        $data = array(
            'current_password' => request('pas'),
            'new_password' => request('pas1'),
            'confirmed_password' => request('pas2')
        );
        $this->client_id = session('client_id');
        foreach ($data as $key => $value) {
            if ($value == '') {
                die(json_encode(array(
                    'status' => 'warning',
                    'message' => 'Sorry !, ' . ucfirst(str_replace('_', ' ', $key)) . ' cannot be empty'
                )));
            } elseif (strlen($value) < 6) {
                die(json_encode(array(
                    'status' => 'warning',
                    'message' => 'Sorry !, Password length should have at least SIX characters'
                )));
            }
        }
        $password = sha1(md5(sha1(request('pas'))));
        $check = DB::table('client')->where('password', $password)
                ->where('client_id', $this->client_id)
                ->first();
        if (empty($check)) {
            die(json_encode(array(
                'status' => 'warning',
                'message' => 'Sorry !, Current password is not valid'
            )));
        }
        if (request('pas1') != request('pas2')) {
            die(json_encode(array(
                'status' => 'warning',
                'message' => 'Sorry !, New password do not match'
            )));
        }
        $new_password = sha1(md5(sha1(request('pas1'))));
        DB::table('client')
                ->where('client_id', $this->client_id)
                ->update(['password' => $new_password]);
        die(json_encode(array(
            'status' => 'success',
            'message' => ' New password has been changed successfully'
        )));
    }

    public function profile($client_id = null) {
        $id = $client_id == NULL ? session('client_id') : $client_id;
        $messages = DB::table('message')->where('client_id', $id)->get();
        $client = DB::table('client')->where('client_id', $id)->first();

        $view = $client_id == NULL ? 'profile' : 'nosession_profile';
        return view('people.' . $view, compact('messages', 'client', 'client_id'));
    }

    public function uploadByExcel() {
        return view('people.upload_excel');
    }

    public function submitExcel() {
        $this->client_id = session('client_id');
        $file = new FileController();
        $file->storage_path = 'media/images/business/' . $this->client_id . '/';
        $file->upload('excel_file');
        $data = $file->loadExcel($file->storage_path . $file->name);
        $this->checkExcelKeys($data);
        foreach ($data as $key => $value) {
            !empty($value['phone_number']) ?
                            $data = $this->addSubscriberInfo($value) : '';
        }
        if (json_decode($data)->status == 'success') {
            return json_encode(array(
                'status' => 'success',
                'message' => 'File uploaded successfully'
            ));
        }
    }

    public function checkExcelKeys($data) {
        foreach ($data as $key => $value) {
            if (!array_key_exists('phone_number', $value)) {
                die(json_encode(array(
                    'status' => 'warning',
                    'message' => 'phone_number column is not available in File. Please rename a column with phone number to phone_number'
                )));
                return false;
            } else if (!array_key_exists('category', $value)) {
                die(json_encode(array(
                    'status' => 'warning',
                    'message' => 'category column is not available in File. Please rename a column with category/group to category'
                )));
            }
        }
    }

    public function download() {
        $this->client_id = session('client_id');
        Excel::create('karibuSMS Excel', function($excel) {

            $excel->sheet('Excel sheet', function($sheet) {

                $sheet->setOrientation('landscape');
                $data = DB::table('subscriber_info')->where('client_id', $this->client_id)->get();
                $result = collect($data)->map(function($x) {
                            return (array) $x;
                        })->toArray();
                $sheet->fromArray($result);
            });
        })->export('xls');
    }

}
