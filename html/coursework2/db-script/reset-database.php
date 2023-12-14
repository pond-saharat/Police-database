<?php
require("../db.inc.php");
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die("Database: connection failed.");
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$path = "../sql/coursework-2.sql";

$sqlScript = file_get_contents($path);

// Execute the SQL script
if ($conn->multi_query($sqlScript)) {
    echo "<h1>Database has been reset.</h1>";
} else {
    echo "Error executing script: " . $conn->error;
}

// Close connection
$conn->close();
?>