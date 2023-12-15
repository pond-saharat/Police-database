<?php
require '../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

$message = json_decode($_POST['json']);

$response_array = array();

if (isset($message->id)) {
    $peopleID = $message->id;

    $sql = "SELECT * FROM People WHERE `People_ID`=?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $peopleID);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response_array[] = $row;
        }

        mysqli_free_result($result);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

$response = json_encode($response_array);

print($response);
?>
