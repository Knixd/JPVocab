<?php
	session_start();	
	require_once 'config.php';
	$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
	mysql_select_db($dbname);
	require_once 'stats.php';
	$userID = getUserID($_SESSION['username']);
	if($_POST) {
		if($_POST['action'] == 'Attack'){
			$stealPrc = 0.15;
			require_once 'stats.php'; //player stats
			require_once 'monster-stats.php'; //monster stats
			//to begin, we'll retrieve player and monster stats
			$player = array(
				name		=>	$_SESSION['username'],
				attack 		=>	getStat('atk',$userID), //goes to getStat fn in stats.php
				defence		=>	getStat('def',$userID),
				curhp		=>	getStat('curhp',$userID)
			);
			$query = sprintf("SELECT id FROM users WHERE username ='%s' AND is_guest != 1",
				mysql_real_escape_string($_POST['monster']));
			$result = mysql_query($query);
			list($opponentID) = mysql_fetch_row($result);
			$opponent = array (
				name		=>	$_POST['monster'],
				attack		=>	getStat('atk',$opponentID),
				defence		=>	getStat('def',$opponentID),
				curhp		=>	getStat('maxhp',$opponentID)
			);
			$combat = array();
			$turns = 0;		
			while($player['curhp'] > 0 && $opponent['curhp'] > 0) {
				if($turns % 2 != 0) {
					$attacker = &$opponent;
					$defender = &$player;	
				} else {
					$attacker = &$player;
					$defender = &$opponent;
				}
				$damage = 0;
				if($attacker['attack'] > $defender['defence']) {
					$damage = $attacker['attack'] - $defender['defence'];	
				}
				$defender['curhp'] -= $damage;
				$combat[$turns] = array(
					attacker	=>	$attacker['name'],
					defender	=>	$defender['name'],
					damage		=>	$damage
				);
				$turns++;
			}
			setStat('curhp',$userID,$player['curhp']);
			if($player['curhp'] > 0) {
				// player won
				$gold=round($stealPrc*getStat('gc',$opponentID));
				setStat('gc',$userID,getStat('gc',$userID)+$gold);	//give reward for winning
				setStat('gc',$opponentID,getStat('gc',$opponentID)-$gold);	//give reward for winning
				$won=1;
			} else { //player lost
				$lost=1;
				$lostGold = getStat('gc',$userID)-round(($stealPrc*getStat('gc',$opponentID)));
				$lostGoldOpp = getStat('gc',$opponentID)-round(($stealPrc*getStat('gc',$opponentID)));
				if($player['curhp'] < 0){ setStat('curhp',$userID,0);}
				//Set players gold
				if($lostGold < 0 ){
					$gold = getStat('gc',$userID);
					setStat('gc',$userID,0);
				}else{
					$gold=round($stealPrc*getStat('gc',$opponentID));
					setStat('gc',$userID,$lostGold);
				}
				//Set enemy's gold
				if($lostGoldOpp < 0 ){//this shouldn't really ever happen except for rounding issues
					$gold = getStat('gc',$opponentID);
					setStat('gc',$userID,0);
				}else{
					$gold=round($stealPrc*getStat('gc',$opponentID));
					setStat('gc',$opponentID,$lostGoldOpp);
				}
			}
			//$smarty->assign('combat',$combat);
			$currentHP=getStat('curhp',$userID);
			$maximumHP=getStat('maxhp',$userID);
		} else if($_POST['action'] == 'Heal for 5GC and run home!'){
			$healCost = 5;
			if(getStat('gc',$userID)-$healCost <0){
				$result = "Insufficient Funds to Heal. Go train some more for GC";
			}else{
				setStat('curhp',$userID,getStat('maxhp',$userID));
				setStat('gc',$userID,getStat('gc',$userID)-$healCost);
				$result = "You've healed yourself for $healCost GC!</br>";
			}
		}else {
			// running away! send them back to the main page
			$lostGold = getStat('gc',$userID)-10;
			if($lostGold < 0 ){
				setStat('gc',$userID,0);
			}else{
				setStat('gc',$userID,$lostGold);
			}
			header('Location: index.php');
		}
			
	}
	/*$query = sprintf("SELECT name FROM monsters ORDER BY RAND() LIMIT 1");
	$result = mysql_query($query);
	list($tmonster) = mysql_fetch_row($result);*/
	$query = sprintf("SELECT username FROM users WHERE id != '%s' AND is_guest != 1 ORDER BY RAND() LIMIT 1",
		mysql_real_escape_string($userID));
	$result = mysql_query($query);
	list($tmonster) = mysql_fetch_row($result);
	$ranCase = array(
		"You were walking home late at night and noticed that someone was following you. You walked a little farther but couldn't take it anymore. You suddenly turned around and saw that it was the notorious <a href='player.php?player=$tmonster'>$tmonster</a> from the baby diaper commercials. <i>But they didn't know you had been studying Japanese.",
		"The next day you stop to tie your shoelace when suddenly you feel somebody watching you. Cold shivers run up and down your spine. You're paralyzed with fear because you know in this humidity, at this beach, in this type of sunshine, with all all these people that it could only mean one thing, <a href='player.php?player=$tmonster'>$tmonster</a>. <i>But they didn't know you had been studying Japanese.",
		"A group of common thugs surround you. They hold baseball bats and busted up pieces of pipe. Scars and a stench not unlike Axe body spray eminates from every pore. Sickening. Their leader identifies themselves as <a href='player.php?player=$tmonster'>$tmonster</a> and they want your gold. <i>But they didn't know you had been studying Japanese.",
		"<p>You're trapped. Held hostage against your own will on the SS Dorivdad Space Cruiser currently leaving Sector 8. All you know is that you were taking the space elavator from the small Janton planet below, listening to the news about the notorious space pirate Captain <a href='player.php?player=$tmonster'>$tmonster</a> wreaking havic to Justic Space Corp patrols like yours when there was a pop as the elevator lights suddenly exploded. From there you felt the back of your head slam against the glass wall behind you as a fist crashed into your face.</p><p>  You're groggy. They must've drugged you. From the looks of your cell you're not alone. Two other regular looking civilians were chained beside you. Suddenly you hear heavy footsteps coming to your cell. <i>But they didn't know you had been studying Japanese.",
		"<p>You didn't mean to knock over the orange-laden fruit stand. You were just minding your own business, dropping in on the grocery store to grab some almonds because your bakery was running short on them this morning. But now there's an angry fruit-stand designer in front of you. Today happened to be the national Fruit-Stand Design Seminar with famous guest designers from Russia, Japan, England, France, and more. The internationally renowned and two-time receiver of the French Fruit-stand Design Accolade <a href='player.php?player=$tmonster'>$tmonster</a> saw you knock over the oranges display.</p> <p>Due to the recent negative media from a controversal fruit-stand design in New York, <a href='player.php?player=$tmonster'>$tmonster</a> took it personally and claims you were deliberate. Seminar guests who you previously thought were regular grocery shoppers have started gathering around, drawn to the area by the noise <a href='player.php?player=$tmonster'>$tmonster</a> was making. <i>But they didn't know you had been studying Japanese.</p>",
		"Something is wrong. You look around the tavern but don't see anyone suspiciou.... well actually everyone is suspicious here but you don't see anything out of the ordinary. Wait! You have no recollection of how long you've been here or how much food and drink you've bought! You check your wallet and it's empty. You look up to see the bartender smirk. The bartender's nametage reads <i>'<a href='player.php?player=$tmonster'>$tmonster</a>'</i>...wait! That's none other than a famous dark jedi that hasn't been seen or heard of for years! You don't know why this jedi is here; you have to report it to headquarters fast! You were jedi-mind tricked into buying more than you needed. <i>But they didn't know you had been studying Japanese.",
	);
	$ranKey = mt_rand(0,count($ranCase)-1);
	//$smarty->assign('monster',$monster);
	
	//$smarty->display('forest.tpl');
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="NOODP">
	<meta name="description" content="Japanese Flashcards. Many decks. Many styles. - jpvocab.com">
	<title>Battle - jpvocab.com</title>
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
	<title>The Forest</title>
</head>
<body>
	<div class="header-wrap">
		<?php include('include/header.php');?>
	</div>
	<div id="combat">
		<table>
			<tr><td><?php echo $_SESSION['username'];?></td><td></td></tr>
			<tr><td>Current Health: </td><td><?php echo getStat('curhp',$userID).'/'.getStat('maxhp',$userID);?></td></tr>
			<tr><td>Attack: </td><td><?php echo getStat('atk',$userID);?></td></tr>
			<tr><td>Defense: </td><td><?php echo getStat('def',$userID);?></td></tr>
			<tr><td></td><td></td></tr>
		</table>
		<div class="fightCase"><?php 
			if($combat == ''){?>		
				<p><?php echo $ranCase[$ranKey];?></p>
				<form action='forest.php' method='post'>
					<input type='submit' name='action' value='Attack' /> 
					<input type='submit' name='action' value='Heal for 5GC and run home!' /> 
					<!--<input type='submit' name='action' value='Throw 10GC at them and Run Away' /> -->
					<input type='hidden' name='monster' value='<?php echo $tmonster;?>' />
				</form><?php
			}else{?>
				Replay:
					<ul><?php
					//print_r($combat);
					foreach($combat as $key=>$value){?>
							<li><strong><?php echo $value['attacker'];?></strong> attacks <?php echo $value['defender'];?> for <?php echo $value['damage'];?> damage!</li><?php
					}?>
					</ul><?php
					if($won == 1){?>
						<p>Current HP: <strong><?php echo $currentHP;?>/<?php echo $maximumHP;?></strong></p>
						<p>You defeated <strong><?php echo $opponent['name'];?></strong>! You gained <strong><?php echo $gold;?></strong> gold.</p><?php
					}
					if($lost ==1){?>
						<p>You were struck down by <strong><?php echo $opponent['name'];//echo $monster['name'];?></strong>. You lost <strong><?php echo $gold;?></strong> gold.</p><?php
					}?>
					<p><a href='forest.php'>Explore Again</a></p>
					<p><a href='index.php'>Back to main</a></p><?php
			}?>
		</div>
		
	</div>
</body>
</html>
