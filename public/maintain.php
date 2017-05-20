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
                            <form method="POST" action="doDelete.php">
                                <?php
                                try {
                                    if (!$bol_spam) {

                                        // Includes
                                        require_once('../vendor/autoload.php');
                                        require_once('../config.php');

                                        // Grab posts
                                        $obj_repo = new \GDS\lib\Repository();
                                        $arr_posts = $obj_repo->getAllToys();

                                        // Show them

                                        foreach ($arr_posts as $obj_post) {
                                            ?>


                                            <div class="post">
                                                <div class="authored">Name: <?php echo htmlspecialchars($obj_post->name); ?><input type="checkbox" name="postsToDelete[]" value="<?php echo $obj_post->getKeyId(); ?>"> </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                } catch (\Exception $obj_ex) {
                                    syslog(LOG_ERR, $obj_ex->getMessage());
                                    echo '<em>Whoops, something went wrong!</em>';
                                }
                                ?>
                                <button type="submit" class="btn btn-primary">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    </body>
</html>