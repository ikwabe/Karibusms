/* 
 Document   : alert
 Created on : 20-april-2013, 01:27:00
 Author     : Ephraim Swilla <swillae@yahoo.com>
 Description:
 Purpose of this js is to customize user interface.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function () {
        $('#ajax_setup').html('loading...................');
    },
    complete: function () {
        $('#ajax_setup').html('');
    }
});


call_page = function (path, div) {

    // push_url(path);
    div = $(((typeof div === "undefined") ? '#content' : div));
    div.html(LOADER);
    var data = actionAjax(path, null, 'GET', null, 'html');
    div.html(data);
};

/*Global function to load page on the content*/
//function call_page(path) {
//    if (window.location.hash.substring(1) === path) {
//	/*$(window).hashchange(); Do not change for now */
//	window.location.reload();
//    } else {
//	window.location.hash = path;
//    }
//}

push_url = function (pageurl) {
    //to change the browser URL to 'pageurl'

    if (typeof (pageurl) === 'undefined')
        pageurl = '';
    else
        document.title = 'karibuSMS ' + pageurl;
    window.history.pushState({path: pageurl}, '', '#' + pageurl);

//    if (!$.browser.msie) {
//	if (pageurl != window.location) {
//	    window.history.pushState({path: pageurl}, '', pageurl);
//	}
//    }
    return false;
}
site_search = function () {
    $('#searchbox').keyup(function () {
        var searchbox = $(this).val();
        if (searchbox == '') {
            $('#sechdiv').hide();

        } else {
            $('#ajax_site_search_result').html(LOADER);
            $.get('search/' + searchbox,
                    {},
                    function (data) {
                        $('#sechdiv').html('');
                        $('#sechdiv').show().html(data);
                    });
        }
    }).blur(function () {
        if (searchbox == '') {
            $('#sechdiv').hide();
        }
    });
}

function actionAjax(path, data_, method_, div, dataType) {
    var output;
    div = $(((typeof div === "undefined") ? '#content' : div));
    data_ = (typeof data_ === "undefined") ? {} : data_;
    method_ = (typeof method_ === "undefined") ? "get" : method_;
    dataType = (typeof dataType === "undefined") ? "json" : dataType;
    //div.mask('<i class="fa fa-refresh fa-spin"></i> Loading...');
    //div.html(LOADER);
    // push_url(path);
    $.ajax({
        method: method_,
        url: path,
        data: data_,
        dataType: dataType,
        cache: true,
        async: false,
        success: function (data, textStatus, XMLHttpRequest) {
            // div.unmask();
            $('.ajax_loader').hide();
            if (data == '0') {
                window.location.reload();
            }
            output = data;
        },
        error: function (jqXHR, errorThrown, error) {
            $('.ajax_loader').hide();
            //div.unmask();
            // on_error(jqXHR, errorThrown)
            // var err = eval("(" + jqXHR.responseText + ")");
            console.log(jqXHR);
            console.log(errorThrown);
            output = jqXHR;
        }
    });
    return output;
}
$(document).ready(site_search);

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
/**
 * 
 * @param {String} #form_id
 * @returns {JSON}
 */
submitForm = function (form_id) {
    /**
     * ------------------------------------------------------------------------
     * This function is used in 2 pages for now
     * 1. views/people/change_photo.blade.php
     * 2. views/people/create.blade.php
     * 
     * After any change, you should test to add new person and upload profile pic
     * -------------------------------------------------------------------------
     */
    var output;
    $('#' + form_id).bind('submit', function (e) {
        e.preventDefault(); // <-- important

        var options = {
            target: output, // target element(s) to be updated with server response 
            beforeSubmit: function () {
                $('#loader').html(LOADER);
            },
            // pre-submit callback 
            dataType: 'JSON', // 'xml', 'script', or 'json' (expected server response type) 
            clearForm: true, // clear all form fields after successful submit 
            resetForm: true, // reset the form after successful submit 

            success: function (output) {
                var res = isJson(output);
                if (res === false) {
                    var obj = output;
                } else {
                    var obj = JSON.parse(output);
                }
                swal(obj.status, obj.message, obj.status);
                if ((typeof obj.page === "undefined")) {

                } else {

                    window.location.href = obj.page;
                }

                $('#loader').html('');
            },
            // post-submit callback 
            error: function (output) {
                $('#loader').html('');
                swal('warning', 'We have encounted some problems, please try again later', 'warning');
            }
            // other available options: 
            //url:       url         // override for form's 'action' attribute 
            //type:      type        // 'get' or 'post', override for form's 'method' attribute 

            // $.ajax options can be used here too, for example: 
            //timeout:   3000 
        };
        $(this).ajaxSubmit(options);
    });
    return output;
}