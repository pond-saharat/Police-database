<?php
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
$licence = $_POST['licence'] ?? '';

$response_array = array();

if ($id != '' && $name != '' && $address != '' && $licence != '') {
    $sql = "UPDATE People SET People_name = ?, People_address = ?, People_licence = ? WHERE People_ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $address, $licence, $id);

    if (mysqli_stmt_execute($stmt)) {
        $response_array['peopleId'] = $id;
        $response_array['status'] = 'success';
        $response_array['message'] = 'New person added successfully';
    } else {
        $response_array['status'] = 'error';
        $response_array['message'] = 'Error adding new person';
    }
    mysqli_stmt_close($stmt);
} else {
    $response_array['status'] = 'error';
    $response_array['message'] = 'Invalid input data';
}

mysqli_close($conn);
echo json_encode($response_array);
?>
