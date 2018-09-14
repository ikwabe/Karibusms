<?php
/**
 * Description of 404
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
<section id="content"> <div class="row m-n">
        <div class="col-sm-4 col-sm-offset-4"> 
            <div class="text-center m-b-lg">
                <h1 class="h text-white animated fadeInDownBig">404</h1> 
            </div> 
            <div class="list-group m-b-sm bg-white m-b-lg"> 
                <section class="panel bg-white"> 
                    <form role="search">
                        <div class="form-group wrapper m-b-none"> 
                            <div class="input-group">
                                <input type="text" id="searchbox" class="form-control" placeholder="Search for business pages"> 
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-info btn-icon"><i class="fa fa-search"></i></button> 
                                </span> 
                            </div> 
                        </div> 
                    </form>
                    <div id="sechdiv"></div>
                </section> 
                <a href="<?=url('/')?>" class="list-group-item"> 
                    <i class="fa fa-chevron-right icon-muted"></i>
                    <i class="fa fa-fw fa-home icon-muted"></i> Goto homepage </a>
                <a data-toggle="ajaxModal" href="<?=url('/contact_us')?>" class="list-group-item"> 
                    <i class="fa fa-chevron-right icon-muted"></i> 
                    <i class="fa fa-fw fa-question icon-muted"></i> Send us a tip </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-chevron-right icon-muted"></i> 
                    <span class="badge">info@karibusms.com</span> 
                    <i class="fa fa-fw fa-phone icon-muted"></i> Call us +255 655 406 004</a>
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