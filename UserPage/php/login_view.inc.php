<?php

    function check_login_errors() {
        if (isset($_SESSION["errors_login"])) {
            $errors = $_SESSION["errors_login"];

            foreach ($errors as $error) {
                echo '<p class="form-error">' . $error . '</p>';
            }

            unset($_SESSION["errors_login"]);
        } else if(isset($_GET['login']) && $_GET['login'] === "success") {
            echo '<p class="form-success">Login successfully!</p>';
        }
    }

    function login_input() {
        if (isset($_SESSION["login_data"]["email"])) {
            echo '<input id="emailBox" name="emailBox" type="text" value="' . $_SESSION["login_data"]["email"] . '" placeholder="Enter email address"/>';
        } else {
            echo '<input id="emailBox" name="emailBox" type="text" placeholder="Enter email address"/>';
        }
        
    }

    function output_account() {
        if (isset($_SESSION["user_id"])) {
            require_once 'dbh.inc.php';
            require_once 'login_model.inc.php';
            $userConcernList = get_concernDetail($pdo, $_SESSION["user_id"]);
            $userMessageList = get_messageDetail($pdo, $_SESSION["user_id"]);

            $concernID = isset($_GET['concernID']) ? $_GET['concernID'] : '';
            if (!empty($concernID))
            $_SESSION["images"] = get_crnImage($pdo, $concernID);

            $_SESSION["user_concernList"] = $userConcernList;
            // foreach ($userConcernList as $value) {
            //     foreach ($value as $row) {
            //         error_log($row);
            //     }
            // }
            $_SESSION["user_messageList"] = $userMessageList;
            // foreach ($userMessageList as $value) {
            //     foreach ($value as $row) {
            //         error_log($row);
            //     }
            // }
            $_SESSION["notifications"] = 0;

            $result = $_SESSION["user_messageList"];
            if (count($result) > 0) {
                for ($row = 0; $row < count($result); $row++) {
                    $data = $result[$row];
                    if ($data['isRead'] === 0) {
                        $_SESSION["notifications"] += 1;
                    }
                }
            }
            echo '<img id="profile_pic" onclick="toaccount()" src="/USCFMS/UserPage/UserHome/Media/user-circle-svgrepo-com(1).svg" />';
            if ($_SESSION["notifications"] > 0)
            echo '<div class="accdot" style="width: 6px; height: 6px; background: red; border-radius: 50px;width: 12px;
                    height: 12px;background: red;border-radius: 50px;position: absolute;right: 42px;top: 5px;font-size: 10px;color: white;
                    display: flex;align-items: center;justify-content: center;">' . $_SESSION["notifications"] . '</div>';
            echo '<div class="register">
                    <p id="user_name" onclick="toaccount()">Logged in as: ' . $_SESSION["user_name"] . '</p>
                    <form action="../php/logout.inc.php" method="post">
                        <button class="logoutBtn">Log-out</button>
                    </form>
                </div>';
        } else {
            echo '<img id="profile_pic" onclick="toggleLoginPopup(\'open\')" src="/USCFMS/UserPage/UserHome/Media/user-circle-svgrepo-com(1).svg" />';
            echo '<div class="register">
                    <p id="login" onclick="tologin()">Log in</p>
                    <p>|</p>
                    <p id="signup" onclick="tosignup()">Sign up</p>
                </div>';
        }
    }

    function tosubmitBtn() {
        if (isset($_SESSION["user_id"])) {
            echo '<a href="/USCFMS/UserPage/UserConcern/UserConcern.html">Submit Concern</a>';
        } else {
            echo '<a onclick="toggleLoginPopup(\'open\')">Submit Concern</a>';
        }
    }

    function torequestBtn() {
        if (isset($_SESSION["user_id"])) {
            echo '<a id="request" href="/USCFMS/UserPage/UserDocRequest/UserDocRequest.html">Request document(s)</a>';
        } else {
            echo '<a id="request" onclick="toggleLoginPopup(\'open\')">Request document(s)</a>';
        }
    }

    function tosubmitHomeBtn() {
        if (isset($_SESSION["user_id"])) {
            echo '<button class="submit" onclick="tosubmitconcern()">SUBMIT</button>';
        } else {
            echo '<button class="submit" onclick="toggleLoginPopup(\'open\')">SUBMIT</button>';
        }
    }

    function torequestHomeBtn() {
        if (isset($_SESSION["user_id"])) {
            echo '<button class="submit" onclick="tosubmitrequest()">SUBMIT</button>';
        } else {
            echo '<button class="submit" onclick="toggleLoginPopup(\'open\')">SUBMIT</button>';
        }
    }

    function userDetail() {
        if (isset($_SESSION["user_id"])) {
            $formattedContact = substr($_SESSION["user_contact"], 0, 4) . ' ' . substr($_SESSION["user_contact"], 4, 3) . ' ' . substr($_SESSION["user_contact"], 7);
            echo '<div class="field1">
                    <h1 id="headTitle">Personal Information</h1>
                    <div class="underline"></div>
                    <p id="required">Fields with * are required</p>
                    <div class="fld">
                        <p>You are logged in as:</p>
                        <p id="bold">' . $_SESSION["user_name"] . '</p>
                    </div>
                    <div class="fld">
                        <p>Email address:</p>
                        <p id="bold">' . $_SESSION["user_email"] . '</p>
                    </div>
                    <div class="fld">
                        <p>Contact number:</p>
                        <p id="bold">' . $formattedContact . '</p>
                    </div>
                    <div class="fld">
                        <p>Your address:</p>
                        <p id="bold">' . $_SESSION["user_street"] . '</p>
                    </div>

                    <p id="inf">The information above will be used and kept on this concern submission.</p>
                </div>';
        } else {
            echo '<h1>Please Login first</h1>';
            header("Location: ../UserLogin/UserLogin.html?timeout=true");
        }
    }

    function login_popup() {
        echo '<div class="shadow-login" id="shadow">
                <div class="popup">
                    <p id="head">You need to log in or sign up first.</p>
                    <div class="pop-buttons">
                        <button onclick="tologin()">Log in</button>
                        <button onclick="tosignup()">Sign up</button>
                    </div>
                    <img onclick="toggleLoginPopup('."'close'".')" src="\USCFMS\UserPage\UserHome\Media\button-error-svgrepo-com.svg">
                </div>
            </div>
            <div id="enlargedContainer" onclick="closeEnlarged()">
                <span id="imgcloseBtn">&times;</span>
                <img id="enlargedImg" src="" alt="Enlarged Image">
            </div>';
    }

    function request_detail() {
        if (isset($_SESSION["user_id"])) {
            echo '<div class="fldAcc">
                <div class="info">
                    <p>You are logged in as:</p>
                    <p id="bold">' . $_SESSION["user_name"] . '</p>
                </div>
                <div class="info">
                    <p>Contact number:</p>
                    <p id="bold">' . $_SESSION["user_contact"] . '</p>
                </div>
            </div>';
        }
        else {
            header("Location: ../UserLogin/UserLogin.html?timeout=true");
        }
    }

    function logout_popup() {
        echo '<div class="shadow-logout" id="shadow">
                <div class="popup">
                    <p id="head">You need to log in or sign up first.</p>
                    <div class="pop-buttons">
                        <button onclick="tologin()">Log in</button>
                        <button onclick="tosignup()">Sign up</button>
                    </div>
                    <img onclick="toggleLoginPopup('."'close'".')" src="\USCFMS\UserPage\UserHome\Media\button-error-svgrepo-com.svg">
                </div>
            </div>';
    }

    function acc_head_title() {
        if (isset($_SESSION["user_id"])) {
            $name = $_SESSION["user_name"];

            // Split the string into an array of words
            $words = explode(" ", $name);
    
            // Get the first word (if it exists)
            $firstName = isset($words[0]) ? $words[0] : $name;
    
            echo '<div class="blur">
                    <h1>Welcome, ' . $firstName . '</h1>
                    <p>Here is your dashboard.</p>
                </div>';
        } else {
            echo '<h1>Please Login first</h1>';
            header("Location: ../UserLogin/UserLogin.html?timeout=true");
        }
}

    function userProfileDetails() {
        $formattedContact = substr($_SESSION["user_contact"], 0, 4) . ' ' . substr($_SESSION["user_contact"], 4, 3)
        . ' ' . substr($_SESSION["user_contact"], 7);
        echo '<div class="first">        
                <div class="NameNAdd">
                    <p>Name:</p>
                    <p id="details">' . $_SESSION["user_name"] . '</p>
                </div>
                <div class="NameNAdd">
                    <p>Your address:</p>
                    <p id="details">' . $_SESSION["user_email"] . '</p>
                </div>
            </div>
            <div class="first">        
                <div class="NameNAdd">
                    <p>Contact number:</p>
                    <p id="details">' . $formattedContact . '</p>
                </div>
                <div class="NameNAdd">
                    <p>Email address:</p>
                    <p id="details">' . $_SESSION["user_street"] . '</p>
                </div>
            </div>';
    }

    function userConcernTable() {
        // Display the HTML table
        $result = $_SESSION["user_concernList"];
        if (count($result) > -1) {
            echo '<table>';
            echo '<tr class="head">
                    <th width="150px">Concern ID</th>
                    <th width="240px">Date received</th>
                    <th width="200px">Concern type</th>
                    <th width="150px">Status</th>
                    <th width="100px">Priority</th>
                </tr>';

            for ($row = 0; $row < count($result); $row++) {
                $data = $result[$row];
                echo '<tr class="tbl" onclick="redirectToTicket(' . $data['concernID'] . ')">';
                echo '<td class="ticketID">SC-' . $data['concernID'] . '</td>';

                // Format the date using DateTime
                $dateTime = new DateTime($data['submitDate']);
                $formattedDate = $dateTime->format('Y-m-d h:i A');

                echo '<td>' . $formattedDate . '</td>';
                echo '<td>' . $data['concernType'] . '</td>';
                echo '<td class="active"><div class="dot" id="' . getStatusColor($data['status']) . '"></div> ' . $data['status'] . '</td>';
                echo '<td>' . ($data['priority'] ? $data['priority'] : '-----') . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No concerns found.';
        }
    }

    function concernInfo () {
        $concernID = $_GET['concernID'];
        $images = $_SESSION['images'];
        if (isset($_SESSION["user_concernList"])) {
            $results = $_SESSION["user_concernList"];
        } else {
            header("Location: ../UserLogin/UserLogin.html?timeout=true");
        }

        if (isset($_SESSION["user_id"])) {
            for ($row = 0; $row < count($results); $row++) {
                $crnRow = $results[$row];
                
                if(intval($crnRow['concernID']) === intval($concernID)) {
                    $crnType = $crnRow['concernType'];
                    $crnLocation = $crnRow['location'];
                    $dateTimeObj = new DateTime($crnRow['submitDate']);
                    $crnDate = $dateTimeObj->format('F j, Y');
                    $crnStatus = $crnRow['status'];
                    $crnDesc = $crnRow['description'];
                    
                }
            }
            echo '<div class="CncrnInfos">
                    <div class="infoTab" >
                        <div class="infos">
                            <p>Concern ID:</p>
                            <p id="details">' . $concernID . '</p>
                        </div>
                        <div class="infos">
                            <p>Type of concern:</p>
                            <p id="details">' . $crnType . '</p>
                        </div>
                        <div class="infos">
                            <p>Incident location:</p>
                            <p id="details">' . $crnLocation . '</p>
                        </div>
                        <div class="infos">
                            <p>Date submitted:</p>
                            <p id="details">' . $crnDate . '</p>
                        </div>
                        <div class="infos">
                            <p>Status:</p>
                            <p id="details">' . $crnStatus . '</p>
                        </div>

                    </div>';
            echo '  <div class="rightInfo">
                        <p style="margin: 0; margin-bottom: 5px;">Uploaded photos:</p>
                        <div class="uploadedImg">';
            if (count($images) > 0){
                for ($row = 0; $row < count($images); $row++) {
                    $imagePath = $images[$row];
                    echo '<img src="/USCFMS' . $imagePath['photoEvidence'] . '" onclick="enlargeImage(this)">';
                }
            }
            echo '           </div>
                    </div>';
            echo '</div>';
            
            echo '<div class="second">
                    <div class="CnrcnDesc">
                        <h4 id="fld">Concern description:</h4>
                        <div class="underline"></div>
                    </div>
                    
                    <div class="desc">
                        <p>' . $crnDesc . '</p>
                    </div>
                </div>';
        } else {
            header("Location: ../UserLogin/UserLogin.html?timeout=true");
        }
        /*Old Template
        <div class="CncrnInfos">
            <div class="infos">
                <p>Concern ID:</p>
                <p id="details">SC-12345</p>
            </div>
            <div class="infos">
                <p>Type of concern:</p>
                <p id="details">Residential</p>
            </div>
            <div class="infos">
                <p>Incident location:</p>
                <p id="details">Tomasa St.</p>
            </div>
            <div class="infos">
                <p>Date submitted:</p>
                <p id="details">November 21, 2023</p>
            </div>
            <div class="infos">
                <p>Status:</p>
                <p id="details">Active</p>
            </div>
        </div>
        <div class="second">
            <div class="CnrcnDesc">
                <h4 id="fld">Concern description:</h4>
                <div class="underline"></div>
            </div>
            
            <div class="desc">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation<br>
                    ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </div>
        </div>*/
    }

    function userMessageTable() {
        // Display the HTML table
        $result = $_SESSION["user_messageList"];

        if (count($result) > -1) {
            echo '<table>';
            echo '<tr class="head">
                    <th width="240px">Date received</th>
                    <th width="190px">Time received</th>
                    <th width="200px">Concern ID connected</th>
                </tr>';

            for ($row = 0; $row < count($result); $row++) {
                $data = $result[$row];
                echo '<tr class="tbl" id="' . $data['msgID'] . '" onclick="toggleMessagePopup(\'open\', ' . $row . ')">';

                // Format the date using DateTime
                $dateTimeObj = new DateTime($data['dateReceived']);
                $formattedDate = $dateTimeObj->format('F j, Y');
                $formattedTime = $dateTimeObj->format('g:i A');

                if ($data['isRead'] === 0) {
                    echo '<td class="msgdate" id="date' . $row .'" style="display: flex; align-items: center; gap: 10px;">
                    <div class="redDot" style="width: 10px; height: 10px; background: red; border-radius: 50px; "></div>' . $formattedDate . '</td>';
                } else {
                    echo '<td class="msgdate" id="date' . $row .'" style="display: flex; align-items: center; gap: 10px;">
                    <div class="redDot" style="width: 10px; height: 10px; background: transparent; border-radius: 50px; "></div>' . $formattedDate . '</td>';
                }
                
                echo '<td class="msgtime"  id="time' . $row .'">' . $formattedTime . '</td>';
                echo '<td class="ticketID"  id="id' . $row .'">SC-' . $data['concernID'] . '</td>';
                echo '<td class="msgDetail" style="position: absolute; display: none; width: 0;">' . $data['message'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No concerns found.';
        }

        //Old Format
        // <table>
        //     <tr class="head">
        //         <th width="250px">Date received</th>
        //         <th width="270px">Time received</th>
        //         <th width="360px">Concern ID connected</th>
        //     </tr>
        //     <tr class="tbl">
        //         <td>October 26, 2023</td>
        //         <td>09:46 PM</td>
        //         <td class="ticketID" onclick="window.location.href='/USCFMS/AdminPage/AdminViewTicket/adminViewTicket.html'">SC-12345</td>                    
        //     </tr>
        //     <tr class="tbl">
        //         <td>October 26, 2023</td>
        //         <td>09:46 PM</td>
        //         <td class="ticketID" onclick="window.location.href='/USCFMS/AdminPage/AdminViewTicket/adminViewTicket.html'">SC-12345</td>
        //     </tr>
        //     <tr class="tbl">
        //         <td>October 26, 2023</td>
        //         <td>09:46 PM</td>
        //         <td class="ticketID" onclick="window.location.href='/USCFMS/AdminPage/AdminViewTicket/adminViewTicket.html'">SC-12345</td>
        //     </tr>
        //     <tr class="tbl">
        //         <td>October 26, 2023</td>
        //         <td>09:46 PM</td>
        //         <td class="ticketID" onclick="window.location.href='/USCFMS/AdminPage/AdminViewTicket/adminViewTicket.html'">SC-12345</td>
        //     </tr>
        // </table>
    }

    function getStatusColor($status)
    {
        switch ($status) {
            case 'Unread':
                return 'red';
            case 'Pending':
                return 'gray';
            case 'Active':
                return 'blue';
            case 'Resolved':
                return 'green';
            case 'Discarded':
                return 'orange';
            default:
                return 'black'; // Change this to a default color or handle as needed
        }
    }
    $messagesData = json_encode(userMessageTable());
    $concernsData = json_encode(userConcernTable());
?>