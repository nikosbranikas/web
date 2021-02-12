 <?php
$db_server["host"] = "localhost"; //database server
$db_server["username"] = "root"; // DB username
$db_server["password"] = ""; // DB password
$db_server["database"] = "project";// database name

$conn = mysqli_connect($db_server["host"], $db_server["username"], $db_server["password"], $db_server["database"]);

$conn->query ('SET CHARACTER SET utf8');
$conn->query ('SET COLLATION_CONNECTION=utf8_general_ci');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?> 