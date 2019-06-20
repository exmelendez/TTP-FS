<?php
    require "includes/nav-header.php";
?>

<div id="heading-div">
    <!-- <H1>Portfolio <span>($58685.00)</span></H1> -->

    <?php
        require 'includes/userdata.php';
        getPortfolioValue($_SESSION['userEmail']);
    ?>

</div>


        
<div id="portfolio-container">
    <div id="current-stock-cont">

        <?php
            // require 'includes/userdata.php';
            getPortfolio($_SESSION['userEmail']);
        ?>

    </div>

    <div id="stock-buy-cont">
        <?php
            $userBalance = getUserBalance($_SESSION['userEmail']);
            $searchForm = '<form action="includes/buy-form-setup.php" method="post"><input type="hidden" name="user-email" value="'.$_SESSION['userEmail'].'" >
            <input type="text" name="symbol-search-input" placeholder="Symbol">
            <input id="stock-search-submit" name="symbol-search-btn" type="submit" value="Search">
        </form>';
            echo '<h2>Balance - $'.$userBalance.'</h2>';

            if(isset($_GET['error'])) {
                if($_GET['error'] == "emptyfield") {
                    echo $searchForm.'<p>Symbol input is empty!</p>';
                } else if($_GET['error'] == "symbolnotfound") {
                    echo $searchForm.'<p>Symbol not found!</p>';
                } else if($_GET['error'] == "unavailablefunds") {
                    echo $searchForm.'<p>no funding available!</p>';
                }
            } else if(isset($_GET['symbolsearch']) == "success") {   

                echo '<div><form action="includes/stock-buy.php" method="post"><input type="hidden" name="user-email" value="'.$_SESSION['userEmail'].'" ><input type="text" name="stock-symbol" value="'.$_GET['symbol'].'" readonly>
                    <input type="text" name="stock-price" value="'.$_GET['price'].'" readonly>
                    <input type="number" pattern="\d+" name="stock-qty" placeholder="quantity"><div>
                    <input id="cancel-buy-btn" type="submit" name="cancelBuyBtn" value="Cancel">
                    <input id="submit-buy-btn" type="submit" name="buyBtn" value="Buy">
                    </div>
                </form>
            </div>';

            } else if(isset($_GET['purchase']) == "success") {
                echo $searchForm;

            } else {
                echo $searchForm;
            }
        ?>
    </div>

</div>

<!-- purchase confirm Modal -->
<div class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h1>You have successfully purchased!</h1>
        <h2>Doesn't it feel good?</h2>
    </div>
</div>

<script src="js/buy-confirm.js"></script>

<?php
    require "includes/footer.php";
?>