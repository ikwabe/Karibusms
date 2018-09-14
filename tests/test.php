<?php

/**
 *  
 * * @author Ephraim Swilla <swillae1@gmail.com>
 */
$headers = 'From: BRELA | ORS <brelanoreply@inetstz.com>' . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/html; charset=iso-8859-1";

$email = $_POST['email'];
//$subject = "Hello OG";
//$message = "Chukua hiyo";
$subject = $_POST['subject'];
$message = $_POST['message'];
echo mail('owdeng@gmail.com', 'HELLO', 'Hi testing', $headers);



?>