<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT status, COUNT(*) AS statusCount FROM concernDetail GROUP BY status";
    // Execute the SQL query to retrieve the data from the database
    
    $result = $conn->query($sql);

    // Initialize variables
    $activeCount = 0;
    $discardedCount = 0;
    $pendingCount = 0;
    $unreadCount = 0;
    $resolvedCount = 0;

    // Process query result
    while ($row = $result->fetch_assoc()) {
        switch ($row['status']) {
            case 'Active':
                $activeCount = $row['statusCount'];
                break;
            case 'Discarded':
                $discardedCount = $row['statusCount'];
                break;
            case 'Pending':
                $pendingCount = $row['statusCount'];
                break;
            case 'Unread':
                $unreadCount = $row['statusCount'];
                break;
            case 'Resolved':
                $resolvedCount = $row['statusCount'];
                break;
            // Add more cases if you have additional status types
        }
    }

    echo    '<div class="rightCard" id="active">
                <h3>' . $activeCount . '</h3>
                <p>Active</p>
                <img src="media/active.svg" />
            </div>
            <div class="rightCard" id="unread">
                <h3>' . $unreadCount . '</h3>
                <p>Unread</p>
                <img src="media/mail-all-unread-svgrepo-com.svg" />
            </div>
            <div class="rightCard" id="resolved">
                <h3>' . $resolvedCount . '</h3>
                <p>Resolved</p>
                <img src="media/resolved.svg" />
            </div>
            <div class="rightCard" id="pending">
                <h3>' . $pendingCount . '</h3>
                <p>Pending</p>
                <img src="media/discarded.svg" />
            </div>';

    /* OLD TEMPLATE
        <div class="rightCard">
            <h3>15</h3>
            <p>Active</p>
            <img src="media/active.svg" />
        </div>
        <div class="rightCard">
            <h3>9</h3>
            <p>Unread</p>
            <img src="media/mail-all-unread-svgrepo-com.svg" />
        </div>
        <div class="rightCard">
            <h3>5</h3>
            <p>Resolved</p>
            <img src="media/resolved.svg" />
        </div>
        <div class="rightCard">
            <h3>3</h3>
            <p>Discarded</p>
            <img src="media/discarded.svg" />
        </div> */
?>