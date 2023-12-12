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

    if (!empty($row) && $docstat['docType'] === 'Barangay Indingency') {
        $currentDate = date('n/j/Y');
        $validDate = date('n/j/Y', strtotime('+6 months'));
        
        echo '<div class="topLogo">
        <div class="logos">
            <img src ="media/ususan_logo.png">
            <img src ="\USCFMS\DocTemplates\media\taguig_logo.png">
        </div>
        <div class="topTitle">
            <p id="republic">Republic of the Philippines</p>
            <p>BARANGAY USUSAN</p>
            <p>Taguig City</p>
            <h2>BARANGAY CLEARANCE</h2>
        </div>
        <div class="rightInfo">
            <div class="details">
                <p id="bold">Control no.: </p>
                <p>0106-C-0650</p>
            </div>
            <div class="details">
                <p id="bold">Prepared by: </p>
                <p>N. CRUZ</p>
            </div>
            <div class="details">
                <p id="bold">Date of issue: </p>
                <p>'.$currentDate.'</p>
            </div>
            <div class="details">
                <p id="bold">Valid until: </p>
                <p>'.$validDate.'</p>
            </div>
        </div>
    </div>
    
    <!-- SubContent START -->
    
    <div class="pageInfo">
        <div class="pic">
            <img src="\USCFMS\DocTemplates\media\image-svgrepo-com.png">
        </div>
    
        <div class="infoDetails">
            <div class="details1">
                <p id="red">NAME: </p>
                <p>'. $row['name'] .'</p>
            </div>
            <div class="details1">
                <p id="red">ADDRESS: </p>
                <p>PDS, BCDA, Barangay Ususan, Taguig City</p>
            </div>
            <div class="details1">
                <p id="red">BIRTH DATE: </p>
                <p>September 15, 2002</p>
            </div>
            <div class="details1">
                <p id="red">AGE: </p>
                <p>21 yrs. old</p>
            </div>
            <div class="details1">
                <p id="red">GENDER: </p>
                <p>Female</p>
            </div>
            <div class="details1">
                <p id="red">RELIGION: </p>
                <p>Catholic</p>
            </div>
            <div class="details1">
                <p id="red">CITIZENSHIP: </p>
                <p>Filipino</p>
            </div>
            <div class="details1">
                <p id="red">VOTER’S ID NO.: </p>
                <p>N/A</p>
            </div>
            <div id="second"class="details1">
                <p id="red">HEIGHT: </p>
                <p>5\'4"</p>
            </div>
            <div class="details1">
                <p id="red">WEIGHT: </p>
                <p>53 kgs.</p>
            </div>
            <div class="details1">
                <p id="red">COMPLEXION: </p>
                <p>Brown</p>
            </div>
            <div class="details1">
                <p id="red">HAIR COLOR: </p>
                <p>Black"</p>
            </div>
            <div id="second"class="details1">
                <p id="red">CONTACT PERSON: </p>
                <p>EDUARDO VISTAL JUARBAL JR.</p>
            </div>
            <div class="details1">
                <p id="red">ADDRESS: </p>
                <p>PDS, BCDA, Barangay Ususan, Taguig City</p>
            </div>
            <div class="details1">
                <p id="red">CONTACT NO.: </p>
                <p>09123456789</p>
            </div>
            <div class="details1">
                <p id="red">PURPOSE: </p>
                <p>BIR REQUIREMENT</p>
            </div>
        </div>
    
        <div class="certify">
            <p>This is to certify that the applicant is a bonafide resident of Barangay Ususan, whose name, photographs <br>
                and right thumb mark appears above. This certification serves as RECORD CLEARANCE upon request<br>
                of the aforesaid applicant.</p>
        </div>
    
    
        <div class="ending">
            <p id="verify">Verified by: </p>
    
            <div class="officialsName">
                <p>Ms. Rosario T. Esteban</p>
                <p>Hon. Marilyn “Marie” F. Marcelino</p>
            </div>
    
            <div class="officialsPositionSec">
                <p>Barangay Secretary</p>
            </div>
            <div class="officialsPositionChairman">
                <p>Barangay Chairman</p>
            </div>
        </div>
    </div>
    
    <div class="last">
        <p>BRGY. USUSAN FORM 01, REV. 12/2013</p>
    </div>';

    }

// <div class="topLogo">
//     <div class="logos">
//         <img src ="media/ususan_logo.png">
//         <img src ="\USCFMS\DocTemplates\media\taguig_logo.png">
//     </div>
//     <div class="topTitle">
//         <p id="republic">Republic of the Philippines</p>
//         <p>BARANGAY USUSAN</p>
//         <p>Taguig City</p>
//         <h2>BARANGAY CLEARANCE</h2>
//     </div>
//     <div class="rightInfo">
//         <div class="details">
//             <p id="bold">Control no.: </p>
//             <p>0106-C-0650</p>
//         </div>
//         <div class="details">
//             <p id="bold">Prepared by: </p>
//             <p>N. CRUZ</p>
//         </div>
//         <div class="details">
//             <p id="bold">Date of issue: </p>
//             <p>1/6/2022</p>
//         </div>
//         <div class="details">
//             <p id="bold">Valid until: </p>
//             <p>7/6/2022</p>
//         </div>
//     </div>
// </div>

// <!-- SubContent START -->

// <div class="pageInfo">
//     <div class="pic">
//         <img src="\USCFMS\DocTemplates\media\image-svgrepo-com.png">
//     </div>

//     <div class="infoDetails">
//         <div class="details1">
//             <p id="red">NAME: </p>
//             <p>SHEENA GEM ALEMAN JUARBAL</p>
//         </div>
//         <div class="details1">
//             <p id="red">ADDRESS: </p>
//             <p>PDS, BCDA, Barangay Ususan, Taguig City</p>
//         </div>
//         <div class="details1">
//             <p id="red">BIRTH DATE: </p>
//             <p>September 15, 2002</p>
//         </div>
//         <div class="details1">
//             <p id="red">AGE: </p>
//             <p>21 yrs. old</p>
//         </div>
//         <div class="details1">
//             <p id="red">GENDER: </p>
//             <p>Female</p>
//         </div>
//         <div class="details1">
//             <p id="red">RELIGION: </p>
//             <p>Catholic</p>
//         </div>
//         <div class="details1">
//             <p id="red">CITIZENSHIP: </p>
//             <p>Filipino</p>
//         </div>
//         <div class="details1">
//             <p id="red">VOTER’S ID NO.: </p>
//             <p>N/A</p>
//         </div>
//         <div id="second"class="details1">
//             <p id="red">HEIGHT: </p>
//             <p>5'4"</p>
//         </div>
//         <div class="details1">
//             <p id="red">WEIGHT: </p>
//             <p>53 kgs.</p>
//         </div>
//         <div class="details1">
//             <p id="red">COMPLEXION: </p>
//             <p>Brown</p>
//         </div>
//         <div class="details1">
//             <p id="red">HAIR COLOR: </p>
//             <p>Black"</p>
//         </div>
//         <div id="second"class="details1">
//             <p id="red">CONTACT PERSON: </p>
//             <p>EDUARDO VISTAL JUARBAL JR.</p>
//         </div>
//         <div class="details1">
//             <p id="red">ADDRESS: </p>
//             <p>PDS, BCDA, Barangay Ususan, Taguig City</p>
//         </div>
//         <div class="details1">
//             <p id="red">CONTACT NO.: </p>
//             <p>09123456789</p>
//         </div>
//         <div class="details1">
//             <p id="red">PURPOSE: </p>
//             <p>BIR REQUIREMENT</p>
//         </div>
//     </div>

//     <div class="certify">
//         <p>This is to certify that the applicant is a bonafide resident of Barangay Ususan, whose name, photographs <br>
//             and right thumb mark appears above. This certification serves as RECORD CLEARANCE upon request<br>
//             of the aforesaid applicant.</p>
//     </div>


//     <div class="ending">
//         <p id="verify">Verified by: </p>

//         <div class="officialsName">
//             <p>Ms. Rosario T. Esteban</p>
//             <p>Hon. Marilyn “Marie” F. Marcelino</p>
//         </div>

//         <div class="officialsPositionSec">
//             <p>Barangay Secretary</p>
//         </div>
//         <div class="officialsPositionChairman">
//             <p>Barangay Chairman</p>
//         </div>
//     </div>
// </div>

// <div class="last">
//     <p>BRGY. USUSAN FORM 01, REV. 12/2013</p>
// </div>

?>