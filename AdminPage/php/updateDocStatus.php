<?php
// Include your database connection code here

    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $docID = $_POST['docID'];
        $status = $_POST['status'];

        // Update concern details in the database
        // Adjust this query according to your database schema
        $query = "UPDATE docstatus SET status = '$status' WHERE docID = '$docID'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo 'Concern details updated successfully';
        } else {
            echo 'Failed to update concern details';
        }
    } else {
        echo 'Invalid request method';
    }
?>
