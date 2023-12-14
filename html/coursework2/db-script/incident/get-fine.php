<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("../../db.inc.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

if (isset($_GET['incidentID'])) {
    $sql = "SELECT Incident.Incident_ID, Vehicle.*, People.*,Incident.Incident_Date, Incident.Incident_Date, Incident.Incident_Report, Offence.Offence_description, COALESCE(Fine_Amount, 'N/A') as Fine_Amount, COALESCE(Fine_Points, 'N/A') as Fine_Points FROM Incident
    LEFT JOIN Vehicle ON Incident.Vehicle_ID = Vehicle.Vehicle_ID
    LEFT JOIN People ON Incident.People_ID = People.People_ID
    LEFT JOIN Offence ON Incident.Offence_ID = Offence.Offence_ID
    LEFT JOIN Fines ON Incident.Incident_ID = Fines.Incident_ID";
    $sql .= " WHERE Incident.Incident_ID = '".$_GET['incidentID']."'";

    $result = mysqli_query($conn, $sql);
    $response_array = array();

    if (mysqli_num_rows($result) == 1) {
        while($row = mysqli_fetch_assoc($result)) {
            $response_array[] = $row;
        }
    }
}
mysqli_close($conn);
$response = json_encode($response_array);
header('Content-Type: application/json');
echo $response;
?>