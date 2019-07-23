<?php
    require "includes/nav-header.php";
    $dirPage = 'portfolio.php';

    if(isset($_POST['symbol-inp']) && isset($_POST['stock-qty'])) {
    
        $symbol = $_POST['symbol-inp'];
        $qtyInp = $_POST['stock-qty'];
        $qty = intval($qtyInp);
        $apiData = $user->getStockData($symbol);
        $symbolCost = $apiData['latestPrice'];
    
        if($symbolCost != "symbol not found") {
            strtoupper($symbol);
    
            if($user->ableToPurchase($qty, $symbolCost)) {

                $user->purchaseStock($symbol, $qty, $symbolCost);
                   
                header("Location: " . $dirPage . "?purchase=success");
                exit();
    
            } else {
                header("Location: " . $dirPage . "?error=unavailablefunds");
                exit();
            }
    
        } else {
            header("Location: " . $dirPage . "?error=symbolnotfound");
            exit();
        }
    
    }
?>

    <p id="port-heading-val">Portfolio: $
        <?php
            echo $user->getPortfolioReport('value');
        ?>
    </p>

    <main>
        <?php

            $portData = $user->getPortfolioReport('body');

            if(sizeof($portData) == 0) {
                echo "<h3>no stocks purchased yet</h3>";
            } else {
                foreach($portData as $stockInfo) {
                    echo $stockInfo;
                }
            }
        ?>
    </main>

    <hr style="margin-top: 2.3em; width: 97%;">

    <div id="stock-buy-cont">
        <h2>Purchase Stock</h2>
        <h3>Buying Power - $
            <?php
                echo $user->getAcctBalance();
            ?>
        </h3>

        <form id="multiphase" onsubmit="return false">
            <div id="phase1" class="buy-step-div">
            <input id="symbol-inp" name="symbol-inp" placeholder="Stock Symbol"><br>
           
            <span id="stat-msg" style="color: red;"></span>

            <button onclick="processPhase1()">Search</button>
            </div>

            <div id="phase2" class="buy-step-div">
            Symbol: <input id="symbol" name="symbol-inp" readonly><br>
            Company: <input id="coName" name="co-inp" readonly><br>
            Price: <input id="cost" name="cost" readonly><br>
            Quantity: <input id="qty-inp" type="number" pattern="\d+" placeholder="Quantity" name="stock-qty">
            <button class="cancel-btn" onclick="resetForm()">Cancel</button>
            <button id="review-btn" onclick="processPhase2()">Review</button>
            </div>

            <div id="show_all_data">

                <div class="buy-conf-report">
                    <div>
                        Company: <br/>
                        Symbol: <br/>
                        Price: <br />
                        Quantity: <br />
                        *Total: <br />
                    </div>

                    <div>
                        <span class="report-space" id="display_co"></span><br>
                        <span class="report-space" id="display_symbol"></span><br>
                        <span class="report-space" id="display_price"></span><br>
                        <span class="report-space" id="display_qty"></span><br>
                        <span class="report-space" id="display_total"></span><br>
                    </div>
                </div>

                <button class="cancel-btn" onclick="resetForm()">Cancel</button>
                <button onclick="submitForm()">Purchase</button>
            </div>

        </form>
    </div>

    <!-- purchase confirm Modal -->
    <div id="buy-modal" class="modal">
        <div class="modal-content">
            <span id="buyCloseBtn" class="close-button">&times;</span>
            <h1>You just purchased!</h1>
            <h2>Doesn't it feel good?</h2>
        </div>
    </div>

    <!-- purchase error Modal -->
    <div id="balance-modal" class="modal">
        <div class="modal-content">
            <span id="errCloseBtn" class="close-button">&times;</span>
            <h1>Oopps!</h1>
            <h2>You don't seem to have enough to make that purchase. In your account make a deposit to make a purchase.</h2>
        </div>
    </div>

    <script src="js/ss-form-prep.js"></script>
    <script src="js/buy-confirm.js"></script>

<?php
    require "includes/footer.php";
?>