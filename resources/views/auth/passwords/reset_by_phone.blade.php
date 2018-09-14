<?php
/**
 * Description of reset_by_phone
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<p style="text-align: center; margin-bottom: 3em;">
    <span id="reset_by_phone_result"></span>
    <div class="ajax_loader"></div>
</p>
<form class="form-horizontal" id="reset_by_phone_form" role="form" method="POST" onsubmit="return false">
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	<label class="col-md-4 control-label">Password</label>

	<div class="col-md-6">
	    <input type="password" class="form-control" name="password">

	    @if ($errors->has('password'))
	    <span class="help-block">
		<strong>{{ $errors->first('password') }}</strong>
	    </span>
	    @endif
	</div>
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	<label class="col-md-4 control-label">Confirm Password</label>
	<div class="col-md-6">
	    <input type="password" class="form-control" name="password_confirmation">

	    @if ($errors->has('password_confirmation'))
	    <span class="help-block">
		<strong>{{ $errors->first('password_confirmation') }}</strong>
	    </span>
	    @endif
	</div>
    </div>

    <div class="form-group">
	<div class="col-md-6 col-md-offset-4">
	    <button type="submit" class="btn btn-primary" onmousedown="reset_password()">
		<i class="fa fa-btn fa-refresh"></i>Reset Password
	    </button>
	</div>
    </div>
</form>
<script type="text/javascript">
reset_password=function(){
    var result=actionAjax('reset_password_form_submit',{
	data:$('#reset_by_phone_form').serialize()
    },'POST');
    $('#reset_by_phone_result').html(result.message).addClass('alert alert-'+result.status);
    console.log(result);
}
</script>