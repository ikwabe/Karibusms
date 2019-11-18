<?php

/**
 * Description of send_email
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
$phone_number = isset($_GET['phone_number']) ? $_GET['phone_number'] : '';
$sender_name_description = 'This is your username and is the name which people who will receive SMS will see in their phones as from address. To change this, go to settings page and change your username.';
?>
<section class="panel panel-default"> 
    <header class="panel-heading font-bold">Sending Email

    </header>

    <div class="panel-body">
	<form class="bs-example form-horizontal">
	    <div class="form-group"> 
		<small>Sender Name: <b style="cursor: pointer" class="label label-info" data-toggle="popover" data-html="true" data-placement="top"  data-content="<div class='scrollable' style='height:40px'><?= $sender_name_description ?></div>" title="" data-original-title="<button type=&quot;button&quot; class=&quot;close pull-right&quot; data-dismiss=&quot;popover&quot;>×</button>About Sender Name" onclick="swal('About Username', '<?= $sender_name_description ?>', 'info')">
			<?= $username ?>
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
    			    <option value="0">All</option>
    			    <option value="-1">Enter manually</option>
				<?php
				/**
				 * -------------------------------
				 * Get categories
				 * -------------------------------
				 */
				$categories = \App\Http\Controllers\Controller::get_category();
				foreach ($categories as $category) {
				    ?>
				    <option  value="<?= $category->category_id ?>"><?= $category->name ?></option> 
				<?php } ?>
    			</select>
    		    </div> 
    		    <div class="col-md-3" id="choose_manually" style="display: none"> 
    			<a href="<?= url('/load_address') ?>"  class="btn btn-s-md btn-info btn-rounded btn-sm" data-toggle="ajaxModal">Choose From Address</a>
    		    </div>
    		</div>
    	    </div>
	    <?php } ?>
	    <div class="form-group" id="phone_number_div"  <?= $phone_number == '' ? 'style="display: none"' : '' ?>> 
		<label class="col-lg-2 control-label">Enter Emails</label>
		<div class="col-lg-10"> 
		    <input type="text" id="emails_tag" name="email" value="<?= $phone_number ?>" class="form-control" placeholder="Enter list of emails separate by comma"/>
		</div>
	    </div>
	    <div class="form-group" id="email_subject_div"> 
		<label class="col-lg-2 control-label">Subject</label>
		<div class="col-lg-10"> 
		    <input type="text" id="subject_tag" name="subject" value="" class="form-control" placeholder="Enter subject here"/>
		</div>
	    </div>
	    <div class="form-group"> <label class="col-lg-2 control-label">Message</label>
		<div class="col-lg-10"> 
		    <textarea class="form-control" placeholder="Type your message" id="content_area"></textarea>
		</div>

	    </div> 
	    <div class="form-group"> 
		<div class="col-lg-offset-2 col-lg-10">
		    <button type="button" class="btn btn-sm btn-success" onclick="javascript:send_sms();">Send</button> 
		</div> 
	    </div>
	</form> 
    </div>
</section>
<script type="text/javascript">
//    word_count = function () {
//	$('#content_area').keyup(function () {
//	    var words = $('#content_area').val().length;
//	    $('#word_counts').html(words);
//	    $('#sms_count').html(Math.ceil(words/160));
//	});
//    };
//    $(document).ready(word_count);
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
	var subject=$('#subject_tag').val();
	if (content == '') {
	    $('#content_area').css({"border": "1px solid red"});
	    return false;
	}
	if (subject == '') {
	    $('#subject_tag').css({"border": "1px solid red"});
	    return false;
	}
	$('#ajax_sms_result').html(LOADER);
	$.post('email_send/1',
		{
		    category: category_id,
		    content: content,
		    subject:subject
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
	var emails = $('#emails_tag').val();
	var subject=$('#subject_tag').val();
	if (content == '') {
	    $('#content_area').css({"border": "1px solid red"});
	    return false;
	}
	if (emails == '') {
	    $('#emails_tag').css({"border": "1px solid red"});
	    return false;
	}
	if (subject == '') {
	    $('#subject_tag').css({"border": "1px solid red"});
	    return false;
	}

	$('#ajax_sms_result').html(LOADER);
	$.post('email_send/2',
		{
		    content: content,
		    emails: emails,
		    subject:subject
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

    smart_sms_status = function () {
	$(".smart_sms").bind('change', function () {
	    var val = this.checked; //<---
	    if (val === true) {
		/*alert('send to all active');
		 * disable number input
		 */

		$('#smart_sms_label').html('<div class="alert alert-info">Turned On. Message will be sent from your smart phone. <a href="<?= url('/').'/' ?>karibusmspro" class="badge badge-success" target="_blank">Learn More</a> </div>');
		$.get(url, {pg: 'profile', process: 'profile', method: 'smartphone_status', messaging_type: 0}, function (data)
		{

		});
	    }
	    if (val === false) {
		/*alert('diactivate'); */
		$.get(url, {pg: 'profile', process: 'profile', method: 'smartphone_status', messaging_type: 1}, function (data)
		{
		    $('#smart_sms_label').html('');
		});

	    }
	});
    };
    $(document).ready(smart_sms_status);

</script>