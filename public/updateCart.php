<?php
/**
 * Author: Teo Jin Cheng
 */
require_once('../vendor/autoload.php');
require_once('../config.php');
$cart_repo = new \GDS\lib\RepositoryCart();

if(isset($_GET["d"])){
$cartIdToDelete = $_GET["d"];

$cart_obj = $cart_repo->getCartEntityById($cartIdToDelete);
$cart_repo->deleteOneCartEntity($cart_obj);

echo "successfully removed from datastore";
}
else if(isset($_GET["u"])){
    $cartIdToUpdate = $_GET["u"];
    $newQty = $_GET["q"];
    $cart_obj = $cart_repo->getCartEntityById($cartIdToUpdate);
    $cart_obj->qty = $newQty;
    $cart_repo->updateCartItem($cart_obj);
    echo "successfully updated datastore";
}else if(isset($_GET["qr"])){
    $userId = $_GET["qr"];
    $totalQty = 0;
    $cart_obj = $cart_repo->getCartItemsOfUser($userId);
    foreach ($cart_obj as $cartObj) {
         $totalQty = $totalQty + $cartObj->qty;
     }
     echo $totalQty;
}