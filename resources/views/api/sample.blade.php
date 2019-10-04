<?php
/**
 * Description of sample
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
$page = request()->route()->parameters()['page'];
?>
@extends('master')
@section('content')
<section id="content"> 
    <div class="bg-white b-b b-light"> 
	<div class="container">
	    <ul class="breadcrumb no-border bg-empty m-b-none m-l-n-sm">
		<li><a href="<?= url('/') ?>">Home</a></li> 
		<li><a href="<?= url('/dev') ?>">dev</a></li>
		<li><a href="<?= url('/dev/' . $page) ?>"><?= $page ?></a></li> 
	    </ul> 

	</div>
    </div> 
    <div>
	<div class="b-t b-light"> 
	    <div class="container m-t-xl"> 
		<div class="row">
		    <div class="col-sm-7"> 
			<h2 class="font-thin m-b-lg">Languages</h2> 
		    </div> 
		    
		    <div class="col-sm-5 text-center fadeInUp animated" data-ride="animated" data-animation="fadeInUp">
			<img src="<?= url('/') ?>/media/images/api/php_flat.png" class="lang_icon white" id="php" width="80" height="80"> 
			<img src="<?= url('/') ?>/media/images/api/java.png" class="lang_icon" id="java"  width="80" height="80"> 
			<img src="<?= url('/') ?>/media/images/api/js.png" class="lang_icon" id="javascript" width="80" height="80"> 
			<img src="<?= url('/') ?>/media/images/api/python.png" class="lang_icon" id="python" width="80" height="80">
		    </div>
		</div> 
	    </div>
	</div> 
	<div class="bg-white b-t b-light"> 
	    <div class="container">
			    	

		<div class="row m-t-xl m-b-xl">
		    <div class="col-sm-5 text-center clearfix m-t-xl fadeInLeftBig animated" data-ride="animated" data-animation="fadeInLeftBig"> 
			<div class="h1 font-bold m-t-xl m-b-xl">
			    <span class="fa-2x icon-muted">
				<img src="<?= url('/') ?>/media/images/api/php_flat.png" id="prev_lang"  width="180" height="180">
			    </span>
			</div> 
		    </div> 
		    <div class="col-sm-7">
			<div class="text-right"><a href="<?= url('/dev/app') ?>" class="btn btn-sm btn-success">Go to App Page</a></div>
			<h2 class="font-thin m-b-lg lang_name">PHP</h2> 
			<p class="h4 m-b-lg l-h-1x">karibuSMS <span class="lang_name">PHP</span> API sample codes can be accessed in the following URI </p>
			<p class="m-b-xl">
			<pre id="github_url">https://github.com/inetscompany/karibuSMS_PHP</pre>
			</p> 
			<p>Following this link you will find all examples, tutorials and any question asked by other developers in our github account.</p>
			<p class="m-t-xl m-b-xl h4">
			    <i class="fa fa-quote-left fa-fw fa-1x icon-muted"></i>
			    <a id="github_link" href="https://github.com/inetscompany/karibuSMS_PHP" target="_blank">Click here to Download or Clone</a></p> </div> 
		</div> 
	    </div>
	</div> 
	
	<div class="b-t b-light pos-rlt bg-white"> 
	    <div class="container"> <p class="m-t-xl m-b-xl">Much more features will be added in. </p> </div> 
	</div>
</section>
<style>
    .lang_icon{cursor: pointer;}
    .white{ background: white;}
    .removewhite{background: none;}
</style>
<script type="text/javascript">
    change_page = function () {
	$('.lang_icon').mousedown(function () {
	    $('.lang_icon, #php').removeClass('white');
	    $(this).addClass('white');
	    var url = $(this).attr('src');
	    var type = $(this).attr('id');
	    var link = '';
	    $('#prev_lang').attr('src', url);
	    $('.lang_name').html(type);
	    switch (type) {
		case 'php':
		    link = 'https://github.com/inetscompany/karibuSMS_PHP';
		    break;
		case 'java':
		    link = 'https://github.com/inetscompany/karibuSMS_JAVA_API';
		    break;
		case 'javascript':
		    link = 'https://github.com/inetscompany/karibuSMS_JavaScript_API';
		    break;
		case 'python':
		    link = 'https://github.com/inetscompany/karibuSMS_PYTHON_API';
		    break;
		default:
		    break;
	    }
	    $('#github_url').html(link);
	    $('#github_link').attr('href', link);
	});
    }
    $(document).ready(change_page);
</script>
@stop