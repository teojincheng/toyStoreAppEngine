<?php
/**
 * Author: Teo Jin Cheng
 */
require_once('../vendor/autoload.php');
require_once('../config.php');
$id_repo = new \GDS\lib\RepositoryId();
$cart_repo = new \GDS\lib\RepositoryCart();

$toyid = $_POST["toyid"];
$userid = $_POST["userid"];
$unitPrice = $_POST["unitprice"];
$buyQty = $_POST["qty"];
/**
 * Since this is just a demo
 * 'prevent harmful queries' into the datastore by checking the toyid 
 * transmitted via $_POST 
 * 
 * Since I am making use of my own id column to identify each record,
 * get the last used id. If I am inserting a new row, make sure the id is incremented properly. 
 * 
 * if user already added this toy to cart before, just update the qty in the datastore
 * else if the user is first time adding this toy to cart, create a new entry in the datastore.
 *  
 */
if (strlen($toyid) > 2) {
    echo "You shall not pass";
    exit();
}


$finalQty = 0;
$resultFromIdRepo = $id_repo->retrieveId();
$newCartId = ($resultFromIdRepo->cartid) + 1;
$cart_arr = $cart_repo->getCartItemByToyId($userid, $toyid);
if (count($cart_arr) != 0) {
    $finalQty = $finalQty + $cart_arr->qty + $buyQty;
    $cart_arr->qty = $finalQty;
    $cart_repo->updateCartItem($cart_arr);
} else {
    $cart_repo->createCartItem($newCartId, $toyid, $userid, $buyQty, $unitPrice);
    $resultFromIdRepo->cartid = $newCartId;
    $id_repo->updateEntry($resultFromIdRepo);
}
header("Location: itemDetail.php?id=$toyid&q=$buyQty");



