const loginItems = document.getElementsByClassName("login-info");
const registerItems = document.getElementsByClassName("register-info");
const loginBtn = document.getElementById("login-btn");
const registerBtn = document.getElementById("register-btn");
const loginForm = document.getElementById("login-form");

loginBtn.addEventListener("click", () => {
    loginForm.setAttribute("action", "includes/login.php");

    for(let i = 0; i < loginItems.length; i++) {
        loginItems[i].style.display = "block";
    }

    for(let i = 0; i < registerItems.length; i++) {
        registerItems[i].style.display = "none";
    }
});

registerBtn.addEventListener("click", () => {
    loginForm.setAttribute("action", "includes/signup.php");

    for(let i = 0; i < loginItems.length; i++) {
        loginItems[i].style.display = "none";
    }

    for(let i = 0; i < registerItems.length; i++) {
        registerItems[i].style.display = "block";
    }
});