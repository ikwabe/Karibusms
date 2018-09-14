<?php
/**
 * Description of notification
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
$admin = TRUE;
$username = 'karibuSMS';
$phone_number = isset($_GET['phone_number']) ? $_GET['phone_number'] : '';
$sender_name_description = 'This is your username and is the name which people who will receive SMS will see in their phones as from address. To change this, go to settings page and change your username.';
?>
<section class="panel panel-default"> 
    <header class="panel-heading font-bold">Sending Notifications

    </header>

    <div class="panel-body">
	<form class="bs-example form-horizontal">
	    <div class="form-group"> 
		<small>
		    <b>
	This message you send will be sent to all business
		    </b>
		</small>
	    </div>
	    <div id="ajax_sms_result"></div>
	    <?php if ($phone_number == '') { ?>
    	    <div class="form-group"> 
    		<label class="col-lg-2 control-label">Send to</label> 
    		<div class="row"> 
    		    <div class="col-md-6"> 

    			<select name="category" id="category" class="form-control m-b">
    			    <!--<option value="0">All</option>-->
    			    <!--<option value="-1">Enter manually</option>-->

    			    <option  value="All">All customers</option> 
			    <option  value="developers">Developers</option>
			    <option  value="android_yes">All with android app</option>
			    <option  value="android_no">All with No android app</option>
			    <option  value="no_subscriber">All with No subscriber</option>
			    <option  value="with_email">All with Emails</option>
			    <option  value="no_email">All with No Emails</option>
    			</select>
    		    </div> 
    		    <div class="col-md-3" id="choose_manually" style="display: none"> 
    			<a href="<?= url('/load_address') ?>"  class="btn btn-s-md btn-info btn-rounded btn-sm" data-toggle="ajaxModal">Choose From Address</a>
    		    </div>
    		</div>
    	    </div>
	    <?php } ?>
	    <div class="form-group" id="phone_number_div"  <?= $phone_number == '' ? 'style="display: none"' : '' ?>> 
		<label class="col-lg-2 control-label">Enter Phone Numbers</label>
		<div class="col-lg-10"> 
		    <input type="text" id="phone_numbers_tag" name="phone_number" value="<?= $phone_number ?>" class="form-control" placeholder="Enter phone numbers here"/>
		</div>
	    </div> 
	    <div class="form-group"> <label class="col-lg-2 control-label">Message</label>
		<div class="col-lg-10"> 
		    <textarea class="form-control" placeholder="Type your message" id="content_area"></textarea>
		</div>
	    </div> 
	    <div class="form-group"> <label class="col-sm-2 control-label"> Send Via</label> 
		<div class="col-sm-10"> <label class="checkbox-inline"> 
			<input type="radio" id="inlineCheckbox1" name="message_type" value="1" checked="checked"> Internet Messages</label>
		    <label class="checkbox-inline"> 
			<input type="radio" id="inlineCheckbox2" name="message_type"  value="0"> Inets phone Messages </label>
			    <label class="checkbox-inline"> 
			<input type="radio" id="inlineCheckbox2" name="message_type"  value="2"> Push Notification </label>
					   
		</div> </div>
	    <div class="form-group"> 
		<div class="col-lg-offset-2 col-lg-10">
		    <button type="button" class="btn btn-sm btn-success" onclick="javascript:send_sms();">Send</button> 
		</div> 
	    </div>
	</form> 
    </div>
</section>
<script type="text/javascript">
    check_value = function () {
	$('#category').change(function () {
	    var change = $(this).val();
	    if (change == '-1') {
		$('#choose_manually,#phone_number_div').show();
	    } else {
		$('#choose_manually,#phone_number_div').hide();
	    }
	});
    }
    check_value();
    sendSmsByCategory = function (category_id) {

	var content = $('#content_area').val();
	var smart_sms = $('input:checkbox:checked.smart_sms').map(function () {
	    return this.value;
	}).get();

	var message_type = $('input[name="message_type"]:checked').val();
	if (content == '') {
	    $('#content_area').css({"border": "1px solid red"});
	    return false;
	}
	var no;
	if (smart_sms == 'on') {
	    no = 1;
	} else {
	    no = 0;
	}
	$('#ajax_sms_result').html(LOADER);
	$.post('sms_send_admin/1',
		{
		    category: category_id,
		    content: content,
		    message_type: message_type
		},
	function (data) {
	    $('#ajax_sms_result').html(data.message).addClass('alert alert-' + data.status);
	}, 'json').error(function (data) {
	    $('#ajax_sms_result').html(data.error);
	});
	$('#content_area').val('');
    };

    sendSmsByNumber = function (category_id) {
	var content = $('#content_area').val();
	var phone_numbers = $('#phone_numbers_tag').val();
	var sms_type = $('input:checkbox:checked.message_type').map(function () {
	    return this.value;
	}).get();
	var message_type = $('input[name="message_type"]:checked').val();
	if (content == '') {
	    $('#content_area').css({"border": "1px solid red"});
	    return false;
	}
	if (phone_numbers == '') {
	    $('#phone_numbers_tag').css({"border": "1px solid red"});
	    return false;
	}

	$('#ajax_sms_result').html(LOADER);
	$.post('sms_send_admin/2',
		{
		    content: content,
		    phone_numbers: phone_numbers,
		    message_type: message_type
		},
	function (data) {
	    $('#ajax_sms_result').html(data.message).addClass('alert alert-' + data.status);
	}, 'json').error(function (data) {
	    $('#ajax_sms_result').html(data.error);
	});
	$('#content_area').val('');
    }
    send_sms = function () {
	var category_id = $('#category').val();
	if (category_id == '-1' || typeof category_id === "undefined") {
	    sendSmsByNumber(category_id);
	} else {
	    sendSmsByCategory(category_id);
	}
    };


</script>