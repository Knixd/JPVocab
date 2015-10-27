<?php
	include_once('words.php');
	$userID = getUserID($_SESSION['username']);
	$cvset = getSkill('cvset',$userID);
	$vstyle = getSkill('vStyle',$userID);
	$pLv = getSkill($cvset . '_'.$vstyle."_lv", $userID);
	$choiceQ = getChoiceQ($pLv);
	//---------------------------------------------------------------------------------------------
	//------------------------------------- Kanji + Reading <--> English-------------
	//------------------------------------- Kanji <--> English-----------------------------
	//---------------------------------------------------------------------------------------------
	if(getSkill('vStyle', $userID) == 'kanjiRE' || getSkill('vStyle', $userID) == 'kanjiE'){		
		//Get Question and Answers for MC Via Id's
		$questionFromBank = 'jtest';
		$answerFromBank = 'etest';
		$questionID = getQuizWordID($userID, getSkill('vStyle', $userID));
		//$questionID = $questionIDs['id'];
		$answerID = $questionID;	//lets transition to passing id's around from the start.
		$element = 'word';
		$answerChoices = getRandomWords($choiceQ, $answerFromBank, $answerID, $userID, $element);	
		//Prepare for Display in kanjiRE.php 
		$rand = rand(0,$choiceQ-1);				
		$answer = getWord($answerID, $answerFromBank);			
		$answerChoices[$rand]['id'] = $answerID; //attach id 
		$answerChoices[$rand][$element] = $answer; //attach id 
		//Finalized Variables Used in kanjiRE.php
		$question = getWord($questionID, $questionFromBank);
		$reading = getReading($answerID, $questionFromBank);
		if(isSentencesDeck(getVocStat('cvset',$userID)) == '1'){ 
			$sentences = getSentences($questionID);
		}else{ $sentences = False;}
	}elseif(getSkill('vStyle', $userID) == 'kanjiH' || $vstyle == 'audioR' || $vstyle == 'audioK'){
		//***************************************************************************************************
		//************************************* Answers are Japanese **********************************
		//***************************************************************************************************
		//Get Question and Answers for MC Via Id's
		$questionFromBank = 'jtest';
		$answerFromBank = 'jtest';				
		$questionID = getQuizWordID($userID, $vstyle); 
		$answerID = $questionID;
		$element = 'reading';
		$answerChoices = getRandomWords($choiceQ, $answerFromBank, $answerID, $userID, $element);	 //get random words in HIRAGANA; need to get hiragana, not kanji
		//Prepare for Display in kanjiRE.php 
		$rand = rand(0,$choiceQ-1);
		$answer = ($vstyle == 'audioR'  || $vstyle =='kanjiH' ? getReading($answerID, $answerFromBank) : getWord($answerID, $answerFromBank));
		$answerChoices[$rand]['id'] = $answerID;
		$answerChoices[$rand][$element] = $answer;
		//Finalized Variables Used in kanjiRE.php
		$question =  ($vstyle == 'audioR' || $vstyle == 'audioK' ? getWordInfo('audio_filename', $questionID, $questionFromBank) : getWord($questionID, $questionFromBank));
		if(isSentencesDeck(getVocStat('cvset',$userID)) == '1'){ 
			$sentences = getSentences($questionID);
		}else{ $sentences = False;}
	}elseif(getSkill('vStyle', $userID) == 'engK' || getSkill('vStyle', $userID) == 'engKR'){
		//***************************************************************************************************
		//*************************************English<-->Kanji+Hiragana; Hiragana***************************
		//***************************************************************************************************
		//$choiceQ = 5;
		$questionFromBank = 'etest';
		$answerFromBank = 'jtest';				
		//get word
		$questionID = getQuizWordID($userID, getSkill('vStyle', $userID)); 
		//echo "newQuesID is: $questionID <br />";
		$question = getWord($questionID, $questionFromBank);
		$answerID = getAnswerIDVocab($questionID, $questionFromBank);
		$answer = getWord($answerID, $answerFromBank);			
		//get random words in HIRAGANA
		$answerChoices = getRandomWords($choiceQ, $answerFromBank, $answerID, $userID, 'word'); //need to get hiragana, not kanji
		//hide answer within choices
		$rand = rand(0,$choiceQ-1);
		$answerChoices[$rand] = $answer;
		list($choice1, $choice2, $choice3, $choice4, $choice5) = $answerChoices;
	}
?>
