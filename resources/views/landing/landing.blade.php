<!-- header -->
@extends('master')
@section('content')

<section id="content"> 

    <div class="bg-gradient" style="background-image: 'http://localhost/karibu_laravel/media/images/app.png';"> 

        <div class="text-center wrapper"> 
            <div class="h4 text-muted m-t-sm">
                A Way to SMS to your phone numbers easily</div>
            <a href="<?= HOME ?>signup" class="btn btn-lg btn-primary b-primary  m-sm">Sign Up</a><br/>
            OR
        </div> 

        <div class="row">

            <!--	    <div class="col-sm-12 col-lg-8">
                            <div class="post-media">
                                <section class="panel bg-primary dk m-b-none">
                                    <div class="carousel auto slide panel-body" id="c-fade"> 
                                        <ol class="carousel-indicators out"> 
                                            <li data-target="#c-fade" data-slide-to="0" class=""></li> 
                                            <li data-target="#c-fade" data-slide-to="1" class=""></li>
                                            <li data-target="#c-fade" data-slide-to="2" class=""></li> 
                                        </ol> 
                                        <div class="carousel-inner"> 
                                            <div class="item text-center">
                                                <span class="h2">
                                                    <i class="fa fa-clock-o fa-5x m-t icon-muted"></i>
                                                </span> 
                                                <p class="text-muted m-t m-b-lg">Make your Event Beautiful by using karibuSMS</p>
                                            </div>
                                            <div class="item text-center active left"> 
                                                <span class="h2"><i class="fa fa-file-o fa-5x m-t icon-muted"></i></span>
                                                <p class="text-muted m-t m-b-lg">Engage with your contacts or customer more easily that before with karibuSMS</p>
                                            </div> 
                                            <div class="item text-center next left">
                                                <span class="h2"><i class="fa fa-mobile fa-5x m-t icon-muted"></i></span> 
                                                <p class="text-muted m-t m-b-lg">Make your software application notify users with automatic SMS </p> 
                                            </div> 
                                        </div>
                                        <a class="left carousel-control" href="#c-fade" data-slide="prev"> 
                                            <i class="fa fa-angle-left"></i> 
                                        </a> 
                                        <a class="right carousel-control" href="#c-fade" data-slide="next"> 
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </section>
                            </div>
                        </div>-->
            <div class="col-sm-12 col-lg-12">
                <div class="padder"> 
                    <div class="hbox"> 
                        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">

                            <div class="container aside-xxl"> 
                                <section class="panel panel-default bg-white m-t-lg"> 
                                    <header class="panel-heading text-center">
                                        <strong>Sign in</strong> 
                                    </header> 

                                    <form class="panel-body wrapper-lg" id="signin_form" method="POST" action="{{ url('/login') }}"> 
                                         {{ csrf_field() }}

                                        <div class="form-group"> 
                                            @if ($errors->has('email'))
                                            <span class="alert alert-danger">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                            @if (session('status'))
                                            <div class="alert alert-success">
                                                {{ session('status') }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Email or Phone number</label>
                                            <input type="text" name="phone_number" id="phone" required="required"
                                                   placeholder="0XXX XYZ XYZ" class="form-control input-lg">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Password</label>
                                            <input type="password" name="password" id="inputPassword"
                                                   required="required" placeholder="Password"
                                                   class="form-control input-lg">
                                            @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <!--                                <div class="checkbox">
                                                            <label> <input type="radio" name="service" checked="checked" value="karibuSMS"> Sign in to karibuSMS </label>
                                                            <label><BR/> <input type="radio" name="service" checked="checked" value="pesaSMS"> Sign in to PesaSMS </label>
                                                        </div> -->
                                        <div class="checkbox">
                                            <label> <input type="checkbox" name="remember" checked="checked"> Keep
                                                me signed in </label>
                                        </div>
                                        <a href="<?= url('/password/reset') ?>"
                                           class="pull-right m-t-xs">
                                            <small>Forgot password?</small>
                                        </a>
                                       <button type="button" class="btn btn-primary" onclick="signin();">Sign in
                                        </button>
<!-- <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>-->

                                        <div id="login_ajax_request"></div>
                                        <div class="line line-dashed"></div>
                                    </form>

                                </section>
                            </div>

                        </section>
                    </div>
                </div>

            </div>
        </div>
        <div class="dker pos-rlt">
            <div class="container wrapper">
                <div class="m-t-lg m-b-lg text-center">
                  karibuSMS helps you to send SMS to many people fast and at once at very low cost 
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<div class="dker pos-rlt">
    <div class="container wrapper">
        <div class="m-t-lg m-b-lg text-center">
            Just create an account and start to send SMS now.</div>
    </div> 
</div> 
</div> 

<div id="about">
    <div class="container">
        <div class="m-t-xl m-b-xl text-center wrapper">
            <h3>What is karibuSMS ?</h3> 
            <p class="text-muted">

                KaribuSMS is derived from a Swahili word <b>karibu</b> that means <b>Welcome</b> . <br/>It is the SMS  & Contacts management platform that will helps you or your business to easily manage contacts and share information using SMS.</p>
            <h3>Accessed via</h3>
        </div> 
        <div class="row m-t-xl m-b-xl text-center">

            <div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="300">
                <p class="h3 m-b-lg"> 
                    <i class="fa fa-mobile fa-3x text-info"></i> 
                </p> 
                <div class="">
                    <h4 class="m-t-none">Android Mobile Application</h4>
                    <p class="text-muted m-t-lg">Download <a href="https://goo.gl/APJaej" target="_blank" class="label label-info"> here</a> our Mobile app to send Free SMS from our platform to all your contacts  or just use <a class="label label-success" href="<?= HOME ?>/dev">internet messages</a>  to send SMS  to your contacts.</p> </div> 
            </div>
            <div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="600"> <p class="h3 m-b-lg"> <i class="fa fa-user fa-3x text-info"></i> </p> <div class=""> <h4 class="m-t-none">Login Anywhere with any Browser</h4> <p class="text-muted m-t-lg">You can easily access karibuSMS  application anywhere via your browser or android phone to share information via SMS. Your contacts will receive SMS by any kind of mobile phone. We also provide custom development to suite your needs as you wish.</p> </div> </div> 
            <div class="col-sm-4" data-ride="animated" data-animation="fadeInLeft" data-delay="900"> <p class="h3 m-b-lg"> <i class="fa fa-gears fa-3x text-info"></i> </p> <div class=""> 
                    <h4 class="m-t-none">Developer API</h4> 
                    <p class="text-muted m-t-lg">karibuSMS <a href="<?= HOME ?>/dev" class="label label-info" title="PHP, JAVA and jQuery APIs">Developer APIs</a> allows any of your system/software application to be integrated with karibuSMS and access all powerful features of karibuSMS in your application.</p> </div> </div> 
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
    <div class="container text-center m-t-xl m-b-xl" data-ride="animated" data-animation="fadeIn">
        <h2>Like or follow us on social networks</h2> 
        <p>We are social, and we like to hear from you and be friends</p>

        <div class="m-t-sm m-b-lg" id="social_media_links">
            <p> <a  id="twitter_button" title="twitter" href="https://twitter.com/karibuSMS" class="twitter-follow-button" data-show-count="true" data-lang="en">Follow @karibuSMS</a>

                <a href="#" title="Facebook">
                    <div class="fb-like" data-href="http://karibusms.com" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>

                </a> 
                <!-- Place this tag in your head or just before your close body tag. -->
                <script src="https://apis.google.com/js/platform.js" async defer></script>
                <link rel="canonical" href="http://www.karibusms.com" />
                <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-annotation="inline" data-width="300"></div>
            </p>

        </div>
    </div> 
</div>
</section> <!-- footer --> 

<footer id="footer"> <div class="bg-primary text-center"> <div class="container wrapper"> <div class="m-t-xl m-b"> For reliable SMS & contacts management solution <a href="<?= url('/') ?>/signup"  class="btn btn-lg btn-dark b-white bg-empty m-sm">Sign Up</a> or <a href="#" class="btn btn-lg btn-info b-white bg-empty m-sm">Sign in</a> </div> </div> <i class="fa fa-caret-down fa-4x text-primary m-b-n-lg block"></i> </div> <div class="bg-dark dker wrapper"> 
    </div> </footer> <!-- / footer -->

@stop
<?php
//css_media('landing');
?>
@section('footer')
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
                                                $.getJSON('login/store', {datastring: datastring}, function (data) {
                                                    console.log(data);
                                                    if (data.error == 0) {
                                                        window.location.href = '<?= url('/') ?>';
                                                    } else {
                                                        swal('warning', 'Wrong phone number or password', 'warning');
                                                        $('#login_ajax_request').html('');
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

@stop