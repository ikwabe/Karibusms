<?php

/**
 * Description of lib
 *
 * @author Ephraim Swilla
 */
/**
 * Description of mail
 *
 * @author Ephraim Swilla
 */
class Checkout{
    //put your code here
    function __construct() {
	require_once __DIR__.'/lib/Twocheckout.php';
    }
}
new Checkout();

