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

// Get values from the form
$accId = 100000;
$location = $_POST['locationBox'];
$file1 = $_FILES['fileInput']['name'];
$concern = $_POST['concernBox'];
$description = $_POST['desc'];
$currentDateTime = date("Y-m-d H:i:s");

// Insert data into the database
$sql = "INSERT INTO concerndetail (accID, location, concernType, description, submitDate, status)
        VALUES ('$accId', '$location', '$concern', '$description', '$currentDateTime', 'Pending');";

if ($conn->query($sql) === TRUE) {
    $lastInsertedID = $conn->insert_id; // Get the auto-incremented ID
    echo "Record inserted successfully. Concern ID: " . $lastInsertedID;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// File Naming

$originalFileName = $_FILES["fileInput"]["name"];
$tempFileName = $_FILES["fileInput"]["tmp_name"];
$targetDir = dirname(dirname(dirname(__DIR__))) . "/AdminPage/uploads/";

// Generate a new unique filename to avoid conflicts
$fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
$newFileName = $lastInsertedID . "_Evidence." . $fileExtension;
$targetFile = $targetDir . $newFileName;

// Check if a file with the same name already exists
if (file_exists($targetFile)) {
    // Handle filename conflict (you can modify this logic)
    $counter = 1;
    $newFileName = $lastInsertedID . "_Evidence" . "(" . $counter . ")." . $fileExtension;
    $targetFile = $targetDir . $newFileName;

    // Increment the counter until a unique filename is found
    while (file_exists($targetFile)) {
        $counter++;
        $newFileName = $lastInsertedID . "_Evidence" . "(" . $counter . ")." . $fileExtension;
        $targetFile = $targetDir . $newFileName;
    }
}

// Move uploaded files to a folder
move_uploaded_file($tempFileName, $targetFile);

$varTargetFile = '/AdminPage/uploads/' . $newFileName;
$escapedTargetFile = addslashes($varTargetFile);

$sql2 ="INSERT INTO concernphoto (concernID, photoEvidence, evidenceName, evidenceDate)
        VALUES ('$lastInsertedID', '$escapedTargetFile', '$newFileName', '$currentDateTime');";

if ($conn->query($sql2) === TRUE) {
    echo "<br>Record inserted successfully. Directory Path: " . $escapedTargetFile;
    // Match found, redirect to the next HTML page
    header("Location: \USCFMS\UserPage\UserAccPage\UserAccPage.html");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
