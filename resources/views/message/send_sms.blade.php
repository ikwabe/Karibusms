<?php
/**
 * Description of send_sms
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
    <header class="panel-heading font-bold">Sending Text SMS

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
    			    <option value="0">All Contacts</option>
    			    <option value="-1">Enter Numbers</option>
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
		<label class="col-lg-2 control-label">Enter Phone Numbers</label>
		<div class="col-lg-10"> 
		    <input type="text" id="phone_numbers_tag" name="phone_number" value="<?= $phone_number ?>" class="form-control" placeholder="Enter phone numbers here"/>
		</div>
	    </div> 
	    <div class="form-group"> <label class="col-lg-2 control-label">Message</label>
		<div class="col-lg-10"> 
		    <textarea class="form-control" placeholder="Type your message" id="content_area"></textarea>
		    <span>chars/SMS count <b id="word_counts">0</b>/<b id="sms_count">1</b></span>
                    <blockquote>
                        <b>use these hashtags to customize your SMS</b> <BR/>
                        #name (It will pick contact firstname + lastname), #organization_name (It will pick contact organization name)
                        
                    </blockquote>
		</div>

	    </div> 
	    <div class="form-group"> <label class="col-sm-2 control-label"> Send Via</label> 
		<div class="col-sm-10">
		    <label class="checkbox-inline"> 
			<input type="radio" id="inlineCheckbox1" name="message_type" value="1" checked="checked"> Internet Messages</label>
		    <label class="checkbox-inline"> 
			<input type="radio" id="inlineCheckbox2" <?php
			if ($gcm_id != '') {
			    ?> name="message_type"  value="0" 
			       <?php } else { ?>
    			       onclick="swal('Information', 'You do not have karibuSMS app installed in your phone so you cannot send SMS from your phone. type this link to download app first. https://goo.gl/msamgD ', 'warning');
    				       document.getElementById('inlineCheckbox2').checked = false;"

<?php } ?>> Your phone Messages
		    </label>
<!--		    <label class="checkbox-inline"> 
			<i class="fa fa-plus"></i>Advanced options</label>-->
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
    word_count = function () {
	$('#content_area').keyup(function () {
	    var words = $('#content_area').val().length;
	    $('#word_counts').html(words);
	    $('#sms_count').html(Math.ceil(words/160));
	});
    };
    $(document).ready(word_count);
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
	$.post('sms_send/1',
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
	$.post('sms_send/2',
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