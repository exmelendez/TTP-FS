<?php
    require "includes/nav-header.php";
?>

<div id="heading-div">
    <H1>Portfolio <span>($58685.00)</span></H1>
</div>
        
<div id="portfolio-container">
    <div id="current-stock-cont">
        <p>
            <span class="port-push-right">AAPL - 6 Shares</span>
            <span>$2043.09</span>
        </p> 
        <p>
            <span class="port-push-right">STWD - 40 Shares</span>
            <span>$2043.09</span>
        </p>
        <p>
            <span class="port-push-right">NFLX - 86 Shares</span>
            <span>$2043.09</span>
        </p>
        <p></p>
        <p></p>
    </div>

    <div id="stock-buy-cont">
        <?php
            require 'includes/userdata.php';
            $userBalance = getUserBalance($_SESSION['userEmail']);
            $searchForm = '<form action="includes/buy-form-setup.php" method="post">
            <input type="text" name="symbol-search-input" placeholder="Symbol">
            <input id="stock-search-submit" name="symbol-search-btn" type="submit" value="Search">
        </form>';
            echo '<h2>Balance - $'.$userBalance.'</h2>';

            if(isset($_GET['error'])) {
                if($_GET['error'] == "emptyfield") {
                    echo $searchForm.'<p>Symbol input is empty!</p>';
                } else if($_GET['error'] == "symbolnotfound") {
                    echo $searchForm.'<p>Symbol not found!</p>';
                }
            } else if(isset($_GET['symbolsearch']) == "success") {   

                echo '<div><form action="includes/stock-buy.php" method="post"><input type="text" name="stock-symbol" value="'.$_GET['symbol'].'" disabled>
                    <input type="text" name="stock-price" value="'.$_GET['price'].'" disabled>
                    <!-- <input type="text" placeholder="quantity"> -->
                    <input type="number" pattern="\d+" name="stock-qty" placeholder="quantity"><div>
                    <input id="cancel-buy-btn" type="submit" name="cancelBuyBtn" value="Cancel">
                    <input id="submit-buy-btn" type="submit" name="buyBtn" value="Buy">
                    </div>
                </form>
            </div>';

            } else {
                echo $searchForm;
            }
        ?>
    </div>

</div>

<?php
    require "includes/footer.php";
?>