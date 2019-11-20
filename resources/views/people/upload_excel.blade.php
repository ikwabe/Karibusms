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
<section class="panel panel-default"> 
    <div class="panel-body">
	<div class="modal-header"> 
            <h4 class="modal-title">Upload Contacts From Excel</h4>
        </div> 
        <div class="modal-body" id="app_area"> 
	    <div id="ajax_status_result"></div>
            <form action="<?= url('/upload_excel_submit') ?>" id="upload_excel_file" method="post" enctype="multipart/form-data">
		<div class="form-group">
		    <label class="col-sm-2 control-label">File</label>
		    <div class="col-sm-8">
			<input type="file" accept=".xls,.xlsx,.csv,.ods,.xlsm,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"  name="excel_file" id="filestyle-0" class="filestyle" data-icon="false" data-classbutton="btn btn-default">

			<div class="modal-footer"> 
                            <?=csrf_field()?>
			    <input type="submit" class="btn btn-success" value="upload now"/>
			</div>
		    </div> 
		</div>
		<div id="loader"></div>
	    </form>

        </div>
    </div>
    <section class="panel panel-default">
	<header class="panel-heading"> <span class="label bg-dark"></span> Important Instructions </header> <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 450px;">
	    <section class="panel-body slim-scroll" data-height="230px" style="overflow: hidden; width: auto; height: 430px;">
		<article class="media"> <span class="pull-left thumb-sm">
			<i class="fa fa-info-circle fa-3x icon-muted"></i></span> 
		    <div class="media-body">
			<div class="pull-right media-xs text-center text-muted"> <strong class="h4"></strong><br> <small class="label bg-light"></small> </div> <a href="#" class="h4">Supported File Format</a> 

			<small class="block m-t-sm">xls,xlsx, xlsm, csv </small> </div> 
		</article> 
		<div class="line pull-in"></div> 
		<article class="media">
		    <span class="pull-left thumb-sm">
			<i class="fa fa-file-o fa-3x icon-muted"></i></span>
		    <div class="media-body"> 
			<div class="pull-right media-xs text-center text-muted"> 
			    <strong class="h4"></strong><br> 
			    <small class="label bg-light"></small>
			</div> 
			<a href="#" class="h4">File Contents Format</a> 
			<small class="block">
			    <a href="#" class="">The first row of the file should have names indicate contents available in that column. 
				<br/>Supported column names are</a> 
			    <span class="label label-warning" title="Mandatory">phone_number</span> (Mandatory)
			    <span class="label label-warning" title="Mandatory">category</span> (Mandatory)
			    <span class="label label-success">email</span>
			    <span class="label label-success">title</span>
			    <span class="label label-success">firstname</span>
			    <span class="label label-success">lastname</span>
			    <span class="label label-success">country</span>
			    <span class="label label-success">location</span>

			    <span class="label label-success">organization_name</span>
			    <span class="label label-success">organization_description</span>
			</small> 

		    </div> 
		</article> 
		<article class="media">
		    <span class="pull-left thumb-sm">
			<i class="fa fa-file-o fa-3x icon-muted"></i></span>
		    <a href="#" class="h4">Example.</a>
		    <small class="block">Excel file with contents to be uploaded</small>
		    <div class="media-body"> 
			<br/>	<img src="media/images/excel.PNG"/>
		    </div> 

		</article>
	    </section>



	</div>
    </section>
</section>
<script src='<?= url('/') ?>/media/js/bootstrap-filestyle.js'></script>
<script type="text/javascript">
				check_file = function () {
				    $(".filestyle").change(function () {
					var data = {previewFileType: "xls",
					    allowedFileExtensions: ["xls", "csv", "xlsx"],
					    showUpload: false
					}
					
				    });
				}
				$(document).ready(check_file);
</script>