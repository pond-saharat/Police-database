<?php
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$admin = $_POST['admin'] ?? '';

$response_array = array();

if ($username != '' && $password != '' && $admin != '') {
    // Insert new vehicle
    $sql = "INSERT INTO Users (User_Name, User_Password, User_Admin) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $username, $password, $admin);
    if (mysqli_stmt_execute($stmt)) {
        $response_array['status'] = 'success';
        $response_array['message'] = 'New vehicle and ownership record added successfully';
    } else {
        $response_array['status'] = 'error';
        $response_array['message'] = 'Error adding ownership record';
    }
    mysqli_stmt_close($stmt);
} else {
    $response_array['status'] = 'error';
    $response_array['message'] = 'Invalid input data';
}

mysqli_close($conn);
echo json_encode($response_array);
?>
