<?php  
		error_reporting(E_ALL);
		ini_set('display_errors',1);
		require("../db.inc.php");

		$conn = mysqli_connect($servername, $username, $password, $dbname);
								
		if(!$conn) {
			die ("Connection failed");
		}
										
		$sql = "SELECT * FROM Fines;";
		$result = mysqli_query($conn, $sql);
			
		if (mysqli_num_rows($result) > 0) {
			echo "<table style='padding-left: 10rem; padding-right: 10rem;' class='table table-hover'>";
			echo "<thead class='table-dark'><th>ID</th><th>Amount</th><th>License Number</th></tr></thead>";
			echo "<tbody class='table-group-divider'>";
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>".$row["ID"]."</td><td>".$row["Amount"]."</td><td>". $row["Points"]."</td></tr>"; 
			}
			echo "</tbody></table>";
		}
		else {
			echo "Nothing found!";
		}
															
		mysqli_close($conn);
?>