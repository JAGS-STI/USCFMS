<?php 

    $commentID = $_GET['commentID'];

    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM commenttbl WHERE commentID = $commentID";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!empty($row)) {
        echo '<textarea id="desc" name="desc" rows="5" cols="100">' . $row['comment'] . '</textarea>';
    } else {
        echo '<textarea id="desc" name="desc" rows="5" cols="100"> ------------------ </textarea>';
    }
    
?>