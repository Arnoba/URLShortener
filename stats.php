<?php
	//Home Page
	session_start();
	//include custom made classes
	include_once('class/dbconnection.php');
	// Setup connection to DB
	$connection = new dbConnect();

	if(!$connection){
		echo 'Error connecting to the database!';
		echo "<a href=\"index.php\">back</a>";
		die();
	}
	
	//get user ip address from database
	$query= "SELECT DISTINCT ip FROM Users WHERE ip IS NOT NULL";
	$result = mysql_query($query);
	$userip=array();
	while($row = mysql_fetch_assoc($result)){
		$userip[]=$row['ip'];
	}
	
	//send IP address to an API call to some resolution service
	for($i=0;$i<sizeof($userip);$i++){
		//send a request to Allans api find information about the ip address
		//$xml = simplexml_load_file("http://gcdsrv.com/~lookup/?ipadr=" . $IPADDRESS); multiple errors using the service provided to us by college
		
		$xml = simplexml_load_file("http://ip-json.rhcloud.com/xml/".$userip[$i]);
		
		//retrieve latitude and longitude and store in an array
		$lat[$i] = $xml->latitude;
		$lng[$i]=  $xml->longitude;	
	}
	
	//api key "AIzaSyAAAaWAKaCDwfzdpB7lBg-Jd-83RByDB8A";
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
		#map-canvas { height: 50%; width :50%;}
		</style>
	
		<script type="text/javascript"
		  src="https://maps.googleapis.com/maps/api/js">
		</script>
	
		<script type="text/javascript">
			function initialize(){
				//get locations array from server
				var lat = <?php echo json_encode($lat) ?>;//converts php array to our javascript array
				var lng = <?php echo json_encode($lng) ?>;
				var mapOptions = {
					zoom: 1,
					center: new google.maps.LatLng(0, 0)
				}
				var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
				
				//add a marker
				var marker,i;
				for(i=0;i<lat.length;i++){
				var location=new google.maps.LatLng(lat[i][0],lng[i][0]);
					marker = new google.maps.Marker({
						position: location,
						map: map,
						title: 'This is a user!'
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
				<h2>Our Users</h2>
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