<?php

function getStockData($stockSymbol, $infoType) {
    $call = "https://cloud.iexapis.com/stable/stock/$stockSymbol/quote?token=pk_0b24b9d449db422194decd95feda86d0";

    $content = file_get_contents($call);
    $data = json_decode($content, true);
    
    if($http_response_header[0] == "HTTP/1.1 200 OK") {

        switch($infoType){
            case "coName":
                return $data['companyName'];
            case "symbol":
                return $data['symbol'];
            case "cost":
                return $data['latestPrice'];
            case "exist":
                return "found";
            default:
                return "no symbol data type specified";
        }
    } else {
        return "symbol not found";
    }
}