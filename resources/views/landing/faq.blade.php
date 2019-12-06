<?php
/**
 * Description of faq
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
    <div class="bg-dark lt"> <div class="container"> 
            <div class="m-b-lg m-t-lg"> 
                <h3 class="m-b-none">FAQ page</h3>
                <small class="text-muted">Frequently asked questions</small>
            </div> </div> </div> 
    <div class="bg-white b-b b-light"> <div class="container">
            <ul class="breadcrumb no-border bg-empty m-b-none m-l-n-sm">
                <li><a href="<?= url('/') ?>">Home</a></li> 
                <li class="active">faq</li> 
            </ul>
        </div> 
    </div>
    <div class="container m-t-lg m-
         b-lg">
        <div class="row">
            <div class="col-sm-9"> 
                <div class="blog-post">
                    <?php
                    $obj = json_decode($data);
                    $i = 1;
                  
                    if (count($obj) > 0) {
                        foreach ($obj as $content) {
                            ?>
                            <div class="post-item"> 
                                <div class="post-media">
                                </div> 
                                <div class="caption wrapper-lg"> 
                                    <h2 class="post-title">
                                        <a href="#">#<?= $i ?></a></h2> 
                                    <div class="post-sum">
                                        <div>
                                            <p class="h4 m-b-lg l-h-1x"><?= $content->question ?> </p>

                                            <p><?= $content->answer ?></p>
                                        </div>
                                    </div> 
                                    <div class="line line-lg"></div>
                                    <div class="text-muted"> <i class="fa fa-user icon-muted"></i> by <a href="#" class="m-r-sm">Admin</a>  </div>
                                </div> 			
                            </div> 
                            <?php
                            $i++;
                        }
                    }
                    ?>

                </div>
            </div>
            <div class="col-sm-3">

                <h5 class="font-semibold">Follow us</h5>
                <div class="line line-dashed"></div>
                <div class="m-t-sm m-b-lg"> 

                    <div class="m-t-sm m-b-lg" id="social_media_links">
                        <p> 
                            <a  id="twitter_button" title="twitter" href="https://twitter.com/karibuSMS" class="twitter-follow-button" data-show-count="true" data-lang="en">Follow @karibuSMS</a>
                        <div class="line line-dashed"></div> 
                        <a href="#" title="Facebook">
                            <div class="fb-like" data-href="http://karibusms.com" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>

                        </a>
                        <div class="line line-dashed"></div> 
                        <!-- Place this tag in your head or just before your close body tag. -->
                        <script src="https://apis.google.com/js/platform.js" async defer></script>
                        <link rel="canonical" href="http://www.karibusms.com" />
                        <!-- Place this tag where you want the +1 button to render. -->
                        <div class="g-plusone" data-annotation="inline" data-width="300"></div>
                        </p>

                    </div>
                </div>
                <h5 class="font-semibold">Recent Tweets</h5> 
                <div class="line line-dashed"></div>  
                <ul class="list-unstyled m-b-lg" style="max-height: 30em; overflow: scroll;">
                    <a class="twitter-timeline" href="https://twitter.com/KaribuSMS">Tweets by KaribuSMS</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script> 
                </ul>

            </div> </div> </div>
</section>
@stop