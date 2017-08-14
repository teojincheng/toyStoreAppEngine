<?php
/**
 * Author: Teo Jin Cheng 
 */
require_once('../vendor/autoload.php');
require_once('../config.php');
$cart_repo = new \GDS\lib\RepositoryCart();
if (isset($_SESSION["userRealname"])) {

    /**
     * do a query on the datastore based current user's userid
     * check the result of the query got how many rows for user's shopping cart
     * if there is at least one row, sum the quanitity of items in the cart
     * if not show a value of 0 for the cart. 
     * 
     */
    $showZero = true;
    $allCartInfoArr = $cart_repo->getCartItemsOfUser($_SESSION["userid"]);
    $numOfRecords = count($allCartInfoArr);
    if ($numOfRecords != 0) {
        $numOfItems = 0;
        $showZero = false;
        foreach ($allCartInfoArr as $cartItem) {
            $numOfItems = $numOfItems + $cartItem->qty;
        }
    }
}
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"> Terrific Toys</a>
        </div>


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li><a href="#">Soft toys</a> </li> 
                <li><a href="#">Model kits</a></li> 
                <li><a href="#">Vehicles</a></li> 
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Brands <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Disney</a></li>
                        <li><a href="#">Play Doh</a></li>
                        <li><a href="#">Lego</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"> <i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>

            </form>
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION["userRealname"])) { ?>
                    <li><a href="cartItems.php">
                            <?php if ($showZero) { ?>
                                <span class="glyphicon glyphicon-shopping-cart"></span> Cart [0] </a></li>
                    <?php } else { ?>
                                <span class="glyphicon glyphicon-shopping-cart"></span> Cart [<span id="cartNum"><?php echo $numOfItems; ?></span>] </a></li>
                    <?php } ?>
                    <li><a href="#"><?php echo $_SESSION["userRealname"]; ?></a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php } else { ?>
                    <li><a href="login.php">Login</a></li>
                <?php } ?>
            </ul>

        </div>
    </div>
</nav>