<?php
	include_once("../include/check_login.php");
	if($user_ok == false){ header("location: ../restricted.php?refPage=lobby"); exit();	}
	require_once '../config.php';
	require_once '../stats.php';
	
	$timestamp = time();
	$userID = getUserID(preg_replace('#[^a-z0-9]#i', '',$_SESSION['username']));
	error_log($timestamp);
	$sql = "UPDATE users SET last_act = now() WHERE id = $userID";
	$result = mysql_query($sql) or error_log(mysql_error());
	//echo sizeOf(getOnlineUsers());
?>