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

    // Check if the user is logged-in
    if (empty($_SESSION["user_id"]) || !isset($_SESSION["user_id"])) {
        echo 'Error: Cannot find $_SESSION["user_id"]';
        echo 'Please go back to the home page';
        header("Location: /USCFMS/UserPage/UserLogin/UserLogin.html?timeout=true");
        die();
    }

    $accId = $_SESSION["user_id"];
    $check = "SELECT COUNT(`docID`) AS `countToday` FROM `docstatus` WHERE `accID` = $accId AND DATE(`dateReceived`) = CURDATE();";
    $result = $conn->query($check);

    if ($result) {
        $row = $result->fetch_assoc();
        if($row['countToday'] > 3) {
            echo $row['countToday'];
            header("Location: /USCFMS/UserPage/UserHome/UserHome.html?submit=max");
            die();
        }    
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die();
    }
    $file1 = $_FILES['fileInput']['name'];
    $tempFileName = $_FILES["fileInput"]["tmp_name"];
    $name = strtoupper($_POST['nameBox']);
    $age = strtoupper($_POST['ageBox']);
    $gender = strtoupper($_POST['genderBox']);
    $bday = $_POST['bdayBox'];
    $religion = !empty($_POST['religionBox']) ? strtoupper($_POST['religionBox']) : "N/A";
    $citizenship = strtoupper($_POST['citizenBox']);
    $fulladdress = addslashes(strtoupper($_POST['addressBox']));
    $votersID = !empty($_POST['voterBox']) ? strtoupper($_POST['voterBox']) : "N/A";
    $height = addslashes(strtoupper($_POST['heightBox']));
    $weight = addslashes(strtoupper($_POST['weightBox']));
    $complexion = !empty($_POST['complexionBox']) ? strtoupper($_POST['complexionBox']) : "N/A";
    $haircolor = strtoupper($_POST['hairBox']);
    $contactperson = !empty($_POST['contactPersonBox']) ? strtoupper($_POST['contactPersonBox']) : "N/A";
    $personaddress = !empty($_POST['contactAddBox']) ? addslashes(strtoupper($_POST['contactAddBox'])) : "N/A";
    $contactnum = !empty($_POST['contactNumBox']) ? $_POST['contactNumBox'] : "N/A";
    $purpose = strtoupper($_POST['purposeBox']);

    $sql = "INSERT INTO docstatus (docType, accID, status)
            VALUES ('Barangay Clearance', '$accId', 'Pending');";
    
    if ($conn->query($sql) === TRUE) {
        $lastInsertedID = $conn->insert_id; // Get the auto-incremented ID
        echo "Record inserted successfully. Concern ID: " . $lastInsertedID;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die();
    }

    $sql1 = "INSERT INTO doc2detail (docID, name, age, gender, bday, religion, citizenship, fulladdress, 
            votersID, height, weight, complexion, haircolor, contactperson, personaddress, contactnum, 
            purpose) VALUES ('$lastInsertedID', '$name', '$age', '$gender', '$bday', '$religion', '$citizenship', '$fulladdress', '$votersID', 
            '$height', '$weight', '$complexion', '$haircolor', '$contactperson', '$personaddress', '$contactnum', '$purpose');";
    
    if ($conn->query($sql1) === TRUE) {
        echo "Record doc2detail inserted successfully. docID: " . $lastInsertedID;
    } else {
        echo "Error: " . $sql1 . "<br>" . $conn->error;
        die();
    }

    // File Handling
    $targetDir = dirname(dirname(dirname(__DIR__))) . "/AdminPage/uploads/";

    $originalFileName = is_array($file1) ? $file1[0] : $file1;
    $tempFileName = is_array($tempFileName) ? $tempFileName[0] : $tempFileName;

    // Generate a new unique filename to avoid conflicts
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $newFileName = $lastInsertedID . "_ClearancePhoto" . "." . $fileExtension;
    $targetFile = $targetDir . $newFileName;

    // Check if a file with the same name already exists
    if (file_exists($targetFile)) {
        // Handle filename conflict (you can modify this logic)
        $counter = 1;
        $newFileName = $lastInsertedID . "_ClearancePhoto" . "(" . $counter . ")." . $fileExtension;
        $targetFile = $targetDir . $newFileName;

        // Increment the counter until a unique filename is found
        while (file_exists($targetFile)) {
            $counter++;
            $newFileName = $lastInsertedID . "_ClearancePhoto" . "(" . $counter . ")." . $fileExtension;
            $targetFile = $targetDir . $newFileName;
        }
    }

    error_log("Temp Name: ".$tempFileName."|Path: ".$targetFile);
    // Move uploaded files to a folder
    move_uploaded_file($tempFileName, $targetFile);

    $varTargetFile = '/USCFMS/AdminPage/uploads/' . $newFileName;
    $escapedTargetFile = addslashes($varTargetFile);

    $sql2 ="UPDATE doc2detail SET photoPath = '$escapedTargetFile' WHERE docID = $lastInsertedID ;";

    if ($conn->query($sql2) !== TRUE) {
        echo "Error: " . $sql2 . "<br>" . $conn->error;
        die();
    }

    // Match found, redirect to the next HTML page
    header("Location: \USCFMS\UserPage\UserAccPage\UserAccPage.html?submit=success");

    $conn->close();
?>