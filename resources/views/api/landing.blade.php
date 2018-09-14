<?php
/**
 * Description of landing
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
@extends('master')
@section('content')
<section id="content">
    <div class="bg-primary dk">
	<div class="text-center wrapper">
	    <div class="m-t-xl m-b-xl"> 
		<div class="text-uc h1 font-bold inline"> 
		    <div class="pull-left m-r-sm text-white">Build apps 
			<span class="font-thin text-muted">That </span>
		    </div> 
		    <div class="carousel slide carousel-fade inline auto aside text-left pull-left pull-none-xs" data-interval="2000"> 
			<div class="carousel-inner"> 
			    <div class="item active text-warning"> last </div> 
			    <div class="item text-dark"> talk </div> 
			    <div class="item"> Scale </div> 
			</div> </div>
		</div> 
		<div class="h4 text-muted m-t-sm">
		    Integrate SMS in your software now to attract more people to use your application </div> </div>
	    <p class="text-center m-b-xl"> 
		<a href="<?= url('/api/doc') ?>" class="btn btn-lg btn-dark m-sm">Get Started Now</a>
		<a href="<?= url('/api/sample') ?>" class="btn btn-lg btn-warning b-white bg-empty m-sm">View Sample Codes</a> </p>
	</div> 
	<div class="dker pos-rlt"> 
	    <div class="container wrapper">
		<div class="m-t-lg m-b-lg text-center"> Make your application faster and easier in sending SMS by using karibuSMS API. </div> 
	    </div> 
	</div> 
    </div> 
    <div id="about">
	<div class="container">
	    <div class="m-t-xl m-b-xl text-center wrapper"> 
		<h3>We have decided to invest for you</h3> 
		<p class="text-muted">If you are a beginner, intermediate or advanced level software developer, our API effectively suites your needs</p>
	    </div> 
	    <div class="row m-t-xl m-b-xl text-center">
		<div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="300">
		    <p class="h3 m-b-lg"> <i class="fa fa-power-off fa-3x text-info"></i></p>
		    <div class="">
			<h4 class="m-t-none">
			    <a href="<?=url('/api/doc')?>">Get Started</a>
			</h4> 
			<p class="text-muted m-t-lg">
			    <a href="<?=url('/api/doc')?>" ><span class="label label-info">Read</span>  our simple documentation page here</a></p>
		    </div>
		</div> 
		<div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="600">
		    <p class="h3 m-b-lg"> 
			<i class="fa fa-code fa-3x text-info"></i> </p> 
		    <div class=""> 
			<h4 class="m-t-none">
			    <a href="<?=url('/api/sample')?>">View Sample Codes</a>
			</h4> 
			<p class="text-muted m-t-lg">
			    <a href="<?=url('/api/sample')?>">Currently <span class="label label-info"> PHP, JAVA, JAVASCRIPT & PYTHON.</span></a>
			</p> 
		    </div>
		</div> 
		<div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="900"> 
		    <p class="h3 m-b-lg"> <i class="fa fa-edit fa-3x text-info"></i> </p> 
		    <div class=""> 
			<h4 class="m-t-none">
			    <a href="<?=url('/api/app')?>">Manage Your Apps</a>
			</h4>
			<p class="text-muted m-t-lg">
			    <a href="<?=url('/api/app')?>"><span class="label label-info">Create your New App</span> or View your Apps for SMS integration.</a></p>
		    </div>
		</div>
	    </div> 
	    <div class="m-t-xl m-b-xl text-center wrapper"> 
		<p class="h5">You can use our API in <span class="text-primary">website & website apps</span>, <span class="text-primary">mobile app</span>, <span class="text-primary">desktop app</span>... </p> </div>
	</div>
    </div>
   
</section> <!-- footer --> 

@stop