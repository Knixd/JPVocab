<table class="table table-condensed borderless thin marg-bot-0" style="border-right:1px solid #ccc;">
	<tr><td colspan="2"><b><?= $_SESSION['username'];?></b></td></tr>
	<tr>
		<td>
			<small><a href="http://www.JPVocab.com/player.php?player=<?= $_SESSION['username'];?>&report=flashcardrank">Flashcard Ranking</a>: <?= ordinal($fcrank);?></small>
		</td>
		<td><small><?= $fcrankFA; ?></small></td>
	</tr>
	<tr>
		<td><small><b><?= $ttldks; ?></b> Decks owned</small></td>
		<td><small><?= $dksFA;?></small></td>
	</tr>
	<tr>
		<td><small><b><?= $ttlpvstyl; ?></b> Quiz Modes owned</small></td>
		<td><small><?= $vstylFA;?></small></td>
	</tr>
	
	<tr><td colspan="2">
		<br />
		<u><i class="fa fa-hand-o-down"></i> Click to Practice a Deck</u></td>
	</tr>
</table><? include('include/deckList.php');?>