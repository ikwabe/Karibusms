<?php


if(!filter_var($_REQUEST['email'],FILTER_VALIDATE_EMAIL)){
     die('<div class="alert alert-danger">This email ' . $_REQUEST['email'] . '  is not valid</div>');
}else {
 
    $message = '<br/> Message from: '.$_REQUEST['name'].' with content:<br/>'.$_REQUEST['message'];
    $message.='<br/><br/>User subscribe to news latter ?'.$_REQUEST['news'];
    $subject = "Contact from Inets Company website";
    $headers = 'From: Inets Company Limited <info@inetstz.com>' . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: text/html; charset=iso-8859-1";

    $send = mail('info@inetstz.com', $subject, $message, $headers);
    
     mail($_REQUEST['email'], "Inets Company Limited", "Hi ".$_REQUEST['name'].'<br/> Thanks for contacting us. Your information was received successful. We will get back to you soon.', $headers);
     
     if ($send) {
        echo '<div class="alert alert-success">Message sent. Thank you</div>';
    } else {
        echo '<div class="alert alert-danger">We encounter an error, try later</div>';
    }
}
exit();
?>

