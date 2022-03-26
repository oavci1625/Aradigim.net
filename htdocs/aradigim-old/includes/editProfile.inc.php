<?php

if(isset( $_SESSION['userUid'])){

    require 'dbh.inc.php';

    $userUid = $_SESSION['userUid'];
    $userType = $_SESSION['userType'];

    if($userType == "eleman"){

        //Deleting a profile
        if( isset($_GET['delete'])){
            $sql = "DELETE FROM users" . $_GET['delete']." WHERE `uid` = '$userUid'";
            $stmt = mysqli_stmt_init( $conn);
            if( !mysqli_stmt_prepare($stmt, $sql) ){
                header("Location: index.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_execute($stmt);
                //now it is time to remove job code from users table
                $sql = "UPDATE users SET jobUsers = REPLACE(jobUsers , '" .  $_GET['delete'].",','') WHERE jobUsers LIKE '%{$_GET['delete']}%' ";
                $stmt = mysqli_stmt_init( $conn);
                if( !mysqli_stmt_prepare($stmt, $sql) ){
                    header("Location: index.php?error=sqlerror");
                    exit();
                }
                else{
                    mysqli_stmt_execute($stmt);
                }
            }
        }
        //end of deleting

        //Changing activation of a profile
        if( isset($_POST['jobActivation'])){
            $userJob = $_POST['jobActivation'];
            if( isset( $_POST['active'])){ 
                $sql = "UPDATE `users".$userJob ."` SET `active`='true' WHERE `uid`='$userUid'";
                $stmt = mysqli_stmt_init( $conn);
                if( !mysqli_stmt_prepare($stmt, $sql) ){
                    header("Location: editProfile.php?error=activationchange1");
                    exit();
                }
                else
                    mysqli_stmt_execute($stmt);
                
                $sql = "UPDATE `users` SET `jobUsers`=REPLACE(`jobUsers`, '".$userJob."_false,', '".$userJob."_true,') ";
                $stmt = mysqli_stmt_init( $conn);
                if( !mysqli_stmt_prepare($stmt, $sql) ){
                    header("Location: editProfile.php?error=activationchangeinuserstable");
                    exit();
                }
                else
                    mysqli_stmt_execute($stmt);
            }
            else{
                $sql = "UPDATE users".$userJob ." SET `active`='false' WHERE `uid`='$userUid'";
                $stmt = mysqli_stmt_init( $conn);
                if( !mysqli_stmt_prepare($stmt, $sql) ){
                    header("Location: editProfile.php?error=activationchange2");
                    exit();
                }
                else
                    mysqli_stmt_execute($stmt);
                
                $sql = "UPDATE `users` SET `jobUsers`=REPLACE(`jobUsers`, '".$userJob."_true,', '".$userJob."_false,') ";
                $stmt = mysqli_stmt_init( $conn);
                if( !mysqli_stmt_prepare($stmt, $sql) ){
                    header("Location: editProfile.php?error=activationchangeinuserstable");
                    exit();
                }
                else
                    mysqli_stmt_execute($stmt);
            }

        }

        $sql = "SELECT * FROM users WHERE uidUsers=?";
        $stmt = mysqli_stmt_init( $conn);

        if( !mysqli_stmt_prepare($stmt, $sql) ){
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "s", $userUid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if( $row = mysqli_fetch_assoc( $result)){
                $image = $row['imageUsers'];
                $jobUsers = $row['jobUsers'];
                if( $jobUsers != NULL){
                    $jobArrayWithStatements = explode("," , $jobUsers);
                    $jobNo = count($jobArrayWithStatements) - 1;
                }
                else{
                    $jobArray = NULL;
                    $jobNo = 0;
                }
                
            }
            else{
                header("Location: index.php?error=nouser");
                exit();
            }
        }

        //Getting activation of the profile
        $jobArray = [];
        $activeArray = [];
        for ($i=0; $i < $jobNo; $i++) {
            array_push($jobArray, explode("_",$jobArrayWithStatements[$i])[0]);
            if(explode("_",$jobArrayWithStatements[$i])[1] == "true")
                array_push($activeArray, "true");
            else
                array_push($activeArray, "false");
        }
        
    }
    else{
        header("Location: index.php?error=nouser");
        exit();
    }

}
else{
    header("Location: index.php");
    exit();
}