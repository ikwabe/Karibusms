<?php
/**
 * @author Ephraim Swilla <ephraim@inetstz.com>
 * Date: 1/23/16
 */
?>
<!DOCTYPE html>
<html lang="en" ng-app="karibusms">

    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="karibu, SMS web app, SMS business support, people get connected with business, Customer support application, be the first to know" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
	<meta charset="utf-8"/>
	<link href="<?= url('/') ?>/media/images/logo.png" rel="shortcut icon" type="image/x-icon" />
	<!--    <meta name="google-translate-customization" content="f08fefcb14c1447d-a1f03246bc4214cf-gecf7d7142d3c86be-11"></meta>
	-->
	<meta name="google-translate-customization" content="AIzaSyAEswiv76lGpmcCBQC7yAmyzZzvHOnve_Y"></meta>
	<!--    
	    <meta name="google-site-verification" content="+nxGUDJ4QpAZ5l9Bsjdi102tLVC21AIh5d1Nl23908vVuFHs34="/>-->    <!--<script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>--> 
	<?php
	/* --------all css media and js load here------- */
	?>

	<script type="text/javascript">
	    //----------------JavaScript variables------------------------------ 
//	           var country = {
//	                name: geoplugin_countryName(),
//	                region: geoplugin_region(),
//	                city: geoplugin_city(),
//	                code: geoplugin_countryCode(),
//	                continent: geoplugin_continentCode(),
//	                latitude: geoplugin_latitude(),
//	                longitude: geoplugin_longitude(),
//	                currency_code: geoplugin_currencyCode(),
//	                currency_symbol: geoplugin_currencySymbol()
//	            };
	    var url = "<?= url('/') ?>/";
	    var home = "<?= url('/') ?>/";
	    var LOADER = '<?= LOADER ?>';
	    function change_cost(cost, to) {
		switch (to) {
		    case 'usd':
			return  Math.ceil(cost / 1620 * 1) / 1; //we need 2dp in us $
			break;
		    default:
			return cost;
			break;
		}
	    }
	    // var subscription_number=country.code=='TZ'? '15573': '+255 714 825 469';

	</script> 
	<link href="<?= url('/') ?>/media/css/app.v2.css" rel="stylesheet">
	<link href="<?= url('/') ?>/media/css/landing.css" rel="stylesheet">
	<link rel='stylesheet' href="<?= url('/') ?>/media/css/sweet-alerts/sweetalert.css">
	<script src="<?= url('/') ?>/media/js/app.v2.js"></script>
	<script src="<?= url('/') ?>/media/js/hashchange.js"></script>
	<script src="<?= url('/') ?>/media/js/custom.js"></script>
	<script src="<?= url('/') ?>/media/js/validator.js"></script>
	<script src="<?= url('/') ?>/media/js/jquery.jcryption.3.0.1.js"></script>
	<meta name="csrf-token" content="{{ csrf_token()}}" />
       
         <script type="text/javascript">


            ajax_setup = function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    async: true,
                    cache: false
                });
            }
            $(document).ready(ajax_setup);

        </script>
	<script src="<?= url('/') ?>/media/js/sweet-alert/sweetalert.min.js"></script>
	<?php
	// css_media('app.v2');
	//css_media('font');
	//css_media('landing');
	?>
	<!--[if lt IE 9]> 
	<script src="js/ie/html5shiv.js"></script> 
	<script src="js/ie/respond.min.js"></script>
	<script src="js/ie/excanvas.js"></script> 
	<![endif]-->
	<?php
//    js_media('app.v2');
//    js_media('custom');
//  js_media('jquery.jcryption.3.0.1');
	?>
	<!--<script src="https://ajax.googledevs.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>-->
	<title>karibuSMS</title> 
	<style type="text/css">
	    .ajax_loader{
		display: none;
	    }
	</style>
    </head>

    <body class="special">

	<!--If you uncomment this, a page will be loaded in the middle-->

	<!--<div class="container">-->
	<header id="header" class="navbar navbar-fixed-top bg-white box-shadow b-b b-light" data-spy="affix" data-offset-top="1">
	    <div class="container"> 
		<div class="navbar-header"> 
		    <a href="<?= url('/') ?>" class="navbar-brand">
			<img src="<?= url('/') ?>/media/images/logo.png" class="m-r-sm">
			<span class="text-muted">KaribuSMS</span>
		    </a>
		    <button class="btn btn-link visible-xs" type="button" data-toggle="collapse" data-target=".navbar-collapse"> 
			<i class="fa fa-bars"></i> 
		    </button>
		</div>
		<div class="collapse navbar-collapse">
		    <ul class="nav navbar-nav navbar-right">
			<li class="active"> 
			    <a href="<?= url('/') ?>">Home</a> 
			</li>

			<li> 
			    <a href="<?= url('/') ?>/features">Features</a> 
			</li>

			<!--                <li> 
					    <a href="<?= url('/') ?>karibusmspro">karibuSMS pro</a> 
					</li>
					<li> 
					    <a href="<?= url('/') ?>shortcode">Shortcode</a> 
					</li>
					<li> 
					    <a href="<?= url('/') ?>faq">FAQ</a> 
					</li>-->
			<!--                <li> 
					    <a href="<?= url('/') ?>help&sec=samples">Sample ads</a> 
					</li>-->
			<li> 
			    <a href="<?= url('/') ?>/payment">Pricing</a> 
			</li>
			<li> 
			    <a href="<?= url('/') ?>/faq">FAQ</a> 
			</li>
			<ul class="nav navbar-nav hidden-xs">
			    <li class="dropdown"> <a href="#" class="dropdown-toggle dker" data-toggle="dropdown"><span class="font-bold">Contact</span> </a> 
				<section class="dropdown-menu aside-xl on animated fadeInLeft no-borders lt">
				    <div class="wrapper lter m-t-n-xs"> 
					<a href="#" class="thumb pull-left m-r">
					    <img src="<?= url('/') ?>/media/images/avatar_default.jpg" class="img-circle"> </a> 
					<div class="clear"> 
					    <a href="#"><span class="text-dark font-bold">@Sales & Support</span></a> 
					    <small class="block">Mobile: +255 655 406 004</small>
					    <small class="block">Tel: +255 22 278 0228</small>
					    <a href="#" class="btn btn-xs btn-success m-t-xs">6:00h to 15:00h (GMT)</a>
					</div>
				    </div> <div class="row m-l-none m-r-none m-b-n-xs text-center"> 
					<div class="col-xs-8 dk">
					    <div class="padder-v"> 
						<span class="m-b-xs block text-dark"><a href="mailto: sales@karibusms.com">sales@karibusms.com</a></span>
						<small class="text-muted">Sales Request</small>
					    </div> 
					    <div class="padder-v"> 
						<span class="m-b-xs block text-dark"><a href="mailto: info@karibusms.com">info@karibusms.com</a></span>
						<small class="text-muted">Other Request</small>
					    </div> 
					</div>
				    </div>
				</section> 
			    </li> 
			</ul>
			<!--                 <li> 
					    <a href="<?= url('/') ?>help&sec=blog">Blog</a> 
					</li>-->
			<?php if (session('client_id') == NULL) { ?>
    			<li> 
    			    <div class="m-t-sm">
    				<a href="<?= url('/') ?>" class="btn btn-link btn-sm">Sign in</a> 
    				<a href="<?= url('/') ?>/signup" class="btn btn-sm btn-success m-l"><strong>Sign up</strong></a>
    			    </div> 
    			</li> 
			<?php } ?>
		    </ul> 
		</div> 
	    </div> 
	</header> <!-- / header -->
	@yield('content')


	<!--</div>-->


	<!-- Placed js at the end of the document so the pages load faster -->

	<!--Core js-->
	<?php
	$page = request()->route()->uri();
	?>
	<?php
	if (preg_match('/dev/i', $page)) {
	    ?>
    	<ul class="nav navbar-nav hidden-xs" id="developer_subscriber">
    	    <li class="dropdown">
    		<a href="#" class="dropdown-toggle dker btn btn-info" data-toggle="dropdown"> 
    		    <i class="fa fa-bell"></i>
    		    <span class="font-bold">Subscribe</span>
    		</a> 
    		<section class="dropdown-menu aside-xl on animated fadeInLeft no-borders lt">
    		    <div class="wrapper lter m-t-n-xs">
    			<div class="clear"> 
    			    <small class="block">Start to receive our API developer updates</small>  
    			</div>
    		    </div>
    		    <div class="row m-l-none m-r-none m-b-n-xs text-center">
    			<div class="col-xs-8">
    			    <input type="email" id="dev_email" class="input-sm form-control input-s-sm" placeholder="Your email"/>
    			</div> 
    			<div class="col-xs-4"> 
    			    <div class="padder-v">
    				<button class="btn btn-success" id="subscribe_btn">Submit</button>
    			    </div> 
    			</div>
    		    </div> 
    		</section>
    	    </li>
    	</ul>
    	<style>
    	    #developer_subscriber{position: absolute;
    				  top: 50%;
    	    }
    	</style>
    	<script type="text/javascript">
    	    subscribe = function () {
    		$('#subscribe_btn').mousedown(function () {
    		    $.getJSON('<?= url('/subscribe/developer') ?>', {email: $('#dev_email').val()}, function (data) {
    			swal(data.status, data.message, data.status);
    		    });
    		});
    	    }
    	    $(document).ready(subscribe);
    	</script>
	<?php } ?>
	<footer id="footer"> 
	    <div class="bg-primary text-center">
		<div class="container wrapper"> 
		    <div class="m-t-xl m-b"> Karibu, a way to be connected with contacts and share via SMS. 
			<?php
			if (!preg_match('/dev/i', $page)) {
			    ?>
    			<a href="<?= url('/') ?>/dev" target="_blank" class=" b-white bg-empty m-sm">Get Our Developer API</a>
			<?php } ?>
			<!--               <a href="index.html" target="_blank" class="btn btn-lg btn-warning b-white bg-empty m-sm">Live Preview</a> -->
		    </div> 

		</div> 
		<i class="fa fa-caret-down fa-4x text-primary m-b-n-lg block"></i> 
	    </div> 
	    <div class="bg-dark dker wrapper"> 
		<div class="container text-center m-t-lg">
		    <div class="row m-t-xl m-b-xl"> 
			<div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="300">
			    <i class="fa fa-map-marker fa-3x icon-muted"></i> 
			    <h5 class="text-uc m-b m-t-lg">Find Us</h5> 
			    <p class="text-sm">Mikocheni B, Bima Road, Block no 11, Dar es salaam, Tanzania<br> Mobile Contact — +255 655 406 004 </p> 
			</div> 
			<div class="col-sm-4" data-ride="animated" data-animation="fadeInUp" data-delay="600"> 
			    <i class="fa fa-envelope-o fa-3x icon-muted"></i> 
			    <h5 class="text-uc m-b m-t-lg">Mail Us</h5>
			    <p class="text-sm"><a href="mailto:info@karibu.com">info@karibusms.com</a></p> 
			</div> 
			<div class="col-sm-4" data-ride="animated" data-animation="fadeInRight" data-delay="900">
			    <i class="fa fa-globe fa-3x icon-muted"></i> 
			    <h5 class="text-uc m-b m-t-lg">Join Us</h5> 
			    <p class="text-sm">Send your interest <br>
				Custom Solution:- <a href="mailto:investor@karibu.com">info@karibusms.com</a></p> 
			    <p class="text-sm">Jobs:- <a href="mailto:investor@karibu.com">jobs@karibusms.com</a></p> 

			</div> 
		    </div> 
		    <div class="m-t-xl m-b-xl">
			<p> <a target="_blank" href="https://www.facebook.com/karibuSMS" class="btn btn-icon btn-rounded btn-facebook bg-empty m-sm">
				<i class="fa fa-facebook"></i></a>
			    <a target="_blank" href="https://twitter.com/KaribuSMS" class="btn btn-icon btn-rounded btn-twitter bg-empty m-sm"><i class="fa fa-twitter"></i></a>
			    <a target="_blank" href="https://plus.google.com/109761774317687567059" rel="publisher" class="btn btn-icon btn-rounded btn-gplus bg-empty m-sm"><i class="fa fa-google-plus"></i></a>
			</p> 
			<p> 
			    <a href="#content" data-jump="true" class="btn btn-icon btn-rounded btn-dark b-dark bg-empty m-sm text-muted">
				<i class="fa fa-angle-up"></i></a> 
			</p> 
		    </div> 
		</div> 
	    </div> 
	</footer> <!-- / footer --> 

	@yield('footer')
    </body>
<!--  Widget Code -->
<script type="text/javascript">
//            ((function(){
//                var load=function(){
//                    var script="https://s.acquire.io/a-0e8be/init.js?full";
//                    var x=document.createElement('script');
//                    x.src=script;x.async=true;
//                    var sx=document.getElementsByTagName('script')[0];
//                    sx.parentNode.insertBefore(x, sx);
//                    
//};
//                if(document.readyState === "complete")
//                    load();
//                else if (window.addEventListener)  
//                    window.addEventListener('load',load,false);
//                else if (window.attachEvent) {
//                    window.attachEvent("onload", load);
//                }
//            })())
</script>
 <noscript><a href="https://www.acquire.io?welcome" title="live chat software">Acquire</a></noscript>
<!-- / Widget Code -->
    <script type="text/javascript">
	$('.ajax_loader').html(LOADER);
    </script>
    <div id="fb-root"></div>
    <script>
//            (function (d, s, id) {
//	    var js, fjs = d.getElementsByTagName(s)[0];
//	    if (d.getElementById(id))
//		return;
//	    js = d.createElement(s);
//	    js.id = id;
//	    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=526011487520671&version=v2.0";
//	    fjs.parentNode.insertBefore(js, fjs);
//	}(document, 'script', 'facebook-jssdk'));
            </script>
    <script>
//            !function (d, s, id) {
//	    var js, fjs = d.getElementsByTagName(s)[0];
//	    if (!d.getElementById(id)) {
//		js = d.createElement(s);
//		js.id = id;
//		js.src = "//platform.twitter.com/widgets.js";
//		fjs.parentNode.insertBefore(js, fjs);
//	    }
//	}(document, "script", "twitter-wjs");</script>
</html>
