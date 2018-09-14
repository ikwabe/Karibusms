/**
 * @author Ephraim Swilla
 * @description This file is used to process payment page
 */
var token = $('#token').val();

var payment_options = {
    "gold":
            {"cost": 450000, "sms": 1000, "contact": "Unlimited "},
    "diamond":
            {"cost": 240000, "sms": 450, "contact": 10000},
    "nickel":
            {"cost": 120000, "sms": 210, "contact": 4000},
    "platnum":
            {"cost": 60000, "sms": 100, "contact": 1500},
//         "silver":
//                 {"cost":30000,"sms":50,"contact":800},
//         "bronze":
//                 {"cost":15000,"sms":30,"contact":300}
};

var smart_payment_options={
     "gold":
            {"cost": 100000, "sms":"Unlimited", "contact": "Unlimited "},
    "diamond":
            {"cost": 60000, "sms": "Unlimited", "contact": 3000},
    "nickel":
            {"cost": 20000, "sms": "Unlimited", "contact": 400}
};
payment = function() {
    $('#sms_number').keyup(function() {
        var number_entered = $(this).val();

        if (number_entered != parseInt(number_entered)) {
            alert('Only numbers are allowed');
            document.close();
        }
        var cost = find_cost(number_entered);
        $('#cost_per_sms').html(cost.amount);
        $('#total_cost').html(cost.total);
        $('#cost_per_dollar').html(cost.$total);
        $('#paypal_pay_button').html(paypal_button(cost.$total));
        // $.get(url, {pg: 'payment', process: 'payments', cost: cost}, function(data) {});
    });
    $('#smart_cost_plan').change(function() {
        var cost_value = $(this).val();
        var cost_plan = $('.' + cost_value).attr('id');
        var usd = 1650;
        var $cost = Math.round(cost_value / usd * 100) / 100;
        $('#paypal_pay_button').html(paypal_button($cost));
        $('#appendedInput2').val(cost_value);
        $('#cost_amount').html(smart_payment_options[cost_plan]['cost']);
        $('#tab_name').html(cost_plan);
        $('#sms_number').html(smart_payment_options[cost_plan]['sms']);
        $('#max_contact').html(smart_payment_options[cost_plan]['contact']);
    });
    
     $('#cost_plan_select2').change(function() {
        var cost_value = $(this).val();
        var cost_plan = $('.' + cost_value).attr('id');
        var usd = 1650;
        var $cost = Math.round(cost_value / usd * 100) / 100;
        $('#paypal_pay_button').html(paypal_button($cost));
        $('#appendedInput2').val(cost_value);
        $('#cost_amount').html(payment_options[cost_plan]['cost']);
        $('#tab_name').html(cost_plan);
        $('#sms_number').html(payment_options[cost_plan]['sms']);
        $('#max_contact').html(payment_options[cost_plan]['contact']);
    });
    
    $('.payment_id').click(function() {
        return false;
    });
    $('.payment_id').mousedown(function() {
        var pmt_type = $(this).attr('id');
        var t_id = $('#' + pmt_type + '_transaction_id').val();
	var per_sms=$(this).attr('data-for');
        var tp_values = $('.input-text').serialize();
        $('#ajax_payment_status').html(LOADER);
        $.get(url,
                {pg: 'payment', process: 'mobile_payment', t_id: t_id,per_sms:per_sms, pmt_type: pmt_type, tp_values: tp_values},
        function(data) {
            $('#ajax_payment_status').html(data);
        });
    });
    
};
function paypal_button(cost) {
    return '<script src="media/js/paypal.js?merchant=AMRBTLR6EK384" \n\
                        data-button="buynow"\n\
                        data-business="swillae@yahoo.com"\n\
                        data-name="SMS" \n\
                        data-no_shipping="1" \n\
                        data-return="http://www.karibusms.com/payment&sec=payment_return" \n\
                        data-cancel_return="http://www.karibusms.com/payment&sec=payment_cancel" \n\
                        data-rm="2" \n\
                        data-custom="' + token + '"\n\
                        data-notify_url="http://www.karibusms.com/modules/payment/section/paypal/ipn/ipnlistener.php" \n\
                        data-amount="' + cost + '">\n\
          </script>';
}
switch_payment_way = function() {
    $('#buy_per_sms').click(function() {
        $(this).html('Change payment plan');
        $('#not_bundle_select').toggle('fast', function() {
            $('#bundle_select').toggle('fast');
        });
    });
    $('#paypal_tab').click(function() {
        var content=$('#paypal_pay_button').html() ;

        if (content== 'Select sms you want first') {
            var cost = $('#appendedInput2').val();
            var usd = 1650;
            var $cost = Math.round(cost / usd * 100) / 100;
            $('#paypal_pay_button').html(paypal_button($cost));
        }
    });
};
function find_cost(sms) {
    var cost = {
        total: '0',
        $total: '',
        type: '',
        amount: 25,
        $amount: '0.021'
    };
    cost.total = cost.amount * sms;
    cost.$total = Math.round(cost.$amount * sms * 100) / 100; //we need 2dp in us $
    return cost;
}
$(document).ready(payment);
$(document).ready(switch_payment_way);