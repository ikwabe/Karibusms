<?php

/**
 * Description of payment_terms
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

<section id="content"> 
    <div class="bg-dark lt"> 
        <div class="container"> 
            <div class="m-b-lg m-t-lg">
                <h3 class="m-b-none">Payments Terms</h3> 
                <small class="text-muted"><small>Updated: 27th May 2016</small></small> 
            </div> 
        </div>
    </div>
    <div class="container m-t-xl">
        <div class="row">
            <div class="col-sm-7">
                <h2 class="font-thin m-b-lg">Introduction</h2>

                <p class="h4 m-b-lg l-h-1x"> 
                    <br/>KaribuSMS accept automated online and offline payments which allow customers and third parties to utilize payments methods to pay for the services or products..
		</p>
	    </div> 
            <div class="col-sm-5 text-center" data-ride="animated" data-animation="fadeInRightBig" >
                <div class="h3 font-bold m-t-xl m-b-xl">
		    <img src="media/images/mpesa.jpg" width="120" title="M-PESA payment" alt="M-PESA payment"/>
		    <img src="media/images/tigopesa.jpg" width="120" title="Tigopesa payment" alt="Tigopesa payment"/>
		    <img src="media/images/paypal.jpg" width="120" title="Paypal and bank payment" alt="Paypal and bank payment"/> 
                </div>
            </div> 
        </div> 
    </div>

    <div class="b-t b-light pos-rlt bg-white"> 
        <div class="container"> <p class="m-t-xl m-b-xl">Read payment terms..</p> </div> 
    </div>

</section>


<div class="container">

    <div class="h4">

        <b>Payment methods:</b><br/>
	<p>We currently accept four (4) kinds of payment methods</p>
	<ul>      
	    <li> M-pesa Mobile payments.<br/> </li>
	    <li> Tigo-pesa Mobile payments. <br/> </li>
	    <li> PayPal electronic bank payment <br/></li>
	    <li> Credit card for bank payments.<br/><br/></li>
	</ul>
        <b>Mobile payments:</b><br/>
	<p>Mobile  payment is  made available with KaribuSMS for customers who use mobile money to pay for karibuSMS. If you use mobile billing as a payment method, you consent to the following applicable terms:</p>

	<ul>
	    <li>By choosing the mobile billing payment method, you agree that we and your mobile operator may exchange information about you in order to facilitate completion or reversal of payments, resolution of disputes, provision of customer support, or other billing-related activity.</li>

	    <li> You are responsible for any charges, fees, changes to your mobile plan service or billing, alterations to your mobile device, or any other consequence that may arise out of your use of mobile billing.</li>

	    <li> If you use mobile billing, you are bound not only by karibuSMS Terms, but also by the terms and conditions of your mobile operator.</li>

	    <li> If you have questions about any charges or fees that appear on your mobile phone bill, you may contact your mobile provider’s customer service division.</li>
	    cases, we have the right, but not the obligation, to issue you a courtesy credit to your electronic value Balance.</li>
	</ul>

	<b>Bank payments:</b><br/>
	<p>Bank payment in karibuSMS is only accessed via PayPal gateway. If you use bank payment as a payment method, you consent to the following applicable terms:</p>

	<ul>
	    <li>By choosing bank payment method, you agree that we karibuSMS, PayPal and your bank  may exchange information about your account for billing only in order to facilitate completion or reversal of payments, resolution of disputes, provision of customer support, or other billing-related activity.</li>

	    <li> You are responsible for any charges, fees, changes to your bank plan service or billing, alterations to your bank account, or any other consequence that may arise out of your use of banking billing.</li>

	    <li> If your bank account for billing, you are bound not only by karibuSMS Terms, but also by the terms and conditions of your bank and PayPal company.</li>

	    <li> If you have questions about any charges or fees that appear on your bank account bill, you may contact your bank for more information.</li>
	</ul>
	<b>Charging Policy:</b><br/>
        <a href="<?= url('/') ?>" target="_blank">KaribuSMS</a> will charge the amount of money required for the service only. If you exceed the amount required to be paid for KaribuSMS service, the money exceed will be stored and added to your balance the next time you pay for the service. If you pay less than the amount required, you will not be able to access the service unless you complete the payment by adding the amount of money required. KaribuSMS will not refund back your money in case you have exceed the payment unless for special conditions.<br/><br/>
	<b>Refunding and Compensations:</b><br/>
        Except as otherwise stated, payments done to KaribuSMS are non-refundable to the full extent permitted by law.<br/><br/>
	<b>Payment Security:</b><br/>
        Its ours and yours responsibility to adhere to all security measures required to protect and not to disclose your payment information. Its our responsibility to protect your payment informations and not to disclose it to any unauthorized person<br/><br/>
	<p style="padding-top: 5em;"></p>
	<p align="center">If you have any question or comment on our payment terms.. <a data-toggle="ajaxModal" href="<?= url('/contact_us') ?>" >Click here</a></p>
	<p style="padding-top: 5em;"></p>
	<h4>You may also want to review the following</h4
	<ul>
	    <p><a href="<?= url('/')  ?>/privacy">KaribuSMS Use Terms</a></p>
	</ul>
    </div> 
</div>
<style>
    ul li{list-style-type: lower-alpha; } a{ color: #8ec165;}
</style>
@stop