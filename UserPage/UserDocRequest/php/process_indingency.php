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

    // Check if the user is logged-in
    if (empty($_SESSION["user_id"])) {
        echo 'Error: Cannot find $_SESSION["user_id"]';
        echo 'Please go back to the home page';
        die();
    }

    $accId = $_SESSION["user_id"];
    $name = strtoupper($_POST['nameBox']);
    $bday = $_POST['bdayBox'];
    $vin = $_POST['vinBox'];
    $address = strtoupper($_POST['addressBox']);
    $year = strtoupper($_POST['yearBox']);
    $educ = strtoupper($_POST['educationalBox']);
    $request = strtoupper($_POST['requestingBox']);
    $purpose = strtoupper($_POST['purposeBox']);

    $sql = "INSERT INTO docstatus (docType, accID, status)
            VALUES ('Indingency', '$accId', 'Pending');";
    
    if ($conn->query($sql) === TRUE) {
        $lastInsertedID = $conn->insert_id; // Get the auto-incremented ID
        echo "Record inserted successfully. Concern ID: " . $lastInsertedID;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die();
    }

    $sql1 = "INSERT INTO doc1detail (docID, name, bday, vin, address, years, education, request, purpose)
            VALUES ('$lastInsertedID', '$name', '$bday', '$vin', '$address', '$year', '$educ', '$request', '$purpose');";
    
    if ($conn->query($sql1) === TRUE) {
        echo "Record doc1detail inserted successfully. docID: " . $lastInsertedID;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die();
    }
 
    // Match found, redirect to the next HTML page
    header("Location: \USCFMS\UserPage\UserAccPage\UserAccPage.html");

    $conn->close();
?>
