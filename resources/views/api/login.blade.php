<?php
/**
 * Description of login
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>

<div class="modal-dialog" >
    <div class="modal-content">
        <div class="modal-header"> 
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
            <h4 class="modal-title">Login to Create your karibuSMS app</h4>
        </div> 
        <div class="modal-body" id="app_area"> 
	    <div id="ajax_status_result"></div>
	    <form class="panel-body wrapper-lg" id="signin_form"> 
		<div class="form-group"> 
		    @if ($errors->has('email'))
		    <span class="alert alert-danger">
			<strong>{{ $errors->first('email') }}</strong>
		    </span>
		    @endif
		    @if (session('status'))
		    <div class="alert alert-success">
			{{ session('status') }}
		    </div>
		    @endif
		</div>
		<div class="form-group"> 
		    <label class="control-label">Email Or Phone number</label> 
		    <input type="text" name="phone_number" id="phone" required="required" placeholder="0XXX XYZ XYZ" class="form-control input-lg"> 
		</div> 
		<div class="form-group">
		    <label class="control-label">Password</label>
		    <input type="password" name="password" id="inputPassword" required="required" placeholder="Password" class="form-control input-lg">
		</div> 
		<!--                                <div class="checkbox"> 
						    <label> <input type="radio" name="service" checked="checked" value="karibuSMS"> Sign in to karibuSMS </label> 
						    <label><BR/> <input type="radio" name="service" checked="checked" value="pesaSMS"> Sign in to PesaSMS </label> 
						</div> -->
		<div class="checkbox"> 
		    <label> <input type="checkbox" name="checkbox" checked="checked"> Keep me sign in </label> 
		</div> 
		<button type="button" class="btn btn-primary" onclick="signin();">Sign in</button> 
		<div id="login_ajax_request"></div>
		<div class="line line-dashed"></div>	  
	    </form> 

        </div>
        <div class="modal-footer"> 
            <a href="#" class="btn btn-success close"  data-dismiss="modal">close</a> 
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script type="text/javascript">
    signin = function () {
	if ($('#inputPassword').val == '' || $('#phone').val() == '') {
	    $('#login_ajax_request').html('<br/><div class="alert alert-danger">\n\
                                   <button type="button" class="close" data-dismiss="alert">×</button>\n\
                                   <i class="fa fa-ban-circle"></i> Fill all fields</div>');
	    return false;
	}
	var datastring = $('#signin_form').serialize();
	$('#login_ajax_request').html(LOADER);
	$.getJSON('<?=url('/')?>/login/store', {datastring: datastring}, function (data) {
	    console.log(data);
	    if (data.error == 0) {
		window.location.reload();
	    } else {
		swal('warning', 'Wrong phone number or password', 'warning');
		$('#login_ajax_request').html('');
	    }
	}).error(function (data) {
	    console.log(data);
	});
    };
    function dismis() {
	window.location.reload();
    }
   // $(document).ready(create_app);
</script>