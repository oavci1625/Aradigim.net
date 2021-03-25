<?php
    if( isset( $_POST['search-submit'])){
        require "dbh.inc.php";
        $jobCode = $_POST['job'];
        //Getting job name
        $sql= "SELECT * FROM `jobcodes` WHERE code LIKE ? ";
        $stmt = mysqli_stmt_init( $conn);

        if( !mysqli_stmt_prepare($stmt, $sql) ){
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "s", $jobCode);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if( $row = mysqli_fetch_assoc( $result)){
                $jobName = $row['name'];
            }
        }//end of job name


        //Getting form inputs
        $formInputs = [];

        $sql= "SELECT * FROM `forminputs` WHERE job='$jobCode' OR job='all'";
        $stmt = mysqli_stmt_init( $conn);

        if( !mysqli_stmt_prepare($stmt, $sql) ){
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else{
            //select filters
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while( $row = mysqli_fetch_assoc( $result)){
                $keys = array_keys($row);
                array_push( $formInputs, $row);
            }
        }//end of form inputs

        //Finding Profiles
        $profiles = [];
        $profileCount = 0;

        $sql= "SELECT * FROM `users` WHERE jobUsers LIKE '%{$jobCode}_true%' ";
        $stmt = mysqli_stmt_init( $conn);

        if( !mysqli_stmt_prepare($stmt, $sql) ){
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while( $row = mysqli_fetch_assoc( $result)){
                array_push( $profiles, $row);
                $profileCount++;
            }
        }//end of finding profiles
    }
    else if( isset( $_POST['filtered-search-submit'])){
        require "dbh.inc.php";
        $jobCode = $_POST['job'];
        //Getting job name
        $sql= "SELECT * FROM `jobcodes` WHERE code LIKE ? ";
        $stmt = mysqli_stmt_init( $conn);

        if( !mysqli_stmt_prepare($stmt, $sql) ){
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "s", $jobCode);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if( $row = mysqli_fetch_assoc( $result)){
                $jobName = $row['name'];
            }
        }//end of job name

        //Getting form inputs
        $formInputs = [];

        $sql= "SELECT * FROM `forminputs` WHERE job='$jobCode' OR job='all'";
        $stmt = mysqli_stmt_init( $conn);

        if( !mysqli_stmt_prepare($stmt, $sql) ){
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else{
            //select filters
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while( $row = mysqli_fetch_assoc( $result)){
                $keys = array_keys($row);
                array_push( $formInputs, $row);
            }
        }//end of form inputs
        
        //Finding Profiles
        $filteringKeys = [];
        $filteringValues = [];
        $filteringTypes = [];
        foreach($_POST as $key => $value) //Geting selected filters' name and their values
        {
            if( $value != null && $key != "job"){
                array_push($filteringKeys, $key);
                array_push($filteringValues, $value);
            }
        }
        //CHECKING IF ANY KIND OF FILTERING IS DONE BY THE USER
        if( sizeof($filteringKeys) == 0){
            //Finding Profiles
            $profiles = [];
            $profileCount = 0;

            $sql= "SELECT * FROM `users` WHERE jobUsers LIKE '%{$jobCode}%'";
            $stmt = mysqli_stmt_init( $conn);

            if( !mysqli_stmt_prepare($stmt, $sql) ){
                header("Location: index.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while( $row = mysqli_fetch_assoc( $result)){
                    array_push( $profiles, $row);
                    $profileCount++;
                }
            }//end of finding profiles
        }
        else{
            foreach ($filteringKeys as $filteringKey) { //storing types of those filters in an array
                //First check if it is a number input
                $maxStr = "-max";
                $minStr = "-min";
                if( strpos($filteringKey, $minStr) || strpos($filteringKey, $maxStr) ){
                    array_push($filteringTypes, 'number');
                }
                else{
                    for ($i=0; $i < sizeof( $formInputs); $i++) { 
                        if( $formInputs[$i]['dbName'] == $filteringKey){
                            $filteringType = $formInputs[$i]['type'];
                            break;
                        }
                    }
                    array_push($filteringTypes, $filteringType);
                }
            }

            //Filtering all those featrues from users.job table and storing their usernames in the array called filteredUids
            $filteredUids = [];
            $jobTableName = 'users'.$jobCode;
            $sql= "SELECT * FROM $jobTableName WHERE ";
            for ($i=0; $i < sizeof($filteringKeys); $i++) {
                //ALL CLAUSES EXCEPT LAST ONE
                if( sizeof($filteringKeys) - $i > 1){
                    if( $filteringTypes[$i] == "select" || $filteringTypes[$i] == "radio"){
                        $sql .= $filteringKeys[$i] . "='" . $filteringValues[$i] . "' AND ";
                    }
                    else if( $filteringTypes[$i] == "checkbox"){
                        for ($j=0; $j < sizeof( $filteringValues[$i]); $j++) { 
                            $sql .= $filteringKeys[$i] . " LIKE '%," .$filteringValues[$i][$j]. ",%' AND ";
                        }
                    }
                    else if( $filteringTypes[$i] == "number"){
                        if( explode("-",$filteringKeys[$i])[1] == "min"){
                            $sql .= explode("-",$filteringKeys[$i])[0] . ">". $filteringValues[$i] . " AND ";
                        }
                        else if( explode("-",$filteringKeys[$i])[1] == "max"){
                            $sql .= explode("-",$filteringKeys[$i])[0] . "<". $filteringValues[$i] . " AND ";
                        }
                    }
                }
                //LAST CLAUSE WITHOUT AN AND AT THE END
                else{
                    if( $filteringTypes[$i] == "select" || $filteringTypes[$i] == "radio"){
                        $sql .= $filteringKeys[$i] . "='" . $filteringValues[$i] . "'";
                    }
                    else if( $filteringTypes[$i] == "checkbox"){
                        for ($j=0; $j < sizeof( $filteringValues[$i]) - 1; $j++) { 
                            $sql .= $filteringKeys[$i] . " LIKE '%" .$filteringValues[$i][$j]. "%' AND ";
                        }
                        $sql .= $filteringKeys[$i] . " LIKE '%" .$filteringValues[$i][$j]. "%'";
                    }
                    else if( $filteringTypes[$i] == "number"){
                        if( explode("-",$filteringKeys[$i])[1] == "min"){
                            $sql .= explode("-",$filteringKeys[$i])[0] . ">". $filteringValues[$i];
                        }
                        else if( explode("-",$filteringKeys[$i])[1] == "max"){
                            $sql .= explode("-",$filteringKeys[$i])[0] . "<". $filteringValues[$i];
                        }
                    }
                }
            }
            $stmt = mysqli_stmt_init( $conn);
            if( !mysqli_stmt_prepare($stmt, $sql) ){
                header("Location: index.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while( $row = mysqli_fetch_assoc( $result)){
                    array_push( $filteredUids, $row['uid']);
                }
            }//end of finding filtered usernames


            //Time to use filtered usernames to find users in users table and add them to the profiles[] array
            $profiles = [];
            $profileCount = 0;

            if( sizeof($filteredUids) > 0){
                $sql= "SELECT * FROM `users` WHERE jobUsers LIKE '%{$jobCode}%' AND (";
                for ($i=0; $i < sizeof($filteredUids) - 1; $i++) { 
                    $sql .= "uidUsers='" . $filteredUids[$i] . "' OR ";
                }
                $sql .= "uidUsers='" . $filteredUids[$i] . "')";
                $stmt = mysqli_stmt_init( $conn);
        
                if( !mysqli_stmt_prepare($stmt, $sql) ){
                    header("Location: index.php?error=sqlerror");
                    exit();
                }
                else{
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while( $row = mysqli_fetch_assoc( $result)){
                        array_push( $profiles, $row);
                        $profileCount++;
                    }
                }//end of finding profiles
            }
        }
    }
    else{
        header("Location: index.php");
        exit();
    }
?>