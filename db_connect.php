<?php
//Creating_Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eventms";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>