<?php
if(isset($_POST['login-submit'])){
    require 'dbh.inc.php';
    require '../api/api.php';

    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];
    $successheader = "Location: ../index.php";
    $errorheader = "Location: ../login.php";
    
    api::login($mailuid, $password, $successheader, $errorheader);
}
else{
    header("Location: ../login.php");
    exit();
}