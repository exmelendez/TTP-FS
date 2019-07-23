var modal = document.getElementById("buy-modal");
var errorModal = document.getElementById("balance-modal");
var closeBuyButton = document.getElementById("buyCloseBtn");
var closeErrButton = document.getElementById("errCloseBtn");

const getUrlVars = () => {
    let vars = {};
    let parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, (m, key, value) => {
        vars[key] = value;
    });
    return vars;
};

const toggleModal = () => {
    modal.classList.toggle("show-modal")
};

const toggleEModal = () => {
    errorModal.classList.toggle("show-modal")
};

const windowOnClick = (event) => {
    if (event.target === modal) {
        toggleModal();
    } else if(event.target === errorModal) {
        toggleEModal();
    }
};

closeBuyButton.addEventListener("click", toggleModal);
closeErrButton.addEventListener("click", toggleEModal);
window.addEventListener("click", windowOnClick);

if(getUrlVars()['purchase'] == "success") {
    toggleModal();
}

if(getUrlVars()['error'] == "unavailablefunds") {
    toggleEModal();
}