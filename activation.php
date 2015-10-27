<?php
	
	if(isset($_GET['id']) && isset($_GET['u']) && isset($_GET['e']) && isset($_GET['p'])){
		//Connect to db and sanitize incoming $_GET variables
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$id = preg_replace('#[^a-z0-9]#i', '', $_GET['id']);
		$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
		$e = mysql_real_escape_string($_GET['e']);
		$p = mysql_real_escape_string($_GET['p']);

		//Evaluate lengths of the incoming $_GET variables
		if($id == "" || strlen($u) <3 || strlen($e) <5 || $p == ""){
			header("location: message.php?msg=activation_string_length_issues");//message.php not created yet
			exit();
		}
		//Check their credentials against the db
		$sql = "SELECT * FROM users WHERE id='$id' AND username ='$u' AND email='$e' LIMIT 1";
		$query = mysql_query($sql) or die(mysql_error());
		$numrows = mysql_num_rows($query);
		//Evaluate for a match in the system (0 = no match)
		if($numrows == 0){
			header("location: message.php?msg=activation_failure");//message.php not created yet			
			exit();
		}
		//Match was found, you can activate them
		$sql = "UPDATE users SET activated='1' WHERE id='$id' LIMIT 1";
		$query = mysql_query($sql);
		$sql2 = "INSERT INTO user_pvp_rank(user_id,pvp_rank) VALUES('$id', (SELECT MAX(pvp_rank) FROM user_pvp_rank a) + 1)";
		$query2 = mysql_query($sql2);
		// Optional double check to see if activated in fact now = 1
		$sql = "SELECT * FROM users WHERE id='$id' AND activated='1' LIMIT 1";
		$query = mysql_query($sql);
		$numrows = mysql_num_rows($query);
		// Evaluate the double check
		if($numrows == 0){
			// Log this issue of no switch of activation field to 1
			header("location: message.php?msg=activation_failure");
			exit();
		} else if($numrows == 1) {
			// Great everything went fine with activation!
			header("location: message.php?msg=activation_success2");
			exit();
		}
		
		
	}else{
		header("location: message.php?msg=missing_GET_variables");//message.php not created ye
	}
?>