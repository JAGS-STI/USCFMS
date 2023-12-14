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

    $responsiveRate = 3;

    $sql = "SELECT * FROM concernsurvey WHERE concernID = $concernID;";
    // Execute the SQL query to retrieve the data from the database
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (isset($row)) {
        $sql2 =   "SELECT name, email, contact FROM useraccount ua JOIN concerndetail cd ON cd.accID = ua.accID 
        WHERE cd.concernID = $concernID;";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        
        $dbDateTime = $row['datetime'];

        $dateTimeObj = new DateTime($dbDateTime);
        $formattedDate = $dateTimeObj->format('F j, Y');
        $formattedTime = $dateTimeObj->format('g:i A');
        

        echo '<div class="shadow">
            <div class="popup">
                <div class="PopTitle">
                    <h3>Survey result</h3>
                </div>
            
                <div class="header1">
                    <div class="card1">
                        <p>Date and time received:</p>
                        <h3>'.$formattedDate.'</h3>
                        <h3>'.$formattedTime.'</h3>
                    </div>
                    <div class="card1">
                        <p>Respondent name:</p>
                        <h3>'.$row2['name'].'</h3>
                    </div>
                </div>
                <div class="header2">
                    <div class="card1">
                        <p>Contact no.:</p>
                        <h3>'.$row2['contact'].'</h3>
                    </div>
                    <div class="card1">
                        <p>Email address:</p>
                        <h3>'.$row2['email'].'</h3>
                    </div>
                </div>

                <div class="closeBtn" id="downloadPdf" onclick="toggleSurveyPanel(\'close\')">
                    <img src="media/button-error-svgrepo-com.svg">
                </div>

                <div class="popContent">
                    <div id="top" class="title">
                        <h1 id="subTitle">Concern Details</h1>
                        <div class="underline"></div>
                        <div class="questions">
                            <div class="q1">
                                <p>Did you receive timely assistance for your concern?</p>';
                                if ($row['timely'] === 'true') {
                                    echo '<div class="answers">     
                                        <img src="media/radio-button-checked-svgrepo-com.png">
                                        <p>Yes</p>
                                    </div>';
                                } else {
                                    echo '<div class="answers">     
                                        <img src="media/radio-button-unchecked-svgrepo-com.png">
                                        <p>No</p>
                                    </div>';
                                }   
                            echo '</div>
                            <div class="q2">
                                <p>Rate the responsiveness of the Barangay authorities in addressing your concern: </p>';
                                echo '<div class="answers">';

                                // Loop to generate star images based on $responsiveRate
                                for ($i = 1; $i <= 5; $i++) {
                                    $imageName = ($i <= $responsiveRate) ? 'star.png' : 'star-svgrepo-com.png';
                                    echo '<img src="media/' . $imageName . '">';
                                }

                                echo '</div>
                            </div>
                        </div>   
                    </div>
                    <div class="title">
                        <h1 id="subTitle">User Experience</h1>
                        <div class="underline"></div>
                        <div class="questions">
                            <div class="q1">
                                <p>Did you receive timely assistance for your concern?</p>';
                                if ($row['transparency'] === 'true') {
                                    echo '<div class="answers">     
                                        <img src="media/radio-button-checked-svgrepo-com.png">
                                        <p>Yes</p>
                                    </div>';
                                } else {
                                    echo '<div class="answers">     
                                        <img src="media/radio-button-unchecked-svgrepo-com.png">
                                        <p>No</p>
                                    </div>';
                                }
                                echo '</div>
                            </div>
            
                            <div class="q2">
                                <p>Rate the responsiveness of the Barangay authorities in addressing your concern: </p>'; 
                                echo '<div class="answers">';

                                // Loop to generate star images based on $responsiveRate
                                for ($i = 1; $i <= 5; $i++) {
                                    $imageName = ($i <= $responsiveRate) ? 'star.png' : 'star-svgrepo-com.png';
                                    echo '<img src="media/' . $imageName . '">';
                                }

                                echo '</div>
                        </div>     
                    </div>
                    <div class="title">
                        <h1 id="subTitle">Transparency and Communication</h1>
                        <div class="underline"></div>
                        <div class="questions">
                            <div class="q1">
                                <p>Did you receive updates regarding the status and resolution of your concern?</p>'; 
                                if ($row['transparency'] === 'true') {
                                    echo '<div class="answers">     
                                        <img src="media/radio-button-checked-svgrepo-com.png">
                                        <p>Yes</p>
                                    </div>';
                                } else {
                                    echo '<div class="answers">     
                                        <img src="media/radio-button-unchecked-svgrepo-com.png">
                                        <p>No</p>
                                    </div>';
                                }
                            echo '</div>
            
                            <div class="q2">
                                <p>Were you satisfied with the level of transparency in the process?</p>'; 
                                if ($row['transparency'] === 'true') {
                                    echo '<div class="answers">     
                                        <img src="media/radio-button-checked-svgrepo-com.png">
                                        <p>Yes</p>
                                    </div>';
                                } else {
                                    echo '<div class="answers">     
                                        <img src="media/radio-button-unchecked-svgrepo-com.png">
                                        <p>No</p>
                                    </div>';
                                }
                            echo '</div>
                        </div> 
                    </div>   
                    <div class="title">
                        <h1 id="subTitle">Additional Comments</h1>
                        <div class="underline"></div>
                        <div class="questions">
                            <div class="q1" style="width: 100%;">
                                <p>Is there anything else you would like to share regarding your experience or concerns that were not covered in this survey? </p>  
                                <div class="longbox">
                                    <textarea id="desc" name="desc" rows="5" cols="100" placeholder="Type here"></textarea>
                                </div>   
                            </div>
                        </div> 
                    </div>   
                </div>
            </div>
        </div>';
    }

    // <div class="shadow">
    //     <div class="popup">
    //         <div class="PopTitle">
    //             <h3>Survey result</h3>
    //         </div>
        
    //         <div class="header1">
    //             <div class="card1">
    //                 <p>Date and time received:</p>
    //                 <h3>September 26, 2023</h3>
    //                 <h3>11:07 PM</h3>
    //             </div>
    //             <div class="card1">
    //                 <p>Respondent name:</p>
    //                 <h3>Ian Gerald Balbon</h3>
    //             </div>
    //         </div>
    //         <div class="header2">
    //             <div class="card1">
    //                 <p>Contact no.:</p>
    //                 <h3>0976 045 9207</h3>
    //             </div>
    //             <div class="card1">
    //                 <p>Email address:</p>
    //                 <h3>email@domain.com</h3>
    //             </div>
    //         </div>

    //         <div class="closeBtn" id="downloadPdf" onclick="toggleSurveyPanel('close')">
    //             <img src="media/button-error-svgrepo-com.svg">
    //         </div>

    //         <div class="popContent">
    //             <div id="top" class="title">
    //                 <h1 id="subTitle">Concern Details</h1>
    //                 <div class="underline"></div>
    //                 <div class="questions">
    //                     <div class="q1">
    //                         <p>Did you receive timely assistance for your concern?</p>  
    //                         <div class="answers">
    //                             <img src="media/radio-button-checked-svgrepo-com.svg">
    //                             <p>Yes</p>  
    //                         </div>    
    //                     </div>
        
    //                     <div class="q2">
    //                         <p>Rate the responsiveness of the Barangay authorities in addressing your concern: </p>  
    //                         <div class="answers">
    //                             <img src="media/star.svg">
    //                             <img src="media/star.svg">
    //                             <img src="media/star.svg">
    //                             <img src="media/star.svg">
    //                             <img src="media/star.svg">
    //                         </div>    
    //                     </div>
    //                 </div>   
    //             </div>
    //             <div class="title">
    //                 <h1 id="subTitle">User Experience</h1>
    //                 <div class="underline"></div>
    //                 <div class="questions">
    //                     <div class="q1">
    //                         <p>Did you receive timely assistance for your concern?</p>  
    //                         <div class="answers">
    //                             <img src="media/star.svg">
    //                             <img src="media/star.svg">
    //                             <img src="media/star.svg">
    //                             <img src="media/star.svg">
    //                             <img src="media/star.svg">
    //                         </div>    
    //                     </div>
        
    //                     <div class="q2">
    //                         <p>Rate the responsiveness of the Barangay authorities in addressing your concern: </p>  
    //                         <div class="answers">     
    //                             <img src="media/radio-button-checked-svgrepo-com.svg">
    //                             <p>Yes</p>
    //                         </div>    
    //                     </div>
    //                 </div>     
    //             </div>
    //             <div class="title">
    //                 <h1 id="subTitle">Transparency and Communication</h1>
    //                 <div class="underline"></div>
    //                 <div class="questions">
    //                     <div class="q1">
    //                         <p>Did you receive updates regarding the status and resolution of your concern?</p>  
    //                         <div class="answers">
    //                             <img src="media/radio-button-checked-svgrepo-com.svg">
    //                             <p>Yes</p>
    //                         </div>    
    //                     </div>
        
    //                     <div class="q2">
    //                         <p>Were you satisfied with the level of transparency in the process?</p>  
    //                         <div class="answers">     
    //                             <img src="media/radio-button-checked-svgrepo-com.svg">
    //                             <p>Yes</p>
    //                         </div>    
    //                     </div>
    //                 </div> 
    //             </div>   
    //             <div class="title">
    //                 <h1 id="subTitle">Additional Comments</h1>
    //                 <div class="underline"></div>
    //                 <div class="questions">
    //                     <div class="q1">
    //                         <p>Is there anything else you would like to share regarding your experience or concerns that were not covered in this survey? </p>  
    //                         <div class="longbox">
    //                             <textarea id="desc" name="desc" rows="5" cols="100" placeholder="Type here"></textarea>
    //                         </div>   
    //                     </div>
    //                 </div> 
    //             </div>   
    //         </div>
    //     </div>
    // </div>

?>