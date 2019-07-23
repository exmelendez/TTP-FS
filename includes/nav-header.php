<?php
   $dirPre = 'classes/';
   $dirPost = '.class.php';

   include $dirPre . 'db' . $dirPost;
   include $dirPre . 'sql' . $dirPost;
   include $dirPre . 'user' . $dirPost;

    $indexPage = "index.php";

    session_start();

    if(!$_SESSION['userId']) {
        header("Location: " . $indexPage);
        exit();
    }
    
    $user = new User();
    $user->loginProcess($_SESSION['userId']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Cache-control" content="no-cache">
        <title>IEX Stocks</title>
        
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <script src="https://kit.fontawesome.com/2e0e252e85.js"></script>
    </head>
    <body>
        <header>

            <div id="header-left" class="header-sides">
                <span id="profile-btn" style="margin-left: 0.5em;">
                    <i class="fas fa-user" style="color:yellow;"></i>
                    <?php
                        echo ucfirst($_SESSION['fName']);
                    ?>
                </span>
            </div>

            <div id="header-middle" class="logo-name">
                <span style="color: white;">IEX Trading</span>
            </div>

            <div id="header-right" class="header-sides">
                <a class="header-space green-text hover-yellow" href="portfolio.php">Portfolio</a>
                <span class="header-space">|</span>
                <a class="header-space red-text hover-yellow" href="transactions.php">Transactions</a>

                <form id="logout-form" action="includes/logout.php">
                    <label for="logout-btn">
                        <i title="Signout" class="fas fa-ban"></i>
                    </label>
                    <input id="logout-btn" name="logout-btn" type="submit"/>
                </form>
            </div>
        </header>