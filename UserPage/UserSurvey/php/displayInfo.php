<?php

    // Assuming you have a database connection established
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "uscfms";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $concernID = $_GET['concernID'];
    $cd = $_GET['cd'];

    $check =   "SELECT cd.status, cd.submitDate FROM concerndetail cd LEFT JOIN concernsurvey cs ON cd.concernID = cs.concernID
                WHERE cd.concernID = $concernID AND cs.concernID IS NULL;";
    $result = $conn->query($check);
    $row = $result->fetch_assoc();

    $numericValue = (int) date('YmdHis', strtotime($row['submitDate']));

    if(isset($row['status']) && $row['status'] === 'Resolved' && $numericValue === (int)$cd) {
        $sql2 =   "SELECT name, email, contact FROM useraccount ua JOIN concerndetail cd ON cd.accID = ua.accID 
        WHERE cd.concernID = $concernID;";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        echo '<form id="concernForm" action="php/process_survey.php?concernID=<?php echo $_GET[\'concernID\'] ?>" method="post" enctype="multipart/form-data">
            <div class="topFld">
                <p id="bold">Instructions</p>
                <ul>
                    <li>Fill up the form below.</li>
                    <li>Submission is optional. If you prefer not to submit, please close this website.</li>
                </ul>
                <hr>
            </div>
            <div class="field1">
                <h1 id="headTitle">Personal Information</h1>
                <div class="underline"></div>
                <p id="required">Fields with * are required</p>
                <div class="fld">
                    <p>Name:</p>
                    <p id="bold">'.$row2['name'].'</p>
                </div>
                <div class="fld">
                    <p>Email address:</p>
                    <p id="bold">'.$row2['email'].'</p>
                </div>
                <div class="fld">
                    <p>Contact number:</p>
                    <p id="bold">'.$row2['contact'].'</p>
                </div>
                <div class="fld">
                    <p>Feedback for concern ID:</p>
                    <p id="bold">SC-'.$concernID.'</p>
                </div>

                <p id="inf">The information above will be used and kept on this concern submission.</p>
            </div>

            <div class="field2">
                <h1 id="concernTitle">Concern Details</h1>
                <div class="underline"></div>
                <div class="fldConcern">
                    <p id="firstQ">Did you receive timely assistance for your concern? </p>
                    <p>Rate the responsiveness of the Barangay authorities in addressing your concern: </p>
                </div>
                <div class="choicesTimely">
                    <div class="fldChoices">
                        <input type="checkbox" id="timelyY" name="timelyY" required>
                        <label for="yesAns">Yes</label>
                    </div>
                    <div class="fldChoices">
                        <input type="checkbox" id="timelyN" name="timelyN" value="noCheck" required>
                        <label for="noAns">No</label>
                    </div>            
                </div>

                <div class="choice2">                                                                    
                    <div class="stars" onclick="rateStar(event)">
                        <img src="media\star-svgrepo-com.png" data-value="1">
                        <img src="media\star-svgrepo-com.png" data-value="2">
                        <img src="media\star-svgrepo-com.png" data-value="3">
                        <img src="media\star-svgrepo-com.png" data-value="4">
                        <img src="media\star-svgrepo-com.png" data-value="5">
                        <input type="text" value="" id="responsiveRate" name="responsiveRate" style="z-index: -1;" required>
                    </div>
                </div>
            </div>

            <div class="field2">
                <h1 id="concernTitle">User Experience</h1>
                <div class="underline"></div>
                <div class="fldConcern">
                    <p id="firstQ">Were you able to easily navigate and use the platform? </p>
                    <p>How would you rate your overall experience using this platform? </p>
                </div>

                <div class="choicesNagivation">
                    <div class="fldChoices">
                        <input type="checkbox" id="nagivationY" name="nagivationY" value="yesCheck" required>     
                        <label for="yesAns">Yes</label>
                    </div>
                    <div class="fldChoices">
                        <input type="checkbox" id="nagivationN" name="nagivationN" value="noCheck" required>
                        <label for="noAns">No</label>
                    </div>            
                </div>

                <div class="choice2">
                    <<div class="stars2" onclick="rateStar2(event)">
                        <img src="media\star-svgrepo-com.png" data-value="1">
                        <img src="media\star-svgrepo-com.png" data-value="2">
                        <img src="media\star-svgrepo-com.png" data-value="3">
                        <img src="media\star-svgrepo-com.png" data-value="4">
                        <img src="media\star-svgrepo-com.png" data-value="5">
                        <input type="text" value="" id="overallRate" name="overallRate" style="z-index: -1;" required>
                    </div>
                </div>
            </div>

            <div class="field2">
                <h1 id="concernTitle">Transparency and Communication</h1>
                <div class="underline"></div>
                <div class="fldConcern">
                    <p id="firstQ">Did you receive updates regarding the status and resolution of your concern? </p>
                    <p>Were you satisfied with the level of transparency in the process?</p>
                </div>

                <div class="choicesUpdateStat">
                    <div class="fldChoices">
                        <input type="checkbox" id="UpdateStatY" name="UpdateStatY" value="yesCheck" required>
                        <label for="yesAns">Yes</label>
                    </div>
                    <div class="fldChoices">
                        <input type="checkbox" id="UpdateStatN" name="UpdateStatN" value="noCheck" required>
                        <label for="noAns">No</label>
                    </div>            
                </div>

                <div class="choicesTransparency">
                    <div class="fldChoices">
                        <input type="checkbox" id="transparencyY" name="transparencyY" value="yesCheck" required>
                        <label for="yesAns">Yes</label>
                    </div>
                    <div class="fldChoices">
                        <input type="checkbox" id="transparencyN" name="transparencyN" value="noCheck" required>
                        <label for="noAns">No</label>
                    </div>
                </div>
            </div>

            <div class="field2">
                <h1 id="concernTitle">Additional Comments</h1>
                <div class="underline"></div>
                <div class="questions">
                    <div class="q1">
                        <p>Is there anything else you would like to share regarding your experience or concerns that were not covered in this survey? </p>  
                        <div class="longbox">
                            <textarea id="addComment" name="addComment" rows="5" cols="100" placeholder="Type here"></textarea>
                        </div>   
                    </div>
                </div> 
            </div>   


            <div class="consent">
                <p id="consent">I consent to the processing of my personal data in accordance with the Republic Act 10173 or also known as the Data Privacy Act of 2012.</p>
                <input id="check" type="checkbox" required/>
            </div>
            <button id="submit">Submit</button>
            
            
        </form>';
    }
    
    $conn->close();
?>