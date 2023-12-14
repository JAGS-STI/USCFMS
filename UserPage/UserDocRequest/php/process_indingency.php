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
    if (empty($_SESSION["user_id"]) || !isset($_SESSION["user_id"])) {
        echo 'Error: Cannot find $_SESSION["user_id"]';
        echo 'Please go back to the home page';
        header("Location: /USCFMS/UserPage/UserLogin/UserLogin.html?timeout=true");
        die();
    }

    $accId = $_SESSION["user_id"];
    $check = "SELECT COUNT(`docID`) AS `countToday` FROM `docstatus` WHERE `accID` = $accId AND DATE(`dateReceived`) = CURDATE();";
    $result = $conn->query($check);

    if ($result) {
        $row = $result->fetch_assoc();
        if($row['countToday'] > 3) {
            echo $row['countToday'];
            header("Location: /USCFMS/UserPage/UserHome/UserHome.html?submit=max");
            die();
        }    
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die();
    }
    $name = strtoupper($_POST['nameBox']);
    $bday = $_POST['bdayBox'];
    $vin = !empty($_POST['vinBox']) || isset($_POST['vinBox']) ? strtoupper($_POST['vinBox']) : "N/A";
    $address = strtoupper($_POST['addressBox']);
    $year = strtoupper($_POST['yearBox']);
    $educ = !empty($_POST['vinBox']) || isset($_POST['vinBox']) ? strtoupper($_POST['educationalBox']) : "N/A";
    $request = strtoupper($_POST['requestingBox']);
    $purpose = strtoupper($_POST['purposeBox']);
    $grade = !empty($_POST['vinBox']) || isset($_POST['vinBox']) ? strtoupper($_POST['gradeBox']) : "N/A";

    $sql = "INSERT INTO docstatus (docType, accID, status)
            VALUES ('Barangay Indingency', '$accId', 'Pending');";
    
    if ($conn->query($sql) === TRUE) {
        $lastInsertedID = $conn->insert_id; // Get the auto-incremented ID
        echo "Record inserted successfully. Concern ID: " . $lastInsertedID;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die();
    }

    $sql1 = "INSERT INTO doc1detail (docID, name, bday, vin, address, years, education, grade, request, purpose)
            VALUES ('$lastInsertedID', '$name', '$bday', '$vin', '$address', '$year', '$educ', '$grade', '$request', '$purpose');";
    
    try {
        if ($conn->query($sql1) === TRUE) {
            echo "Record doc1detail inserted successfully. docID: " . $lastInsertedID;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            die();
        }
    } catch(Exception) {
        $sql = "DELETE FROM docstatus WHERE docID = $lastInsertedID;";
        echo "Deleted newly added " . $lastInsertedID;
    }
    
 
    // Match found, redirect to the next HTML page
    header("Location: \USCFMS\UserPage\UserAccPage\UserAccPage.html?submit=success");

    $conn->close();
?>