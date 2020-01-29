<?php
/**
 * Description of user_documentation
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
		<li><a href="<?= url('/dev') ?>">api</a></li>
		<li><a href="<?= url('/dev/' . $page) ?>"><?= $page ?></a></li> 
	    </ul>
	</div>
    </div>
    <div class="container m-t-lg m-b-lg">

	<div class="col-lg-3" >
	    <section class="panel panel-default">
		<div class="panel-body">
		    <nav class="nav-primary hidden-xs">
			<ul class="nav">
			    <li class=""> <a href="#uikit" class=""> <i class="fa fa-pencil-square-o icon"> <b class="bg-success"></b> </i> <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i> </span> <span>Documentation</span> </a> 
				<ul class="nav lt" style="display: none;"> 
				    <li> 
					<a href="#introduction">
					    <i class="fa fa-angle-right"></i>
					    <span>Introduction</span> 
					</a>
				    </li>

				    <li>
					<a href="#keys">
					    <i class="fa fa-angle-right"></i>
					    <span>Define KEYS</span> 
					</a>
				    </li> 
				    <li> 
					<a href="#send"> 
					    <i class="fa fa-angle-right"></i> 
					    <span>Send SMS</span> 
					</a> 
				    </li> 
				    <li>
					<a href="#statistics">

					    <i class="fa fa-angle-right"></i> 
					    <span>Get Statistics</span> </a>
				    </li> 
				    <li>
					<a href="#reports">
					    <i class="fa fa-angle-right"></i> 
					    <span>Get Reports</span> </a>
				    </li> 
				    <li>
					<a href="#http_get">
					    <b class="badge pull-right">url</b>
					    <i class="fa fa-angle-right"></i> 
					    <span>HTTP GET</span> </a>
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
				<a href="<?= url('/dev/sample') ?>"> <i class="fa fa-code icon"> 
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
		<div class="panel-body">
		    <div class="post-item">
			<div class="text-right"><a href="<?= url('/dev/app') ?>" class="btn btn-sm btn-success">Go to App Page</a></div>
			<div class="caption wrapper-lg"> 
			    <h4 class="h2 header post-title" id="introduction">
				Introduction
			    </h4> 
			    <div class="post-sum"> 
				<div id="introduction">
				    <p> API stands for Application Programming interface. Is the way one application (server side or client side) communnicate with other server to push or pull information </p>
				    <p>This API documentation explains how you can integrate karibuSMS SMS solution in your software and allow your software to send SMS by internet message or from your mobile phone</p>
				    <h4></h4>
				    <h4>Definition</h4>
				    <p>Based on this context</p>
				    <ul>
					<li>API - Application Programming Interface</li>
					<li>API KEY- special unique information that acts as a username of that application</li>
					<li>API SECRET- special information that acts as a password of that application</li>
				    </ul>
				</div>
				<div class="line"></div>
				<pre><h4><i class="fa fa-info-circle"></i> Note</h4>
 This API documentation support all languages, thus you can use any programming language to communicate with karibuSMS and send SMS. Sample source codes are provided for PHP, JAVA,  JavaScript and Python only for now
				</pre>
				<div class="line line-dashed"></div>
				<div id="keys">
				    <h4 class="h3 header post-title">Define KEYS</h4>
				    To be able to send SMS, you need to API KEYS and API SECRET. To obtain this.. 
				    <ol>
					<li>Create your new app</li>
					<li>After creating your app, you will get your API KEYS and API SECRET associated with that app name</li>
				    </ol>
				</div>
				<div class="line"></div>
				<div>
				    <h4 class="h3 header post-title">Send SMS</h4>
				    <p>To send SMS, you need to send JSON POST parameters to karibuSMS that have API_KEY, API_SECRET, message, karibusmspro, phone_number and name</p>
				    <section class="panel panel-default"> 
					<table class="table table-striped m-b-none text-sm"> 
					    <thead>
						<tr> 
						    <th></th> 
						    <th></th>
						</tr>
					    </thead> 
					    <tbody>
						<tr> 
						    <td>URI </td> 
						    <td>
							<pre>http://karibusms.com/api</pre>
						    </td>
						</tr>
						<tr> 
						    <td>HTTP VERB </td> 
						    <td>POST</td>
						</tr>
						<tr> 
						    <td>Params</td> 
						    <td>
							<pre>
	{
	    "phone_number": "255655406004",
	    "message": "Hello word message from karibuSMS",
	    "api_secret": API_SECRET,
	    "karibusmspro": 1,
	    "name": "KaribuSMS",
	    "api_key": API_KEY
	}
							</pre>
						    </td>
						</tr>
					    </tbody>
					</table>
				    </section>

				    <p><br/></p>
				    <h4 class="header">Parameters Meaning</h4>
				    <section class="panel panel-default"> 
					<table class="table table-striped m-b-none text-sm"> 
					    <thead>
						<tr> 
						    <th>Item</th> 
						    <th>Meaning/format</th>
						</tr>
					    </thead> 
					    <tbody>
						<tr> 
						    <td>phone_number</td> 
						    <td>
							A valid phone number started with country code number
						    </td>
						</tr>
						<tr> 
						    <td>message</td> 
						    <td>A text SMS that you want that phone number to receive</td>
						</tr>
						<tr> 
						    <td>api_secret</td> 
						    <td>A secret  code from APP name you have created</td>
						</tr>
						<tr> 
						    <td>api_key</td> 
						    <td>Key code from APP name you have created</td>
						</tr>
						<tr> 
						    <td>karibusmspro</td> 
						    <td><ul>
							    <li>1= Send Internet message. Your phone will not send this message but karibuSMS will send via internet</li>
							    <li>0= Send SMS from your phone. Your smart phone will send that SMS</li>

							</ul></td>
						</tr>
						<tr> 
						    <td>Name</td> 
						    <td>If karibusmspro=1, this NAME will be a sender name at the top of the message received by user.<br/>
							if karibusmspro=0, this is not be used</td>
						</tr>

					    </tbody>
					</table>
				    </section>
				    <br/><br/>
				    <h4 class="header">Server Return</h4>
				    <p>On sending that request to karibuSMS, karibuSMS server will return the following result</p>
				    <section class="panel panel-default"> 
					<table class="table table-striped m-b-none text-sm"> 
					    <thead>
						<tr> 
						    <th></th> 
						    <th></th>
						</tr>
					    </thead> 
					    <tbody>
						<tr> 
						    <td>On Success </td> 
						    <td>
							<pre>
	    {
		"success": 1,
		"sms_remain": 60,
		"message": "message sent successfully"
	    }
							</pre> 
							<p><b>sms_remain</b> : means internet messages remaining after sending this one SMS</p>
							NB; If you specify karibusmspro=FALSE; (SMS sent from your smartphone), sms_remain will always remain the same, it will not decrease because SMS from smartphones are not charged
						    </td>
						</tr>
					    </tbody>
					</table>
				    </section>

				    <h4 class="header">Error Messages</h4>
				    <section class="panel panel-default"> 

					<table class="table table-striped m-b-none text-sm"> 
					    <thead>
						<tr> 
						    <th></th> 
						    <th></th>
						</tr>
					    </thead> 
					    <tbody>
						<tr> 
						    <td>Type 1: wrong credentials</td> 
						    <td>
							<pre>
	    
	    {
		"success": 0,
		"message": "Wrong API_KEY or SECRET_KEY is supplied"
	    }
							</pre> 
							<p><b>Solution</b> : Make sure you have a right API KEY and API SECRET KEY obtained from karibuSMS App you have created</p>
						    </td>
						</tr>

						<tr> 
						    <td>Type 2: No App installed </td> 
						    <td><p>This error occurs when you have not installed karibuSMS app in your phone. This may also happened if you have karibuSMS app installed in your phone but you haven't login. </p>

							<pre>
	    {
		"success": 0,
		"message": "You do not have a latest karibuSMS app in your phone. Please download the latest version of karibuSMS in google play: http:\/\/goo.gl\/msamgD and login first in the android app"
	    }
							</pre>
							<p><b>Solution:</b>
							    Download latest version of karibuSMS  here https://goo.gl/APJaej <br/> and login in the smartphone application. If you have already installed this application, logout and login again in the smartphone application.</p>
						    </td>
						</tr>

						<tr> 
						    <td>Type 3: No SMS remain </td> 
						    <td><p>This error occurs when you have not installed karibuSMS app in your phone. This may also happened if you have karibuSMS app installed in your phone but you haven't login. </p>

							<pre>
	    {
		"success": 0,
		"message": "Insufficient credit, send your payments to us or contact us via info@karibusms.com"
	    }
							</pre>
							<p><b>Solution:</b>
							    Buy more SMS</p>
						    </td>
						</tr>

					    </tbody>
					</table>
				    </section>

				</div>
				<div class="line"></div>
				<br/>
				<h4 class="post-title h3 header">Get SMS Statistics</h4>
				<div id="statistics">
				    <p>In case you want to get statistics usage of your APP name, you can know that by calling JSON POST request to karibuSMS servers</p>
				    <section class="panel panel-default"> 
					<table class="table table-striped m-b-none text-sm"> 
					    <thead>
						<tr> 
						    <th></th> 
						    <th></th>
						</tr>
					    </thead> 
					    <tbody>
						<tr> 
						    <td>URI </td> 
						    <td>
							<pre>http://karibusms.com/api</pre>
						    </td>
						</tr>
						<tr> 
						    <td>HTTP VERB </td> 
						    <td>POST</td>
						</tr>
						<tr> 
						    <td>Params</td> 
						    <td>
							<pre>
	{
	    "tag": "get_statistics",
	    "api_secret": API_SECRET,
	    "api_key": API_KEY
	}
							</pre>
						    </td>
						</tr>
					    </tbody>
					</table>
				    </section>

				    <h5>Server Returns</h5>
				    <section class="panel panel-default"> 
					<table class="table table-striped m-b-none text-sm"> 
					    <thead>
						<tr> 
						    <th></th> 
						    <th></th>
						</tr>
					    </thead> 
					    <tbody>
						<tr> 
						    <td>On Success </td> 
						    <td>
							<pre>
	    {
		"sms_used": 1524,
		"sms_remain": 72,
		"app_name": "VIKINGS"
	    }
							</pre> 
							<p><b>sms_remain</b> : means internet messages remaining after sending this one SMS</p>
							<p><b>sms_used</b> : means total messages (from smartphone and internet) sent by this app name</p>

						    </td>
						</tr>
					    </tbody>
					</table>
				    </section>
				</div>
				<br/>
				<div class="line"></div>
				<h4 id="reports" class="post-title h3 header">Get SMS sent Report</h4>
				<p>With API, you can get total report of SMS you have sent to your contacts. This will also be done by sending JSON POST request to karibuSMS server as follows</p>
				<section class="panel panel-default"> 
				    <table class="table table-striped m-b-none text-sm"> 
					<thead>
					    <tr> 
						<th></th> 
						<th></th>
					    </tr>
					</thead> 
					<tbody>
					    <tr> 
						<td>URI </td> 
						<td>
						    <pre>http://karibusms.com/api</pre>
						</td>
					    </tr>
					    <tr> 
						<td>HTTP VERB </td> 
						<td>POST</td>
					    </tr>
					    <tr> 
						<td>Params</td> 
						<td>
						    <pre>
	{
	    "tag": "get_report",
	    "api_secret": API_SECRET,
	    "api_key": API_KEY,
	    "start_date":"YYYY-mm-dd",
	    "end_date":"YYYY-mm-dd"
	}
						    </pre>
						</td>
					    </tr>
					</tbody>
				    </table>
				</section>
				<h5>Server Returns</h5>
				<section class="panel panel-default"> 
				    <table class="table table-striped m-b-none text-sm"> 
					<thead>
					    <tr> 
						<th></th> 
						<th></th>
					    </tr>
					</thead> 
					<tbody>
					    <tr> 
						<td>On Success </td> 
						<td>
						    <pre>
{
    "success": "1",
    "messages": [
        {
            "message": "sending sms to test message lest",
            "phone": "255714825469",
            "karibusmspro": 1,
            "status": "1",
            "sent_time": "2016-07-14 21:47:55.59",
            "sender_name": "VIKINGS",
            "delivered_status": null
        },
        {
            "message": "sending sms to test message lest",
            "phone": "255714825469",
            "karibusmspro": 1,
            "status": "1",
            "sent_time": "2016-07-14 21:48:23.825",
            "sender_name": "VIKINGS",
            "delivered_status": null
        },
        {
            "message": "sending sms to test message lest",
            "phone": "255714825469",
            "karibusmspro": 0,
            "status": "1",
            "sent_time": "2016-07-14 21:48:25.365",
            "sender_name": "VIKINGS",
            "delivered_status": null
        },
        {
            "message": "sending sms to test message lest",
            "phone": "255714825469",
            "karibusmspro": 1,
            "status": "0",
            "sent_time": "2016-07-14 21:48:57.251",
            "sender_name": "VIKINGS",
            "delivered_status": null
        }
    ]
}
						    </pre> 
						    <p><b>karibusmspro</b> : 1=means internet message, means message sent from your smartphone </p>
						    <p><b>status</b> : 0=pending sms ,1=SMS already sent</p>
						    <p><b>sender_name</b> : correspond to APP name you have created or a name that you have specified while you send SMS</p>
						    <p><b>delivered_status</b> : status that show a message has been delivered or not</p>			</td>
					    </tr>
					</tbody>
				    </table>
				</section>
			    </div>
			    <div class="line line-lg"></div>
			    <h3 class="header" id="http_get">HTTP GET </h3>
			    <div class="post-item">
				<p>You can also send SMS by using HTTP GET URL method if you want. This method is simple but does not give you enough options as custom API and is only recommended for simple application with low SMS traffic</p>
				<div class="panel-body text-sm">
				    <hr>
				    <section class="panel panel-info"> 
					<div class="panel-body"> 
					    <a href="#" class="thumb pull-right m-l"></a>
					    <div class="clear">
						<pre> http://karibusms.com/api_call?message=YOUR_MESSAGE&amp;phone_number=255748XXXXXX&amp;karibusmspro=1&amp;api_key=API_KEY&amp;api_secret=API_SECRET</pre>
					    </div>
					</div> </section>
				  
				</div>
			    </div>
			    <div class="text-muted"> 

				<i class="fa fa-clock-o icon-muted"></i> Last updated July 15, 2016 
				<a data-toggle="ajaxModal" href="<?= url('/api/contact') ?>" class="m-l-sm "><i class="fa fa-comment-o icon-muted"></i>
				    Add your comment</a>
			    </div>
			</div> 
		    </div> 
		</div> 
	    </section>
	</div>

    </div>
</section>			

@stop