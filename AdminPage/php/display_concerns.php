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

// Fetch data from the database
$sql = "SELECT concernID, submitDate, concernType, status, priority FROM concernDetail";
$result = $conn->query($sql);

// Display the HTML table
if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr class="head">
            <th width="150px">Concern ID</th>
            <th width="240px">Date received</th>
            <th width="200px">Concern type</th>
            <th width="150px">Status</th>
            <th width="100px">Priority</th>
          </tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr class="tbl" onclick="redirectToTicket(' . $row['concernID'] . ')">';
        echo '<td class="ticketID">SC-' . $row['concernID'] . '</td>';
        echo '<td>' . $row['submitDate'] . '</td>';
        echo '<td>' . $row['concernType'] . '</td>';
        echo '<td class="active"><div class="dot" id="' . getStatusColor($row['status']) . '"></div> ' . $row['status'] . '</td>';
        echo '<td>' . ($row['priority'] ? $row['priority'] : '-----') . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No concerns found.';
}

// Function to determine status color
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

$conn->close();
?>
<script>
    function redirectToTicket(concernID) {
        window.location.href = '/USCFMS/AdminPage/AdminViewTicket/adminViewTicket.html?concernID=' + concernID;
    }
</script>