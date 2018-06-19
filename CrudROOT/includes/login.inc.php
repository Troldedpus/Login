<?php

session_start();

if (isset($_POST['submit'])) {
 
    include 'dbh.inc.php';
    
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    
        /* tjekker for fejlen empty */ 
        if (empty($uid) || empty($pwd)) {
            header("Location: ../index.php?login=bruger");
            exit();
        
    } else {
            $sql = "SELECT * FROM users WHERE user_uid='$uid'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck < 1){
               /* giver fejlkoden error1 hvis username er forkert */
                header("Location: ../index.php?login=error1");
                exit();
            } else {
                if ($row = mysqli_fetch_assoc($result)) {
                    /* det hashed password skal laves om så vi kan se om det matcher */
                    $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                    if ($hashedPwdCheck == false) {
                        header("Location: ../index.php?login=error2");
                        exit();
                    } elseif ($hashedPwdCheck == true) {
                       /* logger brugeren ind */
                        $_SESSION['u_id'] = $row['user_id'];
                        $_SESSION['u_first'] = $row['user_first'];
                        $_SESSION['u_last'] = $row['user_last'];
                        $_SESSION['u_email'] = $row['user_email'];
                        $_SESSION['u_uid'] = $row['user_uid'];
                        header("Location: ../index.php?login=login?succes");
                        exit();
                    }
                }
            }
        }
    
    } else {
    header("Location: ../index.php?login=error");
    exit();
   }
