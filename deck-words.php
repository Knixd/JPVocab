<?php
	include_once("include/check_login.php");
	if($user_ok == false){ 
		header("location: restricted.php?refPage=lobby");
		exit(); 
	}
	require_once 'words.php';
	require_once 'stats.php';
	require_once 'config.php';
	$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
	mysql_select_db($dbname);
	mysql_query("SET NAMES UTF8");
	
	$userID = getUserID($_SESSION['username']);
	$fcrank =getUserFCardRank($userID);
	$ttldks = getStat('ttldks',$userID);
	$ttlpvstyl = getStat('ttlpvstyl',$userID);
	$fcrankFA = ($fcrank > 50 ? '<i class="fa fa-frown-o text-danger"></i>' : ($fcrank > 25 ? '<i class="fa fa-meh-o"></i>' : ($fcrank <= 25 ? '<i class="fa fa-smile-o text-success"></i>' : '')));
	$dksFA = ($ttldks < 3 ? '<i class="fa fa-frown-o text-danger"></i>' : ($ttldks >=3 && $ttldks < 7 ? '<i class="fa fa-meh-o"></i>' : ($ttldks >= 7 ? '<i class="fa fa-smile-o text-success"></i>' : '')));
	$vstylFA = ($ttlpvstyl < 3 ? '<i class="fa fa-frown-o text-danger"></i>' : ($ttlpvstyl >=3 && $ttlpvstyl < 7 ? '<i class="fa fa-meh-o"></i>' : ($ttlpvstyl >= 7 ? '<i class="fa fa-smile-o text-success"></i>' : '')));
	
	if($ttldks==0){ $ttldks = countUserDecks($userID); setStat('ttldks',$userID,$ttldks); } //make sure db is correc
	if($ttlpvstyl == 0){ $ttlpvstyl = countUserVStyle($userID); setStat('ttlpvstyl',$userID,$ttlpvstyl);}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Super important! Tells googlebot that this site is responsive!-->
	<meta name="robots" content="NOODP">
	<title>Display Deck Words</title>
	<meta name="description" content="We're dedicated to Japanese practice. Learn elsewhere, practice here. We feature modern design, anime flashcards, and free online Japanese practice quizzes.">
	<meta name="keywords" content="Learning Japanese, Japanese practice, online Japanese exercises, login, sign up">
	<meta property="og:title" content="Best Free Online Japanese practice site. Lobby!" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://www.tehJapaneseSite.com" />
	<meta property="og:image" content="http://www.tehJapaneseSite.com/img/as.jpg" />
	<link rel=”publisher” href=”https://plus.google.com/u/0/b/117072635220046762454/+Tehjapanesesitepractice/posts“/>
	<link rel="canonical" href="http://www.JPVocab.com/" />
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9] >
	<script src="/js/html5shiv.js">alert('Your version of Internet Explorer is not supported!');</script>
	<![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="js/main.js" type="text/javascript"></script>
</head>
<body>
	<div id="header-wrap">
		<?php $active = "lobby"; include('include/header.php'); ?>
	</div>
	<div class="container-fluid">
		<div class="row" itemprop="breadcrumb">
			<ol class="breadcrumb" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" 
				itemscope itemtype="http://schema.org/ListItem">
				<span itemprop="name">
					<a href="http://www.JPVocab.com/lobby.php" title="Home" itemprop="item">
						<span itemprop="name">Home</span>
					</a>
				<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" 
				itemscope itemtype="http://schema.org/ListItem">
				<span itemprop="name">View Flashcard Deck Words</span>
				<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<!-- *************SIDEBAR**********************-->
			<div class="col-xs-12 col-sm-4 col-md-3" >
				<table class="table table-condensed borderless thin marg-bot-0" style="border-right:1px solid #ccc;">
					<tr><td colspan="2"><b><?= $_SESSION['username'];?></b></td></tr>
					<tr>
						<td>
							<small><a href="http://www.JPVocab.com/player.php?player=<?= $_SESSION['username'];?>&report=flashcardrank">Flashcard Ranking</a>: <?= ordinal($fcrank);?></small>
						</td>
						<td><small><?= $fcrankFA ?></small></td>
					</tr>
					<tr>
						<td><i><small><b><?= $ttldks; ?></b> Decks owned</small></i></td>
						<td><small><?= $dksFA;?></small></td>
					</tr>
					<tr>
						<td><i><small><b><?= $ttlpvstyl; ?></b> Quiz Modes owned</small></i></td>
						<td><small><?= $vstylFA;?></small></td>
					</tr>
					
					<tr>
						<td colspan="2" class="text-success">
							<br />
							<u>Click a deck to see it's words</u>
							<br />
							<br />
						</td>
					</tr>
				</table>
				<?php
					$pDecks = getUserDecks($userID);
					$pDecksSrtAscArr = sortDeckArrDN($pDecks);
				?>
					<!--********* SHOW ALL OWNED DECKS **************-->
					<div class="list-group small deckList"><?
						$i=1;
						foreach($pDecksSrtAscArr as $key=>$value){?>
							<a href="#<?= $i;?>" class="list-group-item" 
								onClick="displayWords('<?= $value;?>')" >
									<?= $key;?>
							</a><?
							$i++;
						} ?>
					</div>
			</div>
			<div class="col-xs-12 col-sm-8 col-md-9" >
				<div id="deckWords">
					<h2 class="text-warning"><i class="fa fa-hand-o-left"></i> Click a deck on the left to see its word</h2>
				</div>
			</div>
		</div>
	</div>
			
	
	<!-- ********************JS ******************************-->
	<!--*********************ONCLICK SEND TO QUIZ *********************-->
	<script type="text/javascript">
		function displayWords(deckId){
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
				var	url = "scripts/displayDeckWords.php";
				var vars = "deckId="+deckId;
				//console.log("hi"+deckId);
				ajax.open("POST", url, true);
				ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				ajax.onreadystatechange = function() {
					if(ajax.readyState == 4){						
						console.log = ajax.responseText;
						document.getElementById("deckWords").innerHTML = ajax.responseText;
					}
				}
				ajax.send(vars);
				document.getElementById("deckWords").innerHTML = '<i class="fa fa-spinner fa-pulse fa-5x text-center"></i> <br /><i>Some decks are large and take a long time to load. Thank you for your patience.</i>';
			}
			//-->
	</script>
</body>
</html>