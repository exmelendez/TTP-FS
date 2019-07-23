const stkTab = document.getElementById("stock-trans-tab");
const moneyTab = document.getElementById("money-trans-tab");
const stkTabBtn = document.getElementById("stk-btn");
const moneyTabBtn = document.getElementById("money-btn");

const displayMoneyTab = () => {
    stkTab.style.display = "none";
    stkTabBtn.style.backgroundColor = "rgb(25, 10, 109)";
    stkTabBtn.style.cursor = "pointer";

    moneyTabBtn.style.cursor = "auto";
    moneyTab.style.display = "block";
    moneyTabBtn.style.backgroundColor = "rgb(126, 125, 130)";
};

const displayStockTab = () => {
    moneyTab.style.display = "none";
    moneyTabBtn.style.backgroundColor = "rgb(25, 10, 109)";
    moneyTabBtn.style.cursor = "pointer";

    stkTab.style.display = "block";
    stkTabBtn.style.backgroundColor = "rgb(126, 125, 130)";
    stkTabBtn.style.cursor = "auto";
};

moneyTabBtn.addEventListener('click', displayMoneyTab);

stkTabBtn.addEventListener('click', displayStockTab);
