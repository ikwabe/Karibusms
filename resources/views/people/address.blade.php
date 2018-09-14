<?php
/**
 * Description of address
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<div class="modal-dialog" id="largemodal"> 
    <div class="modal-content">
	<div class="modal-header"> 
	    <button type="button" class="close" data-dismiss="modal">&times;</button>
	    <h4 class="modal-title">Your contact address</h4> 
	</div>
	<div class="modal-body"> 
	    <section class="panel panel-default"> 
		<div class="table-responsive">
		    <table class="table table-striped b-t b-light text-sm" id="address_table"> 
			<thead>
			    <tr>
				<th class="th-sortable">Name</th> 
				<th>Phone Number</th>
				<th>Email</th>
				<th width="30"></th> 
			    </tr>
			</thead> 
			<tbody>

			    <?php
			    if (!empty($people)) {
				foreach ($people as $person) {
				    ?>    
			    <tr id="<?= $person->phone_number ?>"> 
					
					<td><?= $person->firstname . ' ' . $person->lastname ?></td>
					<td><?= $person->phone_number ?></td>
					<td><?= $person->email ?></td>
					<td> <button onmousedown="add_number('<?= $person->phone_number ?>')" class="btn btn-sm btn-default">
					    Add
					    </button> </td> 
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
	<div class="modal-footer"> 
	    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
	</div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script src="<?= url('/') ?>/media/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?= url('/') ?>/media/css/table.css" rel="stylesheet">
<script type="text/javascript">
    address_table = function () {
	$('#address_table').dataTable();
    };
    add_number=function(a){
	var number=$('#phone_numbers_tag').val();
	$('#phone_numbers_tag').val(number+','+a);
	$('#'+a).hide('slow');
    }
    address_table();
</script>