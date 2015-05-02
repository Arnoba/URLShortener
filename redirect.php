<?php
include_once 'class/shortener.php';

if(isset($_GET['code'])){
	$s = new shortener();
	$code = $_GET['code'];

	if($url = $s->getUrl($code)){
		header("Location: {$url}");
		die();
	}
}

header("Location: home.php");
?>