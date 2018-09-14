<!-- header --> 
<header id="header" class="navbar navbar-fixed-top bg-white box-shadow b-b b-light" data-spy="affix" data-offset-top="1"> <div class="container">
        <div class="navbar-header">
            <a href="<?= HOME ?>" class="navbar-brand">
                <img src="media/images/logo.png" class="m-r-sm">
                <span class="text-muted">karibuSMS</span></a> 
            <button class="btn btn-link visible-xs" type="button" data-toggle="collapse" data-target=".navbar-collapse"> <i class="fa fa-bars"></i> </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li> <a href="<?= HOME ?>features">Features</a> </li> 
                <li> 
                    <a href="<?= HOME ?>payment">Pricing</a> 
                </li>
		<ul class="nav navbar-nav hidden-xs">
		    <li class="dropdown"> <a href="#" class="dropdown-toggle dker" data-toggle="dropdown"><span class="font-bold">Contact</span> </a> 
			<section class="dropdown-menu aside-xl on animated fadeInLeft no-borders lt">
			    <div class="wrapper lter m-t-n-xs"> 
				<a href="#" class="thumb pull-left m-r">
				    <img src="media/images/avatar_default.jpg" class="img-circle"> </a> 
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
                <li> <div class="m-t-sm">
                        <a href="#" class="btn btn-link btn-sm">Sign in</a>
                        <a href="<?= HOME ?>register" class="btn btn-link btn-sm"><strong>Sign up</strong></a></div> </li>
            </ul> </div> </div>
</header> <!-- / header -->

<section id="content"> 

    <div class="bg-gradient"> 

        <div class="text-center wrapper"> 
            <div class="h4 text-muted m-t-sm">
		Easy and effective Customer  Management tool </div>
            <a href="<?= HOME ?>register" class="btn btn-lg btn-primary b-primary  m-sm">Sign Up</a><br/>
            OR
        </div> 

        <div class="padder"> 
            <div class="hbox"> 
                <section id="content" class="m-t-lg wrapper-md animated fadeInUp">

                    <div class="container aside-xxl"> 
                        <section class="panel panel-default bg-white m-t-lg"> 
                            <header class="panel-heading text-center">
                                <strong>Sign in</strong> 
                            </header> 
                            <form class="panel-body wrapper-lg" id="signin_form"> 
                                <div class="form-group"> 
                                    <label class="control-label">Phone number</label> 
                                    <input type="text" name="phone_number" id="phone" required="required" placeholder="0XXX XYZ XYZ" class="form-control input-lg"> 
                                </div> 
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="password" name="password" id="inputPassword" required="required" placeholder="Password" class="form-control input-lg">
                                </div> 
				<!--                                <div class="checkbox"> 
								    <label> <input type="radio" name="service" checked="checked" value="karibuSMS"> Sign in to karibuSMS </label> 
								    <label><BR/> <input type="radio" name="service" checked="checked" value="pesaSMS"> Sign in to PesaSMS </label> 
								</div> -->
                                <div class="checkbox"> 
                                    <label> <input type="checkbox" name="checkbox" checked="checked"> Keep me signed in </label>
                                </div> 
                                <a href="<?= HOME ?>login&sec=forget_pw" class="pull-right m-t-xs"><small>Forgot password?</small></a> 
                                <button type="button" class="btn btn-primary" onclick="javascript: signin();">Sign in</button> 
                                <div id="login_ajax_request"></div>
                                <div class="line line-dashed"></div>	  
                            </form> 

                        </section> 
                    </div>

                </section> 
            </div>
        </div>

        <div class="dker pos-rlt">
            <div class="container wrapper">
                <div class="m-t-lg m-b-lg text-center">
                   Its simple to use and effective customer engagement solution</div>
            </div> 
        </div> 
    </div> 

    <div id="about">
        <div class="container">
            <div class="m-t-xl m-b-xl text-center wrapper">
                <h3>What is karibuSMS ?</h3> 
                <p class="text-muted">
                     karibu (in SWAHILI means welcome or come close). <br/>Is the customer management tool that help small and medium businesses to easily manage their customers and promote sales and marketing</p> 

		<h3>Accessed via</h3>
            </div> 
            <div class="row m-t-xl m-b-xl text-center">

                <div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="300">
                    <p class="h3 m-b-lg"> 
                        <i class="fa fa-mobile fa-3x text-info"></i> 
                    </p> 
                    <div class="">
                        <h4 class="m-t-none">Android Mobile Application</h4>
                        <p class="text-muted m-t-lg">Download <a href="http://goo.gl/msamgD" target="_blank" class="label label-info"> here</a> our Mobile app (OPTION) or just use <a class="label label-success" href="<?= HOME ?>karibusmspro">internet messages</a>  to send SMS  to your customers.</p> </div> 
                </div>
                <div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="600"> <p class="h3 m-b-lg"> <i class="fa fa-user fa-3x text-info"></i> </p> <div class=""> <h4 class="m-t-none">Cloud Based or Inhouse installation</h4> <p class="text-muted m-t-lg">You can just access this application anywhere via the internet or you decide to install it in your premises. We also provide custom development to suite your needs as you wish.</p> </div> </div> 
                <div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="900"> <p class="h3 m-b-lg"> <i class="fa fa-gears fa-3x text-info"></i> </p> <div class=""> 
                        <h4 class="m-t-none">Developer API</h4> 
                        <p class="text-muted m-t-lg">karibuSMS <a href="<?= HOME ?>api" class="label label-info" title="PHP and jQuery APIs">Developer APIs</a> allows any of your software application to be integrated with karibuSMS and access all powerful features of karibuSMS in your application.</p> </div> </div> 
            </div> 
        </div> </div>


<!--    <div id="responsive" class="bg-dark">
        <div class="text-center">
            <div class="container"> 
                <div class="m-t-xl m-b-xl wrapper"> 
                    <h3 class="text-white">Become Connected on Social Media</h3> 
                    <p>KaribuSMS is well connected with all major social networks to allow more customers from social network to like your page </p> 
                    <br>KaribuSMS is now connected with</div>
                <div class="row m-t-xl m-b-xl"> 
                    <div class="col-sm-4 wrapper-xl" data-ride="animated" data-animation="fadeInLeft" data-delay="300"> <p class="text-center h2 m-b-lg m-t-lg"> <span class="fa-stack fa-2x">
                                <i class="fa fa-facebook-square fa-stack-2x text-dark"></i> 
                                <i class="fa fa-facebook fa-stack-1x text-muted"></i> </span> </p> 
                        <p>Facebook</p> 
                    </div> 
                    <div class="col-sm-4 wrapper-xl" data-ride="animated" data-animation="fadeInLeft" data-delay="600"> <p class="text-center h1 m-b-lg"> 
                            <span class="fa-stack fa-2x"> 
                                <i class="fa fa-twitter-square fa-stack-2x text-dark"></i> 
                                <i class="fa fa-twitter fa-stack-1x text-muted"></i> </span> 
                        </p> <p>Twitter</p> 
                    </div>
                    <div class="col-sm-4 wrapper-xl" data-ride="animated" data-animation="fadeInLeft" data-delay="900"> <p class="text-center h2 m-b-lg m-t-lg"> <span class="fa-stack fa-2x"> 
                                <i class="fa fa-google-plus-square fa-stack-2x text-dark"></i> 
                                <i class="fa fa-google-plus fa-stack-1x text-muted text-md"></i> </span> </p> <p>Google+</p> </div> </div> </div> </div> </div> -->

    <div id="newsletter" class="bg-white clearfix wrapper-lg"> 
	<script type="text/javascript">
	    $.get(url, {pg: 'login', part: 'social_media', type: country.code}, function (data) {
		$('#social_media_links').html(data);
	    });
	</script>
	<div class="container text-center m-t-xl m-b-xl" data-ride="animated" data-animation="fadeIn">
            <h2>Like or follow us on social networks</h2> 
            <p>We are social, and we like to hear from you and be friends</p>

            <div class="m-t-sm m-b-lg" id="social_media_links"></div>
        </div> 
    </div>
</section> <!-- footer --> 

<footer id="footer"> <div class="bg-primary text-center"> <div class="container wrapper"> <div class="m-t-xl m-b"> For reliable customer management solution <a href="<?= HOME ?>register"  class="btn btn-lg btn-dark b-white bg-empty m-sm">Sign Up</a> or <a href="#" class="btn btn-lg btn-info b-white bg-empty m-sm">Sign in</a> </div> </div> <i class="fa fa-caret-down fa-4x text-primary m-b-n-lg block"></i> </div> <div class="bg-dark dker wrapper"> 
    </div> </footer> <!-- / footer -->
<?php
css_media('landing');
?>
<script>
    $('body').keypress(function (e) {
	if (e.which == 13) {
	    signin();
	}
    });
    signin = function () {
	if ($('#inputPassword').val == '' || $('#phone').val() == '') {
	    $('#login_ajax_request').html('<br/><div class="alert alert-danger">\n\
                                   <button type="button" class="close" data-dismiss="alert">×</button>\n\
                                   <i class="fa fa-ban-circle"></i> Fill all fields</div>');
	    return false;
	}
	var datastring = $('#signin_form').serialize();
	$('#login_ajax_request').html(LOADER);
	$.getJSON(url, {pg: 'login', process: 'login', datastring: datastring}, function (data) {
	    if (data.error == 0) {
		window.location.reload();
	    } else {
		$('#login_ajax_request').html(data.error);
	    }
	}).error(function (data) {
	    console.log(data);
	});
    };
    function call_validate() {
	var phone_number = $('#phone').val();
	$('#content').html(LOADER);
	$.get(url, {pg: 'register', section: 'validate_phonenumber', phone_number: phone_number}, function (data) {
	    $('#content').html(data);
	});
    }
</script>
<div id="fb-root"></div>
<script>(function (d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id))
	    return;
	js = d.createElement(s);
	js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=526011487520671&version=v2.0";
	fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<script>!function (d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (!d.getElementById(id)) {
	    js = d.createElement(s);
	    js.id = id;
	    js.src = "//platform.twitter.com/widgets.js";
	    fjs.parentNode.insertBefore(js, fjs);
	}
    }(document, "script", "twitter-wjs");</script>