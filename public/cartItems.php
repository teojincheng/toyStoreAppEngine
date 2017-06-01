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
    </head>
    <body>
        <?php include 'navbar.php'; ?>

        <div class="container">
            <h2>Your Shopping Cart</h2>
            <div class="row">
                <div class="col-md-10">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>

                            <?php
                            foreach ($cartArr as $cartObj) {
                                $toyInfo = $toy_repo->getToyByToyId($cartObj->toyId);
                                ?>
                                <tr>
                                    <td><?php echo $toyInfo->name; ?><br><img src="<?php echo $toyInfo->imgpath ?>" alt="<?php echo $toyInfo->name; ?>"></td>
                                    <td><?php echo $cartObj->qty; ?></td>
                                    <td><?php echo $cartObj->unitPrice; ?></td>

                                </tr>
                            <?php } ?>



                     
                    </table>


                </div>
                <div class="col-md-2">

                </div>

            </div>

        </div>

    </body>
</html>
