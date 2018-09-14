<?php
/**
 *   karibu.com
 * * @author Ephraim Swilla <swillae1@gmail.com>
 */
?>
@extends('master')
@section('content')
<div class="container aside-xxl" id="register">
    <a class="navbar-brand block text-success" href="<?= url('/')  ?>">KaribuSMS</a>
    <section class="panel panel-default m-t-lg bg-white"> 
        <header class="panel-heading text-center"> <strong>Sign up</strong> </header>
        <form class="panel-body wrapper-lg" id="signup_form"> 
            <div class="form-group"> <label class="control-label">Name</label>
                <input type="text" name="name" placeholder="ie. Your personal/business name" class="form-control input-lg">
            </div> 
            <div class="form-group"> 
                <label class="control-label">Email</label> 
                <input type="text" name="email" placeholder="e.g name@example.com" class="form-control input-lg">
            </div>
            <div class="form-group"> 
                <label class="control-label">phone number</label> 
                <input type="text" name="phone_number" placeholder=" XYZ ZZZ XXX" class="form-control input-lg">
            </div>
	    <div class="form-group"> 
                <label class="control-label">Your Type</label> 
                <select class="form-control input-lg" name="type">
		    <option></option>
		    <option value="Individual">Individual</option>
		    <option value="Private Company">Private Company</option>
		    <option value="Normal Business">Normal Business</option>
		    <option value="Government Institution">Government Institution</option>
		    <option value="Non Government Organization (NGO)">Non Government Organization (NGO)</option>
		    <option value="church">Church</option>
		    <option value="Others">Others</option>
		</select>
            </div>
            <div class="form-group"> 
                <label class="control-label">password</label> 
                <input type="password" name="password" id="inputPassword" placeholder="password" class="form-control input-lg"> 
		<span id="password_status"></span>
            </div> 
            <div class="checkbox"> 
                <label>By clicking signup, you agree to our <a href="<?= url('/') ?>/privacy">terms and policy</a> </label> 
            </div> 
            <button type="button" class="btn btn-primary" id="signup">Sign up</button> 
            <div id="ajax_results"></div>
            <div class="line line-dashed"></div> 
            <p class="text-muted text-center"><small>Already have an account?</small></p> 
            <a href="<?= url('/')  ?>" class="btn btn-default btn-block">Sign in</a>
            <p align="center" class="text-success"><br/><a href="<?= url('/') ?>/features" >Learn about karibuSMS here</a></p>

        </form>
    </section> 
</div>
@stop
@section('footer')
<script>
    register_business = function () {
	$('#signup').click(function () {
	    var datastring = $('#signup_form').serialize();
	    var p='#ajax_results';
	    $(p).html(LOADER);
	    $.getJSON('signup/store',
		    {
			datastring: datastring
		    }, function (data) {
			console.log(data);
		swal(data.status,data.message,data.status); 
		$(p).html('');		
	    }).error(function (data) {
		swal('warning','Sorry, we are temporarly not available. We will come back after few min. For info call +255 655 406 004','warning');
		 $(p).html('');
	    });
	   
	});
    };
    jQuery(document).ready(register_business);
</script>
@stop