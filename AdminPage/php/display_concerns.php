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
    echo '<div class="tblContent">';
    echo '<table>
        <tr class="head">
            <th width="150px">Concern ID</th>
            <th width="240px">Date received</th>
            <th width="200px">Concern type</th>
            <th width="150px">Status</th>
            <th width="150px">Priority</th>
            <th width="100px">Updated</th>
          </tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr class="tbl" onclick="redirectToTicket(' . $row['concernID'] . ')">';
        echo '<td class="ticketID">SC-' . $row['concernID'] . '</td>';

        // Format the date using DateTime
        $dateTime = new DateTime($row['submitDate']);
        $formattedDate = $dateTime->format('Y-m-d h:i A');

        echo '<td>' . $formattedDate . '</td>';
        echo '<td>' . $row['concernType'] . '</td>';
        echo '<td class="active"><div class="dot" id="' . getStatusColor($row['status']) . '"></div> ' . $row['status'] . '</td>';
        echo '<td>' . ($row['priority'] ? $row['priority'] : '-----') . '</td>';
        echo '<td>----</td>'; 
        echo '</tr>';
    }

    echo '</table>
    </div>';
} else {
    echo 'No concerns found.';
}

// OLD_TEMPLATE
// <table>
//     <tr class="head">
//         <th width="250px">Concern ID</th>
//         <th width="270px">Date submitted</th>
//         <th width="350px">Concern type</th>
//         <th width="150px">Status</th>
//     </tr>
//     <tr class="tbl">
//         <td class="ticketID">SC-12345</td>
//         <td>October 26, 2023</td>
//         <td>Residential</td>
//         <td class="active"><div class="dot"></div>Active</td>
//     </tr>
//     <tr class="tbl">
//         <td class="ticketID">SC-12345</td>
//         <td>October 26, 2023</td>
//         <td>Residential</td>
//         <td class="active"><div class="dot"></div>Active</td>
//     </tr>
//     <tr class="tbl">
//         <td class="ticketID">SC-12345</td>
//         <td>October 26, 2023</td>
//         <td>Residential</td>
//         <td class="active"><div class="dot"></div>Active</td>
//     </tr>
//     <tr class="tbl">
//         <td class="ticketID">SC-12345</td>
//         <td>October 26, 2023</td>
//         <td>Residential</td>
//         <td class="active"><div class="dot"></div>Active</td>
//     </tr>
// </table>

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