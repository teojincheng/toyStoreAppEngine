<?php
/**
 * Author: Teo Jin Cheng
 */
session_start();
$_SESSION = array();
session_destroy();
header("Location: index.php");


