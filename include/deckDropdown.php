<?php
	$pDecks = getUserDecks($userID);
	$pDecksSrtAscArr = sortDeckArrDN($pDecks);
?>
<div class="dropdown">
	<a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-square-o-down fa-lg fa-fw"></i><span class="sr-only">Change</span></a>
		<!--********* SHOW ALL OWNED DECKS **************-->
		<ul class="dropdown-menu dropdown-menu-right">
			<li class="dropdown-header">Switch <b>Flashcard Decks</b></li><?
			foreach($pDecksSrtAscArr as $key=>$value){?>
				<li role="presentation" 
					onClick="sendToQuiz('<?= $value;?>','kanjiRE','null')" >
						<a href="#2">
							<?= $key;?>
						</a>
				</li><?
			} ?>
		</ul>
</div>
<!--*********************ONCLICK SEND TO QUIZ *********************-->
<script type="text/javascript">
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
	//-->
</script>