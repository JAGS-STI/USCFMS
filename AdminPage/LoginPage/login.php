<?php
// Assuming database connection is established

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // You should perform validation and sanitization here before querying the database

    // Establish a database connection (You'll need to set your own database credentials)
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "uscfms";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM adminAcc WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // Match found, redirect to the next HTML page
        header("Location: \USCFMS\AdminPage\AdminHome\adminHome.html");
        exit;
    } else {
        echo "Invalid username or password";
    }

    $conn->close();
}
?>