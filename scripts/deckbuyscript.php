<?php
	session_start();	
	include '../stats.php';
	$userId = getUserID($_SESSION['username']);	
	$title = getDeckInfoFromId($_POST['deckId'], 'display_name');
	$currency = $_POST['currency'];
	$owned = getOwnershipStatus($_POST['deckId'], getUserID($_SESSION['username'])); //check if user already owns the deck
	
	//check if user has sufficient funds for chosen currency
	if($currency == 'gc'){
		$price = getDeckInfoFromId($_POST['deckId'], 'gold_price');
		$userCurrencyFunds = getStat('Gold', getUserID($_SESSION['username']));		
	}elseif($currency == 'dmd'){
		$price = getDeckInfoFromId($_POST['deckId'], 'diamond_price');
		$userCurrencyFunds = getStat('Diamonds', getUserID($_SESSION['username']));
	}
	$balance = $userCurrencyFunds-$price;

	if($owned == true){
		$hTitle = "Oops...";
		$failBuy = "You already own this deck.";
		$bought = false;
	}elseif($balance<0){
		$lhsIcon = "<img src='../img/fail.jpg'>";
		$hTitle = "Uh oh";
		$failBuy = "<b>Insufficient funds. It seems you need more funds.</b><p>$title could be yours instantly if you get Diamonds from <a href='../diamond.php'>here</a>.</p>";
		$bought = false;
	}elseif($balance>=0 AND $owned == false){
		buyDeck(getDeckInfoFromId($_POST['deckId'],'short_name'), $userId, $currency);
		setOwnershipvStyle(getDeckInfoFromId($_POST['deckId'],'short_name'), 'kanjiE', $userId);
		setOwnershipvStyle(getDeckInfoFromId($_POST['deckId'],'short_name'), 'kanjiH', $userId);
		$bought = true;
	}else{
		$lhsIcon ="";
	}
	//Assign Values for Results Template
	
	
	$msg = $failBuy;
	$linkLHS = "";
	$linkRHS = "";
	if($bought == true){
		$hTitle = "Congratulations!";
		$lhsIcon = "<i class='fa check-circle-o fa-x5 text-success text-center' ></i>";
		$msg = "You've purchased <b>$title</b> Japanese flashcard vocabulary deck. Thank you and Enjoy!";
		$linkRHS = '<a href="#2" class="btn btn-link btn-block" onClick="sendToQuiz('.$_POST['deckId'].',"kanjiRE","null")" role="button">Click to use it now <i class="fa fa-hand-point-o"></i></a>';
	}
	?>
	<!--<div id="buyStatus"></div>-->
	<!--create div templates here
	2 Different div for different result: failBuy and bought=true -->
	<div id="confirmInner-wrap">
		<div id="buyResultLHS-wrap">
			<div id="buyResultLHSIcon">
				<div id="icon-wrap">
					<div id="innerIcon-wrap">
						<?= $lhsIcon;?>
						<a href='#0' onClick='disablePopup()'><i class="fa fa-times pull-right"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div id="buyResultRHS-wrap">
			<h2><?= $hTitle;?></h2>
			<div id="buyResultMsg">
				<?= $msg;?>
			</div>
			<div id="buyResultLink-wrap">
				<div id="buyResultLinkLHS">
					<?= $linkLHS;?>
				</div>
				<div id="buyResultLinkRHS">
					<?= $linkRHS;?>
				</div>
			</div>
		</div>
	</div>
		<!--<button type="button" id="confirmCancel" onClick="disablePopup()">Cancel</button>--><?php
?>
