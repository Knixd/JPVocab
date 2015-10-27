<?php
	include_once("include/check_login.php");
	if($user_ok == false){header('location: restricted.php?refPage=mydecks');}
	/******************************************************************************************************************/
	require_once 'stats.php';
	$pid = getUserID($_SESSION['username']);
	$lv=getStat('lv',$pid);	
	$pDecks = getUserDecks($pid);
	$pDecksSrtAscArr = sortDeckArrDN($pDecks);
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>My Decks </title>
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">-->
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">-->
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript">
		<!-- 
		//Browser Support Code
		function _(el){
			return document.getElementById(el);
		}
		function buyVstyle(deckSN,deckID,userId,sMeth, vStyle){
		//check balance, if enough funds then buy deck and congratulate them(?)
		//             , if insufficient funds redirect to diamonds purchase page
		//to buy, should be able to simply use the function in stats
		var ajax;
		try{
			// Opera 8.0+, Firefox, Safari
			ajax = new XMLHttpRequest();
		} catch (e){
			// Internet Explorer Browsers
			try{ajax = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {try{ajax = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e){alert("Your browser broke!");
					return false;
				}}}
		var	url = "../scripts/buyVstyleScript.php";
		var vars = "userId="+userId+"&sMeth="+sMeth+"&vStyle="+vStyle+"&deckSN="+deckSN; //don't actually need price..
		ajax.open("POST", url, true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4){						
				if(ajax.responseText == 'successful purchase'){
					alert('Congratulations! You\'ve bought a new Vocabulary Style!');//could make this a cool window
					sendToQuiz(deckID,vStyle,'null');
				}else if(ajax.responseText == 'already owned'){
					alert('There was a mistake because it seems you already own this Deck\'s Vocabulary Style');
				}else if(ajax.responseText == 'Insufficient funds'){
					alert('Insufficient Funds');
					window.location = "diamonds.php";
					//redirect to diamonds
				}else{
					console.log(ajax.responseText);
					alert('Oops! Something went wrong. Please try again or contact support.');
				}
			}
		}
		ajax.send(vars);
	}
	function sendToQuiz(deckId,vStyle,lvUpBtn){
		var ajax;
		if(lvUpBtn !='null'){
			btn = _(lvUpBtn);
			btn.style.paddingLeft="120px";
		}
		try{
			// Opera 8.0+, Firefox, Safari
			ajax = new XMLHttpRequest();
		} catch (e){
			// Internet Explorer Browsers
			try{ajax = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {try{ajax = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e){alert("Your browser broke!");
					return false;
				}}}
		var	url = "../scripts/sendToQuizScr.php";
		var vars = "deckId="+deckId+"&vStyle="+vStyle;
		ajax.open("POST", url, true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 4){						
				if(ajax.responseText == 'change_success'){
					window.location = "quiz.php";
				}else{
					_("tmsg").innerHTML = ajax.responseText;
				}
			}
		}
		ajax.send(vars);
	}
	//-->
	</script>
	</head>
<body>
<div id="header-wrap">
		<?php $active = "cards"; include('include/header.php'); ?>
	</div>
	<div class="container-fluid">
		<div class="row" itemprop="breadcrumb">
			<ol class="breadcrumb" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" 
					itemscope itemtype="http://schema.org/ListItem">
						<a href="http://www.JPVocab.com/lobby.php" title="Home" itemprop="item">
							<span itemprop="name">Home</span>
						</a>
						<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" 
					itemscope itemtype="http://schema.org/ListItem">
						<span itemprop="name">My Flashcard Deck Levels</span>
						<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 ">
			<h1>My Deck Levels</h1>
			<p>View your deck levels for each quiz mode.</p>
				<table class="table table-hover table-bordered table-condensed table-responsive">
					<tr>
						<th class="text-center small" style="vertical-align:middle; " >Deck</th>
						<th class="text-center small"><span class='text-success'><b>Easy</b></span>:<br /> <small><i>Introduce Word</i></small></th>
						<th class="text-center small"><span class='text-warning'><b>Medium</b></span>:<br /> <small><i>Learn Kanji Meaning</i></small></th>
						<th class="text-center small"><span class='text-danger'><b>Hard</b></span>:<br /> <small><i>Learn Kanji Reading</i></small></th>
						<th class="text-center small"><span class='text-info'><b>Audio Card</b></span>:<br /> <small><i>Learn Spelling</i></small></th>
						<th class="text-center small"><span class='text-info'><b>Audio Card</b></span>:<br /> <small><i>Learn English</i></small></th>
						<!--<th class="text-center small">Listen <span class="glyphicon glyphicon-volume-up small" aria-hidden="true"></span> <span class="label label-danger">Hard</span> Guess Kanji</th>-->
						<th class="text-center small" style="vertical-align:middle;" ><b>Max Lv</b></th>
					</tr><?php
					$i=1;
					foreach($pDecksSrtAscArr as $key=>$value){//key=DkName; value=deckId
						if($i % 10 == 0){?>
							<tr>
								<th class="text-center small" style="vertical-align:middle; " >Deck</th>
								<th class="text-center small"><span class='text-success'><b>Easy</b></span>:<br /> <small><i>Introduce Word</i></small></th>
								<th class="text-center small"><span class='text-warning'><b>Medium</b></span>:<br /> <small><i>Learn Kanji Meaning</i></small></th>
								<th class="text-center small"><span class='text-danger'><b>Hard</b></span>:<br /> <small><i>Learn Kanji Reading</i></small></th>
								<th class="text-center small"><span class='text-info'><b>Audio Card</b></span>:<br /> <small><i>Learn Spelling</i></small></th>
								<th class="text-center small"><span class='text-info'><b>Audio Card</b></span>:<br /> <small><i>Learn English</i></small></th>
								<!--<th class="text-center small">Listen <span class="glyphicon glyphicon-volume-up small" aria-hidden="true"></span> <span class="label label-danger">Hard</span> Guess Kanji</th>-->
								<th class="text-center small" style="vertical-align:middle;" ><b>Max Lv</b></th>
							</tr><?php
						}
							//if(getOwnershipStatus($value, $pid)){//firefox needs this otherwise it displays unowned decks
							/****************Deck Prices**********************/
							$dkVstyleAssArr = getDeckVstylesAss($value);
							$sDeck = getDeckInfoFromId($value,'short_name');
							$deckMxLv = getDeckInfo($sDeck, 'levels');
							//$userDks = getUserDecks($userID);
							$pkanjiRE = getPrice('kanjiRE', 'gc');
							$pkanjiH = getPrice('kanjiH', 'gc');
							$pkanjiE = getPrice('kanjiE', 'gc');
							$pengKR = getPrice('engKR', 'gc');
							$pengH = getPrice('engH', 'gc');
							$pengK = getPrice('engK', 'gc');
							$paudioR = getPrice('audioR', 'gc');
							$paudioE = getPrice('audioE', 'gc');
							$paudioK = getPrice('audioK', 'gc');
							
							//Set Cell Contents
							$ownsRE = (getDeckInfoFromId($value,'kanjiRE') ? getOwnershipDeckVstyle($key,'kanjiRE',$pid) : '');
							$ownsE = (getDeckInfoFromId($value,'kanjiE') ? getOwnershipDeckVstyle($key,'kanjiE',$pid) : '');
							$ownsH = (getDeckInfoFromId($value,'kanjiH') ? getOwnershipDeckVstyle($key,'kanjiH',$pid) : '');
							$ownsAudR = (getDeckInfoFromId($value,'audioR') ? getOwnershipDeckVstyle($key,'audioR',$pid) : '');
							$ownsAudE = (getDeckInfoFromId($value,'audioE') ? getOwnershipDeckVstyle($key,'audioE',$pid) : '');
							$ownsAudK = (getDeckInfoFromId($value,'audioK') ? getOwnershipDeckVstyle($key,'audioK',$pid) : '');
							
							//$ownsE = (isHKid($value) == FALSE ? getOwnershipDeckVstyle($key,'kanjiE',$pid) : '');
							//$ownsH = (isHKid($value) == FALSE ? getOwnershipDeckVstyle($key,'kanjiH',$pid) : '');
							if($ownsRE==TRUE){// If own this decks KanjiRE
								$clvRE = getSkill($sDeck . '_kanjiRE_lv', $pid);
								$percRE = ($clvRE == 1 ? 0 : round(($clvRE/ $deckMxLv)*100,0));
								$finRE = ($percRE == 100 ? "success sparkley" : ($percRE <= 25 && $percRE != 0 ? "warning" : ($percRE == 0 ? "danger" : "")));//Style it based off their progress
							}
							if($ownsE==TRUE){// If own this decks KanjiRE
								$clvE = getSkill($sDeck . '_kanjiE_lv', $pid);
								$percE = ($clvE == 1 ? 0 : round(($clvE/ $deckMxLv)*100,0));
								$finE = ($percE == 100 ? "success sparkley" : ($percE <= 25 && $percE != 0 ? "warning" : ($percE == 0 ? "danger" : "")));//Style it based off their progress
							}
							if($ownsH==TRUE){// If own this decks KanjiRE
								$clvH = getSkill($sDeck . '_kanjiH_lv', $pid);
								$percH = ($clvH == 1 ? 0 : round(($clvH/ $deckMxLv)*100,0));
								$finH = ($percH == 100 ? "success sparkley" : ($percH <= 25 && $percH != 0 ? "warning" : ($percH == 0 ? "danger" : "")));//Style it based off their progress
							}
							if($ownsAudR==TRUE){// If own this decks KanjiRE
								$clvAudR = getSkill($sDeck . '_audioR_lv', $pid);
								$percAudR = ($clvAudR == 1 ? 0 : round(($clvAudR/ $deckMxLv)*100,0));
								$finAudR = ($percAudR == 100 ? "success sparkley" : ($percAudR <= 25 && $percAudR != 0 ? "warning" : ($percAudR == 0 ? "danger" : "")));//Style it based off their progress
							}
							if($ownsAudE==TRUE){// If own this decks KanjiRE
								$clvAudE = getSkill($sDeck . '_audioE_lv', $pid);
								$percAudE = ($clvAudE == 1 ? 0 : round(($clvAudE/ $deckMxLv)*100,0));
								$finAudE = ($percAudE == 100 ? "success sparkley" : ($percAudE <= 25 && $percAudE != 0 ? "warning" : ($percAudE == 0 ? "danger" : "")));//Style it based off their progress
							}
							if($ownsAudK==TRUE){// If own this decks KanjiRE
								$clvAudK = getSkill($sDeck . '_audioK_lv', $pid);
								$percAudK = ($clvAudK == 1 ? 0 : round(($clvAudK/ $deckMxLv)*100,0));
								$finAudK = ($percAudK == 100 ? "success sparkley" : ($percAudK <= 25 && $percAudK != 0 ? "warning" : ($percAudK == 0 ? "danger" : "")));//Style it based off their progress
							}
							
							?>
							<tr class="text-center">
								<td class="text-left col-xs-4" style="vertical-align:middle;"><a href="<?= getDeckFullUrl($key);?>"><?= $key;?></a></td><?php
								//Easy
								if($ownsRE==TRUE){?>
									<td class="<?= $finRE;?>" style="vertical-align:middle;"><span class="text-default">Lv. <?= "$clvRE";?></span></td><?php
								}else if($ownsRE==FALSE){?><td style="vertical-align:middle;"><button type="button" class="btn btn-sm btn-link" onClick="buyVstyle('<?= $sDeck;?>','<?= $value;?>','<?= $pid;?>','gc','kanjiRE')">Click to upgrade deck,<br />get this quiz mode for <span class="text-info"><?= $pkanjiRE;?> Gold Coins</span> <span class="glyphicon glyphicon-hand-up"></span></button></td><?php }
								//Med
								if($ownsE==TRUE){?>
									<td class="<?= $finE;?>" style="vertical-align:middle;">
										<span class="text-default">Lv. <?= "$clvE";?></span>
									</td><?php
								}else if($ownsE==FALSE && isHKid($value) == FALSE){?>
									<td style="vertical-align:middle;" class=" col-xs-2">
										<button type="button" class="btn btn-sm btn-link" onClick="buyVstyle('<?= $sDeck;?>','<?= $value;?>','<?= $pid;?>','gc','kanjiE')">You must click to pay <br /><b><span class="text-info"><?= $pkanjiE;?> <span class="label label-warning">Gold Coins</span> to get this <span class='text-warning'><b>Medium</b></span> Quiz mode. <span class="glyphicon glyphicon-hand-up"></span></button></td><?php
								}else if($ownsE == ""){?><td style="background-color:#000;"></td><?php }
								//Hard
								if($ownsH==TRUE){?><td class="<?= $finH;?>" style="vertical-align:middle;"><span class="text-default">Lv. <?= "$clvH";?></span></td><?php
								}else if($ownsH==FALSE && isHKid($value) == FALSE){?><td style="vertical-align:middle;" class=" col-xs-3"><button type="button" class="btn btn-sm btn-link" onClick="buyVstyle('<?= $sDeck;?>','<?= $value;?>','<?= $pid;?>','gc','kanjiH')"><b><span class="text-info"><?= $pkanjiH;?></b> <span class="label label-warning">Gold Coins</span><span class="glyphicon glyphicon-hand-up"></span></button></td><?php
								}else if($ownsH==""){?><td style="background-color:#000;"></td><?php }
								//-------------------AUDIO EASY
								if($ownsAudR==TRUE){?><td class="<?= $finAudR;?>" style="vertical-align:middle;"><span class="text-default">Lv. <?= "$clvAudR";?></span></td><?php
								}else if($ownsAudR==FALSE && getDeckInfo($sDeck,'audioR') ==1){?><td style="vertical-align:middle;"><button type="button" class="btn btn-sm btn-link" onClick="buyVstyle('<?= $sDeck;?>','<?= $value;?>','<?= $pid;?>','gc','audioR')"><b><span class="text-info"><?= $paudioR;?></b> <span class="label label-warning">Gold Coins</span></span> <span class="glyphicon glyphicon-hand-up"></span></button></td><?php
								}else if($ownsAudR==""){?><td style="background-color:#000;"></td><?php }
								//-------------------AUDIO MEDIUM
								if($ownsAudE==TRUE){?><td class="<?= $finAudE;?>" style="vertical-align:middle;"><span class="text-default">Lv. <?= "$clvAudE";?></span></td><?php
								}else if($ownsAudE==FALSE && getDeckInfo($sDeck,'audioE') ==1){?><td style="vertical-align:middle;"><button type="button" class="btn btn-sm btn-link" onClick="buyVstyle('<?= $sDeck;?>','<?= $value;?>','<?= $pid;?>','gc','audioE')">Click to upgrade deck,<br />get this quiz mode for <span class="text-info"><?= $paudioE;?> Gold Coins</span> <span class="glyphicon glyphicon-hand-up"></span></button></td><?php
								}else if($ownsAudE==""){?><td style="background-color:#000;"></td><?php }
								//-------------------AUDIO HARD
								/*if($ownsAudK==TRUE){?><td class="<?= $finAudK;?>" style="vertical-align:middle;"><span class="text-default">Lv. <?= "$clvAudK";?></span></td><?php
								}else if($ownsAudK==FALSE && getDeckInfo($sDeck,'audioK') ==1){?><td style="vertical-align:middle;"><button type="button" class="btn btn-sm btn-link" onClick="buyVstyle('<?= $sDeck;?>','<?= $value;?>','<?= $pid;?>','gc','audioK')">Click to upgrade deck,<br />get this quiz mode for <span class="text-info"><?= $paudioK;?> Gold Coins</span> <span class="glyphicon glyphicon-hand-up"></span></button></td><?php
								}else if($ownsAudK==""){?><td></td><?php }*/
								?>
								
								<td class="success" style="vertical-align:middle;"><span class="text-default"><b>Lv. </small><?= $deckMxLv;?></b></span></td>
							</tr><?php
						 //end if($i%==0)
						$i++;
					} //end row
					?>
				</table>
			</div>
		</div>
	
		<div class="row">
			<div class=" col-xs-12 col-sm-6 pull-right">
				<div class="panel panel-default">
					<div class="panel-heading">Legend</div>
					<div class="panel-body">
						<span class="text-success">Green Background</span> = You've reached the max level. Congrats! (Hover over them and see what happens)<br />
						<b>Clear Background</b> = You've made solid progress and have almost reached the maximum level. Just a little bit more!<br />
						<span class="text-warning">Orange Background</span> = You're still a beginner at this deck. Keep it up!<br />
						<span class="text-danger">Red Background</span> = You've just started this deck. Better level up!<br />
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer-->
	<?php include('include/footer.php');?>
	<footer class="footer">
	      <div class="container">
	        <p class="text-muted">&copy;2015 JPVocab.com </p>
	      </div>
    	</footer>
	<!-- ********************JS ******************************-->
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/gen.js"></script>
	<!--<script type="text/javascript" src="js/scrolltest.js"></script>-->
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
</body>
</html>