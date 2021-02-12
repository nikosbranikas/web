<!DOCTYPE HTML>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<link rel="stylesheet" href="mystyle.css">
</head>

<body>

<form method="post" action="login_user.php">
<label for="uname">Username</label><br>
<input type="text" id="uname" name="username">
<br>
<label for="pass">Password</label><br>
<input type="password" id="pass" name="password">
<br>
<input type="submit" name="submit" value="Submit">
</form> 

<?php if (isset($_SESSION["error"])): ?>
  <p class="error"><?php echo $_SESSION["error"]; ?></p>
  <?php unset($_SESSION["error"]); ?>
<?php endif; ?>
</body>
</html>