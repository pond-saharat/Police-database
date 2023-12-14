<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("../../db.inc.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

$response_array = array();

if (isset($_POST['incidentId'])) {
    $incidentId = $_POST['incidentId'];
    $fineAmount = $_POST['amount'];
    $finePoints = $_POST['points'];
    $sql = "SELECT * FROM Fines WHERE Incident_ID = $incidentId";
    $result = mysqli_query($conn, $sql);
    
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO Fines (Fine_Amount, Fine_Points, Incident_ID) VALUES ($fineAmount, $finePoints, $incidentId);";
        $result = mysqli_query($conn, $sql);
        $fineId = mysqli_insert_id($conn);
    } else {
        $row = mysqli_fetch_assoc($result);
        $fineId = $row["Fine_ID"];
    }
    
    $sql = "UPDATE Fines SET Fine_Amount = $fineAmount, Fine_Points =$finePoints, Incident_ID=$incidentId WHERE Fine_ID = $fineId;";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $response_array["status"] = "success";
        $response_array["message"] = "Added fines successfully.";
    } else {
        $response_array["status"] = "error";
        $response_array["message"] = "Errors occur while adding fines.";
    }
}
mysqli_close($conn);

$response = json_encode($response_array);
header('Content-Type: application/json');
echo $response;
?>