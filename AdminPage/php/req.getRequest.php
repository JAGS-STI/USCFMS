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

    $sql1 = "SELECT * FROM docstatus WHERE docID = $docID;";

    $docstatus = $conn->query($sql1);
    $docstat = $docstatus->fetch_assoc();


    switch($docstat['docType']) {
        case 'Barangay Clearance':
            $sql = "SELECT * FROM doc2detail WHERE docID = $docID";
            break;
        case 'Barangay Indingency':
            $sql = "SELECT * FROM doc1detail WHERE docID = $docID";
            break;
        default:
            echo "<p>error or smthing</p>";
            die();
            break;
    }

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $date = new DateTime($row['bday']);
    $formattedDate = $date->format('F j, Y');

    if (!empty($row) && $docstat['docType'] === 'Barangay Clearance') {
        echo '<div class="fields">
                <div class="fldDetail">
                    <p>Document type:</p>
                    <p id="bold">'.$docstat['docType'].'</p>
                </div>
                <div class="fldDetail">
                    <p>Name:</p>
                    <p id="bold">'.$row['name'].'</p>
                </div>
                <div class="fldDetail">
                    <p>Address:</p>
                    <p id="bold">'.addslashes($row['fulladdress']).'</p>
                </div>
                <div class="fldDetail">
                    <p>Birthday:</p>
                    <p id="bold">'.$formattedDate.'</p>
                </div>
                <div class="fldDetail">
                    <p>Age:</p>
                    <p id="bold">'.$row['age'].'</p>
                </div>
                <div class="fldDetail">
                    <p>Citizenship:</p>
                    <p id="bold">'.$row['citizenship'].'</p>
                </div>
                <div class="fldDetail">
                    <p>Hair color:</p>
                    <p id="bold">'.$row['haircolor'].'</p>
                </div>
                <div class="fldDetail">
                    <p>Voter’s ID number:</p>
                    <p id="bold">'.$row['votersID'].'</p>
                </div>
                <div class="fldDetail">
                    <p>Civil status:</p>
                    <p id="bold">SINGLE</p>
                </div>
                <div class="fldDetail">
                    <p>Religion:</p>
                    <p id="bold">'.$row['religion'].'</p>
                </div>
                <div class="fldDetail">
                    <p>Complexion:</p>
                    <p id="bold">'.addslashes($row['complexion']).'</p>
                </div>
                <div class="fldDetail">
                    <p>Gender:</p>
                    <p id="bold">'.$row['gender'].'</p>
                </div>
                <div class="fldDetail">
                    <p>Height:</p>
                    <p id="bold">'.addslashes($row['height']).'"</p>
                </div>
                <div class="fldDetail">
                    <p>Weight:</p>
                    <p id="bold">'.addslashes($row['weight']).'</p>
                </div>
            </div>


            <div class="infosTitle">
                <h3>Contact person information</h3>
                <div class="underline"></div>
            </div>

            <div class="fields">
                <div class="fldDetail">
                    <p>Contact person:</p>
                    <p id="bold">'.$row['contactperson'].'</p>
                </div>
                <div class="fldDetail">
                    <p>Address:</p>
                    <p id="bold">'.addslashes($row['personaddress']).'</p>
                </div>
                <div class="fldDetail">
                    <p>Contact number:</p>
                    <p id="bold">'.$row['contactnum'].'</p>
                </div>
            </div>   ';
    }

    function generateBtn() {
        $docID = $_GET['docID'];

        $servername = "localhost";
        $username = "root";
        $password = ""; // Assuming no password for the root user
        $database = "uscfms";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql1 = "SELECT * FROM docstatus WHERE docID = $docID;";

        $docstatus = $conn->query($sql1);
        $docstat = $docstatus->fetch_assoc();

        switch($docstat['docType']) {
            case 'Barangay Clearance':
                echo '<button onclick="window.location.href =\'/USCFMS/DocTemplates/clearance.html\'">Generate PDF</button>';
                break;
            case 'Barangay Indingency':
                echo '<button onclick="window.location.href =\'/USCFMS/DocTemplates/Indingency.html\'">Generate PDF</button>';
                break;
            default:
                echo "<p>error or smthing</p>";
                die();
                break;
        }
    }

    // <div class="fields">
    //     <div class="fldDetail">
    //         <p>Document type:</p>
    //         <p id="bold">Barangay Clearance</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Name:</p>
    //         <p id="bold">Ian Gerald Balbon</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Address:</p>
    //         <p id="bold">SA BAHAY NILA RR</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Birthday:</p>
    //         <p id="bold">June 30, 2003</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Age:</p>
    //         <p id="bold">21</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Citizenship:</p>
    //         <p id="bold">Filipino</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Hair color:</p>
    //         <p id="bold">Brown</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Voter’s ID number:</p>
    //         <p id="bold">N/A</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Civil status:</p>
    //         <p id="bold">Single</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Religion:</p>
    //         <p id="bold">Roman Catholic</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Complexion:</p>
    //         <p id="bold">Brown</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Gender:</p>
    //         <p id="bold">Female</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Height:</p>
    //         <p id="bold">5' 4"</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Weight:</p>
    //         <p id="bold">53 kgs</p>
    //     </div>
    // </div>


    // <div class="infosTitle">
    //     <h3>Contact person information</h3>
    //     <div class="underline"></div>
    // </div>

    // <div class="fields">
    //     <div class="fldDetail">
    //         <p>Contact person:</p>
    //         <p id="bold">Jherico Medina</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Address:</p>
    //         <p id="bold">SA BAHAY NILA RR</p>
    //     </div>
    //     <div class="fldDetail">
    //         <p>Contact number:</p>
    //         <p id="bold">099999999999</p>
    //     </div>
    // </div>   
    
?>