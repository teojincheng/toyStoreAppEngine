<?php
/**
 * Usage of Library/Framework:
 * https://github.com/CodeSeven/toastr
 */
session_start();
require_once('../vendor/autoload.php');
require_once('../config.php');
$toy_repo = new \GDS\lib\Repository();
$review_repo = new \GDS\lib\RepositoryReview();
/**
 * get information of a toy based on the url parameter. 
 * also get review of that toy.
 * since this is just a demo, 'protect' the datastore from
 * harmful queries by checking the length of $_GET["id"]
 * 
 */
if (is_string($_GET["id"])) {
    if (strlen($_GET["id"]) < 3) {
        $info_toy = $toy_repo->getToyByToyId($_GET["id"]);
        $reviews_arr = $review_repo->getReviewsOfAToy($_GET["id"]);
    }
}


/**
 * count the number of reviews
 * caluclate the average rating which accompanies each review
 */
$numOfReviews = count($reviews_arr);
$avgRating = 0;
if ($numOfReviews != 0) {
    $sumOfRating = 0;
    foreach ($reviews_arr as $obj_review) {
        $sumOfRating = $sumOfRating + $obj_review->rating;
    }
    $avgRating = $avgRating + ( floor($sumOfRating / $numOfReviews));
}
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
        <link rel="stylesheet" href="css/itemDetail.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <?php if (isset($_GET["q"])) { ?>
            <script>
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr["success"]("<?php echo $info_toy->name; ?> <br> Quantity : <?php echo $_GET['q']; ?>", "Item added to cart successfully")
            </script>
        <?php } ?>

        <?php include 'navbar.php'; ?>
        <h2><?php echo $info_toy->name; ?></h2>
        <!-- Information of one toy -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="img-responsive" src="<?php echo $info_toy->imgpath; ?>" alt="">
                </div>
                <div class="col-md-4">
                    <h4>Price: $<?php echo $info_toy->price; ?></h4>
                    <h4>Description: </h4>
                    <p><?php echo $info_toy->txtDescript; ?></p>
                    <br>
                    <br>
                    <br>
                    <?php if (isset($_SESSION["userid"])) { ?>
                        <form action="addToCart.php" method="POST">
                            Quantity:
                            <select name="qty">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select> 
                            <input type="hidden" name="toyid" value="<?php echo $_GET["id"]; ?>">
                            <input type="hidden" name="userid" value="<?php echo $_SESSION["userid"]; ?>">
                            <input type="hidden" name="unitprice" value="<?php echo $info_toy->price; ?>">

                            <input type="submit" value="Add to Cart" class="btn btn-primary">
                        </form>
                    <?php } ?>
                </div>

            </div>

            <hr>
            <!-- Average rating gathered from reviews -->
            <div class="row">
                <div class="col-md-8">
                    <h3>Reviews</h3>

                    <div class="lineblock">
                        <?php if ($avgRating == 0) { ?>
                            <img class="img-responsive" src="img/emptyStars.png" alt="Rating is 0">
                        <?php } elseif ($avgRating == 1) { ?>
                            <img class="img-responsive" src="img/oneStar.png" alt="Rating is 1">
                        <?php } elseif ($avgRating == 2) { ?>
                            <img class="img-responsive" src="img/twoStar.png" alt="Rating is 2">
                        <?php } elseif ($avgRating == 3) { ?>
                            <img class="img-responsive" src="img/threeStar.png" alt="Rating is 3">
                        <?php } elseif ($avgRating == 4) { ?>
                            <img class="img-responsive" src="img/fourStar.png" alt="Rating is 4">
                        <?php } elseif ($avgRating == 5) { ?>
                            <img class="img-responsive" src="img/fiveStar.png" alt="Rating is 5">
                        <?php } ?>
                    </div>

                    <div id="numReviews" class="lineblock"  > <?php echo $numOfReviews; ?> reviews </div>
                    <br>
                    <?php
                    $currUserMadeReview = false;
                    if (isset($_SESSION["userid"])) {
                        foreach ($reviews_arr as $obj_review) {
                            if ($obj_review->userid == $_SESSION["userid"]) {
                                $currUserMadeReview = true;
                            }
                        }
                    }
                    if (isset($_SESSION["userid"])) {
                        if ($currUserMadeReview == false) {
                            ?>
                            <button type="button" data-toggle="modal" data-target="#formModal">Write a review</button>
                            <?php
                        }
                    }
                    ?>


                </div>
            </div>
            <!-- Pop-up modal to let user input review of the toy -->
            <div id="formModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Review for <?php echo $info_toy->name; ?></h4>
                        </div>
                        <div class="modal-body">
                            <form action="#" method="POST">
                                Review:
                                <div class="form-group">
                                    <textarea rows="4" cols="50" name="review"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="rating">
                                        <input type="radio" id="star5" name="rating" value="5"/><label for="star5"></label>
                                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
                                        <input type="radio" id="star3" name="rating" value="3"  /><label for="star3"></label>
                                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
                                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <input type="submit" value="Submit">

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- For loop to display every single review of this toy -->
            <?php foreach ($reviews_arr as $obj_review) { ?>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <?php if ($obj_review->rating == 0) { ?>
                            <img class="img-responsive" src="img/emptyStars.png" alt="Rating is 0">
                        <?php } elseif ($obj_review->rating == 1) { ?>
                            <img class="img-responsive" src="img/oneStar.png" alt="Rating is 1">
                        <?php } elseif ($obj_review->rating == 2) { ?>
                            <img class="img-responsive" src="img/twoStar.png" alt="Rating is 2">
                        <?php } elseif ($obj_review->rating == 3) { ?>
                            <img class="img-responsive" src="img/threeStar.png" alt="Rating is 3">
                        <?php } elseif ($obj_review->rating == 4) { ?>
                            <img class="img-responsive" src="img/fourStar.png" alt="Rating is 4">
                        <?php } elseif ($obj_review->rating == 5) { ?>
                            <img class="img-responsive" src="img/fiveStar.png" alt="Rating is 5">
                        <?php } ?>
                        By <?php echo $obj_review->username; ?>
                        <br>
                        <?php
                        echo $obj_review->reviewText;
                        ?>

                    </div>
                </div>
                <?php
            }
            ?>

        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </body>
</html>

