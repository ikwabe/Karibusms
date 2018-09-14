<?php

/*
  |--------------------------------------------------------------------------
  | Application Custom Helpers
  |--------------------------------------------------------------------------
  |
  | This file store all custom helpers (functions) that are used in the
  | application. It is important to store all your custom functions here and
  | access it in either controller, model or view.
  |
 */
define('ECRYPTION_KEY', "123kdnlsndl");

function assets() {
    return url('/');
}

/**
 * 
 * @param type $phone_number
 * @return array($country_name, $valid_number) or not array if wrong number
 */
function validate_phone_number($number) {
    $phone_number=preg_replace("/[^0-9]/", '', $number);;
    if (strlen(preg_replace('#[^0-9]#i', '', $phone_number)) < 7 || strlen(preg_replace('#[^0-9]#i', '', $phone_number)) > 14) {
	return FALSE;
    } else {

	$y = substr($phone_number, -9);
	$z = str_ireplace($y, '', $phone_number);
	$p = str_ireplace('+', '', $z);

	$x = array(
	    93 => " Afghanistan",
	    355 => " Albania", 213 => " Algeria",
	    1 => " American Samoa",
	    376 => "Andorra ",
	    244 => " Angola",
	    1 => " Anguilla",
	    1 => " Antigua and Barbuda",
	    54 => " Argentine Republic",
	    374 => " Armenia",
	    297 => " Aruba",
	    247 => " Ascension",
	    61 => " Australia",
	    672 => " Australian External Territories",
	    43 => " Austria ", 994 => " Azerbaijani Republic", 1 => " Bahamas ", 973 => " Bahrain", 880 => " Bangladesh ", 1 => " Barbados ", 375 => " Belarus ", 32 => " Belgium ", 501 => " Belize", 229 => " Benin ", 1 => " Bermuda ", 975 => " Bhutan", 591 => " Bolivia", 387 => " Bosnia and Herzegovina ", 267 => " Botswana", 55 => " Brazil (Federative Republic of)", 1 => " British Virgin Islands", 673 => " Brunei Darussalam ", 359 => " Bulgaria (Republic of)", 226 => " Burkina Faso", 257 => " Burundi (Republic of)", 855 => " Cambodia (Kingdom of)", 237 => " Cameroon (Republic of)", 1 => " Canada", 238 => " Cape Verde (Republic of)", 1 => " Cayman Islands ", 236 => " Central African Republic ", 235 => " Chad (Republic of)", 56 => " Chile ", 86 => " China ( Republic of)", 57 => " Colombia (Republic of)", 269 => " Comoros (Union of the)", 242 => " Congo (Republic of the)", 682 => " Cook Islands", 506 => " Costa Rica", 225 => " Côte d \"Ivoire (Republic of)", 385 => " Croatia (Republic of)", 53 => " Cuba", 357 => " Cyprus (Republic of)", 420 => " Czech Republic ", 850 => " Democratic People\"s Republic of Korea ", 243 => " Democratic Republic of the Congo", 670 => " Democratic Republic of Timor-Leste", 45 => " Denmark", 246 => " Diego Garcia ", 253 => " Djibouti (Republic of) ", 1 => " Dominica (Commonwealth of)", 1 => " Dominican Republic", 593 => " Ecuador", 20 => " Egypt (Arab Republic of)", 503 => " El Salvador (Republic of)", 240 => " Equatorial Guinea (Republic of)", 291 => " Eritrea", 372 => " Estonia (Republic of)", 251 => " Ethiopia (Federal Democratic Republic of) ", 500 => " Falkland Islands (Malvinas) ", 298 => " Faroe Islands", 679 => " Fiji (Republic of)", 358 => " Finland ", 33 => " France", 262 => " French Departments and Territories in the Indian Ocean ", 594 => " French Guiana (French Department of)", 689 => " French Polynesia (Territoire français \"outre-mer)", 241 => " Gabonese Republic", 220 => " Gambia (Republic of the)", 995 => " Georgia", 49 => " Germany (Federal Republic of)", 233 => " Ghana", 350 => " Gibraltar", 881 => " Global Mobile Satellite System (GMSS) shared code", 30 => " Greece ", 299 => " Greenland (Denmark)", 1 => " Grenada", 388 => " Group of countries shared code", 590 => " Guadeloupe (French Department of)", 1 => " Guam ", 502 => " Guatemala (Republic of)", 224 => " Guinea (Republic of)", 245 => " Guinea-Bissau (Republic of)", 592 => " Guyana", 509 => " Haiti (Republic of)", 504 => " Honduras (Republic of)", 852 => " Hong Kong China", 36 => " Hungary (Republic of)", 354 => " Iceland", 91 => " India (Republic of)", 62 => " Indonesia (Republic of)", 870 => " Inmarsat SNAC ", 98 => " Iran (Islamic Republic of)", 964 => " Iraq (Republic of)", 353 => " Ireland", 972 => " Israel (State of)", 39 => " Italy", 1 => " Jamaica", 81 => " Japan", 962 => " Jordan (Hashemite Kingdom of)", 7 => " Kazakhstan (Republic of)", 254 => " Kenya (Republic of)", 686 => " Kiribati (Republic of)", 82 => " Korea (Republic of)", 965 => " Kuwait (State of)", 996 => " Kyrgyz Republic ", 856 => " Lao People\"s Democratic Republic", 371 => " Latvia (Republic of)", 961 => " Lebanon ", 266 => " Lesotho (Kingdom of)", 231 => " Liberia (Republic of)", 218 => " Libya (Socialist People\"s Libyan Arab Jamahiriya)", 423 => " Liechtenstein (Principality of)", 370 => " Lithuania (Republic of) ", 352 => " Luxembourg", 853 => " Macao China", 261 => " Madagascar (Republic of)", 265 => " Malawi", 60 => " Malaysia", 960 => " Maldives (Republic of)", 223 => " Mali (Republic of)", 356 => " Malta", 692 => " Marshall Islands (Republic of the)", 596 => " Martinique (French Department of)", 222 => " Mauritania (Islamic Republic of)", 230 => " Mauritius (Republic of)", 269 => " Mayotte", 52 => " Mexico", 691 => " Micronesia (Federated States of)", 373 => " Moldova (Republic of) ", 377 => " Monaco (Principality of)", 976 => " Mongolia ", 382 => " Montenegro (Republic of)", 1 => " Montserrat", 212 => " Morocco (Kingdom of)", 258 => " Mozambique (Republic of) ", 95 => " Myanmar (Union of)", 264 => " Namibia (Republic of)", 674 => " Nauru (Republic of)", 977 => " Nepal (Federal Democratic Republic of)", 31 => " Netherlands (Kingdom of the)", 599 => " Netherlands Antilles", 687 => " New Caledonia (Territoire français d\"outre-mer)", 64 => " New Zealand", 505 => " Nicaragua", 227 => "Niger (Republic of the)", 234 => " Nigeria (Federal Republic of)", 683 => " Niue ", 1 => " Northern Mariana Islands (Commonwealth of the)", 47 => " Norway", 968 => " Oman (Sultanate of)", 92 => " Pakistan (Islamic Republic of)", 680 => " Palau (Republic of)", 507 => " Panama (Republic of)", 675 => " Papua New Guinea", 595 => " Paraguay (Republic of)", 51 => "Peru", 63 => "Philippines (Republic of the)", 48 => " Poland (Republic of)", 351 => " Portugal", 1 => " Puerto Rico", 974 => " Qatar (State of)", 40 => " Romania ", 7 => " Russian Federation", 250 => " Rwanda (Republic of)", 290 => " Saint Helena", 1 => " Saint Kitts and Nevis", 1 => " Saint Lucia", 508 => " Saint Pierre and Miquelon (Collectivité territoriale de la République française)", 1 => " Saint Vincent and the Grenadines", 685 => " Samoa (Independent State of)", 378 => " San Marino (Republic of) ", 239 => " Sao Tome and Principe (Democratic Republic of)", 966 => " Saudi Arabia (Kingdom of)", 221 => " Senegal (Republic of)", 381 => " Serbia (Republic of)", 248 => " Seychelles (Republic of)", 232 => " Sierra Leone", 65 => " Singapore (Republic of)", 421 => " Slovak Republic", 386 => " Slovenia (Republic of)", 677 => " Solomon Islands", 252 => " Somali Democratic Republic", 27 => " South Africa (Republic of)", 34 => " Spain", 94 => " Sri Lanka (Democratic Socialist Republic of)", 249 => " Sudan (Republic of the)", 597 => " Suriname (Republic of)", 268 => " Swaziland (Kingdom of)", 46 => " Sweden", 41 => " Switzerland (Confederation of)", 963 => " Syrian Arab Republic", 886 => " Taiwan China", 992 => " Tajikistan (Republic of)", 255 => " Tanzania (United Republic of)", 66 => " Thailand", 389 => " The Former Yugoslav Republic of Macedonia", 228 => " Togolese Republic", 690 => " Tokelau", 676 => " Tonga (Kingdom of)", 1 => " Trinidad and Tobago", 290 => " Tristan da Cunha", 216 => " Tunisia", 90 => " Turkey", 993 => " Turkmenistan", 1 => " Turks and Caicos Islands", 688 => " Tuvalu", 256 => " Uganda (Republic of)", 380 => " Ukraine", 971 => " United Arab Emirates", 44 => " United Kingdom of Great Britain and Northern Ireland ", 1 => " United States of America", 1 => " United States Virgin Islands", 598 => " Uruguay (Eastern Republic of)", 998 => " Uzbekistan (Republic of)", 678 => " Vanuatu (Republic of)", 379 => " Vatican City State", 39 => " Vatican City State", 58 => " Venezuela (Bolivarian Republic of)", 84 => " Viet Nam (Socialist Republic of)", 681 => " Wallis and Futuna (Territoire français d\"outre-mer)", 967 => " Yemen (Republic of)", 260 => "Zambia (Republic of)", 263 => " Zimbabwe");


	foreach ($x as $key => $value) {
	    if ($p == $key) {
		$country_name = $value;
		$code = $key;
	    } else {
		$country_name = ' Tanzania (United Republic of)';
		$code = '255';
	    }
	}

	$valid_number = $code . $y;

	$valid = array($country_name, $valid_number);
	return $valid;
    }
}

/**
 * This records all errors that occurs in files or systems and write them in a 
 * file. It is very important function and it should not be changed without
 * proper reasons
 */
function errorHandler($errno, $errmsg, $filename, $linenum, $vars) {
    // timestamp for the error entry
    $dt = date("Y-M-d H:i:s");

    // define an assoc array of error string
    // in reality the only entries we should
    // consider are E_WARNING, E_NOTICE, E_USER_ERROR,
    // E_USER_WARNING and E_USER_NOTICE
    $errortype = array(
	E_ERROR => 'Error',
	E_WARNING => 'Warning',
	E_PARSE => 'Parsing Error',
	E_NOTICE => 'Notice',
	E_CORE_ERROR => 'Core Error',
	E_CORE_WARNING => 'Core Warning',
	E_COMPILE_ERROR => 'Compile Error',
	E_COMPILE_WARNING => 'Compile Warning',
	E_USER_ERROR => 'User Error',
	E_USER_WARNING => 'User Warning',
	E_USER_NOTICE => 'User Notice',
	E_STRICT => 'Runtime Notice',
	E_RECOVERABLE_ERROR => 'Catchable Fatal Error'
    );
    // set of errors for which a var trace will be saved
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

    $err = "<br/><br/><ul>\n";
    $err .= "\t<li>date time " . $dt . "</li>\n";
    $err .= "\t<li>errornum " . $errno . "</li>\n";
    $err .= "\t<li>errortype " . $errortype[$errno] . "</li>\n";
    $err .= "\t<li>error msg: " . $errmsg . "</li>\n";
    $err .= "\t<li>File name: " . $filename . "</li>\n";
    $err .= "\t<li>Line no: " . $linenum . "</li>\n";

    if (in_array($errno, $user_errors)) {
	$err .= "\t<li>var trace: " . wddx_serialize_value($vars, "Variables") . "</li>\n";
    }
    $err .= "</ul>\n\n";

    // save to the error log, and e-mail me if there is a critical user error
    error_log($err, 3, RT . "media/doc/errors/php_error_log.html");
}

/*
  |--------------------------------------------------------------------------
  | Call Page function
  |--------------------------------------------------------------------------
  |
  | This function help to detect if session is valid or not so we may load specific
  | resource.
  |
 */

function call_page($page_name) {
    return session('client_id') == NULL ?
	    "window.location.reload()" :
	    "call_page('{$page_name}')";
}

/*
  |--------------------------------------------------------------------------
  | Make time Ago
  |--------------------------------------------------------------------------
  |
  | This function help convert time into ago format.
  |
 */

function make_time_ago($date) {
    if (empty($date)) {
	return "No date provided";
    }

    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    $now = time();
    $unix_date = strtotime($date);

    // check validity of date
    if (empty($unix_date)) {
	return "Bad date";
    }

    // is it future date or past date
    if ($now > $unix_date) {
	$difference = $now - $unix_date;
	$tense = "ago";
    } else {
	$difference = $unix_date - $now;
	$tense = "from now";
    }

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
	$difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
	$periods[$j].= "s";
    }

    return "$difference $periods[$j] {$tense}";
}

function decryptApp($encrypted_string) {
    $iv = "1234567812345678";
    return $data = $encrypted_string;
    // return openssl_decrypt(base64_decode($data), 'aes-256-cbc', ECRYPTION_KEY, OPENSSL_RAW_DATA, $iv);
}

function encryptApp($pure_string) {
    $iv = "1234567812345678";
    $data = openssl_encrypt($pure_string, 'aes-256-cbc', ECRYPTION_KEY, OPENSSL_RAW_DATA, $iv);
    //return base64_encode($data);
    return $pure_string;
}

function numberToWords($number) {
    if (($number < 0) || ($number > 999999999)) {
	return "$number";
    }

    $Gn = floor($number / 1000000);  /* Millions (giga) */
    $number -= $Gn * 1000000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10; /* Ones */

    $res = "";

    if ($Gn) {
	$res .= numberToWords($Gn) . " Million";
    }

    if ($kn) {
	$res .= (empty($res) ? "" : " ") .
		numberToWords($kn) . " Thousand";
    }

    if ($Hn) {
	$res .= (empty($res) ? "" : " ") .
		numberToWords($Hn) . " Hundred";
    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
	"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
	"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
	"Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
	"Seventy", "Eigthy", "Ninety");

    if ($Dn || $n) {
	if (!empty($res)) {
	    $res .= " and ";
	}

	if ($Dn < 2) {
	    $res .= $ones[$Dn * 10 + $n];
	} else {
	    $res .= $tens[$Dn];

	    if ($n) {
		$res .= "-" . $ones[$n];
	    }
	}
    }

    if (empty($res)) {
	$res = "zero";
    }

    return $res;
}
