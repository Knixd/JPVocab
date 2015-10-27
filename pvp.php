<?php
	header('Content-Type: text/html; charset=utf-8');	
	include_once("include/check_login.php");
	//if($user_ok == false){header("location: logout.php");}
	/******************************************************************************************************************/
	include("stats.php");
	$u = getUsers();
	//display next three challengers
	//--Get user rank, plus next three
	$uid = getUserID($_SESSION['username']);
	$pvpRank = getPvpRank($uid);
	//get three next pvp ranks
	if($pvpRank>3){
		for($i=0;$i<3;$i++){
			$pvpDis[]=$pvpRank-($i+1);
		}
	}
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="NOODP">
	<meta name="description" content="Japanese Flashcards. Many decks. Many styles. - jpvocab.com">
	<title>PVP - jpvocab.com</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
</head>
<body>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8 table-responsive">
			<h1>PVP</h1>
			<?php
			$i =2;
			foreach($pvpDis as $rank){?>
				<div class="row">
					<div class="col-xs-12">
						<?= getPvpRank(getPvpUI($pvpDis[$i])); ?>
						<span id="user<?= $i;?>"><?= getUserDetail(getPvpUI($pvpDis[$i]),'username'); ?>, </span>
						Lvl <?= getStat('lv',getPvpUI($pvpDis[$i])); ?>
						<a href="#3" id="battle<?= $i;?>" name="">Battle</a>
					</div>
				</div><?
				$i--;
			} ?>
			
			
		</div>
		<div class="col-md-2"></div>
	</div>
	<script>
		var battle2 = document.getElementById("battle2");
		var battle1 = document.getElementById("battle1");
		var battle0 = document.getElementById("battle0");
		var user2 = document.getElementById("user2").innerHTML;
		var user1 = document.getElementById("user1").innerHTML;
		var user0 = document.getElementById("user0").innerHTML;
		
		battle2.addEventListener("click",function(){combat(user2)}, false);
		battle1.addEventListener("click",function(){combat(user1)}, false);
		battle0.addEventListener("click",function(){combat(user0)}, false);
		function combat(opponent){
			alert(opponent);
		}
	</script>
</body>
</html>
	