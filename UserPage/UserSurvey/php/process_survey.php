<?php

    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $concernID = $_GET['concernID'];
    $timely = isset($_POST['timelyY'])?"true":"false";
    $responsiveRate = $_POST['responsiveRate'];
    $overallRate = $_POST['overallRate'];
    $nagivation = isset($_POST['nagivationY'])?"true":"false";
    $updateStat = isset($_POST['updateStatY'])?"true":"false";
    $transparency = isset($_POST['transparencyY'])?"true":"false";
    $addComment = $_POST['addComment'];

    $check =   "SELECT cd.status FROM concerndetail cd LEFT JOIN concernsurvey cs ON cd.concernID = cs.concernID
                WHERE cd.concernID = $concernID AND cs.concernID IS NULL;";
    $result = $conn->query($check);
    $row = $result->fetch_assoc();

    if(isset($row['status']) && $row['status'] === 'Resolved') {
        // Insert data into the database
        $sql = "INSERT INTO concernsurvey (concernID, timely, responsiveRate, overallRate, 
                nagivation, updateStat, transparency, addComment) VALUES 
                ('$concernID', '$timely', '$responsiveRate', '$overallRate',
                '$nagivation', '$updateStat', '$transparency', '$addComment');";

        if ($conn->query($sql) === TRUE) {
            $lastInsertedID = $conn->insert_id; // Get the auto-incremented ID
            echo "Record inserted successfully. Concern ID: " . $lastInsertedID;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        // Match found, redirect to the next HTML page
        header("Location: \USCFMS\UserPage\UserHome\UserHome.html?feedback=success");
    } else {
        header("Location: \USCFMS\UserPage\UserHome\UserHome.html");
    }

    
    

    $conn->close();
?>
