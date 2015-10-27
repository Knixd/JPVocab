<?php
	header('Content-Type: text/html; charset=utf-8');	
	include_once("../include/check_login.php");
	//if($user_ok == false){header('location: restricted.php?refPage=buy');}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Super important! Tells googlebot that this site is responsive!-->
	<meta name="robots" content="NOODP">
	<title>Japanese Grammar List for Free Online Practice Quizzes!</title>
	<meta name="description" content="If you're looking for Japanese practice, then this free online Japanese site is for you. Simply view this Japanese grammar list and click one to practice! It's that easy.">
	<meta name="keywords" content="Japanese Grammar, Online Japanese Grammar Practice, Exercises" />
	
	<link rel=”publisher” href=”https://plus.google.com/u/0/b/117072635220046762454/+<span class="text-danger">JP</span><span class="text-primary">Vocab</span><span class="text-muted">.com</span>practice/posts“/>
	<link rel="canonical" href="http://www.<span class="text-danger">JP</span><span class="text-primary">Vocab</span><span class="text-muted">.com</span>.com/japanese-grammar-list.php" />
	<link rel="stylesheet" type="text/css" href="../css/newStyle.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-flatly.min.css">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato" />
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">-->
	<!--[if lt IE 9] >
	<script src="/js/html5shiv.js">alert('Your version of Internet Explorer is not supported!');</script>
	<![endif]-->
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
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
					centerPopup();
					$("#backgroundPopup").css({"opacity": "0.7"});
					$("#backgroundPopup").fadeIn("slow");
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
					centerPopup();
					$("#backgroundPopup").css({"opacity": "0.7"});
					$("#backgroundPopup").fadeIn("slow");
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
				$("#backgroundPopup").fadeOut("slow");
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

			$("#backgroundPopup").css({
				"height": windowHeight
			});
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
	</script>
</head>
<body>
	<?php include('../include/header.php'); 
	require_once '../stats.php';
	?>
	<ol class="breadcrumb">
	  <li><a href="http://www.<span class="text-danger">JP</span><span class="text-primary">Vocab</span><span class="text-muted">.com</span>.com/">Home</a></li>
	  <li><a href="http://www.<span class="text-danger">JP</span><span class="text-primary">Vocab</span><span class="text-muted">.com</span>.com/quiz.php">Japanese Flashcards</a></li>
	  <li><a href="http://www.<span class="text-danger">JP</span><span class="text-primary">Vocab</span><span class="text-muted">.com</span>.com/unlock.php">Unlock Japanese Decks</a></li>
	  <li class="active">Anime</li>
	</ol>
	<!--Displaying Initial Deck for old design, unnecssary for new possibly.-->
	<div class="container-fluid">
		<div class="row">
			<h1>Japanese Anime Vocabulary Decks</h1><?php
			$someDecks = getSomeDecks('anime');
			$j=0;
			foreach($someDecks as $row => $deck){
				if($j % 3 == 0){ ?><div class="clearfix visible-md"></div><?php }
				if($j % 4 == 0){ ?><div class="clearfix visible-lg"></div><?php }?>
				<div class="col-sm-6 col-md-4 col-lg-3">
					<div class="thumbnail">
					  <img src="../img/<?php echo $deck['picture'];?>" alt="<?php echo $deck['display_name'];?> Vocabulary Deck Logo">
					  <div class="caption">
						<h3><?php echo $deck['display_name'];?></h3>
						<p><span class="label label-warning"><?php echo $deck['gold_price']; ?> GC</span> <span class="label label-default"><?php echo $deck['diamond_price']; ?> DMD</span></p>
						<p><a href="http://www.<span class="text-danger">JP</span><span class="text-primary">Vocab</span><span class="text-muted">.com</span>.com/Japanese-Vocabulary/deck.php?d=<?php echo $deck['display_url']; ?>" class="btn btn-danger" role="button">Explore Specifics</a> <!--<a href="#" class="btn btn-default" role="button">Button</a>--></p>
					  </div>
					</div>
				</div><?php 
				
				$j++;
			}?>
		</div>
	</div>

	<!-- ********************Include Footer ******************************--><?php
	//include_once($_SERVER['DOCUMENT_ROOT']."/include/footer-new.php"); ?>
	<!-- ********************JS ******************************-->
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type='text/javascript' src='https://plasso.co/embed/v2/embed.js'></script>
</body>
</html>