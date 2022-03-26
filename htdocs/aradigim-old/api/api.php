<?php
class api{
    function login($mailuid, $password, $successheader, $errorheader){
        global $conn;
        if( empty($mailuid) || empty($password)){
            $errorheader = $errorheader. "?error=emptyfields";
            header($errorheader);
            exit();
        }
        else{
            $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?";
            $stmt = mysqli_stmt_init( $conn);
    
            if( !mysqli_stmt_prepare($stmt, $sql) ){
                $errorheader = $errorheader. "?error=sqlerror";
                header($errorheader);
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "ss", $mailuid, $mailuid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if( $row = mysqli_fetch_assoc( $result)){
                    $pwdCheck = password_verify( $password, $row['pwdUsers']);
                    if( $pwdCheck == false){
                        $errorheader = $errorheader. "?error=wrongpwd";
                        header($errorheader);
                        exit();
                    }
                    else if( $pwdCheck == true){
                        session_start();
                        $_SESSION['name'] = $row['nameUsers'];
                        $_SESSION['surname'] = $row['surnameUsers'];
                        $_SESSION['userType'] = $row['typeUsers'];
                        $_SESSION['userUid'] = $row['uidUsers'];
                        
                        $successheader = $successheader . "?login=success";
                        header($successheader);
                        exit();
                    }
                    else{
                        $errorheader = $errorheader. "?error=wrongpwd";
                        header($errorheader);
                        exit();
                    }
            
                }
                else{
                    $errorheader = $errorheader. "?error=nouse";
                    header($errorheader);
                    exit();
                }
            }
        }
    }
}
?>