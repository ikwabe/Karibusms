<?php
/**
 * Description of sms_content
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<aside class="bg-white  b-l" id="email-content"  style="min-height: 21em;">
    <section class="vbox">
	<section class="scrollable"> 
	    <div class="wrapper b-b b-light"> 
		<a href="#" data-toggle="class" class="pull-left m-r-sm">
		    <!--<i class="fa fa-star-o fa-1x text"></i>-->
		    <i class="fa fa-star text-warning fa-1x text-active"></i>
		</a> 

		<h4 class="m-n">
		    <?php
		    $category_name=$message->name =='' ?'No category': $message->name;
		    echo 'Category: <span class="badge badge-info">'.$category_name.'</span>';
		    ?></h4> 
	    </div> 
	    <div class="text-sm padder m-t">
		<div class="block clearfix m-b"> 
		    <a href="#" class="thumb-xs inline">
			To:
		    </a> 
		    <span class="inline m -t-xs ">
			<?php
			foreach ($phone_numbers as $number) {
			    echo '<' . $number->phone_number . '>,';
			}
			?>
		    </span> 
		    <div class="pull-right inline">
			(<em><?= date('d M Y h:m', strtotime($message->time)) ?></em>)
			<div class="btn-group">
			    <button class="btn btn-default btn-xs" title="resend" onmousedown="resend_message('<?= $message->message_id ?>')">
				<i class="fa fa-reply-all"></i></button>
			    <button class="btn btn-default btn-xs" title="Delete" onmousedown="delete_message('<?= $message->message_id ?>')">
				<i class="fa fa-trash-o"></i>
			    </button>
			</div>
		    </div> 
		</div>
		<div>
		    <div class="line pull-in"></div> 
		    <p><?= $message->content ?></p>
		</div> 

	    </div>
	    <!--	    <div class="padder"> 
			    <div class="panel text-sm bg-light"> 
				<div class="panel-body"> Click here to <a href="#">Reply</a> or <a href="#">Forward</a> </div>
			    </div>
			</div>-->

	</section> 
    </section> 
</aside>
<script type="text/javascript">
    resend_message = function (a) {
swal(
		{
		    title: "Are you sure?",
		    text: "By clicking OK, this message will be resent. Are you sure you want to resend SMS ?",
		    type: "warning",
		    showCancelButton: true,
		    confirmButtonColor: "#DD6B55",
		    confirmButtonText: "Yes, resend!",
		    cancelButtonText: "No, cancel this!",
		    showLoaderOnConfirm: true,
		    closeOnConfirm: false,
		    closeOnCancel: false
		},
	function (isConfirm) {
	    if (isConfirm) {
		$.get('resend_message/' + a, {}, function (data) {
		    console.log(data);
		    if (data == 1) {
			swal("Resent!", "Your message is resent successful.", "success");
			call_page('sms');
		    } else {
			swal("Error", "Your message failed to be resent", "error");
		    }
		});
	    } else {
		swal("Cancelled", "Message remain not resent", "error");
	    }
	});
    }
    delete_message = function (a) {
	swal(
		{
		    title: "Are you sure?",
		    text: "By clicking OK you will detele only this message in your list. Are you sure you want to delete ?",
		    type: "warning",
		    showCancelButton: true,
		    confirmButtonColor: "#DD6B55",
		    confirmButtonText: "Yes, delete it!",
		    cancelButtonText: "No, cancel this!",
		    showLoaderOnConfirm: true,
		    closeOnConfirm: false,
		    closeOnCancel: false
		},
	function (isConfirm) {
	    if (isConfirm) {
		$.get('delete_message/' + a, {}, function (data) {
		    if (data == 1) {
			swal("Deleted!", "Your message is deleted successful.", "success");
			call_page('sms');
		    } else {
			swal("Error", "Your message failed to be deleted", "error");
		    }
		});
	    } else {
		swal("Cancelled", "Message remain not deleted", "error");
	    }
	});
    }
</script>