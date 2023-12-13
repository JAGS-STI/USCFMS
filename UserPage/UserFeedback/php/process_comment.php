<?php
    require_once dirname(dirname(__DIR__)) . "/php/config_session.inc.php";
    require_once dirname(dirname(__DIR__)) . "/php/signup_view.inc.php";
    require_once dirname(dirname(__DIR__)) . "/php/login_view.inc.php";

    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if (isset($_SESSION["user_id"])) {
        $name = $_SESSION["user_name"];
        $contact = $_SESSION["user_contact"];
        $comment = $_POST['desc'];
    } else {
        $name = $_POST["nameBox"];
        $contact = $_POST['contactBox'];
        $comment = $_POST['desc'];
    }

    $name = empty($name) ? 'anonymous' : $name;

    // Insert data into the database
    if (empty($contact)) {
        $sql = "INSERT INTO commenttbl (name, contact, comment)
            VALUES ('$name', NULL, '$comment');";
    } else {
        $sql = "INSERT INTO commenttbl (name, contact, comment)
            VALUES ('$name', '$contact', '$comment');";
    }
    

    if ($conn->query($sql) === TRUE) {
        $lastInsertedID = $conn->insert_id; // Get the auto-incremented ID
        echo "Record inserted successfully. Concern ID: " . $lastInsertedID;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
 
    // Match found, redirect to the next HTML page
    header("Location: /USCFMS/UserPage/UserFeedback/UserFeedback.html?submit=success");

    $conn->close();
?>
