<?php
session_start();

$err = "";
$count = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["username"])) {
    $err = "Username is required";
	$count += 1;
  } 
  if (empty($_POST["password"])) {
    $err = "Password is required";
	$count += 1;
  } 
  if($count > 0) {
	$_SESSION["error"] = $err;
	header('Location: login_form_user.php');
	exit;
  }
}

include 'connect.php';

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT username, password FROM users WHERE username='".$username."' AND password='".$password."' AND ROLE = 'user'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	$_SESSION["username"] = $username;
	$_SESSION["password"] = $password;
	header('Location: user/user.php');
} 
else {
	$_SESSION['error'] = "Wrong username or password";
	header('Location: login_form_user.php');
}

$conn->close();
exit;
?>