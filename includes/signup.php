<?php
if(isset($_POST['register-submit'])) {
    require 'db.inc.php';

    $name = $_POST['register-name'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwd-confirm'];

    if(empty($name) || empty($email) || empty($pwd) || empty($pwdRepeat)){
        header("Location: ../index.php?error=emptyfields&register-name=".$name."&email=".$email);
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?error=invalidemail&register-name=".$name);
        exit();
    } else if ($pwd !== $pwdRepeat) {
        header("Location: ../index.php?error=pwdsnomatch&register-name=".$name."&email=".$email);
        exit();
    } else {
        $sql = "SELECT email from users WHERE email=?;";
        $stmt = mysqli_stmt_init($connection);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror1");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            mysqli_stmt_close($stmt);

            if($resultCheck > 0) {
                header("Location: ../index.php?error=usertaken&email=".$email);
                exit();
            } else {
                $sql = "INSERT INTO users (fullName, email, pwd) VALUES (?, ?, ?);";
                $stmt = mysqli_stmt_init($connection);

                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../index.php?error=sqlerror2");
                    exit();
                } else {
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../index.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
} else {
    header("Location: ../index.php");
    exit();
}