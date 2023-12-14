<?php
session_start();
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$userId = $_SESSION['id'] ?? 'NULL';
$method = $_POST['method'] ?? 'NULL';
$affectedTable = $_POST['table'] ?? 'NULL';
$affectedRecord = $_POST['record'] ?? 'NULL';
$now = date('Y-m-d H:i:s');

$response_array = array();

$sql = "SELECT FROM * WHERE Log VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "issss", $userId, $method, $affectedTable, $affectedRecord, $now);

if (mysqli_stmt_execute($stmt)) {
    $response_array['status'] = true;
} else {
    $response_array['status'] = false;
}
mysqli_stmt_close($stmt);
mysqli_close($conn);

echo json_encode($response_array);
header('Content-Type: application/json');
?>
