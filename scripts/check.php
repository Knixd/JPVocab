<?php					
	header('Content-Type: text/html; charset=utf-8');
	include_once("../include/check_login.php");
	//if($user_ok == false){header("location: ../logout.php");}
	include '../words.php';
	require_once '../stats.php';
	if($_POST['guess'] != 'settings'){// vsChange() needs this to reload on vstyle change
		$confMultiplier = 0.3;
		$confWrongPen = 3*$confMultiplier;
		$confCorrGain = 1*$confMultiplier;
		$skillWrongPen = 50;
		$skillCorrGain = 10;
		$userID = getUserID($_SESSION['username']);
		$streakBonus = 0;
		$skills[] = 'vocabulary'; //Keep track of type of users practice
		$scoreDecr = 0.0008;
		$scoreIncr = 0.001;
		$changeLog[] = '<div class="dropdown small">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="sr-only">Results</span><span class="hidden-xs caret"></span></span></a>
									<ul class="dropdown-menu">';
		//Get and compare the answer ID of the question word with the input word to see if matching						
		$questionFromBank = $_POST['questionFromBank'];
		$answerFromBank = $_POST['answerFromBank'];																		
		$answerID = getAnswerIDVocab($_POST['questionID'], $questionFromBank);
		$wordIDGuess = getGuessID($_POST['guess'], $answerID, $answerFromBank);				
		$cvset = getSkill('cvset',$userID);
		$vstyle = getSkill('vstyle',$userID);
		//----------------ASSIGN VARIABLES BASED ON VSTYLE
		if(substr($vstyle,0,5)=='audio'){ $skills[] = 'listening';}
		if($vstyle == 'kanjiRE'){ $gcRw = getDeckInfo($cvset,'gc_per_kanjiRE');}
		elseif($vstyle == 'kanjiE'){ $gcRw = getDeckInfo($cvset,'gc_per_kanjiE');}
		elseif($vstyle == 'kanjiH'){ 
			$gcRw = getDeckInfo($cvset,'gc_per_kanjiH');
			$skills[] = 'kanji';}
		elseif($vstyle == 'audioR'){ $gcRw = getDeckInfo($cvset,'gc_per_audioR');}
		elseif($vstyle == 'audioE'){ $gcRw = getDeckInfo($cvset,'gc_per_audioE');}
		elseif($vstyle == 'audioK'){ 
			$gcRw = getDeckInfo($cvset,'gc_per_audioK');
			$skills[] = 'kanji';}
		$gcPen = (getStat('gold',$userID)<getDeckInfo($cvset,'gc_per_kanjiRE') ? 0 : getDeckInfo($cvset,'gc_per_kanjiRE'));//gold penalty equiv to easiest setting
		$progressVoc = $cvset . '_'.$vstyle.'_prog';
		/*$answerLog = array();								
		$answerLog[0] = array(
				panswer		=>	$_POST['guess']
		);*/
		//*******************************************************************************
		//********INCREASE STATS & SKILLS IF CORRECT*************************************
		//*******************************************************************************
		if($wordIDGuess == $answerID){
			$_SESSION['streak']++;
			if($_SESSION['streak']>5){$streakBonus = round(pow($_SESSION['streak'],1.1));}
			incrStat('sumcfc',$userID);
			incrStat('sumc'.$vstyle,$userID);
			incrUserDeckStat('stats_correct', $cvset, $vstyle, $userID);
			setStat('conf',$userID,getStat('conf',$userID)+$confCorrGain);	//overall conf stat
			setSkill($progressVoc, $userID, getSkill($progressVoc,$userID)+$skillCorrGain+$streakBonus);//cvset prog skill
			setStat('gold',$userID,getStat('gold',$userID)+$gcRw);//gold
			$changeLog[] = "<li><span class='label label-warning'>Gold Coins</span>:<b>+<span class='text-success'>$gcRw</span></b></li>";
			for($i=0;$i< sizeof($skills);$i++){ 
				setScore($skills[$i],$userID,getScore($skills[$i],$userID)+$scoreIncr);
				$changeLog[] = "<li>".getStatInfo($skills[$i],'display_name').":<b> +$scoreIncr</b> Confidence points</li>";
			}
			$changeLog[] = "<li>Overall Player Confidence:<b>+$confCorrGain</b> Confidence points</span></li>";
			$changeLog[] = "<li>Quiz Mode:<b> +$skillCorrGain</b> Confidence points</span></li>";
			$changeLog[] = "<li>Streak Bonus: <b>+$streakBonus</b> Confidence points</span></li>";
			//------------------INCREMENT GENERAL SKILLS
			$result = "<span style='color:green;'>CORRECT!</span>";
		}
		//*******************************************************************************
		//********DECREASE STATS & SKILLS IF INCORRECT***********************************
		//*******************************************************************************
		elseif($wordIDGuess != $answerID){							
			setStat('conf',$userID,getStat('conf',$userID)-$confWrongPen); //overall conf stat
			setSkill($progressVoc, $userID, getSkill($progressVoc,$userID)-$skillWrongPen);//cvset prog skill
			setStat('gold',$userID,getStat('gold',$userID)-$gcPen);//gold
			incrUserDeckStat('stats_incorrect', $cvset, $vstyle, $userID);
			$changeLog[] = "<li><span class='label label-danger'>Gold Coins</span>: <b><span class='text-danger'>-$gcPen</span></b></li>";
			for($i=0;$i< sizeof($skills);$i++){ 
				setStat($skills[$i],$userID,getScore($skills[$i],$userID)-$scoreDecr);
				$changeLog[] = "<li>".getStatInfo($skills[$i],'display_name').": <span class='text-danger'>-$scoreDecr Confidence points</span></li>";
			}
			$changeLog[] = "<li>Overall Player Confidence:<b> <span class='text-danger'>-$confWrongPen Confidence points</span></b></li>";
			$changeLog[] = "<li>Quiz Mode Confidence: <span class='text-danger'>-$skillWrongPen Confidence points(xp)</span></li>";
			$changeLog[] = "<li>Streak Bonus: Reset to 0</li>";
			
			$_SESSION['streak'] = 0;
			$result = "<span style='color:#E15119'>WRONG..</span>";
		}
		$changeLog[] = "</ul></div>";
		//*******************************************************************************
		//********CHECK IF PLAYER LEVELED UP & PREPARE DISPLAY VARIABLES*****************
		//*******************************************************************************
		$lvUp = setLevelUp($userID, 'quiz');//change lv's if needed
		//Prepare Summary of Guess Results (correct/incorrect) for User Display
		$previousQ = "<span style='color:green;'>" . getWord($_POST['questionID'], $questionFromBank)."</span>";
		if(getSkill('vStyle', $userID) == 'kanjiH'){ 
			$previousA = "<span style='color:green;'>" . getReading($answerID, $answerFromBank)."</span>";
		}else{
			$previousA = "<span style='color:green;'>" . getWord($answerID, $answerFromBank)."</span>";
		}
		$origQ=getWord($_POST['questionID'],$questionFromBank);
		$lv = getStat('lv', $userID);
		$currentConf=getStat('conf',$userID);
		$maxconf=getStat('maxconf', $userID);
		$currConfPerc = ($currentConf/$maxconf) * 100;
		$vsLv = getSkill($cvset . '_'.$vstyle.'_lv', $userID);
		$vsProg=getSkill($cvset . '_'.$vstyle.'_prog',$userID);
		$vsProgMax=getSkill($cvset . '_'.$vstyle.'_prog_max', $userID);
	}
	include '../display_mc.php';
?>



