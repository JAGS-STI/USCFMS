<?php 

    declare(strict_types=1);

    function is_input_empty(string $fullname, string $street, $contactno, $file1, $email, $password) {
        if (empty($fullname) || empty($street) || empty($contactno) || empty($file1) || empty($email) || empty($password)) {
            return true;
        } else {
            return false;
        }
    }

    function is_contactno_invalid($contactno) {
        $valid_number = filter_var($contactno, FILTER_SANITIZE_NUMBER_INT);
        if (!preg_match('/^[0-9]{11}+$/', $valid_number)) {
            return true;
        } else {
            return false;
        }
    }

    function is_email_invalid(string $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    function is_email_taken(object $pdo, string $email) {
        if (get_email($pdo, $email)) {
            return true;
        } else {
            return false;
        }
    }

    function create_user(object $pdo, string $fullname, string $street, $contactno, $file1, $email, $password, $tempFileName) {
        set_user($pdo, $fullname, $street, $contactno, $file1, $email, $password, $tempFileName);
    }
?>