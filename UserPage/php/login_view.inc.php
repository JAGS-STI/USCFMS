<?php

    declare(strict_types=1);

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
            echo '<img id="profile_pic" onclick="toaccount()" src="/USCFMS/UserPage/UserHome/Media/user-circle-svgrepo-com(1).svg" />';
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

    function tosubmitHomeBtn() {
        if (isset($_SESSION["user_id"])) {
            echo '<button class="submit" onclick="tosubmitconcern()">SUBMIT</button>';
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
            header("Location: ../UserLogin/UserLogin.html");
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
            </div>';
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
            header("Location: ../UserLogin/UserLogin.html");
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