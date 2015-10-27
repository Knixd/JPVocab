<?php
	include_once("include/check_login.php");
	if($user_ok == false){header('location: restricted.php?refPage=player');}
	/******************************************************************************************************************/
	$username=$_GET['player'];
	require_once 'config.php';
	require_once 'stats.php';
	$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die ('Error connecting to mysql');
	mysql_select_db($dbname);
	$pid = getUserID($_GET['player']);
	$atk=getStat('atk',$pid);
	$mag=getStat('mag',$pid);
	$def=getStat('def',$pid);
	$gc=getStat('gc',$pid);
	$confidence=getStat('conf',$pid);
	$maxconf=getStat('maxconf',$pid);
	$lv=getStat('lv',$pid);	
	$cvDN = getDeckInfo(getSkill('cvset',$pid),'display_name');
	$currentHP=getStat('curhp',$pid);
	$maximumHP=getStat('maxhp',$pid);
	$setHP = getStat('sethp',$pid);
	$ttldks = getStat('ttldks',$pid);
	$ttlpvstyl = getStat('ttlpvstyl',$pid);
	$sumcfc = getStat('sumcfc',$pid);
	$sumckanjiRE = getStat('sumckanjiRE',$pid);
	$sumckanjiE = getStat('sumckanjiE',$pid);
	$sumckanjiH = getStat('sumckanjiH',$pid);
	$sumcaudioR = getStat('sumcaudioR',$pid);
	$vocabulary = round(getScore('vocabulary',$pid),2);
	$listening = round(getScore('listening',$pid),2);
	$kanji = round(getScore('kanji',$pid),2);
	$ttldks = countUserDecks($pid);
	
	$pDecks = getUserDecks($pid);
	$pDecksSrtAscArr = sortDeckArrDN($pDecks);//careful with this. vertNav.php uses $uDecksSrtAscArr
	include("pdc.php");
	try{
		$stmt=$db->query("SELECT  uo.*,
							(
							SELECT  COUNT(*)
							FROM    user_stats ui
							WHERE   (ui.value) >= (uo.value)
							AND ui.stat_id=14
							) AS rank
						FROM    user_stats uo
						WHERE user_id=$pid
						AND stat_id=14");
		$urank = $stmt->fetchALL(PDO::FETCH_ASSOC);
	} catch(PDOException $ex){
		echo "Couldn't get rank <br />";
	}
	$ranktfca = ($urank[0]['value'] != 0 ? $urank[0]['rank'] : 'N/A');
	require_once 'stats.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Stats - JPVocab.com</title>

	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!--JS AT END OF FILE-->
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<script type="text/javascript">
	<!--
		//var $j = jQuery.noConflict();
		function _(el){
			return document.getElementById(el);				
		}
		/*function alertMe(){
			alert("Hello World");
		}
		function mOverLink(e){
			e="#"+e;
			$j(e).css({"background-color": "#000"});
			$j(e).css({"opacity": "0.4"});
			$j(e+' a').css({"color": "#fff"});
		}
		function mOutLink(e){
			e="#"+e;
			$j(e).css({"background-color": "#000"});
			$j(e).css({"opacity": "0"});
		}
			window.addEvent('domready', function(){
			var $j = jQuery.noConflict();

				/*$j('#mousemove').scrollLeft(1020);
				$j('#mousemove').scrollTop(1250);
				$j('#drag').scrollLeft(1020);
				$j('#drag').scrollTop(1250);*/
				/*var scroll1 = new Scroller('drag', {area: 150, velocity: 0.1});		*/	
				/*var scroll2 = new Scroller('mousemove', {area: 150, velocity: 0.1}); 
				
				// Mousemove
				$('mousemove').addEvent('mouseover', scroll2.start.bind(scroll2));
				$('mousemove').addEvent('mouseout', scroll2.stop.bind(scroll2));
			});*/
	-->
	</script>
	<meta name="description" content="My profile. - tehJapanesesite.com">
	<style type="text/css">
		header, section, article, footer, nav { display: block}
		#siteinfo{clear: both;}
	</style>
</head>
<body>
	<!--<div id="loading_screen"><div id="loading">Loading page...</div></div>-->
	<?php include_once("scripts/scriptaddthis.php"); ?>
	<div id="header-wrap">
		<?php $active = ""; include('include/header.php'); ?>
	</div>
	<div class="container">
		<?php include('reports/'.$report);?>
	</div>
	<!-- ********************Include Footer ******************************-->
	<footer class="footer">
      <div class="container">
        <p class="text-muted">&copy;2015 JPVocab.com </p>
      </div>
    </footer>
	<!-- ********************JS ******************************-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<!--<script type="text/javascript" src="js/scrolltest.js"></script>-->
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
</body>
</html>