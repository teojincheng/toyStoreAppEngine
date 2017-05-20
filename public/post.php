<?php

/**
 * Inserts one entry of the toy into the datastore
 */
require_once('../vendor/autoload.php');
require_once('../config.php');

use google\appengine\api\cloud_storage\CloudStorageTools;
use \GDS\lib\Repository;

$my_bucket = "mtoys-167102.appspot.com";
$str_name = substr(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING), 0, 1000);
$str_desc = substr(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING), 0, 1000);
$flt_price = substr(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION), 0, 30);
$str_info = substr(filter_input(INPUT_POST, 'information', FILTER_SANITIZE_STRING), 0, 5000);




$file_name = $_FILES['image']['name'];
$temp_name = $_FILES['image']['tmp_name'];
move_uploaded_file($temp_name, "gs://${my_bucket}/${file_name}");
$str_path = "https://storage.googleapis.com/${my_bucket}/${file_name}";


//syslog(LOG_DEBUG, 'Proceeding... ' . print_r($_SERVER, TRUE) . "\n\n" . print_r($_POST, TRUE));
$obj_repo = new Repository();
$obj_repo->createToy($str_name, $str_desc, $flt_price, $str_info, $str_path);
header("Location: /");


/*

$str_as = (string) base_convert(substr(filter_input(INPUT_POST, 'guest-as', FILTER_SANITIZE_STRING), 0, 20), 36, 10);
if (!in_array($str_as, [date('YmdH'), date('YmdH', strtotime('-1 hour'))])) {
    syslog(LOG_WARNING, 'Skipping potential AV spam from [' . $_SERVER['REMOTE_ADDR'] . ']: ' . print_r($_POST, TRUE));
    header("Location: /?spam=maybe");
    exit();
}

use \GDS\lib\Spammy;
use \GDS\lib\Repository;

// VERY crude anti-spam-bot check
if (Spammy::anyLookSpammy([$str_name, $str_message])) {
    syslog(LOG_WARNING, 'Skipping potential spam from [' . $_SERVER['REMOTE_ADDR'] . ']: ' . print_r($_POST, TRUE));
    header("Location: /?spam=maybe");
} else {
    
}
		
	
*/