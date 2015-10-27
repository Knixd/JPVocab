<?php
	header('Content-Type: text/html; charset=utf-8');
	session_start();
	if($_SESSION['username'] != 'Guest'){ include_once("include/check_login.php");}
	if($user_ok == true){ 
		header("location: lobby.php");
		exit(); 
	}
	if($_SESSION['guestInit'] == false || $_SESSION['username'] == 'Guest'){
		require_once 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
		mysql_select_db($dbname);
		mysql_query("SET NAMES UTF8");
		$u = preg_replace('#[^a-z0-9]#i', '', 'Guest'. rand(1,5000));
		$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
		$sql = sprintf("INSERT INTO users (username, ip, is_guest, notescheck) VALUES('%s','%s','1',now())",
			$u,$ip);
		$query = mysql_query($sql) or die(mysql_error());
		$userID = mysql_insert_id($conn);
		require_once 'stats.php';						
		setStat('conf',$userID,'0');
		setStat('maxconf',$userID,'150');
		setStat('lv', $userID, '1');
		setStat('gold', $userID, '0');
		setStat('dmd', $userID, '0');
		//Set Initial Deck
		//setOwnershipDeck('hirkat',$userID);
		//setOwnershipvStyle('hirkat','audioR',$userID);
		//setOwnershipDeck('minna',$userID);//sets ownership of deck(adds this deck to users' user_decks); initializesdeck_lv, deck_progress, deck_prog_max
		setOwnershipDeck('minna',$userID);//sets ownership of deck(adds this deck to users' user_decks); initializesdeck_lv, deck_progress, deck_prog_max
		setSkill('cvset',$userID,'minna');
		setSkill('vstyle',$userID,'kanjiRE');
		// CREATE THEIR SESSIONS AND COOKIES
		$_SESSION['username'] = $u;
		$_SESSION['prevID'] = 1;
		$_SESSION['guestInit'] = true;
	}
	/******************************************************************************************************************/
	require_once 'words.php';
	require_once 'stats.php';
	require_once 'config.php';
	
	$userID = getUserID($u);
	$cvset = getSkill('cvset',$userID);
	$userDeckIds = getUserDecks(getUserID($u));
	$currentConf=getStat('conf',$userID);
	$maxconf=getStat('maxconf', $userID);
	$currConfPerc = ($currentConf/$maxconf) * 100;
	$_SESSION['streak']=0;
	?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="NOODP">
	<meta name="description" content="Japanese Flashcards. Many decks. Many styles. - jpvocab.com">
	<title>Free Online Japanese Flashcard Tour</title>
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
		<!-- 
		//Browser Support Code
		function _(el){
			return document.getElementById(el);
		}

		function checkAnswer(guess){													
			var ajax;
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
						alert("Your browser broke!");
						return false;
					}
				}
			}
			//alert(guess);

			var url = "scripts/check.php";					
			var questionID = _("questionID").value;
			var questionFromBank = _("questionFromBank").value;
			var answerFromBank = _("answerFromBank").value;
			var vars = "guess="+guess+"&questionID="+questionID+"&questionFromBank="+questionFromBank+"&answerFromBank="+answerFromBank;					
			//alert(vars);
			ajax.open("POST", url, true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.onreadystatechange = function() {
				if(ajax.readyState == 4){							
					_("first").innerHTML = "";							
					var return_data = ajax.responseText;
					_("onward").innerHTML = return_data;
					updateGold()
					//setTimeout(function() {ajaxDisplay.style.display='none';},3000);
					setTimeout(function() {_("mcResult").innerHTML = "";},500000);
				}
			}
			ajax.send(vars); //actually execute the request
			//if(guess != 'settings'){
				_("mcResult").innerHTML = "checking <i class='fa fa-spinner fa-spin'></i>";
			//}
		}
		var i=0;
		function updateGold(){
			var ajax;
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
						alert("Your browser broke!");
						return false;
					}
				}
			}
			var url = "scripts/updateGoldScript.php";
			ajax.open("POST", url, true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.onreadystatechange = function() {
				if(ajax.readyState == 4){
					_("headerGC").innerHTML = ajax.responseText;
				}
			}
			ajax.send();
			i++;
			if(i == 4){ 
				addBorder('headerGC');
				_("sMsg").innerHTML = '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" onClick="removeBorder(\'headerGC\')" data-dismiss="alert" aria-label="Close"><i class="fa fa-close"></i></button><strong>Wait!</strong> Look top-right. You\'re earning gold from flashcards but then throwing them away by not signing in...<a href="http://www.JPVocab.com#register" class="alert-link">Register</a> to keep them!</div>';
			}
			if(i == 8){ 
				addBorder('quizProgBar-wrap');
				_("sMsg").innerHTML = '<div class="col-xs-12 alert alert-success alert-dismissible" role="alert"><button type="button" class="close" onClick="removeBorder(\'quizProgBar-wrap\')" data-dismiss="alert" aria-label="Close"><i class="fa fa-close"> </i></button><strong>Good Job!</strong><p>Look to the right <i class="fa fa-hand-o-right"></i>.</p><p>This is an "experience bar". You\'re gaining experience from answering these flashcards. If the bar gets to 100% you level up and you automatically get quizzed on more words. <i>(Each level quizzes a fixed amount of cards. When you level up, more words are automatically added and you\'re quizzed on more words)</i></p><p>Guests can\'t keep their progress though ... <a href="http://www.JPVocab.com#register" class="alert-link">Register</a> to save your hard work!</p><p><span class="pull-right"><i class="fa fa fa-long-arrow-down fa-2x"></i></span></p></div>';
			}
			if(i == 14){ 
				addBorder('qmDrop');
				_("sMsg").innerHTML = '<div class="col-xs-12 alert alert-info alert-dismissible" role="alert"><button type="button" class="close" onClick="removeBorder(\'qmDrop\')" data-dismiss="alert" aria-label="Close"><i class="fa fa-close"> </i></button><strong>Switch it up!</strong><p>Look bottom-left.</p><p>Can you spot the <i class="fa fa-exchange"></i> icon? Try clicking it.</p><p>These are <b>Quiz Modes</b>. Every flashcard deck has <b>Quiz Modes</b>. In Japanese, learning a word is not the same as automatically learning how to write it\'s kanji. It is important to learn the sound AND the kanji writing of Japanese words. JPVocab\'s Quiz modes do this.</p><p><ol><li><span class="label label-success">Easy</span> Mode: <small><i>Word Introduction</i></small><ul><li>gives all info: Kanji, reading, and English.</li></ul></li><li><span class="label label-warning">Medium</span> Mode: <small><i>Learn English</i></small><ul><li>Guess a kanji word\'s English meaning</li></ul></li><li><span class="label label-danger">Hard</span> Mode:<small><i>Learn Kanji</i></small><ul><li> Guess a kanji word\'s kana reading</li></ul></li><li><span class="label label-primary">Audio</span>(Beta)<ul><li>Listen to the audio and guess the correct word</li></ul></li></ol>Quiz modes are a major feature of JPVocab\'s flashcard system. Quiz modes are unlocked with <a href="http://www.JPVocab.com/flashcard-rewards.php" class="alert-link">Diamonds</a> currency.</p><p><span class="pull-left"><i class="fa fa fa-long-arrow-down fa-2x"></i></span></p></div>';
			}
		}
		function addBorder(id){
			$("#"+id).css({
					"border": "4px solid yellow"
				});
		}
		function removeBorder(id){
			$("#"+id).css({
					"border": "none"
				});
		}
		
		function toggleProgress(){
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
			var progressBar = _('progressBar');	
			var	url = "progressToggle.php";
			
			if(progressBar.style.display == 'none'){
				progressBar.style.display = 'block';
				var vars = 'toggle='+progressBar.style.display;
			}else{
				progressBar.style.display = 'none';
				var vars = 'toggle='+progressBar.style.display;						
			}
			//alert(vars);
			ajax.open("POST", url, true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.onreadystatechange = function() {
				if(ajax.readyState == 4){							
					//_("first").innerHTML = "";							
					var return_data = ajax.responseText;
					_("tst").innerHTML = return_data;
				}
			}
			ajax.send(vars);
		}
		
		
		//-->
		</script>
</head>
<body>
	<?php //include_once("scripts/scriptaddthis.php"); ?> 
	<div id="header-wrap"><?
	$active = "tour";
		include('include/header_preview.php');?>
	</div>
	<div class="container"><!-- Need this container or else initial flashcard has extranneous space on the right-->
		<div id="sMsg" class="row"></div>
		<div class="row" id="first"><?php
			include 'mc_get.php';
			include 'include/kanjiRE.php';?>
		</div>
		<div id="onward"></div>
		<div id="headerGC"></div>
	</div>
	
	
	<!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- Responsive -->
		<!--<ins class="adsbygoogle"
			 style="display:block"
			 data-ad-client="ca-pub-6131513852826437"
			 data-ad-slot="3071796305"
			 data-ad-format="auto"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
	</script>-->
	<!-- Footer-->
	<?php include('include/footer-new.php');?>
	<!-- ********************Include Footer ******************************--><?php
	//include_once($_SERVER['DOCUMENT_ROOT'].'/include/footer-new.php'); ?>
	<!--<script type="text/javascript" src="js/scrolltest.js"></script>-->
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
</body>
</html>