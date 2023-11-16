<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Face Me!</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="index.php">
            <img class="homebtn" src="./assets/home.png">
         
        </a>
    <a class="navbar-brand" href="register.php">
        <img class="downbtn" src="./assets/register_btn.png">
       
    </a>
    <a class="navbar-brand" href="scanner.php">
        <img class="regbtn" src="./assets/dash_btn.png">
      
    </a>
    </nav>
    <h1>Image Registration</h1>
    
    <div>
        <video id="video" width="640" height="480" autoplay></video>
        
        <label for="nameInput">Name:</label>
        <input  type="text" id="nameInput">
        <button class="capbtn" id="captureBtn">Capture</button>
        
    </div>
    
    <script>
        // Access the webcam and stream video
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                const videoElement = document.getElementById('video');
                videoElement.srcObject = stream;
            })
            .catch(error => {
                console.error('Error accessing webcam:', error);
            });

        // Update data.js file on the server
        function updateDataFile(name) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_data.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                        alert('Updated data.js file successfully!');
                    } else {
                        console.error('Error updating data.js file:', xhr.status);
                    }
                }
            };
            xhr.send('name=' + encodeURIComponent(name));
        }

        // Capture image from webcam and save
        function captureImage() {
            const videoElement = document.getElementById('video');
            const nameInput = document.getElementById('nameInput');
            const name = nameInput.value.trim();

            if (name === '') {
                alert('Please enter a name.');
                return;
            }

            const canvas = document.createElement('canvas');
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            
            const imageDataURL = canvas.toDataURL('image/png');

            // Send the captured image and name to the server
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_image.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                        alert('Image captured and saved successfully!');
                        updateDataFile(name); // Update data.js file on the server
                    } else {
                        console.error('Error saving image:', xhr.status);
                    }
                }
            };
            xhr.send('name=' + encodeURIComponent(name) + '&image=' + encodeURIComponent(imageDataURL));
        }

        // Event listener for the capture button
        const captureBtn = document.getElementById('captureBtn');
        captureBtn.addEventListener('click', captureImage);
    </script>
</body>
</body>
</html>