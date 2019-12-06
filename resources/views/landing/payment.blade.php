<?php
/**
 * @author Ephraim Swilla<swillae1@gmail.com>
 * 
 */
?>
@extends('master')
@section('content')

<section id="content"> 
    <div class="bg-dark lt"> 
        <div class="container"> 
            <div class="m-b-lg m-t-lg">
                <h3 class="m-b-none">Plans & Pricing</h3>
                <small class="text-muted">Choose the plan that best fits your needs</small>
            </div> 
        </div> 
    </div> 
    <div class="bg-white b-b b-light">
        <div class="container"> 
            <ul class="breadcrumb no-border bg-empty m-b-none m-l-n-sm">
                <li><a href="<?= url('/') . '/' ?>">Home</a></li> 
                <li class="active">Price</li> 
            </ul>
        </div> 
    </div>
    <div class="container"> 
        <div id="testing"></div>
        <?php if (session('client_id') != null) { ?>
            @include('landing.pricing')
        <?php } else {
            ?>
            <div class="bg-white b-t b-light pos-rlt">
                <div class="container"> 
                    <div class="row m-t-xl m-b-xl"> 
                        <div class="col-sm-5 text-center clearfix m-t-xl" data-ride="animated" data-animation="fadeInLeftBig"> 
                            <div class="h3 font-bold m-b-xl">
                                <img src="media/images/blessed_emoji.png" width="70%" title="Feeling Blessed with karibuSMS" alt="Feeling Blessed with karibuSMS"/>
                                <p>We know you are doing business, and we want to help you do it better..</p>
                            </div> 
                        </div> 
                        <div class="col-sm-7">
                            <h2 class="font-thin m-b-lg">Pricing Options</h2> 
                            <p class="h4 m-b-lg l-h-1x">
                                karibuSMS provide AFFORDABLE pricing for BulkSMS on volume based depends on your needs
                                <br/>
                                <br/>
                                All payments in karibuSMS can be done by 
                            </p> 
                            <ul class="m-b-xl fa-ul"> 
                                <li><i class="fa fa-li fa-check text-muted"></i>Mobile Payments</li>
                                <li><i class="fa fa-li fa-check text-muted"></i>Credit/Debit Cards</li> 
                                <li><i class="fa fa-li fa-check text-muted"></i>Direct Bank deposit</li> 
                            </ul> 
                        </div> </div>
                </div> 
            </div> 
            <p>To do payment, you need to follow the following simple steps</p>
            <ol>
                <li>After login, in your dashboard, click payment link.</li>
                <li>Then specify number of SMS you want to buy. System will generate your invoice which you can print if you want to</li>
                <li>send money with your preferred method  and your payment will be confirmed with SMS provision as you want. </li>
            </ol>
        <?php }
        ?>

    </div>
    <div class="bg-white-only">
        <div class="container">
            <div class="m-t-xl m-b-xl"> <h2 class="font-thin">Why many business have chosen us</h2> </div>
            <div class="row m-b-xl"> 
                <div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="300"> 
                    <span class="fa-stack fa-2x pull-left m-r m-t-xs"> 
                        <i class="fa fa-circle fa-stack-2x text-info"></i> 
                        <i class="fa fa-stack-1x fa-inverse">1</i> </span>
                    <div class="clear">
                        <h4>Simple to use application and scale your contacts</h4> 
                        <p class="text-muted text-sm"> You can create groups (category) of contacts, allow other people to subscribe to your account (option feature), send internet messages or let your phone send SMS.<br><br>
                            karibuSMS is yet allow you to request any feature to be added in your profile and we will add it for you.</p> 
                    </div> 
                </div>
                <div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="600"> 
                    <span class="fa-stack fa-2x pull-left m-r m-t-xs"> 
                        <i class="fa fa-circle fa-stack-2x text-info"></i>
                        <i class="fa fa-stack-1x fa-inverse">2</i>
                    </span> 
                    <div class="clear"> <h4>Customer support</h4>
                        <p class="text-muted text-sm">We provide consistent support to ensure you full get what you want. For many business and organization or individuals, we offer technical support, training (in case you want upgraded features) and other materials to ensure you fully use application for your benefits..<br><br>Start now to Manage well your contacts and share information with karibuSMS</p> 
                    </div> 
                </div> 
                <div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="900"> 
                    <span class="fa-stack fa-2x pull-left m-r m-t-xs">
                        <i class="fa fa-circle fa-stack-2x text-info"></i> 
                        <i class="fa fa-stack-1x fa-inverse">3</i> 
                    </span> 
                    <div class="clear"> 
                        <h4>Extensible technology</h4> 
                        <p class="text-muted text-sm">Our solution is flexible, easy to be integrated with other systems and yet you can decide whether to use it over the cloud or have it intergrated in your office computer softwares to send SMS notifications</p>
                        <p>If you are a software developer, visit our API page here <a href="<?= url('/') ?>/api" target="_blank" class="badge badge-success">www.karibusms.com/api</a></p>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
</section> <!-- footer --> 
@stop