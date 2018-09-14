<?php


/**
 * Description of email_validated
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
    <div class="row m-n">
        <div class="col-sm-4 col-sm-offset-4"> 
	    <header></header>
            <div class="list-group m-b-sm bg-white m-b-lg"> 
                <br/>
		<section class="panel bg-white"> 
		    <div class="alert alert-success">
			Email verified successfully
		    </div>
                </section> 
                <a href="<?=url('/')?>" class="list-group-item"> 
                    <i class="fa fa-chevron-right icon-muted"></i>
                    <i class="fa fa-fw fa-home icon-muted"></i> Goto homepage </a>
          
            </div>
        </div> 
    </div> 
</section> <!-- footer --> 
<footer id="footer"> 
    <div class="text-center padder clearfix">
        <p> <small>Karibu web application<br>&copy; <?= date('Y') ?></small> </p> 
    </div> 
</footer>
@stop