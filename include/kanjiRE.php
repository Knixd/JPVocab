<?php
	global $previousQ;
	global $previousA;
	global $result;
	include_once ($_SERVER['DOCUMENT_ROOT']."/stats.php");
	$abcAr = array("A.","B.","C.","D.","E.");
	$cvset = getSkill('cvset',$userID);
	$vstyle = getSkill('vStyle',$userID);
	$vstyleDisp = ($vstyle == "kanjiRE" ? "<span class='text-success'><b>Easy</b></span>: <small><i>Introduce Word</i></small>" : 
		($vstyle == "kanjiE" ? "<span class='text-warning'><b>Medium</b></span>: <small><i>Learn Kanji Meaning</i></small>" : 
		($vstyle == "kanjiH" ? "<span class='text-danger'><b>Hard</b></span>: <small><i>Learn Kanji Reading</i></small>" : 
		($vstyle == "audioR" ? "<span class='text-info'><b>Audio Card</b></span>: <small><i>Learn Spelling</i></small>" :
		($vstyle == "audioE" ? "<span class='text-info'><b>Audio Card</b></span>: <small><i>Learn English</i></small>" : "")))));
	//----------------------------ASSIGN USER'S DECK VSTYLE LEVELS
	//----------------------------------------------Japanese
	$mxDkLv = getDeckInfo($cvset,'levels');
	$vstyleLv = getSkill($cvset.'_'.$vstyle.'_lv',$userID);
	$vsLvEZ = (getDeckInfo($cvset,'kanjiRE')? getSkill($cvset . '_kanjiRE_lv',$userID) : '&infin;');
	$vsLvMed = (getDeckInfo($cvset,'kanjiE')? getSkill($cvset . '_kanjiE_lv',$userID) : '&infin;');
	$vsLvHard = (getDeckInfo($cvset,'kanjiH')? getSkill($cvset . '_kanjiH_lv',$userID) : '&infin;');
	//----------------------------------------------Audio
	$vsLvAEZ = (getDeckInfo($cvset,'audioR')? getSkill($cvset . '_audioR_lv',$userID) : '&infin;');
	$vsLvAMed = (getDeckInfo($cvset,'audioE')? getSkill($cvset . '_audioE_lv',$userID) : '&infin;');
	$vsLvAHard = (getDeckInfo($cvset,'audioK')? getSkill($cvset . '_audioH_lv',$userID) : '&infin;');
	$abcAr = array("A.","B.","C.","D.","E.");
	//Vstyle Background Option
	if($vstyle == 'kanjiRE'){ 
		$vstyleBG= "success";
	}elseif($vstyle == 'kanjiH'){ 
		$vstyleBG="danger";
	}elseif($vstyle == 'kanjiE'){ 
		$vstyleBG="warning";
	}else if($vstyle =='audioR'){
		$vstyleBG = 'info';
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
	function changeVstyleMenu(cv,u,vStyle){
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
			var url = "scripts/script-vstyle-menu-redirect.php";
			var vars = "vstyle="+vStyle+"&u="+u+"&cv="+cv;
			console.log("vars: "+vars);
			ajax.open("POST", url, true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.onreadystatechange = function() {
				if(ajax.readyState == 4){
					_("vstyleMenu").innerHTML = ajax.responseText;
					console.log(ajax.responseText);
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
<div class="container">
	<div class="row">
		<div class="col-xs-3 col-sm-1 text-center pad-right-left-none" id="qmDrop">
			<?php include("vstyle-kanji.php"); ?>
		</div>
		<div class="col-xs-9 col-sm-4 text-left pad-left-none">
			<?= $vstyleDisp;?> <small>Lv. <?= $vstyleLv;?>/<span class='text-muted'><?= $mxDkLv;?></span></small>
		</div>
		<div class="col-xs-12 col-sm-7" id="quizProgBar-wrap"><?php
			include_once ($_SERVER['DOCUMENT_ROOT']."/scripts/scriptprogress.php"); ?>
		</div>
	</div>
</div>
<div class="container panel panel-<?= $vstyleBG;?>">
	<!-- Deck Picture or Messages -->
	<div class="col-xs-0 col-sm-4">
		<div class="row">
			<div class="row">
				<div class="col-xs-10">
					<a href="http://www.jpvocab.com/Japanese-Vocabulary/deck.php?t=<?= getDeckInfo($cvset,	'type'); ?>&d=<?= getDeckInfo($cvset,'display_url');?>" title="<?= $cvsetDisplay;?> Japanese Vocabulary Page">
							<?= $cvsetDisplay;?>
						</a>
				</div>
				<div class="col-xs-2"><?
					if(getUserDetail($userID,'is_guest')!=1){include("deckDropdown.php");}
					else{include("deckDropdown-sample.php");}?>
				</div>
			</div>
			<div class="col-sm-12 divider bg-<?= $vstyleBG;?>"></div>
			<div class="col-xs-12 hidden-xs pad-bot">
				<a href="<?= $cvsetAffilUrl; ?>" ><img src="http://www.jpvocab.com/img/<?= $cvsetPic; ?>" alt="<?= $cvsetDisplay;?> Japanese Vocabulary Deck Logo" class="img-rounded img-responsive center-block"></a>
				<!--<div class="text-center greyed small">
					<h6><i>If we may,</i></h6>
					<i>Recommended previous: <a href="http://www.jpvocab.com/Japanese-Vocabulary/deck.php?t=<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_prev'),'type'); ?>&d=<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_prev'),'display_url');?>" title="<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_prev'),'display_name');?> Japanese Vocabulary Deck Details Page"><?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_prev'),'display_name');?></a></i>
					<br /><i>Recommended next: <a href="http://www.jpvocab.com/Japanese-Vocabulary/deck.php?t=<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_next'),'type'); ?>&d=<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_next'),'display_url');?>" title="<?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_next'),'display_name');?> Japanese Vocabulary Deck Details Page"><?php echo getDeckInfoFromId(getDeckInfo($cvset,'series_next'),'display_name');?></a></i>
				</div>-->
			</div>
		</div>
	</div>
	<!-- Quiz Word-->
	<div class="col-sm-4">
		<div class="row" ><?php
			include_once ($_SERVER['DOCUMENT_ROOT']."/mc_get.php");							
			//include('include/kanjiRE.php');?>
			<div class="col-xs-4 small text-left">Streak: <?php echo $_SESSION['streak'];?></div>
			<div class="col-xs-8 small text-right">
				<span class="text-info"><small>Lv. <?php echo $_SESSION['wordLv'];?>　から引き出した。</small></span><?php 
				if(isAdmin($_SESSION['username']) ){?>
					<div class="pull-right"><span class="glyphicon glyphicon-flag" aria-hidden="true" role="button" onClick="toggleAdminFlag()"></span></div><?php
				}else{?>
					<div class="pull-right"><span class="glyphicon glyphicon-flag" aria-hidden="true" role="button" onClick="toggleFlag()"></span></div><?php
				}?>
			</div>
			
			<?php
				include_once ($_SERVER['DOCUMENT_ROOT']."/scripts/scriptQSize.php");
				if(substr($vstyle,0,5)=='audio'){?>
					<div class="col-xs-12 text-center play" id="question">
						<a href="#2" onClick="playSound('<?php echo $question;?>')"><?php //echo $question;?><span class="glyphicon glyphicon-play-circle play-Glyph" aria-hidden="false"></span></a><?php
				}else{?>
					<div class="col-xs-12 text-center " id="question">
						<h1 style="font-size:<?php echo $fontSize;?>"><?php echo $question;?></h1><?php
				}
						if(substr($vstyle,0,5)!='audio' ){
							$reading = ($vstyle == 'kanjiE' || $vstyle == 'kanjiH' ? "<small class='glyphicon glyphicon-question-minus'></small>" : ($question == $reading ? "<span class='glyphicon'></span>":  $reading));
						}
						/*if($question == $reading){
							$reading = "<span class='glyphicon'></span>";
						}*/?>
						<p id="reading"><?php echo $reading; ?></p>
						<label id="minutes">00</label>:<label id="seconds">00</label>
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
			<div class="col-xs-12 hidden-xs small panel panel-<?php echo $vstyleBG;?>">
				<div class="row">
					<dl class="dl-horizontal">
						<dt>You Guessed: </dt>
						<dd id="mcResult"><?php echo $result;?></dd>
						<dt>Previous Question: </dt>
						<dd ><?php echo $previousQ;?></dd>
						<dt>Previous Answer: </dt>
						<dd><?php echo $previousA;?></dd>
						<dt>Results</dt>
						<dd><?php 
							for($i=0;$i<sizeof($changeLog);$i++){
								echo $changeLog[$i];
							}?></dd>
						
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
			<div class="col-xs-12 visible-xs-block small panel panel-<?php echo $vstyleBG;?>">
				<div class="row">
					<dl class="dl-horizontal">
						<dt>You Guessed: </dt>
						<dd id="mcResult"><?= $result;?></dd>
						<dt>Previous Question: </dt>
						<dd ><?= $previousQ;?></dd>
						<dt>Previous Answer: </dt>
						<dd><?= $previousA;?></dd>
						<dt>Results</dt>
						<dd><?php 
							for($i=0;$i<sizeof($changeLog);$i++){
								echo $changeLog[$i];
							}?></dd>
						
					</dl>
				</div>
			</div>
		<input type='hidden' name='questionID' id='questionID' value="<?php echo $questionID; ?>" />
		<input type='hidden' name='questionFromBank' id='questionFromBank' value="<?php echo $questionFromBank; ?>" />
		<input type='hidden' name='answerFromBank' id='answerFromBank' value="<?php echo $answerFromBank; ?>" />
	</div>
</div>
<script type="text/javascript" src="../js/header.js"></script>
<script type="text/javascript">
	function playSound(fileName) {
		var audioElement = document.createElement('audio');
		var path = '../audio/'+fileName;
		audioElement.setAttribute('src', path);
		audioElement.load();
		audioElement.play();
	}
</script>
<!--<form id="custom-notification" action="">
  <label for="title">Title:</label>
  <input type="text" id="title" name="title" />

  <label for="body">Body:</label>
  <textarea id="body" name="body"></textarea>

  <div class="buttons-wrapper">
	<button id="button-wn-show-preset" class="button-demo">Show Preset Notification</button>
	<input type="submit" id="button-wn-show-custom" class="button-demo" value="Show Custom Notification" />
  </div>
</form>-->
<script>
  if (!('Notification' in window)) {
	document.getElementById('wn-unsupported').classList.remove('hidden');
	//document.getElementById('button-wn-show-preset').setAttribute('disabled', 'disabled');
	document.getElementById('button-wn-show-custom').setAttribute('disabled', 'disabled');
  } else {
	//var log = document.getElementById('log');
	var notificationEvents = ['onclick', 'onshow', 'onerror', 'onclose'];

	function notifyUser(event) {
	  var title;
	  var options;

	  event.preventDefault();

	  if (event.target.id === 'button-wn-show-preset') {
		title = 'New Level';
		options = {
		  body: 'You\'ve reached a new level. Congrats!',
		  tag: 'preset',
		  icon: 'http://www.audero.it/favicon.ico'
		};
	  } else {
		title = document.getElementById('title').value;
		options = {
		  body: document.getElementById('body').value,
		  tag: 'custom'
		};
	  }

	  Notification.requestPermission(function() {
		var notification = new Notification(title, options);

		notificationEvents.forEach(function(eventName) {
		  notification[eventName] = function(event) {
			log.innerHTML = 'Event "' + event.type + '" triggered for notification "' + notification.tag + '"<br />' + log.innerHTML;
		  };
		});
	  });
	}

	document.getElementById('button-wn-show-preset').addEventListener('click', notifyUser);
	document.getElementById('button-wn-show-custom').addEventListener('click', notifyUser);
	document.getElementById('clear-log').addEventListener('click', function() {
	  log.innerHTML = '';
	});
  }
</script>
<script type="text/javascript">
       timer();
    </script>
