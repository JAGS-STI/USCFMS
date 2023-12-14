<?php
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password for the root user
$database = "uscfms";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
 $query = "SELECT `concernType`, COUNT(`concernID`) AS `count` FROM `concerndetail` GROUP BY `concernType`";
 $result = $conn->query($query);
 
 $dataPoints = array();
 
 if ($result->num_rows > 0) {
     while ($row = $result->fetch_assoc()) {
         $dataPoints[] = array("y" => $row['count'], "label" => $row['concernType']==='Infrastructures and facilities'?"I&E":$row['concernType']);
     }
 }
 
 // You can print or use $dataPoints as needed
 print_r($dataPoints);
 


    $dataPoints2 = array( 
        array("y" => 10, "label" => "Roads and highways" ),
        array("y" => 4, "label" => "Residential" ),
        array("y" => 12, "label" => "Schools" ),
        array("y" => 3, "label" => "Safety & security" ),
        array("y" => 7, "label" => "I&F" ),
        array("y" => 2, "label" => "Animal welfare" ),
        array("y" => 1, "label" => "Others" )   
    );
  // Close the database connection
  $conn->close();
?>