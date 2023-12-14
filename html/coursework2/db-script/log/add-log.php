<?php
session_start();
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$tableId = $_POST['tableId'] ?? '';
$tableValue = $_POST['tableValue'] ?? '';

$userId = $_SESSION['id'] ?? 'NULL';
$incidentId = $_POST['incidentId'] ?? 'NULL';
$vehicleId = $_POST['vehicleId'] ?? 'NULL';
$peopleId = $_POST['peopleId'] ?? 'NULL';
$method = $_POST['method'] ?? 'NULL';
$affectedTable = $_POST['table'] ?? 'NULL';
$now = date('Y-m-d H:i:s');
$response_array = array();

if ($tableId != '' && $tableValue != '') {
    $sql = "SELECT * FROM `?` VALUES `?` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $affectedTable, $tableId, $tableValue);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($statement);
    $row = mysqli_fetch_assoc($result);
    $affectedRecord = $row;

    // Get Affected table 
    $sql = "INSERT INTO Log VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiiissss", $userId, $incidentId, $vehicleId, $peopleId, $method, $affectedTable, $affectedRecord, $now);

    if (mysqli_stmt_execute($stmt)) {
        $response_array['status'] = true;
        $response_array['record'] = $affectedRecord;
    } else {
        $response_array['status'] = false;
        $response_array['record'] = $affectedRecord;
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);

echo json_encode($response_array);
?>
