<?php
if(isset($_POST['buyBtn'])){

    $searchInput = $_POST['symbol'];
    $searchSymbol = strtoupper($searchInput);

    if(empty($searchSymbol)){
        header("Location: ../buy.php?error=emptyfields");
        exit();
    } else if (!symbolExists($searchSymbol)) {
        header("Location: ../buy.php?error=symbolnotfound");
        exit();
    } else {
        header("Location: ../buy.php?process=success");
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
    $bool = false;
    
    foreach($data as $stock) {
        if($stock['symbol'] == $input){
            $bool = true;
            break;
        }
    }
    return $bool;
}
