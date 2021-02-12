<!DOCTYPE HTML>

<head>
<link rel="stylesheet" href="../sidebar.css">
<style>
.button {
  background-color: #C0C0C0;
  margin-left: 150px;
  border-color: #000000;
  border-style: solid;
  padding: 14px 28px;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
}
</style>
</head>

<body>
<div class="sidenav">
	<a href="user.php">Home</a>
	<a href="management.html">Profile Management</a>
	<a href="user_heatmap.php">Heatmap</a>
	<a href="../logoff.php">Log off</a>
</div>

<?php

echo "<p class=\"main\" style='font-family: Comic Sans MS;'>Hi ".$_SESSION["username"]."</p>";
?>
<p id="change"> </p>
<input class="button" type="file" id="selectFiles" value="Import" accept=".har" /><br><br>
<button class="button" id="import">Import</button>

<p id="result" style="margin-left: 150px; font-family: Comic Sans MS;"></p><br><br>

<script type="text/javascript">
	document.getElementById('import').onclick = function() {
    var files = document.getElementById('selectFiles').files;
	//console.log(files);
	if (files.length <= 0) {
		return false;
	}
	var fr = new FileReader();
	
		
	fr.onload = function(e) { 
		console.log(e);
		var result = JSON.parse(e.target.result);
		var formatted = JSON.stringify(result, null, 2);
		//document.getElementById('result').innerHTML = formatted;
		var myobj = result.log.entries;
		arr = [];
		var count = -1;
		var myProp = '';
		myobj.forEach(function (item) {
			count++;
			arr.push({});
			arr[count]["startedDateTime"] = item.startedDateTime;
			arr[count]["serverIPAddress"] = item.serverIPAddress;
			arr[count]["timings"] = {wait: item.timings.wait};
			arr[count]["request"] = {method: item.request.method, url: item.request.url, headers: []};
			arr[count]["response"] = {status: item.response.status, statusText: item.response.statusText, headers: []};
			var count2 = -1
			item.request.headers.forEach(function (item2) {
				if(Object.values(item2).indexOf('content-type') > -1) {
					count2++;
					arr[count]["request"]["headers"].push({});
					arr[count]["request"]["headers"][count2]["name"] = "content-type";
					arr[count]["request"]["headers"][count2]["value"] = item2.value;
				}
				if(Object.values(item2).indexOf('cache-control') > -1) {
					count2++;
					arr[count]["request"]["headers"].push({});
					arr[count]["request"]["headers"][count2]["name"] = "cache-control";
					arr[count]["request"]["headers"][count2]["value"] = item2.value;
				}
				if(Object.values(item2).indexOf('pragma') > -1) {
					count2++;
					arr[count]["request"]["headers"].push({});
					arr[count]["request"]["headers"][count2]["name"] = "pragma";
					arr[count]["request"]["headers"][count2]["value"] = item2.value;
				}
				if(Object.values(item2).indexOf('expires') > -1) {
					count2++;
					arr[count]["request"]["headers"].push({});
					arr[count]["request"]["headers"][count2]["name"] = "expires";
					arr[count]["request"]["headers"][count2]["value"] = item2.value;
				}
				if(Object.values(item2).indexOf('age') > -1) {
					count2++;
					arr[count]["request"]["headers"].push({});
					arr[count]["request"]["headers"][count2]["name"] = "age";
					arr[count]["request"]["headers"][count2]["value"] = item2.value;
				}
				if(Object.values(item2).indexOf('last-modified') > -1) {
					count2++;
					arr[count]["request"]["headers"].push({});
					arr[count]["request"]["headers"][count2]["name"] = "last-modified";
					arr[count]["request"]["headers"][count2]["value"] = item2.value;
				}
				if(Object.values(item2).indexOf('host') > -1) {
					count2++;
					arr[count]["request"]["headers"].push({});
					arr[count]["request"]["headers"][count2]["name"] = "host";
					arr[count]["request"]["headers"][count2]["value"] = item2.value;
				}
			});
			var count3 = -1;
			item.response.headers.forEach(function (item3) {
				if(Object.values(item3).indexOf('content-type') > -1) {
					count3++;
					arr[count]["response"]["headers"].push({});
					arr[count]["response"]["headers"][count3]["name"] = "content-type";
					arr[count]["response"]["headers"][count3]["value"] = item3.value;
				}
				if(Object.values(item3).indexOf('cache-control') > -1) {
					count3++;
					arr[count]["response"]["headers"].push({});
					arr[count]["response"]["headers"][count3]["name"] = "cache-control";
					arr[count]["response"]["headers"][count3]["value"] = item3.value;
				}
				if(Object.values(item3).indexOf('pragma') > -1) {
					count3++;
					arr[count]["response"]["headers"].push({});
					arr[count]["response"]["headers"][count3]["name"] = "pragma";
					arr[count]["response"]["headers"][count3]["value"] = item3.value;
				}
				if(Object.values(item3).indexOf('expires') > -1) {
					count3++;
					arr[count]["response"]["headers"].push({});
					arr[count]["response"]["headers"][count3]["name"] = "expires";
					arr[count]["response"]["headers"][count3]["value"] = item3.value;
				}
				if(Object.values(item3).indexOf('age') > -1) {
					count3++;
					arr[count]["response"]["headers"].push({});
					arr[count]["response"]["headers"][count3]["name"] = "age";
					arr[count]["response"]["headers"][count3]["value"] = item3.value;
				}
				if(Object.values(item3).indexOf('last-modified') > -1) {
					count3++;
					arr[count]["response"]["headers"].push({});
					arr[count]["response"]["headers"][count3]["name"] = "last-modified";
					arr[count]["response"]["headers"][count3]["value"] = item3.value;
				}
				if(Object.values(item3).indexOf('host') > -1) {
					count3++;
					arr[count]["response"]["headers"].push({});
					arr[count]["response"]["headers"][count3]["name"] = "host";
					arr[count]["response"]["headers"][count3]["value"] = item3.value;
				}
			});
		});
		
		btn1 = document.createElement("BUTTON");
		btn1.style.marginLeft = "200px";
		btn1.innerHTML = "save locally";
		document.body.appendChild(btn1);
		btn2 = document.createElement("BUTTON");
		//btn1.style.marginLeft = "20px";
		btn2.innerHTML = "upload";
		document.body.appendChild(btn2);
		btn1.classList.add('button');
		btn2.classList.add('button');
		
		btn1.onclick = function() {save_locally()};
		btn2.onclick = function() {upload()};
		/*
		var endpoint = 'http://ip-api.com/json/?fields=status,message,city,lat,lon,isp,query';
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var response = JSON.parse(this.responseText);
				if(response.status !== 'success') {
					console.log('query failed: ' + response.message);
					return;
				}
				obj = {};
				obj["ip"] = response.query;
				obj["isp"] = response.isp;
				obj["city"] = response.city;
				obj["lat"] = response.lat;
				obj["lon"] = response.lon;
				//document.getElementById('result').innerHTML = lon;
				
				var send = {entries:arr, loc:obj};
				document.getElementById('result').innerHTML = obj["lon"];
				var xhr = new XMLHttpRequest(); 
				var url = "upload.php";
				xhr.open("POST", url, true);
				xhr.setRequestHeader("Content-Type", "application/json");
				xhr.onreadystatechange = function () {
					if (xhr.readyState === 4 && xhr.status === 200) {
						document.getElementById('change').innerHTML = this.responseText; 
					}	
				};
				var data = JSON.stringify(send);
				xhr.send(data);
			}
		};
		xhr.open('GET', endpoint, true);
		xhr.send(); */
	}

	fr.readAsText(files.item(0));
};

function save_locally() {
	window.localStorage.setItem('my_file', JSON.stringify(arr));
	document.getElementById("selectFiles").remove();
	document.getElementById("import").remove();
	btn1.remove();
	btn2.remove();
	document.getElementById('result').innerHTML = "File saved locally";
}

function upload() {
	var endpoint = 'http://ip-api.com/json/?fields=status,message,city,lat,lon,isp,query';
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var response = JSON.parse(this.responseText);
			if(response.status !== 'success') {
				console.log('query failed: ' + response.message);
				return;
			}
			obj = {};
			obj["ip"] = response.query;
			obj["isp"] = response.isp;
			obj["city"] = response.city;
			obj["lat"] = response.lat;
			obj["lon"] = response.lon;
			//document.getElementById('result').innerHTML = lon;
				
			var send = {entries:arr, loc:obj};
			//document.getElementById('result').innerHTML = obj["lon"];
			var xhr = new XMLHttpRequest(); 
			var url = "upload.php";
			xhr.open("POST", url, true);
			xhr.setRequestHeader("Content-Type", "application/json");
			xhr.onreadystatechange = function () {
				if (xhr.readyState === 4 && xhr.status === 200) {
					document.getElementById("selectFiles").remove();
					document.getElementById("import").remove();
					btn1.remove();
					btn2.remove();
					document.getElementById('result').innerHTML = this.responseText; 
				}	
			};
			var data = JSON.stringify(send);
			xhr.send(data);
		}
	};
	xhr.open('GET', endpoint, true);
	xhr.send();
}

</script>

<?php
echo "<br><a href='logoff.php'>Log off</a>";
?>
</body>