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

    $sql = "SELECT name, contact, email, address, description, photoID, location FROM useraccount, concerndetail 
            WHERE concerndetail.accID = useraccount.accID AND concerndetail.concernID = $concernID";
    // Execute the SQL query to retrieve the data from the database
    
?>