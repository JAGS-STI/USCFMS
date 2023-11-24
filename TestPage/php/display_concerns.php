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
    echo '<table border="1">';
    echo '<tr>
            <th>Concern ID</th>
            <th>Date received</th>
            <th>Concern type</th>
            <th>Status</th>
            <th>Priority</th>
          </tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>SC-' . $row['concernID'] . '</td>';
        echo '<td>' . $row['submitDate'] . '</td>';
        echo '<td>' . $row['concernType'] . '</td>';
        echo '<td><div class="dot" id="' . getStatusColor($row['status']) . '"></div> ' . $row['status'] . '</td>';
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
        case 'Pending':
            return 'red';
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
