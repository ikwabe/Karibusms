<?php if (preg_match("/Android/", DEVICE)) { ?>
    <div class="fadeInLeft animated" data-ride="animated" data-animation="fadeInLeft" data-delay="600">
        <p class="h3 m-b-lg" align="center"> <i class="fa fa-android fa-3x text-info"></i> </p> 
        <p align="center"> 
            <a href="https://play.google.com/store/apps/details?id=com.karibusms.smart&hl=en" 
               target="_blank">Click to download the app</a>
        </p> 
    </div> 
<?php } ?>
<?php
/**
 *   karibu.com
 * * @author Ephraim Swilla <swillae1@gmail.com>
 */
if (!isset($_GET['isajax'])) {
    include_once 'modules/login/new.php';
} else {
    if (isset($_GET['sec'])) {
        include_once 'modules/login/section/forget_password.php';
    } else {
        ?>

        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">

            <div class="container aside-xxl"> 
                <a class="navbar-brand block text-success" href="<?= url('/').'/' ?>" >KaribuSMS</a> 
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
                        <div class="checkbox"> 
                            <label> <input type="checkbox" name="checkbox" checked="checked"> Keep me signed in </label>   </div>
                        <a href="<?= url('/').'/' ?>login&sec=forget_pw" class="pull-right m-t-xs"><small>Forgot password?</small></a> 
                        <button type="button" class="btn btn-primary" onclick="javascript: signin();">Sign in</button> 
                        <div id="login_ajax_request"></div>
                        <div class="line line-dashed"></div>
                        <p class="text-muted text-center"><small>Do not have an account?</small></p> 
                        <a href="<?= url('/').'/' ?>register" class="btn btn-default btn-block">Sign up</a>
                        <p align="center" class="text-success"><br/><a style="color: #8ec165" href="<?= url('/').'/' ?>features" >Learn about karibuSMS here</a></p>
                                <?php include_once 'modules/login/section/sample_features.php'; ?>
                    </form> 
                </section> 
            </div>
        </section> 
        <?php include_once 'modules/landing/footer.php'; ?>
        <script>
            $('body').keypress(function(e) {
                if (e.which == 13) {
                    signin();
                }
            });
            signin = function() {
                if ($('#inputPassword').val == '' || $('#phone').val() == '') {
                    $('#login_ajax_request').html('<br/><div class="alert alert-danger">\n\
                                        <button type="button" class="close" data-dismiss="alert">×</button>\n\
                                        <i class="fa fa-ban-circle"></i> Fill all fields</div>');
                    return false;
                }
                var datastring = $('#signin_form').serialize();
                $('#login_ajax_request').html(LOADER);
                $.getJSON(url, {pg: 'login', process: 'login', datastring: datastring}, function(data) {
                    if (data.error == 0) {
                        window.location.reload();
                    } else {
                        $('#login_ajax_request').html(data.error);
                    }
                }).error(function(data) {
                    console.log(data);
                });
            };
            function call_validate() {
                var phone_number = $('#phone').val();
                $('#content').html(LOADER);
                $.get(url, {pg: 'register', section: 'validate_phonenumber', phone_number: phone_number}, function(data) {
                    $('#content').html(data);
                });
            }
        </script>
        <?php
    }
}?>