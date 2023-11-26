<?php 

    declare(strict_types=1);

    function get_email(object $pdo, string $email) {
        $query = "SELECT email FROM useraccount WHERE email = :email;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function set_user(object $pdo, string $fullname, string $street, $contactno, $file1, $email, $password, $tempFileName) {

        $query =    "INSERT INTO useraccount (password, name, contact, email, address) 
                    VALUES (:password, :name, :contactno, :email, :address);";
        $stmt = $pdo->prepare($query);

        // Password Decrypter
        // $options = [
        //     'cost' => 12
        // ];
        // $hashedPwd = password_hash($password, PASSWORD_BCRYPT, $options);

        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":name", $fullname);
        $stmt->bindParam(":contactno", $contactno);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":address", $street);
        $stmt->execute();

        $lastInsertedID = $pdo->lastInsertId(); // Get the auto-incremented ID

        create_file_path($file1, $lastInsertedID, $pdo, $tempFileName);
    }

    function create_file_path($file1, $lastInsertedID, $pdo, $tempFileName) {
        // File Handling
        $targetDir = dirname(dirname(__DIR__)) . "/AdminPage/IDPhotos/";

        $originalFileName = is_array($file1) ? $file1[0] : $file1;
        $tempFileName = is_array($tempFileName) ? $tempFileName[0] : $tempFileName;

        // Generate a new unique filename to avoid conflicts
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $newFileName = $lastInsertedID . "_ID" . "." . $fileExtension;
        $targetFile = $targetDir . $newFileName;

        // Check if a file with the same name already exists
        if (file_exists($targetFile)) {
            // Handle filename conflict (you can modify this logic)
            $counter = 1;
            $newFileName = $lastInsertedID . "_ID" . "(" . $counter . ")." . $fileExtension;
            $targetFile = $targetDir . $newFileName;

            // Increment the counter until a unique filename is found
            while (file_exists($targetFile)) {
                $counter++;
                $newFileName = $lastInsertedID . "_ID" . "(" . $counter . ")." . $fileExtension;
                $targetFile = $targetDir . $newFileName;
            }
        }

        // Move uploaded files to a folder
        move_uploaded_file($tempFileName, $targetFile);

        $varTargetFile = '/AdminPage/IDPhotos/' . $newFileName;
        $escapedTargetFile = addslashes($varTargetFile);

        $sql2 ="INSERT INTO idphoto (idPath, idName)
                VALUES (:idPath, :idName);";

        $stmt = $pdo->prepare($sql2);
        $stmt->bindParam(":idPath",  $escapedTargetFile);
        $stmt->bindParam(":idName", $newFileName);
        $stmt->execute();

        $lastInsertedPhotoID = $pdo->lastInsertId(); // Get the auto-incremented ID

        $sql3 ="UPDATE useraccount SET photoID = :photoID WHERE useraccount.accID = '$lastInsertedID';";
        $stmt = $pdo->prepare($sql3);
        $stmt->bindParam(":photoID", $lastInsertedPhotoID);
        $stmt->execute();
    }
?>