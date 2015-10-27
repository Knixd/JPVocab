<?

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12"<div class="row">
			<h1><?= $t;?> <small>Japanese Vocab Decks</small></h1>
			<div class="row"><?php
				$someDecks = getSomeDecks($t);
				$j=0;
				foreach($someDecks as $row => $deck){
					if(!$deck['is_sentences']){
						$deckOwners = countDeckOwners($deck['display_name']);
						if($j % 2 == 0){ ?><div class="clearfix visible-sm"></div><? }
						if($j % 3 == 0){ ?><div class="clearfix visible-md visible-lg"></div><? }?>
						<div class="col-sm-6 col-md-4">
							<div class="thumbnail">
							  <img src="../img/<?= $deck['picture'];?>" class="img-responsive" alt="<?= $deck['display_name'];?> Vocabulary" class="img-responsive">
							  <div class="caption">
								<h4><a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=<?= $t;?>&d=<?= $deck['display_url']; ?>"><?= $deck['display_name'];?></a></h4>
								<p>
									 
									<a href="#2" data-toggle="popover" title="Deck Owners" data-content="<? if($user_ok ==false){ echo "Oh hey! You need to <strong>Login</strong> to do that.";}else{ foreach($deckOwners as $row => $user){ echo "<a href='http://www.jpvocab.com/player.php?player=".$user['username']."&report=summary'>". $user['username'] ."</a> <i class='text-muted small '>Lvl <strong>".getStat('level',$user['id'])."</strong></i><br />"; } }?>" data-trigger="focus" data-html="true"><small><strong><?= sizeOf($deckOwners); ?></strong> Users</a> Own This Deck</small>
								</p>
								<p><?= $deck['description'];?></p>
								<p>
									<a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=<?= $t;?>&d=<?= $deck['display_url']; ?>" class="btn btn-default btn-block" role="button">Interested?</a>
								</p>
							  </div>
							</div>
						</div><?php
						$j++;
					}
				}?>
				<!--<small><a href="http://www.JPVocab.com/flashcard-rewards.php" alt="Japanese flashcard reward system">What the heck are <span class="label label-warning">Gold</span> and <span class="label label-default">Diamonds</span>?</a></small>-->
			</div>
		</div>
	</div>
</div><script>
	$(function () {
	  $('[data-toggle="popover"]').popover()
	})
	</script>