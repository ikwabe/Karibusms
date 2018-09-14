<?php

/**
 * Description of mail_account
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<?php
/**
 * Description of sms
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
//count smartphone sms
$smartphone_sms = 0;
$normal_sms = 0;
foreach ($sms as $sms_content) {
    if ($sms_content->messaging_type == 1) {
	//smartphone
	$smartphone_sms++;
    } else {
	$normal_sms++;
    }
}
$user = App\Http\Controllers\Controller::user_info();
$link = 'media/images/business/' . $user->client_id . '/' . $user->profile_pic;
$path = is_file($link) ? $link : 'media/images/business/0/default.png';
?>
<section class="vbox"> 
    <header class="bg-dark dk header navbar navbar-fixed-top-xs"> 
	<div class="navbar-header aside-md"> 
	    <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html"> 
		<i class="fa fa-bars"></i> 
	    </a> 
	    <a href="#" class="navbar-brand" data-toggle="fullscreen">
		<img src="<?= url('/') . '/' . $path ?>" class="m-r-sm"></a>
	    <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
		<i class="fa fa-cog"></i>
	    </a> 
	</div>

    </header> 
    <section> 
	<section class="hbox stretch"> <!-- .aside -->


	    <!-- /.aside --> <section id="content"> <section class="hbox stretch"> <!-- .aside --> 
		    <aside class="aside aside-md bg-white"> 
			<section class="vbox">
			    <header class="dk header">
				<button onmousedown="compose_sms()" 
					class="btn  btn-default btn-sm pull-right" title="Compose New SMS">Compose <i class="fa fa-plus"></i></button>
				<button class="btn btn-icon btn-default btn-sm pull-right visible-xs m-r-xs" data-toggle="class:show" data-target="#mail-nav"><i class="fa fa-reorder"></i></button> 



				<p class="h4">Emails</p> </header>
			    <section> 
				<section> 
				    <section id="mail-nav" class="hidden-xs">
					<ul class="nav nav-pills nav-stacked no-radius">
					    <li  class="active"> 
						<a href="#sms" onclick="call_page('sms')">

						    <i class="fa fa-fw fa-inbox"></i> Sent SMS (All)
						</a> 
					    </li> 
					     <li > 
											    <a href="#received_sms">
												<span class="badge pull-right"><?= $normal_sms ?></span> 
												<i class="fa fa-fw fa-envelope-o"></i> Received SMS
											    </a>
											</li>
					    <!--					    <li > 
											    <a href="#">
												<span class="badge pull-right"><?= $normal_sms ?></span> 
												<i class="fa fa-fw fa-envelope-o"></i> Developer API
											    </a>
											</li>
											<li>
											    <a href="#"> 
												<span class="badge badge-hollow pull-right"><?= $smartphone_sms ?></span> 
												<i class="fa fa-fw fa-mobile-phone"></i>Smart Phone SMS </a>
											</li>-->

					</ul>
				    </section>
				</section>
			    </section>
			</section>
		    </aside> <!-- /.aside --> <!-- .aside --> 

		    <div id="lists">
			<aside class="bg-light lter b-l" id="email-list sms_list"> 
			    <section class="vbox"> 
				<header class="bg-light dk header clearfix"> 

				    <div class="btn-toolbar"> 

					<div class="btn-group"> 
<!--					    <button class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="bottom" data-title="Refresh"><i class="fa fa-refresh"></i></button>-->

					</div> 
				    </div> 
				</header> 
				<section class="scrollable hover"> 
				    <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-alt list-group-lg"> 

					<?php
					/**
					 * ---------------------------------------------------------------------
					 * Loop to show message titles
					 * --------------------------------------------------------------------
					 */
					foreach ($sms as $message) {
					    ?>
    					<li class="list-group-item animated fadeInRightBig" onmousedown="call_page('sms_content/<?= encryptApp($message->message_id) ?>', '#sms_content_div');
    						$('#lists').toggle();">
    					    <a href="#" class="thumb-xs pull-left m-r-sm"> 
    						<img src="<?= url('/') . '/' . $path ?>" class="img-circle">
    					    </a> 
    					    <a href="#" class="clear"> 
    						<small class="pull-right text-muted"><?= date('d M Y h:m', strtotime($message->time)) ?></small> 
    						<span><?= str_limit($message->content, 60) ?>
    						    <span class="text-success">read more....</span>	
    						</span> 
    					    </a>
    					</li>
					<?php } ?>
					<input type="hidden" id="page_id" value="1"/>
					<div id="moresms"></div>

				    </ul> 
				    
				</section> 
				<footer class="footer b-t bg-white-only"> 
				    <div class="text-center"><br/>
					<p style="cursor: pointer" onmousedown="load_more()">Load More</p>
				    </div>

				    <!--				    <form class="m-t-sm"> 
									    <div class="input-group">
										<input type="text" class="input-sm form-control input-s-sm" placeholder="Search">
										<div class="input-group-btn"> 
										    <button class="btn btn-sm btn-default">
											<i class="fa fa-search"></i></button>
										</div> 
									    </div> 
									</form> -->
				</footer> 
			    </section> 
			</aside> <!-- /.aside --> <!-- .aside --> 
		    </div>
		    <?php
		    /**
		     * ---------------------------------------------------------------------
		     * Loop to show message titles
		     * --------------------------------------------------------------------
		     */
//foreach ($sms as $message) {
		    ?>

		    <div id="sms_content_div" style="min-height: 15em;"></div>
		    <!-- /.aside --> 

		    <?php // }   ?>
		    <aside class="aside-sm b-l"> 
			<section class="vbox"> 
			    <header class="bg-light dk header"> <p>Your Phone Status</p> </header>
			    <section class="scrollable bg-white"> 
				<div class="list-group list-group-alt no-radius no-borders">
				    <?php
				    if ($gcm_id != '') {
					?>
    				    <a class="list-group-item" href="#sms" onmousedown="swal('Information', 'This means, you have karibuSMS app installed in your mobile phone', 'success')">
    					<i class="fa fa-circle text-success text-xs"></i> 
    					<span>App installed</span>
    				    </a>
				    <?php } else { ?>
    				    <a class="list-group-item" href="#sms" onmousedown="swal('Information', 'This means, you don\'t have karibuSMS app installed in your mobile phone. Follow this link https://goo.gl/msamgD and install karibuSMS application in your phone to connect with your online profile', 'warning')">
    					<i class="fa fa-circle text-warning text-xs"></i> 
    					<span>App Not Installed</span>
    				    </a>
				    <?php } ?>
				</div> 
			    </section> 
			    <!--			    <footer class="footer text-center b-t"> 
							    <button class="btn btn-success btn-sm"><i class="fa fa-plus"></i>Change Status</button> 
							</footer>-->
			</section>

		</section>
		<aside class="bg-light lter b-l aside-md hide" id="notes"> <div class="wrapper">Notification</div> </aside> 
	    </section> 
	</section> 
    </section>
</section>
<script type="text/javascript">
    compose_sms = function () {
	var data=actionAjax('send_email_dialog', {}, 'GET', '#sms_list', 'html');
	$('#lists').html(data).show();
	$('#sms_content_div').hide();
    }
    load_more=function(){
	var page_id=$('#page_id').val();
	var data=actionAjax('sms/'+page_id, {}, 'GET', null, 'html');
	$('#moresms').append(data);
	$('#page_id').val(page_id+1);
    }
</script>