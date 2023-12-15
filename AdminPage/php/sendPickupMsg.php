<?php
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
            echo 'fetched accID '.$row['accID'].'<br>';
        } else {
            echo 'Failed to fetched accID<br>';
        }
        $accID = $row['accID'];

        $query = "SELECT concernID, useraccount.accID FROM concerndetail JOIN useraccount ON useraccount.accID = concerndetail.accID 
                WHERE concerndetail.accID = $accID";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        if ($result) {
            echo 'fetch first concernID'.$row['concernID'].' Account: '.$row['accID'].'<br>';
        } else {
            echo 'Failed to fetch first concernID<br>';
        }
        $concernID = $row['concernID'];

        $message = $_POST['msgBox'];
        $formattedMessage = addslashes($message);
        $sql = "INSERT INTO messageconcern (concernID, message) 
                VALUES ('$concernID', '$formattedMessage');";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo 'Message Sent to '.$concernID;
        } else {
            echo 'Failed to update concern details<br>';
        }
    } else {
        echo 'Invalid request method';
    }
?>