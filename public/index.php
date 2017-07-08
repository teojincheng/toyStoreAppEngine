<?php
session_start();
require_once('../vendor/autoload.php');
require_once('../config.php');


$toy_repo = new \GDS\lib\Repository();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Terrific Toys</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Teo Jin Cheng">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/navbar.css">
        <link rel="stylesheet" href="css/general.css">

    </head>
    <body>
        <div id="wrapper">
            <?php include 'navbar.php'; ?>
            <?php
            // get the most recent added toys. 6 of them. 
            $arrLatestThree = $toy_repo->getRecentToysTopThree();
            $arrNextThree = $toy_repo->getRecentToysNextThree();
            ?>

            <div id="content">
                <div class="container">

                    <!-- Image Carousel-->
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>


                        </ol>      
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="img/caro1.jpg" alt="">

                            </div>

                            <div class="item">
                                <img src="img/caro2.png" alt="">
                            </div>
                        </div>              
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <h2>New toys</h2>
                    <!--
                    Latest 6 toys. 
                    Divided into 2 rows. 
                    For loop to display information about the toy
                    -->
                    <div class="row">
                        <?php foreach ($arrLatestThree as $toy) { ?>
                            <div class="col-md-4">
                                <figure class="productSmallPic">
                                    <a href="itemDetail.php?id=<?php echo $toy->id; ?>"> <img class="img-responsive" src="<?php echo $toy->imgpath; ?>" alt="img of toy" >
                                        <figcaption> <?php echo $toy->name; ?></figcaption></a>
                                </figure>
                            </div>
                        <?php } ?>
                    </div>
                    <br>
                    <br>


                    <div class="row">
                        <?php foreach ($arrNextThree as $toyNext) { ?>
                            <div class="col-md-4">
                                <figure class="productSmallPic">
                                    <a href="itemDetail.php?id=<?php echo $toyNext->id; ?>">  <img class="img-responsive"  src="<?php echo $toyNext->imgpath; ?>" alt="img of toy" >
                                        <figcaption> <?php echo $toyNext->name; ?></figcaption> </a>
                                </figure>
                            </div>
                            <?php
                        }
                        ?>

                    </div>

                </div> <!-- close container -->
                
            </div>
              <?php include 'footer.php'; ?>
        </div>

      

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/index.js"></script>
    </body>
</html>
