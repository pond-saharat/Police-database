<?php
session_start();

require("../db.inc.php");

if (!$conn) {
	die("Database: connection failed.");
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

$loginerror = FALSE;
$wrongcredential = FALSE;

$user = $_SESSION['user'];
$stmt = $conn->prepare("SELECT * FROM `Users` WHERE `User_Name` = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  if (isset($_POST['newpassword'])) {
    $newpass = $_POST['newpassword'];
    $confirm = $_POST['confirmpass'];
    if ($newpass==$confirm) {
      $stmt = $conn->prepare("UPDATE `Users` SET `User_Password`=? WHERE `User_Name` = ?");
      $stmt->bind_param("ss", $newpass, $user);
      if ($stmt->execute()) { 
        echo "<script> location.href='./log-out.php'; </script>";
        exit();
      } 
    } else {
      echo "Please re-enter your password.";
    }
  }
}
?>
<form method="post" action="./db-script/change-password.php" class="row g-3">
  <h1>Enter new password</h1>
  <div class="col-auto">
    <input type="text" readonly class="form-control-plaintext" id="staticUsername" value=<?php echo $_SESSION['user'];?>>
  </div>
  <div class="col-auto">
    <input name ="newpassword" type="password" class="form-control" id="inputPassword" placeholder="New password">
  </div>
  <div class="col-auto">
    <input name ="confirmpass" type="password" class="form-control" id="inputPassword" placeholder="Re-enter password">
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-dark mb-3">Change my password</button>
  </div>
</form>
