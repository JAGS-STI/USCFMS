<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Concerns</title>
</head>
<body>

<!-- Display the total amount of active concerns -->
<?php
function displayActiveConcerns() {
    // Include the script
    include($_SERVER['DOCUMENT_ROOT'] . "/USCFMS/TestPage/php/fetch_count.php");
    
    // Display the total amount in a new <h3> element
    echo '<h3 class="activeConcern">' . $activeCount . '</h3>';
}

// Call the function to display the total amount initially
displayActiveConcerns();
?>

<!-- Button to add a new <h3> element -->
<button onclick="addNewConcern()">Add New Concern</button>

<script>
    // JavaScript function to add a new <h3> element
    function addNewConcern() {
        // Create a new <h3> element with the class "activeConcern"
        var newH3 = document.createElement("h3");
        newH3.className = "activeConcern";

        // Append the new <h3> element to the body
        document.body.appendChild(newH3);

        // Call the PHP script to fetch and update the total amount
        fetch('php/fetch_count.php') // Assuming your PHP script is in the "php" folder
            .then(response => response.text())
            .then(data => {
                // Update the innerHTML of the new <h3> element with the new count
                newH3.innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }
</script>

</body>
</html>
