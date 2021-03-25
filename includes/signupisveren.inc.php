<?php
if (isset($_POST["signup-isveren-submit"])) {
    
    require 'dbh.inc.php';

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['uid'];
    $email = $_POST['mail'];
    $companyName = $_POST['companyname'];
    $companyType = $_POST['companytype'];
    $taxid = $_POST['taxid'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];
    $job = $_POST['job'];

    // Get file info 
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fişleType = $_FILES['file']['type'];

    $fileExt = explode( '.' , $fileName);
    $fileActualExt = strtolower( end( $fileExt));

    $allowed = array('jpg', 'jpeg', 'png');



    if ( empty($name) || empty($surname) ||empty($username) || empty($email) || empty($companyName) || empty($companyType) || empty($taxid) || empty($password) || empty($passwordRepeat) || empty($_FILES["file"]["name"])) {
        header("Location: ../signup.php?error=emptyfields&name=".$name."&surname=".$surname."uid=".$username."&mail=".$email."&job=".$job);
        exit();
    }

    else if( !filter_var( $email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username) ){
        header("Location: ../signup.php?error=invalidmailuid&name=".$name."&surname=".$surname."job=".$job);
        exit();
    }

    else if( !filter_var( $email, FILTER_VALIDATE_EMAIL) ){
        header("Location: ../signup.php?error=invalidmail&name=".$name."&surname=".$surnameuid."&uid=".$username."&job=".$job);
        exit();
    }

    else if( !preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../signup.php?error=invaliduid&name=".$name."&surname=".$surnameuid."&mail=".$email."&job=".$job);
        exit();
    }

    else if( $password !== $passwordRepeat){
        header("Location: ../signup.php?error=passwordcheck&name=".$name."&surname=".$surname."&uid=".$username."&mail=".$email."&job=".$job);
        exit();
    }
     
    // Allow certain file formats 
    else if( !in_array($fileActualExt, $allowed)){ 
        header("Location: ../signup.php?error=invalidfile&name=".$name."&surname=".$surname."&uid=".$username."&mail=".$email."&job=".$job);
        exit();
    }

    //Checking for error
    else if( $fileError !== 0){
        header("Location: ../signup.php?error=uploaderror&name=".$name."&surname=".$surname."&uid=".$username."&mail=".$email."&job=".$job);
        exit();
    }

    //Allow max size
    else if($fileSize > 1000000){
        header("Location: ../signup.php?error=invalidimagesize&name=".$name."&surname=".$surname."&uid=".$username."&mail=".$email."&job=".$job);
        exit();
    }

    else{

        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if( !mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../signup.php?error=sqlerror1");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt , "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultcheck = mysqli_stmt_num_rows($stmt);
            if( $resultcheck > 0){
                header("Location: ../signup.php?error=usertaken&name=".$name."&surname=".$surname."&mail=".$email."&job=".$job);
                exit();
            }
            else{

                //uploading profile image
                $fileNameNew = $username . "." . $fileActualExt;
                $fileDestination = '../img/profile_pictures/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                $sql = "INSERT INTO users (imageUsers, nameUsers, surnameUsers, uidUsers, emailUsers, pwdUsers, typeUsers, companynameUsers, companytypeUsers, taxid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if( !mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../signup.php?error=sqlerror2");
                    exit();
                }
                else{
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    $typeUser = "isveren";
                    mysqli_stmt_bind_param($stmt , "ssssssssss", substr($fileDestination, 3), $name, $surname, $username, $email, $hashedPwd, $typeUser, $companyName, $companyType, $taxid);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../signup.php?signup=success");
                    exit();
                }

            }
        }

    }
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($conn);

}
else{
    header("Location: ../signup.php");
    exit();
}