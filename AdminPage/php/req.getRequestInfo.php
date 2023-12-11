<?php 

    $docID = $_GET['docID'];

    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM docstatus WHERE docID = $docID";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $pComment = '-----';

    if (!empty($row)) {
        
        $dbDateTime = $row['submitDate'];
        $pComment = $row['comment'];
        $pName = $row['name'];

        if(empty($row['contact'])){
            $pContact = '-----';
        } else {
            $pContact = $row['contact'];
        }

        $dateTimeObj = new DateTime($dbDateTime);
        $formattedDate = $dateTimeObj->format('F j, Y');
        $formattedTime = $dateTimeObj->format('g:i A');

        echo '<div class="header">
                <div class="card1">
                    <p>Date and time received:</p>
                    <h3>'. $formattedDate . '</h3>
                    <h3>' . $formattedTime . '</h3>
                </div>
                <div class="card1">
                    <p>Respondent name:</p>
                    <h3>' . $pName . '</h3>
                </div>   
                <div class="card1">
                    <p>Contact no.:</p>
                    <h3> ' . $pContact . '</h3>
                </div>     
            </div>';
    } else {
        echo '<div class="header">
                <div class="card1">
                    <p>Date and time received:</p>
                    <h3>' . '-----' . '</h3>
                    <h3>' . '</h3>
                </div>
                <div class="card1">
                    <p>Respondent name:</p>
                    <h3>' . '-----' . '</h3>
                </div>   
                <div class="card1">
                    <p>Contact no.:</p>
                    <h3> ' . '-----' . '</h3>
                </div>     
            </div>';
    }
    


// <div class="header">
//     <div class="card1">
//         <p>Date and time received:</p>
//         <h3>September 26, 2023</h3>
//         <h3>11:07 PM</h3>
//     </div>
//     <div class="card1">
//         <p>Respondent name:</p>
//         <h3>Ian Gerald Balbon</h3>
//     </div>   
//     <div class="card1">
//         <p>Contact no.:</p>
//         <h3>0976 045 9207</h3>
//     </div>     
// </div>
?>