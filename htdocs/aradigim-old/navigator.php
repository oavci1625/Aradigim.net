<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Home</title>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light" style="background-color: #ffffff;">
        <div class="col-sm-2"></div>
        <a class="navbar-brand" href="index.php">
            <img src="img/alogo.png" width="50" height="50" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link h6" href="index.php">Ana Sayfa</a>
                </li>
                <li class="nav-item">
                    <a href="aradigimeleman/index.php" class="btn btn-outline-dark" style="margin-right:5px;">Aradığım Eleman</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="btn btn-outline-dark my-sm-0">Aradığım İş</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link h6">Hakkımızda</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link h6">İletişim</a>
                </li>
            </ul>

            <?php
            //Login-Logout Buttons
            if (isset($_SESSION['userUid'])) { //IF LOGGED IN
                $userUid = $_SESSION['userUid'];
            ?>
                <a href="editProfile.php">
                    <button class="btn btn-outline-success my-2 my-sm-0 bg-primary text-light"><?php echo $userUid ?></button>
                </a>

                <a href="includes/logout.inc.php">
                    <button class="btn btn-outline-danger my-2 my-sm-0 bg-danger text-light">Çıkış Yap</button>
                </a>
            <?php } ?>

            <?php
            //Login-Logout Buttons
            if (!isset($_SESSION['userUid'])) { //IF LOGGED OUT
            ?>
                <a href="login.php">
                    <button class="btn btn-outline-success bg-success text-light" name="login-button" type="submit">Giriş Yap</button>
                </a>
                <a href="signup.php">
                    <button class="btn my-sm-0 text-light bg-primary">Kaydol</button>
                </a>
            <?php } ?>
        </div>
        <div class="col-sm-2"></div>
    </nav>
</body>