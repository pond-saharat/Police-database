<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("../../db.inc.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

$sql = "SELECT * FROM Users ORDER BY User_ID;";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Officers</h1>";
    echo "<table class='table table-hover text-center'>";
    echo "<thead class='table-dark text-center'><th>ID</th><th>Username</th><th>Password</th><th>Administrator status</th></tr></thead>";
    echo "<tbody class='table-group-divider'>";
    
    while($row = mysqli_fetch_assoc($result)) {
        $admin = $row["User_Admin"] == 1 ? 'True' : 'False';
        echo "<tr><td>".$row["User_ID"]."</td><td>".$row["User_Name"]."</td><td>".$row["User_Password"]."</td><td>".$admin."</td>";
        echo "</tr>";
    }
    echo "<tr><td colspan='4' class='text-center'><button type='button' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#addUserModal'>Add</button></td></tr>";
    echo "</tbody></table>";
}
mysqli_close($conn);
?>