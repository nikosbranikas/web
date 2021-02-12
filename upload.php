<?php 
  
header("Content-Type: application/json"); 
  
$data = json_decode(file_get_contents("php://input"), true); 
$entries = $data["entries"];
$length = count($entries);

$upload = 0;
for($x=0; $x<$length; $x++) {
	
	$startedDateTime = $entries[$x]["startedDateTime"];
	$serverIPAddress = $entries[$x]["serverIPAddress"];
	$wait = $entries[$x]["timings"]["wait"];
	$method = $entries[$x]["request"]["method"];
	$url = $entries[$x]["request"]["url"];
	$url = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
	$status = $entries[$x]["response"]["status"];
	$statusText = $entries[$x]["response"]["statusText"];
	$headers1 = $entries[$x]["request"]["headers"];
	$headers2 = $entries[$x]["response"]["headers"];
	
	$length2 = count($headers1);
	$length3 = count($headers2);
	
	$content_type = "";
	$cache_control = "";
	$pragma = "";
	$expires = "";
	$age = "";
	$last_modified = "";
	$host = "";
	
	$id = 0;
	for($y=0; $y<$length2; $y++) {
		if($headers1[$y]["name"] == "content-type") {
			$content_type = $headers1[$y]["value"];
		}
		if($headers1[$y]["name"] == "cache-control") {
			$cache_control = $headers1[$y]["value"];
		}
		if($headers1[$y]["name"] == "pragma") {
			$pragma = $headers1[$y]["value"];
		}
		if($headers1[$y]["name"] == "expires") {
			$expires = $headers1[$y]["value"];
		}
		if($headers1[$y]["name"] == "age") {
			$age = $headers1[$y]["value"];
		}
		if($headers1[$y]["name"] == "last-modified") {
			$last_modified = $headers1[$y]["value"];
		}
		if($headers1[$y]["name"] == "host") {
			$host = $headers1[$y]["value"];
		}
	}
	
	$content_type2 = "";
	$cache_control2 = "";
	$pragma2 = "";
	$expires2 = "";
	$age2 = "";
	$last_modified2 = "";
	$host2 = "";
	for($y=0; $y<$length3; $y++) {
		if($headers2[$y]["name"] == "content-type") {
			$content_type2 = $headers2[$y]["value"];
		}
		if($headers2[$y]["name"] == "cache-control") {
			$cache_control2 = $headers2[$y]["value"];
		}
		if($headers2[$y]["name"] == "pragma") {
			$pragma2 = $headers2[$y]["value"];
		}
		if($headers2[$y]["name"] == "expires") {
			$expires2 = $headers2[$y]["value"];
		}
		if($headers2[$y]["name"] == "age") {
			$age2 = $headers2[$y]["value"];
		}
		if($headers2[$y]["name"] == "last-modified") {
			$last_modified2 = $headers2[$y]["value"];
		}
		if($headers2[$y]["name"] == "host") {
			$host2 = $headers2[$y]["value"];
		}
	}
	
	include '../connect.php';
	$sql1 = "SELECT id, uploads FROM users WHERE username='".$_SESSION["username"]."' AND password='".$_SESSION["password"]."'";
	$result = $conn->query($sql1);
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$id = $row['id'];
		$upload = $row['uploads'] + 1;
	} else {
		echo "Error: " . $sql1 . "<br>" . $conn->error;
	}
	
	$sql2 = "INSERT INTO entries (user_id, upload, entry_idx, startedDateTime, serverIPAddress, wait)
	VALUES ('".$id."', '".$upload."', '".$x."', '".$startedDateTime."', '".$serverIPAddress."', '".$wait."')";
	if ($conn->query($sql2) === TRUE) {
	} else {
		echo "Error: " . $sql2 . "<br>" . $conn->error;
	}
	
	$sql3 = "INSERT INTO request (user_id, upload, entry_idx, method, url, content_type, cache_control, pragma, expires, age, last_modified, host)
	VALUES ('".$id."', '".$upload."', '".$x."', '".$method."', '".$url."', '".$content_type."', '".$cache_control."', '".$pragma."', '".$expires."', '".$age."', '".$last_modified."', '".$host."')";
	if ($conn->query($sql3) === TRUE) {
	} else {
		echo "Error: " . $sql3 . "<br>" . $conn->error;
	}
	
	$sql4 = "INSERT INTO response (user_id, upload, entry_idx, status, statusText, content_type, cache_control, pragma, expires, age, last_modified, host)
	VALUES ('".$id."', '".$upload."', '".$x."', '".$status."', '".$statusText."', '".$content_type2."', '".$cache_control2."', 
	'".$pragma2."', '".$expires2."', '".$age2."', '".$last_modified2."', '".$host2."')";
	if ($conn->query($sql4) === TRUE) {
	} else {
		echo "Error: " . $sql4 . "<br>" . $conn->error;
	}
	
	
	$conn->close();
}

include '../connect.php';

$sql5 = "UPDATE users SET uploads = '".$upload."' WHERE username = '".$_SESSION["username"]."' AND password = '".$_SESSION["password"]."'";
if ($conn->query($sql5) === TRUE) {
} else {
	echo "Error: " . $sql5 . "<br>" . $conn->error;
}

$geo = $data["loc"];
$ip = $geo["ip"];
$isp = $geo["isp"];
$city = $geo["city"];
$lat = $geo["lat"];
$lon = $geo["lon"];
$mydate = getdate(date("U"));
$date = $mydate['weekday'] . ", " . $mydate['month'] . " " . $mydate['mday'] . ", " . $mydate['year'];

$sql = "INSERT INTO geolocation (user_id, upload, ip, isp, city, lat, lon, date)
VALUES ('".$id."', '".$upload."', '".$ip."', '".$isp."', '".$city."', '".$lat."', '".$lon."', '".$date."')";
if ($conn->query($sql) === TRUE) {
} else {
	echo "Error: " . $sql4 . "<br>" . $conn->error;
}

$conn->close();


echo "File uploaded successfully";
  
?> 
