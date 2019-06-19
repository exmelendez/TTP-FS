<?php
    require "includes/nav-header.php";
?>

<div id="trans-container">
    <h1>Transactions</h1>

    <?php
    require 'includes/userdata.php';

    $stockTransArr = getStockTrans($_SESSION['userEmail']);

    foreach($stockTransArr as $sData) {
        $transType = '';

        if($sData['transType'] == 'B') {
            $transType = "BUY";
        } else if($sData['transType'] == 'S') {
            $transType = "SELL";
        }

        echo '<p>
        <span class="trans-push-right">'.$transType.'</span>
        <span class="trans-push-right">('.$sData['symbol'].') - '.$sData['qty'].' Shares</span>
        <span class="trans-push-right">@</span>
        <span class="trans-push-right">'.$sData['totalCost'].' ('.$sData['indivCost'].' ea.)</span></p>';

    }
?>
</div>

<?php
    require "includes/footer.php";
?>