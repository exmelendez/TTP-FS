<?php

if(isset($_POST['symbol-search-btn'])) {
    require 'api.stockinfo.php';
    $userEmail = $_POST['user-email'];
    $symbolInput = $_POST['symbol-search-input'];

    if(empty($symbolInput)){
        header("Location: ../portfolio.php?error=emptyfield");
        exit();
    } else {
        strtoupper($symbolInput);
        $statusMsg = getStockData($symbolInput, "exist");

        if($statusMsg == "found") {
            $symbol = getStockData($symbolInput, "symbol");
            $price = getStockData($symbolInput, "cost");

            header("Location: ../portfolio.php?symbolsearch=success&symbol=".$symbol."&price=".$price);
            exit();
        } else {
            header("Location: ../portfolio.php?error=symbolnotfound");
        exit();
        }
    }
}