<?php
$directory = './labels'; // Replace with the actual directory path

$folders = array();

if (is_dir($directory)) {
    if ($handle = opendir($directory)) {
        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != ".." && is_dir($directory . '/' . $file)) {
                $folders[] = $file;
            }
        }
        closedir($handle);
    }
}



// Alternatively, you can assign the folder names to a variable
$folderArray = $folders;

// Access the folder names from the array
foreach ($folderArray as $folder) {
    echo "<div>'$folder'</div><br>";
    // Log the folder name to the console
    echo "<script>console.log('$folder');</script>";
}
?>