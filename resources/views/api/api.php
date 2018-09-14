<?php
if(!isset($_SESSION['id'])){
require_once 'modules/landing/banner/feature_banner.php';
}else{
?>  
<header id="header" class="navbar navbar-fixed-top bg-white box-shadow b-b b-light" data-spy="affix" data-offset-top="1"> <div class="container">
	<div class="navbar-header"> 
	    <a href="<?=HOME?>" class="navbar-brand">
		<img src="media/images/logo.png" class="m-r-sm"><span class="text-muted">KaribuSMS</span></a> 
	</div> 
	<div class="collapse navbar-collapse"> 
	    <ul class="nav navbar-nav navbar-right">
		<li class="dropdown"> 
		    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                        <span class="thumb-sm avatar pull-left"> <img src="<?= isset($link) ? $link:'' ?>">
			</span> 
			<?= isset($business) ? $business->name:''?>
			<b class="caret"></b> 
		    </a> 
		    <?php if (isset($ses_user)) { ?>
    		    <ul class="dropdown-menu animated fadeInRight"> 
    			<span class="arrow top"></span> 
    			<li> <a href="<?= HOME ?>">profile</a> </li>
    			<li> <a href="<?= HOME ?>help">Help</a> </li>
    			<li class="divider"></li>
    			<li> <a href="<?= HOME ?>logout">Sign out</a> </li> 
    		    </ul>
		    <?php } ?>
		</li> 
	    </ul>
	</div>
    </div> 
</header> <!-- / header -->
<?php }?>
<section class="hbox">
    <section id="content"> 
	<section class="hbox stretch">
	    <aside class="aside-md bg-white b-r" id="subNav"> 
		<div style="min-height: 20em;"></div>
		<div class="wrapper b-b header">SMS API</div> 
		<ul class="nav"> 
		    <li class="b-b b-light">
			<a href="#" onclick="get_send({pg: 'api', part: 'intro'}, 'content_loading');">
			    <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>Introduction</a></li>
		    <?php
		    $business_id = isset($ses_user) ? $ses_user->id : '';
		    if (isset($ses_user)) {
			$developer_info = developer_app::find_where(array('client_id' => $ses_user->id));
			$developer = !empty($developer_info) ? $developer_info : array();
		    } else {
			$developer = array();
		    }
		    if (!empty($developer)) {

			foreach ($developer_info as $app) {
			    ?>
                            <br/>
			    <li class="b-b b-primary">
                               
				<a href="#" class="btn-info" onclick="get_send({pg: 'api', section: 'app', name: '<?= $app->name ?>'}, 'content_loading')">
				    <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>
				    <?= ucfirst($app->name) ?>
				</a>
			    </li>
                            <span></span>
			<?php } ?>
    		    <br/><a data-toggle="ajaxModal"
    			    href="<?= $AJAX ?>&pg=api&part=create_app"
    			    class="btn btn-s-md btn-info" >Create new app</a>
			    <?php } else { ?>
    		    <li class="b-b b-light">
    			<a data-toggle="ajaxModal" <?php if (isset($ses_user)) { ?>
				   href="<?= $AJAX ?>&pg=api&part=create_app"
			       <?php } else { ?> 
				   href="<?= $AJAX ?>&pg=login&file=login&type=silver" <?php } ?>
    			   class="btn btn-s-md btn-info" >Create your app</a>
    		    </li>
		    <?php } ?>
		</ul> 
	    </aside>
	    <aside>
		<section class="vbox"> 
		    <header class="header bg-white b-b clearfix"> </header> 
		    <section class="scrollable wrapper w-f"> 


			<section class="panel panel-default">
			    <section class="panel bg-light"> 
				<div class="carousel slide carousel-fade panel-body" id="c-fade">
				    <ol class="carousel-indicators out">
					<li data-target="#c-fade" data-slide-to="0" class=""></li>
					<li data-target="#c-fade" data-slide-to="1" class="active"></li>
					<li data-target="#c-fade" data-slide-to="2" class=""></li>
				    </ol> 
				    <div class="carousel-inner">
					<div class="item centered"> 
					    <div class="col-sm-4  animated" data-delay="600"> <p class="h3 m-b-lg"> <i class="fa fa-exchange fa-3x text-info"></i> </p> <div class=""> <h4 class="m-t-none">SMS switching</h4> <p class="text-muted m-t-lg">You can switch to use either karibuSMS (SMS sent from your mobile phone) or karibuSMSpro (SMS sent from our platform).</p> </div> </div>
					</div> 
					<div class="item active"> 
					    <div class="col-sm-4  animated" data-delay="300"> <p class="h3 m-b-lg"> <i class="fa fa-gears fa-3x text-info"></i> </p> <div class=""> <h4 class="m-t-none">karibuSMS developer API</h4> <p class="text-muted m-t-lg">Allows  SMS notification integration in your application or platforms and switch with any messaging type you as per your need.</p> </div> </div> 
					</div>
					<div class="item"> 
					    <div class="col-sm-4  animated" data-ride="animated" data-animation="fadeInLeft" data-delay="900"> <p class="h3 m-b-lg"> <i class="fa fa-share fa-3x text-info"></i> </p> <div class=""> <h4 class="m-t-none">Many APPs for different integration</h4> <p class="text-muted m-t-lg">You can create more application and integrate it in many application differently.</p> </div> </div>
					</div> 
				    </div>
				    <a class="left carousel-control" href="#c-fade" data-slide="prev"> <i class="fa fa-angle-left"></i> </a> 
				    <a class="right carousel-control" href="#c-fade" data-slide="next"> <i class="fa fa-angle-right"></i> </a> 
				</div>
			    </section>

			</section> 
		    </section>
		    <div class="bg-white col-lg-8">
			<div id="content_loading">
			    <?php include_once 'modules/api/part/intro.php'; ?>
			</div>
		    </div>
		    <div class="col-lg-4 bg-light">
			<header><h4>Download code samples</h4></header>
			<section class="panel panel-default"> 
			    <header class="panel-heading bg-light">
				<ul class="nav nav-tabs nav-justified"> 
				    <li class="active"><a href="#home" data-toggle="tab">PHP</a></li>
				    <li><a href="#profile" data-toggle="tab">JavaScript/jQuery</a></li>
				    <li><a href="#java" data-toggle="tab">JAVA</a></li> 
				</ul> 
			    </header> 
			    <div class="panel-body"> 
				<div class="tab-content"> 
				    <div class="tab-pane active" id="home">
					<div class="four columns">
					    <div class="spacer"></div>
					    <h4 class="title">
						karibuSMS API PHP codes 
					    </h4>
					    <h6 class="subheader">v1.0.0</h6>
					    <p class="text-left">
						Download PHP codes with example to easily get started.
					    </p>

					    <a href="karibusms.zip" class="btn btn-s-md btn-dark btn-rounded">Download &nbsp; <i class="fa fa-download"></i></a>


					</div></div> 
				    <div class="tab-pane" id="profile">
					<div class="four columns">
					    <div class="spacer"></div>
					    <h4 class="title">
						karibuSMS jQuery API
					    </h4>
					    <h6 class="subheader">v1.0.0</h6>
					    <p class="text-left">
						Download jQuery codes with example to easily get started.
					    </p>

                                            <a href="karibusms_jquery.zip" class="btn btn-s-md btn-default btn-rounded">Download &nbsp; <i class="fa fa-download"></i></a>


					</div>
				    </div> 
				      <div class="tab-pane" id="java">
					<div class="four columns">
					    <div class="spacer"></div>
					    <h4 class="title">
						karibuSMS JAVA API
					    </h4>
					    <h6 class="subheader">v1.0.0</h6>
					    <p class="text-left">
						Download JAVA codes with example to easily get started.
					    </p>

                                            <a href="karibusms_java.zip" class="btn btn-s-md btn-default btn-rounded">Download &nbsp; <i class="fa fa-download"></i></a>


					</div>
				    </div> 
				</div> 
			    </div>
			</section>

		    </div>
		    <footer class="footer bg-white b-t">
			<div class="row text-center-xs"> 
			    <div class="col-md-6 hidden-sm"></div>
			</div>
		    </footer> 
		</section> 
	    </aside>
	</section> 
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section> 
</section> 