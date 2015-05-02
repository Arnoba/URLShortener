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
?>	

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<link rel="stylesheet" href = "style.css">
	</head>
	<body>
		<div class = "page">
			<div id = "header">
				<ul>
				  <li><a href="logout.php">Logout</a></li>
				  <li><a href="history.php">History</a></li>
				  <li><a href="favorites.php">Favorites</a></li>
				  <li><a href="surprise.php">Surprise Me</a></li>
				</ul>
			</div>
			<div id="history">
				<h1>Shortly</h1>
				<h2>History</h2>
				<div id ="content">
					<form action="favorites.php" method="post">
						<table>
							<tr>
		 		 				<td>Favorite</td>
		 		 				<td style = "text-align: center">Url</td>
		 		 				<td>Created</td>
		 		 			</tr>
							<?php
								$mysql = "SELECT url, created FROM history where userId = {$_SESSION['userID']}";
								$result = mysql_query($mysql);

								while($row = mysql_fetch_array($result)){
									echo "<tr>";
                        	     	echo "<td><input type=\"checkbox\" name=\"checked_boxes[]\" value = {$row['url']} style=\"float: left; margin-top: 5px;\"></td>";
                            		echo "<td>{$row['url']}</td>";
                            		echo "<td>{$row['created']}</td>";
                           			echo "<tr>";
								}
							?>
						</table>
						<input type = "submit" name = "favorite" value = "Add to Favorites" style="border:1px solid #000">
						<input type = "submit" name = "delete" value = "Delete from History and Favorites" style="border:1px solid #000">
						<input type = "submit" name = "deletefav" value = "Delete from Favorites" style="border:1px solid #000">
					</form>
				<a href = "home.php">home</a>
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