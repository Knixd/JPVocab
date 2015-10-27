<?php
session_start();
if(!isset($_SESSION['username'])){
		header("Location: http://www.japanesegame.nocturnalvent.com/login.php");
		exit();
	}else{	
		include_once("../include/check_login.php");
		if($user_ok == false){header("location:  http://www.japanesegame.nocturnalvent.com/logout.php");}
		include '../stats.php';
		$id = $_POST['deckId'];
		$picture = getDeckInfoFromId($id, 'picture');
		$title = getDeckInfoFromId($id, 'display_name');
		$descr = getDeckInfoFromId($id, 'description');
		$goldPrice = getDeckInfoFromId($id, 'gold_price');
		$diamondPrice = getDeckInfoFromId($id, 'diamond_price');
		$diamondListPrice = getDeckInfoFromId($id, 'diamond_list_price');
		$saved =$diamondListPrice-$diamondPrice; 
		$savedPerc = round(100*($saved/$diamondListPrice),0);
		$affiliIdStr = getDeckInfoFromId($id, 'affiliates_str');
		$affiliIdArr = explode(",",$affiliIdStr, -1); //takes off the last delimiter
		shuffle($affiliIdArr);
		if(count($affiliIdArr)>4){$affiliLimit = 4;}else{$affiliLimit = count($affiliIdArr);}
		
		$levels = getDeckInfoFromId($id, 'levels');
		$details = getDeckInfoFromId($id, 'details');
		$type = getDeckInfoFromId($id, 'type');
		$size = getDeckInfoFromId($id, 'size');
		$avgCdsPerLv = getDeckInfoFromId($id, 'avg_cards_per_lv');
		$difficulty =  getDeckInfoFromId($id, 'difficulty');
		$seriesPrevId =  getDeckInfoFromId($id, 'series_prev'); 
		$seriesNextId =  getDeckInfoFromId($id, 'series_next');
		$seriesPrev =  getDeckInfoFromId($seriesPrevId, 'display_name');
		$seriesNext =  getDeckInfoFromId($seriesNextId, 'display_name');
	}
?>
<!-- TOP -->
<section>
	<div id="top-wrap" class="buyCol">
		<div id="innerLeftBuyCol" class="rounded">
			<div id="picture">
				<img src="../img/<?php echo $picture;?>" alt="Japanese Verb Deck Logo" >
				
			</div>
			<div class="buyButton-wrap">
				<button type="button" id="goldButton" class="rounded" onClick="buyDeck('<?php echo $id;?>','gc')">Buy with 1-Click <span style="color:#900; font-weight:bold;">GC</span></button>
			</div>
			<div class="buyButton-wrap">		
				<button type="button" id="diamondButton" class="rounded" onClick="buyDeck('<?php echo $id;?>','dmd')">Buy with 1-Click <span style="color:#007a00; font-weight:bold;">DMD</span></button>
			</div>
		</div><!-- end.innerLeftBuyCol-->
		<div id="innerRightBuyCol">
			<div id="deckTitle-wrap">
				<div id="deckTitle"><?php echo $title; ?></div>
			</div>
			<div id="cost-wrap" class="buyCol">
				<table>
					<tr>
						<td class="title">Gold Price:</td>
						<td><div class="goldP costNumber">GC$ <?php echo $goldPrice;?></div></td>
					</tr><?php
					if($diamondListPrice != $diamondPrice){?>
						<tr>
							<td class="title listD">List Diamond Price:</td>
							<td><div class="costNumber listD">DMD$ <?php echo $diamondListPrice;?></div></td>
						</tr><?php
					}?>
					<tr>
						<td class="title">Diamond Price:</td>
						<td><div class="diamondP costNumber">DMD$ <?php echo $diamondPrice;?></div></td>
					</tr><?php
					if($diamondListPrice != $diamondPrice){?>
						<tr>
							<td class="title listD">You save:</td>
							<td><div id="saved" class="costNumber listD diamondP">DMD$ <?php echo $saved . ' ('.$savedPerc.'%)';?></div></td>
						</tr><?php
					}?>
				</table>
				<!--<input type="submit" id ="confirmButton" onClick="confirmBuy('<?php //echo $id;?>', '<?php //echo getUserID($_SESSION['username']);?>')" value="<?php //echo $goldPrice; ?> Gold" />-->
			</div>
			<div id="pitch-wrap" class="buyCol">
				<div class="pitch buyCol">
					<div id="pitch1">
						<b>Did you know?</b> Lots of users have said they like the Diamonds system because they can get decks immediately without having to study decks they've already mastered. 
					</div>
				</div>
				<div class="pitch buyCol">
					<div id="pitch2">
						<b>But</b>, it's ok if you don't want to be like the majority, save your Gold Coins and you can buy decks for free too!<!--<?php echo date('F jS');?>-->
						<!--Transmorgify</b> with <b>Diamonds from the Sky</b> or <b>Gold from practicing</b> your hard-earned decks and grammar.-->
					</div>
				</div>
				<div class="pitch buyCol">
						<div class="pitch3"><a href="../diamond.php">Get Diamonds from the Sky</a></div>
						<div class="pitch3"><a href="../quiz.php">Get Gold from Practicing</a></div>
				</div>
			</div>
			<div id="innerRightBuyColDivider"></div>
		</div><!-- end .innerRightBuyCol-->
	</div>
</section>
<!-- OTHERS FOUND THESE USEFUL -->
<section>
	<div class="middle-wrap buyCol">
		<h3>Others liked these too</h3>
		<div id="amazonItem-wrap"><!-- Dynamically populates 4 Affiliate Links-->
			<ul class="suggItems">
				<?php for($i=0;$i<$affiliLimit;$i++){?>
					<li class="amazonItem">
						<div class="amazonSubWords">
							<?php if (getAffilInfo($affiliIdArr[$i], 'blog_review') != 'NULL'){?><a href="<?php echo getAffilInfo($affiliIdArr[$i], 'blog_review');?>" target="_blank">My Review for this</a><?php }else{ ?>&nbsp; <?php }?>
						</div>
						<div class="amazonLink">
							<a href="<?php echo getAffilInfo($affiliIdArr[$i], 'url');?>" target="_blank"><img border="0" src="../img/<?php echo getAffilInfo($affiliIdArr[$i], 'pic');?>" ></br><?php echo getAffilInfo($affiliIdArr[$i], 'display');?></a>
						</div>
					</li><?php
				}?>
			</ul>
		</div><!--end #AmazonItem-wrap-->
	</div><!--end #middle-wrap.buyCol-->
</section>
<!--*********************************************************************
     WHAT ITEMS DO OTHER BUYERS ALREADY HAVE BEFORE BUYING THIS ITEM 
*************************************************************************-->
<!--<section>
	<div id="mWrap2" class="middle-wrap buyCol">
		<h3>What Items Do Users Already Have Before Buying This Item?</h3>
		<div id="gameItem-wrap" class="buyCol">
			<ul class="suggItems">
				<li class="gameItem buyCol">
					<a href="#" onClick="getDeckDetails('7','null')"><img src="../img/sampleThumb.jpg"><span class="gItemTitle"><?php echo getDeckInfoFromId('7', 'display_name');?></span></a>
					<span class="itemType"><?php echo getDeckInfoFromId('7', 'type');?></span>
					
					<div class="gameItemPrice">
						<span class="diamondP">DMD$ <?php echo getDeckInfoFromId('7', 'diamond_price');?></span>; 
						<span class="goldP">GLD$ <?php echo getDeckInfoFromId('7', 'gold_price');?></span>
					</div>
				</li>
				<li class="gameItem buyCol">
					<a href="#" onClick="getDeckDetails('7','null')"><img src="../img/sampleThumb.jpg"><span class="gItemTitle"><?php echo getDeckInfoFromId('7', 'display_name');?></span></a>
					<span class="itemType"><?php echo getDeckInfoFromId('7', 'type');?></span>
					
					<div class="gameItemPrice">
						<span class="diamondP">DMD$ <?php echo getDeckInfoFromId('7', 'diamond_price');?></span>; 
						<span class="goldP">GLD$ <?php echo getDeckInfoFromId('7', 'gold_price');?></span>
					</div>
				</li>
				<li class="gameItem buyCol">
					<a href="#" onClick="getDeckDetails('7','null')"><img src="../img/sampleThumb.jpg"><span class="gItemTitle"><?php echo getDeckInfoFromId('7', 'display_name');?></span></a>
					<span class="itemType"><?php echo getDeckInfoFromId('7', 'type');?></span>
					
					<div class="gameItemPrice">
						<span class="diamondP">DMD$ <?php echo getDeckInfoFromId('7', 'diamond_price');?></span>; 
						<span class="goldP">GLD$ <?php echo getDeckInfoFromId('7', 'gold_price');?></span>
					</div>
				</li>
			</ul>
		</div>
	</div><!--end #middle-wrap.buyCol-->
<!--</section>-->
<!--*********************************************************************
							ITEM DESCRIPTION
*************************************************************************-->
<section>
	<div class="middle-wrap buyCol">
		<h3>Item Description</h3>
		<div id="itemDescr">
			<p><?php echo $descr;?></p>
			<p><?php echo $details;?></p>
		</div>
	</div><!--end .middle-wrap.buyCol-->
</section>
<!--*********************************************************************
							ITEM DETAILS
*************************************************************************-->
<section>
	<div class="middle-wrap buyCol">
		<h3>Item Details</h3>
		<div id="itemDetail">
			<ul>
				<li><b>Type: </b><?php echo $type;?></li>
				<li><b>Size: </b><?php echo $size;?></li>
				<li><b>Levels: </b><?php echo $levels;?></li>
				<li><b>Avg Cards Per Level: </b><?php echo $avgCdsPerLv;?></li>
				<?php if ($difficulty != 'NULL'){?> <li><b>Difficulty: </b><?php echo $difficulty;?></li><?php }?>
				<?php if ($seriesPrevId != 'NULL'){?><li><b>Previous Item in Series: </b><a href="#" onClick="getDeckDetails('<?php echo $seriesPrevId;?>','null')"><?php echo $seriesPrev;?></a></li><?php }?>
				<?php if ($seriesNextId != 'NULL'){?><li><b>Next Item in Series: </b><a href="#" onClick="getDeckDetails('<?php echo $seriesNextId;?>','null')"><?php echo $seriesNext;?></a></li><?php }?>
			</ul>
		</div>
	</div><!--end .middle-wrap.buyCol-->
</section>

