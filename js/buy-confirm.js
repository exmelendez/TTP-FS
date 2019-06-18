var modal = document.querySelector(".modal");
var closeButton = document.querySelector(".close-button");

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

const windowOnClick = (event) => {
    if (event.target === modal) {
        toggleModal();
    }
};

closeButton.addEventListener("click", toggleModal);
window.addEventListener("click", windowOnClick);

if(getUrlVars()['purchase'] == "success") {
    toggleModal();
} else {
    console.log("nada");
}
