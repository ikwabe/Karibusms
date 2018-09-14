<?php
/**
 * Description of pending_sms
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
		<header class="panel-heading">Pending SMS</header>
		<div class="row text-sm wrapper">


		    <div class="col-sm-8"> 
			<h3></h3>
			<div class="input-group"> 


			</div>
		    </div> 
		</div>

		<div class="table-responsive" >

		    <table class="table table-striped b-t b-light text-sm" id="mytable">

			<thead>
			    <tr> 
				<th width="20"></th>
				<th>Phone Number</th>
				<th>Message</th> 
				<th>Username</th> 
				<th>Sent Time</th>
				<th>To Be Sent By</th>
				<th>Status</th>
				<th>Option</th> 
			    </tr> 
			</thead> 
			<tbody>
			    <?php
			    if (!empty($sms)) {

				foreach ($sms as $pending_sms) {
				    ?>

				    <tr id="subscriber<?= $pending_sms->pending_sms_id ?>">
					<td></td>
					<td><?= $pending_sms->phone_number ?></td>
					<td><?= $pending_sms->content ?></td>
					<td><?= $pending_sms->username ?></td> 
					<td><?= date('d M Y h:i A',strtotime($pending_sms->reg_time)) ?></td>
					<td><?= $pending_sms->from_smart ==1 ?'Your Phone' : 'Internet' ?></td> 
					<td><b class="badge badge-info"><?= $pending_sms->status ==0 ?'pending':'' ?></b></td>
					<td> 
					   
					
					</td> 
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