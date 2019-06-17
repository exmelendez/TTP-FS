<?php

if(isset($_POST['symbol-search-btn'])) {
    /*
    require 'api.stockinfo.php';
    $symbolInput = $_POST['symbol-search-input'];

    if(empty($symbolInput)){
        header("Location: ../port2.php?error=emptyfield");
        exit();
    } else {
        strtoupper($symbolInput);
        $statusMsg = getStockData($symbolInput, "exist");

        if($statusMsg == "found") {
            $symbol = getStockData($symbolInput, "symbol");
            $price = getStockData($symbolInput, "cost");

            header("Location: ../port2.php?symbolsearch=success&symbol=".$symbol."&price=".$price);
            exit();
        } else {
            header("Location: ../port2.php?error=symbolnotfound");
        exit();
        }
    }
    */
} else if(isset($_POST['cancelBuyBtn'])) {
    header("Location: ../port2.php");
        exit();
}