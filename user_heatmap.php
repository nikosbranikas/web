<!DOCTYPE HTML>
<html>

<head>
<link rel="stylesheet" href="../sidebar.css">
</head>
<body>

<div class="sidenav">
	<a href="user.php">Home</a>
	<a href="management.html">Profile Management</a>
	<a href="user_heatmap.php">Heatmap</a>
	<a href="../logoff.php">Log off</a>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
<script src = "https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>
<div id="mapid" class="main" style="height: 600px;"></div>

<p id="change" style="margin-left: 150px;"></p>

<script type="text/javascript">
mymap = L.map("mapid");
let osmUrl = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
let osmAttrib = 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
let osm = new L.TileLayer(osmUrl, { attribution: osmAttrib });
mymap.addLayer(osm);
mymap.setView([38.246242, 21.7350847],8);

var url = "user_heatmap_info.php";
var xhr = new XMLHttpRequest();

xhr.onreadystatechange = function() {
	if(this.readyState == 4 && this.status == 200) {
		//document.getElementById('change').innerHTML = this.responseText;
		result = this.responseText;
		var ips = [];
		ips[0] = result[0];
		var count = [];
		count[0] = 0;
		var flag = false;
		
		for(let i=0; i<result.length; i++) {
			flag = false;
			for(let j=0; j<ips.length; j++) {
				if(result[i] === ips[j]) {
					count[j] = count[j] + 1;
					flag = true;
					break;
				}
			}
			if(flag === false) {
				ips.push(result[i]);
				count.push(1);
			}
		}
		
		//document.getElementById('change').innerHTML = count[0];
		
		var resp = [];
		var locations = [];
		for(var i=0; i<ips.length; i++) {
			(function(i) {
				var xhttp = new XMLHttpRequest({mozSystem: true});
				var addr = 'http://api.ipstack.com/' + ips[i] + '?access_key=8651345e676f6c65650cc2dd58de445d';
				xhttp.open("GET", addr, true);
				xhttp.send();
				xhttp.onreadystatechange = function () {
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						resp[i] = JSON.parse(xhttp.responseText);
						if(typeof resp[i] == 'undefined') {
							return;
						}
						else {
							locations.push({lat: resp[i].latitude, lng: resp[i].longitude, count: count[i]});
						}
						console.log(i);
						
						if(i === (ips.length -1)) {
							let testData = {
							data: locations
							};
							let cfg = {
								"radius": 40,
								"maxOpacity": 0.8,
								"scaleRadius": false,
								"useLocalExtrema": false,
								latField: 'lat',
								lngField: 'lng',
								valueField: 'count'
							};
							let heatmapLayer =  new HeatmapOverlay(cfg);
							mymap.addLayer(heatmapLayer);
							heatmapLayer.setData(testData);
						}
					}
				};
			})(i);
		}
	}
};
xhr.open("POST", url, true);
xhr.send();

</script>

</body>
</html>