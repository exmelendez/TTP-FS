<?php
    require "includes/nav-header.php";
?>

<div id="heading-div">
    <H1>Portfolio <span>($58685.00)</span></H1>
</div>
        
<div id="portfolio-container">
    <div id="portfolio-cont">
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
        <h2>Cash - $5000.00</h2>
        <input id="symbol-search-input" type="text" placeholder="Symbol">
        <input id="symbol-search-btn" type="submit" value="Search">
    
        <div id="buy-form-div">
            <p>
                <span id="symbol-display" class="symbol-reset">AAPL</span>
                <i class="fas fa-times-circle symbol-reset"></i>
            </p> 
            
            <form> 
                <input id="symbol-acrn" type="hidden" name="symbol" value="">       
                <input type="text" placeholder="quantity">
                <input type="submit" name="buyBtn" value="Buy">
            </form>
        </div>

        <p id="symbol-status-msg"></p>
    </div>
</div>

<script src="js/symbol-find.js"></script>

<?php
    require "includes/footer.php";
?>