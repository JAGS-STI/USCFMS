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
$sql = "SELECT docID, docType, useraccount.name, status, docstatus.dateReceived FROM docstatus 
        JOIN useraccount ON useraccount.accID = docstatus.accID ORDER BY docstatus.dateReceived DESC;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>
            <tr class="head">
                <th width="300px">Request ID</th>
                <th width="400px">Date received</th>
                <th width="300px">Requestor name</th>
                <th width="300px">Document request</th>
                <th width="200px">Status</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr class="tbl" onclick="window.location.href=\'adminViewDoc.html?docID='.$row['docID'].'\'">';
        echo '<td class="ticketID">DOC-' . $row['docID'] . '</td>';

        // Format the date using DateTime
        $date = new DateTime($row['dateReceived']);
        $formattedDate = $date->format('F j, Y');

        echo '<td>' . $formattedDate . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['docType'] . '</td>';
        echo '<td class="active"><div class="dot" id="' . getStatusColor($row['status']) . '"></div> ' . $row['status'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
// <table>
//     <tr class="head">
//         <th width="300px">Request ID</th>
//         <th width="400px">Date received</th>
//         <th width="300px">Requestor name</th>
//         <th width="300px">Document request</th>
//         <th width="200px">Status</th>
//     </tr>
//     <tr class="tbl" onclick="window.location.href='adminViewDoc.html'">
//         <td class="ticketID">SC-12345</td>
//         <td>October 26, 2023</td>
//         <td>Nezuko Kamado</td>
//         <td>Barangay Indigency</td>
//         <td class="active"><div class="dot"></div>Active</td>
//     </tr>
//         <tr class="tbl">
//         <td class="ticketID">SC-12345</td>
//         <td>October 26, 2023</td>
//         <td>Tanjiro Kamado</td>
//         <td>Barangay Indigency</td>
//         <td class="active"><div class="dot"></div>Active</td>
//     </tr>
//         <tr class="tbl">
//         <td class="ticketID">SC-12345</td>
//         <td>October 26, 2023</td>
//         <td>Zenitsu Agatsuma</td>
//         <td>Barangay Clearance</td>
//         <td class="active"><div class="dot"></div>Active</td>
//     </tr>
//     <tr class="tbl">
//         <td class="ticketID">SC-12345</td>
//         <td>October 26, 2023</td>
//         <td>Inosuke Hashibira</td>
//         <td>Barangay Indigency</td>
//         <td class="active"><div class="dot"></div>Active</td>
//     </tr>
// </table>

// Function to determine status color
function getStatusColor($status)
{
    switch ($status) {
        case 'Pending':
            return 'blue';
        case 'Ready for pick up':
            return 'green';
        case 'Closed':
            return 'orange';
        default:
            return 'black'; // Change this to a default color or handle as needed
    }
}

function getReqType($type)
{
    switch ($type) {
        case 'Barangay Indingency':
            return '1';
        case 'Barangay Clearance':
            return '2';
        default:
            return '0'; // Change this to a default color or handle as needed
    }
}

$conn->close();
?>
<script>
    function redirectToComment(commentID) {
        window.location.href = '/USCFMS/AdminPage/AdminViewComments/adminViewComments.html?commentID=' + commentID;
    }
</script>