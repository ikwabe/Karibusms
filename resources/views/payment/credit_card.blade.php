<?php
/**
 * Description of credit_card
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<section class="vbox">
    <section class="scrollable padder">
	<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	    <li><a href="<?= url('/') ?>"><i class="fa fa-home"></i> Home</a></li> 
	    <li><a href="#">Payment</a></li> 
	    <li class="active"><a href="#">Add New</a></li>
	</ul>

	<div class="m-b-md"> <h3 class="m-b-none">Add New Payment</h3> </div>

	<div class="row"> 
	    <div class="col-lg-6">
		<section class="panel panel-default"  id="checkout_page"> 
		    <header class="panel-heading font-bold">Information Validation</header> 
		    <div class="alert alert-warning">
			Please validate the information below if they are correct for your payment to be accepted from your BANK</div>
		    <section class="panel-body">
			<!-- Page Header -->

			<!-- /pageheader -->

			<!--main content-->
			<div class="main-content">
			    <!--theme panel-->
			    <div id="span_loader"></div>
			    <div class="panel">
				<div class="panel-body">
				    <form class="form form-horizontal" id="mycard_form" action="<?= url('/') ?>/tocheckout" method="POST" onsubmit="return false">

					<!--Default Horizontal Form-->
					<div class="form-group">
					    <label class="col-sm-4 control-label">Number of SMS:</label>
					    <div class="col-sm-6">
						<input type="text" class="form-control" id="csms" placeholder="No of SMS"><span>Specify SMS you buy</span>
					    </div>
					</div>
					<!--Default Horizontal Form-->

					<!--Default Horizontal Form with password-->
					<div class="form-group">
					    <label class="col-sm-4 control-label">Card Holder Name:</label>
					    <div class="col-sm-6">
						<input type="tel" id="cname" value="<?= $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname ?>" class="form-control" placeholder="Card Holder Name">
						<span>As it appear in your BANK card</span>
					    </div>

					</div>
					<div class="form-group">
					    <label class="col-sm-4 control-label">City:</label>
					    <div class="col-sm-6">
						<input type="tel" id="city" value="<?= $user->city ?>" class="form-control" placeholder="City Name">
						<span>Current city</span>
					    </div>

					</div>
					<div class="form-group">
					    <label class="col-sm-4 control-label">Email:</label>
					    <div class="col-sm-6">
						<input type="tel" id="email" value="<?= $user->email ?>" class="form-control" placeholder="Email">
						<span>Valid Email</span>
					    </div>

					</div>

					<!-- xsuccess-->
					<div class="form-group">
					    <label class="col-sm-4 control-label"></label>
					    <div class="col-sm-8">
						<button class="btn btn-primary btn-icon-primary btn-icon-block btn-icon-blockleft" id="process-payment-btn" onmousedown="go_tocheckout()">
						    <i class="ion ion-checkmark"></i>
						    <span>Continue To Process</span>
						</button>
					    </div>
					</div>
				    </form>
				</div>
			    </div>
			</div>

		    </section> 
		</section>
	    </div> 
	    <div class="col-sm-6"> 
		<section class="panel panel-default">
		    <header class="panel-heading font-bold">Notes</header>
		    <div class="panel-body">
			<div class="form-group">
			    <div class="row">
				<div class="col-sm-8">
				    <p><img src="<?= url('/') ?>/media/images/payments.png"/></p>
				    <p>
					&nbsp;Master Cards,
					&nbsp;Visa Cards,
					&nbsp;American Express,
					&nbsp;etc.</p>
				</div>

			    </div>
			</div>
			<div class="form-group">
			    <p>Our payment channel is highly secured and meet all international standards of payments and money transfer. For more about our policies, just read our policies <a href="<?= url('/payment_terms') ?>" target="_blank" class="badge badge-success">here </a></p>
			    <a href="" target="_blank" style="display: none" id="invoice_link" class="btn btn-sm btn-success"><i class="fa fa-download"></i>Download your Invoice</a>
			</div>
		    </div>
		</section>
	    </div> 
	</div>
    </section>
</section>
<script type="text/javascript">
    go_tocheckout = function () {
	var data = {
	    name: $('#cname').val(),
	    sms: $('#csms').val(),
	    city: $('#city').val(),
	    email: $('#email').val()
	};
	if (data.name == '' || data.sms == '' || data.city == '' || data.email == '') {
	    $.each(data, function (k, v) {
		//display the key and value pair
		if (typeof (v) == 'undefined' || v === '') {
		    swal('Note !', k + ' field cannot be empty', 'warning');
		    return false;
		}
	    });
	} else if (data.sms >= 1000) {
	    $.get('tocheckout', data, function (server) {
		$('#checkout_page').html(server);
		var str = jQuery.param( data );
		push_url('tocheckout?'+str);
	    });
	} else {
	    swal('Note !', 'Minimum number of SMS to buy is 1000 ', 'warning');
	}
    }
</script>