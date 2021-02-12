<!DOCTYPE HTML>
<html>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<head>
<style>
input {
  width: 250px;
  padding: 6px 10px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=submit] {
	background-color: #49ACF4;
}
input[type=submit]:hover {
  background-color: #496FF4;
}
form {
	text-align: center;
	border-radius: 5px;
    background-color: #f2f2f2;
	padding: 5px;
	margin: auto;
	margin-top: 7%;
	border-radius: 4px;
	width: 350px;
  
}
.error {
	color: #FF0000;
	text-align: center;
}
</style>
</head>
<body>
 <?php
 
$firstnameErr = $lastnameErr = $usernameErr = $passwordErr = $emailErr = "";
$count = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  if (empty($_POST["firstname"])) {
    $firstnameErr = "First Name is required";
	$count += 1;
  } 
  if (empty($_POST["lastname"])) {
    $lastnameErr = "Last Name is required";
	$count += 1;
  } 
  if (empty($_POST["username"])) {
    $usernameErr = "Username is required";
	$count += 1;
  } 
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
	$count += 1;
  } else if(strlen($_POST["password"])<8) {
    $passwordErr = "Password must be at least 8 characters long";
	$count += 1;
  } else if(!preg_match("/\W/", $_POST["password"])) {
	$passwordErr = "Password must contain at least one special character";
	$count += 1;
  } 

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
	$count += 1;
  } else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
	  $count += 1;
    }
  if($count == 0) {
	include 'connect.php';

	$username = $_POST["username"];
	$password = $_POST["password"];
	$fname = $_POST["firstname"];
	$lname = $_POST["lastname"];
	$email = $_POST["email"];
	$uploads = 0;
	$role = "user";

	$sql = "INSERT INTO users (username, password, email, firstname, lastname, uploads, role)
	VALUES ('".$username."', '".$password."', '".$email."', '".$fname."', '".$lname."', '".$uploads."', '".$role."')";

	if ($conn->query($sql) === TRUE) {
		echo "<p style='font-size: 20px; font-family: Comic Sans MS;'>Ο λογαριασμός σας ολοκληρώθηκε με επιτυχία!</p><br>";
		echo "<br><a style='padding: 13px 13px 13px 18px; background-color: #191970; color: #FFEBCD;' href='index.html'>Go to start page</a>";
	}else {
	echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
	exit;
  }
}

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<label for="fname">First Name</label><br>
<input type="text" id="fname" name="firstname">
<span class="error">* <?php echo "<br>" . $firstnameErr;?></span>
<br>
<label for="lname">Last Name</label><br>
<input type="text" id="lname" name="lastname">
<span class="error">* <?php echo "<br>" . $lastnameErr;?></span>
<br>
<label for="uname">Username</label><br>
<input type="text" id="uname" name="username">
<span class="error">* <?php echo "<br>" . $usernameErr;?></span>
<br>
<label for="pass">Password</label><br>
<input type="password" id="pass" name="password">
<span class="error">* <?php echo "<br>" . $passwordErr;?></span>
<br>
<label for="email">E-mail</label><br>
<input type="text" id="email" name="email">
 <span class="error">* <?php echo "<br>" . $emailErr;?></span>
 <br>
<input type="submit" name="submit" value="Submit">

</form> 

</body>
</html>