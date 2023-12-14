<?php
require("../db.inc.php");

if (!$conn) {
	die("Database: connection failed.");
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$response_array = array();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $stmt = $conn->prepare("UPDATE `Users` SET `User_Password`=? WHERE `User_Name` = ?");
    $newpass = $_POST['password'];
    $user = $_POST['username'];
    $stmt->bind_param("ss", $newpass, $user);
    if ($stmt->execute()) { 
        $response_array['status'] = true;
        $response_array['message'] = 'Success';
    } else {
      $response_array['status'] = false;
      $response_array['message'] = 'Invalid input data';
    }
}

mysqli_close($conn);
echo json_encode($response_array);
?>
