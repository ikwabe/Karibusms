<?php
/**
 * Description of user_statistics
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<div class="row m-l-none m-r-none bg-light lter">
    <div class="col-sm-6 col-md-3 padder-v b-r b-light"> 
	<span class="fa-stack fa-2x pull-left m-r-sm">
	    <i class="fa fa-circle fa-stack-2x text-danger"></i>
	    <i class="fa fa-user fa-stack-1x text-white"></i> 

	</span>
	<a class="clear" href=""> 
	    <span class="h3 block m-t-xs">
		<strong id="firers"><?= count($users) ?></strong>
	    </span>
	    <small class="text-muted text-uc">Total Business Registered</small>
	</a>
    </div>
</div>
<section class="panel panel-default"> 
    <header class="panel-heading">List of available Clients Registered </header>

    <div class="table-responsive">
        <table class="table table-striped b-t b-light text-sm" id="mytable">
            <thead>
                <tr> 
                    <th>Name </th>
                    <th>Phone number</th> 
                    <th>Date Registered</th>
                    <th>Email</th>
		    <th>User Type</th>
		    <th>Registered By</th>
		    <th>Android App</th>
		    <th>Subscribers</th>
		    <th>SMS Remain</th>
                    <th>Country</th>
		    <th>Action</th>
		</tr> 
            </thead> 
            <tbody>
		<?php
		$with_email = 0;
		$with_android = 0;
		$user_type = array('Individual', 'Private Company', 'Normal Business', 'Government Institution', 'Non Government Organization (NGO)', 'Church', 'Others');
		$with_android_app = 0;
		$outside_tanzania = 0;
		foreach ($user_type as $value) {
		    $tag = strtolower(str_replace(' ', '_', $value));
		    $$tag = 0;
		}
		foreach ($users as $client) {
		    $client->email != '' ? ++$with_email : '';
		    strtolower($client->register_by) == 'android' ? ++$with_android : '';
		    $variable = strtolower(str_replace(' ', '_', $client->type));
		    in_array($client->type, $user_type) ? ++$$variable : '';
		    $client->gcm_id != '' ? ++$with_android_app : '';
		    preg_match('/tanzania/i', $client->country) ? '' :  ++$outside_tanzania;
		    ?>
    		<tr id="user<?= $client->client_id ?>">
    		    <td><?= $client->name ?></td>
    		    <td><?= $client->phone_number ?></td> 
    		    <td><?= date('d M Y', strtotime($client->reg_time)) ?></td>
    		    <td><?= $client->email ?></td>
    		    <td><?= $client->type ?></td>
    		    <td><?= $client->register_by ?></td>
    		    <td><?= $client->gcm_id != '' ? 'Installed' : 'None' ?></td>
    		    <td><?= $client->subscribers ?></td>
    		    <td><?= $client->message_left ?></td>
    		    <td><?= $client->country ?></td> 
    		    <td>
    			<p id="social-buttons">
    			    <!--			    <a href="#" class="btn btn-sm btn-icon btn-info">
    							    <i class="fa fa-folder-open"></i>
    							</a>-->
    			    <button class="btn btn-sm btn-icon btn-danger" onmousedown="delete_user('<?= $client->client_id ?>')">
    				<i class="fa fa-trash-o"></i>
    			    </button> 
    			</p>
    		    </td>
    		</tr> 
		<?php } ?>
            </tbody> 
        </table>
    </div> 
    <div class="row">
	<div class="col-sm-6">
	    <section class="panel panel-default">
		<header class="panel-heading">
		    <span class="label bg-danger pull-right">User Statistics</span> General </header> 
		<table class="table table-striped m-b-none text-sm">
		    <thead>
			<tr> 
			    <th>Item</th> 
			    <th>Number</th> 
			    <th width="70"></th>
			</tr>
		    </thead> 
		    <tbody>
			<tr>
			    <td>User with Emails</td>
			    <td><?= $with_email ?></td> 
			    <td class="text-right"> </td>
			</tr>
			<tr>
			    <td>User registered by Android</td>
			    <td><?= $with_android ?></td> 
			    <td class="text-right"> </td>
			</tr>
			<tr>
			    <td>User with Android App Linked</td>
			    <td><?= $with_android_app ?></td> 
			    <td class="text-right"> </td>
			</tr>
			<tr>
			    <td>User not from Tanzania</td>
			    <td><?= $outside_tanzania ?></td> 
			    <td class="text-right"> </td>
			</tr>
			<tr>
			    <td>Total Users</td>
			    <td><?= count($users) ?></td> 
			    <td class="text-right"> </td>
			</tr>
		    </tbody>
		</table> 
	    </section>
	</div>
	<div class="col-sm-6"> 
	    <section class="panel panel-default"> 
		<header class="panel-heading">General statistics</header> 
		<table class="table table-striped m-b-none text-sm">
		    <thead>
			<tr> 
			    <th>Type</th> 
			    <th>Number</th> 
			    <th width="70">Percentage</th>
			</tr>
		    </thead> 
		    <tbody>
			<?php
			$total_userby_type = 0;
			foreach ($user_type as $value) {
			    $val = strtolower(str_replace(' ', '_', $value));
			    $percentage = 100 * ($$val / count($users));
			    ?>
    			<tr> 
    			    <td><?= $value ?> </td> 
    			    <td><?= $$val ?> </td> 
    			    <td class="text-success"><?= round($percentage, 2) ?>% </td> 
    			</tr>	    
			    <?php
			    $total_userby_type+= $$val;
			}
			$unknown_users = count($users) - $total_userby_type;
			$unknown_users_percentage = 100 * ($unknown_users / count($users));
			?>
			<tr> 
			    <td>Unknown type</td> 
			    <td><?= $unknown_users ?> </td> 
			    <td class="text-success"><?= round($unknown_users_percentage, 2) ?>% </td> 
			</tr>	
		    </tbody> 
		</table>
	    </section> 
	</div> 
    </div>
</section>
<script src="<?= url('/') ?>/media/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?= url('/') ?>/media/css/table.css" rel="stylesheet">
<script type="text/javascript">
				mydatatable = function () {
				    $('#mytable').dataTable();
				};
				delete_user = function (user_id) {
				    $.getJSON('delete_user/' + user_id, {}, function (data) {
					swal(data.status, data.message, data.status);
					$('#user' + user_id).hide();
				    });
				}
				mydatatable();
</script>