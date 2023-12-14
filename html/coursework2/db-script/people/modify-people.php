<?php
require '../../db.inc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

// Decode the JSON data
$message = json_decode($_POST['json']);

$response_array = array();

// Check if 'People_ID' is set in the JSON data
if (isset($message->id)) {
    $peopleID = $message->id;

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM People WHERE `People_ID`=?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $peopleID);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);
    // Check if there are results
    if ($result) {
        // Fetch data and store it in the response array
        while ($row = mysqli_fetch_assoc($result)) {
            $response_array[] = $row;
        }

        // Close the result set
        mysqli_free_result($result);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);

// Convert the response array to JSON
$response = json_encode($response_array);

// Print the JSON response
print($response);
?>
