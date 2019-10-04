<?php
/**
 * Description of faq
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
$page = request()->route()->parameters()['page'];
?>
@extends('master')
@section('content')
<section id="content"> 
    <div class="bg-white b-b b-light"> 
	<div class="container"> 
	    <ul class="breadcrumb no-border bg-empty m-b-none m-l-n-sm"> 
		<li><a href="<?= url('/') ?>">Home</a></li> 
		<li><a href="<?= url('/dev') ?>">dev</a></li>
		<li><a href="<?= url('/dev/' . $page) ?>"><?= $page ?></a></li> 
		
	    </ul>
	</div>
    </div>
    <div class="container m-t-lg m-b-lg">
<div class="col-lg-3">
	    <section class="panel panel-default">
		<div class="panel-body">
		    <nav class="nav-primary hidden-xs">
			<ul class="nav">
			    <li class=""> <a href="<?= url('/dev/doc') ?>" class=""> <i class="fa fa-flask icon"> <b class="bg-success"></b> </i> <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i> </span> <span>Documentation</span> </a> 
				<ul class="nav lt" style="display: none;"> 
				    <li> 
					<a href="<?= url('/dev/doc') ?>#introduction">
					    <i class="fa fa-angle-right"></i>
					    <span>Introduction</span> 
					</a>
				    </li>
				    <li> 
					<a href="<?= url('/dev/doc') ?>#lang">
					    <i class="fa fa-angle-right"></i>
					    <span>Languages Supported</span> 
					</a>
				    </li>
				    <li>
					<a href="<?= url('/dev/doc') ?>#keys">
					    <b class="badge bg-info pull-right">369</b>
					    <i class="fa fa-angle-right"></i>
					    <span>Define KEYS</span> 
					</a>
				    </li> 
				    <li> 
					<a href="<?= url('/dev/doc') ?>#send"> 
					    <i class="fa fa-angle-right"></i> 
					    <span>Send SMS</span> 
					</a> 
				    </li> 
				    <li>
					<a href="<?= url('/dev/doc') ?>#statistics">
					    <b class="badge pull-right">8</b>
					    <i class="fa fa-angle-right"></i> 
					    <span>Get Statistics</span> </a>
				    </li> 
				    <li>
					<a href="<?= url('/dev/doc') ?>#reports">
					    <b class="badge pull-right">8</b>
					    <i class="fa fa-angle-right"></i> 
					    <span>Get Reports</span> </a>
				    </li> 
				    <li>
					<a href="<?= url('/dev/doc') ?>#reports">
					    <b class="badge pull-right">8</b>
					    <i class="fa fa-angle-right"></i> 
					    <span>Best Practices</span> </a>
				    </li> 
				</ul>
			    </li>

			    <li> <a href="<?= url('/dev/faq') ?>"> 
				    <b class="badge bg-danger pull-right">3</b>
				    <i class="fa fa-question icon">
					<b class="bg-primary dker"></b>
				    </i> 
				    <span>FAQ</span>
				</a> 
			    </li>

			    <li> 
				<a href="<?= url('/dev/sample') ?>"> <i class="fa fa-pencil icon"> 
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
	
	<div class="col-lg-9">
	    <section class="panel panel-default"> 
		   <div class="post-item">
		     
			<div class="caption wrapper-lg"> 
			      
			<div class="text-right"><a href="<?= url('/dev/app') ?>" class="btn btn-sm btn-success">Go to App Page</a></div>
			    <h2 class="post-title">
				<a href="#introduction">FAQ</a>
			    </h2> 
			    <div  class="content">
				<div class="panel-group m-b" id="accordion2"> 
				    <div class="panel panel-default">
					<div class="panel-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">#1:  Can I use any programming language to integrate karibuSMS features ? </a> </div> 
					<div id="collapseOne" class="panel-collapse in"> 
					    <div class="panel-body text-sm"> Yes,any programming language can be used. The provided documentation provide a guide on how to integrate </div>
					</div>
				    </div>
				    <div class="panel panel-default">
					<div class="panel-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">#2: Do I need internet access to be able to send SMS </a> </div> <div id="collapseTwo" class="panel-collapse collapse"> 
					    <div class="panel-body text-sm"> YES, your computer needs to have a good internet to be able to send SMS. If you send SMS from your smartphone, your phone needs to have a good internet connection also to enable SMS to be sent</div> </div> 
				    </div> 
				    <div class="panel panel-default"> <div class="panel-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">#3: What maximum number of SMS I can send at once </a> </div> 
					<div id="collapseThree" class="panel-collapse collapse"> <div class="panel-body text-sm">Unlimited, karibuSMS will send SMS one by one or by group till all SMS has been sent to your intended recipients. </div> </div>
				    </div>
				</div>
			    </div>
			    <div class="line line-lg"></div>
			    <div class="text-muted"> 
			
				<i class="fa fa-clock-o icon-muted"></i>Last Update: July 15, 2016 
				<a data-toggle="ajaxModal" href="<?= url('/dev/contact') ?>"  class="m-l-sm"><i class="fa fa-comment-o icon-muted"></i>
				    Add comment</a>
			    </div>
			</div> 
		    </div> 
		
	    </section>
	</div>
	</div>
</section>

	@stop