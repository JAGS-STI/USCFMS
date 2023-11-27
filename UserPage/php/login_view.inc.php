<?php

    declare(strict_types=1);

    function check_login_errors() {
        if (isset($_SESSION["errors_login"])) {
            $errors = $_SESSION["errors_login"];

            foreach ($errors as $error) {
                echo '<p class="form-error">' . $error . '</p>';
            }

            unset($_SESSION["errors_login"]);
        } else if(isset($_GET['login']) && $_GET['login'] === "success") {
            echo '<p class="form-success">Login successfully!</p>';
        }
    }

    function output_account() {
        if (isset($_SESSION["user_id"])) {
            echo '<div class="register">
                    <p id="user_name" onclick="toaccount()">Logged in as: ' . $_SESSION["user_name"] . '</p>
                    <form action="../php/logout.inc.php" method="post">
                        <button class="logoutBtn">Log-out</button>
                    </form>
                </div>';
        } else {
            echo '<div class="register">
                    <p id="login" onclick="tologin()">Log in</p>
                    <p>|</p>
                    <p id="signup" onclick="tosignup()">Sign up</p>
                </div>';
        }
    }

    function tosubmitBtn() {
        if (isset($_SESSION["user_id"])) {
            echo '<a href="/USCFMS/UserPage/UserConcern/UserConcern.html">Submit Concern</a>';
        } else {
            echo '<a onclick="toggleLoginPopup(\'open\')">Submit Concern</a>';
        }
    }

    function tosubmitHomeBtn() {
        if (isset($_SESSION["user_id"])) {
            echo '<button class="submit" onclick="tosubmitconcern()">SUBMIT</button>';
        } else {
            echo '<button class="submit" onclick="toggleLoginPopup(\'open\')">SUBMIT</button>';
        }
    }

    function login_popup() {
        echo '<div class="shadow" id="login-popup">
                <div class="popup">
                    <p id="head">You need to log in or sign up first.</p>
                    <div class="pop-buttons">
                        <button onclick="tologin()>Log in</button>
                        <button onclick="tosignup()>Sign up</button>
                    </div>
                    <img onclick="toggleLoginPopup('."'close'".')" src="Media/button-error-svgrepo-com.svg">
                </div>
            </div>';
    }