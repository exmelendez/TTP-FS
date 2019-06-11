<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>IEX Stocks</title>
        
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <script src="https://kit.fontawesome.com/2e0e252e85.js"></script>
    </head>
    <body>
        <header>
            <a class="header-space green-text hover-yellow" href="portfolio.html">Portfolio</a>
            <span class="header-space">|</span>
            <a class="header-space red-text hover-yellow" href="transactions.html">Transactions</a>
            <a class="header-space hover-yellow logout-btn" href="#"><i title="Signout" class="fas fa-ban"></i></a>
        </header>