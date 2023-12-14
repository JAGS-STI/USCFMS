<?php
    $concernID = $_GET['concernID'];
    
    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $concernID = $_POST['concernID'];

        $query = "SELECT useraccount.accID FROM useraccount, docstatus WHERE docstatus.accID = useraccount.accID AND docstatus.docID = $concernID";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        if ($result) {
            echo 'fetched accID';
        } else {
            echo 'Failed to fetched accID';
        }
        $accID = $row['accID'];

        $query = "SELECT concernID FROM concerndetail JOIN useraccount ON useraccount.accID = concerndetail.accID";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        if ($result) {
            echo 'fetch first concernID';
        } else {
            echo 'Failed to fetch first concernID';
        }
        $concernID = $row['concernID'];

        $message = $_POST['msgBox'];
        $formattedMessage = addslashes($message);
        $sql = "INSERT INTO messageconcern (concernID, message) 
                VALUES ('$concernID', '$formattedMessage');";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo 'Message Sent';
        } else {
            echo 'Failed to update concern details';
        }
    } else {
        echo 'Invalid request method';
    }
?>