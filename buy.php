<?php
	header('Content-Type: text/html; charset=utf-8');	
	include_once("include/check_login.php");
	if($user_ok == false){header("location: logout.php");}
			
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
			var popupStatus = 0;
			function _(el){
				return document.getElementById(el);				
			}
			function buyDeck(deckId, currency){
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
				var url = "scripts/deckbuyscript.php";
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
			function getDeckDetails(deckId, deckItemStyle){
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
				var url = "scripts/deckDetailScript.php";
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
				var url = "scripts/confirmBuy.php";
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
		<title>Japanese Practice | Get New Flash Cards</title>
		<style type="text/css">
			header, section, article, footer, nav { display: block}
			#siteinfo{clear: both;}
		</style>
	</head>
	<body>
		<div class="header-wrap">
			<?php $selected = "decksStore"; include('include/header.php'); ?>
		</div>
		<div id="buyContainer">
			<div id="leftBuy-wrap">
				<script>getDeckDetails('<?php echo array_rand(array_flip(getAllDecks()), '1');?>','null')</script>
				
			</div><!--end #rightBuy-wrap-->
			<div id="decks-wrap"><?php
				require_once 'stats.php';
				$deckTypes = getAllDeckTypes();?>
				<div class="deckLists"><?php
					for($i=0;$i<count($deckTypes);$i++){//display all decks from this function?
						echo "<h4>$deckTypes[$i]</h4>";
						$typeIds = getTypeIds($deckTypes[$i]);
						echo "<ul>";
							for($j=0;$j<count($typeIds);$j++){?>
								<li onClick ="getDeckDetails('<?php echo $typeIds[$j];?>','<?php echo "deckItem" . $typeIds[$j];?>')" id="<?php echo "deckItem" . $typeIds[$j]; ?>" style="cursor:pointer;"><?php echo getDeckDisplay($typeIds[$j], ''); ?></li><?
							}
						echo "</ul>";
					}?>
				</div><!--end .deckLists-->
			</div><!--end #decks-wrap-->
			
		</div> 
		<div id="confirmDiv" style="display:none;">
		</div>
		<div id="backgroundPopup"></div>
		<div id="bought"></div>
	</body>
</html>