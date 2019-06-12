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
            <form id="login-form" action="includes/login.php" method="post">

                <input class="register-info" name="register-name" type="text" placeholder="Full Name">

                <input name="email" type="email" placeholder="Email">

                <input type="password" name="pwd" placeholder="Password">
                <input class="register-info" name="pwd-confirm" type="password" placeholder="Confirm Password">

                <input id="login-submit" class="login-info" name="login-submit" type="submit" value="Login">
                <input id="register-submit" class="register-info" name="register-submit" type="submit" value="Register">
            </form>

            <P class="login-info">
            Not a member? It's free to <a id="register-btn" href="#">register</a>.
            </P>

            <P class="register-info">
            Already a member? Click to <a id="login-btn" href="#">login</a>.
            </P>
        </div>

        <?php
            error_reporting(0);
            if(isset($_GET['error'])) {
                if($_GET['error'] == "emptyfields") {
                    echo '<p class="login-signup-msg">Fill in all fields!</p>';
                } else if($_GET['error'] == "invalidemail") {
                    echo '<p class="login-signup-msg">Invalid email!</p>';
                } else if($_GET['error'] == "pwdsnomatch") {
                    echo '<p class="login-signup-msg">Passwords do not match!</p>';
                } else if($_GET['error'] == "sqlerror") {
                    echo '<p class="login-signup-msg">db connection error!</p>';
                } else if($_GET['error'] == "usertaken") {
                    echo '<p class="login-signup-msg">Email already in system!</p>';
                }
            } else if($_GET['signup'] == "success") {   
                echo '<p class="login-signup-msg">Signup successful, you may now login!</p>';
            }
        ?>
        
        <script src="js/login.js"></script>

<?php
    require "includes/footer.php";
?>