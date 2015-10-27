<?php
	header('Content-Type: text/html; charset=utf-8');	
	include_once("include/check_login.php");
	//echo $user_ok .'<---';
	//exit();
	//if(getUserDetail(preg_replace('#[^a-z0-9]#i', '',$_SESSION['username']),'is_guest')==1){header('location: sample-flashcard.php');}
	if($user_ok == false){header('location: restricted.php?refPage=quiz');}
	/******************************************************************************************************************/
	require_once 'words.php';
	require_once 'stats.php';
	require_once 'config.php';
	$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
	mysql_select_db($dbname);
	mysql_query("SET NAMES UTF8");
				
	$userID = getUserID($_SESSION['username']);
	$cvset = getSkill('cvset',$userID);
	$userDeckIds = getUserDecks(getUserID($_SESSION['username']));
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
	<title>Flashcards - jpvocab.com</title>
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
		function timer(){
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
		}
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
			timer();
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
	<div id="header-wrap">
		<?php $active = "cards"; include('include/header.php'); ?>
	</div>
	<div class="container"><!-- Need this container or else initial flashcard has extranneous space on the right-->
		<div class="row" id="first"><?php
			include 'mc_get.php';
			include 'include/kanjiRE.php';?>
		</div>
	</div>
	<div id="onward"></div>
	<div id="headerGC"></div>
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
	<?php include('include/footer.php');?>
	<!-- ********************Include Footer ******************************--><?php
	//include_once($_SERVER['DOCUMENT_ROOT'].'/include/footer-new.php'); ?>
	<!--<script type="text/javascript" src="js/scrolltest.js"></script>-->
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
</body>
</html>