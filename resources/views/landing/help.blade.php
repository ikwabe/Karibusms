<?php
/**
 * Description of help
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
 *   karibusms.com
 * * @author Ephraim Swilla <swillae1@gmail.com>
 */
?>
@extends('master')
@section('content')
<section class="hbox stretch"> <!-- .aside --> 
    <aside class="bg-light aside b-r animated fadeInLeftBig">
        <section class="vbox"> 

            <section class="scrollable"> 
                <nav class="nav-primary hidden-xs nav-docs"> 
                    <ul class="nav">
                        <li class="dropdown-header b-b b-light"><em>overview</em></li>
                        <li><a href="#">Get customers</a></li> 
                        <li><a href="#send_sms">Send SMS</a></li>
                        <li><a href="#buy_sms">Buy SMS</a></li>

                    </ul>
                </nav> 
            </section>
        </section>
    </aside> <!-- /.aside --> 

    <section id="content"> 
        <section class="vbox"> 
            <section class="scrollable bg-light lter" data-spy="scroll" data-target=".nav-primary"> 
                <section id="docs"> 
                    <div class="clearfix padder"> 
                        <div id="printstyle1">
                            <h3>Overview help manual</h3> 
                            <h5 class="m-t-lg"><strong>KaribuSMS</strong> help you to be close to your customers and let them subscribe to your business to get 
                                news and updates from your business</h5>
                            <h4>Features:</h4> 
                            <ul> 
<!--                                <li>Customers subscribe with SMS having keyword KARIBU BUSINESSNAME to <? $SUBSCRIPTION_NUMBER ?></li>-->
                                <li>Your customers' contact will be stored in your page</li>
                                <li>An interface that allow you to send SMS at once to all your customers</li>
                                <li>Customer with any kind of mobile phone is able to receive SMS for free</li> 
                                <li>You can send up to unlimited number of SMS at once</li>
                                <li>Highly customized interface</li>
                                <li>Custom support for your business or organization</li> 
                                <li>Customers do not need internet to receive SMS</li>
                                <li>Support both local and international SMS routing</li>
                            </ul> 
<!--                            <h3 class="text-success">How to get customers</h3>
                            <div class="line"></div>
                            <p id="bootstrap">KaribuSMS let your customers subscribe to your business by sending SMS with keyword KARIBU BUSINESSNAME to 
                                <strong>
                                    <a href="#"><? $SUBSCRIPTION_NUMBER ?></a></strong>
                            </p>
                            <p>Recommended procedures </p><br/>
                            <ul>
                                <li>Create account with business name easy to be remembered</li>
                                <li>Create a username that you want your customer to receive SMS having that name</li>
                                <li>Print a poster that show your customer which keyword they should subscribe to</li>

                            </ul>-->
                        </div>
<!--                        <section class="scrollable wrapper">
                            <div class="buttonstn-group btn-group-justified">
                                <div class="col-lg-6 doc-buttons" id='page_info'><a data-toggle="ajaxModal" href="<?php // $AJAX  ?>&pg=home&section=page_info" class="btn btn-s-md btn-primary">View your page information</a> </div>
                                <div class="col-lg-6 doc-buttons" id='sample_add'><a data-toggle="ajaxModal" href="<?php // $AJAX  ?>&pg=home&section=sample_add" class="btn btn-s-md btn-info">Your sample add for your business</a></div>
                            </div>
                        </section>-->

                        <div id="printstyle2">
                            <h4 id="send_sms" class="text-success">How to send sms from Android Phone</h4> 

                            <p>
                            <ol> 
                                <li>After successful signin in your android smartphone karibuSMS app, you will see a text area.</li>
                                <li>Write anything that you want your customers to know about your business and click a send message button.</li>

                                <li> With that, a message will be sent to all your customers</li>
                            </ol>
                            </p> 

                            <!--<p>N.B: DEMOPAGE- Is a business name that you register in this application</p><br/>-->

                            <h4 id="buy_sms" class="text-success">How to recharge your account</h4>
                            <p>These are simple steps taken to recharge your account</p>
                            <ol>
                                <li>Choose what cost real suite your needs and send the amount of money specified using M-pesa or TigoPesa to 0655 406 004.For those who are not in Tanzania or prefer other meeans of payment, please contact us at <a href="mail: sales@karibusms.com">sales@karibusms.com</a> 
				    <!--Paypal and bank payments can be made in web based only for karibusms pro messaging-->
				</li>
                                <li>After successful payment, you will receive SMS from TigoPesa or Mpesa having verification code (reference number) to ensure you that you have sent money successfully</li>
                                <li>After short time, your payment will be approved and you will get your receipt in your email indicating you that we have received payment successfully </li>
                                <!--<li>If you are in home page of web application, Click an arrow icon appear in top banner with this icon <a href="<?= HOME ?>payment" class="dropdown-toggle btn btn-xs btn-primary" title="Upgrade"><i class="fa fa-long-arrow-up"></i></a></li>-->
                                <!--<li>If you are in karibuSMS mobile application, click payment tab</li>-->
                                <!--<li>Enter those verification code in payment tab (for karibuSMS mobile application) or if you are in web based in payment tab, choose either tigopesa or mpesa and enter those codes</li>-->
                            </ol>

                            @include('landing.pricing')
                        </div>
                </section>
            </section> 
        </section> 
    </section> 
</section>
@stop