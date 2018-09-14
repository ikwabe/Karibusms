
 /**
 * -----------------------------------------
 * 
 * ******* Address****************
 * INETS COMPANY LIMITED
 * P.O BOX 32258, DAR ES SALAAM
 * TANZANIA
 * 
 * 
 * *******Office Location *********
 * 11th block, Bima Road, Mikocheni B, Kinondoni, Dar es salaam
 * 
 * 
 * ********Contacts***************
 * Email: <info@inetstz.com>
 * Website: <www.inetstz.com>
 * Mobile: <+255 655 406 004>
 * Tel:    <+255 22 278 0228>
 * -----------------------------------------
 **/


 /**!
 * karibuSMS jquery API
 *
 * @version 2.1.0
 * @author Ephraim Swilla <ephraim@inetstz.com>
 *For any upgrade, support or any concern, 
 *write to us via info@karibusms.com or info@inetstz.com 
 */

karibusms = {
    /**
     * 
     * @param {array} param
     * @param {function} callback
     * @returns {JSON Object}
     */
    sendSms: function (param, callback) {
	return this.send(param,callback);
    },
    /**
     * 
     * @param {array} param
     * @param {function} callback
     * @returns {JSON Object}
     */
    getStatistics:function(param, callback){
	return this.sendSms(param,callback);
    },
    /**
     * 
     * @param {array} param
     * @param {function} callback
     * @returns {JSON Object}
     */
    send:function(param,callback){
	$.ajax({
	    cache: true,
	    url: "http://karibusms.com/api_call?js=true",
	    data:param,
	    dataType: 'jsonp',
	    success: function (data) {
		callback.call(this, data);
	    },
	    error: function (jqXHR, errorThrown) {
		 var err = eval("(" + jqXHR.responseText + ")");
		console.log(err.message);
		console.log(jqXHR);
		console.log(errorThrown);
	    }
	});
    }
}
