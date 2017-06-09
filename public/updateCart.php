<?php
/**
 * Author: Teo Jin Cheng
 */
require_once('../vendor/autoload.php');
require_once('../config.php');
$cart_repo = new \GDS\lib\RepositoryCart();
$cartIdToDelete = $_GET["q"];

$cart_obj = $cart_repo->getCartEntityById($cartIdToDelete);
$cart_repo->deleteOneCartEntity($cart_obj);

echo "successfully removed from datastore";