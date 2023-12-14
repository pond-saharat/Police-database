<?php
session_start();
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$tableId = $_POST['tableId'] ?? '';
$tableValue = $_POST['tableValue'] ?? '';
$userId = isset($_SESSION['id']) ? $_SESSION['id'] : 'NULL';
$incidentId = $_POST['incidentId'] == '' ? 'NULL': $_POST['incidentId'];
$vehicleId = $_POST['vehicleId'] == '' ? 'NULL' : $_POST['vehicleId'];
$peopleId = $_POST['peopleId'] == '' ? 'NULL' : $_POST['peopleId'];
$method = $_POST['method'] == '' ? NULL :  $_POST['method'];
$affectedTable = $_POST['table'] == '' ? NULL : $_POST['table'];
$now = date('Y-m-d H:i:s');
$response_array = array();

if ($tableId != '' && $tableValue != '') {
    $sql = "SELECT * FROM $affectedTable WHERE $tableId = '$tableValue'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $affectedRecord = $row;
        
        // Insert into Log table
        $sql = "INSERT INTO Log (User_ID, Incident_ID, Vehicle_ID, People_ID, Method, Table_name, Affected_record, Datetime) VALUES ($userId, $incidentId, $vehicleId, $peopleId, '$method', '$affectedTable', '".json_encode($affectedRecord)."', '$now')";
        
        if (mysqli_query($conn, $sql)) {
            $response_array['status'] = true;
            $response_array['record'] = $affectedRecord;
        } else {
            $response_array['status'] = false;
            $response_array['error'] = mysqli_error($conn);
        }
    } else {
        $response_array['status'] = false;
        $response_array['error'] = mysqli_error($conn);
    }
}

mysqli_close($conn);
echo json_encode($response_array);
?>
