<div class="row">
	<div class="col-sm-1 col-md-1"></div>
	<div class="col-sm-10 col-md-10 table-responsive">
		<h1>My Flashcard Stats</h1>
		<p>Each number represents how many correct flashcards you've answered.</p>
		<table class="table table-hover table-bordered table-striped table-condensed">
			<tr class="info">
				<th class="text-center" style="vertical-align:middle;">Deck</th>
				<th class="text-center">Get Kanji+Reading, Guess English<br /><span class="label label-primary">Easy</span></th>
				<th class="text-center">Get Kanji, Guess English<br /><span class="label label-warning">Med</span></th>
				<th class="text-center">Get Kanji, Guess Reading<br /><span class="label label-danger">Hard</span></th>
				<th class="text-center" style="vertical-align:middle;">Total</th>
			</tr><?php
			foreach($pDecksSrtAscArr as $key=>$value){//key=DkName; value=deckId
				//if(getOwnershipStatus($value, $pid)){//firefox needs this otherwise it displays unowned decks
				$kanjiRE = getUserDeckStat('stats_correct',$key,'kanjiRE',$pid);
				$kanjiE = getUserDeckStat('stats_correct',$key,'kanjiE',$pid);
				$kanjiH = getUserDeckStat('stats_correct',$key,'kanjiH',$pid);
				$reCnt = getUserDeckStat('stats_correct',$key,'kanjiRE',$pid);
				$eCnt = getUserDeckStat('stats_correct',$key,'kanjiE',$pid);
				$hCnt = getUserDeckStat('stats_correct',$key,'kanjiH',$pid);
				$total = $kanjiRE + $kanjiH + $kanjiE;?>
				<tr class="text-center">
					<td class="text-left"><?php echo $key;?></td>
					<td <?php if($reCnt < 10){echo "class='danger'";}?> > <?php echo $reCnt;?></td><?php
					if(getDeckInfoFromId($value,'short_name') != 'hirkat' && getDeckInfoFromId($value,'short_name') != 'katakana'){?>
						<td <?php if($eCnt < 10){echo "class='danger'";}?> > <?php echo $eCnt;?></td>
						<td <?php if($hCnt < 10){echo "class='danger'";}?> > <?php echo $hCnt;?></td><?php
					}else{ echo"<td></td><td></td>";}?>
					<th class="text-center"><?php echo $total;?></th>
				</tr><?php
			}?>
			<tr>
				<th class="text-center">Total</th>
				<th class="text-center"><?php echo $sumckanjiRE; ?></th>
				<th class="text-center"><?php echo $sumckanjiE; ?></th>
				<th class="text-center"><?php echo $sumckanjiH; ?></th>
				<th class="text-center"><?php echo $sumcfc; ?></th>
		</table>
	</div>
	<div class="col-sm-1 col-md-1"></div>
</div>