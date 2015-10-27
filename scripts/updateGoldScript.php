<?php
	session_start();
	include '../stats.php';
	echo getStat('gc', getUserID(preg_replace('#[^a-z0-9]#i', '',$_SESSION['username'])));
?>