<?php
/**
 * Description of add_payment
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

        <div class="row" id="load_payment_page"> 
	    <div class="col-lg-6" id="load_excel_page">
		<section class="panel panel-default"> 
		    <header class="panel-heading font-bold">Add new payment form</header> 
		    <section class="panel-body">
			
			<?php
			/**
			 * ------------------------------------------------
			 * We comment this only while we are going live
			 * 
			 * Soon after SSL installation, we will enable this
			 * --------------------------------------------------
			 * 
			 */
			
			?>
			
<!--			<p>Do you want to pay by Bank Card (Visa, MasterCard, Discover etc) ? 
			    <a  onmousedown="call_page('pay_by_card')" class="btn btn-s-md btn-warning">Click here</a></p>-->
			
			<?php
			/**
			 * End of comments
			 */
			?>
			<form role="form" class="form-horizontal" id="add_payment" action="<?= url('/') ?>/add_payment_submit" onsubmit="return false"> 

			    <div class="form-group"> 
				<label class="col-sm-2 control-label">Price</label>
				<div class="col-sm-4">
Tsh 19.95/= per SMS
				</div>

			    </div>

			    <div class="form-group"> 
				<label class="col-sm-2 control-label">Number of SMS</label>
				<div class="col-sm-4">
                                    <input type="number" min="500" value='500' id="sms_no" name="sms_number" class="form-control " placeholder="Number of SMS"> </div>
				<span>Minimum number of SMS is 1000</span>
			    </div>


			    <div class="form-group"> 
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-10"> 
                                    <input type="submit" value="Proceed" class="btn btn-success" onmousedown="get_invoice()"/>
				</div>

			    </div>



			    <div class="panel-body">
				<div class="form-group" id="mobile" style="display: none">
				    <p>To pay by <b class="mobile_type">M-PESA</b>, please follow the following simple steps</p>
				    <ol>
					<li>Open your <b class="mobile_type">M-PESA</b></li>
					<li>Send money to M-pesa number 0754406004 (INETS COMPANY LIMITED)</li>
					<li>You will receive SMS confirmation from <b class="mobile_type">M-PESA</b>. </li>
					<li>Click the button below "Add payment" and enter transaction codes your receive from <b class="mobile_type">M-PESA</b></li>
					<li>Wait for few seconds and your payments will be accepted and receipt will be in your payment report page</li>
				    </ol>


				</div>
				<div class="form-group" id="bank" style="display: none">
				    <p>We accept BANK Direct Payments, please use the following details</p>
				    <ul>
					<li>Bank Name: <b>NMB Bank</b></li>
					<li>Account Name: <b>Inets Company Limited</b></li>
					<li>Account  Number:  <b>22510028669</b> </li>
					<li>After Deposit, please CALL us via<b><a href="#">+255655406004</a></b> and we will process your order as soon as possible</li>
				    </ul>


				</div>
			    </div>

			    <span id="loader"></span>

			    <div class="form-group">
				<label class="col-sm-2 control-label"></label> 
				<div class="col-sm-10">
				    <button type="submit" id="add_receipt" onclick="confirm_payment()" style="display: none" class="btn btn-sm btn-success">Confirm Payments</button> </div>
			    </div>

			</form> 
		    </section> 
		</section>
	    </div> 
	    <div class="col-sm-6"> 
		<section class="panel panel-default">
		    <header class="panel-heading font-bold">Notes</header>
		    <div class="panel-body">
			<div class="form-group">
			    <p>Adding SMS in your account is easy and strait forward. Just follow the steps provided to add as many SMS as possible</p>
			</div>
			<div class="form-group">
			    <p>When your invoice is generated successfully, you will see here a link to download for your reference. You can download invoice also in payment report, not necessary here</p>
			    <a href="" target="_blank" style="display: none" id="invoice_link" class="btn btn-sm btn-success"><i class="fa fa-download"></i>Download your Invoice</a>
			</div>
		    </div>
		</section>
	    </div> 
	</div>
    </section>
</section>
<script type="text/javascript">
    detect_payment_method = function () {
	var method = $('#method_type').val();
	if (method == 'bank') {
	    $('#bank,#get_invoice').show();
	    $('#mobile').hide();

	} else {
	    $('#bank').hide();
	    $('#mobile,#get_invoice').show();
	    $('.mobile_type').html(method);
	}
    }
    confirm_payment = function () {
	swal({
	    title: "Add Receipt Code !",
	    text: 'After payments being done, add receipt codes you have received in text SMS',
	    type: 'input',
	    showCancelButton: true,
	    closeOnConfirm: false,
	    animation: "slide-from-top"
	},
	function (inputValue) {
	    if (inputValue === false)
		return false;

	    if (inputValue === "") {
		swal.showInputError("You need to write something!");
		return false;
	    } else {
		$.getJSON('submit_receipt', {code: inputValue}, function (data) {
		    swal(data.status,data.message, data.status);
		});
	    }
	});
    }
    get_invoice = function () {
	var sms = $('#sms_no').val();
	window.location.href='<?=url('#invoice')?>/'+sms;
    }
    check_number = function () {
	var number = $('#sms_no').val();
	if (number >= 1000) {
	    $('#method_type').prop("disabled", false);
	} else {
	    $('#method_type').attr('disabled', 'disabled');
	}
    }
</script>