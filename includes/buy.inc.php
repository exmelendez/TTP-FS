<?php
    session_start();

if(isset($_POST['buyBtn'])){

    $searchSymbol = strtoupper($_POST['symbol']);

    if(empty($searchSymbol)){
        header("Location: ../buy.php?error=emptyfields");
        exit();
    } else if (!symbolExists($searchSymbol)) {
        header("Location: ../buy.php?error=symbolnotfound");
        exit();
    } else {
    getBalance();

        header("Location: ../buy.php?process=success&email=".$_SESSION['userEmail']);
        exit();
    } 
}
else {

    header("Location: ../buy.php");
    exit();
}

function symbolExists($input) {
    $content = file_get_contents("https://api.iextrading.com/1.0/ref-data/symbols");
    $data = json_decode($content, true);
    $symbolFound = false;
    
    foreach($data as $stock) {
        if($stock['symbol'] == $input){
            $symbolFound = true;
            break;
        }
    }
    return $symbolFound;
}

function getBalance() {
    echo $_SESSION['userEmail'];
}
