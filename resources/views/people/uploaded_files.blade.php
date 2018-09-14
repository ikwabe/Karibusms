<?php
/**
 * Description of uploaded_files
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<header class="header bg-white b-b clearfix">
    <div class="row m-t-sm">         
	<div class="col-sm-4 m-b-xs" id="title_banner">List of Uploaded Files</div> 
    </div> 
</header>
<section class="scrollable wrapper w-f" id="ajax_load_options">
    <section class="panel panel-default">
	<header class="panel-heading">These are files you have upload. You can delete them if you want</header>
	<table class="table table-striped m-b-none text-sm"> 
	    <thead>
		<tr> 
		    <th width='40'>Id</th>
		    <th>Name</th> 
		    <th>Uploaded Time</th> 
		    <th class="text-left">Option</th>
		</tr>
	    </thead> 
	    <tbody> 
		<?php
		/**
		 * -------------------------------
		 * List all user available files
		 * -------------------------------
		 */
		$user = App\Http\Controllers\Controller::user_info();

	
		$i = 1;
		foreach ($user_info as $file) {
		    if($file==$user->profile_pic)			continue;
		    $key = $i;
		    ?>
    		<tr id="cat_id<?= $key ?>"> 
    		    <td>
			    <?= $i ?>
    		    </td> 
    		    <td> <p id="tag<?= $key ?>"><?= $file ?></p>
    		    </td> 
    		    <td> <p><?= date("F d Y H:i:s.", filemtime('media/images/business/' . $client_id . '/' . $file)); ?></p>
    		    </td> 
    		    <td class="text-left"> 
    			<a href="#" class="active" data-toggle="class" onclick="delete_cat(<?= $key ?>);" title="Delete">
    			    <i class="fa fa-trash-o text-success text-active"></i>
    			    <i class="fa fa-times text-danger text"></i>
    			</a>
    			<a href="<?= url('/download_file/' . $file) ?>" title="Download">
    			    <i class="fa fa-download text-success text-active"></i>
    			    <i class="fa fa-download text-success text"></i>
    			</a>
    		    </td> 
    		</tr>

		    <?php
		    $i++;
		}
		?>

	    </tbody> 
	</table> 
    </section>
</section> 
<script type="text/javascript">
    delete_cat = function (cat_id) {
	swal(
		{
		    title: "Are you sure?",
		    text: "By clicking YES you will detele this file in your list. Are you sure you want to delete ?",
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
		$.get('delete_file', {file: $('#tag' + cat_id).text()}, function (data) {
		    if (data == 1) {
			swal("Deleted!", "File deleted successful.", "success");
			$('#cat_id' + cat_id).html('').fadeOut('slow');
		    } else {
			swal("Error", "File failed to be deleted", "error");
		    }
		});
	    } else {
		swal("Cancelled", "File remain not deleted", "error");
	    }
	});
    };
</script>