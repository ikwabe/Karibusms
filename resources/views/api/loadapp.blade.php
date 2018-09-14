<br/>  
<div class="col-sm-10" id="app_info">
    <br/><section class="panel panel-default"> 
	<div class="list-group no-radius alt">
	    <table class="table table-striped m-b-none text-sm">
		<thead> <tr> <th><h3>Your App info</h3></th> <th></th> <th width="70"></th> </tr> </thead> 
		<tbody>
		    <tr> 
			<td>Your App Name:</td> 
			<td><?= $app->name ?></td> 
			<td class="text-right"> </td>
		    </tr>
		    <tr> 
			<td>Your App key:</td> 
			<td><?= $app->api_key ?></td> 
			<td class="text-right"> </td>
		    </tr> 
		    <tr> 
			<td>Your App Secret:</td>
			<td><?= $app->api_secret ?></td> 
			<td class="text-right"> 
			    <div class="btn-group"> 
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-pencil"></i></a>
			    </div>
			</td> 
		    </tr> 
		</tbody> 
	    </table>
	    <br/><h3>Your usage statistics</h3>

	    <a class="list-group-item" href="#">
		<span class="badge bg-success"><?= $app->phone_sms_total + $app->bulk_sms_total; ?></span> 
		<i class="fa fa-envelope icon-muted"></i> Total Messages sent </a> 

	    <a class="list-group-item" href="#">
		<span class="badge bg-success">
		    <?= $app->bulk_sms_total == NULL ? 0 : $app->bulk_sms_total; ?></span> 
		<i class="fa fa-envelope-o icon-muted"></i> Internet Messages sent </a> 

	    <a class="list-group-item" href="#">
		<span class="badge bg-success">
		    <?= $app->phone_sms_total == NULL ? 0 : $app->phone_sms_total ?></span> 
		<i class="fa fa-phone-square icon-muted"></i> Smartphone Messages sent </a> 

	    <a class="list-group-item" href="#"> <span class="badge bg-light">
		    <?= date('d M Y H:m', strtotime($app->reg_time)) ?></span>
		<i class="fa fa-eye icon-muted"></i> Start usage date </a> 
	</div>
    </section>
    <section class="panel panel-info"> 
	<div class="panel-body"> <a href="#" class="thumb pull-right m-l"></a> 
            <div class="clear">Do you have any request or comment or having a question ? <a  data-toggle="ajaxModal" href="<?= url('/api/contact') ?>" class="btn btn-xs btn-success m-t-xs">Contact us here</a> </div> 
        </div> 
    </section>
</div>
<div class="col-lg-2 right">
    <a href="#" class="btn btn-default btn-xs btn-warning" onclick="delete_app(<?= $app->developer_id ?>)" style="padding: 5px;">
	<i class="fa fa-trash-o text-muted"></i> Delete this app </a>
</div>
<script>
    delete_app = function (a) {
	$('#app_info').html(LOADER);
	$.get('<?= url('/') ?>/api_delete/' + a, {}, function (data) {
	    $('#app_info').html(data);
	    window.location.reload();
	});
    };
</script>
