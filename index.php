<?php

    $dirPre = 'classes/';
    $dirPost = '.class.php';
    $indexPage = "index.php";
    $mainPage = "portfolio.php";

    include $dirPre . 'db' . $dirPost;
    include $dirPre . 'sql' . $dirPost;
    include $dirPre . 'user' . $dirPost;
    session_start();

    if(isset($_POST['login-submit'])) {
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];

        if(empty($email) || empty($pwd)) {
            header("Location: ". $indexPage ."?type=login&error=emptyfields&email=".$email);
            exit();

        } else {

            $user = new User();
            $loginStats = $user -> verifyAcct($email, $pwd);

            if($loginStats['acctPwdValid']) {
                session_start();
                $_SESSION['userId'] = $loginStats['userId'];
                $_SESSION['fName'] = $loginStats['fName'];

                header("location: " . $mainPage);
                exit();

            } else {
                header("Location: ". $indexPage ."?type=login&error=invalidpwd&email=".$email);
                exit();
            }
        }
        
    } else if(isset($_POST['register-submit'])) {

        $firstName = strtolower($_POST['fname']);
        $lastName = strtolower($_POST['lname']);
        $email = strtolower($_POST['email']);
        $pwd = $_POST['pwd'];
        $pwdConf = $_POST['pwd-conf'];

        if(empty($firstName) || empty($lastName) || empty($email) || empty($pwd) || empty($pwdConf)) {
            header("Location: ". $indexPage ."?type=register&error=emptyfields&fname=".$firstName."&lname=".$lastName."&email=".$email);
            exit();

        } else {
            if($pwd == $pwdConf) {
                $user = new User();
                $acctCreated = $user -> createAcct($firstName, $lastName, $email, $pwd);
    
                if($acctCreated) {
                    header("Location: ". $indexPage ."?type=login&status=acctcrtd");
                    exit();
                } else {
                    header("Location: ". $indexPage ."?type=register&error=acctdup&fname=".$firstName."&lname=".$lastName."&email=".$email);
                    exit();
                }

            } else {
                header("Location: ". $indexPage ."?type=register&error=pwdmismatch&fname=".$firstName."&lname=".$lastName."&email=".$email);
                exit();
            }
        }

    } else if(isset($_SESSION['userId'])) {
        header("location: " . $mainPage);
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Cache-control" content="no-cache">
        <title>IEX Login</title>
        <link type="text/css" rel="stylesheet" href="css/style.css">
    </head>
    <body id="login-body">

    <div id="login-box">
        <h1 class="login-info">IEX Trading Login</h1>
        <h1 class="register-info">IEX Trading Register</h1>
        <form action="<?php $indexPage ?>" method="post">

            <input class="register-info" name="fname" type="text" value="<?php if(isset($_GET["fname"])){echo htmlentities($_GET['fname']);} ?>" placeholder="First Name">
            <input class="register-info" name="lname" type="text" value="<?php if(isset($_GET["lname"])){echo htmlentities($_GET['lname']);} ?>" placeholder="Last Name">

            <input name="email" type="email" value="<?php if(isset($_GET["email"])){echo htmlentities($_GET['email']);} ?>" placeholder="Email">

            <input id="pwd-field" type="password" name="pwd" placeholder="Password">
            <input id="pwd-conf-field" class="register-info" name="pwd-conf" type="password" placeholder="Confirm Password">

            <input id="form-submit" type="submit" class="login-info" name="login-submit"  value="Login">
           
        </form>

        <P class="login-info">
        Not a member? It&#39;s free to <a id="register-btn" href="#">register</a>.
        </P>

        <P class="register-info">
        Already a member? Click to <a id="login-btn" href="#">login</a>.
        </P>
    </div>

        <?php
            if(isset($_GET['error'])) {
                if($_GET['error'] == "emptyfields") {
                    echo '<p class="login-signup-msg">One or more required fields empty!</p>';
                } else if($_GET['error'] == "invalidpwd") {
                    echo '<p class="login-signup-msg">Invalid Email or Password!</p>';
                } else if($_GET['error'] == "acctdup") {
                    echo '<p class="login-signup-msg">User with this email already exists!</p>';
                } else if($_GET['error'] == "pwdmismatch") {
                    echo '<p class="login-signup-msg">Passwords do match one another!</p>';
                }
            } else if(isset($_GET['status'])) { 
                
                if($_GET['status'] == "acctcrtd") {
                    echo '<p class="login-signup-msg" style="color: #00DE00">Signup successful, you may now login!</p>';
                }
            }
        ?>
        
        <script src="js/login.js"></script>

<?php
    require "includes/footer.php";
?>