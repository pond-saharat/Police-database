<?php
session_start();
require("db.inc.php");
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
	die("Database: connection failed.");
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

$loginerror = FALSE;
$wrongcredential = FALSE;
# Unset session variables if the user logs out
if (isset($_POST["logout"])) {
	unset($_SESSION["user"]);
	unset($_SESSION["id"]);
}

# POST: username and password
$user = isset($_POST["username"])? $_POST["username"] : "";
$pass = isset($_POST["password"])? $_POST["password"] : "";

$query = "SELECT * FROM `Users` WHERE `User_Name` = ? AND `User_Password` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

$admin = 0;
$id = -1;
$id = isset($row["User_ID"])? $row["User_ID"]: -1;
if ($result->num_rows > 0) {
	{
		$result->num_rows;
		$row = $result->fetch_assoc();
		$id = isset($row["User_ID"])? $row["User_ID"]: -1;
		$admin = isset($row["User_ID"])? $row["User_Admin"] : 0;
	  }
	  mysqli_close($conn);
	  
	  // If this was a brand new, successful login, then set the session variables
	  if($id != -1 && !isset($_SESSION["user"]) && !isset($_SESSION["id"]))
	  {
		$_SESSION["user"] = $user;
		$_SESSION["id"] = $id;
		$_SESSION["admin"] = $admin;
	  }
	  // If there was a login attempt, i.e., user and pass were POST-ed but the session vars are not set, then there's been a login problem, so flag it
	  elseif(!isset($_SESSION["user"]) && !isset($_SESSION["id"]))
	  {
		$loginerror = TRUE;
	  }
} elseif ($result->num_rows == 0 && isset($_POST["username"]) && isset($_POST["password"])) {
	$wrongcredential = TRUE;
}
?>

<!-- HTML -->
<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">	
	<title>Database</title>
		<?php 
		require 'db.inc.php';
		?>
	</head>
	<body>
		<main>
			<?php
			// Selectively show the logout button / form only if this user is logged in
			if(isset($_SESSION["user"]) && 
				isset($_SESSION["id"]))
			{
				echo "<script> location.href='./database.php'; </script>";
				exit();
			}
			else if (!isset($_SESSION["user"]) && !isset($_SESSION["id"]))
			{
				if ($loginerror) {
				echo "<p>Invalid Username or Password</p>";
				}
			}
			?>
				<form method="POST">
				<div class="h-100 w-100 position-fixed" style="padding: 15% 35% 20% 35%;">
				<h1 style="text-align: center;"><i class="bi bi-database-fill fa-lg"></i>&nbsp;Police Database</h1></br>
				<div class="input-group mb-3 justify-content-center align-items-center">
					<span style="width: 10%; border: 0rem;" class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle fa-lg"></i></span>
					<input name="username" type="text" id="user" value="" size="30" maxlength="32" class="form-control" aria-label="Username" aria-describedby="basic-addon1" required/><br/>
				</div>
				<div class="input-group mb-3 justify-content-cente">
					<span style="width: 10%; border: 0rem;" class="input-group-text" id="basic-addon1"><i class="bi bi-key-fill fa-lg"></i></span>
					<input name="password" type="password" id="pass" value="" size="30" maxlength="32" class="form-control" aria-label="Username" aria-describedby="basic-addon1" required/><br/>
				</div>
				<div class="d-flex justify-content-center"><input style="width: 10rem;" class="btn btn-dark text-center" type="Submit" value="Log in" data-mdb-ripple-init></div>
				<?php 
					if ($wrongcredential) {
						echo "Invalid username or password";
					}
				?>
				</form>
				
		</main>
	
</body>
</html>