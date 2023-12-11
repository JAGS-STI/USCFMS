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

    $sql = "SELECT idPath FROM useraccount, concerndetail, idphoto
            WHERE concerndetail.accID = useraccount.accID AND concerndetail.concernID = $concernID AND useraccount.photoID = idphoto.photoID";
    // Execute the SQL query to retrieve the data from the database
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    echo    '<div class="upldID">
                <h4>Uploaded valid ID:</h4>
                <div class="imgs">';
    while ($row = $result->fetch_assoc()) {
        $idPath = $row['idPath'];
        $pathFormat = '/USCFMS' . $idPath;
    echo            '<img src="' . $pathFormat . '" onclick="enlargeImage(this)">';
    }         
    echo        '</div>  
            </div>';
    }
    
    /* OLD TEMPLATE
    <div class="upldID">
        <h4>Uploaded valid ID:</h4>
        <div class="imgs">
            <img src="media/blank-image-svgrepo-com.svg">
        </div>  
    </div>*/
?>