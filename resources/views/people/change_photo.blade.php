<?php
/**
 * Description of photo_change
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>
<section class="vbox">
    <section> 
        <section class="hbox stretch">         
            <section id="content"> 
                <section class="vbox"> 
                    <section class="scrollable padder"> 
                        <section class="panel panel-default"> 
                            <header class="panel-heading bg-light"> About </header> 
                            <div class="panel-body"> <div class="tab-content">

                                    <div class="col-sm-8">
                                        <section class="panel panel-default"> 
                                            <header class="panel-heading font-bold">Profile picture </header>
                                            <div class="panel-body"> 
						<div id="loader"></div>
                                                <div class="col-lg-4" id="upload_output"> 
                                                    <a href="#" class="pull-left thumb m-r"> 
							<?php
							$default = 'media/images/avatar_default.jpg';
							$live = 'media/images/business/' . $user_info->client_id . '/' . $user_info->profile_pic;
							?>
                                                        <img src="<?=  url('/')?>/<?= is_file($live) ? $live : $default ?>" class="img-circle" id="img_tag">
                                                    </a>
                                                </div>

                                                <form class="form-inline" id="change_photo" method="post"
						      action="<?= url('/change_photo') ?>" role="form"> 
                                                    <div class="form-group"> 
                                                        <label class="sr-only" for="profile_pic">Profile picture</label>
                                                        <input type="file" name="file" style="max-width: 18em;" class="form-control" placeholder="upload profile">
                                                    </div>
                                                    <button type="submit" class="btn btn-info" id="upload_pic">Upload</button> 
                                                </form> 
                                            </div>
                                        </section> 

                                    </div>

                                </div>
                            </div>
                        </section>
                    </section>
                </section> 
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
            </section>

            <aside class="bg-light lter b-l aside-md hide" id="notes"> <div class="wrapper">Notification</div>
            </aside> </section> </section>
</section>
<script>
    basic_edit = function () {
	$('#upload_pic').click(function () {
	   submitForm('change_photo');
	  // window.location.reload();
	});
    };
    $(document).ready(basic_edit);

</script>

