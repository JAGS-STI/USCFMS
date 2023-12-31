document.addEventListener("DOMContentLoaded", function() {
    // Fetch concern details from the server
    fetchConcernDetails();
    updateButtons();

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

function updateButtons() {
    var survey = document.getElementById("downloadPdf");
    var isResolved = document.getElementsByClassName("dot");
    var downloadBtn = document.getElementById("pdf");
    var viewBtn = document.getElementById("btnView");
    var label = document.getElementById("not");
    if (survey) {
        console.log("Survey Available.");
        viewBtn.style.backgroundColor = "#16601F";
        downloadBtn.style.backgroundColor = "#16601F";
        label.style.color = "#008c0d";
        label.innerHTML = "Survey result available"
        
    } else if(isResolved[0].id === "green"){
        console.log("Waiting for Survey.");
        viewBtn.style.backgroundColor = "#606060";
        viewBtn.style.cursor = "not-allowed";
        viewBtn.disabled = true;
        downloadBtn.style.backgroundColor = "#606060";
        downloadBtn.style.cursor = "not-allowed";
        downloadBtn.disabled = true;
        label.innerHTML = "Wait for user to answer"
        label.style.color = "#f78904";
    } else {
        console.log("No survey result.");
        viewBtn.style.backgroundColor = "#606060";
        viewBtn.disabled = true;
        viewBtn.style.cursor = "not-allowed";
        downloadBtn.style.backgroundColor = "#606060";
        downloadBtn.style.cursor = "not-allowed";
        downloadBtn.disabled = true;
    }
}

function saveAndClose() {
    // Get the updated values from the select elements
    const status = document.getElementById("statusBox").value;
    const priority = document.getElementById("priorBox").value;
    const concernID = getParameterByName('concernID');

    if (status === 'Resolved') {
        sendResolvedMsg(document.getElementById("cd").className);
    }
    if (status === 'Active') {
        sendUpdateMsg(status);
    }
    if (status === 'Pending') {
        sendUpdateMsg(status);
    }
    if (status === 'Discarded') {
        sendUpdateMsg(status);
    }

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

function sendUpdateMsg(status) {
    // Get the updated values from the select elements
    var isNow = "";
    switch(status) {
        case "Active":
            isNow = "is now on process.";
            break;
        case "Pending":
            isNow = "is now pending.";
            break;
        case "Discarded":
            isNow = "has been discarded.";
            break;
        default:
            break; 
    }
    const message = "Status: "+status+"<br><br>Good Day!<br><br>Please be informed that your requested concern "+isNow;
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

function sendResolvedMsg(link) {
    // Get the updated values from the select elements
    const concernID = getParameterByName('concernID');
    const Name = document.getElementById("pName").innerHTML;
    document.getElementById("msgBox").value = "Hi there, "+Name+"! Your concern <span style=\"font-weight: bold;\">SC-"+concernID+"</span> has been resolved! Feel free to give us your thoughts on how we handled your concern.<br><br>You can tell us about your thoughts here: ";
    const message = document.getElementById("msgBox").value;
    
    

    // Use AJAX to send the updated values to the server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/USCFMS/AdminPage/php/sendResolvedMsg.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server, if needed
            console.log(xhr.responseText);

            // Refreshes the page
            //window.location.href = "/USCFMS/AdminPage/AdminViewTicket/adminViewTicket.html?concernID=" + concernID;
        }
    };
    xhr.send(`concernID=${concernID}&msgBox=${message}&cd=${link}`);
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