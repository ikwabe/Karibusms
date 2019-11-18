<?php
/**
 * @author Ephraim Swilla<swillae1@gmail.com>
 * @uses  payment
 */
if (isset($_GET['pay']) && $_GET['pay'] == 'pay') {
    include_once 'modules/payment/section/pay.php';
} else {
    require_once 'modules/landing/banner/feature_banner.php';
    ?>
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
    		<li><a href="<?= url('/').'/' ?>">Home</a></li> 
    		<li class="active">Price</li> 
    	    </ul>
    	</div> 
        </div>
        <div class="container"> 
    	<div id="testing"></div>
	    <?php
	    if (isset($ses_user)) {
		require_once 'modules/payment/part/packages.php';
		//require_once 'modules/payment/section/pay.php';
	    } else {
		?>
		<div class="bg-white b-t b-light pos-rlt">
		    <div class="container"> 
			<div class="row m-t-xl m-b-xl"> 
			    <div class="col-sm-5 text-center clearfix m-t-xl" data-ride="animated" data-animation="fadeInLeftBig"> 
				<div class="h3 font-bold m-t-xl m-b-xl">
				    <?php if (COUNTRTY_CODE == 'KY') { ?>
	    			    <img src="media/images/mpesa_kenya.jpg" width="40%" title="M-PESA payment" alt="M-PESA payment"/>
				    <?php } else { ?>
	    			    <img src="media/images/mpesa.jpg" width="40%" title="M-PESA payment" alt="M-PESA payment"/>
	    			    <img src="media/images/tigopesa.jpg" width="40%" title="Tigopesa payment" alt="Tigopesa payment"/>
	    			    <img src="media/images/paypal.jpg" width="40%" title="Paypal and bank payment" alt="Paypal and bank payment"/> 
				    <?php } ?>

				</div> 
			    </div> 
			    <div class="col-sm-7">
				<h2 class="font-thin m-b-lg">Pricing Options</h2> 
				<p class="h4 m-b-lg l-h-1x">
				    karibuSMS provide FREE SMS pricing option and paid SMS solution depends on customer needs
				    <br/>
				    <br/>
				    All payments in karibuSMS can be done by 
				</p> 
				<ul class="m-b-xl fa-ul"> 
				    <li><i class="fa fa-li fa-check text-muted"></i>Mobile Payments (M-pesa, Tigo-Pesa)</li>
				    <li><i class="fa fa-li fa-check text-muted"></i>Credit Cards (using PayPal or Bank Cards)</li> 
				    <li><i class="fa fa-li fa-check text-muted"></i>Direct Bank deposit</li> 
				</ul> 
			    </div> </div>
		    </div> 
		</div> 
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
    			<h4>Simple connection with your customers</h4> 
    			<p class="text-muted text-sm">KaribuSMS let you manage your customers easily and provide easy means for you to satisfy your customers and in turn manage well your organization.<br><br>
    			   karibuSMS include main features and yet allow you to request any feature to be added in your profile for free and we will add it for you.</p> 
    		    </div> 
    		</div>
    		<div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="600"> 
    		    <span class="fa-stack fa-2x pull-left m-r m-t-xs"> 
    			<i class="fa fa-circle fa-stack-2x text-info"></i>
    			<i class="fa fa-stack-1x fa-inverse">2</i>
    		    </span> 
    		    <div class="clear"> <h4>Low cost and efficient marketing tool</h4>
    			<p class="text-muted text-sm">We understand that you need reliable price and best tool that is why we will always keep our price affordable and yet provide with you all features that you need so you can grow your business.<br><br>Start now to Manage well your business karibuSMS</p> 
    		    </div> 
    		</div> 
    		<div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="900"> 
    		    <span class="fa-stack fa-2x pull-left m-r m-t-xs">
    			<i class="fa fa-circle fa-stack-2x text-info"></i> 
    			<i class="fa fa-stack-1x fa-inverse">3</i> 
    		    </span> 
    		    <div class="clear"> 
    			<h4>Extensible technology</h4> 
    			<p class="text-muted text-sm">Our solution is flexible, easy to be integrated with other systems and yet you can decide whether to use it over the cloud or have it in your office to be accessed locally.</p> 
    		    </div> 
    		</div> 
    	    </div>
    	</div>
        </div>
    </section> <!-- footer --> 
    <?php
    require_once 'modules/landing/feature_footer.php';
    ?>
    <script>

        payment = function () {

        };
        $(document).ready(payment);
    </script>
    <?php
    js_media('appear/jquery.appear');
    js_media('scroll/smoothscroll');
    js_media('landing');
}
?>
