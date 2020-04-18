<?php
/**
 * Description of navigation
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<aside class="bg-light lter b-r aside-md hidden-print" id="nav" style="z-index: 2000;">
    <section class="vbox"> 
        <header class="header bg-white-only lter text-center clearfix">
            <div class="btn-group"></div>
        </header>
        <section class="w-f scrollable"> 

            <div class="slimScrollDiv">

                <div class="slim-scroll"  data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333"> 
                    <!-- nav --> 
                    <nav class="nav-primary hidden-xs"> 
                        <ul class="nav"> 

                            <li> 
                                <a href="#home">
                                    <i class="fa fa-dashboard icon">
                                        <b class="bg-danger"></b>
                                    </i> <span>Home</span>
                                </a> 
                            </li>
                            <li> 
                                <a href="#layout"> 
                                    <i class="fa fa-columns icon"> 
                                        <b class="bg-warning"></b> 
                                    </i>
                                    <span class="pull-right"> 
                                        <i class="fa fa-angle-down text"></i> 
                                        <i class="fa fa-angle-up text-active"></i> 
                                    </span> <span>Mail & SMS</span>
                                </a> 
                                <ul class="nav lt"> 

                                    <li > 
                                        <a href="#sms"> <i class="fa fa-angle-right"></i> <span>SMS</span> </a>
                                    </li>
                                    <!--                                    <li > 
                                                                            <a href="#email"> <i class="fa fa-angle-right"></i> <span>Email</span> </a> 
                                                                        </li> -->
                                    <li > 
                                        <a href="#incoming_sms"> <i class="fa fa-angle-right"></i> <span>Incoming SMS</span> </a> 
                                    </li> 
                                    <?php
                                    $developer = DB::table('developer_app')->where('client_id', session('client_id'))->first();
                                    if (count($developer) > 0) {
                                        ?>
                                        <li > 
                                            <a href="#app_requests"> <i class="fa fa-angle-right"></i> <span>API SMS Request</span> </a> 
                                        </li> 
                                    <?php } ?>
                                </ul>
                            </li>

                            <li class=""> 
                                <a href="#uikit" class="active">
                                    <i class="fa fa-flask icon"> <b class="bg-success"></b> </i> 
                                    <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i> </span> <span>Contacts</span> 
                                </a> 
                                <ul class="nav lt"> 
                                    <li>
                                        <a href="#add_people"> <i class="fa fa-angle-right"></i>
                                            <span>Add</span> </a>
                                    </li>

                                    <?php
                                    /*
                                     * -----------------------------------------------------------------
                                     * This part we will load categories of people added by this person,
                                     * for example, if business has got customers, leads, etc, then we
                                     * will load here and same if organization has got choir, pastors etc
                                     * ----------------------------------------------------------------
                                     */
                                    $categories = \App\Http\Controllers\Controller::get_category();
                                    $total_people = \App\Http\Controllers\Controller::count_all_people();
                                    foreach ($categories as $category) {
                                        ?>
                                        <li> 
                                            <a href="#people/<?= encryptApp($category->category_id) ?>">
                                                <b class="badge bg-info pull-right"></b> 
                                                <i class="fa fa-angle-right"></i>
                                                <span><?= $category->name ?></span> 
                                            </a> 
                                        </li> 	
                                    <?php } ?>

                                    <li> 
                                        <a href="#people/<?= encryptApp("all") ?>">
                                            <b class="badge bg-info pull-right"><?= $total_people ?></b> 
                                            <i class="fa fa-angle-right"></i> <span>All Contacts</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
<!--                            <li> 
                                <a href="#layout"> 
                                    <i class="fa fa-money icon"> 
                                        <b class="bg-success"></b> 
                                    </i>
                                    <span class="pull-right"> 
                                        <i class="fa fa-angle-down text"></i> 
                                        <i class="fa fa-angle-up text-active"></i> 
                                    </span> <span>Payments</span>
                                </a> 
                                <ul class="nav lt"> 

                                    <li > 
                                        <a href="#add_payment"> <i class="fa fa-angle-right"></i> <span>Add Payments</span> </a>
                                    </li>
                                    <li > 
                                        <a href="#view_report"> <i class="fa fa-angle-right"></i> <span>View History</span> </a> 
                                    </li> 
                                </ul>
                            </li>-->
                             <li> 
                                <a href="#view_report">
                                    <i class="fa fa-money icon">
                                        <b class="bg-success"></b>
                                    </i> <span>Payments</span>
                                </a> 
                            </li>
                            <li> 
                                <a href="#client_setting">
                                    <i class="fa fa-gear icon">
                                        <b class="bg-danger"></b>
                                    </i> <span>Settings</span>
                                </a> 
                            </li>
                            <?php
                            /**
                             * -----------------------------------------------------------------
                             * Load admin panel for special accounts
                             * ----------------------------------------------------------------
                             */
                            $admin = array('1');
                            if (in_array(session('client_id'), $admin)) {
                                ?>
                                <li class=""> 
                                    <a href="#table" class=""> 
                                        <i class="fa fa-angle-down text"></i>
                                        <i class="fa fa-angle-up text-active"></i> 
                                        <span>Admin Panel</span> 
                                    </a>
                                    <ul class="nav bg" style="display: none;"> 
                                        <li> <a href="#payment_report" ><i class="fa fa-angle-right"></i> 
                                                <span>Payments</span> </a> 
                                        </li>
                                        <li> 
                                            <a href="#user/statistics"> 
                                                <i class="fa fa-angle-right"></i>
                                                <span>Users</span> </a> </li> 
                                        <li> 
                                            <a href="#user/notification"> 
                                                <i class="fa fa-angle-right"></i>
                                                <span>Send SMS Notification</span> </a> </li> 
                                        <li> 
                                            <a href="#user/email"> 
                                                <i class="fa fa-angle-right"></i>
                                                <span>Send Email Notification</span> </a> </li>
                                        <li> 
                                            <a href="#user/logs"> 
                                                <i class="fa fa-angle-right"></i>
                                                <span>Log Report</span> </a> </li>
                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                            <li> 
                                <a href="#" onclick="signout()" onmousedown="signOut()" >
                                    <i class="fa fa-power-off"><b class="bg-danger"></b></i> 
                                    <span>Sign out</span> 
                                </a> 
                            </li>

                        </ul> 
                    </nav> <!-- / nav --> 
                </div>

            </div>
        </section> 
    </section>
</aside>
<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
<meta name="google-signin-client_id" content="688185075515-8n990kovtjtjvfcfbdt6m5320kh9m5un.apps.googleusercontent.com">
<script>
                                    function signOut() {
                                        var auth2 = gapi.auth2.getAuthInstance();
                                        auth2.signOut().then(function () {
                                            console.log('User signed out.');
                                        });
                                    }

                                    function onLoad() {
                                        gapi.load('auth2', function () {
                                            gapi.auth2.init();
                                        });
                                    }
</script>
<script type="text/javascript">
    signout = function () {
        $.get('logout', {}, function (data) {
            if (data == 1) {
                window.location.reload();
            }
        });
    }
</script>    