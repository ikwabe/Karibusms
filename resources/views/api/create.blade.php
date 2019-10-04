<?php

/**
 * Description of create
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
            <h4 class="modal-title">Create your karibuSMS app</h4>
        </div> 
        <div class="modal-body" id="app_area"> 
	    <div id="ajax_status_result"></div>
	    <div class="form-group has-success">
		<label class="col-sm-2 control-label">Your App Name</label>
		<div class="col-sm-8"> <input type="text" id="app_name" class="form-control"> </div> </div>

        </div>
        <div class="modal-footer"> 
            <a href="#" class="btn btn-success" id="next">Next</a> 
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script type="text/javascript">
    create_app = function() {
	$('#next').click(function() {
	    $('#ajax_status_result').html(LOADER);
	    var app_name= $('#app_name').val();
	    $.getJSON('<?= url('/') ?>/dev_store/'+app_name, {}, function(data) {
		if (data.success == 1) {
		    $('#app_area').html(data.status);
		    $('#next').html('Finish').attr("data-dismiss","modal").attr('onclick','dismis()');;
		    $('#next').removeAttr("id");
		} else {
		    $('#ajax_status_result').html(data.error);
		}
	    });
	});
    };
    function dismis(){
       window.location.reload();
    }
    $(document).ready(create_app);
</script>