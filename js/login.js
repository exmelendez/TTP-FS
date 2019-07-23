const loginItems = document.getElementsByClassName("login-info");
const registerItems = document.getElementsByClassName("register-info");
const loginBtn = document.getElementById("login-btn");
const registerBtn = document.getElementById("register-btn");
const loginPwdField = document.getElementById("pwd-field");
const loginSubmit = document.getElementById("login-submit");
const cnfPwdField = document.getElementById("pwd-conf-field");
const registerSubmit = document.getElementById("register-submit");
const formSubmitBtn = document.getElementById("form-submit");

loginBtn.addEventListener("click", () => {

    formSubmitBtn.setAttribute("class", "login-info");
    formSubmitBtn.setAttribute("name", "login-submit");
    formSubmitBtn.setAttribute("value", "Login");

    for(let i = 0; i < loginItems.length; i++) {
        loginItems[i].style.display = "block";
    }

    for(let i = 0; i < registerItems.length; i++) {
        registerItems[i].style.display = "none";
    }
});

registerBtn.addEventListener("click", () => {

    formSubmitBtn.setAttribute("class", "register-info");
    formSubmitBtn.setAttribute("name", "register-submit");
    formSubmitBtn.setAttribute("value", "Register");

    for(let i = 0; i < loginItems.length; i++) {
        loginItems[i].style.display = "none";
    }

    for(let i = 0; i < registerItems.length; i++) {
        registerItems[i].style.display = "block";
    }
});

const getUrlVars = () => {
    let vars = {};
    let parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, (m, key, value) => {
        vars[key] = value;
    });
    return vars;
};

if(getUrlVars()['type'] == "register") {
    for(let i = 0; i < loginItems.length; i++) {
        loginItems[i].style.display = "none";
    }

    for(let i = 0; i < registerItems.length; i++) {
        registerItems[i].style.display = "block";
    }
}

loginPwdField.addEventListener('keypress', (event) => {
    if(event.keycode == 13) {
        loginSubmit.click();
    }
});

cnfPwdField.addEventListener('keypress', (event) => {
    if(event.keycode == 13) {
        registerSubmit.click();
    }
});