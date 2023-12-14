document.addEventListener("DOMContentLoaded", function() {
    // Fetch concern details from the server
    fetchConcernDetails();

    try{
        // Attach an event listener to the "Save and Close" button
        document.getElementById("saveBtn").addEventListener("click", function() {
            // Show a confirmation dialog
            if (confirm("Save changes?")) {
                saveAndClose();
            }
        });
    } catch {
        // Refreshes the page
        window.location.href = "/USCFMS/AdminPage/AdminDocument/adminDocument.html?docID=notfound";
    }

});

function fetchConcernDetails() {
    // Get the concern ID from the URL parameter
    const docID = getParameterByName('docID');

    // Fetch the concern details from the server
    fetch(`/USCFMS/AdminPage/php/getDocStatus.php?docID=${docID}`)
        .then(response => response.json())
        .then(data => {
            // Update the status and priority select elements
            document.getElementById("statusBox").value = data.status !== null ? data.status : '-----';
        })
        .catch(error => console.error('Error:', error));
}



function saveAndClose() {
    // Get the updated values from the select elements
    const status = document.getElementById("statusBox").value;
    const docID = getParameterByName('docID');

    if (status === 'Ready for pick up') {
        sendMsg();
    }

    // Use AJAX to send the updated values to the server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/USCFMS/AdminPage/php/updateDocStatus.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server, if needed
            console.log(xhr.responseText);

            // Refreshes the page
            //window.location.href = "/USCFMS/AdminPage/AdminDocument/adminDocument.html";
        }
    };
    xhr.send(`docID=${docID}&status=${status}`);
}

function sendMsg() {
    // Get the updated values from the select elements
    const Name = document.getElementById("pName").innerHTML;
    const type = document.getElementsByClassName("doctype")[0].innerHTML;
    const docID = getParameterByName('docID');
    const message = "Hi there, "+Name+" your "+type+" is ready for pick up! <br><br>Request ID: DOC-"+docID+"<br>Open Time: Weekdays 10:00 am - 6:00 pm";



    // Use AJAX to send the updated values to the server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/USCFMS/AdminPage/php/sendPickupMsg.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server, if needed
            console.log(xhr.responseText);

            // Refreshes the page
            //window.location.href = "/USCFMS/AdminPage/AdminViewTicket/adminViewTicket.html?concernID=" + docID;
        }
    };
    xhr.send(`concernID=${docID}&msgBox=${message}`);
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

function getParameterByName(name) {
    const url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}