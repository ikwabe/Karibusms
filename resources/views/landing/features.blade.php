
@extends('master')
@section('content')

<section id="content">
    <div class="bg-dark lt">
        <div class="container"> 
            <div class="m-b-lg m-t-lg"> <h3 class="m-b-none">Features</h3> 
                <small class="text-muted">What you need to know</small>
            </div> 
        </div>
    </div> 
    <div class="bg-white b-b b-light">
        <div class="container">
            <ul class="breadcrumb no-border bg-empty m-b-none m-l-n-sm">
                <li><a href="<?= HOME ?>">Home</a></li> <li class="active">Features</li>
            </ul>
        </div> 
    </div> 
    <div> <div class="container m-t-xl">
            <div class="row"> 
                <div class="col-sm-7"> 
                    <h2 class="font-thin m-b-lg">What is
                        <span class="text-primary">karibuSMS? </span>
                        <span class="text-primary"></span> 
                        <span class="text-primary"></span>
                    </h2>
                    <p class="h4 m-b-lg l-h-1x">
                        It is the SMS & Contacts management platform that helps you or your business, organization and others to easily manage contacts and share information using SMS.
                    <div class="font-bold m-t-xl m-b-xl"><span class="fa-2x icon-muted">Where can it be used?</span> </div>
                    </p>
                    <p>KaribuSMS can be used by companies, organizations, supermarkets and individuals to</p>
                    <div class="row m-b-xl"> 
			 <div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i>Store customer contacts and other information </div>
                        <div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i>Inform customers about offers</div>
                        <div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i>Send SMS reminders and Emails for events/appointments or new arrivals</div>
                        <div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i>Notify them about new product(s) or service(s)</div>
			 <div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i>Automate SMS/ Email campaigns </div>
                        <div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i>Create promotional SMSs </div>
                        <div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i>And so much more....</div>
                    </div> 
                    <div class="row m-b-xl">
			<div class="font-bold m-t-xl m-b-xl"><span class="fa-2x icon-muted">KaribuSMS features</span> </div>
                        <div class="col-sm-6"> <i class="fa fa-fw fa-angle-right"></i>Can send either internet messages or smartphone SMS </div>
<!--			<div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i> Upload in your profile, products and services you have for customers to view  </div>-->
			<div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i>Free SMS and paid SMS plan according to your needs </div>
			<div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i>Promote your website with SMS  </div>
<!--			<div class="col-sm-6"><i class="fa fa-fw fa-angle-right"></i> Customer can subscribe to your business with keyword KARIBU BUSINESSNAME to 15573 </div>-->
                    </div>
                </div> 
                <div class="col-sm-5 text-center"> 
                    <section class="panel bg-dark inline aside-md no-border device phone animated fadeInRightBig">
                        <header class="panel-heading text-center">
                            <i class="fa fa-minus fa-2x icon-muted m-b-n-xs block"></i>
                        </header> <div class="m-l-xs m-r-xs"> 
                            <div class="carousel auto slide" id="c-fade" data-interval="3000">
                                <div class="carousel-inner"> 
                                    <div class="item active text-center"> 
                                        <img src="media/images/phone-2.png" class="img-full" > 
                                    </div> 
                                    <div class="item text-center"> 
                                        <img src="media/images/phone-1.png" class="img-full" > 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                        <footer class="bg-dark text-center panel-footer no-border"> <i class="fa fa-circle icon-muted fa-lg"></i> </footer>
                    </section>
                </div> 
            </div> 
        </div> 
    </div> 

    <div class="bg-white b-t b-light"> 
        <div class="container"> 
            <div class="row m-t-xl m-b-xl"> 
                <div class="col-sm-5 text-center clearfix m-t-xl" data-ride="animated" data-animation="fadeInLeftBig"> 
                    <div class="h2 font-bold m-t-xl m-b-xl">
                        <span class="fa-2x icon-muted"><a href="#">{KARIBU}</a></span>
                    </div> 
                </div> 
                <div class="col-sm-7"> 
                    <h2 class="font-thin m-b-lg">How it works</h2> 
		    <p class="h4 m-b-lg l-h-1x">
		    <h4 class="font-thin m-b-lg">With Internet SMS</h4> 
                    <ol>
                        <li>Create your account and log in </li>
                        <li>In the home page, create your message and send to either all of your contacts, one by one or custom selection</li>

                    </ol>
                    <p class="h4 m-b-lg l-h-1x">
		    <h4 class="font-thin m-b-lg">With your Smartphone</h4>
                    <ol>
                        <li>Download karibuSMS application , 
                            <a href="https://goo.gl/APJaej" target="_blank" class="label label-success">click here</a> and create your account or log in if you already have karibuSMS account</li>
                        <li>
			    <ul>
				<h4>With karibuSMS android App</h4>
				<li>Login, create SMS and send. Message will be sent to all numbers contacts that you have uploaded in karibuSMS (not to your phone contact lists)</li>
			    </ul>
			    <br/>
			    <ul>
				<h4>With karibuSMS website</h4>
				<li>Log into <a href="<?php ?>">karibuSMS website</a>, go to SMS tab and compose your message with option either to send Internet Message or SMS from your phone</li>
				<li>If you choose phone SMS, karibuSMS will find your smartphone and command it to send SMS to all numbers you have specified in website</li>
			    </ul>
			</li>

                    </ol>
                    <p>N:B: Your phone needs to be connected with internet and it should have SMS plan from your network provider in order to send SMS to numbers you have specified.</p>
<!--                    <p class="m-t-xl m-b-xl h4"><i class="fa fa-quote-left fa-fw fa-1x icon-muted"></i> Customers will
                        subscribe to your business by send SMS 
                        with keyword KARIBU BUSINESSNAME to <? $SUBSCRIPTION_NUMBER ?></p>
                    </p>
                    <p class="m-b-xl">Then:<br/>
                        You can send SMS to your customers by either
                        <br/>
                    <ul>
                        <li>Open the karibuSMS application in your phone and send a message</li>
                        <ul>OR</ul>
                        <li>Login in your account on <a href="<? HOME ?>">www.karibusms.com</a> and compose SMS to send to all</li>
                        <ul>OR</ul>
                        <li>Use the phone number you register your business with here, start with keyword KARIBU followed by 
                            SMS you would like your customers to read and send it to <? $SUBSCRIPTION_NUMBER ?></li>
                    </ul>
                    </p> -->
                    <p class="m-t-xl m-b-xl h4"><i class="fa fa-quote-left fa-fw fa-1x icon-muted"></i> We make very simple for you</p>
                    <p><a href="<?= HOME ?>register">Do you need to integrate SMS in your system /software ? <a href="<?= HOME ?>api" class="label label-success">click here</a> (if you are a software developer) or contact us via <a href="mail: info@karibusms.com" class="label label-info">Email</a> (free integration). karibuSMS can be simply integrated with banks, hospital systems, radio stations and any application to send SMS to people</p>
                </div>

            </div> 
        </div> 
    </div>

    <div class="b-t b-light"> 
        <div class="container m-t-xl"> 
            <div class="row">
                <div class="col-sm-7"> 
                    <h2 class="font-thin m-b-lg">Do business with us</h2> 
                    <p class="h4 m-b-lg l-h-1x">
			We provide different options for you to work with us and grow together. You can work with karibuSMS as 
                    </p> 
                    <ul>
                        <p><i class="fa fa-fw fa-angle-right"></i>Partner</p>
                        <p><i class="fa fa-fw fa-angle-right"></i>Reseller</p>
                        <p><i class="fa fa-fw fa-angle-right"></i>Marketer</p>
                    </ul>

                    <p class="m-b-xl">
                        For any request, feel free to send your interest to <a href="mailto:info@karibusms.com" class="label label-info h3">info@karibusms.com </a> or call us now +255 655 406 004
                    </p> 
                    <p class="clearfix">&nbsp;</p>
		    <!--                    <div class="row m-b-xl">
					    <div class="col-xs-2"><i class="fa fa-desktop fa-4x icon-muted"></i></div>
					    <div class="col-xs-2"><i class="fa fa-plus icon-muted m-t"></i></div>
					    <div class="col-xs-2"><i class="fa fa-tablet fa-4x icon-muted"></i></div>
					    <div class="col-xs-2"><i class="fa fa-plus icon-muted m-t"></i></div> 
					    <div class="col-xs-2"><i class="fa fa-mobile fa-4x icon-muted"></i></div>
					</div>-->
                </div> 
                <div class="col-sm-5 text-center" data-ride="animated" data-animation="fadeInUp" > 
                    <section class="panel bg-dark m-t-lg m-r-n-lg m-b-n-lg no-border device animated fadeInUp"> 
                        <header class="panel-heading text-left"> 
                            <i class="fa fa-circle fa-fw icon-muted"></i> 
                            <i class="fa fa-circle fa-fw icon-muted"></i> 
                            <i class="fa fa-circle fa-fw icon-muted"></i> 
                        </header> 
                        <img src="media/images/back.png" class="img-full" >
                    </section>
                </div>
            </div>
        </div> 
    </div> 

    <div class="bg-white b-t b-light pos-rlt">
        <div class="container"> 
            <div class="row m-t-xl m-b-xl"> 
                <div class="col-sm-5 text-center clearfix m-t-xl" data-ride="animated" data-animation="fadeInLeftBig"> 
                    <div class="h3 font-bold m-t-xl m-b-xl">
			<?php if (COUNTRTY_CODE == 'KY') { ?>
    			<img src="media/images/mpesa_kenya.jpg" width="40%" height="50%" title="M-PESA payment" alt="M-PESA payment"/>

			<?php } else { ?>
    			<img src="media/images/mpesa.jpg" width="80" title="M-PESA payment" alt="M-PESA payment"/>
    			<img src="media/images/tigopesa.jpg" width="80" title="Tigopesa payment" alt="Tigopesa payment"/>
    			<img src="media/images/paypal.jpg" width="90" title="Bank Cards payment" alt="Paypal and bank payment"/> 
			<?php } ?>

                    </div> 
                </div> 
                <div class="col-sm-7">
                    <h2 class="font-thin m-b-lg">Payments Option</h2> 
                    <p class="h4 m-b-lg l-h-1x">
                        karibuSMS provide FREE SMS pricing option and paid Internet SMS solution depends on customer needs
                        <br/><br/>
			All payments in karibuSMS can be done by 
                    </p> 
                    <ul class="m-b-xl fa-ul"> 
			<?php if (COUNTRTY_CODE == 'KY') { ?>
    			<li><i class="fa fa-li fa-check text-muted"></i>Mobile Payments (M-pesa)</li>

			<?php } else { ?>
    			<li><i class="fa fa-li fa-check text-muted"></i>Mobile Payments (M-pesa, Tigo-Pesa)</li>
                            <li><i class="fa fa-li fa-check text-muted"></i>Credit/Debit Cards (Bank Cards)</li> 
                            <li><i class="fa fa-li fa-check text-muted"></i>Direct Bank deposit</li> 

			<?php } ?>
		    </ul> 
                </div> </div>
        </div> 
    </div> 
    
    <div class="b-t b-light pos-rlt bg-white"> <div class="container"> 
            <p class="m-t-xl m-b-xl center">
	    <div class="m-t-sm m-b-lg text-center" id="social_media_links">
		<p> <a  id="twitter_button" title="twitter" href="https://twitter.com/karibuSMS" class="twitter-follow-button" data-show-count="true" data-lang="en">Follow @karibuSMS</a>

		    <a href="#" title="Facebook">
			<div class="fb-like" data-href="http://karibusms.com" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>

		    </a> 
		    <!-- Place this tag in your head or just before your close body tag. -->
		    <script src="https://apis.google.com/js/platform.js" async defer></script>
		    <link rel="canonical" href="http://www.karibusms.com" />
		    <!-- Place this tag where you want the +1 button to render. -->
		<div class="g-plusone" data-annotation="inline" data-width="300"></div>
		</p>

	    </div> </p>
        </div> 
    </div>
</section> <!-- footer --> 
@stop
<?php
//require_once 'modules/landing/feature_footer.php';

//js_media('appear/jquery.appear');
//js_media('scroll/smoothscroll');
//js_media('landing');
?>
