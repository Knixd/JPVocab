<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT']."/config.php");
	$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
	mysql_select_db($dbname);
	mysql_query("SET NAMES UTF8");
	$user_ok = false;
	$log_id = "";
	$log_username = "";
	$log_password = "";
	// User Verify function
	function evalLoggedUser($id,$u,$p){
		$sql = "SELECT password FROM users WHERE id='$id' AND username='$u' AND activated='1' LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_row($query);
		$db_pass_pregd = preg_replace('#[^a-z0-9]#i', '', $row[0]);
		
		$sql = "SELECT ip FROM users WHERE id='$id' AND username='$u' AND activated='1' LIMIT 1";
		$query = mysql_query($sql) or die(mysql_error());
		$numrows = mysql_num_rows($query);		
		if($numrows > 0 && $p == $db_pass_pregd){
			//If wanted to log out because of a session left open without action, could destroy here. See older files for ie
			$_SESSION['LAST_ACT'] = time();
			//Avoid attacks like Session Fixation
			if (!isset($_SESSION['CREATION'])) {
				$_SESSION['CREATION'] = time();
			} else if (time() - $_SESSION['CREATION'] > 1800) {
				// session started more than 30 minutes ago
				session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
				$_SESSION['CREATION'] = time();  // update creation time
			}
			//** Don't need to update last_act here anymore. See js/update-status.js **/
			//$sql = "UPDATE users SET last_act=now() WHERE id='$id' LIMIT 1";
			//$query = mysql_query($sql);
			return true;
		}
	}
	if(isset($_SESSION["userid"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])) {
		$log_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
		$log_username = preg_replace('#[^a-z0-9]#i', '', $_SESSION['username']);
		$log_password = preg_replace('#[^a-z0-9]#i', '', $_SESSION['password']);
		// Verify the user
		$user_ok = evalLoggedUser($log_id,$log_username,$log_password);
	}else if(isset($_COOKIE["id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])){
		//If session expired, but session isn't	reset session
		$_SESSION['userid'] = preg_replace('#[^0-9]#', '', $_COOKIE['id']);
		$_SESSION['username'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['user']);
		$_SESSION['password'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['pass']);
		$log_id = $_SESSION['userid'];
		$log_username = $_SESSION['username'];
		$log_password = $_SESSION['password'];
		// Verify the user
		$user_ok = evalLoggedUser($log_id,$log_username,$log_password);
		if($user_ok == true){
			// Update their lastlogin datetime field
			$sql = "UPDATE users SET last_login=now() WHERE id='$log_id' LIMIT 1";
			$query = mysql_query($sql);
		}
	}
?>