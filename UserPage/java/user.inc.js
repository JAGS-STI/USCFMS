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
    $popupWindow = document.getElementsByClassName("shadow-login");

    if ($toggle === 'open') {
        $popupWindow[0].style.display = 'flex';
    } else {
        $popupWindow[0].style.display = 'none';
    }
}

function toggleMessagePopup($toggle) {
    $popupWindow = document.getElementsByClassName("shadow");

    if ($toggle === 'open') {
        $popupWindow[0].style.display = 'flex';
    } else {
        $popupWindow[0].style.display = 'none';
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

function scrollEvent (targetElement, i, animation) {
    const element = document.getElementsByClassName(targetElement);

    if (animation === true) {
        element[i].scrollIntoView( { behavior: "smooth" } );
    }
    else {
        element[i].scrollIntoView();
    }
}