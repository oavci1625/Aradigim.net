<?php
    require "navigator.php";

    if( !isset( $_SESSION['userUid'])){
       header("Location: ../editProfile.php");                 
    }
    else{
        require 'includes/dbh.inc.php';
        if(isset($_GET['job'])){
            $userJob = $_GET['job'];
        }
        else if($_POST['job'] != ""){
            $userJob = $_POST['job'];
        }
        else{
            header("Location: ../editProfile.php?error=nojob");    
        }
        $userUid = $_SESSION['userUid'];

        //First we will check if user has a profile with that job
        $sql = "SELECT * FROM users WHERE uidUsers = '". $userUid."'";
        $stmt = mysqli_stmt_init( $conn);
        if( !mysqli_stmt_prepare($stmt, $sql) ){
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if( $row = mysqli_fetch_assoc( $result)){
                $userJobs = $row['jobUsers'];
            }
            else{
                header("Location: index.php?error=nouser");
            }
        }
        if( strpos($userJobs, $userJob."_true,") !== false || strpos($userJobs, $userJob."_false,") !== false){
            $newAccout = false;
        }
        else{
            $newAccout = true;
        }//end of finding if new account or not

        //Now we will get values if an account already exist
        if(!$newAccout){
            $sql = "SELECT * FROM users$userJob WHERE uid='".$userUid."'";
            $stmt = mysqli_stmt_init( $conn);
            if( !mysqli_stmt_prepare($stmt, $sql) ){
                header("Location: index.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if( $row = mysqli_fetch_assoc( $result)){
                    $userInfo = $row;
                }
                else{
                    header("Location: index.php?error=nouser");
                }
            }
        }

        $spStartIndex = 9;

        //Getting job name
        $sql= "SELECT * FROM `jobcodes` WHERE code LIKE ? ";
        $stmt = mysqli_stmt_init( $conn);

        if( !mysqli_stmt_prepare($stmt, $sql) ){
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "s", $userJob);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if( $row = mysqli_fetch_assoc( $result)){
                $jobName = $row['name'];
            }
            else{
                header("Location: index.php?error=snojobcode");
            }
        }//end of job name
            
        $sql = "SELECT * FROM formInputs WHERE job='$userJob' OR job='all' ";
        $stmt = mysqli_stmt_init( $conn);

        if( !mysqli_stmt_prepare($stmt, $sql) ){
            echo "error";
        }
        else{

            //Basics
            echo '<body class="bg-dark">';
            echo '<main>';
            echo '<div class="container-fluid">';
            if($newAccout)
                echo '<h3 class="text-center text-light p-3">Profil Ekle / '. $jobName .'</h3>';
            else
                echo '<h3 class="text-center text-light p-3">Profili Düzenle / '. $jobName .'</h3>';
            echo '<div class="row">';
            echo '<div class="col-md-3"></div>';
            echo '<div class="col-md-6">';
            echo '<form action="includes/addProfile.inc.php" method="post" class="bg-secondary" style="padding:40px; border-radius:25px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">';
            echo '<input type="hidden" name="jobAdd" value="'.$userJob.'"/>';

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while( $row = mysqli_fetch_assoc( $result)){
                $keys = array_keys($row);

                //Radio input
                if( $row['type'] == "radio"){
                    echo '<div class="form-group row">';
                    echo '<label class="col-sm-3 col-form-label">'.$row['formQuestion'].'</label>';
                    $index = $spStartIndex;
                    echo '<div class="col-sm-9">';
                    while( isset($row[ $keys[$index]]) ){
                        echo '<div class="form-check">';
                        if( $newAccout){
                            if($row[ $keys[$index + 2]] == "true")
                                echo '<input type="radio" class="form-check-input" name="'. $row['name'] .'" value="' . $row[ $keys[$index + 1]] . '" checked> ';
                            else
                                echo '<input type="radio" class="form-check-input" name="'. $row['name'] .'" value="' . $row[ $keys[$index + 1]] . '"> ';
                        }
                        else{
                            if( $userInfo[$row['dbName']] == $row[ $keys[$index + 1]])
                                echo '<input type="radio" class="form-check-input" name="'. $row['name'] .'" value="' . $row[ $keys[$index + 1]] . '" checked> ';
                            else
                                echo '<input type="radio" class="form-check-input" name="'. $row['name'] .'" value="' . $row[ $keys[$index + 1]] . '"> ';
                        }
                        echo '<label class="form-check-label">'. $row[ $keys[$index]] .'</label>';
                        echo '</div>';
                        $index += 3;
                    }
                    echo '</div>';
                    echo '</div>';
                }

                //Date input
                if( $row['type'] == "date"){
                    echo '<div class="form-group row">';
                    echo '<label class="col-sm-3 col-form-label">'.$row['formQuestion'].'</label>';
                    echo '<div class="col-sm-9">';
                    if($newAccout)
                        echo '<input class="form-control" type="date" name="'. $row['name'] .'" value="'. $row['sp1'] .'" min="'. $row['sp2'] .'" max="'. $row['sp3'] .'">';
                    else
                        echo '<input class="form-control" type="date" name="'. $row['name'] .'" value="'. $userInfo[$row['dbName']] .'" min="'. $row['sp2'] .'" max="'. $row['sp3'] .'">';
                    echo '</div>';
                    echo '</div>';
                }

                //Select input
                if( $row['type'] == "select"){
                    echo '<div class="form-group row">';
                    echo '<label class="col-sm-3 col-form-label">'.$row['formQuestion'].'</label>';
                    echo '<div class="col-sm-9">';
                    echo '<select class="form-control" name="'. $row['name'] .'">';
                    $index = $spStartIndex;
                    while( isset($row[ $keys[$index]]) ){
                        if($newAccout || $userInfo[$row['dbName']] !== $row[ $keys[$index]])
                            echo '<option value ="'. $row[ $keys[$index]].'">'. $row[ $keys[$index + 1]] .'</option>';
                        else{
                            echo '<option value ="'. $row[ $keys[$index]].'" selected>'. $row[ $keys[$index + 1]] .'</option>';
                        }
                        $index += 2;
                    }
                    echo '</select>';
                    echo '</div>';
                    echo '</div>';
                }

                //Number input
                if( $row['type'] == "number"){
                    echo '<div class="form-group row">';
                    echo '<label class="col-sm-3 col-form-label">'.$row['formQuestion'].'</label>';
                    echo '<div class="col-sm-9">';
                    if($newAccout)
                        echo '<input class="form-control" type="number" name="'. $row['name'] .'" min="'. $row['sp1'] .'" max="'. $row['sp2'] .'">';
                    else
                        echo '<input class="form-control" type="number" name="'. $row['name'] .'" min="'. $row['sp1'] .'" max="'. $row['sp2'] .'" value='.$userInfo[$row['dbName']].'>';
                    echo '</div>';
                    echo '</div>';
                }

                //Textarea input
                if( $row['type'] == "textarea"){
                    echo '<div class="form-group row">';
                    echo'<label class="col-sm-3 col-form-label">'. $row['formQuestion'] .'</label>';
                    echo '<div class="col-sm-9">';
                    if($newAccout)
                        echo'<textarea class="form-control" name="'. $row['name'] .'" rows="'. $row['sp1'] .'" cols="'. $row['sp2'] .'" maxlength="'. $row['sp3'] .'" placeholder = "'. $row['sp4'] .'"></textarea>';
                    else
                        echo'<textarea class="form-control" name="'. $row['name'] .'" rows="'. $row['sp1'] .'" cols="'. $row['sp2'] .'" maxlength="'. $row['sp3'] .'" placeholder = "'. $row['sp4'] .'">'.$userInfo[$row['dbName']].'</textarea>';            
                    echo '</div>';
                    echo '</div>';
                }

                //Checkbox input
                if( $row['type'] == "checkbox"){
                    echo '<div class="form-group row">';
                    echo '<label class="col-sm-3 col-form-label">'.$row['formQuestion'].'</label>';
                    $index = $spStartIndex;
                    echo '<div class="col-sm-9">';
                    while( isset($row[ $keys[$index]]) ){
                        echo '<div class="form-check">';
                        if($newAccout)
                            echo'<input class="form-check-input" type="checkbox" name="'. $row['name'] .'[]" value ="'. $row[ $keys[$index]] .'">';
                        else{
                            if( strpos( $userInfo[$row['dbName']], ",".$row[ $keys[$index]].",") !== false)
                                echo'<input class="form-check-input" type="checkbox" name="'. $row['name'] .'[]" value ="'. $row[ $keys[$index]] .'" checked>';
                            else
                                echo'<input class="form-check-input" type="checkbox" name="'. $row['name'] .'[]" value ="'. $row[ $keys[$index]] .'">';
                        }
                        echo '<label class="form-check-label">'. $row[ $keys[$index]].'</label>';
                        echo '</div>';
                        $index += 1;
                    }
                    echo '</div>';
                    echo '</div>';
                }
            }

            //Submit button
            echo '<div class="row justify-content-md-center">';
            echo '<button class="btn btn-lg btn-primary" type="submit" name="add-profile-submit" class="edit-profile-save-button">Kaydet</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '<div class="col-md-3"></div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<hr>';
            echo '</div>';
            echo '</div>';
            echo '</main>';
            echo '</body>';
        }
    }
    require "footer.php"
?>

</html>


