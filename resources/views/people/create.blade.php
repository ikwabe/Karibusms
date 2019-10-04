<?php
/**
 * Description of create
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
    <section class="scrollable padder">
	<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	    <li><a href="<?= url('/') ?>"><i class="fa fa-home"></i> Home</a></li> 
	    <li><a href="#">Contacts</a></li> 
	    <li class="active"><a href="#">Add New</a></li>
	</ul>

	<div class="m-b-md"> <h3 class="m-b-none">Add New Contact</h3> </div>

	<div class="row"> 
	    <div class="col-lg-8" id="load_excel_page">
		<section class="panel panel-default"> 
		    <header class="panel-heading font-bold">Add new contact form</header> 
		    <section class="panel-body">
			<form role="form" class="form-horizontal" id="add_person" action="<?= url('/') ?>/add_people_submit" onsubmit="return false"> 

			    <div class="col-sm-12">
				<div class="col-sm-2">
				    <br/>
				    <select name="title" class="form-control m-b">
					<option>Mr</option> 
					<option>Mrs</option>
					<option>Miss</option>
					<option>Sister</option>
					<option>Madam</option>
					<option>Dr</option> 
					<option>Prof</option> 
					
				    </select> 	
				</div>
				<div class="form-group col-sm-6">
				    <label>First Name </label>
				   <input type="text" name="firstname" class="form-control rounded"  placeholder="First Name"> 
				</div> 
				<div class="form-group col-sm-4">
				    <label>Last Name</label> 
				    <input type="text" name="lastname" class="form-control rounded"  placeholder="Last Name">
				</div> 
			    </div>


			    <div class="form-group">
				<label class="col-sm-2 control-label">Phone Number <span class="text-danger">*</span></label> 
				<div class="col-sm-10">
				   
				    <input type="number" name="phone_number"  required="true" class="form-control rounded" placeholder="Phone number"> </div>
				    
			    </div>
			     <div class="form-group">
				<label class="col-sm-2 control-label">Other Phone Number(s)</label> 
				<div class="col-sm-10">
				   
				    <input type="text" name="other_phone_number"  class="form-control rounded" placeholder="Phone number"> </div>
				<span style="margin-left: 5%">Separete by comma if more than on. <a href="#" title="Start with country code">Use international format only</a></span>
				    
			    </div>
			    <div class="form-group"> 
				<label class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
				    <input type="email" name="email" class="form-control rounded" placeholder="Email"> </div>
			    </div>


			    <div class="form-group"> 
				<label class="col-sm-2 control-label">Category</label>
				<div class="col-sm-10"> 
				    <select name="category" class="form-control m-b rounded">
					<option id="add_category" value="">default</option> 
					<?php
					/**
					 * -------------------------------
					 * Get categories
					 * -------------------------------
					 */
					$categories = \App\Http\Controllers\Controller::get_category();
					foreach ($categories as $category) {
					    ?>
    					<option id="" value="<?= $category->name ?>"><?= $category->name ?></option> 
					<?php } ?>

				    </select>

				</div>
				<a href="#add_people" onclick="add_category()" class="label bg-info btn">+ add new category</a>
			    </div>

			    <br/>
			    <div class="col-sm-12">
				<div class="form-group">
				    <label>Option Fields</label><p class="form-control-static">These are option for your future reference.
					<!--Tick a checkbox to select type of information you want to add-->
				    </p>
				</div>
			    </div>
			    <!--			    <div class="col-sm-12">
							    <div class="form-group">
			    
								<div class="checkbox">
								    <label class="checkbox-custom">Organization Information</label>
								    <input type="checkbox" name="checkboxA"> 
								</div> 
							    </div>
							</div>-->


			    <div class="form-group"> 
				<label class="col-sm-2 control-label">Organization Name</label>
				<div class="col-sm-10">
				    <input type="text" name="organization_name" class="form-control rounded" placeholder="someone organization he/she belons to">
				</div>
			    </div>


			    <div class="form-group"> 
				<label class="col-sm-2 control-label">Organization Position</label> 
				<div class="col-sm-10">
				    <input type="text" name="organization_position" class="form-control rounded" placeholder="Position for which he/she belongs in the  organization">
				</div>
			    </div>

			    <div class="form-group"> 
				<label class="col-sm-2 control-label">Organization other description</label> 
				<div class="col-sm-10">
				    <textarea type="text" name="organization_description" class="form-control" placeholder="any description about that organization"></textarea>
				</div>
			    </div>
			     <div class="form-group"> 
				<label class="col-sm-2 control-label">Notify this Person</label> 
				 <input type="checkbox" id="notify_user" name="notify"/>
				<div class="col-sm-10" style="display: none;" id="notify_sms">
				   
				    <textarea type="text"  name="notify_sms" id="notify_textarea" class="form-control"  placeholder="Write a message that you want this user to receive when you add"></textarea>
					 <label class="col-sm-2 control-label"> Send Via</label> 
		<label class="checkbox-inline"> 
			<input type="radio" id="inlineCheckbox1" name="message_type" value="1" checked="checked"> Internet Messages</label>
		    <label class="checkbox-inline"> 
			<input type="radio" id="inlineCheckbox2" name="message_type"  value="0"> Your phone Messages </label>
					 <div class="alert alert-info">SMS will be sent only when new record is added. When record exist and updated, SMS will not be sent. If you have few SMS remain, contact will be added by SMS will not be sent</div>
				</div>
			
			    </div>

			    <span id="loader"></span>

			    <div class="form-group">
				<label class="col-sm-2 control-label"></label> 
				<div class="col-sm-10">
				    <button type="submit" onclick="submitForm('add_person'); $('#notify_sms').hide()"  class="btn btn-sm btn-success">Submit</button> </div>
			    </div>

			</form> 
		    </section> 
		</section>
	    </div> 
	    <div class="col-sm-4"> 
		<section class="panel panel-default">
		    <header class="panel-heading font-bold">Notes</header>
		    <div class="panel-body">
			<div class="form-group">
			    <p>You can add as many contacts as possible and categorize them. This category will help you later to group contacts and manage well contacts you add</p>
			</div>
			<div class="form-group">
			    <p>Add Contacts From Excel</p>
			    <a href="#add_by_excel"
    			    class="btn btn-s-md btn-info" >Upload Excel</a>
			</div>
		    </div>
		</section>
	    </div> 
	</div>
    </section>
</section>
<script type="text/javascript">
    notify_user=function(){
	$('#notify_user').mousedown(function(){
          $('#notify_sms').toggle();
	  var content='Hello '+$('input[name="firstname"]').val()+', I have add your number '+$('input[name="phone_number"]').val()+' in my KaribuSMS <?php echo ($user->name)?> profile. For any question, please call me via <?php echo ($user->phone_number)?>';
	  $('#notify_textarea').val(content);
	});
    }
    $(document).ready(notify_user);
    function  add_category() {
	swal({
		title: "Add new category !",
		text: 'This will help you to group well your contacts',
		type: 'input',
		showCancelButton: true,
		closeOnConfirm: false,
		animation: "slide-from-top"
	}, 
	function(inputValue){
		if (inputValue === false) return false;

		if (inputValue === "") {
			swal.showInputError("You need to write something!");
			return false;
		}
		$('#add_category').after('<option value="'+inputValue+'">' + inputValue + '</option>');
		swal("Nice!", 'You wrote: ' + inputValue+'. Category will be created when you add at least one person now', "success");
		
	});
    }
</script>