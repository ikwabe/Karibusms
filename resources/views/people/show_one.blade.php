<header class="header bg-white b-b b-light"> <p>Personal Information</p> </header>

<section class="scrollable wrapper">
    <div class=""> <h4 class="m-t-none">You can edit any list you want</h4> 

	<ul class="list-group gutter list-group-lg list-group-sp sortable"> 

	    <?php
	    $list = array('title','firstname', 'lastname', 'phone_number', 'other_phone_number', 'email', 'location', 'organization_name', 'organization_position', 'organization_description');

	    foreach ($list as $value) {
		?>
    	    <li class="list-group-item" draggable="true"> 
    		<span class="pull-right"> 
    		    <a href="" onclick="return false" onmousedown="edit_tag('<?= $value ?>')">
    			<i class="fa fa-pencil icon-muted fa-fw m-r-xs"></i>
    		    </a>
    		</span> 
    		<span class="pull-left media-xs">
    		    <i class="fa fa-sort text-muted fa m-r-sm"></i> 
    		    <b id="tag_name<?= $value ?>"><?= ucwords(str_ireplace('_', ' ', $value)) ?></b> : 
    		</span> 
    		<div class="clear" id="tag<?= $value ?>"> <?= $person->$value != '' ? $person->$value : 'Nil' ?></div> 
    		<span id="edit<?= $value ?>" style="display:none;">
    		    <input type="text" placeholder="Edit here" value="<?= $person->$value ?>" id="<?= $value ?>" />
    		    <button id="edit_btn<?= $value ?>" class="btn btn-success" data-toggle="class:show inline" data-target="#spin" data-loading-text="Saving..." onmousedown="edit_save('<?= $value ?>')">Save</button>
    		</span>
    	    </li> 
		<?php
	    }
	    /**
	     * -------------------------------
	     * Get categories
	     * -------------------------------
	     */
	    $categories = \App\Http\Controllers\Controller::get_category();
	    ?>    
	    <li class="list-group-item" draggable="true"> 
		<span class="pull-right"> 
		    <a href="" onclick="return false" onmousedown="edit_tag('category_id')">
			<i class="fa fa-pencil icon-muted fa-fw m-r-xs"></i>
		    </a>
		</span> 
		<span class="pull-left media-xs">
		    <i class="fa fa-sort text-muted fa m-r-sm"></i> 
		    <b id="tag_name_cat">Category</b> : 
		</span> 
		<div class="clear" id="tagcategory_id">
		    <?php
		    foreach ($categories as $category) {
			if ($category->category_id == $person->category_id) {
			    $name = $category->name;
			}
		    }
		    echo isset($name) ? $name : 'Nil';
		    ?>
		</div> 
		<span id="editcategory_id" style="display:none;">
		    <select name="category" class="form-control m-b rounded" id="category_id">
			<option id="add_category" value="">default</option> 
			<?php
			foreach ($categories as $category) {
			    ?>
    			<option id="" value="<?= $category->category_id ?>"><?= $category->name ?></option> 
			<?php } ?>

		    </select>
		    <button onclick="add_category()" class="btn btn-info btn-sm">+ add new category</button><br/><br/>
		    <button id="edit_btncat" class="btn btn-success" data-toggle="class:show inline" data-target="#spin" data-loading-text="Saving..." onmousedown="edit_save('category_id')">Save</button>
		</span>
	    </li> 
	</ul> 
    </div>
</section>
<script type="text/javascript">
    add_category = function () {
	swal({
	    title: "Add new category !",
	    text: 'This will help you to group well your people',
	    type: 'input',
	    showCancelButton: true,
	    closeOnConfirm: false,
	    animation: "slide-from-top"
	},
	function (inputValue) {
	    if (inputValue === false)
		return false;

	    if (inputValue === "") {
		swal.showInputError("You need to write something!");
		return false;
	    }
	    $.get('add_category', {name: inputValue}, function (data) {
		$('#add_category').after('<option value=' + data + '>' + inputValue + '</option>');
		swal("Nice!", 'New category : ' + inputValue+' added successfully', "success");
	    });
	});
    }
    edit_tag = function (a) {
	$('#edit' + a).toggle();
    }
    edit_save = function (a) {
	var new_value = $('#' + a).val();
	$.get('edit_person/<?= $person->subscriber_info_id ?>', {tag: a, new_value: new_value}, function (data) {
	    if (a == 'category_id') {
		$('#tag' + a).html(data);
	    } else {
		$('#tag' + a).html($('#' + a).val());
	    }
	    $('#edit_btn' + a).html('Save');
	    //  $('#tag_name' + a).html(data);
	    $('#edit' + a).hide();
	});
    }
</script>
