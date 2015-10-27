<?php
	header('Content-Type: text/html; charset=utf-8');	
		
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
		exit();
	}else{		
		if(isset($_SESSION['LAST_ACT']) && (time() - $_SESSION['LAST_ACT'] > (60*60))){
			session_unset();
			session_destroy();
			header("Location:login.php");			
		}else{
			$_SESSION['LAST_ACT'] = time();
			//avoid attacks like session fixation
			if (!isset($_SESSION['CREATION'])) {
				$_SESSION['CREATION'] = time();
			} else if (time() - $_SESSION['CREATION'] > 1800) {
				// session started more than 30 minutes ago
				session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
				$_SESSION['CREATION'] = time();  // update creation time
			} 
			require_once 'config.php';
			$conn = mysql_connect($dbhost,$dbuser,$dbpass)
					or die('Error connecting to mysql');
			mysql_select_db($dbname);
			mysql_query("SET NAMES UTF8");
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- www.phpied.com/conditional-comments-block-downloads/ -->
		<!-- [if IE]><![endif]-->
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="applie-touch-icon" href="/apple-touch-icon.png">
		
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/reset.css" />
		<link rel="stylesheet" href="css/text.css" />
		<link rel="stylesheet" href="css/960_24_col.css" />
		
		<!-- For the less-enabled mobile browsers like Opera Mini -->
		<link rel="stylesheet" media="handheld" href="css/handheld.css?v=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script language="javascript" type="text/javascript">
			<!-- 
			//Browser Support Code
			function _(el){
				return document.getElementById(el);				
			}
			function findSelection(field){
				var test = document.getElementsByName(field);
				var sizes = test.length;
				for (i=0; i < sizes; i++){
					if (test[i].checked==true){ 
						return test[i].value;
					}
				}
			}
			function addDeck(){
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
				var url = "addDeckScript.php";
				var shortName = _('shortName').value;
				var displayName = _('displayName').value;
				var sentencesDeck = findSelection('sentencesDeck');
				var description = _('description').value;
				var gold_price = _('gold_price').value;
				var diamond_price = _('diamond_price').value;
				var diamond_list_price = _('diamond_list_price').value;
				var type = findSelection('type');
				var pictureExt = _('pictureExt').value;
				var size = _('size').value;
				var levels = _('levels').value;
				var details = _('details').value;
				var vars = "shortName="+shortName+"&displayName="+displayName+"&sentencesDeck="+sentencesDeck+"&description="+description+"&gold_price="+gold_price+"&diamond_price="+diamond_price+"&diamond_list_price="+diamond_list_price+"&type="+type+"&pictureExt="+pictureExt+"&size="+size+"&levels="+levels+"&details="+details;
				ajax.open("POST", url, true);
				ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				ajax.onreadystatechange = function(){
					if(ajax.readyState == 4){						
						var return_data = ajax.responseText;
						_('result').innerHTML = return_data;
						setTimeout(function() {_("result").innerHTML='';},20000000);
					}
				}
				ajax.send(vars);
			}
			
			</script>
		<title>Admin||Add Deck</title>
		<style type="text/css">
			header, section, article, footer, nav { display: block}
			#siteinfo{clear: both;}
		</style>
	</head>
	<body>		
		<header class="container_24">
			<?php $selected = "Vocab"; include('include/header.php'); ?>
		</header>
		<h1>Add Deck to DataBase</h1>
		Short(11):<input type='text' id="shortName" size='11'>
		Display: <input type='text' id="displayName"></br>
		Sentences Deck?</br>
			<input type='radio' name="sentencesDeck" value="1">Yes;
			<input type='radio' name="sentencesDeck" value="0">No</br>
		Description(200):</br> <textarea id="description" style="width:400px;height:75px;" size="200"></textarea></br>
		Gold Price: <input type='text' id="gold_price">
		Diamond Price: <input type='text' id="diamond_price">
		Diamond List Price: <input type='text' id="diamond_list_price"></br>
		Type of Deck</br>
			<input type='radio' name="type" value="Anime">Anime;
			<input type='radio' name="type" value="Adjectives">Adjectives;
			<input type='radio' name="type" value="JLPT">JLPT;
			<input type='radio' name="type" value="Textbook">Textbook;
			<input type='radio' name="type" value="Verbs">Verbs;
			<input type='radio' name="type" value="Other">Other</br>
		Picture extension (20): <input type='text' id="pictureExt" size="20"></br>
		Size (#cards)<input type='text' id="size" size="3">
		Levels (2)<input type='text' id="levels" size="2"></br>
		Details (500): <textarea id="details" size="500"></textarea>
		<input type='submit' id="addDeckSubmit" onClick = "addDeck()">
		<div id="result"></div>
	</body>
</html>