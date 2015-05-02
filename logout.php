<?php   
session_start(); //contine previous session wich will be destroyed
session_destroy(); //destroy the session whihc effectivly log out the user
header('location: http://gcdsrv.com/~praisets/GroupProject/index.php'); //redirect back to index
?>