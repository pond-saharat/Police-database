<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("../../db.inc.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

$sql = "SELECT Vehicle.*, COALESCE(People.People_name, 'N/A') as `People_name`, COALESCE(People.People_licence, 'N/A') as `People_licence` FROM Vehicle 
LEFT JOIN Ownership ON Vehicle.Vehicle_ID = Ownership.Vehicle_ID
LEFT JOIN People ON Ownership.People_ID = People.People_ID";

$textToBeSearched = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($textToBeSearched)) {
	$sql .= " WHERE Vehicle.Vehicle_licence LIKE '%$textToBeSearched%' ORDER BY Vehicle_ID;";
} else {
	$sql .= " ORDER BY Vehicle_ID;";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Vehicle</h1>";
	echo "<div id='tableContainer'>";
	echo '<form method="get" action="" id="searchForm">';
	echo "
		<div class='input-group mb-3'>
			<input type='text' class='form-control' name='search' placeholder='Search vehicles by a licence plate number' aria-label='Recipient\'s username' aria-describedby='basic-addon2' value='".$textToBeSearched."'>
		</div>
	</form>";
    echo "<table class='table table-hover'>";
    echo "<thead class='table-dark text-center'><th>ID</th><th>Type</th><th>Colour</th><th>Licence plate number</th><th>Owner</th><th>Owner's licence</th><th>Action</th></tr></thead>";
    echo "<tbody class='table-group-divider'>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["Vehicle_ID"]."</td><td>".$row["Vehicle_type"]."</td><td>".$row["Vehicle_colour"]."</td><td>". $row["Vehicle_licence"]."</td><td>".$row["People_name"]."</td><td>".$row["People_licence"]."</td><td>";
        echo "<button type='button' class='btn btn-outline-primary' data-bs-toggle='modal' data-bs-target='#editPeopleModal' data-bs-value='People&".$row["People_name"]."'>Edit</button></a>";
        echo "&nbsp;&nbsp;";
        echo "<button type='button' class='btn btn-outline-danger' data-bs-toggle='modal' data-bs-target='#deletePeopleModal'>Delete</button></a>";
        echo "</td></tr>";
    }
    echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><button type='button' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#addVehicleModal'>Add</button></td></tr>";
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
    echo "<tr><td colspan='7' class='text-center'>Nothing found.</td></tr></tbody></table>";
}
mysqli_close($conn);
?>
<script>
$(document).ready(function() {
    $('#searchForm input[name="search"]').on('keyup', function() {
        var formData = $('#searchForm').serialize();

        $.ajax({
            type: 'GET',
            url: './db-script/vehicle/vehicle.php',
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