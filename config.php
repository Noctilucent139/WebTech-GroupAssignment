
<?php

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";  // should be changed if required 
// $password = "root";
$dbname = "online_library";
// $port = 8889;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
    
?>
