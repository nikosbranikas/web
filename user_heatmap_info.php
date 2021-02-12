<?php

include '../connect.php';

$sql = "SELECT E.serverIPAddress, R.content_type FROM entries E
INNER JOIN users U ON U.id = E.user_id 
INNER JOIN response R on R.user_id = E.user_id WHERE U.username = '".$_SESSION["username"]."'";

$result = $conn->query($sql);
$data = [];
$counter = 0;
if ($result->num_rows > 0) {
	for($i=0; $i<$result->num_rows; $i++) {
		$row = $result->fetch_assoc();
		if((strpos($row["content_type"], 'html') !== false) || (strpos($row["content_type"], 'php') !== false) || (strpos($row["content_type"], 'asp') !== false) || (strpos($row["content_type"], 'jsp') !== false)) {
			$data[$counter] = $row["serverIPAddress"];
			$counter++;
		}
	}
}
else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

echo json_encode($data);
?>