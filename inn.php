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
		if($_POST['action'] == 'Rest'){
			$healCost = 100;
			if($player['gold']-$healCost <0){
				$innkeeper = "Sorry friend, you'll need more gold to sleep here.";
			}else{
				$innkeeper = "Thank you. Please enjoy your stay.";
				setStat('curhp',$userID,$player['maxhp']);
				setStat('gc',$userID,$player['gold']-$healCost);
				$healAmt = $player['maxhp'] - $player['curhp'];
				$healTime = $healAmt;
				$result = "You pay the innkeeper <b>$healCost gold</b> and rest at the inn. 
				<p>You sleep for <b>$healTime hours</b>!</p> 
				<p>When you wake up you feel totally refreshed.</p>
				<button class='btn btn-link'><a href='#' alt='Leave inn'>Leave</a></button>";
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
	<title>Inn</title>
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
	<?php include('include/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-4">
				<h1>Inn</h1><?
				if($_POST['action'] != 'Rest'){?>
				<p>You enter the inn. As always, it's bustling with activity.</p>
				<p>What would you like to do?<br/>
					<form action='inn.php' method='post'>
						<div class="input-group">
							<div class="input-group-btn">
								<button type='submit' class="btn btn-default btn-block " name='action' value='Rest'><span class="pull-left">Rest</span> <span class="pull-right">100<span class="label label-warning">Gold</span></span></button>
								<button class="btn btn-link"><a href="#" alt="Leave inn">Leave</a></button>
							</div>
						</div>
					</form>
				</p><?
				}else if($_POST['action'] == 'Rest'){?>
				<p><b>Innkeeper</b>: <div id='innkeeper'></div></i></p>
				<p><?= $result;?></p>
				<?
				}?>
			</div>
		</div>
	</div>
<script type="text/javascript">
	printLetterByLetter('innkeeper', <?= json_encode($innkeeper); ?>, 50);
</script>
<label id="minutes">00</label>:<label id="seconds">00</label>
    <script type="text/javascript">
        var minutesLabel = document.getElementById("minutes");
        var secondsLabel = document.getElementById("seconds");
        var totalSeconds = 0;
        setInterval(setTime, 1000);

        function setTime()
        {
            ++totalSeconds;
            secondsLabel.innerHTML = pad(totalSeconds%60);
            minutesLabel.innerHTML = pad(parseInt(totalSeconds/60));
        }

        function pad(val)
        {
            var valString = val + "";
            if(valString.length < 2)
            {
                return "0" + valString;
            }
            else
            {
                return valString;
            }
        }
    </script>
</body>
</html>
