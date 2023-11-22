// Function to display the custom formatted date and time
function displayCustomDateTime() {
    const dateTime = new Date();
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = dateTime.toLocaleDateString(undefined, options);

    const hour = dateTime.getHours();
    const minute = dateTime.getMinutes();
    const second = dateTime.getSeconds();
    const amOrPm = hour >= 12 ? 'PM' : 'AM';
    const formattedHour = (hour % 12 || 12); // Convert to 12-hour format

    // Formatting minutes to include leading zero if less than 10
    const formattedMinute = (minute < 10 ? '0' : '') + minute;
    const formattedSecond = (second < 10 ? '0' : '') + second;

    // Combine formatted date and time into the desired format
    const formattedTime = `${formattedHour}:${formattedMinute}:${formattedSecond} ${amOrPm}`;

    const formattedDateTime = `${formattedDate} | ${formattedTime}`;
    const adminDate = `${formattedDate}`;
    const adminTime = `${formattedTime}`;
    var element = document.getElementById("dateTime");

    // Display the custom formatted date and time in the 'datetime' div
    if(element != null){
        document.getElementById('dateTime').textContent = formattedDateTime;
    }
    else {
        document.getElementById('currentDate').textContent = adminDate;
        document.getElementById('currentTime').textContent = adminTime;
    }
}

// Call the function to display custom date and time
displayCustomDateTime();

// Update the date and time every second (optional)
setInterval(displayCustomDateTime, 1000); // Updates every second