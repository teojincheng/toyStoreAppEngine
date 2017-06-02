<?php
/**
 * Author: Teo Jin Cheng
 */
session_start();
require_once('../vendor/autoload.php');
require_once('../config.php');
$cart_repo = new GDS\lib\RepositoryCart();
$toy_repo = new GDS\lib\Repository();

$cartArr = $cart_repo->getCartItemsOfUser($_SESSION["userid"]);

$cartTotal = 0;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Terrific Toys</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Teo Jin Cheng">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/navbar.css">
        <link rel="stylesheet" href="css/cartItems.css">
    </head>
    <body>
        <?php include 'navbar.php'; ?>

        <div class="container">
            <h2>Your Shopping Cart</h2>
            <div class="row">
                <div class="col-md-9">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                            </tr>
                        </thead>

                        <?php
                        foreach ($cartArr as $cartObj) {
                            $toyInfo = $toy_repo->getToyByToyId($cartObj->toyId);
                            $cartTotal = $cartTotal + ($cartObj->unitPrice * $cartObj->qty);
                            ?>
                            <tr>
                                <td><?php echo $toyInfo->name; ?><br><img class="img-responsive cartProduct" src="<?php echo $toyInfo->imgpath ?>" alt="<?php echo $toyInfo->name; ?>"></td>
                                <td><?php echo $cartObj->qty; ?></td>
                                <td><?php echo $cartObj->unitPrice; ?></td>

                            </tr>
                        <?php } ?>
                            <tr>
                                <td></td>
                                <td>Total: </td>
                                <td><?php echo $cartTotal; ?></td>
                            </tr>




                    </table>


                </div>
                <div class="col-md-3">
                    <div id="checkOut">
                        <div id="innerContent">
                        Total: <?php echo $cartTotal; ?>
                        <br>
                        <input type="submit" class="btn btn-warning" value="Checkout">
                        </div>
                        </div>

                </div>

            </div>

        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
