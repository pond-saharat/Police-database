<?php
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_GET['username'];

$sql = "SELECT * FROM Users WHERE User_Name = $username";
$result = mysqli_query($conn, $sql);

$response_array = array();
$response_array['exist'] = false;
if (mysqli_num_rows($result) > 0) {
    $response_array['exist'] = true;
}

mysqli_close($conn);

$response = json_encode($response_array);
header('Content-Type: application/json');
echo $response;
?>
