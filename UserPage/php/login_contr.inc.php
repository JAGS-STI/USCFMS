<?php

    declare(strict_types=1);

    function is_input_empty(string $email, string $password) {
        if(empty($email) || empty($password)) {
            return true;
        } else {
            return false;
        }
    }

    function is_email_wrong(bool|array $result) {
        if (!$result) {
            return true;
        } else {
            return false;
        }
    }

    function is_password_wrong(string $password, $resultPassword) {

        if ($password !== $resultPassword) {
            return true;
        } else {
            return false;
        }

    }

?>