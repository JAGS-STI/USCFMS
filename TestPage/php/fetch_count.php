<?php

$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password for the root user
$database = "uscfms";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS activeCount FROM concerndetail WHERE status = 'active'";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $activeCount = $row['activeCount'];

    // Echo the total amount
    echo $activeCount;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
