<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>IEX Login</title>
        <link type="text/css" rel="stylesheet" href="css/style.css">
    </head>
    <body id="login-body">
        <div id="login-box">
            <h1 class="login-info">IEX Trading Login</h1>
            <h1 class="register-info">IEX Trading Register</h1>

            <input class="register-info" name="register-name" type="text" placeholder="Full Name">

            <input class="login-info" name="login-email" type="email" placeholder="Email">
            <input class="register-info" name="register-email" type="email" placeholder="Email">

            <input class="login-info" type="password" name="login-pwd" placeholder="Password">
            <input class="register-info" name="register-pwd1" type="password" placeholder="Password">
            <input class="register-info" name="register-pwd2" type="password" placeholder="Confirm Password">

            <input id="login-submit" class="login-info" name="login-submit" type="submit" value="Login">
            <input id="register-submit" class="register-info" name="register-submit" type="submit" value="Register">

            <P class="login-info">
            Not a member? It's free to <a id="register-btn" href="#">register</a>.
            </P>

            <P class="register-info">
            Already a member? Click to <a id="login-btn" href="#">login</a>.
            </P>
        </div>
        <script src="js/login.js"></script>

<?php
    require "includes/footer.php";
?>