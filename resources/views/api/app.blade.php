<?php
/**
 * Description of app
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
$client_id = session('client_id') != NULL ? session('client_id') : '';
if (session('client_id') != NULL) {
    $developer = App\Http\Controllers\ApiController::getDeveloperApp($client_id);
} else {
    $developer = array();
}
?>
@extends('master')
@section('content')
<section id="content"> 

    <div class="bg-white b-b b-light"> 
	<div class="container"> 
	    <ul class="breadcrumb no-border bg-empty m-b-none m-l-n-sm"> 
		<li><a href="<?= url('/') ?>">Home</a></li> 
		<li><a href="<?= url('/dev') ?>">dev</a></li>
		<li><a href="<?= url('/dev/app') ?>">app</a></li> 
	    </ul>
	</div>
    </div>
    <div class="container m-t-lg m-b-lg">
	<div class="col-lg-12">
	    <section class="panel panel-default">
		<div class="panel-body text-right">
		    <button class="btn btn-sm btn-success" data-toggle="ajaxModal" 
		    <?php if (session('client_id') != NULL) { ?>
    			    href="<?= url('/dev_create_app') ?>"
			    <?php } else { ?> 
    			    href="<?= url('/dev_login') ?>" <?php } ?> >Create New App</button>
		</div> 
	    </section>
	</div>

	<div class="col-lg-4">
	    <section class="panel panel-default">
		<div class="panel-body">
		    <nav class="nav-primary hidden-xs">
			<ul class="nav">
			    <li> <a href="<?= url('/dev/app') ?>">
				    <i class="fa fa-dashboard icon"> <b class="bg-danger"></b> </i> 
				    <span>Dashboard</span> </a>
			    </li>
			    <li class="">
				<a href="#uikit" class=""> 
				    <i class="fa fa-flask icon"> 
					<b class="bg-success"></b>
				    </i>
				    <span class="pull-right">
					<i class="fa fa-angle-down text"></i>
					<i class="fa fa-angle-up text-active"></i>
				    </span> 
				    <span>Apps</span>
				</a> 
				<ul class="nav lt" style="display: none;">
				    <?php
				    if (!empty($developer)) {
					foreach ($developer as $app) {
					    ?>
					    <li>
						<a href="#<?= ucfirst($app->name) ?> " onclick="call_page('<?=url('/')?>/dev_show/<?= $app->developer_id ?>','#dev_content')"> 
						    <i class="fa fa-angle-right"></i> 
						    <span><?= ucfirst($app->name) ?> </span>
						</a> 
					    </li>
					<?php }
				    }
				    ?>
				</ul>
			    </li>

			    <li> 
				<a href="<?= url('/dev/doc') ?>"> <i class="fa fa-pencil-square-o icon"> 
					<b class="bg-info"></b>
				    </i>
				    <span>Documentation</span> 
				</a> 
			    </li>
			     <li> 
				<a href="<?= url('/dev/sample') ?>"> 
				    <i class="fa fa-code icon"> 
					<b class="bg-info"></b>
				    </i>
				    <span>Code Samples</span> 
				</a> 
			    </li>
			</ul>
		    </nav>
		</div> 
	    </section> 
	</div>
	<div class="col-lg-8">
	    <section class="panel panel-default"> 
		<div class="panel-body" id="dev_content">

		    <?php
		    if (!empty($developer)) {
			echo '<br/><h4>List of your APPs</h4>';
			foreach ($developer as $app) {
			    $app_stat=  App\Http\Controllers\ApiController::getAppStat($app->developer_id);
			    $total_bulk_sms=$app_stat->bulk_sms_total==NULL ? 0 : $app_stat->bulk_sms_total;
			    $total_phone_sms=$app_stat->phone_sms_total==NULL ? 0 : $app_stat->phone_sms_total;
			    ?>		   
			    <div class="col-lg-6">
				<section class="panel panel-info"> 
				    <div class="panel-body"> 
					<a href="#dev_show/<?= $app->developer_id ?>" class="thumb pull-right m-l" onclick="call_page('<?=url('/')?>/dev_show/<?= $app->developer_id ?>', '#dev_content')"> 
					    
					    <img src="<?= url('/') ?>/media/images/avatar.jpg" class="img-circle"> 
					</a> 
					<div class="clear"> 
					    <a href="#dev_show/<?= $app->developer_id ?>" class="text-info" onclick="call_page('<?=url('/')?>/dev_show/<?= $app->developer_id ?>', '#dev_content')">@<?= ucfirst($app->name) ?> <i class="icon-twitter"></i></a>
					    <small class="block text-muted">
				    <?= $total_bulk_sms ?> Internet SMS / <?=$total_phone_sms?> Phone SMS sent</small> 
					    <a href="#" onclick="call_page('<?=url('/')?>/dev_show/<?= $app->developer_id ?>','#dev_content')" class="btn btn-xs btn-success m-t-xs">Open</a> 
					</div>
				    </div>
				</section>
			    </div>
			    <?php
			}
		    }else if(session('client_id') != NULL){
			echo 'You have no APP, start now by creating your first APP';
		    }  else { ?>
		    
			Click <button class="btn btn-sm btn-success" data-toggle="ajaxModal" 
		    <?php if (session('client_id') != NULL) { ?>
    			    href="<?= url('/dev_create_app') ?>"
			    <?php } else { ?> 
    			    href="<?= url('/dev_login') ?>" <?php } ?> >here</button> to Login First and view your Apps to get API KEY and API SECRET			
<?php }
		    ?>

		</div> 
		
	    </section>
	    <p>NB; You can create more than one APP and get different API KEY and API SECRET to integrate in different software that you have. Each software can have a separate APP name for easy management</p>
	</div>
    </div>
</section>			

@stop