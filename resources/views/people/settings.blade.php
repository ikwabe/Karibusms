<style>#security{cursor: pointer}</style>
<section class="hbox stretch"> 

    <aside class="aside-md bg-white b-r" id="subNav"> 
        <div class="wrapper b-b header">Profile settings</div> 

        <ul class="nav"> 
            <li class="b-b b-light section" id="basic" data-for="Basic Settings" onmousedown="call_page('client_setting')">
		<a href="#"><i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted" ></i>basic</a>
	    </li> 

            <li class="b-b b-light section" id="security" data-id="settings/password">
		<a><i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>security</a>
	    </li> 
	     <li class="b-b b-light section" id="security" data-id="settings/category" data-for="Change your Password" >
		<a>
		    <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>Categories</a>
	    </li> 
	    <li class="b-b b-light section" id="security" data-id="settings/photo" data-for="Change photo">
		<a>
		    <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>Profile Photo</a>
	    </li> 
 <li class="b-b b-light section" id="security" data-id="settings/uploaded_files" data-for="View Uploaded Files" >
		<a>
		    <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>Uploaded Files</a>
	    </li> 
	    <?php if (FALSE) { ?>
    	    <li class="b-b b-light section" id="location" data-for="Basic Settings"><a href="#"><i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>Location</a></li>
    	    <li class="b-b b-light section" id="social_connection" data-for="Update Social Connections"><a href="#"><i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>Social connections</a></li> 
    	<!--<li class="b-b b-light section" id="messaging_type" data-for="Change messaging type"><a href="#"><i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>Messaging type</a></li>-->
    	    <li class="b-b b-light section" id="reseller" data-for="SMS Reseller page"><a href="#">
    		    <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>SMS Reseller</a></li>
	    <?php } ?>    
        </ul> 
    </aside> 
    <aside> 
        <section class="vbox" id="vbox_content">
            <header class="header bg-white b-b clearfix">
		<div class="row m-t-sm">         
		    <div class="col-sm-4 m-b-xs" id="title_banner">Basic information</div> 
                </div> 
            </header>

            <section class="scrollable wrapper w-f" id="ajax_load_options">
		<section class="panel panel-default">
		    <header class="panel-heading">Your personal information</header>
		    <table class="table table-striped m-b-none text-sm"> 
			<thead>
			    <tr> 
				<th width='20'>Name</th>
				<th>Value</th> 
				<th></th>
			    </tr>
			</thead> 
			<tbody> 
			    <?php
			    foreach ($user_info as $key => $user) {

				$skipped = array('client_id', 'phone_verification_code', 'password', 'reg_time', 'email_token', 'business_tag', 'messaging_type', 'gcm_id', 'imei','profile_pic','register_by', 'phone_number_valid', 'email_valid', 'business_lastlogin');
				if (!in_array($key, $skipped)) {
				    ?>
				    <tr> 
					<td>
					    <?= $key ?>
					</td> 
					<td> <p id="tag<?= $key ?>"><?= str_limit($user, 85) ?></p>
					    <span id="edit<?= $key ?>" style="display:none;">
						<?php
						if($key=='username'){ ?>
						  <div class="alert alert-warning">
						      <b>Username length MUST not exceed 10 characters, only Characters & Numbers allowed, otherwise SMS will not be sent</b></div>
						<?php } 	?>
						<input type="text" placeholder="Edit here" value="<?= $user ?>" id="<?= $key ?>" />
						<button id="edit_btn<?= $key ?>" class="btn btn-success" data-toggle="class:show inline" data-target="#spin" data-loading-text="Saving..." onmousedown="edit_save('<?= $key ?>')">Save</button>
					    </span>
					</td> 
					<td class="text-right"> 
					    <div class="btn-group">
						<a href="#" onmousedown="edit_tag('<?= $key ?>')" class="dropdown-toggle" data-toggle="dropdown">
						    <i class="fa fa-pencil"></i></a> 
					    </div>
					</td> 
				    </tr>

				<?php
				}
			    }
			    ?>

			</tbody> 
		    </table> 
		</section>
            </section> 
            <footer class="footer bg-white b-t"> 
                <div class="row text-center-xs">
                    <div class="col-md-6 hidden-sm"> <p class="text-muted m-t"></p> </div>
                </div> 
            </footer> 
        </section>
    </aside> 
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
<script type="text/javascript">
    section_call = function () {
	$('.section').click(function () {
	      var section = $(this).attr('id');
	      $('#vbox_content').html(LOADER);
	      var url = $(this).attr('data-id');
	    $.get(url, null, function (data) {
		$('#vbox_content').html(data);
	    });
	});
    };
    $(document).ready(section_call);

    edit_tag = function (a) {
	$('#edit' + a).toggle();
    }
    edit_save = function (a) {
	var new_value = $('#' + a).val();
	$.get('edit_person/<?= $user_info->client_id ?>', {tag: a, new_value: new_value, client: '1'}, function (data) {
	    $('#tag' + a).html(data);
	    $('#edit_btn' + a).html('Save');
	    //  $('#tag_name' + a).html(data);
	    $('#edit' + a).hide();
	});
    }
</script>