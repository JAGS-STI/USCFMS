document.addEventListener("DOMContentLoaded", function() {
    // Fetch concern details from the server
    fetchConcernDetails();

    // Attach an event listener to the "Save and Close" button
    document.getElementById("saveNclose").addEventListener("click", function() {
        // Show a confirmation dialog
        if (confirm("Save changes?")) {
            saveAndClose();
            
        }
    });

    // Attach an event listener to the "Close" button
    document.getElementById("close").addEventListener("click", function() {
        window.location.href = "/USCFMS/AdminPage/AdminTickets/adminTickets.html";
    });

    // Attach an event listener to the "Discard" button
    document.getElementById("discard").addEventListener("click", function() {
        if (confirm("Discard this ticket?")) {
            discardTicket();
        }
    });

    document.getElementById("submitMsg").addEventListener("click", function() {
        if (confirm("Send Message?")) {
            sendMsg();
        }
    });
});

function fetchConcernDetails() {
    // Get the concern ID from the URL parameter
    const concernID = getParameterByName('concernID');

    // Fetch the concern details from the server
    fetch(`/USCFMS/AdminPage/php/getStatus.php?concernID=${concernID}`)
        .then(response => response.json())
        .then(data => {
            // Update the status and priority select elements
            document.getElementById("statusBox").value = data.status !== null ? data.status : '-----';
            document.getElementById("priorBox").value = data.priority;
        })
        .catch(error => console.error('Error:', error));
}

function saveAndClose() {
    // Get the updated values from the select elements
    const status = document.getElementById("statusBox").value;
    const priority = document.getElementById("priorBox").value;
    const concernID = getParameterByName('concernID');

    // Use AJAX to send the updated values to the server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/USCFMS/AdminPage/php/updateStatus.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server, if needed
            console.log(xhr.responseText);

            // Refreshes the page
            window.location.href = "/USCFMS/AdminPage/AdminTickets/adminTickets.html";
        }
    };
    xhr.send(`concernID=${concernID}&status=${status}&priority=${priority}`);
}

function sendMsg() {
    // Get the updated values from the select elements
    const message = document.getElementById("msgBox").value;
    const concernID = getParameterByName('concernID');

    // Use AJAX to send the updated values to the server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/USCFMS/AdminPage/php/sendMsg.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server, if needed
            console.log(xhr.responseText);

            // Refreshes the page
            window.location.href = "/USCFMS/AdminPage/AdminViewTicket/adminViewTicket.html?concernID=" + concernID;
        }
    };
    xhr.send(`concernID=${concernID}&msgBox=${message}`);
}

function discardTicket() {
    const concernID = getParameterByName('concernID');

    // Use AJAX to update the status to "Discarded"
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/USCFMS/AdminPage/php/discardStatus.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server, if needed
            console.log(xhr.responseText);

            // Redirect to the admin tickets page after discarding
            window.location.href = "/USCFMS/AdminPage/AdminTickets/adminTickets.html";
        }
    };
    xhr.send(`concernID=${concernID}&status=Discarded`);
}

function getParameterByName(name) {
    const url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}