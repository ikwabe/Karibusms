<?php
/**
 * Description of view_report
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

    <header class="header bg-white b-b b-light"> <p> <small></small></p> </header>
    <br/>
    <section class="hbox stretch"> 
	<div class="tab-pane col-lg-12">

	    <section class="panel panel-default" style="overflow: scroll;"> 
		<header class="panel-heading">Payment </header>
		<div class="row text-sm wrapper">


		    <div class="col-sm-8"> 
			<h3>Payment Report</h3>
			<div class="input-group"> 

			    <span class="input-group-btn"> 

				<a href="#add_payment" class="btn btn-xs btn-success m-t-xs" id="add_users" 

					style="cursor: pointer;"
					>Add Payment </a>
			    </span> 
			</div>
		    </div> 
		</div>

		<div class="table-responsive" >
		    <table class="table table-striped b-t b-light text-sm" id="mytable">
			<thead>
			    <tr> 

				<th>Date</th> 
				<th>Amount</th>
				<th>Currency</th> 
				<th>Method</th>
				<th>SMS Provided</th>
				<th>Status</th> 
				<th>Approved</th> 
				<th>Action</th> 
				<!--<th>Receipt</th>--> 
			    </tr> 
			</thead> 
			<tbody>
			    <?php
			    if (!empty($payments)) {

				foreach ($payments as $payment) {
				    ?>

				    <tr id="payment_id<?= $payment->payment_id ?>">
					<td><?= date('d M Y H:m', strtotime($payment->time)) ?></td>
					<td><?= $payment->amount ?></td>
					<td><?= $payment->currency ?></td>
					<td><?= $payment->method ?></td>
					<td><?= $payment->sms_provided ?></td>

					<td><?=
			    $payment->confirmed == 0 ?
				    '<span class="badge bg-info">pending</span>' :
				    '<span class="badge bg-success">complete</span>'
				    ?></td>

					<td><?= $payment->approved == 1 ? 'Yes' : 'Not yet' ?></td>
					<td>
                                              <?php
					    if ($payment->confirmed == 1 && $payment->approved == 1) {
						?>
                                            <a class="btn btn-success btn-xs" href="<?= url('#view_receipt/') ?><?= $payment->payment_id ?>?tag=invoice" title="View receipt">
						<i class="fa fa-file"></i> Receipt</a>
                                            <?php }else{?>
                                            <a class="btn btn-info btn-xs" href="<?= url('#invoice/'.($payment->amount/$payment->cost_per_sms)) ?>?token=<?=$payment->invoice?>" title="View Invoice">
						<i class="fa fa-money"></i> Pay</a>
                                                <a class="btn btn-danger btn-xs" href="<?= url('#deleteinvoice/') ?>?token=<?=$payment->invoice?>" title="View Invoice">
						<i class="fa fa-trash-o"></i> Delete</a>
                                            <?php }?>

					</td>
<!--					<td> 
					    <?php
					    if ($payment->confirmed == 1 && $payment->approved == 1) {
						?>
	    				    <a href="<?= url('/download_file') ?>/<?= $payment->payment_id ?>?tag=receipt" target="_blank"  title="Download Receipt">
	    					<i class="fa fa-download text-success text-active"></i>
	    					<i class="fa fa-download text-success text"></i></a> 
						<?php } ?>
					</td> -->
				    </tr>

				    <?php
				}
			    }
			    ?>
			</tbody> 
		    </table>
		</div>
	    </section>
	</div>
    </section>

</section>

<script src="<?= url('/') ?>/media/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?= url('/') ?>/media/css/table.css" rel="stylesheet">
<script type="text/javascript">
mydatatable = function () {
    $('#mytable').dataTable();
};
mydatatable();
</script>
