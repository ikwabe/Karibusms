<?php
/**
 * Description of show_all
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
		<header class="panel-heading">List of People </header>
		<div class="row text-sm wrapper">


		    <div class="col-sm-8"> 
			<h3><?php
			$type=='all' ? '':  ucfirst($type)?></h3>
			<div class="input-group"> 
			  
			    <span class="input-group-btn"> 
				
				<button class="btn btn-xs btn-success m-t-xs" id="add_users" onmousedown="window.location.href='#add_people'" 

					style="cursor: pointer;"
					>Add more </button>
			    </span> 
			</div>
		    </div> 
		</div>

		<div class="table-responsive" >
		
		    <p align="right">
			<a href="<?=url('/user_download')?>">
			    <button class="btn btn-sm btn-default"><i class="fa fa-download"></i></button>
			</a>
			</p>
		    <table class="table table-striped b-t b-light text-sm" id="mytable">
			
			<thead>
			    <tr> 
<th width="20"><input type="checkbox"></th>
				<th>Name</th>
				<th>Phone number</th> 
				<th>Email</th> 
				<th>Category</th>
				<th>Organization</th>
				<th>Option</th> 
			    </tr> 
			</thead> 
			<tbody>
			    <?php
			
			    if (!empty($people)) {

				foreach ($people as $person) {
				    ?>

				    <tr id="subscriber<?= $person->subscriber_info_id ?>">
					<td><input type="checkbox" name="post[]" value="2"></td>
					<td><?= $person->title . ' ' . $person->firstname . ' ' . $person->lastname ?></td>
					<td><?= $person->phone_number ?></td>
					<td><?= $person->email ?></td> 
					<td><?= $person->category ?></td>
					<td><?= $person->organization_name ?></td>
					<td> 
					    <a href="#" class="active" data-toggle="class" onclick="delete_subscriber(<?= $person->subscriber_info_id ?>);" title="Delete">
						<i class="fa fa-trash-o text-success text-active"></i>
						<i class="fa fa-times text-danger text"></i></a> 
					    <a href="#" onmousedown="call_page('send_sms_dialog?phone_number=<?= $person->phone_number ?>')" title="Send Email or SMS">
						<i class="fa fa-envelope text-success text-active"></i>
						<i class="fa fa-envelope-o text-success text"></i></a>
					    <a href="#view/<?= encryptApp($person->subscriber_info_id) ?>" class="active" onclick="call_page('view/<?= encryptApp($person->subscriber_info_id)?>')" title="View More">
						<i class="fa fa-folder-open text-success text-active"></i>
						<i class="fa fa-folder-open-o text-success text"></i></a>
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
<script type="text/javascript">
						other_name = function () {
						    $('.info').keypress(function (e) {
							if (e.which == 13) {
							    //we save this information 
							    var name = $(this).text();
							    var data_for = $(this).attr('data-for');
							    var subscriber_id = $(this).attr('id');
							    $.get(url, {pg: 'profile', process: 'info', subscriber_id: subscriber_id, value: name, data_for: data_for, edit_subscriber: 'true'}, function (data) {
								alert("Information updated");
								// $('#subscriber' + subscriber_id).html(data).fadeOut('slow');
							    });
							}
						    });
						};
						$(document).ready(other_name);

						mydatatable = function () {
						    $('#mytable').dataTable();
						};
						mydatatable();
						send_sms_to_id = function (a) {
						    return true;
						}
						delete_subscriber = function (subscriber_id) {
						    swal(
							    {
								title: "Are you sure?",
								text: "By clicking OK you will detele only this person in your list. Are you sure you want to delete ?",
								type: "warning",
								showCancelButton: true,
								confirmButtonColor: "#DD6B55",
								confirmButtonText: "Yes, delete it!",
								cancelButtonText: "No, cancel this!",
								showLoaderOnConfirm: true,
								closeOnConfirm: false,
								closeOnCancel: false
							    },
						    function (isConfirm) {
							if (isConfirm) {
							    $.getJSON('delete_person/' + subscriber_id, {}, function (data) {
								if (data.status == 'success') {
								    swal("Deleted!", "Your contact is deleted successful.", "success");
								    $('#subscriber' + subscriber_id).html('').fadeOut('slow');
								} else {
								    swal("Error", "Your contact failed to be deleted", "error");
								}
							    });
							} else {
							    swal("Cancelled", "Contact remain not deleted", "error");
							}
						    });
						};
						bulk_option=function(){
						    var bulk_option=$('#bulk_option').val();
						    alert(bulk_option);
						}
</script>
