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
        $currentDate = new DateTime();

        // Format the current date in the same format
        $currentFormattedDate = $currentDate->format('jS \d\a\y \of F, Y');
        
        echo '<div class="topLogo">
                <div class="logos">
                    <img src ="media/ususan_logo.png">
                    <img src ="\USCFMS\DocTemplates\media\taguig_logo.png">
                </div>
                <div class="topTitle">
                    <h3>REPUBLIKA NG PILIPINAS</h3>
                    <h1 id="headTitle">BARANGAY USUSAN</h1>
                    <h3>LUNGSOD TAGUIG</h3>
                    <p id="add">01 Tomasa Avenue, Tomasa Subdivision, Barangay Ususan, Lungsod Taguig <br>
                        Telepono: 02-8-6409066 o 02-8-6282841 Email: brgy.ususan@gmail.com</p>
                </div>
            </div>    

            <!-- Left content START -->

            <div class="leftContents">
                <div class="pic">
                    <img src="\USCFMS\DocTemplates\media\kapitana.png">
                </div>
                <div class="nameInfos">
                    <div class="nameInfosTop">
                        <p>Hon. Marilyn “Marie” F. Marcelino</p>
                        <p>Punong Barangay</p>
                    </div>

                <div class="nameInfosContent">
                    <p>Hon. Jim Albert C. Flores</p>
                    <p>Barangay Kagawad</p>
                </div>
                <div class="nameInfosContent">
                    <p>Hon. Rachel G. Santos</p>
                    <p>Barangay Kagawad</p>
                </div>
                <div class="nameInfosContent">
                    <p>Hon. Gabrielle Anne R. Macelino</p>
                    <p>Barangay Kagawad</p>
                </div>
                <div class="nameInfosContent">
                    <p>Hon. Joselito R. Costes</p>
                    <p>Barangay Kagawad</p>
                </div>
                <div class="nameInfosContent">
                    <p>Hon. Romell R. Marcelino</p>
                    <p>Barangay Kagawad</p>
                </div>
                <div class="nameInfosContent">
                    <p>Hon. Manuel E. Carlos</p>
                    <p>Barangay Kagawad</p>
                </div>
                <div class="nameInfosContent">
                    <p>Hon. Raul M. Teodones</p>
                    <p>Barangay Kagawad</p>
                </div>
                <div class="nameInfosContent">
                    <p>Mr. Isagani B. Papa</p>
                    <p>Ingat Yaman ng Barangay</p>
                </div>
                <div class="nameInfosContent">
                    <p>Mrs. Rosario T. Esteban</p>
                    <p>Kalihim ng Barangay</p>
                </div>
            </div>

            <div class="line">

            </div>


        </div>
        <div class="last">
                <div class="tanod">
                    <p>TANOD HOTLINE</p>
                    <img src="\USCFMS\DocTemplates\media\telephone-svgrepo-com.png">
                </div>
                <div class="num">
                    <p>02-8-628-2841</p>
                    <p>0999-306-2222</p>
                </div>

                <div class="fire">
                    <p>FIRE & RESCUE</p>
                    <img src="\USCFMS\DocTemplates\media\telephone-svgrepo-com.png">
                </div>
                <div class="num">
                    <p>0995-458-3767</p>
                    <p>0968-548-1233</p>
                </div>

                <div class="health">
                    <p>Health Center</p>
                    <img src="\USCFMS\DocTemplates\media\telephone-svgrepo-com.png">
                </div>
                <div class="num">
                    <p>0961-734-0856</p>
                    <p>0961-734-0876</p>
                </div>
            </div>

        <div class="rightContents">
            <div class="rightHead">
                <h2>CERTIFICATE OF INDIGENCY</h2>
                <h3>EDUCATIONAL SUPPORT PROGRAM</h3>
            </div>

            <div class="letter">
                <p>TO WHOM IT MAY CONCERN:</p>
                <p id="text"> This is to certify that the person whose data indicated has been recorded in this <br>
                    Barangay as a resident with data below:</p>
            </div>

            <div class="table1">
                <table>
                    <tr>
                        <th width="220px">BENEFICIARY NAME:</th>
                        <th width="350px">'.$row['name'].'</th>
                    </tr>
                    <tr>
                        <td>DATE OF BIRTH:</td>
                        <td>'.$formattedDate.'</td>
                    </tr>
                    <tr>
                        <td>VIN / PRECINT NO.:</td>
                        <td>'.$row['vin'].'</td>
                    </tr>
                    <tr>
                        <td>NO. OF YEARS RESIDING IN USUSAN:</td>
                        <td>'.$row['years'].'</td>
                    </tr>
                    <tr>
                        <td>ADDRESS:</td>
                        <td>'.$row['address'].'</td>
                    </tr>
                    <tr>
                        <td>PURPOSE:</td>
                        <td>'.$row['purpose'].'</td>
                    </tr>
                    <tr>
                        <td>GRADE / LEVEL:</td>
                        <td>'.$row['grade'].'</td>
                    </tr>
                    <tr>
                        <td>EDUCATIONAL / INSTITUTIONAL:</td>
                        <td>'.$row['education'].'</td>
                    </tr>
                    <tr>
                        <td>REQUESTING / SUPPORT INSTITUTION</td>
                        <td>'.$row['request'].'</td>
                    </tr>
                </table>
            </div>

            <div class="table2">
            <p id="certReq">This certification is being issued upon the request of:</p>
                <table>
                    <tr>
                        <th width="220px">AUTHORIZED REPRESENTATIVE:</th>
                        <th width="350px"></th>
                    </tr>
                    <tr>
                        <td>DATE OF BIRTH:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>VIN / PRECINT NO.:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>NO. OF YEARS RESIDING IN USUSAN:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>ADDRESS:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>RELATIONSHIP:</td>
                        <td></td>
                    </tr>
                </table>
                <p id="issueDate">Issued this '.$currentFormattedDate.' at the Barangay Hall, Ususan, Taguig City.</p>
            </div>
            <div class="CapitanName">
                    <h4>MARILYN F. MARCELINO</h4>
                    <p>Punong Barangay</p>
                </div>

                <div class="seal">
                    <h5>SS. NO. 11-29- 12167-</h5>
                    <h5>NOT VALID WITHOUT DRY SEAL</h5>
                </div>
            </div>';

    } else if (!empty($row) && $docstat['docType'] === 'Barangay Clearance') {

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
                <img src="'.$row['photoPath'].'">
            </div>
        
            <div class="infoDetails">
                <div class="details1">
                    <p id="red">NAME: </p>
                    <p>'.$row['name'].'</p>
                </div>
                <div class="details1">
                    <p id="red">ADDRESS: </p>
                    <p>'.$row['fulladdress'].'</p>
                </div>
                <div class="details1">
                    <p id="red">BIRTH DATE: </p>
                    <p>'.$formattedDate.'</p>
                </div>
                <div class="details1">
                    <p id="red">AGE: </p>
                    <p>'.$row['age'].' yrs. old</p>
                </div>
                <div class="details1">
                    <p id="red">GENDER: </p>
                    <p>'.$row['gender'].'</p>
                </div>
                <div class="details1">
                    <p id="red">RELIGION: </p>
                    <p>'.$row['religion'].'</p>
                </div>
                <div class="details1">
                    <p id="red">CITIZENSHIP: </p>
                    <p>'.$row['citizenship'].'</p>
                </div>
                <div class="details1">
                    <p id="red">VOTER’S ID NO.: </p>
                    <p>'.$row['votersID'].'</p>
                </div>
                <div id="second"class="details1">
                    <p id="red">HEIGHT: </p>
                    <p>'.$row['height'].'"</p>
                </div>
                <div class="details1">
                    <p id="red">WEIGHT: </p>
                    <p>'.$row['weight'].'</p>
                </div>
                <div class="details1">
                    <p id="red">COMPLEXION: </p>
                    <p>'.$row['complexion'].'</p>
                </div>
                <div class="details1">
                    <p id="red">HAIR COLOR: </p>
                    <p>'.$row['haircolor'].'</p>
                </div>
                <div id="second"class="details1">
                    <p id="red">CONTACT PERSON: </p>
                    <p>'.$row['contactperson'].'</p>
                </div>
                <div class="details1">
                    <p id="red">ADDRESS: </p>
                    <p>'.$row['personaddress'].'</p>
                </div>
                <div class="details1">
                    <p id="red">CONTACT NO.: </p>
                    <p>'.$row['contactnum'].'</p>
                </div>
                <div class="details1">
                    <p id="red">PURPOSE: </p>
                    <p>'.$row['purpose'].'</p>
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