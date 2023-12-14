<?php
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$vehicleId = $_POST['vehicleId'] ?? '';
$ownerId = $_POST['ownerId'] ?? '';
$date = $_POST['date'] ?? '';
$report = $_POST['report'] ?? '';
$offenceId = $_POST['offenceId'] ?? '';

$response_array = array();

if ($vehicleId != '' && $ownerId != '' && $date != '' && $report != '' && $offenceId != '') {
    $sql = "INSERT INTO Incident (Vehicle_ID, People_ID, Incident_Date, Incident_Report, Offence_ID) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iissi", $vehicleId, $ownerId, $date, $report, $offenceId);

    if (mysqli_stmt_execute($stmt)) {
        $response_array['status'] = 'success';
        $response_array['message'] = 'A new incident is added.';
    } else {
        $response_array['status'] = 'error';
        $response_array['message'] = 'An error occurs while adding new incident';
    }
    mysqli_stmt_close($stmt);
} else {
    $response_array['status'] = 'error';
    $response_array['message'] = 'Invalid input.';
}

mysqli_close($conn);
echo json_encode($response_array);
?>
