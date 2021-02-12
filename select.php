<!DOCTYPE HTML>
<html>
<link rel="stylesheet" href="mystyle.css">
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST['action'] == 'login') {
		header('Location: login_form_user.php');
	} else if ($_POST['action'] == 'sign up') {
		header('Location: signup.php');
	} else {
		//invalid action!
	}
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<input type="submit" name="action" value="login"/><br>
	<input type="submit" name="action" value="sign up"/><br>
</form>


</body>

</html>