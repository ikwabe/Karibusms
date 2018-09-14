<?php

/**
 * Description of faq
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 * 
 * ENGLISH PAGE
 */
return [

    /*
      |--------------------------------------------------------------------------
      | Pagination Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines are used by the paginator library to build
      | the simple pagination links. You are free to change them to anything
      | you want to customize your views to better match your application.
      |
     */
    array(
	'question' => 'Why my android phone do not send SMS when I use karibuSMS from website ?',
	'answer' => 'Make sure in your android phone, you have SMS plan from your network provider.'
    ),
   
     array(
	'question' => 'I have SMS plan in my android phone, but yet SMS are not sent from my phone when I use karibuSMS from website ?',
	'answer' => 'Please open first karibuSMS android application, logout and login again and send SMS again from website'
    ),
      array(
	'question' => 'I use android phone which use double line. One line have SMS plan and one line do not have SMS plan, but yet SMS are not sent from my phone when I use karibuSMS from website ?',
	'answer' => 'Please make sure in your android phone, you have selected one sim card to be a default line to send SMS. If your phone do not have an option to select one line to be a default for sending SMS, then make sure by the time you start to send SMS, you have your android phone close and by the time it prompt you which line to send SMS, then select the one with SMS plan and make it default'
    ),
];
