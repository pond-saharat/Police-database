<?php
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$type = $_POST['type'] ?? '';
$colour = $_POST['colour'] ?? '';
$licence = $_POST['licence'] ?? '';
$ownerId = $_POST['ownerId'] ?? '';

$response_array = array();

if ($ownerId != '' && $type != '' && $colour != '' && $licence != '') {
    // Insert new vehicle
    $sql = "INSERT INTO Vehicle (Vehicle_type, Vehicle_colour, Vehicle_licence) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $type, $colour, $licence);
    if (mysqli_stmt_execute($stmt)) {
        $newVehicleId = mysqli_insert_id($conn);
        if ($ownerId !== "no") {
            // Get the latest vehicle ID
            $vehicleId = mysqli_insert_id($conn); 

            // Insert into Ownership
            $sql = "INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $ownerId, $vehicleId);

            if (mysqli_stmt_execute($stmt)) {
                $response_array['newVehicleId'] = $newVehicleId;
                $response_array['status'] = 'success';
                $response_array['message'] = 'New vehicle and ownership record added successfully';
            } else {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Error adding ownership record';
            }
        } else {
            $response_array['newVehicleId'] = $newVehicleId;
            $response_array['status'] = 'success';
            $response_array['message'] = 'Added a vehicle without an owner';
        }
    } else {
        $response_array['status'] = 'error';
        $response_array['message'] = 'Error adding new vehicle';
    }

    mysqli_stmt_close($stmt);
} else {
    $response_array['status'] = 'error';
    $response_array['message'] = 'Invalid input data';
}

mysqli_close($conn);

echo json_encode($response_array);
?>
