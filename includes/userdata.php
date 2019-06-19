<?php

function additionalStockBuy($email, $numToBuy, $symbol, $price) {
    require 'db.inc.php';

    $userId = getUserId($email);
    $currentStockQty = getStockQty($email, $symbol);
    $newStockQtyNum = $numToBuy + $currentStockQty;
    $totalCost = $numToBuy * $price;

    $sql = "UPDATE stocks SET qty = ".$newStockQtyNum." WHERE userId = ".$userId." AND symbol ='".$symbol."';";

    mysqli_query($connection, $sql);

    deductFromBalance($email, $numToBuy, $price);

    recordStockTrans($userId, 'B', $symbol, $numToBuy, $totalCost, $price);
}

function addMoney($userId, $amount){
    require 'db.inc.php';

    $sql = "INSERT INTO userBalance (userId, balance) VALUES (".$userId."," .$amount.");";

    mysqli_query($connection, $sql);

    recordMoneyTrans($userId, 'D', $amount);
}

function balancePurchaseCheck($email, $qty, $cost) {
    require 'db.inc.php';

    $moneyAvailable = getUserBalance($email);
    $buyPrice = $qty * $cost;
    $balanceStatus = "funding";

    if($buyPrice > $moneyAvailable) {
        $balanceStatus = "no funding";
    }

    return $balanceStatus;
}

function buyStock($userId, $email, $stockSymbol, $qty, $buyPrice) {
    require 'db.inc.php';

    $sql = "INSERT INTO stocks (userId, symbol, qty) VALUES (".$userId.", '".$stockSymbol."'," .$qty.");";

    mysqli_query($connection, $sql);

    deductFromBalance($email, $qty, $buyPrice);
    
    $totalCost = $qty * $buyPrice;
    recordStockTrans($userId, 'B', $stockSymbol, $qty, $totalCost, $buyPrice);
}

function deductFromBalance($email, $qty, $stockPrice) {
    require 'db.inc.php';

    $deductAmount = $qty * $stockPrice;
    $currentBalance = getUserBalance($email);
    $newBalance = $currentBalance - $deductAmount;
    $userId = getUserId($email);

    $sql = "UPDATE userBalance SET balance = ".$newBalance." WHERE userId = ".$userId.";";

    mysqli_query($connection, $sql);

    recordMoneyTrans($userId, 'P', $deductAmount);
}

function getStockQty($email, $symbol) {
    require 'db.inc.php';

    $userId = getUserId($email);

    $sql = "SELECT * FROM stocks WHERE userId =".$userId." AND symbol = '".$symbol."';";
    $result = mysqli_query($connection, $sql);
    $resultLength = mysqli_num_rows($result);
    // $currentStockCount = 0;

    if($resultLength > 0) {
        $resultRow = mysqli_fetch_assoc($result);
        return $currentStockCount = $resultRow['qty'];
    }

    // return $currentStockCount;
}

function getStockTrans($email) {
    require 'db.inc.php';

    $userId = getUserId($email);

    $sql = "SELECT * FROM stockTrans WHERE userId =".$userId." ORDER BY transDate DESC;";

    $result = mysqli_query($connection, $sql);
    $resultLength = mysqli_num_rows($result);

    if($resultLength > 0) {
        while($resultRow = mysqli_fetch_assoc($result)) {

            $data[] = $resultRow;
        }
        return $data;
    }
    
}

function getUserBalance($email) {
    require 'db.inc.php';

    $userId = getUserId($email);
    $balanceSql = "SELECT * FROM userBalance WHERE userId ='".$userId."';";
    $result = mysqli_query($connection, $balanceSql);
    $resultLength = mysqli_num_rows($result);

    if($resultLength > 0) {
        $resultRow = mysqli_fetch_assoc($result);
        return $resultRow['balance'];
    }
}

function getUserId($email) {
    require 'db.inc.php';

    $getIdSql = "SELECT * FROM users WHERE email ='".$email."';";
    $idResult = mysqli_query($connection, $getIdSql);
    $idResultLength = mysqli_num_rows($idResult);

    if($idResultLength > 0) {
        $idResultRow = mysqli_fetch_assoc($idResult);
        return $idResultRow['primeId'];
    }
}

function moneyAcctSetup($userId) {
    require 'db.inc.php';

    addMoney($userId, 5000.00);
}

function recordMoneyTrans($userId, $transType, $amount){
    require 'db.inc.php';
    //transType = 'D' for deposit & 'P' for purchase

    $sql = "INSERT INTO moneyTrans (userId, transType, amount) VALUES (".$userId.",'".$transType."',".$amount.");";

    mysqli_query($connection, $sql);
}

function recordStockTrans($userId, $transType, $symbol, $qty, $totalCost, $indivCost){
    require 'db.inc.php';
    //transType = 'B' for buy & 'S' for sell

    $sql = "INSERT INTO stockTrans (userId, transType, symbol, qty, totalCost, indivCost) VALUES (".$userId.",'".$transType."','".$symbol."'," .$qty.",".$totalCost.",".$indivCost.");";

    mysqli_query($connection, $sql); 
}

function stockOwnCheck($email, $symbol) {
    require 'db.inc.php';

    $userId = getUserId($email);
    $sql = "SELECT * FROM stocks WHERE userId ='".$userId."';";
    $result = mysqli_query($connection, $sql);
    $resultLength = mysqli_num_rows($result);
    $found = "false";

    if($resultLength > 0) {
        while($resultRow = mysqli_fetch_assoc($result)) {
            if($symbol == $resultRow['symbol']) {
                $found = "true";
                break;
            }
        }
    }

    return $found;
}

/*

SQL STATEMENT FOR REMOVAL

DELETE from table where id = id

//Multiple selections
SELECT * FROM table WHERE ID = id AND symbol = symbol

//update record SQL
UPDATE table SET contactname = value WHERE userId = 1



*/