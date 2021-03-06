<?php
session_start();
require_once('../vendor/autoload.php');
require_once('../config.php');
$user_repo = new \GDS\lib\RepositoryUser();
$loginFail = false;
if (isset($_POST["username"])) {
    /**
     * get all the columns of the logged in user
     * get the hased password stored in the database.
     * use the php function to match the input password and stored password
     * if successful, create session variables for this user. 
     */
    $allInfoArr = $user_repo->getAllColsFromDatastore($_POST["username"]);
    $userHashed = $allInfoArr->password;
    if (password_verify($_POST["password"], $userHashed)) {
        $_SESSION["userRealname"] = $allInfoArr->name;
        $_SESSION["userid"] = $allInfoArr->id;
        header("Location: index.php");
    } else {
        $loginFail = true;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login-</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Teo Jin Cheng">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/navbar.css">
        <link rel="stylesheet" href="css/general.css">

    </head>
    <body>
        <div id="wrapper">
            <?php include 'navbar.php'; ?>
            <div id="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <form action="login.php" method="POST">
                                <div class="form-group">
                                    <label for="usernameInput">Username: </label>
                                    <input class="form-control" type="text" name="username" value="feliwee" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="pwInput">Password: </label>
                                    <input class="form-control" type="password" name="password" value="shfw88" readonly>
                                </div>
                                <input type="submit" value="Login">

                                <?php if ($loginFail) { ?>
                                    <div class="alert alert-warning">Login failed </div>
                                <?php } ?>

                            </form>
                        </div>
                        <div class="col-md-4"></div>


                    </div>
                </div> <!-- close container -->
            </div>
            <?php include 'footer.php'; ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>


