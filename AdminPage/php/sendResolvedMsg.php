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
        $message = $_POST['msgBox'];
        $cd = $_POST['cd'];
        $message = $message . '<a href="/USCFMS/UserPage/UserSurvey/UserSurvey.html?concernID='.$concernID.'&cd='.$cd.'">Survey Page</a>';
        $formattedMessage = addslashes($message);
        $sql = "INSERT INTO messageconcern (concernID, message) 
                VALUES ('$concernID', '$formattedMessage');";
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