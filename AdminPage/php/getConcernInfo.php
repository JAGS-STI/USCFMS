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

    $sql = "SELECT * FROM concerndetail WHERE concernID = $concernID";
    // Execute the SQL query to retrieve the data from the database
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $dbDateTime = $row['submitDate'];
    $pType = $row['concernType'];
    $pStatus = $row['status'];
    $numericValue = (int) date('YmdHis', strtotime($row['submitDate']));

    if($row['priority'] === null){
        $pPriority = '-----';
    } else{
        $pPriority = $row['priority'];
    }
    
    $dateTimeObj = new DateTime($dbDateTime);
    $formattedDate = $dateTimeObj->format('F j, Y');
    $formattedTime = $dateTimeObj->format('g:i A');

    echo    '<div class="first">
                <div class="card">
                    <p id="cd" class="'.$numericValue.'">Date and time received:</p>
                    <h3>' . $formattedDate . '</h3>
                    <h3>' . $formattedTime . '</h3>
                </div>
                <div class="card">
                    <p>Concern type:</p>
                    <h3 id="pType">' . $pType . '</h3>
                </div>
            </div>
            <div class="first">
                <div class="card">
                    <p>Status:</p>
                    <h3 id="pStatus" style="display: flex;"><div class="dot" id="' . getStatusColor($row['status']) . '"></div>' . $pStatus . '</h3>
                </div>
                <div class="card">
                    <p>Priority:</p>
                    <h3 id="pPriority">' . $pPriority . '</h3>
                </div>
            </div>';

    // Function to determine status color
    function getStatusColor($status)
    {
        switch ($status) {
            case 'Unread':
                return 'red';
            case 'Pending':
                return 'gray';
            case 'Active':
                return 'blue';
            case 'Resolved':
                return 'green';
            case 'Discarded':
                return 'orange';
            default:
                return 'black'; // Change this to a default color or handle as needed
        }
    }
?>