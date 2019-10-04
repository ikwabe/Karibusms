<?php
/**
 * Description of home_ajax
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com 
 *  -----------------------------------------------------
 * @author Ephraim Swilla 
 */

$link = 'media/images/business/' . $user->client_id . '/' . $user->profile_pic;
$path = file_exists($link) ? $link : 'media/images/business/0/default.png';


?>
<section class="vbox" style="min-height: 40em;"> 
    <section class="scrollable padder"> 
	<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
	    <li class="active">Dashboard</li>
	</ul>
	<div class="m-b-md"> 
	    <h3 class="m-b-none">Hello</h3> 
	    <small>Welcome, <b style="font-size: 17px;"><?= ucwords($user->name) ?></b></small>
            <p align="right"><a class="btn btn-success btn-sm" href="<?=url('/')?>storage/app/karibusms.apk"><i class="fa fa-download"></i> Download Android APP</a></p>
	</div>

	<section class="panel panel-default">
	    <div class="row m-l-none m-r-none bg-light lter"> 
		<div class="col-sm-6 col-md-3 padder-v b-r b-light" title="Click to add more people"> 
		    <span class="fa-stack fa-2x pull-left m-r-sm"> 
			<i class="fa fa-circle fa-stack-2x text-info"></i>
			<i class="fa fa-male fa-stack-1x text-white"></i> 
		    </span> 
		    <a class="clear" href="#people/all"> 
			<span class="h3 block m-t-xs"><strong><?= $total_people ?></strong></span> 
			<small class="text-muted text-uc"> Total People</small> 
		    </a> 
		</div>
		<div class="col-sm-6 col-md-3 padder-v b-r b-light lt" title="click to add payment">
		    <span class="fa-stack fa-2x pull-left m-r-sm"> 
			<i class="fa fa-circle fa-stack-2x text-warning"></i> 
			<i class="fa fa-inbox fa-stack-1x text-white"></i>
			
		    </span>
		    <a class="clear" href="#"> 
			<span class="h3 block m-t-xs"><strong id="bugs"><?=$user->message_left==NULL ? '0' : $user->message_left?></strong></span> 
			<small class="text-muted text-uc">Remaining SMS</small>
		    </a>
		</div> 
		<div class="col-sm-6 col-md-3 padder-v b-r b-light"  title="Click to send SMS">
		    <span class="fa-stack fa-2x pull-left m-r-sm"> 
			<i class="fa fa-circle fa-stack-2x text-danger"></i> 
			<i class="fa fa-mail-forward fa-stack-1x text-white"></i> 
			
		    </span> 
		    <a class="clear" href="#send_sms_dialog">
			<span class="h3 block m-t-xs"><strong id="firers"><?=$sms_sent?></strong></span> 
			<small class="text-muted text-uc">Total SMS Sent</small>
		    </a>
		</div>
		<div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
		    <span class="fa-stack fa-2x pull-left m-r-sm">
			<i class="fa fa-circle fa-stack-2x icon-muted"></i> 
			<i class="fa fa-cloud fa-stack-1x text-white"></i>
		    </span> 
		    <a class="clear" href="#pending_sms">
			<span class="h3 block m-t-xs"><strong><?=$pending_sms?></strong></span> 
			<small class="text-muted text-uc">Pending SMS</small>
		    </a>
		</div>
	    </div>
	</section>



	<div class="row">
	     
	    <div class="col-md-4"> 
		
	
	
	    </div>
	</div> 
	<div> 

	</div> 
    </section>
</section>