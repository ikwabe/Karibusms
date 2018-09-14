
<header  class="navbar light-blue lighten-1">
    <div class="container">
	<div class="navbar-header">
	    <a id="logo-container" href="<?= HOME ?>" class="brand-logo white-text">INETS</a>
	    <a type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar white"></span>
		<span class="icon-bar white"></span>
		<span class="icon-bar white"></span>
	    </a>
	    <!--			<a href="--><? //= HOME   ?><!--#layout" class="brand js-target-scroll">-->
	    <!--				<img class="brand-img-white" alt="" width="180" src="medimg/brand-white.png">-->
	    <!--				<img class="brand-img" alt="" width="130" src="img/brand.png">-->
	    <!--			</a>-->
	</div>
	<div class="collapse navbar-collapse" id="navbar-collapse">
	    <ul class="nav navbar-nav navbar-right">
		<li   <?= header_state('/') ?>><a class="waves-effect waves-light white-text" href="<?= HOME ?>">Home</a></li>
		<li <?= header_state('about') ?>><a href="<?= HOME ?>about" class="waves-effect waves-light white-text">About</a></li>
		<li <?= header_state('services') ?>><a href="<?= HOME ?>services" class="waves-effect waves-light white-text">Services</a></li>
		<li <?= header_state('clients') ?>><a href="<?= HOME ?>clients" class="waves-effect waves-light white-text">Clients</a></li>
		<li <?= header_state('projects') ?>><a href="<?= HOME ?>projects" class="waves-effect waves-light white-text">Projects</a></li>
		<!--<li <?= header_state('news') ?>><a href="<?= HOME ?>news" >News</a></li>-->
		<li <?= header_state('contact') ?>><a href="<?= HOME ?>contacts" class="waves-effect waves-light white-text">Contacts</a></li>
		<li class="featured" style="border: 1px solid white;"><a href="#" onclick="prompt_user()" class="waves-effect waves-light white-text">NEW WEBSITE</a></li>
	    </ul>
	</div>
    </div>
</header>

<script type="text/javascript">
    function prompt_user() {
	r = confirm('We are about to upgrade our website. We need much of your feedback so we may give you something that you need. Click yes to view our new website');
	if (r) {
	    window.location.href = 'new_site';
	}
    }
</script>
