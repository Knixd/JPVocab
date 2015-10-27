<?
$deckOwners = countDeckOwners($d['display_name']);
?>
<small>Gold Price:</small> <?
	if($d['gold_price']==0){?>
		Free <i>(offer ending soon)</i><?
	}else{?>
		<b><?= $d['gold_price'];?></b> <span class="label label-warning">Gold</span>
		<!--<br />
		<small class="">Diamond Price: </small>
		<b><?= $d['diamond_price'];?></b> <span class="label label-default">Diamonds</span>
		<br />
		<small class="text-muted"><i>Get more Diamonds <a href="http://www.JPVocab.com/diamond.php" alt="Get more Diamonds">here</a></i></small>--><?
	}?> 
<p>
<hr><small class="">Difficulty:</small> <span itemprop="audience"><a href="http://www.jlpt.jp/e/"><?php echo $d['difficulty'];?></a></span></b><br/>
<small class="">Number of Cards:</small> <?= $d['size'];?> cards<br />
<small class="">Number of Levels: </small><?= $d['levels'];?> levels<hr></small>
<a href="#2" data-toggle="popover" title="Deck Owners" data-content="<? if($user_ok ==false){ echo "Oh hey! You need to <strong>Login</strong> to do that.";}else{foreach($deckOwners as $row => $user){ echo "<a href='http://www.jpvocab.com/player.php?player=".$user['username']."&report=summary'>". $user['username'] ."</a> <i class='text-muted small '>Lvl <strong>".getStat('level',$user['id'])."</strong></i><br />"; }}?>" data-trigger="focus" data-html="true"><small><strong><?= sizeOf($deckOwners); ?></strong> Users</a> Already Own This Deck
</p>