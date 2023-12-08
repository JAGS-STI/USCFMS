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
        $message = $_POST['msgBox'];
        $sql = "INSERT INTO messageconcern (concernID, message) 
                VALUES ('10001', '$message');";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo 'Concern details updated successfully';
        } else {
            echo 'Failed to update concern details';
        }
    } else {
        echo 'Invalid request method';
    }
?>