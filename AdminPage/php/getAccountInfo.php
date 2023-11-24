<?php

    $concernID = $_GET['concernID'];

    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT name, contact, email, address, description, photoID, location FROM useraccount, concerndetail 
            WHERE concerndetail.accID = useraccount.accID AND concerndetail.concernID = $concernID";
    // Execute the SQL query to retrieve the data from the database
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $pName = $row['name'];
    $pContact = $row['contact'];
    if (strlen($pContact) == 11) {
        $formattedPhoneNumber = preg_replace('/(\d{4})(\d{3})(\d{4})/', '$1 $2 $3', $pContact);
    } else {
        echo "Invalid phone number length.";
        exit;
    }
    $pEmail = $row['email'];
    $pAddress = $row['address'];
    $pLocation = $row['location'];
    $pDescription = $row['description'];

    echo    '<div class="firstRow">
                <div class="name">
                    <h4>Respondent name:</h4>
                    <p id="pName">' . $pName . '</p>
                </div>
                <div class="name">
                    <h4>Contact number:</h4>
                    <p id="pContact">' . $formattedPhoneNumber . '</p>
                </div>
            </div>
            <div class="secondRow">
                <div class="name">
                    <h4>Email address:</h4>
                    <p id="pEmail">' . $pEmail . '</p>
                </div>
                <div class="name">
                    <h4>Address:</h4>
                    <p id="pAddress">' . $pAddress . '</p>
                </div>
                <div class="name">
                    <h4>Incident location:</h4>
                    <p id="pLocation">' . $pLocation . '</p>
                </div>
            </div>
            <div class="concernDesc">
                <h4>Concern description:</h4>
                <p id="pDescription">' . $pDescription . '</p>
            </div>';

    /* OLD TEMPLATE
        <div class="firstRow">
                <div class="name">
                    <h4>Respondent name:</h4>
                    <p id="pName">Ian Gerald Balbon</p>
                </div>
                <div class="name">
                    <h4>Contact number:</h4>
                    <p id="pContact">0976 045 9207</p>
                </div>
            </div>
            <div class="secondRow">
                <div class="name">
                    <h4>Email address:</h4>
                    <p id="pEmail">email@email.com</p>
                </div>
                <div class="name">
                    <h4>Address:</h4>
                    <p id="pAddress">Tomasa Ave.</p>
                </div>
                <div class="name">
                    <h4>Incident location:</h4>
                    <p id="pLocation">Tomasa Ave.</p>
                </div>
            </div>
            <div class="concernDesc">
                <h4>Concern description:</h4>
                <p id="pDescription">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur.</p>
            </div> */
?>