<?php
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM Offence";
$result = mysqli_query($conn, $sql);

$response_array = array();

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $response_array[] = $row;
    }
}

mysqli_close($conn);

$response = json_encode($response_array);
header('Content-Type: application/json');
echo $response;
?>
