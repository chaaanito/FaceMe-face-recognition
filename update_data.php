<?php
// update_data.php

// Get the name data from the POST request
$name = $_POST['name'];

// Read the existing data.js file
$dataFile = 'data.js';
$dataContent = file_get_contents($dataFile);

// Extract the array portion from the content
$pattern = '/const labelNames = (\[.*?\]);/s';
preg_match($pattern, $dataContent, $matches);
$dataArray = json_decode($matches[1], true);

// Check if the name already exists in the array
if (in_array($name, $dataArray)) {
    echo 'Name already exists in the data.js file.';
    exit();
}

// Add the new name to the array
$dataArray[] = $name;

// Convert the array back to a formatted string
$dataString = "const labelNames = " . json_encode($dataArray, JSON_PRETTY_PRINT) . ";\n";

// Replace the matched array portion with the updated content
$dataContent = preg_replace($pattern, $dataString, $dataContent, 1);

// Write the updated content back to the data.js file
file_put_contents($dataFile, $dataContent);

// Return a response to indicate the success
echo 'data.js file updated successfully!';
?>