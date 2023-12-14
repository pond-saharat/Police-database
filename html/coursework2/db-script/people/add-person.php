<?php
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
$licence = $_POST['licence'] ?? '';

$response_array = array();

if ($name != '' && $address != '' && $licence != '') {
    $sql = "INSERT INTO People (People_name, People_address, People_licence) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $address, $licence);

    if (mysqli_stmt_execute($stmt)) {
        $newPersonId = mysqli_insert_id($conn);
        $response_array['newOwnerId'] = $newPersonId;
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
