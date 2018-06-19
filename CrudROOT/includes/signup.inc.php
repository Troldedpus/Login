<?php

if (isset($_POST['submit'])) {
   
    include_once 'dbh.inc.php'; 
    /* linker mit connect kode */ 
    
    /* hvis mysli_real_escape_string ikke var med, kan man bruge tekstfeltet til at indsætte kode/blocker farlige tegn før de bliver sendt til DB */
    $first = mysqli_real_escape_string($conn, $_POST['first']);
    $last = mysqli_real_escape_string($conn, $_POST['last']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    
    /* hvis de ikke udfylder alle felter, og giver fejlkoden empty */
    if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd)) {
        header("Location: ../signup.php?signup=empty");
        exit();
    } else {
        /* tjekker hvis man kan bruge brugte tegn, og giver fejlkoden invalid, med "!" foran tjekker den om der er brugte tegn udover a-z */ 
        if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
        header("Location: ../signup.php?signup=invalid");
        exit();    
        } else {
            /* tjekker om emailen kan bruges, validate=ingen weird mails */ 
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                header("Location: ../signup.php?signup=email");
                exit(); 
        } else {
            /* tjekker om username er i brug */
            $sql = "SELECT * FROM users WHERE user_uid='$uid'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            
            /* hvis username er i brug, giver den fejlkoden usertaken */
            if ($resultCheck > 0) {
                header("Location: ../signup.php?signup=usertaken");
                exit(); 
         
        } else {
            /* hashing+laver det om, så andre ikke kan læse det */
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
            
            /* får brugeren ind i databasen og tager dig tilbage til signup siden, med msg succes */
            $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$hashedPwd');";
            $result = mysqli_query($conn, $sql);
            header("Location: ../signup.php?signup=Succes");
                exit(); 
                }
            }
        }
    }
} else {
    header("Location: ../signup.php");
    exit();
} 