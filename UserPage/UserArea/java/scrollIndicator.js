// Get the scroll indicator element
var scrollIndicator = document.getElementById("upBtn");

// Function to handle scroll events
function handleScroll() {
    // Check the scroll position
    if (window.scrollY <= 400) {
        // At the top of the page, hide the scroll indicator
        scrollIndicator.classList.remove("up");
    } else {
        // Scrolled down, show the scroll indicator
        scrollIndicator.classList.add("up");
    }
}

// Attach the scroll event listener
window.addEventListener('scroll', handleScroll);