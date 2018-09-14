<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {

	if (Auth::guard($guard)->check()) {
	    return redirect('/');
	}
	//dd($request->route()->uri());
	$exception = array(
	    'api_login', 
	    'signup/store',
	    'validate_code',
	    'login/store', 
	    'reset_password',
	    'password/{_missing}',
	    'reset_password_form_submit',
	    'reset_password_form',
	    'password/reset_password_form',
	    'password/reset_password_form/{code}',
	    'contact_us_submit',
	    'search',
	    "search/{report}",
	    "api/{page}",
	    'subscribe/{type}',
	    '{page?}',
	);
	if (session('client_id') == NULL && $request->ajax() == TRUE && !in_array($request->route()->uri(),$exception)) {
	    echo '<script type="text/javascript"> '
	    . 'window.location.href="' . url('/') . '";'
	    . '; </script>';
	    exit;
	}

	return $next($request);
    }

}
