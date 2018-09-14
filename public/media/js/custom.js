/* 
 Document   : alert
 Created on : 20-april-2013, 01:27:00
 Author     : Ephraim Swilla <swillae@yahoo.com>
 Description:
 Purpose of this js is to customize user interface.
 */
$.ajaxSetup({
    timeout: 20000,
    beforeSend: function () {
	$('#ajax_setup').html(LOADER);
    },
    complete: function () {
	$('#ajax_setup').html('');
    }
});

call_page = function (path, div) {
    push_url(path);
    div = $(((typeof div === "undefined") ? '#content' : div));
    var data = actionAjax(path, null, 'GET', null, 'html');
    $(div).html(data);
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
    window.history.pushState({path: pageurl}, '', '#'+pageurl);

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
	    //$('#ajax_site_search_result').html(LOADER);
	    $.get(url, {
		pg: "general",
		process: "search/search",
		searchword: searchbox
	    }, function (data) {
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
    push_url(path);
    $.ajax({
	method: method_,
	url: path,
	data: data_,
	dataType: dataType,
	cache: true,
	async: false,
	success: function (data, textStatus, XMLHttpRequest) {
	    //  div.unmask();
	    if(data=='0'){
		window.location.reload();
	    }
	    output = data;
	},
	error: function (jqXHR, errorThrown, error) {
	    // div.unmask();
	    // on_error(jqXHR, errorThrown)
	    var err = eval("(" + jqXHR.responseText + ")");
	    console.log(jqXHR);
	    console.log(errorThrown);
	    window.location.reload();
	    output = err;
	}
    });
    return output;
}
$(document).ready(site_search);

submitForm = function (form_id) {
    var output;
    $('#loader').html(LOADER);
    $('#' + form_id).bind('submit', function (e) {
	e.preventDefault(); // <-- important
	$(this).ajaxSubmit({
	    target: output
	});
	swal('success','Data inserted successfully','success');
	window.location.href='#people/add';
    });
    return output;
}