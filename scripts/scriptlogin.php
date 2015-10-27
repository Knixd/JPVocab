<?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
	if(isset($_POST["e"])){
		//DELETE ANY EXISTING SESSIONS OR COOKIES BEFORE STARTING ANOTHER LOG IN
		session_start();
		$_SESSION = array();
		if(isset($_COOKIE["id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
			setcookie("id", '', strtotime( '-5 days' ), '/');
		    setcookie("user", '', strtotime( '-5 days' ), '/');
			setcookie("pass", '', strtotime( '-5 days' ), '/');
		}
		session_destroy();
		// CONNECT TO THE DATABASE
		include_once("config.php");
		include_once("include/password.php");
		// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
		$e = mysql_real_escape_string($_POST['e']);
		$p = $_POST['p'];
		$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
		// FORM DATA ERROR HANDLING
		if($e == "" || $p == ""){
			header("location: loginfail.php?message=mt");
			//echo "login_failed";
			exit();
			
		} else {
		// END FORM DATA ERROR HANDLING
			$sql = "SELECT id, username, password FROM users WHERE email='$e' OR username='$e' AND activated='1' LIMIT 1";
			$query = mysql_query($sql);
			$row = mysql_fetch_row($query);
			$db_id = $row[0];
			$db_username = $row[1];
			$db_pass_str = $row[2];
			if(password_verify($p, $db_pass_str) != true){
				//header("location: loginfail.php?message=pf");
				echo "login_failed";
				exit();
				//
			} else {
				// CREATE THEIR SESSIONS AND COOKIES
				$_SESSION['userid'] = $db_id;
				$_SESSION['username'] = $db_username;
				$_SESSION['password'] = $db_pass_str;
				$_SESSION['LAST_ACT'] = time();
				$_SESSION['prevID'] = 1;
				setcookie("id", $db_id, strtotime( '+3 days' ), "/", "", "", TRUE);
				setcookie("user", $db_username, strtotime( '+3 days' ), "/", "", "", TRUE);
				setcookie("pass", $db_pass_str, strtotime( '+3 days' ), "/", "", "", TRUE); 
				// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
				$sql = "UPDATE users SET ip='$ip', last_login=now(), last_act=now() WHERE username='$db_username' LIMIT 1";
				$query = mysql_query($sql);
				echo $db_username;
				exit();
			}
		}
		exit();
	}
?>