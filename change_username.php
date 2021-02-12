<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="../mystyle.css">
</head>
<body>

<?php
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if($_POST['username1'] == $_SESSION['username']) {
		include '../connect.php';
		$sql = "UPDATE users SET username = '".$_POST['username2']."' WHERE username = '".$_SESSION['username']."' AND password = '".$_SESSION['password']."'";
		if ($conn->query($sql) === TRUE) {
			$_SESSION['username'] = $_POST['username2'];
			echo "<p style='font-size: 20px; font-family: Comic Sans MS;'>Η αλλαγή του username σας ολοκληρώθηκε επιτυχώς</p><br>";
			echo "<br><a style='padding: 13px 13px 13px 18px; background-color: #191970; color: #FFEBCD;' href='user.php'>Go to your home page</a>";
		} 
		else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
		exit;
	}
	else { 
		$error = "Wrong username";
	}
}

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<label for="uname1">Current Username:</label><br>
<input type="text" id="uname1" name="username1"><br>
<span class="error">* <?php echo $error;?></span>
<br><br>
<label for="uname1">New Username:</label><br>
<input type="text" id="uname2" name="username2">
<input type="submit" value="Submit">
</form>

</body>
</html>