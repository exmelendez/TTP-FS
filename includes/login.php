<?php
if (isset($_POST['login-submit'])) {
    require 'db.inc.php';
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    if(empty($email) || empty($pwd)) {
        header("Location: ../index.php?error=emptyfields");
        exit();        
    } else {
        $sql = "SELECT * FROM users WHERE email=?;";
        $stmt = mysqli_stmt_init($connection);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($pwd, $row['pwd']);
               
                if($pwdCheck == false) {
                    header("Location: ../index.php?error=invalidpwd");
                    exit();
                } else if($pwdCheck == true) {
                    session_start();
                    $_SESSION['userEmail'] = $row['email'];
                    header("Location: ../portfolio.php?login=success");
                    exit();
                } else {
                    header("Location: ../index.php?error=invalidpwd");
                    exit();
                }
            } else {
                header("Location: ../index.php?error=nouser");
                exit();
            }
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}