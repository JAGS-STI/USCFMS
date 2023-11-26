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
                    <p id="user_name">Logged in as: ' . $_SESSION["user_name"] . '</p>
                    <form action="../php/logout.inc.php" method="post">
                        <button class="logoutBtn">Log-out</button>
                    </form>
                </div>';
        } else {
            echo '<div class="register">
                    <p id="login" onclick="login()">Log in</p>
                    <p>|</p>
                    <p id="signup" onclick="signup()">Sign up</p>
                </div>';
        }
    }