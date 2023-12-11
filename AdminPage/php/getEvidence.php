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

    $sql = "SELECT photoEvidence FROM concernphoto, concerndetail
            WHERE concerndetail.concernID = $concernID AND concerndetail.concernID = concernphoto.concernID";
    // Execute the SQL query to retrieve the data from the database
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    echo    '<div class="evidence">
                <h4>Uploaded evidence:</h4>
                <div class="imgs">';
    while ($row = $result->fetch_assoc()) {
        $idPath = $row['photoEvidence'];
        $pathFormat = '/USCFMS' . $idPath;
    echo            '<img src="' . $pathFormat . '" onclick="enlargeImage(this)">';
    }         
    echo        '</div>  
            </div>';
    }
    
    /* OLD TEMPLATE
    <div class="evidence">
        <h4>Uploaded evidence:</h4>
        <div class="imgs">
            <img src="/USCFMS/AdminPage/uploads/10012_Evidence.png">
            <img src="media/blank-image-svgrepo-com.svg">
            <img src="media/blank-image-svgrepo-com.svg">
            <img src="media/blank-image-svgrepo-com.svg">
            <img src="media/blank-image-svgrepo-com.svg">
        </div>   
     </div>*/
?>