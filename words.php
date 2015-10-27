<?php
	//Tried to make the words rikaichan-proof
	function getOppositeWordID($sourceID, $sourceWordBank){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or error_log('Error connecting to mysql');
		mysql_select_db($dbname);
		if($sourceWordBank == 'etest'){
			$oppositeWordBank = 'jtest';			
		}else{
			$oppositeWordBank = 'etest';
		}		
		$query = sprintf("SELECT id FROM %s WHERE answer_id = '%s'",
			mysql_real_escape_string($oppositeWordBank),
			mysql_real_escape_string($sourceID));
		$result = mysql_query($query)or error_log("Error on words.php getOppositeWordID(). <br /> Mysql Error: ".mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	function getVocabID($word, $wordBank){//changed name, could mess things up
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		if($wordBank == 'etest'){ 
			$query = sprintf("SELECT id FROM %s WHERE word = '%s'",
				mysql_real_escape_string($wordBank),				
				mysql_real_escape_string($word));
		}elseif($wordBank == 'jtest'){
			$query = sprintf("SELECT id FROM %s WHERE word = '%s' OR reading ='%s'",
				mysql_real_escape_string($wordBank),
				mysql_real_escape_string($word),
				mysql_real_escape_string($word));
		}
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		//echo "guessID::$value::</br>";
		return $value;
	}
	function delDup(){
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);		
		for($i=1;$i<9000;$i++){		
			$query = sprintf("SELECT word,reading,minna FROM jtest WHERE id = '$i'");				
			$result = mysql_query($query) or die(mysql_error());
			// for($j=0;$j<6;$j++){
				// list($value[$j])=mysql_fetch_row($result);/*everytime it fetches the row, adds it to array...*/ //fetch probably goes through each location of $result array
			// }
			$value1 = mysql_fetch_array($result);			
			//echo "</br>" . $value1['word'] . $value1['reading'];
			$word = $value1['word'];
			$reading = $value1['reading'];
			$minna = $value1['minna'];
			$query = sprintf("SELECT COUNT(id) FROM jtest WHERE word = '$word' AND reading = '$reading'");
				
			$result2 = mysql_query($query) or die(mysql_error());
			list($value2) = mysql_fetch_row($result2);
			if($value2>=2){
				//print_r($value1);
				echo $value2 . ' duplicates: ' . $value1['word'] . 'minna::' . $value1['minna'] . '::</br>';				
				//echo 'Deleting the min of ' . $value2 . 'Duplicates: ' . $value1['word'] . 'minna::' . $value1['minna'] . '::</br>';				
				
				// $test = sprintf("SELECT Min(id) FROM jtest WHERE word = '$word' AND reading = '$reading'");
				// $testt = mysql_query($test) or die(mysql_error());
				// list($testt) = mysql_fetch_row($testt);
				
				// $query = sprintf("DELETE FROM jtest WHERE word = '$word' AND reading = '$reading' AND id != $testt");
				// $result3 = mysql_query($query) or die(mysql_error());
				// list($value3) = mysql_fetch_row($result3);
				// $query2 = sprintf("");
				
				// echo "min id::$testt </br>";
				//order
				//grab answer_id's of those not min
				//drop those not min
				//drop those answer_id's
				
			}
		}
	}
	function getGuessID($guess, $answerID, $wordBank){
		include 'config.php';				
		$answer = getWord($answerID, $wordBank);		
		//echo "$guess||$answerID||$wordBank||$answer||"; //answer being sent is wrong
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		if($wordBank == 'etest'){ 
			$query = sprintf("SELECT COUNT(id) FROM %s WHERE word = '%s'",
				mysql_real_escape_string($wordBank),
				mysql_real_escape_string($answer),
				mysql_real_escape_string($guess));
			$result = mysql_query($query) or die(mysql_error());
			list($value) = mysql_fetch_row($result);
			if($value > 1){
				$query = sprintf("SELECT id FROM %s WHERE word = '%s' AND answer_id = '%s'",
					mysql_real_escape_string($wordBank),				
					mysql_real_escape_string($guess),
					mysql_real_escape_string($answerID));
				$result = mysql_query($query) or die(mysql_error());
				list($value) = mysql_fetch_row($result);
			}else{
				$query = sprintf("SELECT id FROM %s WHERE word = '%s'",
					mysql_real_escape_string($wordBank),				
					mysql_real_escape_string($guess));
				$result = mysql_query($query) or die(mysql_error());
				list($value) = mysql_fetch_row($result);				
			}
			return $value;
		}elseif($wordBank == 'jtest'){
			$query = sprintf("SELECT COUNT(id) FROM %s WHERE word = '%s' OR reading = '%s'",
				mysql_real_escape_string($wordBank),
				mysql_real_escape_string($answer),
				mysql_real_escape_string($guess));
			$result = mysql_query($query) or die(mysql_error());
			list($value) = mysql_fetch_row($result);
			//echo "count:$value||";
			if($value >1){
				$query = sprintf("SELECT id FROM %s WHERE word = '%s' AND reading = '%s'",
					mysql_real_escape_string($wordBank),
					mysql_real_escape_string($answer),
					mysql_real_escape_string($guess));
				$result = mysql_query($query) or die(mysql_error());
				list($value) = mysql_fetch_row($result);				
			}else{
				$query = sprintf("SELECT id FROM %s WHERE word = '%s' OR reading ='%s'",
					mysql_real_escape_string($wordBank),
					mysql_real_escape_string($answer),
					mysql_real_escape_string($guess));
				$result = mysql_query($query) or die(mysql_error());
				list($value) = mysql_fetch_row($result);
			}			
			return $value;
		}
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);		
		return $value;
	}
	function getAnswerIDVocab($ID, $wordBank){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);		
			$query = sprintf("SELECT answer_id FROM %s WHERE id = '%s'",
				mysql_real_escape_string($wordBank),		
				mysql_real_escape_string($ID));					
			$result = mysql_query($query) or die(mysql_error());
			list($value) = mysql_fetch_row($result);			
			return $value;		
	}
	function getRandomWords($quantity, $wordBank, $answerID, $userID, $element){
		include_once 'stats.php';
		include 'config.php';
		$cvset = getSkill('cvset', $userID);
		$vStyle = getSkill('vStyle', $userID);
		$cvsetLv = getSkill($cvset . '_'.$vStyle.'_lv', $userID);				
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		mysql_query("SET NAMES UTF8");//Once upon a time I forgot this and Kanji-->hiragana choices showed up as "???"
		//need answer id
		//select choice from word_for_sentence_answers WHERE NOT id = 'answerId'
		
		$query = sprintf("SELECT %s,id FROM %s WHERE NOT id = '%s' AND $cvset !=0 AND $cvset <='%s' ORDER BY RAND() LIMIT %s",
			mysql_real_escape_string($element),
			mysql_real_escape_string($wordBank),
			mysql_real_escape_string($answerID),
			mysql_real_escape_string($cvsetLv),			
			mysql_real_escape_string($quantity));
		$result = mysql_query($query)or die(mysql_error());//$result is prob array of addresses to locations specified by query
		$i=0;
		while($row = mysql_fetch_array($result)){
			$value[$i]['id'] = $row['id'];
			$value[$i][$element] = $row[$element];
			$i++;
		}
		//for($i=0;$i<$quantity;$i++){
			//$value[$i]=mysql_fetch_row($result);/*everytime it fetches the row, adds it to array...*/ //fetch probably goes through each location of $result array
		//}
		//print_r($value);
		return $value;
	}
	function getQuizWordID($userID, $wType){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die(error_log('Error connecting to mysql'));
		mysql_select_db($dbname);	
		$cvset = getSkill('cvset',$userID);
		//error_log($wType);
		if($cvset == 'hirkat' || $cvset == 'katakana'){if( $wType != 'audioK' && $wType != 'audioR' && $wType != 'audioE'){ $wType == 'kanjiRE'; setSkill('vstyle',$userID,'kanjiRE');}}
		$j =0;
		$lv = getRanLv($cvset, $userID);//works
		do{
			if($wType == 'kanjiH'){
				$r = mysql_query("SELECT count(*) FROM jtest WHERE $cvset =$lv AND word != reading");
				$d = mysql_fetch_row($r);
				$rand = mt_rand(0,$d[0] - 1);
				$query = sprintf("SELECT id,$cvset FROM jtest WHERE $cvset ='%s' AND word != reading LIMIT $rand, 1",			
					mysql_real_escape_string($lv));
			}else if($wType == 'kanjiRE' || $wType == 'kanjiE' || $wType == 'engK' || $wType == 'engKR' || $wType == 'audioR' || $wType == 'audioK' || $wType == 'audioE'){
				$query = sprintf("SELECT id,$cvset FROM jtest WHERE $cvset ='%s' ORDER BY RAND() LIMIT 1",
					mysql_real_escape_string($lv));
			}
			$result = mysql_query($query) or error_log("Query Error:<br />File: words.php<br />Function: getQuizWordID()<br />Line:200<br />Mysql Error:".mysql_error());
			$question = mysql_fetch_array($result);
			$_SESSION['wordLv'] = $question[$cvset];
			$j++;
			//if($question['id'] !='' && $_SESSION['prevID'] != $question['id']){$lv++;}
			$lv++;
		}while($question['id'] =='' || $_SESSION['prevID'] == $question['id']); //incr if kanjiH and first levels contain no kanji
		$_SESSION['prevID'] = $question['id'];
		return $question['id'];	
	}
	function getRanLv($cvset, $userID){
		include_once('stats.php');
		$vStyle = getSkill('vStyle',$userID);
		$cvsetMxLv = getDeckInfo($cvset,'levels');
		$mxLv = getSkill($cvset . "_$vStyle"."_lv", $userID);
		$prob = .5;//prob to make next quiz word a word from the current level. reinforces new learning.
		if($mxLv >= $cvsetMxLv){
			$mxLv = $cvsetMxLv;
			$prob = 1 / $mxLv;
		}

		$tmin = 0;
		$tmax = $prob*100;
		$rn = mt_rand(0,25);
		for($n=0; $n <3; $n++){
			$rn += mt_rand(0,25);
		}
		$returned = FALSE;
		$j=0;
		$i = $mxLv;
		do{ //occasional errors on this. It times out.
			/*error_log(" words.php getRanLv()<br />
				rn $rn<br />
				tmin $tmin<br />
				tmax $tmax<br />
				j $j<br />
				i(mxLv) $i<br />");*/
			if($rn > $tmin && $rn<=$tmax){
				if($i<=0){return 1;
				}else{ return $i;}
			}else{
				$tmin = $tmax;
				$t = (100-$tmax)*($prob);
				$tmax += round($t);
			}
			
			$j++;
			$i--;
		}while($i > 1);
		return 1;//failsafe
	}
	function noRepeat(){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);	
		$cvset = getSkill('cvset',$userID);
		$query = sprintf("SELECT id FROM jtest WHERE $cvset !=0 AND $cvset <='%s' AND word != reading ORDER BY RAND() LIMIT 1",
			mysql_real_escape_string(getSkill($cvset . "_lv", $userID)));
			$result = mysql_query($query) or die(mysql_error());
		list($question) = mysql_fetch_row($result);
		//echo $question;
		$word = getWord($question, 'jtest');
		$r = getReading($question, 'jtest');
		//echo "$word::$r </br>";
		if(getWord($question, 'jtest') == getReading($question, 'jtest')){
			echo "Found duplicate word($word) and reading($r), finding another </br>";
			noRepeat();
		}else{
			return $question;
		}
	}
	function getWord($Id, $wordBank){
		mysql_query("SET NAMES UTF8");//without this, can;t fetch		
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT word FROM %s WHERE id = '%s'",
			mysql_real_escape_string($wordBank),	
			mysql_real_escape_string($Id));
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		//print_r($value);
		return $value;	
	}
	function getKanji($answerID, $wordbank){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);		
		$query = sprintf("SELECT word FROM %s WHERE id='%s' or reading = '%s' or word='%s' ORDER BY RAND() LIMIT 1",
			mysql_real_escape_string($wordbank),
			mysql_real_escape_string($answerID),
			mysql_real_escape_string($answerID),
			mysql_real_escape_string($answerID));
		$result = mysql_query($query) or die(mysql_error());
		list($reading) = mysql_fetch_row($result);
		return $reading;	
	}
	function getReading($answerID, $wordbank){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);		
		$query = sprintf("SELECT reading FROM %s WHERE id='%s' or word = '%s' ORDER BY RAND() LIMIT 1",
			mysql_real_escape_string($wordbank),
			mysql_real_escape_string($answerID),
			mysql_real_escape_string($answerID));
		$result = mysql_query($query) or error_log(mysql_error());
		list($reading) = mysql_fetch_row($result);
		return $reading;	
	}
	function getWordInfo($field, $word, $wordbank){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);		
		$query = sprintf("SELECT %s FROM %s WHERE id='%s' or word = '%s' or reading = '%s' ORDER BY RAND() LIMIT 1",
			mysql_real_escape_string($field),
			mysql_real_escape_string($wordbank),
			mysql_real_escape_string($word),
			mysql_real_escape_string($word),
			mysql_real_escape_string($word));
		$result = mysql_query($query) or die(mysql_error());
		list($element) = mysql_fetch_row($result);
		return $element;	
	}

/*****************************************************************************************************
*******************************************FILL IN THE BLANK******************************************
*****************************************************************************************************/
	function getFIBAdjWordChoices($phraseID, $userID, $choiceQ, $table, $col, $customize){					
		$rChoices = getFIBAdjWordRChoices($phraseID, $col, $table);
		$choices = getFIBAdjWordChoicesFill($rChoices, $choiceQ, $userID, $table, $customize);		
		return $choices;	
	}
	function getFIBAdjWordRChoices($phraseID, $col, $table){
		include 'config.php';
		require_once 'blanks.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);				
		$blankQ = getBlanks($phraseID, 'fib_word');
		//get each blanks' answer
		$query = sprintf("SELECT %s FROM %s WHERE element_id ='%s'",			
			mysql_real_escape_string($col),
			mysql_real_escape_string($table),
			mysql_real_escape_string($phraseID));
		$result = mysql_query($query) or die(mysql_error());
		for($i=0;$i<$blankQ;$i++){
			list($value[$i])=mysql_fetch_row($result);/*everytime it fetches the row, adds it to array...*/ //fetch probably goes through each location of $result array
		}
		return $value;
	}
	function getFIBAdjWordChoicesFill($answers, $choiceQ, $userID, $table, $customize){
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$cvset = getSkill('cvset',$userID);
		$vsLv = getSkill($cvset . '_lv', $userID);
		$answersQ = count($answers);
		for($i=0; $i<$answersQ; $i++){
			$where_arr[$i] = "choice !='" . $answers[$i] . "'";
		}
		if($customize == ''){
			$query = sprintf("SELECT distinct choice FROM %s WHERE " . implode(' AND ', $where_arr) . "ORDER BY RAND() LIMIT $choiceQ",			
				mysql_real_escape_string($table),
				mysql_real_escape_string($cvset),				
				mysql_real_escape_string($vsLv));
			$result = mysql_query($query) or die('Error at getFIBAdjWordChoicesFill1: </br>SQL msg: ' . mysql_error());
		}else{
			$query = sprintf("SELECT distinct choice FROM %s WHERE $customize AND " . implode(' AND ', $where_arr) . " ORDER BY RAND() LIMIT $choiceQ",
				mysql_real_escape_string($table),
				mysql_real_escape_string($cvset),				
				mysql_real_escape_string($vsLv));
			$result = mysql_query($query) or die('Error at getFIBAdjWordChoicesFill2: </br>SQL msg: ' . mysql_error());
		}
		$i=0;
		while($row=mysql_fetch_array($result)){
			$value[$i] = $row['choice'];
			$i++;
		}	
		$numbers = array_rand(range(0, count($value)-1), $answersQ);
		if($answersQ>1){
			for($i=0; $i<$answersQ; $i++){
				$j=$numbers[$i];
				$value[$j]=$answers[$i];
			}
		}else{
			$value[$numbers]=$answers[0];
		}
		return $value;
	}
	function getFIBAdjWordAnswers($phraseID, $table){
		$answers = getFIBAdjWordRChoices($phraseID, 'answer', $table);
		return $answers;
	}
	function getTypeId($type, $table){		
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT id FROM $table WHERE element = '%s'",
			mysql_real_escape_string($type));
		$result = mysql_query($query) or die(mysql_error());
		list($typeId) = mysql_fetch_row($result);		
		return $typeId;
	}
/*****************************************************************************************************
*******************************************  SENTENCES  **********************************************
*****************************************************************************************************/
	function isSentencesDeck($cvset){//Checks db if current deck is a sentence deck or not, returns 1,0 (false)
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$sql = sprintf("SELECT sentences_deck FROM decks WHERE short_name ='%s' LIMIT 1",
				mysql_real_escape_string($cvset));
		$query = mysql_query($sql) or die("Error: isSentencesDeck(). Couldn't select sentence_deck</br>".mysql_error());
		list($isSentencesDeck) = mysql_fetch_array($query);//list because single result
		return $isSentencesDeck;
	}
	function getSentences($jWordId){
	//echo $jWordId.'<---id';
		$jSentenceIdStr = getSentenceIds($jWordId);
		if($jSentenceIdStr==null){return "no sentences";}
		$sentencePairMDArr = getSentencesPairs($jSentenceIdStr);
		return $sentencePairMDArr;
	}
	//---------------------------------------------------------------------
	//Have Japanese Word Id, Get Sentence Id's For This Word
	//---------------------------------------------------------------------
	function getSentenceIds($jWordId){		
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$sql = sprintf("SELECT sentence_id_str FROM jtest WHERE id='%s' LIMIT 1",
				mysql_real_escape_string($jWordId));
		$query = mysql_query($sql) or die("Error: getSentenceIds. jWordId=$jWordId</br>".mysql_error());
		list($sentenceIdStr) = mysql_fetch_array($query);//list because single result
		//Prepare Id String for Next Query
		$sentenceIdArrTemp = explode(",",$sentenceIdStr, -1); //takes off the last delimiter
		$sentenceIDStr = implode(",",$sentenceIdArrTemp);
		return $sentenceIDStr;
	}
	//---------------------------------------------------------------------
	//Get Sentence Pair Japanese/English
	//---------------------------------------------------------------------
	function getSentencesPairs($jSentenceIdStr){
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		//Get Japanese Component
		$j = mysql_real_escape_string($jSentenceIdStr);
		$sql = sprintf("SELECT count(id) FROM j_mc_sentences WHERE id in(".$j.") ORDER BY RAND() limit 5"); //Only Displaying 5 Currently
		$query = mysql_query($sql) or die("Error: getSentenceIds.2 $j</br>".mysql_error());
		list($count) = mysql_fetch_row($query);
		if($count>0){
			$sql = sprintf("SELECT * FROM j_mc_sentences WHERE id in(".$j.") ORDER BY RAND() limit 5"); //Only Displaying 5 Currently
			$query = mysql_query($sql) or die("Error: getSentenceIds.2 $j</br>".mysql_error());
			while($row=mysql_fetch_array($query)){
				$sentencePair[]['japanese'] = $row['sentence'];
				$transIdTemp[] = $row['translation_id'];
			}
			//Get English Component
			$transId = implode(",",$transIdTemp);//take the elements of the array and concat them with ,
			$sql = "SELECT sentence FROM e_mc_sentences WHERE id in(".$transId.") ORDER BY FIELD(id,".$transId.")"; //need order by field in order to get these english matched up with their proper japanese counterpart
			$query = mysql_query($sql) or die("Error: getSentenceIds.3</br>".mysql_error());
			//Assemble MDArray Containing Sentence Pairs array[0]=>array[japanese]=>~~,[english]=>~~
			for($i=0;$row=mysql_fetch_array($query);$i++){
				$sentencePair[$i]['english'] = $row['sentence'];
			}
			return $sentencePair;//I can return like this right?
		}else{
			return "no sentences";
		}
	}
	function verbFormTempExists($v){
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT COUNT(id) FROM verb_forms_temp WHERE dictionary = '%s'",
			mysql_real_escape_string($v));
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		if($value < 1){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	function verbFormExists($v){
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT COUNT(id) FROM verb_forms WHERE dictionary = '%s'",
			mysql_real_escape_string($v));
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		if($value < 1){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	function getGroup($v){
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT vgroup FROM verb_forms WHERE dictionary = '%s'",
			mysql_real_escape_string($v));
		$result = mysql_query($query) or error_log("Error in getGroup()".mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	function getTopVerbs($q){
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		
		$sql = sprintf("SELECT * FROM verb_forms ORDER BY search_count DESC limit %s",
			mysql_real_escape_string($q));
		$result = mysql_query($sql) or error_log("Error in getGroup()".mysql_error());
		$i=0;
		if($result){
			while($row=mysql_fetch_array($result)){
				$array[$i]['v'] = $row['dictionary'];
				$array[$i]['cnt'] = $row['search_count'];
				$array[$i]['g'] = $row['vgroup'];
				$i++;
			}
		}
		return $array;
	}
	function getRecentVerbs($q){
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		
		$sql = sprintf("SELECT dictionary,vgroup FROM verb_forms ORDER BY id DESC limit %s",
			mysql_real_escape_string($q));
		$result = mysql_query($sql) or error_log("Error in getRecentVerbs()".mysql_error());
		$i=0;
		if($result){
			while($row=mysql_fetch_array($result)){
				$array[$i]['v'] = $row['dictionary'];
				$array[$i]['g'] = $row['vgroup'];
				$i++;
			}
		}
		return $array;
	}
	function getChoiceQ($pLv){
		if($pLv == 1){
			return 2;
		}else if($pLv > 1 && $pLv < 5){
			return 3;
		}else if(pLv == 5){
			return 4;
		}else
			return 5;
	}
?>