<?php
/**
 * Description of checkout
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
  <header class="panel-heading font-bold">Payment summary</header> 
		   
<div class="panel">
    <div class="panel-body">
	<form class="form form-horizontal" id="myCCForm">

	    <div class="form-group">
		<label class="col-sm-4 control-label">Number of SMS:</label>
		<div class="col-sm-4">
		    <span>{{$sms}}</span>
		</div>
	    </div>


	    <!-- xsuccess-->
	    <div class="form-group">
		<label class="col-sm-4 control-label">Amount:</label>
		<div class="col-sm-4">
		    <div class="input-group">
			<span class="input-group-addon bg">

			    <i class="fa fa-usd"></i>
			    {{$price}}
			</span>

		    </div>
		</div>

	    </div>
	    <!--Default Horizontal Form-->

	    <!--Default Horizontal Form with password-->
	    <div class="form-group">
		<label class="col-sm-4 control-label">Invoice Number:</label>
		<div class="col-sm-4">
		    #{{$invoice}}
		</div>
	    </div>
	    <!--Default Horizontal Form with password-->



	    <!-- xsuccess-->
	    <div class="form-group">
		<label class="col-sm-4 control-label"></label>
		<div class="col-sm-4">


		</div>
	    </div>
	</form>
	 <div class="form-group">
		<label class="col-sm-4 control-label"></label>
		<div class="col-sm-4">
	<form action='https://www.2checkout.com/checkout/purchase' method='post'>
	    <!--<input type='hidden' name='sid' value='901314453' /> sandbox-->
	    <input type='hidden' name='sid' value='102514285' />
	    <input name="return_url" type="hidden" value="http://karibusms.com/payment/status">
	    <input type='hidden' name='mode' value='2CO' />
	     <input type='hidden' name='currency' value='USD' />
	    <input type='hidden' name='li_0_type' value='product' />
	    <input type='hidden' name='li_0_name' value='{{$invoice}}' />
	    <input type='hidden' name='li_0_price' value='{{$price}}' />
	    <input type='hidden' name='card_holder_name' value='{{$cardname}}' />
	    <input type='hidden' name='street_address' value='{{$user->location}}' />
	    <input type='hidden' name='street_address2' value='{{$user->location}}' />
	    <input type='hidden' name='city' value='{{$user->location}}' />
	    <input type='hidden' name='state' value='TZ' />
	    <input type='hidden' name='zip' value='43228' />
	    <input type='hidden' name='country' value='{{$user->country}}' />
	    <input type='hidden' name='email' value='{{$user->email}}' />
	    <input type='hidden' name='phone' value='{{$user->phone_number}}' />
	    <input name="paypal_direct" type="hidden" value="Y">
	    <input name='submit' class="btn btn-warning btn-icon-primary btn-icon-block btn-icon-blockleft" type='submit'  value='Checkout Now' />
	</form>
		    </div>
	    </div>
    </div>
</div>

<script src="https://www.2checkout.com/static/checkout/javascript/direct.min.js"></script>