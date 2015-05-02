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
			<div id="top">
				<h1>Shortly</h1>
				<h2>Top 10</h2>
				<div id = "content">
					<table style = "margin: auto">
						<tr>
		 					<td style = "text-align: center">Url</td>
		 					<td>Short</td>
		 					<td>Visited</td>
		 				</tr>
						<?php
							$mysql = "SELECT * FROM links ORDER BY counter DESC LIMIT 10";
							$result = mysql_query($mysql);
							
							while($row = mysql_fetch_array($result)){
								echo "<tr>";
								echo "<td><a href = \"{$row['url']}\">{$row['url']}</td>";
								echo "<td style = \"text-align: center\">{$row['code']}</td>";
								echo "<td style = \"text-align: center\">{$row['counter']}</td>";	
								echo "</tr>";
							}
						?>
					</table>
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