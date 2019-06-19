<?php
    require "includes/nav-header.php";
?>

<div id="trans-container">
    <h1>Transactions</h1>

    <?php
    require 'includes/userdata.php';

    $stockTransArr = getStockTrans($_SESSION['userEmail']);

    if($stockTransArr > 0) {

        foreach($stockTransArr as $sData) {
            $transType = '';
            $sharesText = "Share";
    
            if($sData['transType'] == 'B') {
                $transType = "BUY";
            } else if($sData['transType'] == 'S') {
                $transType = "SELL";
            }

            if($sData['qty'] > 1) {
                $sharesText = 'Shares';
            }
    
            echo '<p>
            <span class="trans-push-right">'.$transType.'</span>
            <span class="trans-push-right">('.$sData["symbol"].') - '.$sData["qty"].' '.$sharesText.'</span>
            <span class="trans-push-right">@</span>
            <span class="trans-push-right">'.$sData["totalCost"].' ('.$sData["indivCost"].' ea.)</span></p>';
        }

    } else {
        echo '<p style="text-align: center;">No transaction yet</p>';
    }

    
?>
</div>

<?php
    require "includes/footer.php";
?>