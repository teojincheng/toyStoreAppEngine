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

$numOfReviews = count($reviews_arr);
$sumOfRating = 0;
foreach ($reviews_arr as $obj_review) {
    $sumOfRating = $sumOfRating + $obj_review->rating;
    
}
$avgRating = floor($sumOfRating/$numOfReviews);


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
            <hr
                <div class="row">
                <div class="col-md-8">
                    <h3>Reviews</h3>
                    <div class="rating">
                        <input type="radio" id="star5" name="rating" value="5" <?php if ($avgRating == 5) { ?> checked="checked" <?php } ?> /><label for="star5"></label>
                        <input type="radio" id="star4" name="rating" value="4" <?php if ($avgRating == 4) { ?> checked="checked" <?php } ?> /><label for="star4"></label>
                        <input type="radio" id="star3" name="rating" value="3" <?php if ($avgRating == 3) { ?> checked="checked" <?php } ?> /><label for="star3"></label>
                        <input type="radio" id="star2" name="rating" value="2" <?php if ($avgRating == 2) { ?> checked="checked" <?php } ?> /><label for="star2"></label>
                        <input type="radio" id="star1" name="rating" value="1" <?php if ($avgRating == 1) { ?> checked="checked" <?php } ?> /><label for="star1"></label>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </body>
</html>

