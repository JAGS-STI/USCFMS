<?php 

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $fullname = $_POST["nameBox"];
        $street = $_POST["streetBox"];
        $contactno = $_POST["contactBox"];
        $file1 = $_FILES['fileInput']['name'];
        $email = $_POST["emailBox"];
        $password = $_POST["passwordBox"];
        $tempFileName = $_FILES["fileInput"]["tmp_name"];

        try {

            require_once 'dbh.inc.php';
            require_once 'signup_model.inc.php';
            require_once 'signup_contr.inc.php';

            // ERROR HANDLERS 
            $errors = [];

            if (is_input_empty($fullname, $street, $contactno, $file1, $email, $password)) {
                $errors["empty_input"] = "Fill in all fields!";
            }
            if (is_email_invalid($email)) {
                $errors["invalid_email"] = "Invalid email used!";
            }
            if (is_contactno_invalid($contactno)) {
                $errors["invalid_contactno"] = "Invalid contact number used!";
            }
            if (is_email_taken($pdo, $email)) {
                $errors["email_used"] = "Email already registered!";
            }

            require_once 'config_session.inc.php';

            if ($errors) {
                $_SESSION["errors_signup"] = $errors;

                $signupData = [
                    "name" => $fullname,
                    "contact" => $contactno,
                    "email" => $email,
                    "streetBox" => $street
                ];
                $_SESSION["signup_data"] = $signupData;

                header("Location: /USCFMS/UserPage/UserSignup/UserSignup.html");
                die();
            }

            create_user($pdo, $fullname, $street, $contactno, $file1, $email, $password, $tempFileName);
            header("Location: /USCFMS/UserPage/UserSignup/UserSignup.html?signup=success");

            $pdo = null;
            $stmt = null;

            die();

        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }

    } else {
        header("Location: /USCFMS/UserPage/UserSignup/UserSignup.html");
        die();
    }

?>