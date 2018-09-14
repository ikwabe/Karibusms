<?php
/**
 * ----------------------------------------------------
 * chat area. This will later be upgraded to chat room
 * ----------------------------------------------------
 * 
 * 
 */
$level = 1;
$user_id = session("client_id");
?>
<tag>
    <div id="habla_beta_container_do_not_rely_on_div_classes_or_names"  class="habla-browser-chrome habla-desktop olrk-noquirks ">
	<div id="hbl_operator_state_div" class="olrk-away">
	    <div id="hbl_region" class="olrk-normal">
		<div id="habla_window_state_div" class="olrk-state-expanded">
		    <div id="habla_window_div" style="margin: 0px 20px; bottom: 0px; right: 0px;  position: fixed;" class="habla_window_div_base hbl_pal_main_width olrk-fixed-bottom olrk-fixed-right ">
			<div id="habla_compressed_div" style=""></div>
			<div id="habla_panel_div" class="habla_panel_border hbl_pal_main_bg hbl_pal_panel_border hbl_pal_main_font_family hbl_pal_main_font_size " style="display: block;">
			    <div id="habla_both_div" style="display: block;">
				<div id="habla_topbar_div" onclick="$('#habla_expanded_div').toggle()" class="habla_topbar_div_normal hbl_pal_title_fg hbl_pal_title_bg habla_topbar_div_compressed "><a id="habla_sizebutton_a" class="habla_button habla_button_a_normal hbl_pal_header_font_size hbl_pal_button_bg " style="background:#FFF; color: #000000;">_</a><a id="habla_oplink_a" class="habla_oplink_a_normal hbl_pal_header_font_size hbl_pal_title_fg ">Help and Support</a></div>

			    </div>
			    <div id="habla_expanded_div" style="display: none;">
				<div class="alert alert-warning">
				    <p style="padding:4%; font-size: 9px;"> call us via +255 655 406 004, or use support@karibusms.com</p>
				</div>
				<div id="habla_middle_div">
				    <div id="habla_middle_wrapper_div">
					<div id="habla_offline_message_span"></div>
					<div id="habla_offline_message_div" class="hbl_panel habla_offline_message_div hbl_pal_control_border hbl_pal_main_fg " style="display: block;">
					    <div class="package-detail">
						<ul class="list-unstyled"  style="display: block;max-height: 14em; overflow: scroll; overflow-x:hidden; ">
						    <span id="chat_message_agent_notify"></span></ul></div>
					    <?php
					    if (!isset($level)) {
						?>

    					    <div class="register-area">
    						<div class="hbl_txt_wrapper">
    						    <textarea id="habla_name_input" name="habla_name_input" class="habla_wcsend_field habla_wcsend_input_pre habla_wcsend_input_normal hbl_pal_input_pre_fg hbl_pal_main_font_family hbl_pal_input_font_size hbl_pal_control_border " placeholder="Your Subject" style="height: 20px; display: block;"></textarea>
    						</div>
    						<div class="hbl_txt_wrapper">
    						    <input id="habla_offline_email_input" name="habla_name_input" class=" habla_wcsend_input_normal  hbl_pal_control_border" placeholder="Your Email" style="height: 20px; display: block;"/> </div>    </div>
					    <?php } else { ?>


    					    <div class="hbl_txt_wrapper">
    						<textarea id="habla_name_input" name="habla_name_input" class="habla_wcsend_field habla_wcsend_input_pre habla_wcsend_input_normal hbl_pal_input_pre_fg hbl_pal_main_font_family hbl_pal_input_font_size hbl_pal_control_border " placeholder="Your Subject" style="height: 20px; display: block;"></textarea>
    					    </div>
					    <?php } ?>
					    <div class="hbl_txt_wrapper">
						<textarea id="habla_offline_body_input" name="habla_offline_body_input" class="habla_wcsend_field habla_wcsend_input_pre habla_wcsend_input_normal hbl_pal_input_pre_fg hbl_pal_main_font_family hbl_pal_input_font_size hbl_pal_control_border " placeholder="Let us know your need" style="height: 35px; display: block; margin-right: 1em;"></textarea>
					    </div>
					    <span id="habla_offline_error_span" class="habla_offline_error_span "></span>

					    <div id="habla_offline_clear_div" class="clear_style "></div>

					</div>
					<button  class="btn btn-primary btn-squared btn-block trl" id='message_send_button'>Send</button><br/>
<!--
					<a href="<?= url('/') ?>/help" target="_blank"><input id="habla_pre_chat_submit_input" name="habla_pre_chat_submit_input" type="submit" class="habla_pre_chat_form_field habla_offline_submit_input hbl_pal_offline_submit_fg hbl_pal_control_border hbl_pal_offline_submit_bg " value="<?php echo'Read user manual here'; ?>"></a>-->

				    </div>
				</div>

			    </div>
			</div>

		    </div>

		</div>

	    </div>

	</div>
    </div>
</tag>
<link rel="stylesheet" href="<?= url('/') ?>/media/css/chat.css">

<style>
    .nomodal{
	margin-top: 20em;
	left: 50%;
	bottom: auto;
	right: auto;
	margin-left: -250px;
	background-color: #ffffff;
    }
</style>
<script  type="text/javascript" charset="utf-8">

				    var id = '<?= $user_id ?>'; //we will later get this ID from cookie
				    var username = '<?= $level ?>';
//    //we create a socket object here
//   // var socket = io.connect('http://localhost:3000');
//
////let us check if this user is already registered with us or not. If not, we keep him/her as a guest
//    if (username === '') {
//	//alert('we save this as a guest');
//	//this user is empty and is not registered for chat, so we save him
//	$.get(url, {pg: 'chat', file: 'chat', method: 'save_guest', session_id: '<?= session_id() ?>'}, function (data) {
//	    console.log(data);
//	    if (data === 1) {
//		socket.emit('update', {session_id: '<?= session_id() ?>'});
//	    }
//	});
//    }
//    //define entrace method fired with emit in server.js file
//
//    socket.on('entrace', function (data) {
//	$('#habla_offline_message_span').html('<p>' + data.message + '</p>');
//    });
//
//    //we fire message to a user when someone exit the chat
//    socket.on('exit', function (data) {
//	$('#chat_message_list').html('<p>' + data.message + '</p>');
//	$.get(url, {pg: 'chat', file: 'chat', method: 'update_online_status', session_id: '<?= session_id() ?>'}, function (data) {
//	    if (data === 1) {
//		socket.emit('update', {offile: '1', id: id});
//	    }
//	});
//    });
//
//    //chat messages load here
//    socket.on('chat', function (data) {
//	//we here detect a message come, if it has the ID of the cookie, then we show it
//	//otherwise we hide this
//	//this message will only be shown to the intended client, not anyone else
//	var tag = data.username == username ? 'background: #f9f8f8;' : '';
//	if (data.id === id) {
//	    $('#chat_message_list').append('<li style="padding:0.5em; ' + tag + '  border-bottom:1px solid #CCC; list-style: none;"><span style="color: #17ade0;">' + data.username + '</span><br/>' + data.message + '</li>');
//	}
//	if (username == '') {
//	    $('#chat_message_agent_notify').append('<li style="padding:0.5em; ' + tag + '  border-bottom:1px solid #CCC; list-style: none;"><span style="color: #17ade0;">' + data.username + '</span><br/>' + data.message + '</li>');
//	}
//    });
				    ticket = function () {
					$('#message_send_button').click(function () {

					    var message = $('#habla_offline_body_input').val();
					    var title = $('#habla_name_input').val();
					    //you should here send a message, chatter ID, and destination ID here
					    //  if (username == '') {
					    //user is not yet login or submitted his/her information

					    var email = $('#habla_offline_email_input').val();
					 
					    //save message in a database for later retrieval
					    $.ajax({
						url: 'create_ticket',
						method: 'POST',
						dataType: 'JSON',
						data: {title: title,
						    subject: email, message: message},
						success: function (data) {

						   // if (data.status == 'success') {
							//socket.emit('chat', {message: message, id: data.chat_user_id, username: data.username});
//							$('.register-area').hide();
//							$('#habla_offline_body_input').val('');
//							$('#habla_offline_message_span').hide();
//							$('#habla_pre_chat_submit_input').val('Send');
						  //  } else {
						  swal(data.status,data.message,data.status);
						$('#habla_offline_message_span').html(data.message).addClass('alert alert-'+data.status);
						$('.hbl_txt_wrapper').html('');
						$('#message_send_button').hide();
						  //  }
						}
					    });
//					    } else {
//						//save message in a database for later retrieval
//						$.getJSON(home + 'login/client_message', {pg: 'chat', file: 'chat', method: 'index', message: message}, function (data) {
//						    //socket.emit('chat', {message: message, id: data.chat_user_id, username: username});
//						    bootbox.alert(data.status, function () {
//							//Example.show("Hello world callback");
//						    });
//						});
//					    }

					    $('#habla_offline_body_input').val('');

					});
				    }
				    $(document).ready(ticket);

</script>