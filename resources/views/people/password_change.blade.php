<?php
/**
 * Description of password_change
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>

<section class="vbox"> 
    <header class="header bg-white b-b clearfix">
	<div class="row m-t-sm">         
	    <div class="col-sm-4 m-b-xs" id="title_banner">Change your Password</div> 
	</div> 
    </header>
    <section class="scrollable padder"> 
	<div class="row"> 
            <div class="col-sm-6"> 
                <form data-validate="parsley"> 
                    <section class="panel panel-default"> 
                        <div class="panel-body"> 
                            <p class="text-muted">Fill the information for changing your password</p> 
                            <div id="change_password_results"></div>
                            <div class="form-group"> <label>Enter your current password</label>
                                <input type="password" class="form-control parsley-validated" data-type="password" id="pw" data-required="true"> 
                            </div> 
                            <div class="form-group pull-in clearfix"> 
                                <div class="col-sm-6"> 
                                    <label>Enter password</label> 
                                    <input type="password" class="form-control parsley-validated" data-required="true" id="pw1">
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Confirm password</label> 
                                    <input type="password" class="form-control parsley-validated" data-equalto="#pwd" id="pw2" data-required="true"> 
                                </div> 
                            </div> </div> <footer class="panel-footer text-right bg-light lter"> 
			    <button type="button" class="btn btn-success btn-s-xs" id="change_password">Submit</button> 
                        </footer>
                    </section>
                </form> 
            </div> 
        </div> 
    </section> 
</section> 
<script>
    change_password = function () {
	$('#change_password').click(function () {
	    var pas = $('#pw').val();
	    var pas1 = $('#pw1').val();
	    var pas2 = $('#pw2').val();
	    $.post('change_password',{pas: pas, pas1: pas1, pas2: pas2},function(data){
		console.log(data);
		swal(data.status,data.message,data.status);
	    },'JSON');
	   // call_page('change_password',{pas: pas, pas1: pas1, pas2: pas2}, '#vbox_content');
	});
    }
    $(document).ready(change_password);
</script>