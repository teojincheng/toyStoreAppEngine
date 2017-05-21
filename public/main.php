<?php

use google\appengine\api\cloud_storage\CloudStorageTools;

$my_bucket = "mtoys-167102.appspot.com";
$options = ['gs_bucket_name' => $my_bucket];
$upload_url = CloudStorageTools::createUploadUrl('/post.php', $options);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/demo.css">

        <!--[if lt IE 9]>
                        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                <![endif]-->

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>
            <div class="row">
                <div class="col-md-8">

                </div>
                <div class="col-md-4">
                    <h2>Resources</h2>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="well">
                        <h3>Create</h3>
                        <form method="POST" action="/post.php" enctype="multipart/form-data" >
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name"  />
                            </div>
                            <div class="form-group">
                                <textarea rows="3" class="form-control" name="description" id="description" placeholder="Description" maxlength="1000"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="price" id="price" placeholder="0.00" maxlength="30" />
                            </div>
                            <div class="form-group">
                                <textarea rows="3" class="form-control" name="information" id="information" placeholder="information" maxlength="1000"></textarea>
                            </div>
                            <input type="file" name="image" />
                            <div class="form-group">
                                <div class="rating">
                                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
                                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>

                                </div>
                            </div>

                            <div class="form-group">
                                <textarea rows="3" class="form-control" name="review" id="review" placeholder="review" ></textarea>
                            </div>
                            <input type="hidden" name="guest-as" id="guest-as" value="<?php echo base_convert(date('YmdH'), 10, 36); ?>" />
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    </div>
                    <?php
                    $bol_spam = FALSE;
                    if (isset($_GET['spam']) && 'maybe' == $_GET['spam']) {
                        echo '<span class="alert alert-warning">Perhaps you are trying to spam? Post ignored.</spam>';
                        $bol_spam = TRUE;
                    }
                    ?>
                </div>
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php
                            try {
                                if (!$bol_spam) {

                                    // Includes
                                    require_once('../vendor/autoload.php');
                                    require_once('../config.php');

                                    // Grab posts
                                    $obj_repo = new \GDS\lib\Repository();
                                    $arr_posts = $obj_repo->getRecentToysThree();
                                    
                                    print_r($arr_posts);

                                    // Show them

                                    foreach ($arr_posts as $obj_post) {
                                        ?>


                                        <div class="post">
                                            <div class="message"><a href="update.php?id=<?php echo $obj_post->getKeyId(); ?>"><?php echo htmlspecialchars($obj_post->txtDescript); ?></a></div>
                                            <div class="authored">By <?php echo htmlspecialchars($obj_post->name); ?> </div>
                                        </div>

            <?php
        }
        $int_posts = count($arr_posts);
        echo '<div class="post"><em>Showing last ', $int_posts, '</em></div>';
    }
} catch (\Exception $obj_ex) {
    syslog(LOG_ERR, $obj_ex->getMessage());
    echo '<em>Whoops, something went wrong!</em>';
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    </body>
</html>		