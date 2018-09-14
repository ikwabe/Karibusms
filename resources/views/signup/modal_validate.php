<?php ?>
<div class="modal in" id="ajaxModal" aria-hidden="false" style="display: block;">
    <div class="modal-over"> 
        <a class="navbar-brand block" href="<?= HOME ?>">Karibu..!</a>
        <div class="modal-center animated fadeInUp text-center" style="width:200px;margin:-80px 0 0 -100px;">
            <div class="thumb-md"><img src="media/images/avatar_default.jpg" class="img-circle b-a b-light b-3x"></div> 
            <p class="text-white h4 m-t m-b"><?= $data['business_name'] ?></p>
            <small class="text-white h4 m-t m-b">Enter verification codes you receive in your phone. If not yet received,  wait for at least 10 seconds</small>>
            <div class="input-group" id="ajax_load_wait"> 
                <input type="text" id="verification_codes" class="form-control text-sm" placeholder="Enter verification codes"> 
                <span class="input-group-btn">
                    <button class="btn btn-success" type="button" onclick="javascript: validate_number();"id="ver_codes" data-dismiss="modal">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </span> 
                <p id="ajax_modal_results" align="center"></p>
            </div> 
            <p class="text-white h4 m-t m-b"><a href="#" style="color: #ffffff;" onclick="skip_verification();">Skip this</a></p>
        </div>
    </div>
</div>
<script>
    skip_verification = function() {
        $('#ajax_load_wait').html(LOADER);
        $.get(url, {pg: 'register', process: 'verification_code', skip: true,business_id:"<?=$business_id?>"}, function(data) {
            window.location.reload();
        });
    };
    validate_number = function() {

        var ver_codes = $('#verification_codes').val();
        $.get(url, {pg: 'register', process: 'verification_code', ver_codes: ver_codes}, function(data) {
            if (data == 1) {
                window.location.reload();
            } else {
                //we get an error
                $('#ajax_modal_results').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><i class="fa fa-ban-circle"></i>  <a href="#" class="alert-link">Codes are not valid</a>.</div>');
            }
        });
    };
</script>