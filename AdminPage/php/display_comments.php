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
$sql = "SELECT * FROM commenttbl";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr class="head">
            <th width="250px">Comment ID</th>
            <th width="270px">Date received</th>
            <th width="350px">Comment from</th>
          </tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr class="tbl" onclick="redirectToComment(' . $row['commentID'] . ')">';
        echo '<td class="ticketID">SC-' . $row['commentID'] . '</td>';

        // Format the date using DateTime
        $dateTime = new DateTime($row['submitDate']);
        $formattedDate = $dateTime->format('Y-m-d h:i A');

        echo '<td>' . $formattedDate . '</td>';
        if ($row['name'] === 'anonymous') {
            echo '<td id="anonymous">' . $row['name'] . '</td>';
        } else {
            echo '<td>' . $row['name'] . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}
// <table>
//     <tr class="head">
//         <th width="250px">Comment ID</th>
//         <th width="270px">Date received</th>
//         <th width="350px">Comment from</th>
//     </tr>
//     <tr class="tbl">
//         <td class="ticketID" onclick="window.location.href='/USCFMS/AdminPage/AdminViewComments/adminViewComments.html'">CM-12345</td>
//         <td>October 26, 2023</td>
//         <td id="anonymous">Anonymous</td>
//     </tr>
//     <tr class="tbl">
//         <td class="ticketID" onclick="window.location.href='/USCFMS/AdminPage/AdminViewComments/adminViewComments.html'">CM-98765</td>
//         <td>October 26, 2023</td>
//         <td>Nezuko</td>
//     </tr>
//     <tr class="tbl">
//         <td class="ticketID" onclick="window.location.href='/USCFMS/AdminPage/AdminViewComments/adminViewComments.html'">CM-98765</td>
//         <td>October 26, 2023</td>
//         <td>Zenitsu</td>
//     </tr>
//     <tr class="tbl">
//         <td class="ticketID" onclick="window.location.href='/USCFMS/AdminPage/AdminViewComments/adminViewComments.html'">CM-24680</td>
//         <td>October 26, 2023</td>
//         <td id="anonymous">Anonymous</td>
//     </tr>
// </table>
?>
<script>
    function redirectToComment(commentID) {
        window.location.href = '/USCFMS/AdminPage/AdminViewComments/adminViewComments.html?commentID=' + commentID;
    }
</script>