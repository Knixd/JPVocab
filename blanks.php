<?php
	function getID($phrase, $table){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);	
		$query = sprintf("SELECT id FROM %s WHERE element = '%s'",
			mysql_real_escape_string($table),//changed this, could mess things
			mysql_real_escape_string($phrase));
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	function getBlanks($phraseID, $table){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);	
		$query = sprintf("SELECT blank_Q FROM %s WHERE id = '%s'",
			mysql_real_escape_string($table),
			mysql_real_escape_string($phraseID));			
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	function getAnswers($phraseID, $drill){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);	
		$qBlanks = getBlanks($phraseID, 'fill_in_the_blank');
		$blankCounter = 1;
		for($i=0; $i<$qBlanks; $i++){
			if($drill == "adj" || $drill == "wordBox"){ $answers[] = getAdjAnswer($phraseID, $blankCounter);}
			elseif($drill == "fib"){ $answers[] = getAnswer(getAnswerID($phraseID, $blankCounter));}
			$blankCounter++;
		}
		return $answers;
	}
	function getAnswer($answerID){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);	
		$query = sprintf("SELECT element FROM japanese_grammar_terms WHERE id = '%s'",
			mysql_real_escape_string($answerID));			
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	function getAnswerID($phraseID, $blankN){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT answer_id FROM fill_in_blank_answers WHERE fib_id = '%s' AND blank_order = '%s'",
			mysql_real_escape_string($phraseID),
			mysql_real_escape_string($blankN));			
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	// function getAdjAnswers($phraseID){
		// include 'config.php';
		// $conn = mysql_connect($dbhost,$dbuser,$dbpass)
				// or die('Error connecting to mysql');
		// mysql_select_db($dbname);	
		// $qBlanks = getBlanks($phraseID, 'adj_pract');
		// $blankCounter = 1;
		// for($i=0; $i<$qBlanks; $i++){			
			// $answers[] = getAdjAnswer($phraseID, $blankCounter));
			// $blankCounter++;
		// }
		// return $answers;
	// }
	function getAdjAnswer($phraseID, $blankN){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT answer FROM adj_pract_answers WHERE adj_pract_id = '%s' AND blank_order = '%s'",
			mysql_real_escape_string($phraseID),
			mysql_real_escape_string($blankN));			
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}	
	function getCompletePhrase($phraseID, $table, $splitText, $color){
		$phrase = getPhrase($phraseID, $table);		
		$choppedPhrase = explode("(split)", $phrase);
		$completePhrase = getSpliced($choppedPhrase, $splitText, $color);
		return $completePhrase;
	}
	// function getCorrectPhrase($phraseID, $drill, $table){
		// $answers = getAnswers($phraseID, $drill);
		// $phrase = getPhrase($phraseID, $table);
		// $choppedPhrase = explode("(split)", $phrase);
		// $correctPhrase = getSpliced($choppedPhrase, $answers);
		// return $correctPhrase;
	// }
	// function getUserPhrase($phraseID, $table, $userInput,){
		// $phrase = getPhrase($phraseID, $table);
		// $choppedPhrase = explode("(split)", $phrase);
		// $usersPhrase = getSpliced($choppedPhrase, $userInput);
		// return $usersPhrase;
	// }
	function getPhrase($phraseID, $table){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT element FROM %s WHERE id = '%s'",
			mysql_real_escape_string($table),
			mysql_real_escape_string($phraseID));
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	function getSpliced($choppedPhrase, $answers, $color){
		$arrayChunks = sizeof($choppedPhrase);
		$string = "";
		for($i=0; $i<$arrayChunks; $i++){
			$string .= $choppedPhrase[$i].'<b><span style="color:'. $color .'">'.$answers[$i].'</span></b>';
		}
		return $string;
	}
?>