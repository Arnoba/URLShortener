<?php
	session_start();
	include_once('class/dbconnection.php');
	// Setup connection to DB
	$connection = new dbConnect();
	
	// 1. Collect the IP address from the user
	$mysql = "SELECT IP FROM links";
	$result = mysql_query($mysql);
	while ($row = mysql_fetch_assoc($result)) {
		$IPADDRESS[] = trim($row[IP]);
	}
	
	// 2. Send it via an API call to some resolution service
	//$xml = simplexml_load_file("http://gcdsrv.com/~lookup/?ipadr=" . $IPADDRESS); multiple errors using the service provided to us by college
	for($x = 0; $x<sizeof($IPADDRESS); $x++){
		$xml = simplexml_load_file("http://ip-json.rhcloud.com/xml/".trim($IPADDRESS[$x]));//free online geolocation ip api
		$lat[$x] = $xml->latitude;
		$lon[$x] = $xml->longitude;
	}
	//Collect links
	$mysql = "SELECT url FROM links";
	$result = mysql_query($mysql);
	while ($row = mysql_fetch_assoc($result)) {
		$url[] = $row[url];
	}

	// Google Maps Javascript API Key: AIzaSyANYFuAK-e9XxW7DJ38lSFPCNPTX6LRJw8
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<link rel="stylesheet" href = "style.css">
		<style type="text/css">
		   	html,body{ 
			height: 100%;
			width:	100%;
			}
			#map-canvas { height: 50%; width: 50%;}	
		</style>
		<script type="text/javascript"
		   	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANYFuAK-e9XxW7DJ38lSFPCNPTX6LRJw8">
		</script>
		<script type="text/javascript">
		   	function initialize() {
		       	var myLatlng = new google.maps.LatLng(0, 0);
						
				var mapOptions = {
					zoom: 1,
					center: myLatlng
				};
						
				var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
				
				var lat = <?php echo json_encode($lat); ?>;	//converts php array to our javascript array
				var lon = <?php echo json_encode($lon); ?>;
				var url = <?php echo json_encode($url); ?>;
				console.log(url);

				// To add the marker to the map, use the 'map' property
					for(var x = 0; x < lat.length; x++){
						var location=new google.maps.LatLng(lat[x][0], lon[x][0]);
						marker = new google.maps.Marker({
							position: location,
							map: map,
							title: url[x]
						});
					}
				
		   	}
		google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	</head>
	<body>
		<div id = "header">
			<ul>
				<li><a href="logout.php">Logout</a></li>
				<li><a href="history.php">History</a></li>
				<li><a href="favorites.php">Favorites</a></li>
				<li><a href="surprise.php">Surprise Me</a></li>
			</ul>
		</div>
				<h1>Shortly</h1>
				<h2>URL Stats</h2>
				<div id="map-canvas"></div>	
				<a href = "home.php" style = "margin-left:2%;">home</a>	
			<div id="footer">
				<ul>
				  <li><a href="urlstats.php">URL Stats</a></li>
				  <li><a href="stats.php">Our Users</a></li>
				  <li><a href="top.php">Top 10</a></li>
				  <li><a href="about.php">About</a></li>
				</ul>
			</div>
	</body>
</html>