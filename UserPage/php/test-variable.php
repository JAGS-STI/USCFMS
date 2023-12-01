<?php 
    require_once 'dbh.inc.php';
    require_once 'login_model.inc.php';
    require_once 'login_contr.inc.php';
    require_once 'config_session.inc.php';
    require_once "signup_view.inc.php";
    require_once "login_view.inc.php";

    $email = 'jhericomedina213@gmail.com';

    $result = get_email($pdo, $email);
    $userConcernList = get_concernDetail($pdo, $result["accID"]);

    $_SESSION["user_id"] = $result["accID"];
    $_SESSION["user_name"] = htmlspecialchars($result["name"]) ;
    $_SESSION["user_email"] = $result["email"];
    $_SESSION["user_contact"] = $result["contact"];
    $_SESSION["user_street"] = $result["address"];

    $_SESSION["user_concernList"] = $userConcernList;

    $userConcernList = $_SESSION['user_concernList'];

    // Output the contents of the array
    echo '<pre>';
    var_dump($userConcernList); // or print_r($userConcernList);
    echo '</pre>';

    echo $_SESSION['user_concernList'][0]["concernID"] . ' idk';
    userConcernTable();

?>
