<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,
    Redirect,
    Response,
    File;
use Socialite;
use App\User;

class SocialController extends Controller {

    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider) {
        $getInfo = Socialite::driver($provider)->user();
        $this->createUser($getInfo, $provider);
        // auth()->login($user);
        return redirect()->to('/');
    }

    function createUser($getInfo, $provider) {

        $users = DB::table('client')
                ->where('email', $getInfo->email)
                ->first();
        if (count($users) == 0) {
            $users = $this->store($getInfo, $provider);
        }
        $this->createLoginUser($users);

        return redirect('/')->with('success', 'success');
    }

    public function createLoginUser($user) {
        session(['client_id' => $user->client_id]);
        session(['username' => $user->username]);
        return (new \App\Http\Controllers\LoginController())->storeLoginInformation($user->client_id);
    }

    public function store($getInfo, $provider) {
        $password = sha1(md5(sha1(time())));
        $codes = rand(1, 999999);
        $token = rand(time(), date('Y'));
        $username = preg_replace("/[^A-Za-z0-9 ]/", '', $getInfo->name);
        $limit = substr($username, 0, 10);
        $client_id = DB::table('client')->insertGetId(
                [
            'name' => $getInfo->name,
            'username' => $limit,
            'phone_number' => time(),
            'phone_verification_code' => $codes,
            'email' => $getInfo->email,
            'email_token' => '_' . $token,
            'password' => $password,
            'country' => '',
            'register_by' => $provider,
            'type' => ''
                ], 'client_id'
        );
        $subject = 'Welcome to karibuSMS';
        $message = 'Verify your email account. click a link below'
                . '<br/>'
                . '' . url('/') . '/verify/?token=_' . $token;
        $this->sendEmail($getInfo->email, $subject, $message);
        return DB::table('client')->where('client_id', $client_id)->first();
    }

}
