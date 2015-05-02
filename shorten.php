<?php
	session_start();
	include_once('class/shortener.php');
	include_once('class/dbconnection.php');

	$s = new Shortener;

	if(isset($_POST['shorten'])){
		$url = $_POST['inputurl'];

		if($code = $s ->genUrlCode($url, $_SESSION['userID'])){
			$_SESSION['feedback'] = "Generated! Your short URL is: <a href=\"http://gcdsrv.com/~praisets/GroupProject/{$code}\">http://gcdsrv.com/~praisets/GroupProject/{$code}</a>";
		}
		else{
			$_SESSION['feedback'] = "There was a problem. Invalid url perhaps";
		}
	}
	else if(isset($_POST['search'])){
		$url = $_POST['inputurl'];

		if($code = $s ->searchdata($url)){
			$_SESSION['feedback'] = "Link was found in database: <a href=\"http://gcdsrv.com/~praisets/GroupProject/{$code}\">http://gcdsrv.com/~praisets/GroupProject/{$code}</a>";
		}
		else{
			$_SESSION['feedback'] = "Link could not be found in database";
		}
	}
	else if(isset($_POST['extend'])){
		$input = $_POST['inputurl'];
		$input = explode("/", $input);
		$code = $input[5];

		if($url = $s->getUrl($code)){
			$_SESSION['feedback'] = "Original Link <a href=\"$url\">$url</a>";
		}
		else{
			$_SESSION['feedback'] = "Link could not be found in database" . $code;
		}
	}


	header('Location: http://gcdsrv.com/~praisets/GroupProject/home.php');
?>