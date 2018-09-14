<div class="modal-dialog" style="z-index: 2000;" >
    <div class="modal-content">
        <div class="modal-header"> 
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
            <h4 class="modal-title">Send us a tip</h4>
        </div> 
        <div class="modal-body"> 
            <ul>
              
                <div class="col-lg-10"> <input type="email" id="email" class="form-control" placeholder="Email"> <span class="help-block m-b-none"><br/></span> </div>
                <textarea class="form-control parsley-validated" id="tip" style="width: 95%;height: 8em;resize: none;border-radius: 0.4em;" placeholder="Write your tip"></textarea>
            </ul>

        </div>
        <div class="modal-footer"> 
            <script>
                tip = function() {
                    var content = $('#tip').val();
                    var email = $('#email').val();
                    $.getJSON('contact_us_submit',{ email: email, comments: content}, function(data) {
                        $('.modal-body').html(data.message).addClass('alert alert-'+data.status);
                    });
                };

            </script>
            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            <a onclick="javascript:tip();" href="#" class="btn btn-primary">Send</a> 
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->