<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Enlarger</title>
    <style>
        /* Styles for the enlarged image container */
        #enlargedContainer {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        #enlargedImg {
            max-width: 80%;
            max-height: 80%;
        }

        #imgcloseBtn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: white;
            font-size: 20px;
        }
    </style>
</head>
<body>

<!-- Image that, when clicked, will be enlarged -->
<img src="\USCFMS\AdminPage\uploads\10023_Evidence1.jpg" alt="Enlargable Image" onclick="enlargeImage(this)">

<!-- Enlarged image container -->
<div id="enlargedContainer" onclick="closeEnlarged()">
    <span id="closeBtn">&times;</span>
    <img id="enlargedImg" src="" alt="Enlarged Image">
</div>

<script>
    // Function to enlarge the image
    function enlargeImage(clickedImg) {
        var enlargedContainer = document.getElementById("enlargedContainer");
        var enlargedImg = document.getElementById("enlargedImg");

        // Set the source of the enlarged image
        enlargedImg.src = clickedImg.src;

        // Show the enlarged container
        enlargedContainer.style.display = "flex";
    }

    // Function to close the enlarged image container
    function closeEnlarged() {
        var enlargedContainer = document.getElementById("enlargedContainer");

        // Hide the enlarged container
        enlargedContainer.style.display = "none";
    }
</script>

</body>
</html>
