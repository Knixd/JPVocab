<?php
	header('Content-Type: text/html; charset=utf-8');	
	include_once("include/check_login.php");
	if($user_ok == false){header('location: restricted.php?refPage=train');}
	
	require_once 'config.php';
	$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
	mysql_select_db($dbname);
	require_once 'stats.php';
	$userID = getUserID(preg_replace('#[^a-z0-9]#i', '',$_SESSION['username']));
	
	$player = array(
				name		=>	preg_replace('#[^a-z0-9]#i', '',$_SESSION['username']),
				attack 		=>	getStat('atk',$userID), //goes to getStat fn in stats.php
				defence		=>	getStat('def',$userID),
				magic		=>	getStat('mag',$userID),
				curhp		=>	getStat('curhp',$userID),
				maxhp		=>	getStat('maxhp',$userID),
				level		=>	getStat('lv',$userID),
				xp			=>	getStat('conf',$userID),
				maxxp		=>	getStat('maxconf',$userID),
				gold		=>	getStat('gc',$userID)
			);
	if($_POST) {
		if($_POST['action'] == 'offense'){
			$cost = 500;
			if($player['gold']-$cost <0){
				$monk = "We cannot train you for free. Come back when you're able to pay.";
			}else{
				$monk = "...";
				//decrease gold
				//set status to training
				//increase stat
				setStat('gc',$userID,$player['gold']-$healCost);
				$healAmt = $player['maxhp'] - $player['curhp'];
				$healTime = $healAmt;
				$result = "You offer the monk <b>$cost gold</b>. He accepts ... you think.
				<p>Without saying anything he turns and slowly makes his way across the courtyard and points inside the temple. You assume he's letting you go inside. You bow reverently and walk up the familiar wooden steps.</p>
				<p> Inside, you proceed to the center. You kneel and wait, for you know your training has already begun...</p>";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="NOODP">
	<meta name="description" content="Japanese Flashcards. Many decks. Many styles. - jpvocab.com">
	<title>Temple Training Grounds</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script language="javascript" type="text/javascript">
	function printLetterByLetter(destination, message, speed){
		var i = 0;
		var interval = setInterval(function(){
			document.getElementById(destination).innerHTML += message.charAt(i);
			i++;
			if (i > message.length){
				clearInterval(interval);
			}
		}, speed);
	}
	</script>
</head>
<body>
	<div class="header-wrap">
		<?php include('include/header.php');?>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<h2>Temple Courtyard</h2>
				<p>You walk up the familiar stone steps and enter the temple courtyard. Incense burns your nose. Bordering the courtyard are small monuments and structures with a large temple looming across the rocky space.</p><p>An elderly monk approaches.</p>
				<p><b>Monk</b>: <i>What do you seek?</i></p>
				<p>
					<form action='temple.php' method='post'>
						<div class="input-group">
							<div class="input-group-btn">
								<button type='submit' class="btn btn-default btn-block " name='action' value='offense'>
									<span class="pull-left">
										I seek to train in the way of <b>strength</b>
									</span>
									<span class="pull-right">
										500<span class="label label-warning">Gold</span>, 2days
									</span>
								</button>
								<button type='submit' class="btn btn-default btn-block " name='action' value='defense'>
									<span class="pull-left">
										I seek to train in the way of <b>defense</b>
									</span>
									<span class="pull-right">
										500<span class="label label-warning">Gold</span>
									</span>
								</button>
								<button class="btn btn-link"><a href="#" alt="Leave inn">Nothing. I accidently got lost. I'll be leaving now.</a></button>
							</div>
						</div>
					</form>
				</p>
				
			</div>
		</div>
	</div>
</body>
</html>
