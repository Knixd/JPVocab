<section>
	<div class="container"  id="buyAnchor">
		<!--***************************** BUY MODULE***************************************-->
		<div class="row">
			<div class="col-xs-12">
				<h2><span class='text-info'><?= $d['display_name'];?></span> <small>Japanese Flashcard Deck</small></h2>
				<div class="col-sm-3"><?php
					include("template-buy-module.php")?>
				</div>
				<div class="col-sm-3"><?php
					include("deckDetail.php");?>
				</div>
				
				<div class="col-xs-12 col-sm-6 "><?php
					include("buyButton.php");?>
				</div>
			</div>
		</div>
	</div>
</section>
<hr>
<section>
	<div class="container"  id="prevAnchor">
		<div class="row">
			<h2>Not convinced? <small>Here's a preview</small></h2>
			<div class="col-sm-6 col-sm-offset-3">
				<!--********************RIGHT COLUMN-*********************************-->
				<div class="col-xs-12">
					<h3><span class='text-info'><?= $d['display_name'];?></span> <small>First 10 words</small></h3>
					<table class="table table-bordered table-hover table-condensed">
						<tr>
							<th>Card #</th>
							<th class="text-center">Japanese</th>
							<th class="text-center">English</th>
							<th class="text-center">Level</th>
						</tr><?php
						$i=1;
						$prNum = 10;
						$top =getTopVocab($d['short_name'], $prNum+1);
						foreach($top as $row => $word){?>
							<tr>
								<td class="text-center"><small><?php echo $word['q'];?></small></td>
								<td class="text-center" >
									<abbr title="<?= $word['reading'];?>"><?= $word['kanji'];?></abbr>
								</td>
								<td class="text-left">
									<?= getWord(getOppositeWordID($word['id'],'jtest'),'etest'); ?>
								</td>
								<td class="text-center">1</td>
							</tr><?php
							if($i==$prNum){ break;}
							else{$i++;}
						}?>
						<tr class="text-center">
							<td><i class="fa fa-ellipsis-v"></i></td>
							<td><i class="fa fa-ellipsis-v"></i></td>
							<td><i class="fa fa-ellipsis-v"></i></td>
							<td><i class="fa fa-ellipsis-v"></i></td>
						</tr>
						<tr>
							<td class="text-danger text-center"><?= $d['size'];?></i></td>
							<td class="text-center"><abbr title="<?= $top[$prNum]['reading'];?>"><?= $top[$prNum]['kanji'];?></abbr></td>
							<td><?= getWord(getOppositeWordID($top[$prNum]['id'],'jtest'),'etest'); ?></abbr></td>
							<td class="text-danger text-center"><?= $d['levels'];?></i></td>
						</tr>
					</table>
				</div><!-- end RIGHT COLUMN-->
			</div>
		</div>
	</div>
</section>
<hr>
<!--<section>
	<div class="container"  id="howAnchor">
		<div class="row">
			<h2>Still not convinced?? <small>What about these other flash card sets?</small></h2>
			<!--<div class="col-xs-12">
				<div class="col-sm-6 col-sm-offset-3"><?
					include('leftModule.php');?>
				</div>
			</div>-->
		<!--</div>
	</div>
</section>-->
