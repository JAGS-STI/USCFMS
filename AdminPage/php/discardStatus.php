<?php
// Include your database connection code here
    $concernID = $_GET['concernID'];

    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $concernID = $_POST['concernID'];
        $status = $_POST['status'];

        // Update status to "Discarded" in the database
        // Adjust this query according to your database schema
        $query = "UPDATE concerndetail SET status = '$status' WHERE concernID = '$concernID'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo 'Status updated to Discarded';
        } else {
            echo 'Failed to update status';
        }
    } else {
        echo 'Invalid request method';
    }
?>
