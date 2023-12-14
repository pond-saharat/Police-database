<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("../../db.inc.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

$sql = "SELECT * FROM People ORDER BY People_ID;";
$textToBeSearched = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($textToBeSearched)) {
    $sql = "SELECT * FROM People WHERE People_name LIKE '%$textToBeSearched%' OR People_licence LIKE '%$textToBeSearched%' ORDER BY People_ID;";
}


$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
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
    
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["People_ID"]."</td><td>".$row["People_name"]."</td><td>".$row["People_address"]."</td><td>". $row["People_licence"]."</td><td>";
        echo "<button type='button' class='btn btn-outline-primary' data-bs-toggle='modal' data-bs-target='#editPeopleModal' data-bs-value='People&".$row["People_ID"]."'>Edit</button></a>";
        echo "&nbsp;&nbsp;";
        echo "<button type='button' class='btn btn-outline-danger' data-bs-toggle='modal' data-bs-target='#deletePeopleModal'>Delete</button></a>";
        echo "</td></tr>";
    }
    echo "<tr><td></td><td></td><td></td><td></td><td><button type='button' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#addPeopleModal'>Add</button></td></tr>";
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