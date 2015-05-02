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
			<div id="favorites">
				<h1>Shortly</h1>
				<h2>Favorites</h2>
				<div id ="content">
					<?php
						if(isset($_POST['favorite'])){//check to see if we have to add any favorites
							foreach ($_POST['checked_boxes'] as $row) {
								$mysql = "UPDATE history SET favorite = 1 WHERE url = '{$row}'";
								$result = mysql_query($mysql);
							}
							unset($_POST['favorite']);
						}

						if (isset($_POST['delete'])) {
							foreach ($_POST['checked_boxes'] as $row){
								$mysql = "DELETE FROM history WHERE url = '{$row}'";
								$result = mysql_query($mysql);
							}
							unset($_POST['delete']);
						}

						if (isset($_POST['deletefav'])) {
							foreach ($_POST['checked_boxes'] as $row){
								$mysql = "UPDATE history SET favorite = 0 WHERE url = '{$row}'";
								$result = mysql_query($mysql);
							}
							unset($_POST['deletefav']);
						}

						$mysql = "SELECT url FROM history where userId = {$_SESSION['userID']} AND favorite = 1";
						$result = mysql_query($mysql);
						while($row = mysql_fetch_array($result)){
							echo "<a href = \"{$row['url']}\"><p>{$row['url']}</p></a>";
						}
							
					?>
				</form>
			</form>
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