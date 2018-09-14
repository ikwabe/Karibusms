<div class="text-heading">
            <h1>Let us <span class="highlight"> know </span>of your needs</h1>
            <p>Contact us<span>,let us turn your idea into a working solution </span></p>
        </div>
<div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
                    <form class="form form-register dark" id="registration" method="post" action="#"  novalidate="novalidate">
                        <div class="form-group">
                            <label for="fullname" class="col-sm-3 col-xs-12 control-label">Full name</label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" class="form-control required" name="fullname" id="fullname" placeholder="How can we call you ..?">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 col-xs-12 control-label">Email address</label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="email" class="form-control required email" name="email" id="email" placeholder="So we can get back to you soon...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-sm-3 col-xs-12 control-label">Message</label>
                            <div class="col-sm-9 col-xs-12">
                                <textarea class="form-control required" name="message" id="message" placeholder="Write your message here"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
				
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="newsletter" id="newsletter" value="1"> Submit to the monthly newsletter also
                                    </label>
				     <p id="loading"></p>
                                </div>
                            </div>
                        </div>
                        <button type="submit" onclick="return false;" onmousedown="send_info()" class="btn btn-primary btn-lg btn-block">Submit</button>
                    </form>
                   
                    <p class="agree-text">We will respond as soon as possible. For quick response, just call us with number below.<br>
                  You will always get the solution you need</p>
                </div>
            </div>
        </div>
<script type="text/javascript">
send_info=function(){
    var name=$('#fullname').val();
    var email=$('#email').val();
    var message=$('#message').val();
    var news=$("input:checked" ).val();
    if(email==''){return false;}
    $('#loading').html('loading.....');
    $.get('<?=$AJAX?>',{pg:'contacts',process:'contact',message:message,name:name,email:email,news:news},function(data){
	 $('#loading').html(data);
    });
}
</script>