<?php
/**
 * Description of dopayment
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<section class="vbox" style="min-height: 40em;"> 
    <section class="scrollable padder"> 
	<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
	    <li class="active">Payment</li>
	</ul>
	<div class="m-b-md"> 
	    <h3 class="m-b-none">Hello</h3> 
	    <small>View report or add new payment</small>
	</div>

	<section class="panel panel-default">
	    <div class="row m-l-none m-r-none bg-light lter"> 
		<div class="col-sm-6 col-md-6 padder-v b-r b-light"  title="Click to add payments"> 
		    <span class="fa-stack fa-2x pull-left m-r-sm"> 
			<i class="fa fa-circle fa-stack-2x text-info"></i>
			<i class="fa fa-money fa-stack-1x text-white"></i> 
		    </span> 
		    <a class="clear" href="#add_payment"> 
			<span class="h3 block m-t-xs"><strong></strong></span> 
			<small class="text-muted text-uc">Add Payments</small> 
		    </a> 
		</div>

		<div class="col-sm-6 col-md-6 padder-v b-r b-light" onmousedown="call_page('view_report')" title="Click to send SMS">
		    <span class="fa-stack fa-2x pull-left m-r-sm"> 
			<i class="fa fa-circle fa-stack-2x text-danger"></i> 
			<i class="fa fa-dashboard fa-stack-1x text-white"></i> 

		    </span> 
		    <a class="clear" href="#">
			<span class="h3 block m-t-xs"><strong id="firers"></strong></span> 
			<small class="text-muted text-uc">View Payment Reports</small>
		    </a>
		</div>

	    </div>
	</section>
	<div> 

	</div> 
    </section>
</section>