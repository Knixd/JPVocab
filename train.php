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
			
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="NOODP">
	<meta name="description" content="Japanese Flashcards. Many decks. Many styles. - jpvocab.com">
	<title>Train - jpvocab.com</title>
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
			<div class="col-xs-6 col-sm-1 pad-right-left-none text-right">
				<img src="img/fail.jpg" alt="Player Avatar" class="img-thumbnail">
			</div>
			<div class="col-xs-6 col-sm-2 pad-left-none">
				<table class="table table-condensed borderless thin">
					<tr>
						<td colspan="2" id="user"><?= $player['name'];?></td>
					</tr>
					<tr>
						<td><b>Lvl</b></td>
						<td><b><?= $player['level'];?></b></td>
					</tr>
					<tr>
						<td><b>HP</b></td>
						<td><b><?= $player['curhp'];?></b>/ <?= $player['maxhp'];?></td>
					</tr>
				</table>
			</div>
			<div class="col-sm-4">
				<table class="table table-condensed borderless thin">
					<tr>
						<td>EXP</td>
						<td>
							<b><?= $player['xp'];?>xp /</b>
							<?= $player['maxxp'];?>xp
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="progress progress-striped">
								<div class="progress-bar active" role="progressbar" aria-valuenow="<?= ($player['xp']/$player['maxxp'])*100;?>" aria-valuemin="0" aria-valuemax="100" style="min-width:2em; width:<?= ($player['xp']/$player['maxxp'])*100;?>%"><?= $player['xp'];?>xp
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-3 ">
				<table class="table table-condensed borderless thin">
					<tr>
						<td rowspan="2"><a href="#1" id="trainAtk"><i class="fa fa-plus-circle"></i></a></td>
						<td style="border-bottom:1px dotted #ccc;">Attack</td>
						<td style="border-bottom:1px dotted #ccc;"><b id="atkValue"><?= $player['attack'];?></b></td>
					</tr>
					<tr style="border-bottom:1px solid #000;">
						<td><sub><small><span id="atkPrice"></span> Gold</small></sub></td>
						<td colspan="2"><sub><small><i class="fa fa-clock-o"></i><!--<span id="atkTime">30</span> min</small></sub>--></td>
					</tr>
					<tr>
						<td rowspan="2"><a href="#1" id="trainDef"><i class="fa fa-plus-circle"></i></a></td>
						<td style="border-bottom:1px dotted #ccc;">Defence</td>
						<td style="border-bottom:1px dotted #ccc;"><b id="defValue"><?= $player['defence'];?></b></td>
					</tr>
					<tr style="border-bottom:1px solid #000;">
						<td><sub><small><span id="defPrice"></span> Gold</small></sub></td>
						<td colspan="2"><sub><small><i class="fa fa-clock-o"></i><!--<span id="defTime">30</span> min</small></sub>--></td>
					</tr>
					<tr>
						<td rowspan="2" style="border-bottom:1px solid #000;"><a href="#1" id="trainMag"><i class="fa fa-plus-circle"></i></a></td>
						<td style="border-bottom:1px dotted #ccc;">Magic</td>
						<td style="border-bottom:1px dotted #ccc;"><b id="magValue"><?= $player['magic'];?></b></td>
					</tr>
					<tr style="border-bottom:1px solid #000;">
						<td><sub><small><span id="magPrice"></span> Gold</small></sub></td>
						<td colspan="2"><sub><small><i class="fa fa-clock-o"></i><!--<span id="magTime">30</span> min</small></sub>--></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<div class="panel panel-primary" id="status" style="min-height:150px;">
					Want do you want to train?
				</div>
			</div>
		</div>
		
	</div>
	<script>
		
		function train(el,val){
			var price = Math.round(Math.pow(val,2.5));
			var newVal = parseFloat(val)+1;
			var gold = parseFloat(document.getElementById("headerGC").innerHTML);
			var status = document.getElementById("status");
			status.innerHTML = "<i>"+el+" "+val+" -> <b>"+newVal+"</b></i><p> "+gold+"<br /><u><span class='text-danger'>-&nbsp;&nbsp;&nbsp;"+price+"</span></u><br /><b>"+(gold-price)+"</b></p><p>Train?</p><p><a href='#23' id='bought'>Yes</a> &bull; <a href='#3' id='cancelBuy'>No</a></p>";
			//how to get yes or no
			var bought = document.getElementById("bought");
			var cancelBuy = document.getElementById("cancelBuy");
			bought.addEventListener("click", function(){
														if(gold>=price){upgradeSkill(el,val);}
														else{status.innerHTML = "You don't have enough gold.";}
														},false);
			cancelBuy.addEventListener("click", function(){status.innerHTML="Want do you want to train?";},false);
		}
		function upgradeSkill(el,val){
			var status = document.getElementById("status");
			var user = document.getElementById("user").innerHTML;
			var ajax;  // The variable that makes Ajax possible!
			try{
				// Opera 8.0+, Firefox, Safari
				ajax = new XMLHttpRequest();
			} catch (e){
				// Internet Explorer Browsers
				try{
					ajax = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					try{
						ajax = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e){
						// Something went wrong
						alert("Your browser broke!");
						return false;
					}
				}
			}
			var url = "scripts/upgradeSkill.php";
			var vars = "user="+user+"&el="+el+"&val="+val;
			ajax.open("POST", url, true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.onreadystatechange = function(){
				if(ajax.readyState == 4){						
					if(ajax.responseText == "success"){
						status.innerHTML = "Success. <p><small><i>Reloading page...</i></small></p>";
						document.location.reload(true);
					}else if( ajax.responseText == "error"){
						status.innerHTML = "There was an error. Please refresh and try again.";
					}
				}
			}
			ajax.send(vars);	
			//status.innerHTML = "You bought";
		}
		var trainAtk = document.getElementById("trainAtk");
		var trainDef = document.getElementById("trainDef");
		var trainMag = document.getElementById("trainMag");
		var gold = document.getElementById("headerGC").innerHTML;
		var atkVal = parseFloat(document.getElementById("atkValue").innerHTML);
		var defVal = parseFloat(document.getElementById("defValue").innerHTML);
		var magVal = parseFloat(document.getElementById("magValue").innerHTML);
		var atkPrice = Math.round(Math.pow(atkVal,2.5));
		var defPrice = Math.round(Math.pow(defVal,2.5));
		var magPrice = Math.round(Math.pow(magVal,2.5));
		document.getElementById("atkPrice").innerHTML = atkPrice;
		document.getElementById("defPrice").innerHTML = defPrice;
		document.getElementById("magPrice").innerHTML = magPrice;
		
		trainAtk.addEventListener("click", function(){train("Attack",atkVal)},false);
		trainDef.addEventListener("click", function(){train("Defence",defVal)},false);
		trainMag.addEventListener("click", function(){train("Magic",magVal)},false);
	</script>
</body>
</html>
