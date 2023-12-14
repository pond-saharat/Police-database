<?php
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$response_array = array();

if (isset($_GET['ownerId'])) {
    $peopleID = $_GET['ownerId'];

    $sql = "SELECT * FROM People WHERE People_ID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $peopleID);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $response_array = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

$response = json_encode($response_array);
header('Content-Type: application/json');
echo $response;
?>
