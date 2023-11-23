<?php

$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password for the root user
$database = "uscfms";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS commentCount FROM commenttbl WHERE DATE(submitDate) = CURDATE()";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $commentCount = $row['commentCount'];
    
    // Echo the total amount
    echo $commentCount;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>