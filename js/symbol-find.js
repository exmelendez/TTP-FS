/*******
 * 
 * FILE NO LONGER IN USE ANYMORE
 * KEEP FOR JS REFERENCE ON AJAX USE WITH
 * XMLHttpRequest
 * 
 */

const searchInput = document.getElementById("symbol-search-input");
const symbolSearchBtn = document.getElementById("symbol-search-btn");
const symbolSearchMsg = document.getElementById("symbol-status-msg");
let isSymbolFound;
const buyForm = document.getElementById("buy-form-div");


symbolSearchBtn.addEventListener("click", () => {
   
    let symbolSearch = searchInput.value;

    if(symbolSearch == "") {
        symbolSearchMsg.innerHTML = "symbol field blank";

    } else {
        isSymbolFound = false;
        const xhr = new XMLHttpRequest();
        xhrProcess(xhr);

        xhr.onload = function() {
            let data = JSON.parse(this.response);
    
            if(xhr.status >= 200 && xhr.status < 400) {
                let symbolInput = symbolSearch.toUpperCase();
    
                for(let i = 0; i < data.length; i++) {
                    if(data[i]['symbol'] === symbolInput) {
                        isSymbolFound = true;
                        break;
                    }
                }
                symbolFindProcess(symbolInput);
                
            } else {
                console.log("error");
            }
        };
    }
});

const symbolFindProcess = (givenSymbol) => {
    if(isSymbolFound) {
        symbolSearchMsg.innerHTML = "";
        buyForm.style.display = "flex";

        document.getElementById("symbol-display").innerHTML = givenSymbol;
        document.getElementById("symbol-acrn").setAttribute("value", givenSymbol);
        document.getElementById("price-cont").innerHTML = `<?php$stockPrice = getStockData("${givenSymbol}", "cost");echo "<p>".$stockPrice."</p>";?>`;

        searchInput.style.display = "none";
        symbolSearchBtn.style.display = "none";
        
    } else {
        symbolSearchMsg.innerHTML = "Symbol not found";
        searchInput.value = "";
    }
};

const xhrProcess = (request) => {
    request.open('GET', 'https://api.iextrading.com/1.0/ref-data/symbols', true);
    request.send();
};