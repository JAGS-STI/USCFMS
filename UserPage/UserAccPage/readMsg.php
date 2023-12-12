<?php
    require_once dirname(__DIR__) . "/php/config_session.inc.php";
    require_once dirname(__DIR__) . "/php/signup_view.inc.php";
    require_once dirname(__DIR__) . "/php/login_view.inc.php";

    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    $msgID = isset($_GET['msgID']) ? $_GET['msgID'] : null;
    $row = isset($_GET['row']) ? $_GET['row'] : null;

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get values from the form
    if (empty($_SESSION["user_id"])) {
        echo 'Error: Cannot find $_SESSION["user_id"]';
        echo 'Please go back to the home page ' . $msgID;
        die();
    }

    $sql = "UPDATE messageconcern SET isRead = 1 WHERE msgID = $msgID;";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully.";
        $_SESSION["user_messageList"][$row]['isRead'] = 1;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

?>