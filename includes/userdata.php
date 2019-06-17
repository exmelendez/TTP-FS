<?php

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

function getUserBalance($email) {
    require 'db.inc.php';

    $userId = getUserId($email);
    $getBalanceSql = "SELECT * FROM moneyAcct WHERE userId ='".$userId."';";
    $balanceResult = mysqli_query($connection, $getBalanceSql);
    $balanceResultLength = mysqli_num_rows($balanceResult);

    if($balanceResultLength > 0) {
        $balanceResultRow = mysqli_fetch_assoc($balanceResult);
        return $balanceResultRow['balance'];
    }
}