<?php
require '../../db.inc.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$response_array = array();

if (isset($_POST['vehicleId'])) {
    $vehicleId = $_POST['vehicleId'];

    $sql = "SELECT Vehicle.*, People.* FROM Vehicle LEFT JOIN Ownership ON Vehicle.Vehicle_ID = Ownership.Vehicle_ID
    LEFT JOIN People ON Ownership.People_ID = People.People_ID WHERE (People.People_ID IS NOT NULL) AND (Vehicle.Vehicle_ID = ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $vehicleId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    // The data is not null
    if ($result->num_rows == 1) {
        $response_array['hasOwner'] = true;
        $response_array['ownerId'] = $row['People_ID'];
        $response_array['ownerName'] = $row['People_name'];
        $response_array['ownerAddress'] = $row['People_address'];
        $response_array['ownerLicence'] = $row['People_licence'];
    } else {
        $response_array['hasOwner'] = false;
    }
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

$response = json_encode($response_array);
header('Content-Type: application/json');
echo $response;