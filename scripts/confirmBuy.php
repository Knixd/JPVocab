<?php
session_start();
include '../stats.php';
echo "<strong>Summary</strong>";
$title = getDeckInfoFromId($_POST['deckId'], 'display_name');
$cost = getDeckInfoFromId($_POST['deckId'], 'cost');
$userGold = getStat('Gold', getUserID($_SESSION['username']));
$balance = $userGold - $cost;
$owned = getOwnershipStatus($_POST['deckId'], getUserID($_SESSION['username']));
?>

<button type="button" id="confirmCancel" onClick="disablePopup()">Cancel</button>
<?php
	if($balance<0){
		echo "<i>insufficient gold</i>";
	}elseif($owned == false){
		?><button type="button" id="confirmBuy" onClick="buyDeck(getDeckInfoFromId('$_POST['deckId']','short_name'))">Buy!</button><?php
	}else{
		?><button type="button" id="confirmBuy" onClick="disablePopup()">Congrats! Deck already owned~</button><?php
	}
?>
<div id="buyStatus"></div>