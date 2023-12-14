<?php
    require_once dirname(dirname(__DIR__)) . "/php/config_session.inc.php";
    require_once dirname(dirname(__DIR__)) . "/php/signup_view.inc.php";
    require_once dirname(dirname(__DIR__)) . "/php/login_view.inc.php";

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
    if (empty($_SESSION["user_id"]) || !isset($_SESSION["user_id"])) {
        echo 'Error: Cannot find $_SESSION["user_id"]';
        echo 'Please go back to the home page';
        header("Location: ../UserLogin/UserLogin.html?timeout=true");
        die();
    }

    $accId = $_SESSION["user_id"];

    $check = "SELECT COUNT(`concernID`) AS `countToday` FROM `concerndetail` WHERE `accID` = $accId AND DATE(`submitDate`) = CURDATE();";
    $result = $conn->query($check);

    if ($result) {
        $row = $result->fetch_assoc();
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die();
    }

    if($row['countToday'] > 3) {
        echo $row['countToday'];
        header("Location: /USCFMS/UserPage/UserHome/UserHome.html?submit=max");
    } else {
        $location = $_POST['locationBox'];
        $file1 = $_FILES['fileInput']['name'];
        $concern = $_POST['concernBox'];
        $description = $_POST['desc'];

        // Insert data into the database
        $sql = "INSERT INTO concerndetail (accID, location, concernType, description, status)
                VALUES ('$accId', '$location', '$concern', '$description', 'Unread');";

        if ($conn->query($sql) === TRUE) {
            $lastInsertedID = $conn->insert_id; // Get the auto-incremented ID
            echo "Record inserted successfully. Concern ID: " . $lastInsertedID;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // File Handling
        $targetDir = dirname(dirname(dirname(__DIR__))) . "/AdminPage/uploads/";

        foreach ($_FILES['fileInput']['tmp_name'] as $key => $tempFileName) {
            $originalFileName = $_FILES['fileInput']['name'][$key];

            // Generate a new unique filename to avoid conflicts
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $newFileName = $lastInsertedID . "_Evidence" . $key . "." . $fileExtension;
            $targetFile = $targetDir . $newFileName;

            // Check if a file with the same name already exists
            if (file_exists($targetFile)) {
                // Handle filename conflict (you can modify this logic)
                $counter = 1;
                $newFileName = $lastInsertedID . "_Evidence" . $key . "(" . $counter . ")." . $fileExtension;
                $targetFile = $targetDir . $newFileName;

                // Increment the counter until a unique filename is found
                while (file_exists($targetFile)) {
                    $counter++;
                    $newFileName = $lastInsertedID . "_Evidence" . $key . "(" . $counter . ")." . $fileExtension;
                    $targetFile = $targetDir . $newFileName;
                }
            }

            // Move uploaded files to a folder
            move_uploaded_file($tempFileName, $targetFile);

            $varTargetFile = '/AdminPage/uploads/' . $newFileName;
            $escapedTargetFile = addslashes($varTargetFile);

            $sql2 ="INSERT INTO concernphoto (concernID, photoEvidence, evidenceName, evidenceDate)
                    VALUES ('$lastInsertedID', '$escapedTargetFile', '$newFileName', '$currentDateTime');";

            if ($conn->query($sql2) !== TRUE) {
                echo "Error: " . $sql2 . "<br>" . $conn->error;
            }
        }

        echo "<br>Record inserted successfully. Directory Path: " . $escapedTargetFile;
        // Match found, redirect to the next HTML page
        header("Location: \USCFMS\UserPage\UserAccPage\UserAccPage.html?submit=success");
    }
    
    $conn->close();
?>
