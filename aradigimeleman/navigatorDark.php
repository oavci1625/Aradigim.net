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


    <nav class="navbar sticky-top navbar-expand-lg navbar-dark" style = "background-color: rgb(37, 37, 37, 0.99);">
        <a class="navbar-brand" href="../index.php">
            <img src="img/alogo.png" width="60" height="60" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link h6" href="../index.php">Ana Sayfa <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link h6" href="#">İş Verenlerimiz</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link h6" href="editProfile.php">Profilini Düzenle</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link h6" href="#">Hakkımızda</a>
                </li>
            </ul>

            <?php
            //Login-Logout Buttons
            if( isset( $_SESSION['userUid'])){ //IF LOGGED IN
                $userUid = $_SESSION['userUid'];
                $userJob = $_SESSION['userJob'];
            ?>
                <form class="form-inline my-2 my-lg-0" action="profile.php?uid=<?php echo $userUid?>&job=<?php echo $userJob?>" method="post">
                    <button class="btn btn-outline-success my-2 my-sm-0" name="profile-page-submit" type="submit"><?php echo $userUid?></button>
                </form>

                <form class="form-inline my-2 my-lg-0" action="includes/logout.inc.php" method="post">
                    <button class="btn btn-outline-danger my-2 my-sm-0" name="logout-submit" type="submit">Çıkış Yap</button>
                </form>
            <?php } ?>

            <?php
            //Login-Logout Buttons
            if( !isset( $_SESSION['userUid'])){ //IF LOGGED OUT
            ?>
                <form class="form-inline my-2 my-lg-0" action="login.php" method="post">
                        <button class="btn btn-outline-success my-2 my-sm-0" name="login-button" type="submit">Giriş Yap</button>
                </form>
            <?php } ?>

        </div>
    </nav>
</body>
