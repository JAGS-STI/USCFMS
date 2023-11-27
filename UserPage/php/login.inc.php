<?php 

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["emailBox"];
        $password = $_POST["passwordBox"];

        try {

            require_once 'dbh.inc.php';
            require_once 'login_model.inc.php';
            require_once 'login_contr.inc.php';

            // ERROR HANDLERS 
            $errors = [];

            if (is_input_empty($email, $password)) {
                $errors["empty_input"] = "Fill in all fields!";
            }
            
            $result = get_email($pdo, $email);

            if (is_email_wrong($result)) {
                $errors["login_incorrect"] = "Incorrect email and password.";
            }
            if (!is_email_wrong($result) && is_password_wrong($password, $result["password"])) {
                $errors["login_incorrect"] = "Incorrect password.";
            }

            require_once 'config_session.inc.php';

            if ($errors) {
                $_SESSION["errors_login"] = $errors;

                header("Location: ../UserLogin/UserLogin.html");
                die();
            }

            $newSessionId = session_create_id();
            $sessionId = $newSessionId . "_" . $result["id"];
            session_id($sessionId);

            $_SESSION["user_id"] = $result["accID"];
            $_SESSION["user_name"] = htmlspecialchars($result["name"]) ;
            $_SESSION["user_email"] = $result["email"];
            $_SESSION["user_contact"] = $result["contact"];
            $_SESSION["user_street"] = $result["address"];

            $_SESSION["last_regeneration"] = time();

            header("Location: ../UserLogin/UserLogin.html?login=success");
            
            $pdo = null;
            $statement = null;

            die();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }

    } else {
        header("Location: ../index.html");
        die();
    }

?>