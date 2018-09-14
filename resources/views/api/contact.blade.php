<?php
/**
 * Description of contact
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
            <h4 class="modal-title">Submit any complain, question or comment here</h4>
        </div> 
        <div class="modal-body" id="app_area"> 
	    <div id="ajax_status_result"></div>
	    <form class="panel-body wrapper-lg" id="signin_form"> 
		<?php
		if (session('client_id') == NULL) {
		    ?>
    		<div class="form-group"> 
    		    <label class="control-label">Your Email</label> 
    		    <input type="text" name="email" id="email_id" required="required" placeholder="email" class="form-control input-lg"> 
    		</div>
		<?php } ?>
		<div class="form-group">
		    <label class="control-label">Message</label>
		    <textarea  name="content" id="comment_input" required="required" placeholder="content" class="form-control input-lg"></textarea>
		</div> 


		<button type="button" class="btn btn-primary" onclick="submit_request();">Submit</button> 
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
    submit_request = function () {
	if ($('#comment_input').val() == '') {
	    $('#login_ajax_request').html('<br/><div class="alert alert-danger">\n\
                                   <button type="button" class="close" data-dismiss="alert">×</button>\n\
                                   <i class="fa fa-ban-circle"></i> Write your message first</div>');
	    return false;
	}
	var comment = $('#comment_input').val();
	var email=$('#email_id').val();
	$('#login_ajax_request').html(LOADER);
	$.getJSON('<?= url('/contact_us_submit') ?>', {comment: comment,email:email}, function (data) {
	    swal(data.status, data.message, data.status);
	    $('#login_ajax_request').html('');
	});
    };
    function dismis() {
	window.location.reload();
    }
</script>