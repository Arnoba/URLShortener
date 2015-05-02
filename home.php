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
	
	if(isset($_POST['register'])){ //instruction for registering new user
		if($_POST['password'] != $_POST['passwordcheck']){//passwords dont  match
			$_SESSION['userID'] = 'Error creating account passwords dont match.';
			header('Location: http://gcdsrv.com/~praisets/GroupProject/index.php' );
			die();
		}

		$mysql = "INSERT INTO Users (username, password, email, IP) VALUES ('" . $_POST['username'] . "', '" . $_POST['password'] . "', '" . $_POST['email'] . "', '" . $_SERVER['REMOTE_ADDR'] . "')";

		$result = mysql_query($mysql);

		if($result!= true){ //error creating account
			$_SESSION['userID'] = 'Error creating account please try again';
			header('Location: http://gcdsrv.com/~praisets/GroupProject/index.php' );
			die();
		}

		else{//all good account created
			$_SESSION['userID'] = 'Registration successfull';
			header('Location: http://gcdsrv.com/~praisets/GroupProject/index.php' );
			die();
		}
	}
	
	else if(isset($_POST['login'])){ //login instructions
		$mysql = "SELECT username, password FROM Users WHERE (username = '{$_POST['username']}'   AND password = '{$_POST['password']}')";

		$result = mysql_query($mysql);
		$value = mysql_fetch_object($result);

		if ($_POST['username'] ==  $value->username && $_POST['password'] == $value->password){ //validate user and save user id

				$mysql = "SELECT id FROM Users where username = '{$_POST['username']}'";
				$result = mysql_query($mysql);
				$value = mysql_fetch_object($result);
				$_SESSION['userID'] =$value->id;
		}
		else{ //invalid user redirect back to login and set userID to invalid
			$_SESSION['userID'] = 'Invalid login';
			header('Location: http://gcdsrv.com/~praisets/GroupProject/index.php' );
			die();
		}
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
			<div id="shorten">
				<form action="shorten.php" method="post" autocomplete = 'off'>
					<h1>Shortly</h1>
					<br/>
					<input class="input" type= "url" name = "inputurl">
					<br/>
					<br/>
						<div id="button">
							<input type = "submit" name = "shorten" value = "Shorten" style="border:1px solid #000">
							<input type = "submit" name = "extend" value = "Extend" style="border:1px solid #000">
							<input type = "submit" name = "search" value = "Search" style="border:1px solid #000">
						</div>
					<br/>
					<br/>
					<?php
						if(isset($_SESSION['feedback'])){ //output of user request
							echo "<p>{$_SESSION['feedback']}<p>";
							unset($_SESSION['feedback']); //unset to allow refreshing without holding value
						}
					?>
				</form>
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