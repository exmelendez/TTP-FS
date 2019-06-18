<?php

if(isset($_POST['buyBtn'])) {
    require 'api.stockinfo.php';

    $userEmail = $_POST['user-email'];
    $symbol = $_POST['stock-symbol'];
    $price = $_POST['stock-price'];
    $qty = $_POST['stock-qty'];

    if(getStockData($symbol, "exist") == "found") {
        require 'userdata.php';
        $userId = getUserId($userEmail);
        $stockOwned = stockOwnCheck($userEmail, $symbol);

        if(balancePurchaseCheck($userEmail, $qty, $price) == "funding") {

            if($stockOwned == "false") {
                buyStock($userId, $userEmail, $symbol, $qty, $price);
                header("Location: ../portfolio.php?purchase=success");
                exit();
            } else if($stockOwned == "true") {
                additionalStockBuy($userEmail, $qty, $symbol, $price);
                
                header("Location: ../portfolio.php?purchase=success");
                exit();
            }

        } else if(balancePurchaseCheck($userEmail, $qty, $price) == "no funding") {
            header("Location: ../portfolio.php?error=unavailablefunds");
            exit();
        }

    } else {
        header("Location: ../portfolio.php?error=symbolnotfound");
        exit();
    }

} else if(isset($_POST['cancelBuyBtn'])) {
    header("Location: ../portfolio.php");
    exit();
}