<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8 table-responsive">
		
		<table class="table table-hover">
			<thead>
				<tr>
					<td colspan="3" class="info text-center"><h4><?= $username;?></h4></td>
				</tr>
			</thead>
			<tr>
				<td>Join date</td>
				<td><?= date("F jS \, Y", strtotime(getUserDetail(getUserID($_GET['player']),'signup')))?></td>
			</tr>
			<tr>
				<td>Approximate JLPT</td>
				<td>N<?= getUserDetail(getUserID($_GET['player']),'jlpt');?></td>
			</tr>
			<tr>
				<td style="vertical-align: middle;">Last practiced Flashcard Deck:</td>
				<td style="vertical-align: middle;"><a href="<?= getDeckFullUrl(getSkill('cvset',$pid));?>"><?= $cvDN;?></a></td>
			</tr>
			<tr>
				<td style="vertical-align: middle;">Gold Coins</td>
				<td style="vertical-align: middle;"><?= $gc;?></td>
			</tr>
			
			<!--<tr>
				<td colspan="2" class="text-center active"><h4>Skills Rating</h4></td>
			</tr>
			<tr>
				<td>Vocabulary Skill</td>
				<td><?= $vocabulary;?></td>
			</tr>
			<tr>
				<td>Listening Skill</td>
				<td><?php echo $listening;?></td>
			</tr>
			<tr>
				<td>Kanji Skill</td>
				<td><?php echo $kanji;?></td>
			</tr>-->
			<tr>
				<td colspan="2" class="text-center active"><h4>Flashcard Info</h4></td>
			</tr>
			
			<tr <?php //if($ttldks <= 2){echo "class='danger'";}?> >
				<td>Decks</td>
				<td><?= $ttldks; ?></td>
			</tr>
			<tr <?php //if($ttlpvstyl < 3){echo "class='danger'";}?> >
				<td>Vocabulary Styles</td>
				<td> <?= $ttlpvstyl; ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Total Correctly Answered</td>
			</tr>
			<tr <?php //if($sumckanjiRE < 500){echo "class='danger'";}?> >
				<td><span class='text-success'><b>Easy</b></span>: <small><i>Introduce Word</i></small></td>
				<td><?= $sumckanjiRE; ?></td>
			</tr>
			<tr <?php //if($sumckanjiE < 1){echo "class='danger'";}?> >
				<td><span class='text-warning'><b>Medium</b></span>: <small><i>Learn Kanji Meaning</i></small></td>
				<td><?= $sumckanjiE; ?></td>
			</tr>
			<tr <?php //if($sumckanjiH < 1){echo "class='danger'";}?> >
				<td><span class='text-danger'><b>Hard</b></span>: <small><i>Learn Kanji Reading</i></small></td>
				<td><?= $sumckanjiH;?></td>
			</tr>
			<tr>
				<td><span class='text-info'><b>Audio Card</b></span>: <small><i>Learn Spelling</i></small></td>
				<td><?= $sumcaudioR;?></td>
			</tr>
			<tr>
				<td class="text-right"><b>Total</b></td>
				<td><?= $sumcfc;?></td>
			</tr>
			
			<tr>
				<td colspan="2" class="text-center active"><h4>Ranking</h4></td>
			</tr><?
			if($ranktfca == 1){ 
					$ranktfcaGlyph = '<abbr title="The King of flashcards!"><span class="glyphicon glyphicon-king" aria-hidden="true"></span></abbr>';
				}else if($ranktfca == 2){ 
					$ranktfcaGlyph = '<abbr title="This player is ranked #2 for Flashcards!"><span class="glyphicon glyphicon-knight" aria-hidden="true"></span></abbr>';
				}else if($ranktfca == 3){ 
					$ranktfcaGlyph = '<abbr title="This player is ranked #3 for Flashcards!"><span class="glyphicon glyphicon-bishop" aria-hidden="true"></span></abbr>';
				}else{ $ranktfcaGlyph = '';}?>
			<tr >
				<td>Flashcard Rank</td>
				<td><a href='http://www.JPVocab.com/player.php?player=<?= $_GET['player'];?>&report=flashcardrank'><?= ordinal($ranktfca) . " <span class='pull-right'>" . $ranktfcaGlyph.'</span>'; ?></a></td>
			</tr>
		</table>
	</div>
	<div class="col-md-2"></div>
</div><!-- end .row-->