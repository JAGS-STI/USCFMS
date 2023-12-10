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

function toggleMessagePopup($toggle, $row) {
    var popupWindow = document.getElementsByClassName("shadow");
    var msginfo = document.getElementsByClassName("msgInfo");
    var msgbox = document.getElementById("desc");
    var date = document.getElementsByClassName("msgdate");
    var time = document.getElementsByClassName("msgtime");
    var id = document.getElementsByClassName("ticketID");
    var msg = document.getElementsByClassName("msgDetail");
    var table = document.getElementsByClassName("tbl");
    var dot = document.getElementsByClassName("redDot");
    var accdot = document.getElementsByClassName("accdot");
    
    if ($toggle === 'open') {
        popupWindow[0].style.display = 'flex';
        msginfo[0].innerHTML = id[$row].innerHTML;
        msginfo[1].innerHTML = date[$row].innerHTML;
        msginfo[2].innerHTML = time[$row].innerHTML;
        dot[$row].style.backgroundColor = "transparent";
        msgbox.innerHTML = msg[$row].innerHTML;
        var num = parseInt(accdot[0].innerHTML);
        console.log(num);
        accdot[0].innerHTML = num - 1;

        fetch('readMsg.php?msgID=' + encodeURIComponent(table[$row].id) + '&row=' + encodeURIComponent($row))
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));

    } else {
        popupWindow[0].style.display = 'none';
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