function createElement(element, classN, getParentID, path){
    // Create a new <h3> element with the class "activeConcern"
    var newH3 = document.createElement(element);

    if(classN !== null){
        newH3.className = classN;
    }

    var cardContent = document.getElementById(getParentID);
    // Append the new <h3> element to the body
    cardContent.appendChild(newH3);

    // Call the PHP script to fetch and update the total amount
    fetch(path)
        .then(response => response.text())
        .then(data => {
            // Update the innerHTML of the new <h3> element with the new count
            newH3.innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
}