<?php

//used to show & report errors on client side page
//error_reporting(0);

$symbols = array("AAPL", "FB", "AMZN", "TWTR", "GOOG");

foreach($symbols as $stocks) {
    $call = "https://api.iextrading.com/1.0/stock/$stocks/batch?types=quote";
    $content = file_get_contents($call);
    //Adding the true makes it into an associated array
    $data = json_decode($content, true);

    $price = $data['quote']['latestPrice'];
    $name = $data['quote']['companyName'];

    if(empty($name)) {
        $price = "N/A";
        $stocks = "N/A";
        $name = "N/A";
    }

    echo '<tr>
            <td>'.$name.'</td>
            <td>'.$stocks.'</td>
            <td>'.$price.'</td>
        </tr>';
}