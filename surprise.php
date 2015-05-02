<?php
	session_start();
	//include custom made classes
	include_once('class/dbconnection.php');
	// Setup connection to DB
	$connection = new dbConnect();
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<link rel="stylesheet" href = "style.css">
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
		<div class = "page">
			<div id="surprise">
				<h1>Shortly</h1>
				<h2>Surprise Me</h2>
				<div id ="content" style = "text-align:center">
					<p>Enjoy your randomly selected shortened url from our database:</p>
					<?php
						$mysql = "SELECT * FROM links"; //select all rows from our url table
						$result = mysql_query($mysql); 
						$temp = mysql_num_rows($result); //get number of rows currently in table
						$temp = rand(0, $temp);	//generate random number between 0 and max numbre of rows
						$temp = base_convert($temp, 10, 36); //convert the random number to base 36 which is our shortcode algorithm

						echo "<a href=\"http://gcdsrv.com/~praisets/GroupProject/{$temp}\">http://gcdsrv.com/~praisets/GroupProject/{$temp}</a>";
					?>
				<br>
				<a href = "home.php">home</a>
				</div>
			</div>
			<div id="footer">
				<ul>
				  <li><a href="urlstats.php">URL Stats</a></li>
				  <li><a href="stats.php">Our Users</a></li>
				  <li><a href="top.php">Top 10</a></li>
				  <li><a href="about.php">About</a></li>
				</ul>
			</div>
		</div> 
	</body>
</html>