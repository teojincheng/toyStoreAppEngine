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

$numOfCartItems = count($cartArr);
$cartTotal = 0;
$arrOfCartId = array();
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
        <link rel="stylesheet" href="css/general.css">
    </head>
    <body>
        <div id="wrapper">
            <?php include 'navbar.php'; ?>


            <div id="content">
                <div class="container">
                    <h2>Your Shopping Cart</h2>
                    <div id="mainContent" class="row">
                        <div class="col-md-9">
                            <?php if ($numOfCartItems == 0) { ?>
                                <p id="noItem">No items in your cart</p>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-9">
                                <table id="itemsTable" class="table table-responsive">
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
                                        <tr id="tr<?php echo $cartObj->id; ?>">

                                            <td><?php echo $toyInfo->name; ?><br><img class="img-responsive cartProduct" src="<?php echo $toyInfo->imgpath ?>" alt="<?php echo $toyInfo->name; ?>"></td>

                                            <td>
                                                <select id="itemQty<?php echo $cartObj->id; ?>">
                                                    <option value="1" <?php if ($cartObj->qty == 1) { ?>selected <?php } ?> >1</option>
                                                    <option value="2" <?php if ($cartObj->qty == 2) { ?>selected <?php } ?> >2</option>
                                                    <option value="3" <?php if ($cartObj->qty == 3) { ?>selected <?php } ?> >3</option>
                                                    <option value="4" <?php if ($cartObj->qty == 4) { ?>selected <?php } ?>>4</option>
                                                </select>
                                            </td>


                                            <td>$<span id="unitPrice<?php echo $cartObj->id; ?>"><?php echo $cartObj->unitPrice; ?></span><br><span class="delLink" id="del<?php echo $cartObj->id; ?>">Remove item</span></td>

                                        </tr>
                                        <?php
                                        array_push($arrOfCartId, $cartObj->id);
                                    }
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td>Total: </td>
                                        <td>$<span id="cartTotalBottom"><?php echo $cartTotal; ?></span></td>
                                    </tr>
                                </table>


                            </div>
                            <div class="col-md-3">
                                <div id="checkOut">
                                    <div id="innerContent">
                                        <span> Total: $<span id="cartTotalSide"><?php echo $cartTotal; ?></span> </span>
                                        <br>
                                        <input type="submit" class="btn btn-warning" value="Checkout">
                                    </div>
                                </div>

                            </div>
                        <?php } ?>
                    </div> 

                </div> <!-- close container -->
            </div>
             <?php include 'footer.php'; ?>
        </div>

       

        <script>
            var arrOfId = <?php echo json_encode($arrOfCartId); ?>;
            var currUserId = <?php echo json_encode($_SESSION["userid"]); ?>;

        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/cartItems.js"></script>



    </body>
</html>
