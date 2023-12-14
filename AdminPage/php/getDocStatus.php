<?php
// Include your database connection code here
    $docID = $_GET['docID'];

    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['docID'])) {
        $docID = $_GET['docID'];

        // Fetch concern details from the database
        // Adjust this query according to your database schema
        $query = "SELECT status FROM docstatus WHERE docID = '$docID'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Failed to fetch concern details']);
        }
    } else {
        echo json_encode(['error' => 'Missing concernID parameter']);
    }
?>
