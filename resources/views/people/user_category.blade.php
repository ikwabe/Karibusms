<?php
/**
 * Description of user_category
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
	<div class="col-sm-4 m-b-xs" id="title_banner">People Categories</div> 
    </div> 
</header>
<section class="scrollable wrapper w-f" id="ajax_load_options">
    <section class="panel panel-default">
	<header class="panel-heading">Manage your people categories</header>
	<table class="table table-striped m-b-none text-sm"> 
	    <thead>
		<tr> 
		    <th width='40'>Id</th>
		    <th>Name</th> 
		    <th class="text-left">Option</th>
		</tr>
	    </thead> 
	    <tbody> 
		<?php
		/**
		 * -------------------------------
		 * Get categories
		 * -------------------------------
		 */
		$categories = \App\Http\Controllers\Controller::get_category();
		$i = 1;
		foreach ($categories as $category) {
		    $key = $category->category_id;
		    ?>
		<tr id="cat_id<?= $key ?>"> 
    		    <td>
			    <?= $i ?>
    		    </td> 
    		    <td> <p id="tag<?= $key ?>"><?= $category->name ?></p>
    			<span id="edit<?= $key ?>" style="display:none;">
    			    <input type="text" placeholder="Edit here" value="<?= $category->name ?>" id="<?= $key ?>" />
    			    <button id="edit_btn<?= $key ?>" class="btn btn-success" data-toggle="class:show inline" data-target="#spin" data-loading-text="Saving..." onmousedown="edit_save_cat('<?= $key ?>')">Save</button>
    			</span>
    		    </td> 
    		    <td class="text-left"> 
    			<a href="#" class="active" data-toggle="class" onclick="delete_cat(<?= $key ?>);" title="Delete">
    			    <i class="fa fa-trash-o text-success text-active"></i>
    			    <i class="fa fa-times text-danger text"></i>
    			</a>

    			<div class="btn-group">
    			    <a href="#" onmousedown="edit_cat('<?= $key ?>')" class="dropdown-toggle" data-toggle="dropdown">
    				<i class="fa fa-pencil"></i></a> 
    			</div>
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
      edit_cat = function (a) {
	$('#edit' + a).toggle();
    }
    edit_save_cat = function (a) {
	var new_value = $('#' + a).val();
	$.get('edit_category/'+a, {name: new_value}, function (data) {
	    $('#tag' + a).html($('#' + a).val());
	    $('#edit_btn' + a).html('Save');
	    //  $('#tag_name' + a).html(data);
	    $('#edit' + a).hide();
	});
    }
    delete_cat = function (cat_id) {
	swal(
		{
		    title: "Are you sure?",
		    text: "By clicking YES you will detele this category in your list. All people belongs to this category will be in default group. Are you sure you want to delete ?",
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
		$.get('delete_person/' + cat_id, {type:'category'}, function (data) {
		    if (data == 1) {
			swal("Deleted!", "Category deleted successful.", "success");
			$('#cat_id' + cat_id).html('').fadeOut('slow');
		    } else {
			swal("Error", "Category failed to be deleted", "error");
		    }
		});
	    } else {
		swal("Cancelled", "Category remain not deleted", "error");
	    }
	});
    };
</script>