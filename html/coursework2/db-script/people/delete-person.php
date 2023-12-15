<?php
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_POST['id'] ?? '';

$response_array = array();

if ($id != '') {
    $sql = "DELETE FROM Ownership WHERE People_ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        $sql = "DELETE FROM People WHERE People_ID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $response_array['id'] = $id;
            $response_array['status'] = 'success';
            $response_array['message'] = 'A person deleted successfully';
        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Error deleting new person';
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);

echo json_encode($response_array);
?>
