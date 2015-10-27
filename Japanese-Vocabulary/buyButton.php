<?php
if($_SESSION['username']){
	if($d['gold_price'] ==0){?>
		<button 
			type="button" 
			id="goldButton" 
			class="btn btn-danger btn-lg btn-block" 
			style="height:150px;"
			onClick="buyDeck('<?= $d['id'];?>','gc')">
					Click to claim your free deck
		</button><?
	}else{?>
		<!--<button 
			type="button" 
			id="diamondButton" 
			class="btn btn-info btn-lg btn-block" 
			style="height:125px;"
			onClick="buyDeck('<?= $d['id'];?>','dmd')">
				Click to buy for <b><?= $d['diamond_price'];?></b> <span class="label label-default"> Diamonds</span>
		</button>
		<span class="col-xs-12 text-center"><b>- or -</b></span>-->
		<button 
			type="button" 
			id="goldButton" 
			class="btn btn-primary btn-lg btn-block" 
			style="height:100px;"
			onClick="buyDeck('<?= $d['id'];?>','gc')">
					Quickly! <br />Add to Your Collection<br /> for <b><?= $d['gold_price'];?></b> <span class="label label-warning">Gold</span>
		</button>
		<small><i>Your other decks are going to be jealous that you aren't looking at them...but I'll never tell</i></small>
		<?
	}
}else{?>
	<a href="http://www.JPVocab.com" >
		<button class="btn btn-primary btn-block" style="height:150px;">uh oh...<br />Login so I know where <br />to send your new deck!</button></a><?php
}?>
<!--<div class="col-xs-12">
	<small><a href="http://www.JPVocab.com/flashcard-rewards.php" alt="Japanese flashcard reward system">What the heck are <span class="label label-warning">Gold</span> and <span class="label label-default">Diamonds</span>?</a></small>
</div>-->
<div class="row ">
	<div class="" style="display:none;" id="confirmDiv" ></div>
</div>