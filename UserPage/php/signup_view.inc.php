<?php 

    declare(strict_types=1);

    function signup_input_name() {
        
        if (isset($_SESSION["signup_data"]["name"])) {
            echo '<input id="nameBox" name="nameBox" type="text" placeholder="Name" value="' . $_SESSION["signup_data"]["name"] . '">';
        } else {
            echo '<input id="nameBox" name="nameBox" type="text" placeholder="Name">';
        }
    }

    function signup_input_contact() {
        
        if (isset($_SESSION["signup_data"]["contact"]) && !isset($_SESSION["errors_signup"]["invalid_contactno"])) {
            echo '<input id="contactBox" name="contactBox" type="text" placeholder="Contact number" value="' . $_SESSION["signup_data"]["contact"] . '" required>';
        } else {
            echo '<input id="contactBox" name="contactBox" type="text" placeholder="Contact number" required>';
        }
    }

    function signup_input_email() {
        
        if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["invalid_email"]) && !isset($_SESSION["errors_signup"]["email_used"])) {
            echo '<input id="emailBox" name="emailBox" type="text" placeholder="Enter emai address" value="' . $_SESSION["signup_data"]["email"] . '" required>';
        } else {
            echo '<input id="emailBox" name="emailBox" type="text" placeholder="Enter emai address" required>';
        }
    }
    

    function check_signup_errors() {
        if (isset($_SESSION['errors_signup'])) {
            $errors = $_SESSION['errors_signup'];

            foreach($errors as $error) {
                echo '<p class="form-error">' . $error . '</p>';
            }
            unset($_SESSION['errors_signup']);
        } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
            echo '<p class="form-success">Signup success!</p>';
        }
    }
?>