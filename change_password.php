<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="../mystyle.css">
</head>
<body>

<?php
$error1 = "";
$error2 = "";
$count = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if($_POST['password1'] == $_SESSION['password']) {
		if (empty($_POST["password2"])) {
			$error2 = "Password is required";
			$count += 1;
		} else if(strlen($_POST["password2"])<8) {
			$error2 = "Password must be at least 8 characters long";
			$count += 1;
		} else if(!preg_match("/\W/", $_POST["password2"])) {
			$error2 = "Password must contain at least one special character";
			$count += 1;
		}
		if ($count == 0) {
			include '../connect.php';
			$sql = "UPDATE users SET password = '".$_POST['password2']."' WHERE username = '".$_SESSION['username']."' AND password = '".$_SESSION['password']."'";
			if ($conn->query($sql) === TRUE) {
				$_SESSION['password'] = $_POST['password2'];
				echo "<p style='font-size: 20px; font-family: Comic Sans MS;'>Η αλλαγή κωδικού ολοκληρώθηκε επιτυχώς</p><br>";
				echo "<br><a style='padding: 13px 13px 13px 18px; background-color: #191970; color: #FFEBCD;' href='user.php'>Go to home page</a>";
			} 
			else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}

			$conn->close();
			exit;
		}
	}
	else { 
		$error1 = "Wrong password";
	}
}

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<label for="pass1">Current Password:</label><br>
<input type="password" id="pass1" name="password1"><br>
<span class="error">* <?php echo $error1;?></span>
<br><br>
<label for="pass2">New Password:</label><br>
<input type="password" id="pass2" name="password2"><br>
<span class="error">* <?php echo $error2;?></span>
<br><br>
<input type="submit" value="Submit">
</form>

</body>
</html>