<?php
    require "includes/nav-header.php";
    
    $dirPage = 'transactions.php';
    $stkData = $user->getTransReport('stock');
    $moneyData = $user->getTransReport('money');
?>

<div id="trans-selector">
    <span id="stk-btn">Stocks</span>
    <span id="money-btn">Money</span>
</div>

<div id="stock-trans-tab">

            <?php
                if(sizeof($stkData) == 0) {
                    echo "<h3 style=\"text-align:center;\">no stocks purchased yet</h3>";
                } else {
                    echo '
                        <table class="table">
                            <thead>
                                <th>Type</th>
                                <th>Symbol</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Date</th>
                            </thead>
                        <tbody>
                    ';

                    foreach($stkData as $stockTransInfo) {
                        echo $stockTransInfo;
                    }

                    echo '</tbody></table>';
                }
            ?>
</div>

<div id="money-trans-tab">
            <?php
                if(sizeof($moneyData) == 0) {
                    echo "<h3 style=\"text-align:center;\">no monetary transactions yet made</h3>";
                } else {
                    echo '
                        <table class="table">
                            <thead>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </thead>
                        <tbody>
                    ';
                    foreach($moneyData as $moneyTransInfo) {
                        echo $moneyTransInfo;
                    }

                    echo '</tbody></table>';
                }
            ?>
</div>

<script src="js/trans.js"></script>

<?php
    require "includes/footer.php";
?>