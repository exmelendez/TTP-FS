<?php

$content = file_get_contents("https://api.iextrading.com/1.0/ref-data/symbols");
$data = json_decode($content, true);
$input = "AAPL";
$found = 'not found';

/*
foreach($data as $stock) {

    echo '<tr>
                <td></td>
                <td>'.$stock['symbol'].'</td>
                <td>'.gettype($stock['symbol']).'</td>
            </tr>';
} 
*/


foreach($data as $stock) {

    if($input == $stock['symbol']) {

        $found = 'found';
        break;
    }
}

echo '<tr>
        <td></td>
        <td>'.$input.'</td>
        <td>'.$found.'</td>
    </tr>';
    