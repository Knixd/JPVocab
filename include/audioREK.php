<?php
	//session_start();
	global $previousQ;
	global $previousA;
	global $result;
	include_once ($_SERVER['DOCUMENT_ROOT']."/stats.php");
	$abcAr = array("A.","B.","C.","D.","E.");
	$cvset = getSkill('cvset',$userID);
	$vstyle = getSkill('vstyle',$userID);
	//Assign decks vstyle levels
	$mxDkLv = getDeckInfo($cvset,'levels');
	$vsLvEZ = getSkill($cvset . '_KanjiRE_lv',$userID);
	if($cvset != 'hirkat'&& $cvset !='katakana'){ 
		$vsLvMed = getSkill($cvset . '_kanjiE_lv',$userID);
		$vsLvHard = getSkill($cvset . '_kanjiH_lv',$userID);
	}
	$abcAr = array("A.","B.","C.","D.","E.");
	//Vstyle Background Option
	if($vstyle == 'kanjiRE'){ 
		$vstyleBG= "success";
	}elseif($vstyle == 'kanjiH'){ 
		$vstyleBG="danger";
	}elseif($vstyle == 'kanjiE'){ 
		$vstyleBG="warning";
	}
	//Left column variables
	$cvsetDisplay = getDeckInfo($cvset, "display_name");
	$cvsetPic = getDeckInfo($cvset, "picture");
	$affiliIdStr = getDeckInfo($cvset, 'affiliates_str');
	$affiliIdArr = explode(",",$affiliIdStr, -1);
	$cvsetAffilUrl = getAffilInfo($affiliIdArr[0], 'url');
//---------------------------------------------------------------------
//Deck Header & 3 Column Flashcards
//---------------------------------------------------------------------
?>
<script type="text/javascript">

	function checkCard(wordID,answerID,deckSN,vStyle,from){
		var ajax;
			try{
				// Opera 8.0+, Firefox, Safari
				ajax = new XMLHttpRequest();
			} catch (e){
				// Internet Explorer Browsers
				try{
					ajax = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					try{
						ajax = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e){								
						alert("Your browser broke!");
						return false;
					}
				}
			}
			msg = _("amsg").value;
			choicesArr = <?php echo json_encode($answerChoices); ?>;
			var url = "admin/scripts/script-check-card.php";
			var vars = "wordID="+wordID+"&answerID="+answerID+"&deckSN="+deckSN+"&vStyle="+vStyle+"&msg="+msg+"&from="+from+"&choicesArr="+choicesArr;
			console.log("vars: "+vars);
			ajax.open("POST", url, true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.onreadystatechange = function() {
				if(ajax.readyState == 4){
					if(ajax.responseText == "Notified"){
						_("adminCheck").innerHTML = "<small class='greyed'><i>You've successfully notified <span class='marooned'><strong>teh wizzard.</strong></span> <br />Your input is valuable and helps others learn Japanese more efficiently, so kind.</i></small>";
					}else{
						_("adminCheck").innerHTML = "<small class='greyed'>Thanks! Your input is valuable and helps others learn Japanese more efficiently, so kind.</small>";
						console.log("art: "+ajax.responseText);
					}
				}
			}
			ajax.send(vars);
	}
	var i = 1;
	function toggleAdminFlag(){
		if(i==1){
			_('adminCheck').style.display = "block";
			_('amsg').style.display = "block";
			_('flagBtn').style.display = "block";
			i=0;
		}else{
			_('adminCheck').style.display = "none";
			_('amsg').style.display = "none";
			_('flagBtn').style.display = "none";
			i=1;
		}
	}
	function toggleFlag(){
		if(i==1){
			_('adminCheck').style.display = "block";
			//_('amsg').style.display = "block";
			_('flagBtn').style.display = "block";
			i=0;
		}else{
			_('adminCheck').style.display = "none";
			//_('amsg').style.display = "none";
			_('flagBtn').style.display = "none";
			i=1;
		}
	}
</script>
<div class="container" >
	<div class="row">
		<div class="col-sm-12 text-center">
			<h2><?php echo getDeckInfo($cvset, 'display_name') . $vstyle;?></h2>
		</div>
	</div>
	<span onClick="vsChange('vStyle','audioK')">Change to audio</span>
	<div class="row">
		<div class="col-sm-12">
			<ul class="nav nav-pills nav-justified">
			  <!--If user owns this vocabulary style -->
			  <?php if(getOwnershipDeckVstyle($cvset,'kanjiRE',$userID)==TRUE){?>
			  	<li role="presentation" class="<?php if($vstyle== 'kanjiRE'){echo "vsSel active";}?>" onClick="vsChange('vStyle','kanjiRE')"><a href="#1" ><span class="label label-success">Easy</span> <?php if($cvset != 'hirkat'&& $cvset !='katakana'){?>Get Kanji+Reading, Guess English<?php }else{ echo "Guess Pronunciation!";}?> <span class="badge"><small><i>Lv.<?php echo $vsLvEZ; if($vsLvEZ==$mxDkLv){echo " (Max)";}?></i></small></span></a></li><?php }
				//Medium If/else
				if(getOwnershipDeckVstyle($cvset,'kanjiE',$userID)==TRUE && $cvset != 'hirkat'&& $cvset !='katakana'){?>
					<li role="presentation" class="<?php if($vstyle == 'kanjiE'){echo "active";}?>" onClick="vsChange('vStyle','kanjiE')" ><a href="#2"><span class="label label-warning">Med</span> Get Kanji, Guess English <span class="badge"><small><i>Lv.<?php echo $vsLvMed; if($vsLvMed==$mxDkLv){echo " (Max)";}?></i></small></span></a></li><?php
				}else if(getOwnershipDeckVstyle($cvset,'kanjiE',$userID)==FALSE && $cvset != 'hirkat'&& $cvset !='katakana'){?>
					<li role="presentation" class="vsBuy" onClick="buyVstyle('<?php echo $cvset; ?>','<?php echo getDeckInfo($cvset, 'id'); ?>','<?php echo $userID; ?>','dmd', 'kanjiE')" ><a href="#2">Buy <span class="label label-warning">Med</span> Get Kanji, Guess English for <?php echo getPrice('kanjiE', 'dmd');?> DMD here!</a></li><?php
			   }
			   //Hard If/else
			   if(getOwnershipDeckVstyle($cvset,'kanjiH',$userID)==TRUE && $cvset != 'hirkat'&& $cvset !='katakana'){?>
					<li role="presentation" class="<?php if($vstyle == 'kanjiH'){echo "active";}?>" onClick="vsChange('vStyle','kanjiH')" ><a href="#3"><span class="label label-danger">Hard</span> Get Kanji, Guess Reading <span class="badge"><small><i>Lv.<?php echo $vsLvHard; if($vsLvHard==$mxDkLv){echo " (Max)";}?></i></small></span></a></li><?php
			   }else if(getOwnershipDeckVstyle($cvset,'kanjiH',$userID)==FALSE && $cvset != 'hirkat'&& $cvset !='katakana'){?>
				<li role="presentation" class="vsBuy" onClick="buyVstyle('<?php echo $cvset; ?>','<?php echo getDeckInfo($cvset, 'id'); ?>','<?php echo $userID; ?>','dmd', 'kanjiH')" ><a href="#3">Buy <span class="label label-danger">Hard</span> Get Kanji, Guess Reading for <?php echo getPrice('kanjiH', 'dmd');?> DMD here!</a></li><?php
			   }?>
			</ul>
		</div>
	</div>
	<div class="row"><?php
		include_once ($_SERVER['DOCUMENT_ROOT']."/scripts/scriptprogress.php"); ?>
	</div>
</div>
<div class="container panel panel-<?php echo $vstyleBG;?>">
	<!-- Deck Picture or Messages -->
	<div class="col-xs-0 col-sm-4">
		<div class="row">
			<div class="col-sm-12 small text-center"><a href="http://www.tehjapanesesite.com/Japanese-Vocabulary/deck.php?t=<?php echo getDeckInfo($cvset,'type'); ?>&d=<?php echo getDeckInfo($cvset,'display_url');?>" title="<?php echo $cvsetDisplay;?> Japanese Vocabulary Deck Details Page"><?php echo $cvsetDisplay;?></a></div>
			<div class="col-sm-12 divider bg-<?php echo $vstyleBG;?>"></div>
			<div class="col-xs-12 pad-bot"><a href="<?php echo $cvsetAffilUrl; ?>" ><img src="http://www.tehjapanesesite.com/img/<?php echo $cvsetPic; ?>" alt="<?php echo $cvsetDisplay;?> Japanese Vocabulary Deck Logo" class="img-rounded img-responsive center-block"></a>
			<div class="text-center greyed small"><h6><i>If we may,</i></h6>
				<i>Recommended previous: <a href="http://www.tehjapanesesite.com/Japanese-Vocabulary/deck.php?t=<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_prev'),'type'); ?>&d=<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_prev'),'display_url');?>" title="<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_prev'),'display_name');?> Japanese Vocabulary Deck Details Page"><?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_prev'),'display_name');?></a></i>
				<br /><i>Recommended next: <a href="http://www.tehjapanesesite.com/Japanese-Vocabulary/deck.php?t=<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_next'),'type'); ?>&d=<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_next'),'display_url');?>" title="<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_next'),'display_name');?> Japanese Vocabulary Deck Details Page"><?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_next'),'display_name');?></a></i></div>
			</div>
		</div>
	</div>
	<!-- Quiz Word-->
	<div class="col-sm-4">
		<div class="row" ><?php
			include_once ($_SERVER['DOCUMENT_ROOT']."/audio_mc_get.php");							
			//include('include/kanjiRE.php');?>
			<div class="col-xs-6 small text-center">Streak: <?php echo $_SESSION['streak'];?></div>
			<div class="col-xs-6 small text-center">
				<i>This word is from &nbsp;<span class="badge"><small><i>Lv. <?php echo $_SESSION['wordLv'];?></i></small></span></i><?php 
				if(isAdmin($_SESSION['username']) ){?>
					<div class="pull-right"><span class="glyphicon glyphicon-flag" aria-hidden="true" onClick="toggleAdminFlag()"></span></div><?php
				}else{?>
					<div class="pull-right"><span class="glyphicon glyphicon-flag" aria-hidden="true" onClick="toggleFlag()"></span></div><?php
				}?>
			</div>
			
			<div class="col-xs-12 text-center jumbotron " id="question"><?php
				include_once ($_SERVER['DOCUMENT_ROOT']."/scripts/scriptQSize.php");?>
				<h1 style="font-size:<?php echo $fontSize;?>"><?php echo $question;?></h1><?php
				if($vstyle != 'kanjiRE'){
					$reading = "<small class='glyphicon glyphicon-question-sign'></small>";
				}
				if($question == $reading){
					$reading = "<span class='glyphicon'></span>";
				}?>
				<p id="reading"><?php echo $reading; ?></p>
					<div class="form-inline" id="adminCheck" style="display:none;">
					<small><i>Problem with this card? If yes</i></small>
					  <div class="form-group">
						<label class="sr-only" for="exampleInputAmount">Suggested</label>
						<div class="input-group-sm">
							<input type="text" class="form-control" id="amsg" placeholder="type a msg " autocomplete="off"  style="display:none;">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-default"   style="display:none;" id="flagBtn" onClick="checkCard('<?php echo $questionID."','".$answerID."','".$cvset."','".$vstyle."','".$_SESSION['username'];?>')"><i>Notify teh wizard</i></button>
							</span>
						</div>
					  </div>
					</div>
			</div>
			<div class="col-xs-12 panel panel-<?php echo $vstyleBG;?>">
				<div class="row">
					<dl class="dl-horizontal">
						<dt>You Guessed: </dt>
						<dd id="mcResult"><?php echo $result;?></dd>
						<dt>Previous Question: </dt>
						<dd ><?php echo $previousQ;?></dd>
						<dt>Previous Answer: </dt>
						<dd><?php echo $previousA;?></dd>
					</dl>
				</div>
			</div>
		</div>
		
	</div>
	<!-- Choices-->
	<div class="col-sm-4">
		<div class="row text-center">
			<div class="col-xs-12 small">Choices</div>
		</div><?php 
			$i = 0;
			foreach($answerChoices as $key => $value){?>
				<input type='button' name='guess' class='guess btn btn-block btn-info' onClick ="checkAnswer('<?php echo addslashes($value[$element]);?>')" value=" <?php echo $abcAr[$i] . " ".$value[$element];?>"/><?php 
				$i++;
			}?>
		<input type='hidden' name='questionID' id='questionID' value="<?php echo $questionID; ?>" />
		<input type='hidden' name='questionFromBank' id='questionFromBank' value="<?php echo $questionFromBank; ?>" />
		<input type='hidden' name='answerFromBank' id='answerFromBank' value="<?php echo $answerFromBank; ?>" />
	</div>
</div>
<script type="text/javascript" src="../js/header.js"></script>