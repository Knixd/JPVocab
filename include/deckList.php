<?php
	if($_SESSION['username'] =='Guest'){
		$pDecks = getAllDecks();
		$pDecksSrtAscArr = sortDeckArrDN($pDecks);
	}else{
		$pDecks = getUserDecks($userID);
		$pDecksSrtAscArr = sortDeckArrDN($pDecks);
	}
?>
	<!--********* SHOW ALL OWNED DECKS **************-->
	<div class="list-group small deckList"><?
		foreach($pDecksSrtAscArr as $key=>$value){?>
			<a href="#3" class="list-group-item <?= ($_SESSION['username']=='Guest' ?"disabled" : ''); ?>" 
			<? if($_SESSION['username']!='Guest'){?> onClick="sendToQuiz('<?= $value;?> ','kanjiRE','null')"<?} ?> >
					<?= $key;?>
			</a><?
		} ?>
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