
<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "online_library";
$port = 8889;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
?>
