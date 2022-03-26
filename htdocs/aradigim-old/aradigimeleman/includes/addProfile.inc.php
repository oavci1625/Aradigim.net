<?php
session_start();

if (isset($_POST["add-profile-submit"])) {

    $userUid = $_SESSION['userUid'];
    $userName = $_SESSION['name'];
    $userSurname = $_SESSION['surname'];
    $userJob = $_POST['jobAdd'];
    $inputNames =  [];
    $inputValues =  [$userUid, $userName, $userSurname, 'true'];
    $dbNames =  [];
    $dbTypes = [];
    $isRequired = [];

    require 'dbh.inc.php';
 
    $sql = "SELECT * FROM formInputs WHERE job='$userJob' OR job='all' ";
    $stmt = mysqli_stmt_init( $conn);

    if( !mysqli_stmt_prepare($stmt, $sql) ){
        echo "error";
    }
    else{
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while( $row = mysqli_fetch_assoc( $result)){
            array_push($inputNames, $row['name']);
            //Instead I should use implode() function
            if( $row['type'] == "checkbox"){
                $array = $_POST[ $row['name']];
                if( empty( implode(",", $array)))
                    $strArray = "";
                else
                    $strArray = ",".implode(",", $array).",";
                array_push($inputValues, $strArray);
            }
            else if( $row['type'] == "number"){
                if( $_POST[ $row['name'] ] == "")
                    array_push($inputValues, NULL);
                else
                    array_push($inputValues, $_POST[ $row['name'] ]);
            }
            else{
                array_push($inputValues, $_POST[ $row['name'] ]);
            }
            array_push($dbNames, $row['dbName']);
            array_push($dbTypes, $row['dbType']);
            array_push($isRequired, $row['required']);
        }
    }

    //checking for empty fields
    for( $i = 0; $i < count($isRequired) ; $i++){
        if( $isRequired[$i] == "true" && ( $inputValues[$i + 4] == "" || $inputValues[$i + 4] == "none")){
            header("Location: ../addProfile.php?error=emptyfields&job=".$userJob );
            exit();
        }
    }//end of checking

    //Checking if user already has a profile
    $sql = "SELECT uid FROM users". $userJob ." WHERE uid=?";
    $stmt = mysqli_stmt_init($conn);
    if( !mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../addProfile.php?error=sqlerror1&job=".$userJob );
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt , "s", $userUid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultcheck = mysqli_stmt_num_rows($stmt);
        if( $resultcheck > 0){
            //creating sql statement updating profile information for having already an account
            $sql = "UPDATE `users". $userJob."` SET `uid`=?, `name`=?, `surname`=?,";
            for( $i = 0; $i < count($dbNames) - 1 ; $i++){
                $sql .= "`". $dbNames[$i] . '`= ?,';
            }
            $sql .= "`" . $dbNames[ count($dbNames) - 1] . "`=? WHERE `users". $userJob . "`.`uid`=?";

            //creating types of inputs
            $types = "sss";
            foreach( $dbTypes as $dbType){
                if( $dbType == "text" || $dbType == "tinytext" || $dbType == "date")
                    $types .= "s";
                else if ( $dbType == "int")
                    $types .= "i";
            }
            $types .= "s"; //end of types

            $sqlJobUpdate = "";
            unset($inputValues[3]); //remove true statement
            array_push($inputValues, $userUid);
        }
        else{
            //creating sql statement new profile
            $sql = "INSERT INTO users". $userJob. " (`uid`, `name`, `surname`, `active`, ";
            for( $i = 0; $i < count($dbNames) - 1 ; $i++){
                $sql .= '`' . $dbNames[$i] . '`,';
            }
            $sql .= '`'. $dbNames[ count($dbNames) - 1] . '`) VALUES (';
            for( $i = 0; $i < count($dbNames) ; $i++){
                $sql .= '?, ';
            }
            $sql .= "?, ?, ?, ?)"; //end of sql statement

            //creating types of inputs
            $types = "ssss";
            foreach( $dbTypes as $dbType){
                if( $dbType == "text" || $dbType == "tinytext" || $dbType == "date")
                    $types .= "s";
                else if ( $dbType == "int")
                    $types .= "i";
            }//end of types
            $sqlJobUpdate = "UPDATE `users` SET `jobUsers` = CONCAT(`jobUsers`,'".$userJob."_true,') WHERE `users`.`uidUsers` = '".$userUid."';";         
        }
    }

    $stmt = mysqli_stmt_init($conn);
    if( !mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../addProfile.php?error=sqlerror2&job=".$userJob);
        exit();
    }
    else{
        $stmt->bind_param($types, ...$inputValues);
        mysqli_stmt_execute($stmt);

        //Adding the job name in the users table to the user
        if($sqlJobUpdate != ""){
            $stmt = mysqli_stmt_init($conn);
            if( !mysqli_stmt_prepare($stmt, $sqlJobUpdate)){
                header("Location: ../addProfile.php?error=sqlerror3&job=".$userJob);
                exit();
            }
            else{
                mysqli_stmt_execute($stmt);
                header("Location: ../../editProfile.php?save=success");
                exit();
            }
        }
        header("Location: ../profile.php?uid=".$userUid."&job=".$userJob."&save=success");
        exit();
    }
        
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($conn);
}
else{
    header("Location: ../../editProfile.php");
    exit();
}