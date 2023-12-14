<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("../../db.inc.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

$sql = "SELECT Incident.Incident_ID, Vehicle.*, People.*,Incident.Incident_Date, Incident.Incident_Date, Incident.Incident_Report, Offence.Offence_description, COALESCE(Fine_Amount, 'N/A') as Fine_Amount, COALESCE(Fine_Points, 'N/A') as Fine_Points FROM Incident
LEFT JOIN Vehicle ON Incident.Vehicle_ID = Vehicle.Vehicle_ID
LEFT JOIN People ON Incident.People_ID = People.People_ID
LEFT JOIN Offence ON Incident.Offence_ID = Offence.Offence_ID
LEFT JOIN Fines ON Incident.Incident_ID = Fines.Incident_ID";

$textToBeSearched = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($textToBeSearched)) {
    $sql .= " WHERE People_name LIKE '%$textToBeSearched%'";
}
$sql .= " ORDER BY Incident.Incident_ID;";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Reports</h1>";
	echo "<div id='tableContainer'>";
	echo '<form method="get" action="" id="searchForm">';
	echo "
		<div class='input-group mb-3'>
			<input type='text' class='form-control' name='search' placeholder='Search people by their name or their licence number' aria-label='Recipient\'s username' aria-describedby='basic-addon2' value='".$textToBeSearched."'>
		</div>
	</form>";
    echo "<table class='table table-hover'>";
    echo "<thead class='table-dark text-center'><th>ID</th><th>Vehicle type</th><th>Colour</th><th>Vehicle licence</th><th>Vehicle owner</th><th>Date</th><th>Report</th><th>Offence</th><th>Fine amount</th><th>Fine points</th><th>Action</th></tr></thead>";
    echo "<tbody class='table-group-divider'>";
    
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["Incident_ID"]."</td><td>".$row["Vehicle_type"]."</td><td>".$row["Vehicle_colour"]."</td><td>".$row["Vehicle_licence"]."</td><td>".$row["People_name"]."</td><td>".$row["Incident_Date"]."</td><td>".$row["Incident_Report"]."</td><td>".$row["Offence_description"]."</td><td>".$row["Fine_Amount"]."</td><td>".$row["Fine_Points"]."</td><td>";
        echo "<button type='button' class='btn btn-outline-danger";
        if ($_SESSION["admin"] == 0) {echo " disabled";}
        echo "' data-bs-toggle='modal' data-bs-target='#associateFineModal'>Set Fines</button></a>";
        echo "&nbsp;&nbsp;";
        echo "</td></tr>";
    }
    echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><td></td></td><td></td><td></td><td><button type='button' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#addIncidentModal'>Add</button></td></tr>";
    echo "</tbody></table>";
}
else {
    echo "<h1>People</h1>";
	echo "<div id='tableContainer'>";
	echo '<form method="get" action="" id="searchForm">';
	echo "
		<div class='input-group mb-3'>
			<input type='text' class='form-control' name='search' placeholder='Search people by their name or their licence number' aria-label='Recipient\'s username' aria-describedby='basic-addon2' value='".$textToBeSearched."'>
		</div>
	</form>";
    echo "<table class='table table-hover'>";
    echo "<thead class='table-dark text-center'><th>ID</th><th>Name</th><th>Address</th><th>Driver's Licence</th><th>Action</th></tr></thead>";
    echo "<tbody class='table-group-divider'>";
    echo "<tr><td colspan='5' class='text-center'>Nothing found.</td></tr></tbody></table>";
}
mysqli_close($conn);
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    $('#searchForm input[name="search"]').on('keyup', function() {
        var formData = $('#searchForm').serialize();

        $.ajax({
            type: 'GET',
            url: './db-script/people/people.php',
            data: formData,
            success: function(response) {
				console.log(response);
				$('#tableContainer table tbody').html($(response).find('table tbody').html());
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});
</script>