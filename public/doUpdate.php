<?php

/**
 * Update the record of one toy
 */
require_once('../vendor/autoload.php');
require_once('../config.php');
use \GDS\lib\Repository;


// Filter vars
$post_id = $_POST["postid"];
$str_name = substr(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING), 0, 30);
$str_desc = substr(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING), 0, 1000);
$flt_price = substr(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION), 0, 30);
$str_info = substr(filter_input(INPUT_POST, 'information', FILTER_SANITIZE_STRING), 0, 30);
$int_rating = substr(filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT), 0, 30);



$obj_repo = new Repository();
$curr_post = $obj_repo->getToyByEntityId($post_id);
$curr_post->name = $str_name;
$curr_post->txtDescript = $str_desc;
$curr_post->price = $flt_price;
$curr_post->information = $str_info;
$curr_post->rating = $int_rating;
$obj_repo->updateToy($curr_post);

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
		