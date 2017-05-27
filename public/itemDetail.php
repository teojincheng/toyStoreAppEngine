<?php
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
$sumOfRating = 0;
foreach ($reviews_arr as $obj_review) {
    $sumOfRating = $sumOfRating + $obj_review->rating;
}
$avgRating = floor($sumOfRating / $numOfReviews);
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

        <?php include 'navbar.php'; ?>

        <?php ?>
        <h2><?php echo $info_toy->name; ?></h2>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="img-responsive" src="<?php echo $info_toy->imgpath; ?>" alt="">
                </div>
                <div class="col-md-4">
                    <h4>Price: $<?php echo $info_toy->price; ?></h4>
                    <h4>Description: </h4>
                    <p><?php echo $info_toy->txtDescript; ?></p>
                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-md-8">
                    <h3>Reviews</h3>

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

                    <?php echo $numOfReviews; ?> reviews
                </div>
            </div>
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

