<?php
	header('Content-Type: text/html; charset=utf-8');	
	include_once("include/check_login.php");
	//if($user_ok == false){header('location: restricted.php?refPage=buy');}
	//include_once("../stats.php");
	//include_once("../words.php");
	$u = $_GET['u'];
	$sql = sprintf("UPDATE users SET gen_email = 0 WHERE username = '%s'",
		mysql_real_escape_string($u));
	$results = mysql_query($sql) or die(mysql_error());
	echo "Thanks $u, you were successfully unsubscribed. <a href='http://www.jpvocab.com'>Login</a> to do 10 flashcards.";
?>