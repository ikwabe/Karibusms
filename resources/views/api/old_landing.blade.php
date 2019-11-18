<?php
/**
 * Description of landing
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
@extends('master')
@section('content')
<section class="hbox">
    <section id="contents"> 
	<section class="hbox stretch">
	    <aside class="aside-md bg-white b-r" id="subNav"> 
		<div class="bg-light b-b clearfix" style="min-height: 10em;"></div>
		<div class="wrapper b-b header">SMS API</div> 
		<ul class="nav"> 
		    <li class="b-b b-light">
			<a href="<?= url('/api') ?>">
			    <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>Introduction</a></li>
		    <?php
		    $client_id = session('client_id') != NULL ? session('client_id') : '';
		    if (session('client_id') != NULL) {
			$developer = App\Http\Controllers\ApiController::getDeveloperApp($client_id);
		    } else {
			$developer = array();
		    }
		    if (!empty($developer)) {
			echo '<br/><h4>List of your APP</h4><div class="list-group bg-white"> ';
			foreach ($developer as $app) {
			    ?>		   
			    <a href="#api_show/<?= $app->developer_id ?>" class="list-group-item" onclick="call_page('api_show/<?= $app->developer_id ?>','#api_content')">
				<i class="fa fa-chevron-right icon-muted"></i> 
				<i class="fa fa-certificate icon-muted fa-fw"></i>
				<?= ucfirst($app->name) ?>
			    </a>
			<?php } ?>
    		    </div>
    		    <br/><a data-toggle="ajaxModal"
    			    href="<?= url('/api_create_app') ?>"
    			    class="btn btn-s-md btn-info" >Create new app</a>
			    <?php } else { ?>
    		    <li class="b-b b-light">
    			<a data-toggle="ajaxModal" <?php if (session('client_id') != NULL) { ?>
				   href="<?= url('/api_create_app') ?>"
			       <?php } else { ?> 
				   href="<?= url('/api_login') ?>" <?php } ?>
    			   class="btn btn-s-md btn-info" >Create your app</a>
    		    </li>
		    <?php } ?>
		</ul> 
	    </aside>
	    <aside>
		<section class="vbox"> 
		    <header class="header bg-white b-b clearfix"> </header> 

		    <div class="bg-white col-lg-8">

			<div id="content_loading">
			    <div class="twelve columns" id="api_content">

				<h4>How to start</h4>
				<ol class="tabs-content">

				    <li>Create account in karibuSMS or Login if you have an account already</li>
				    <li>Click a button "Create new App" on the left side on this page</li>
				    <li>On success, you will get API KEY and API SECRET codes. Use these codes in the following API as described below</li>
				</ol>

				<div class="panel-group m-b" id="accordion2"> 
				    <div class="panel panel-default">
					<div class="panel-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"> <h4>1. KaribuSMS Simple API</h4></a> </div>
					<div id="collapseOne" class="panel-collapse in" style="height: auto;">
					    <div class="panel-body text-sm"> <p>For simple usage, just call this url and pass API keys of APP you have create</p>
						<hr>
						<section class="panel panel-info"> 
						    <div class="panel-body"> 
							<a href="#" class="thumb pull-right m-l"></a>
							<div class="clear">
							    <pre> http://karibusms.com/api_call?message=YOUR_MESSAGE&phone_number=255748XXXXXX&messaging_type=1&api_key=API_KEY&api_secret=API_SECRET</pre>
							</div>
						    </div> </section>
						<p>This is for simple usage. For large application, use below information  </p>
					    </div> </div> </div>
				    <div class="panel panel-default"> 
					<div class="panel-heading"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
						<h4> 2. KaribuSMS API Documentation</h4></a> 
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" style="height: 0px;"> <div class="panel-body text-sm">
						<li class="active" id="tabsExTab">

						    <p>This is version <strong>2.1.0</strong> of karibuSMS API.</p>
						    <hr>
						    <p class="alert alert-info">N:B; This description is for PHP version only. For JAVA and JavaScript/Jquery, all descriptions are available in source codes and example scripts provided</p>
						    <h5>Usage</h5>
						    <p>You can either connect your Android phone to send SMS or you can just use our internet messages. To get started, just create your app and download sample codes</p>
						    <p>These are steps to follow</p>

						    <h5>Initialize</h5>
						    <pre class="prettyprint">
<span class="tag">  &lt;&quest;php</span>
<span class="pln"> </span>
<span class="atn">  define('API_SECRET', 'your app secret here');</span>
<span class="pun">  define('API_KEY', 'your app key here');</span>
<span class="atv">  include_once "karibusms.php" </span>
<span class="tag">  &quest;&gt;</span>

						    </pre>

						    <h5>Send SMS now</h5>
						    <pre class="prettyprint">
<span class="pln">    &lt;&quest;php</span>
<span class="pln"></span>
<span class="pln">    $karibu->new karibusms();</span>
<span class="pln">    $karibu->send_sms('0735875785,0619822122', 'hello how are you');</span>
<span class="pun">    &quest;&gt;</span>
						    </pre>

						    <h5>By default, SMS will be sent using a messaging type you choose in your profile as either <a href="<?= url('/').'/' ?>features" class="label">karibuSMS</a> or <a href="<?= url('/').'/' ?>karibusmspro" class="label">karibuSMSpro.</a></h5><br>
						    <p>You can also change the messaging type by setting variable <a class="label">public $karibuSMSpro </a>into TRUE or FALSE. The boolean TRUE will allow you to use karibuSMSpro while FALSE is the default that will use your smart phone</p>

						</li>
					    </div> 
					</div>
				    </div> 


				    <div class="panel panel-default"> 
					<div class="panel-heading">
					    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree"> <h4 class="">API statistics</h4> </a> 
					</div>
					<div id="collapseThree" class="panel-collapse collapse" style="height: 0px;">
					    <div class="panel-body text-sm"> 
						<p>API Usage statistics can be accessed by using karibuSMS API from version 1.2.0 and above</p> 
						<p>The following example shows how to access all statistics</p>
						<pre class="prettyprint">
<span class="pln">    &lt;&quest;php</span>
<span class="pln"></span>
<span class="pln">    $karibu->new karibusms();</span>
<span class="pln">    $karibu->get_statistics();</span>
<span class="pun">    &quest;&gt;</span>    
						</pre>
						<p>This method will return JSON object with the following parameters as seen in below example</p>
						<pre class="prettyprint">
{
    'app_name':'API NAME',
    'sms_used': '891',
    'sms_remain' :'9881'
} 
						</pre>
						
					    </div> 
					</div>
				    </div> 
				</div>


<!--				<article id="chat-id-1" class="chat-item left"> <a href="#" class="pull-left thumb-sm avatar">
					<img src="media/images/logo.png" class="img-circle"></a> <section class="chat-body"> <div class="panel b-light text-sm m-b-none"> <div class="panel-body"> 
						<span class="arrow left"></span> 
						<p> Is this helpful to you ? 
						    <button class="btn btn-default" data-toggle="button">
							<i class="fa fa-heart-o text"></i> 
							<i class="fa fa-heart text-active text-danger"></i> 
						    </button> 
						    <button class="btn btn-default" data-toggle="button"> 
							<span class="text"> <i class="fa fa-thumbs-up text-success"></i> 25 </span> 
							<span class="text-active"> <i class="fa fa-thumbs-down text-danger"></i> 10 </span>
						    </button>
						    <i class="fa fa-spin fa-spinner hide" id="spin"></i> 
						</p>
					    </div> </div> 
				    </section> 
				</article>-->


				<section class="panel panel-info"> 
				    <div class="panel-body"> <a href="#" class="thumb pull-right m-l"></a> <div class="clear">If you have any request or comment or having a question ? <a  data-toggle="ajaxModal" href="<?= url('/contact_us') ?>" class="btn btn-xs btn-success m-t-xs">Contact us here</a> </div> </div> </section>
			    </div>

			</div>
		    </div>
		    <div class="col-lg-4 bg-light">
			<header><h4>Download code samples</h4></header>
			<section class="panel panel-default"> 
			    <header class="panel-heading bg-light">
				<ul class="nav nav-tabs nav-justified"> 
				    <li class="active"><a href="#home" data-toggle="tab">PHP</a></li>
				    <li><a href="#profile" data-toggle="tab">javaScript/jQuery</a></li> 
				    <li><a href="#java" data-toggle="tab">JAVA</a></li> 
				</ul> 
			    </header> 
			    <div class="panel-body"> 
				<div class="tab-content"> 
				    <div class="tab-pane active" id="home">
					<div class="four columns">
					    <div class="spacer"></div>
					    <h4 class="title">
						karibuSMS API PHP codes 
					    </h4>
					    <h6 class="subheader">v2.1.0</h6>
					    <p class="text-left">
						Download PHP codes with example to easily get started.
					    </p>

					    <a href="https://github.com/inetscompany/karibuSMS_PHP" class="btn btn-s-md btn-dark btn-rounded" target="_blank">Download &nbsp; <i class="fa fa-download"></i></a>


					</div></div> 
				    <div class="tab-pane" id="profile">
					<div class="four columns">
					    <div class="spacer"></div>
					    <h4 class="title">
						karibuSMS JavaScript/jQuery API
					    </h4>
					    <h6 class="subheader">v2.1.0</h6>
					    <p class="text-left">
						Download jQuery codes with example to easily get started.
					    </p>

                                            <a href="https://github.com/inetscompany/karibuSMS_JavaScript_API" class="btn btn-s-md btn-default btn-rounded" target="_blank">Download &nbsp; <i class="fa fa-download"></i></a>


					</div>
				    </div> 
				    <div class="tab-pane" id="java">
					<div class="four columns">
					    <div class="spacer"></div>
					    <h4 class="title">
						karibuSMS JAVA API
					    </h4>
					    <h6 class="subheader">v2.1.0</h6>
					    <p class="text-left">
						Download JAVA codes with example to easily get started.
					    </p>

                                            <a href="https://github.com/inetscompany/karibuSMS_JAVA_API" class="btn btn-s-md btn-default btn-rounded" target="_blank">Download &nbsp; <i class="fa fa-download"></i></a>


					</div>
				    </div> 
				</div> 
			    </div>
			</section>

		    </div>
		    <footer class="footer bg-white b-t">
			<div class="row text-center-xs"> 
			    <div class="col-md-6 hidden-sm"></div>
			</div>
		    </footer> 
		</section> 
	    </aside>
	</section> 
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section> 
</section> 
@stop