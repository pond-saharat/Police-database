<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("../../db.inc.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

$sql = "SELECT Log.*,Users.User_Name FROM Log LEFT JOIN Users ON Log.User_ID = Users.User_ID";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) >= 0) {
    echo "<h1>Log</h1>";
    echo "<table class='table table-hover'>";
    echo "<thead class='table-dark text-center'><th>ID</th><th>Officer</th><th>Incident ID</th><th>Vehicle</th><th>Person</th><th>Method</th><th>Affected table</th><th>Affected record</th><th>Datetime</th></tr></thead>";
    echo "<tbody class='table-group-divider'>";
    
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["Log_ID"]."</td><td>".$row["User_Name"]."</td><td>".$row["Method"]."</td><td>".$row["Table_name"]."</td><td>".$row["Affected_record"]."</td></tr>";
    }
    echo "</tbody></table>";
}
mysqli_close($conn);
?>