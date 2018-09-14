<?php

/**
 * Description of test
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
header('Content-Type: text/javascript;');
header('Access-Control-Allow-Origin: http://client');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: POST, PUT');

$object = array(
    'message' => 'testing',
    'status' => 0
);
$message='Please check these documents @(File (Tracking Software) (features).docx) and @(ruby_on_rails_tutorial.pdf) and @(Extracted Marketing manual.pdf) and @(File Tracking Software features.docx) and @(ruby_on_rails_tutorial.pdf) and @(Extracted Marketing manual.pdf) and a lot other documents too.';
$data=preg_replace('/@\(/','',$message);
echo preg_replace('/\)/', '', $data);