<?php
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "uscfms";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$database", $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
?>