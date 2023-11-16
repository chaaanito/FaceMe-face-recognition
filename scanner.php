<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Face detection on the browser using javascript !</title>
  <script defer src="data.js"></script>
  <script defer src="face-api.min.js"></script>
  <script defer src="script.js"></script>
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
    <div class="container">
  <video id="video" width="600" height="450" autoplay>
  </div>
    <div class="container"><?php include "folderNames.php" ?></div>
</body>
</html>