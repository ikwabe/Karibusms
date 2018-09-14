
<?php
/**
 * Description of add_int_payment
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
		<section class="panel panel-default"> 
		    <header class="panel-heading font-bold">Add new payment form</header> 
		    <section class="panel-body">
			<!-- Page Header -->

			<!-- /pageheader -->

			<!--main content-->
			<div class="main-content" id="checkout_page">
			    <!--theme panel-->
			    <div id="span_loader"></div>
			    <div class="panel">
				<div class="panel-body">
				    <form class="form form-horizontal" id="myCCForm" action="<?= url('/') ?>/credit_card_payment" method="POST" onsubmit="return false">
					<!--		<div class="form-group">
							    <label class="col-sm-2 control-label">Contribution For:</label>
							    <div class="col-sm-8">
								<div class="col-sm-4">
								    <select id="contrib_month" class="name_search form-control">
					<?php
					//for ($x = 1; $x <= 12; $x++) {
					?>
									<option value="<?// $x ?>"><? //date('M', mktime(0, 0, 0, $x)) ?></option>
					
					<?php // }   ?>	
								    </select>
								</div>
								<div class="col-sm-4">
								    <select id="contrib_year" class="name_search form-control">
					<?php
					//for ($y =date('Y',  strtotime(Auth::user()->created_at)); $y<=date('Y'); $y++) {
					?>
									<option value="<? //$y ?>"><?// $y ?></option>
					<?php // }  ?>
								    </select>
								</div>
							    </div>
							</div>-->
					<!--Default Horizontal Form-->
					<div class="form-group">
					    <label class="col-sm-2 control-label">Credit Card Number:</label>
					    <div class="col-sm-8">
						<input type="text" class="form-control" id="ccNo" placeholder="Credit Card Number">
					    </div>
					</div>
					<!--Default Horizontal Form-->

					<!--Default Horizontal Form with password-->
					<div class="form-group">
					    <label class="col-sm-2 control-label">CVS:</label>
					    <div class="col-sm-8">
						<input type="tel" id="cvv" class="form-control" placeholder="CVS Number">
					    </div>
					</div>
					<!--Default Horizontal Form with password-->



					<!-- xselectize form   -->
					<div class="form-group">
					    <label class="col-sm-2 control-label">Card Expire Date:</label>
					    <div class="col-sm-8">
						<div class="col-sm-4">
						    <select id="expMonth" class="name_search form-control">
							<option value="01">Jan</option>
							<option value="02">Feb</option>
							<option value="03">Mar</option>
							<option value="04">Apr</option>
							<option value="05">May</option>
							<option value="06">Jun</option>
							<option value="07">Jul</option>
							<option value="08">Aug</option>
							<option value="09">Sep</option>
							<option value="10">Oct</option>
							<option value="11">Nov</option>
							<option value="12">Dec</option>
						    </select>
						</div>
						<div class="col-sm-4">
						    <select id="expYear" class="name_search form-control">

							<option value="16">2016</option>
							<option value="17">2017</option>
							<option value="18">2018</option>
							<option value="19">2019</option>
							<option value="20">2020</option>
							<option value="21">2021</option>
							<option value="22">2022</option>
							<option value="23">2023</option>
							<option value="24">2024</option>
							<option value="25">2025</option>
						    </select>
						</div>
					    </div>
					</div>
					<!-- xselect form   -->




					<!-- xsuccess-->
					<div class="form-group">
					    <label class="col-sm-2 control-label">Amount:</label>
					    <div class="col-sm-4">
						<div class="input-group">
						    <span class="input-group-addon bg">

							<i class="fa fa-usd"></i>
						    </span>
						    <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount">
						</div>
					    </div>

					    <div class="col-sm-4">
						<div class="input-group">

						    <span class="input-group-addon bg">

							= Tsh
						    </span>
						    <input type="number" disabled="disabled" class="form-control" name="amount" id="amount_tsh" placeholder="Amount">
						</div>
					    </div>
					</div>

					<!-- xsuccess-->
					<div class="form-group">
					    <label class="col-sm-2 control-label"></label>
					    <div class="col-sm-8">
						<button class="btn btn-primary btn-icon-primary btn-icon-block btn-icon-blockleft" id="process-payment-btn" >
						    <i class="ion ion-checkmark"></i>
						    <span>Process Payments</span>
						</button>
					    </div>
					</div>
				    </form>
				</div>
			    </div>
			    <!--theme panel-->
			</div>
			<?php
//$mode = 'sandbox';
//$PUBLISHABLE_KEY = $mode == 'sandbox' ?
//	'66A6A908-4E69-4F8D-AF2C-2DCEAB6D2FC1' :
			//'BEC71F48-E7C1-11E4-901D-5ECC3A5D4FFE';
			?>

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
<script src="<?= url('/') ?>/media/js/2co.js"></script>
<script src="<?= url('/') ?>/media/js/direct.min.js"></script>
<script>
					/*Called when token created successfully.*/
					var successCallback = function (data) {
					    var myForm = document.getElementById('myCCForm');

					    /*Set the token as the value for the token input
					     * Commented by Owden,enable progress bar
					     * */
					    $('#span_loader').html('<div class="alert alert-info">Please wait...............</div>');
					    // $('#span_loader').html(LOADER);
					    var token = data.response.token.token;
					    /*console.log(token);
					     IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.*/
//	var contrib_month=$('#contrib_month').val();
//	var contrib_year=$('#contrib_month').val()
					    $.ajax({
						url: $('#myCCForm').attr('action'),
						type: $('#myCCForm').attr('method'),
						data: 'token=' + token + '&amount=' + $('#amount').val(),
						dataType: 'JSON',
						success: function (response) {
						    console.log(response);
						    var status = (typeof response.status === "undefined") ? 'danger' : response.status;
						    $('#span_loader').html('<div class="alert alert-' + status + '">' + response.message + '</div>');
						    //$('#span_loader').html(response);
						    /*lets know the status of the payment. if its okay
						     then direct user to see a page with success, otherwise
						     show error message and allow user to make payment later*/
						},
						error: function (xhr, err, xhttperror) {
						    console.log(xhr);
						    $('#span_loader').html('<div class="alert alert-danger">' + xhr.message + '</div>');
						}
					    });
					    return false;
					    /*myForm.submit();*/
					};

					/*Called when token creation fails.*/
					var errorCallback = function (data) {
					    $('#span_loader').html('');
					    console.log(data);
					    if (data.errorCode === 200) {
						tokenRequest();
					    } else {
						$('#span_loader').html('<div class="alert alert-danger">' + data.errorMsg + '</div>');
					    }

					};

					var tokenRequest = function () {
					    /*Setup token request arguments*/

					    var args = {
						sellerId: "901314453", /*this is seller ID change dep on sand or live*/
						publishableKey: "66A6A908-4E69-4F8D-AF2C-2DCEAB6D2FC1",
						ccNo: $("#ccNo").val(),
						cvv: $("#cvv").val(),
						expMonth: $("#expMonth").val(),
						expYear: $("#expYear").val()
					    };

					    /* Make the token request*/
					    TCO.loadPubKey('sandbox', function () {
						TCO.requestToken(successCallback, errorCallback, args);
					    });
					};

					$(function () {
					    /*Pull in the public encryption key for our environment*/
					    TCO.loadPubKey('sandbox');
					    $("#process-payment-btn").click(function (e) {
						/*Call our token request function
						 * Commented by Owden Godson
						 * */
						$('#span_loader').html('<div class="alert alert-info">Please wait...............</div>');

						tokenRequest();
						//$('#span_loader').html('');

						/*Prevent form from submitting*/
						return false;
					    });
					});

					equivalentTsh = function () {
					    $('#amount').keyup(function () {
						var usd = $(this).val();
						var eq = usd * 2150;
						$('#amount_tsh').val(eq);
					    });
					};
					equivalentTsh();
</script>