<?php
    require 'dbh.inc.php';
    $username = $_GET['uid'];
    $userJob = $_GET['job'];

    //Getting job name
    $sql= "SELECT * FROM `jobcodes` WHERE code LIKE ? ";
    $stmt = mysqli_stmt_init( $conn);

    if( !mysqli_stmt_prepare($stmt, $sql) ){
        header("Location: index.php?error=sqlerror");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s", $_GET['job']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if( $row = mysqli_fetch_assoc( $result)){
            $jobName = $row['name'];
        }
    }//end of job name

    $sql = "SELECT * FROM users WHERE uidUsers=?";
    $stmt = mysqli_stmt_init( $conn);

    if( !mysqli_stmt_prepare($stmt, $sql) ){
        echo "error";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if( $row = mysqli_fetch_assoc( $result)){
            if($row['typeUsers'] != "eleman"){
                header("Location: index.php?error=noprofile");
            }
            $falseCheck = $userJob."_false,";
            if(strpos($row['jobUsers'], $falseCheck ) !== false && $username != $_SESSION['userUid']){
                header("Location: index.php?profile=hidden");
            }
            $name = $row['nameUsers'];
            $surname = $row['surnameUsers'];
            $image = $row['imageUsers'];
        }
        else{
            if (isset($_POST["profile-page-submit"]))
                header("Location: editProfile.php?error=noprofile");
            else
                header("Location: index.php?error=noprofile");
            exit();
        }
    }

    $profileQuestions = [];
    $dbNames = [];
    $sql = "SELECT * FROM formInputs WHERE job='$userJob' OR job='all' ";
    $stmt = mysqli_stmt_init( $conn);

    if( !mysqli_stmt_prepare($stmt, $sql) ){
        echo "error";
    }
    else{
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while( $row = mysqli_fetch_assoc( $result)){
            array_push($profileQuestions, $row['profileQuestion']);
            array_push($dbNames, $row['dbName']);
        }
    
    }

    $sql = "SELECT * FROM users$userJob WHERE uid=?";
    $stmt = mysqli_stmt_init( $conn);

    if( !mysqli_stmt_prepare($stmt, $sql) ){
        echo "error";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if( $row = mysqli_fetch_assoc( $result)){
            $values = [];
            for ($i=0; $i < count($dbNames); $i++) { 
                array_push($values, $row[$dbNames[$i]]);
            }
        }
        else{
            if (isset($_POST["profile-page-submit"]))
                header("Location: editProfile.php?error=noprofile");
            else
                header("Location: index.php?error=noprofile");
            exit();
        }
        
    }

?>