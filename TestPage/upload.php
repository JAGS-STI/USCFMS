<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the original name of the uploaded file
    $originalFileName = $_FILES["fileToUpload"]["name"];

    // Get the temporary filename assigned to the file on the server
    $tempFileName = $_FILES["fileToUpload"]["tmp_name"];

    // Specify the folder where you want to save the uploaded files
    $targetDir = "uploads/";

    // Generate a new unique filename to avoid conflicts
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $newFileName = "184757" . "_Evidence." . $fileExtension;

    // Move the uploaded file to the specified folder with the new filename
    $targetFile = $targetDir . $newFileName;
    
    // Check if a file with the same name already exists
    if (file_exists($targetFile)) {
        // Handle filename conflict (you can modify this logic)
        // For example, append a counter to the filename
        $counter = 1;
        $newFileName = "184757" . "_Evidence" . "(" . $counter . ")." . $fileExtension;
        $targetFile = $targetDir . $newFileName;

        // Increment the counter until a unique filename is found
        while (file_exists($targetFile)) {
            $counter++;
            $newFileName = "184757". "_Evidence" . "(" . $counter . ")." . $fileExtension;
            $targetFile = $targetDir . $newFileName;
        }
    }

    // Move the uploaded file to the specified folder with the new filename
    move_uploaded_file($tempFileName, $targetFile);

    echo "File uploaded successfully! New filename: " . $newFileName;
}
?>
