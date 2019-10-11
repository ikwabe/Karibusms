<?php
/**
 * @author Ephraim Swilla <ephraim@inetstz.com>
 * Date: 1/23/16
 */
$user = App\Http\Controllers\Controller::user_info();
$link = 'media/images/business/' . $user->client_id . '/' . $user->profile_pic;
$path = is_file($link) ? url('/') . '/' . $link : url('/') . '/media/images/business/0/default.png';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="karibu, SMS web app, SMS business support, people get connected with business, Customer support application, be the first to know" />
        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
        <meta charset="utf-8"/>
        <link href="<?= url('/') ?>/media/images/logo.png" rel="shortcut icon" type="image/x-icon" />
        <!--    <meta name="google-translate-customization" content="f08fefcb14c1447d-a1f03246bc4214cf-gecf7d7142d3c86be-11"></meta>
        -->
        <meta name="google-translate-customization" content="AIzaSyAEswiv76lGpmcCBQC7yAmyzZzvHOnve_Y"></meta>
        <!--    
            <meta name="google-site-verification" content="+nxGUDJ4QpAZ5l9Bsjdi102tLVC21AIh5d1Nl23908vVuFHs34="/>-->
           <!--<script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>--> 
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
        <script type="text/javascript">
            //----------------JavaScript variables------------------------------ 
            //       var country = {
            //            name: geoplugin_countryName(),
            //            region: geoplugin_region(),
            //            city: geoplugin_city(),
            //            code: geoplugin_countryCode(),
            //            continent: geoplugin_continentCode(),
            //            latitude: geoplugin_latitude(),
            //            longitude: geoplugin_longitude(),
            //            currency_code: geoplugin_currencyCode(),
            //            currency_symbol: geoplugin_currencySymbol()
            //        };
            var url = "<?php // $AJAX                         ?>";
            var home = "<?= HOME ?>";
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
        <script src="<?= url('/') ?>/media/js/app.v2.js"></script>
        <script src="<?= url('/') ?>/media/js/hashchange.js"></script>
        <script src="<?= url('/') ?>/media/js/custom.js?v=3"></script>
        <script src="<?= url('/') ?>/media/js/jquery.form.js"></script>
        <script src="<?= url('/') ?>/media/js/jquery.jcryption.3.0.1.js"></script>
        <link rel='stylesheet' href="media/css/sweet-alerts/sweetalert.css">
        <meta name="csrf-token" content="{{ csrf_token()}}" />
        <script src="media/js/sweet-alert/sweetalert.min.js"></script>
        <?php
        //css_media('font');
        ?>
        <!--[if lt IE 9]> 
        <script src="js/ie/html5shiv.js"></script> 
        <script src="js/ie/respond.min.js"></script>
        <script src="js/ie/excanvas.js"></script> 
        <![endif]-->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>-->
        <title>KaribuSMS</title>  
    </head>

    <body>

        <!--If you uncomment this, a page will be loaded in the middle-->

        <!--<div class="container">-->
        <section class="vbox">

            <header class="bg-light dk header navbar navbar-fixed-top-xs"> 
                <div class="navbar-header aside-md"> 
                    <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                        <i class="fa fa-bars"></i> </a>
                    <a href="<?= HOME ?>" class="navbar-brand">
                        <img src="<?= url('/') ?>/media/images/logo.png" class="m-r-sm">KaribuSMS</a>
                    <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user"> 
                        <i class="fa fa-cog"></i> </a> 
                </div> 

                <ul class="nav navbar-nav hidden-xs">
                    <!--		    <li class="dropdown"> 
                                            <a href="#" class="dropdown-toggle dker" data-toggle="dropdown"> <i class="fa fa-building-o"></i> <span class="font-bold">Summary</span> </a> 
                                            <section class="dropdown-menu aside-xl on animated fadeInLeft no-borders lt"> 
                                                <div class="wrapper lter m-t-n-xs"> 
                                                    <a href="#" class="thumb pull-left m-r"> <img src="<?= url('/') ?>/media/images/avatar.jpg" class="img-circle"> </a> <div class="clear"> <a href="#">
                                                            <span class="text-white font-bold">@Mike Mcalidek</span></a> <small class="block">Art Director</small> <a href="#" class="btn btn-xs btn-success m-t-xs">Upgrade</a> </div> </div> 
                                                <div class="row m-l-none m-r-none m-b-n-xs text-center">
                                                    <div class="col-xs-4"> <div class="padder-v"> <span class="m-b-xs h4 block text-white">245</span> <small class="text-muted">Followers</small> </div> </div>
                                                    <div class="col-xs-4 dk"> 
                                                        <div class="padder-v"> <span class="m-b-xs h4 block text-white">55</span> <small class="text-muted">Likes</small> </div> </div>
                                                    <div class="col-xs-4"> <div class="padder-v"> <span class="m-b-xs h4 block text-white">2,035</span> <small class="text-muted">Photos</small> </div> </div> </div> </section> 
                                        </li>-->

                </ul> 
                <p id="ajax_setup"></p>
                <ul class="nav navbar-nav navbar-right hidden-xs nav-user">
                    <!--
                                        <li class="hidden-xs">
                    
                                            <a href="#" class="dropdown-toggle dk" data-toggle="dropdown" id="not_no"> 
                                                <i class="fa fa-bell"></i>
                                                <span class="badge badge-sm up bg-danger" ></span>
                                            </a> 
                                            <section class="dropdown-menu aside-xl"> 
                                                <section class="panel bg-white">
                                                    <header class="panel-heading b-light bg-light">
                                                        <strong>You have <span class=""></span> notifications</strong> 
                                                    </header> 
                                                    <div id="notification_ajax_results"></div>
                                                    <footer class="panel-footer text-sm">
                                                        <a href="#" class="pull-right"><i class="fa fa-cog"></i></a>
                                                        <a href="http://support.karibusms.com" target="_blank">See all the notifications</a>
                                                    </footer> 
                                                </section> 
                                            </section> 
                                        </li> -->

                    <!--		    		    <li class="dropdown hidden-xs"> 
                                                                <a href="#" class="dropdown-toggle dker" data-toggle="dropdown"><i class="fa fa-fw fa-search"></i></a> 
                                                                <section class="dropdown-menu aside-xl animated fadeInUp"> 
                                                                    <section class="panel bg-white"> 
                                                                        <form role="search">
                                                                            <div class="form-group wrapper m-b-none"> 
                                                                                <div class="input-group">
                                                                                    <input type="text" id="searchbox" class="form-control" placeholder="Search"> 
                                                                                    <span class="input-group-btn">
                                                                                        <button type="submit" class="btn btn-info btn-icon"><i class="fa fa-search"></i></button> 
                                                                                    </span> 
                                                                                </div> 
                                                                            </div> 
                                                                        </form>
                                                                        <div id="sechdiv"></div>
                                                                    </section> 
                                                                </section>
                                                            </li> -->
                    <li class="dropdown"> 
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                            <span class="thumb-sm avatar pull-left"> 
                                <img src="<?= $path ?>">
                            </span> 
                            <?= $user->name ?>
                            <b class="caret"></b> 
                        </a> 

                        <ul class="dropdown-menu animated fadeInRight"> 
                            <span class="arrow top"></span> 
                            <li> <a href="#profile">profile</a> </li>
                            <li class="divider"></li>
                            <!--<li> <a href="http://support.karibusms.com" target="_blank">Tickets</a> </li>-->
                            <li> <a href="<?= HOME ?>help">Help</a> </li>
                            <li class="divider"></li>
                            <li> <a href="#" onclick="signout()">Sign out</a> </li> 
                        </ul>

                    </li> 
                </ul> 
            </header>




            <!--start section after banner-->

            <section> 
                <section class="hbox stretch">

                    <?php
                    /**
                     * -----------------------------------------------
                     * Navigations
                     * -----------------------------------------------
                     */
                    ?>



                    @include('layout.navigation')


                    <?php
                    /**
                     * -------------------------------------------
                     * End of navigation
                     * -------------------------------------------
                     */
                    ?>

                    <section id="content">

                        @yield('content')
                    </section> 

                    <!--		    <aside class="bg-light lter b-l aside-md hide" id="notes"> 
                                            <div class="wrapper">Notification</div> 
                                            <a href="#" onclick="$('#notes').remove()"><i class="fa fa-chevron-right"></i>close</a>
                                            <div id="ajax_load_all_notifications" style="overflow: scroll;"></div>
                                        </aside> -->

                </section>
            </section>
        </section>
        <footer id="footer" class="footer bg-white b-t b-light fixed">
            <div class="text-center padder">  
                <span><a href="<?= url('/') ?>/dev" target="_blank" class="badge">Developers Api</a></span> |
                <span><a data-toggle="ajaxModal" href="<?= url('/') ?>/dev/contact" class="m-l-sm "><i class="fa fa-comment-o icon-muted"></i> Give us Feedback</a></span>
            </div>
            <div class="text-center padder"> 
                <p> <small>KaribuSMS web application<br>&copy; <?= date('Y') ?></small> </p> 

            </div>
        </footer>
        <script>
            detect_username = function () {
                var username = '<?php // $ses_user->username                       ?>';
                if (username == '') {
                    $.get(url, {pg: 'register', section: 'detect_username'}, function (data) {
                        $('#ajaxModal').remove();
                        var $modal = $('<div class="modal" id="ajaxModal"></div>');
                        $('body').append($modal);
                        $modal.modal();
                        $modal.html(data);
                    });
                }
            };
            detect_number_validation = function () {
                var is_valid = '<?php // $ses_user->phone_number_valid                       ?>';
                if (is_valid == 0) {
                    $.get(url, {pg: 'register', section: 'detect_phone_valid', phone_number: '<?php // $ses_user->phone_number                       ?>'}, function (data) {
                        $('#ajaxModal').remove();
                        var $modal = $('<div class="modal" id="ajaxModal"></div>');
                        $('body').append($modal);
                        $modal.modal();
                        $modal.html(data);
                    });
                }
            };
            //$(document).ready(detect_username);
            //$(document).ready(detect_number_validation);

            notification = function () {

                $('#not_no').click(function () {
                    //$('#notification_ajax_results').html(LOADER);

                });
            };
            //jQuery(document).ready(notification);
            // initialise the hash change event               
            $(window).hashchange(function () {
                if (window.location.hash !== '') {
                    $('#content').html(LOADER);
                    var q = window.location.hash.substring(1);
                    /*  var title = (this.processAjaxbol) ? this.pagetitle : q.substring(0, 1).toUpperCase() + q.substring(1);*/
                    // $('#content').html(actionAjax(q,null, 'GET', null, 'html'));	
                    $.get(q, null, function (data) {
                        $('#content').html(data);
                    });
                }
            });
            $(window).hashchange();

        </script>
        <?php
        $js_array = array(
            'charts/easypiechart/jquery.easy-pie-chart',
            'charts/sparkline/jquery.sparkline.min',
            'charts/flot/jquery.flot.min',
            'charts/flot/jquery.flot.tooltip.min',
            'charts/flot/jquery.flot.resize',
//'charts/flot/jquery.flot.grow',
// 'charts/flot/demo',
// 'calendar/bootstrap_calendar',
// 'calendar/demo',
            'sortable/jquery.sortable'
        );
        foreach ($js_array as $js) {
            echo '<script src="' . url('/') . '/media/js/' . $js . '.js"></script>';
        }
        ?>


        <!-- Placed js at the end of the document so the pages load faster -->

        <!--Core js-->
        @yield('footer')

    </body>
    <!-- ClickDesk Live Chat Service for websites -->
    <script type='text/javascript'>
//	var _glc =_glc || []; _glc.push('all_ag9zfmNsaWNrZGVza2NoYXRyEgsSBXVzZXJzGICAgM7z-70LDA');
//	var glcpath = (('https:' == document.location.protocol) ? 'https://my.clickdesk.com/clickdesk-ui/browser/' : 
//	'http://my.clickdesk.com/clickdesk-ui/browser/');
//	var glcp = (('https:' == document.location.protocol) ? 'https://' : 'http://');
//	var glcspt = document.createElement('script'); glcspt.type = 'text/javascript'; 
//	glcspt.async = true; glcspt.src = glcpath + 'livechat-new.js';
//	var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(glcspt, s);
    </script>
    <!-- End of ClickDesk -->
</html>

