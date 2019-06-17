<?php

/************
 * 
 * 
 *  TEST METHOD - NON-KEY API CALL TO CHECK THE LIST OF AVAILABLE STOCKS & THEIR EXISTENCE
 * 
 */
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
