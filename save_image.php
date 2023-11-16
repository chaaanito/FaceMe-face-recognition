<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $imageData = $_POST['image'];

    // Sanitize the name input to remove any unwanted characters
    $name = preg_replace('/[^a-zA-Z0-9\s]/', '', $name);

    // Create a directory for the user if it doesn't exist
    $directory = 'imgDatabase/' . $name;
    if (!is_dir($directory)) {
        mkdir($directory);
    }

    // Get the number of existing images in the user's directory
    $existingImages = glob($directory . '/*.png');
    $imageCount = count($existingImages);

    // Generate a filename for the new image
    $filename = ($imageCount + 1) . '.png';

    // Save the image to the user's directory
    $filePath = $directory . '/' . $filename;
    $success = file_put_contents($filePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));

    if ($success !== false) {
        echo 'Image saved successfully: ' . $filePath;
    } else {
        echo 'Failed to save image.';
    }
}
?>
