<?php

    function generateChartData($conn, $monthFilter) {
        // Use parameterized query to prevent SQL injection
        $query = "SELECT `concernType`, COUNT(`concernID`) AS `count` FROM `concerndetail`";

        // Add a condition to filter by month if it's not 'All'
        if ($monthFilter !== 'All') {
            // Use a parameterized query to prevent SQL injection
            $query .= " WHERE MONTH(`submitDate`) = ?";
        }

        $query .= " GROUP BY `concernType`";

        // Prepare the statement
        $stmt = $conn->prepare($query);

        // Bind parameters if monthFilter is not 'All'
        if ($monthFilter !== 'All') {
            $stmt->bind_param("s", $monthFilter);
        }

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        $dataPoints = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataPoints[] = array("y" => $row['count'], "label" => $row['concernType'] === 'Infrastructures and facilities' ? 'I&E' : $row['concernType']);
            }
        }

        // Close the statement
        $stmt->close();

        return $dataPoints;
    }

    function generateChartData2($conn, $monthFilter) {
        // Use parameterized query to prevent SQL injection
        $query = "SELECT `location`, COUNT(`concernID`) AS `count` FROM `concerndetail` GROUP BY `location`";

        // Prepare the statement
        $stmt = $conn->prepare($query);

        // Bind parameters if monthFilter is not 'All'
        if ($monthFilter !== 'All') {
            $stmt->bind_param("s", $monthFilter);
        }

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        $dataPoints2 = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataPoints2[] = array("y" => $row['count'], "label" => $row['location'] === 'Infrastructures and facilities' ? 'I&E' : $row['location']);
            }
        }

        // Close the statement
        $stmt->close();

        return $dataPoints2;
    }

    function generateChartData3($conn, $monthFilter) {
        // Use parameterized query to prevent SQL injection
        $query = "SELECT `status`, COUNT(`status`) AS `count` FROM `concerndetail` GROUP BY `status`";

        // Prepare the statement
        $stmt = $conn->prepare($query);

        // Bind parameters if monthFilter is not 'All'
        if ($monthFilter !== 'All') {
            $stmt->bind_param("s", $monthFilter);
        }

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        $dataPoints3 = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataPoints3[] = array("y" => $row['count'], "label" => $row['status'] === 'Infrastructures and facilities' ? 'I&E' : $row['status']);
            }
        }

        // Close the statement
        $stmt->close();

        return $dataPoints3;
    }

    $servername = "localhost";
    $username = "root";
    $password = ""; // Assuming no password for the root user
    $database = "uscfms";

    $conn = new mysqli($servername, $username, $password, $database);
    
    // Get the selected month from the query parameters
    $selectedMonth = isset($_GET['month']) ? $_GET['month'] : 'All';

    // Generate chart data based on the selected month
    $dataPoints = generateChartData($conn, $selectedMonth);

    // Generate chart data based on the selected month
    $dataPoints2 = generateChartData2($conn, $selectedMonth);

    // Generate chart data based on the selected month
    $dataPoints3 = generateChartData3($conn, $selectedMonth);

    // Close the database connection
    $conn->close();

?>