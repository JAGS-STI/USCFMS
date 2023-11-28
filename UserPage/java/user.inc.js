function tologin() {
    window.location.href='/USCFMS/UserPage/UserLogin/UserLogin.html';
}

function tosignup() {
    window.location.href='/USCFMS/UserPage/UserSignup/UserSignup.html';
}

function tosubmitconcern() {
    window.location.href='/USCFMS/UserPage/UserConcern/UserConcern.html';
}

function toaccount() {
    window.location.href='/USCFMS/UserPage/UserAccPage/UserAccPage.html';
}

function toggleLoginPopup($toggle) {
    $popupWindow = document.getElementById("login-popup");

    if ($toggle === 'open') {
        $popupWindow.style.display = 'flex';
    } else {
        $popupWindow.style.display = 'none';
    }
}

function togglePassword() {
    var passwordField = document.getElementById("passwordBox");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}