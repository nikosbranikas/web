<?php

include '../connect.php';

$sql = "SELECT COUNT(*) as count FROM entries
INNER JOIN users ON users.id = entries.user_id WHERE users.username='".$_SESSION["username"]."' AND users.password='".$_SESSION["password"]."'";

$count = 0;
$result = $conn->query($sql);
if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	$count = $row["count"];
}
else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql2 = "SELECT date, upload FROM geolocation
INNER JOIN users ON users.id = geolocation.user_id WHERE users.username='".$_SESSION["username"]."' AND users.password='".$_SESSION["password"]."'";

$upload = -1;
$date = "";
$result = $conn->query($sql2);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	if($row["upload"] > $upload) {
		$upload = $row["upload"];
		$date = $row["date"];
	}
}
else {
	echo "Error: " . $sql2 . "<br>" . $conn->error;
}

$conn->close();

echo "<table><tr><th>Last Upload Date</th><th>#Total_Entries</th></tr>";
echo "<tr><td>".$date."</td><td>".$count."</td></tr>";

?>