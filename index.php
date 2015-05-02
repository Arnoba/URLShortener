<?php
	session_start();
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<link rel="stylesheet" href = "style.css">
	</head>
	<body>
		<div id = "page">
			<div id="header">
			
			</div>
			<div id = "registration">
				<form action="home.php" method="post" autocomplete="off">
					<h3 id = "title">Registration</h3>
					<br/>
					<p>Username:</p><input class="textbox" type= "text" name = "username" required>
					<br/>
					<p>Password:</p><input class="textbox" type ="password" name = "password" required>
					<br/>
					<p>Re-enter Password: </p><input class="textbox" type = "password" name = "passwordcheck" required>
					<br/>
					<p>Email:</p><input class="textbox" type = "email" name = "email" required>
					<br/>
					<div id="button">
						<input type = "submit" name = "register" value = "Register" style="border:1px solid #000">	
					</div>
				</form>	
			</div>
			<div id = "login">
				<form action="home.php" method="post" autocomplete="off">
					<h3 id = "title">Welcome back!</h3>
					<br/>
					<p>Username:</p><input class="textbox" type= "text" name = "username">
					<br/>
					<p>Password: </p><input class="textbox" type = "password" name= "password">
					<br/>
					<div id="button">
						<input type = "submit" name = "login" value = "Log in" style="border:1px solid #000">
					</div>
				</form>	
			</div>
			<div id="footer">
		
			</div>
		</div>
		<div id = "alert">
			<?php
				if(isset($_SESSION['userID'])){
					echo "<script> alert(\"{$_SESSION['userID']}\")</script>";
					unset($_SESSION['userID']);
				}
			?>
		</div>
	</body>
</html>