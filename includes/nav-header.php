<?php
    session_start();
    /******
     * COMMENT BACK FOR FINAL PRODUCT
     */
    // error_reporting(0);

    if(!$_SESSION['userEmail']) {
        header("Location: index.php");
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
        <title>IEX Stocks</title>
        
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <script src="https://kit.fontawesome.com/2e0e252e85.js"></script>
    </head>
    <body>
        <header>
            <a class="header-space green-text hover-yellow" href="portfolio.php">Portfolio</a>
            <span class="header-space">|</span>
            <a class="header-space red-text hover-yellow" href="transactions.php">Transactions</a>
           
            <form id="logout-form" action="includes/logout.php">
                <label for="logout-btn">
                    <i title="Signout" class="fas fa-ban"></i>
                </label>
                <input id="logout-btn" type="submit"/>
            </form>
        </header>