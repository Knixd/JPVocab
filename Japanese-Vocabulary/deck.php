<?php
	header('Content-Type: text/html; charset=utf-8');	
	include_once("../include/check_login.php");
	//if($user_ok == false){header('location: restricted.php?refPage=buy');}
	include_once("../stats.php");
	include_once("../words.php");
	$t = $_GET['t'];
	if(!isset($_GET['t'])){header("location: unlock.php");}
	if(isset($_GET['d']) && $_GET['d'] != NULL){
		$d = getDeckRow(getDeckIDFromURL($_GET['d']));
		$affiliIdStr = getDeckInfo($d['short_name'], 'affiliates_str');
		$affiliIdArr = explode(",",$affiliIdStr, -1);
		$dAffilUrl = getAffilInfo($affiliIdArr[0], 'url');
	}else if(!isset($_GET['d']) OR $_GET['d'] == NULL OR empty($_GET['d'])){
		$d = "no deck set";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Super important! Tells googlebot that this site is responsive!-->
	<meta name="robots" content="NOODP">
	<title>Japanese Flashcards | <?= ($_GET['d'] != '' ? $_GET['d'] : $t);?></title>
	<meta name="description" content="If you're looking for Japanese <?php echo $t; if($d!="no deck set"){echo " $d";}?> Vocabulary, then this free Japanese site is for you! We've done all the work for you!">
	<meta name="keywords" content="Japanese Vocabulary, Japanese flashcards online, Online Japanese Flashcards, Free Flashcards, Flash cards" />
	<meta name="author" content="Benjamin Cann">
	
	<meta property="og:title" content="Online Japanese Flashcards Flashcard -JPVocab.com" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=<?php echo $_GET['t'];?>&d=<?php echo $_GET['d'];?>" />
	<meta property="og:image" content="http://www.JPVocab.com/img/unlock2.png" />
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.JPVocab.com/js/bootstrap.min.js"></script>
	<link rel="publisher" href="https://plus.google.com/b/117072635220046762454/+Tehjapanesesitepractice/posts"/>
	<link rel="canonical" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=<?php echo $_GET['t'];?>&d=<?php echo $_GET['d'];?>" />
	<link rel="stylesheet" type="text/css" href="../css/newStyle.css">
	<link rel="stylesheet" type="text/css" href="../css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="http://www.JPVocab.com/css/font-awesome.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">-->
	<!--[if lt IE 9] >
	<script src="/js/html5shiv.js">alert('Your version of Internet Explorer is not supported!');</script>
	<![endif]-->
	
	<script src="https://apis.google.com/js/platform.js" async defer></script>

	<script type="text/javascript">
	<!-- 
			//Browser Support Code
			var popupStatus = 0;
			function _(el){
				return document.getElementById(el);				
			}
			function buyDeck(deckId, currency){//Individual Deck Page
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
				var confirmDiv = _('confirmDiv');					
				if(confirmDiv.style.display == 'none'){
					//centerPopup();
					//$("#backgroundPopup").css({"opacity": "0.7"});
					//$("#backgroundPopup").fadeIn("slow");
					$("#confirmDiv").fadeIn("slow");
					popupStatus=1;
				}
				var url = "../scripts/deckbuyscript.php";
				var vars = "deckId="+deckId+"&currency="+currency;
				ajax.open("POST", url, true);
				ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				ajax.onreadystatechange = function(){
					if(ajax.readyState == 4){						
						var return_data = ajax.responseText;
						_('confirmDiv').innerHTML = return_data;
					}
				}
				ajax.send(vars);				
			}
			function getDeckDetails(deckId, deckItemStyle){//Prob use for individual deck page
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
				//_(deckItemStyle).style.listStyle = 'circle';
				var url = "../scripts/deckDetailScript-new.php";
				var vars = "deckId="+deckId;
				ajax.open("POST", url, true);
				ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				ajax.onreadystatechange = function(){
					if(ajax.readyState == 4){						
						var return_data = ajax.responseText;
						_('leftBuy-wrap').innerHTML = return_data;
					}
				}
				ajax.send(vars);
				_('picture').innerHTML = 'Loading...';
			}
		function confirmBuy(deckId,userId){			
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
				var confirmDiv = _('confirmDiv');					
				if(confirmDiv.style.display == 'none'){
					//centerPopup();
					//$("#backgroundPopup").css({"opacity": "0.7"});
					//$("#backgroundPopup").fadeIn("slow");
					$("#confirmDiv").fadeIn("slow");
					popupStatus=1;
				}
				var url = "../scripts/confirmBuy.php";
				var vars = "deckId="+deckId+"&userId"+userId;
				ajax.open("POST", url, true);
				ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				ajax.onreadystatechange = function(){
					if(ajax.readyState == 4){						
						var return_data = ajax.responseText;
						_('confirmDiv').innerHTML = return_data;
					}
				}
				ajax.send(vars);	
		}
		function disablePopup(){
			//disables popup only if it is enabled
			if(popupStatus==1){
				//$("#backgroundPopup").fadeOut("slow");
				$("#confirmDiv").fadeOut("slow");
				popupStatus = 0;
			}
		}
		function centerPopup(){
			//request data for centering
			var windowWidth = document.documentElement.clientWidth;
			var windowHeight = document.documentElement.clientHeight;
			var popupHeight = $("#confirmDiv").height();
			var popupWidth = $("#confirmDiv").width();
			//centering
			$("#confirmDiv").css({
				"position": "absolute",
				"top": windowHeight/2-popupHeight/2,
				"left": windowWidth/2-popupWidth/2
			});
			//only need force for IE6

			/*$("#backgroundPopup").css({
				"height": windowHeight
			});*/
		}
		$(document).ready(function(){
			$("#backgroundPopup").click(function(){
				disablePopup();
			});
			$(document).keydown(function(e){
				if(e.which==27 && popupStatus==1){
					disablePopup();
				}
			});
		})
		$(function() {
		  $('a[href*=#]:not([href=#])').click(function() {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

			  var target = $(this.hash);
			  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			  if (target.length) {
				$('html,body').animate({
				  scrollTop: target.offset().top
				}, 1000);
				return false;
			  }
			}
		  });
		});
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
					window.location = "../quiz.php";
				}else{
					_("tmsg").innerHTML = ajax.responseText;
				}
			}
		}
		ajax.send(vars);
	}
	</script>
</head>
<body itemscope itemtype="https://schema.org/ItemPage"><?php
	if($user_ok == true){ include('../include/header.php');}
	else{ include('../include/header1.php');}
	require_once($_SERVER['DOCUMENT_ROOT'].'/stats.php');
	$someDecks = getSomeDecks('anime');
	//Breadcrumbs
	include("deck-breadcrumbs.php");
	//Template
	if($d != "no deck set"){
		include("template-general.php");
	}
	include("template-display-decks.php");
	
	//Breadcrumbs
	?>
	<a href="#topAnchor" class="pull-right">Top</a>
	<?
	include("deck-breadcrumbs.php");
	if($d != "no deck set"){?>
		<!-- Likes and Comments-->
			<!--<div class="fb-like" style="padding-left:45px;" data-share="true" data-width="250" data-show-faces="false"></div>
			<div class="g-plusone" data-size="small" data-annotation="inline" data-width="150" data-href="http://www.<span class="text-danger">JP</span><span class="text-primary">Vocab</span><span class="text-muted">.com</span>.com/Japanese-Vocabulary/deck.php?t=<?php echo $_GET['t'];?>&d=<?php echo $_GET['d'];?>"></div>
			<div class="g-plus" data-action="share" data-height="15" data-href="http://www.<span class="text-danger">JP</span><span class="text-primary">Vocab</span><span class="text-muted">.com</span>.com/Japanese-Vocabulary/deck.php?t=<?php echo $_GET['t'];?>&d=<?php echo $_GET['d'];?>"></div>
			<div class="g-follow" data-annotation="bubble" data-height="15" data-href="//plus.google.com/u/0/117072635220046762454" data-rel="publisher"></div>
			<div class="fb-comments " data-href="http://www.<span class="text-danger">JP</span><span class="text-primary">Vocab</span><span class="text-muted">.com</span>.com/deck.php?t=<?php echo $_GET['t'];?>&d=<?php echo $_GET['d'];?>" data-numposts="5" data-colorscheme="light"></div>
		</div>--><?php
	}?>
	<!--********************Include Footer ******************************--><?php
	//include_once($_SERVER['DOCUMENT_ROOT']."/include/footer-new.php");?>
	<!-- ********************JS ******************************-->
	<script>
	$(function () {
	  $('[data-toggle="popover"]').popover()
	})
	</script>
</body>
</html>