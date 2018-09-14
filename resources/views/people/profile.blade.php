<?php
/**
 * Description of profile
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
$link = 'media/images/business/' . $client->client_id . '/' . $client->profile_pic;
$path = file_exists($link) ? $link : 'media/images/business/0/default.png';
?>

<section class="vbox">
    <header class="header bg-white b-b b-light"> <p><?= $client->name ?>'s profile</p> </header> 
    <section class="scrollable"> 
	<section class="hbox stretch"> 
	    <aside class="aside-lg bg-light lter b-r"> 
		<section class="vbox">
		    <section class="scrollable">
			<div class="wrapper"> 
			    <div class="clearfix m-b"> <a href="#" class="pull-left thumb m-r">
				    <img src="<?= $path ?>" class="img-circle"> </a> 
				<div class="clear"> 
				    <div class="h3 m-t-xs m-b-xs"><?= $client->name ?></div>
				    <small class="text-muted"><i class="fa fa-map-marker"></i><?= $client->location ?></small> 
				</div>
			    </div> 
<!--			    <div class="panel wrapper panel-success"> <div class="row"> <div class="col-xs-4"> <a href="#"> <span class="m-b-xs h4 block">245</span> <small class="text-muted">Followers</small> </a> </div> <div class="col-xs-4"> <a href="#"> <span class="m-b-xs h4 block">55</span> <small class="text-muted">Following</small> </a> </div> <div class="col-xs-4"> <a href="#"> <span class="m-b-xs h4 block">2,035</span> <small class="text-muted">Tweets</small> </a> </div> </div> </div> -->
			    <div class="btn-group btn-group-justified m-b"> 
				<a class="btn btn-primary btn-rounded" data-toggle="button"> 
<!--				    <span class="text"> <i class="fa fa-eye"></i> Follow </span> 
				    <span class="text-active"> 
					<i class="fa fa-eye-slash"></i> Following </span>-->
				</a> 
				<!--				<a class="btn btn-dark btn-rounded" data-loading-text="Connecting"> 
								    <i class="fa fa-comment-o"></i> Chat </a> -->

			    </div> <div> <small class="text-uc text-xs text-muted">Slogan</small>
				<p><?=$client->slogan?></p> 
				<small class="text-uc text-xs text-muted">info</small> 
				<p><?= $client->about ?></p> 
				<div class="line"></div> 
				<small class="text-uc text-xs text-muted">connection</small> 
				<p class="m-t-sm"> 
				    <?php
				    if ($client->twitter != '') {
					?>
    				    <a href="https://twitter.com/<?= $client->twitter ?>" target="_blank" class="btn btn-rounded btn-twitter btn-icon">
    					<i class="fa fa-twitter"></i>
    				    </a>
				    <?php } if ($client->facebook != '') {
					?>
    				    <a href="https://facebook.com/<?= $client->facebook ?>" target="_blank" class="btn btn-rounded btn-facebook btn-icon">
    					<i class="fa fa-facebook"></i>
    				    </a> 
				    <?php }  if ($client->googleplus != '') { ?>
    				    <a href="https://plus.google.com/u/0/<?= $client->googleplus ?>" target="_blank" class="btn btn-rounded btn-gplus btn-icon">
    					<i class="fa fa-google-plus"></i>
    				    </a> 
					<?php
				    } 
				    if($client->twitter == '' && $client->facebook == '' && $client->googleplus == '') {
					echo 'User do not have any social page';
				    }
				    ?>
				</p> 
			    </div> 
			</div> 
		    </section> 
		</section> </aside> <aside class="bg-white">
		<section class="vbox"> 
		    <header class="header bg-light bg-gradient">
			<ul class="nav nav-tabs nav-white">
			    <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li> 
			</ul> 
		    </header> 
		    <section class="scrollable">
			<div class="tab-content"> <div class="tab-pane active" id="activity">
				<ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border"> 
				    <?php
				    
				    foreach ($messages as $message) {
					?>
    				    <li class="list-group-item"> 
    					<a href="#" class="thumb-sm pull-left m-r-sm"> 
    					    <img src="<?= $path ?>" class="img-circle"> </a> 
    					<a href="#" class="clear"> 
    					    <small class="pull-right"><?= make_time_ago($message->time) ?></small>
    					    <strong class="block"><?= $client->name ?></strong> 
    					    <small><?= $message->content ?></small> </a>
    				    </li>
				   <?php }  ?>

				</ul> </div> 

			</div>
		    </section>

		</section> </aside> <aside class="col-lg-4 b-l"> 
		<section class="vbox">
		    <section class="scrollable"> 
			<div class="wrapper"> 
<!--				<section class="panel panel-default"> <form> <textarea class="form-control no-border" rows="3" placeholder="What are you doing..."></textarea> 
			    </form> <footer class="panel-footer bg-light lter"> <button class="btn btn-info pull-right btn-sm">POST</button> <ul class="nav nav-pills nav-sm"> <li><a href="#"><i class="fa fa-camera text-muted"></i></a></li> <li><a href="#"><i class="fa fa-video-camera text-muted"></i></a></li> </ul> </footer> 
			    </section>-->
			    <section class="panel panel-default">
				<?php
				/**
				 * 
				 * ---------------------------------------------
				 * This part will load twitter feeds
				 * ---------------------------------------------
				 * 
				 */
				?>
				<?php if ($client->twitter != '') { ?>
    				<h4 class="font-thin padder">Latest Tweets</h4> 
				<?php } ?>
				<ul class="list-group"> 

				    <div id="twitter_feeds"></div>


				    <!--				    <li class="list-group-item"> 
									    <p>Wellcome <a href="#" class="text-info">@Drew Wllon</a> and play this web application template, have fun1 </p> <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small> </li> 
									<li class="list-group-item"> <p>Morbi nec <a href="#" class="text-info">@Jonathan George</a> nunc condimentum ipsum dolor sit amet, consectetur</p> <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 hour ago</small> </li> 
									<li class="list-group-item"> <p><a href="#" class="text-info">@Josh Long</a> Vestibulum ullamcorper sodales nisi nec adipiscing elit. </p> <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 hours ago</small> </li>-->
				</ul> 
			    </section>
<!--			    <section class="panel clearfix bg-info lter"> 
				<div class="panel-body"> <a href="#" class="thumb pull-left m-r"> <img src="images/avatar.jpg" class="img-circle"> </a>
				    <div class="clear"> <a href="#" class="text-info">@Mike Mcalidek <i class="fa fa-twitter"></i></a> <small class="block text-muted">2,415 followers / 225 tweets</small>
					<a href="#" class="btn btn-xs btn-success m-t-xs">Follow</a> 
				    </div> </div> 
			    </section> -->
			</div>
		    </section>
		</section>
	    </aside>
	</section>
    </section>
</section>