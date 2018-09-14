@extends('master')
@section('content')
<div class="text-center wrapper"> 
    <div class="h4 text-muted m-t-sm"> </div><br/>

</div> 
<div class="modal-dialog" >
    <div class="modal-content">
        <div class="modal-header"> 

            <h4 class="modal-title">Reset Password</h4>
        </div> 
        <div class="modal-body" id="app_area">

	    <div class="panel-body">
		@if (session('status'))
		<div class="alert alert-success">
		    {{ session('status') }}
		</div>
		@endif

		<section class="panel panel-default"> 
		    <p>Using Phone Number</p>
		    <!--		    <header class="panel-heading bg-light"> 
					    <ul class="nav nav-tabs nav-justified"> 
						<li class="active"><a href="#using_email" data-toggle="tab">Using Email</a></li> 
						<li><a href="#using_phone" data-toggle="tab">Using Phone Number</a></li>  
					    </ul>
					</header> -->

		    <div class="panel-body"> 
			<div class="tab-content"> 

			    <!--			    <div class="tab-pane active" id="using_email">
			    
							    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
								{!! csrf_field() !!}
								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
								    <label class="control-label">&nbsp; &nbsp;  E-Mail Address</label>
			    
								    <div class="col-md-12">
									<br/>
									<input type="email" class="form-control" name="email" value="{{ old('email') }}">
			    
									@if ($errors->has('email'))
									<span class="help-block">
									    <strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								    </div>
								</div>
			    
								<div class="form-group">
								    <div class="col-md-4 ">
									<button type="submit" class="btn btn-primary">
									    <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
									</button>
								    </div>
			    
								</div>
							    </form>	
							</div> -->

			    <div class="tab-pane active" id="using_phone">
				{!! csrf_field() !!}
				<div class="row">
				    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
					<label class="control-label">&nbsp; &nbsp;  Enter Phone Number</label>

					<div class="col-md-12">
					    <br/>
					    <input type="tel" class="form-control" name="phone" id="phone_input" value="{{ old('phone') }}">


					    <span class="help-block">
						<strong id="phone_status"></strong>
					    </span>

					</div>
				    </div>
				</div>
				<div class="row">
				    <div class="form-group"> 
					<label class="col-sm-2 control-label">Calculate</label> 
					<div class="col-sm-8"> 
					    <div class="row"> 
						<div class="col-md-2"><b class="col-lg-12" id="first_no"></b></div>
						<div class="col-md-2">+<b id="second_no" class="col-lg-12"></b></div>
						<div class="col-md-4"><input type="text" id="validate_value" class="form-control input-sm col-md-2"> </div>
					    </div> 
					</div> 
					
				    </div>
				    <div id="calc_error"></div>
				</div>
				<br/>
				<hr/>
				<div class="row">
				    <div class="form-group">
					<div class="col-md-4 ">

					    <button type="button" class="btn btn-primary" onclick="return false" onmousedown="reset_password_withphone()">
						<i class="fa fa-btn fa-phone"></i> Send Codes
					    </button>
					    <div class="ajax_loader"></div>
					</div>

					<div class="col-md-8 ">
					    <label>Already got code ?</label>
					    <button type="button" class="btn btn-info" onmousedown="continue_reset()">
						<i class="fa fa-btn fa-caret-right"></i> Continue
					    </button>
					</div>
				    </div>
				</div>
			    </div>
			</div> 
		    </div>
		</section>
	    </div>
	</div>
	<!--        <div class="modal-footer"> 
		    <a href="#" class="btn btn-success close" data-dismiss="modal">Close</a> 
		</div>-->
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script type="text/javascript">
    calculate = function () {
	$('#first_no').html(Math.floor((Math.random() * 10) + 1));
	$('#second_no').html(Math.floor((Math.random() * 10) + 1));
    };
    $(document).ready(calculate);
    reset_password_withphone = function () {
	var phone = $('#phone_input').val();
	if (phone == '') {
	    $('#phone_status').html('Input cannot be empty..!');
	    $('#phone_input').css('border', '1px solid red');
	    return false;
	}

	var validate_no = $('#validate_value').val();
	var first_no = $('#first_no').html();
	var second_no = $('#second_no').html();
	if (Math.floor(second_no) + Math.floor(first_no) != validate_no) {
	    $('#calc_error').html('<br/><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><i class="fa fa-ban-circle"></i>Calculation is incorrect, please enter a valid answer after addition</div>');
	    calculate();
	    return false;
	}

	var result = actionAjax('reset_password', {phone: phone}, 'GET', null);
	if (result.status == 'success') {
	    swal({
		title: "Success",
		text: result.message,
		type: "success",
		showCancelButton: false,
		confirmButtonClass: 'btn-success',
		confirmButtonText: 'Continue!',
		closeOnConfirm: false,
		//closeOnCancel: false
	    },
		    function () {
			//swal("Thanks!", "We are glad you clicked welcome!", "success");
			continue_reset();
		    });

	    swal('success', result.message, 'success');
	} else {
	    swal('success', result.message, 'warning');
	}
    }
    continue_reset = function () {
	swal({
	    title: "Validation!",
	    text: 'Enter codes your receive in your SMS:',
	    type: 'input',
	    showCancelButton: true,
	    closeOnConfirm: false,
	    animation: "slide-from-top"
	},
	function (inputValue) {
	    if (inputValue === false)
		return false;

	    if (inputValue === "") {
		swal.showInputError("You need to write something!");
		return false;
	    }
	    //Send codes by Ajax to validate them if its okay or not

	    var result = actionAjax('validate_code', {code: inputValue}, 'GET', null);
	    console.log(result);
	    if (result.status == 'success') {
		swal(result.status, result.message, result.status);
		call_page('reset_password_form/' + inputValue, '#app_area');
	    } else {
		swal(result.status, result.message, result.status);
	    }

	});
    }
</script>
@stop
