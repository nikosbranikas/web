<!DOCTYPE HTML>

<body>

<?php
session_start();

include 'connect.php';

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT username, password FROM users
WHERE users.role='admin' AND users.username='".$username."' AND users.password='".$password."';";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	$_SESSION['username'] = $row['username'];
	header('Location: admin/admin.html');
} 
else {
    $_SESSION['error'] = "Wrong username or password";
	header('Location: login_form_admin.php');
}

$conn->close();
?>

</body>