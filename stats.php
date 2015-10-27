<?php	
	function getUserID($sessionUsername){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT id FROM users WHERE UPPER(username) = UPPER('%s')",
				mysql_real_escape_string($sessionUsername)); //%s is a placeholder. It exists to save confusion with quotes or double quotes. In this case it is immediately assigned to the sessions 'username'
		$result = mysql_query($query);
		list($userID) = mysql_fetch_row($result);
		return $userID;
	}
	function isAdmin($sessionUsername){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT is_admin FROM users WHERE UPPER(username) = UPPER('%s')",
				mysql_real_escape_string($sessionUsername)); 
		$result = mysql_query($query);
		list($isAdmin) = mysql_fetch_row($result);
		return ($isAdmin=='1' ? TRUE : FALSE);
	}
	function getUserDetail($userID, $field){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT %s FROM users WHERE id = '%s'",
				mysql_real_escape_string($field),
				mysql_real_escape_string($userID)); 
		$result = mysql_query($query);
		list($string) = mysql_fetch_row($result);
		return $string;
	}
	function setUserDetail($detail, $value, $userID){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("UPDATE users SET %s = '%s' WHERE id = '%s'",
				mysql_real_escape_string($detail),
				mysql_real_escape_string($value),
				mysql_real_escape_string($userID)); 
		$result = mysql_query($query) or error_log("Couldn't setUserDetail $field for userID: $userId");
	}
/***********************************************************************************************
*********************************************    STATS    **************************************
***********************************************************************************************/	
	function getStat($statName, $userID){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createStatIfNotExists($statName,$userID);
		$query = sprintf("SELECT value FROM user_stats WHERE stat_id = (SELECT id FROM stats WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
				mysql_real_escape_string($statName),
				mysql_real_escape_string($statName),
				mysql_real_escape_string($userID));
		$result = mysql_query($query) or error_log("Query Error<br /> File: stats.php <br />Function: getStat()<br />Line: 26<br />Mysql Error: ".mysql_error());
		list($value) = mysql_fetch_row($result);			
		return $value;
	}
	function setStat($statName,$userID,$value){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createStatIfNotExists($statName,$userID);		
			$user_tbl = 'user_stats';
			$tbl = 'stats';
			$tbl_id = 'stat_id';			
			$query = sprintf("UPDATE user_stats SET value = '%s' WHERE stat_id = (SELECT id FROM stats WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
					mysql_real_escape_string($value),
					mysql_real_escape_string($statName),
					mysql_real_escape_string($statName),
					mysql_real_escape_string($userID));
			$result = mysql_query($query) or error_log("Query Error<br /> File: stats.php <br />Function: setStat()<br />Line: 44<br />Mysql Msg:".mysql_error());			
	}
	//may be createIfNotExists existing in other files, change to createStatIfNotExists
	function createStatIfNotExists($statName,$userID){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT value FROM user_stats WHERE stat_id = (SELECT id FROM stats WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
				mysql_real_escape_string($statName),
				mysql_real_escape_string($statName),
				mysql_real_escape_string($userID));
		$result = mysql_query($query) or die(mysql_error());
		list($count) = mysql_fetch_row($result);
		//echo "$count values of $statName <br />";
		if($count == ""){								
			//the stat doesn't exist; insert it into the database					
			$query = sprintf("INSERT INTO user_stats(stat_id,user_id,value) VALUES ((SELECT id FROM stats WHERE display_name = '%s' OR short_name = '%s'),'%s','%s')",
				mysql_real_escape_string($statName),
				mysql_real_escape_string($statName),
				mysql_real_escape_string($userID),
				'0');
			mysql_query($query) or error_log(mysql_error());
		}
	}
	function getStatInfo($statName, $field){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createStatIfNotExists($statName,$userID);
		$query = sprintf("SELECT %s FROM stats WHERE id ='%s' OR short_name = '%s'",
				mysql_real_escape_string($field),
				mysql_real_escape_string($statName),
				mysql_real_escape_string($statName));
		$result = mysql_query($query) or error_log("Query Error<br /> File: stats.php <br />Function: getStatInfo()<br />Line: 26<br />Mysql Error: ".mysql_error());
		list($value) = mysql_fetch_row($result);			
		return $value;
	}
	function getScore($scoresStatName, $userID){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createStatIfNotExists($scoresStatName,$userID);
		$query = sprintf("SELECT value FROM user_stats WHERE stat_id = (SELECT id FROM stats WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
				mysql_real_escape_string($scoresStatName),
				mysql_real_escape_string($scoresStatName),
				mysql_real_escape_string($userID));
		$result = mysql_query($query) or error_log("Query Error<br /> File: stats.php <br />Function: getScore()<br />Line: 26<br />Mysql Error: ".mysql_error());
		list($value) = mysql_fetch_row($result); 
		$value = statToScore($value);//db col is in int. so convert for display
		return $value;
	}
	function setScore($scoresStatName,$userID,$value){
		$statValue = scoreToStat($value);//db col is in int.so convert for update
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createStatIfNotExists($scoresStatName,$userID);		
			$user_tbl = 'user_stats';
			$tbl = 'stats';
			$tbl_id = 'stat_id';			
			$query = sprintf("UPDATE user_stats SET value = '%s' WHERE stat_id = (SELECT id FROM stats WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
					mysql_real_escape_string($statValue),
					mysql_real_escape_string($scoresStatName),
					mysql_real_escape_string($scoresStatName),
					mysql_real_escape_string($userID));
			$result = mysql_query($query) or error_log("Query Error<br /> File: stats.php <br />Function: setStat()<br />Line: 44<br />Mysql Msg:".mysql_error());			
	}
	function statToScore($stat){
		return $stat/1000;
	}
	function scoreToStat($score){
		return $score*1000;
	}
	function getAchiev($title, $userID){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createAchievIfNotExists($title,$userID);
		$query = sprintf("SELECT value FROM user_achievements WHERE aid = (SELECT id FROM achievements WHERE title = '%s' ) AND user_id = '%s'",
				mysql_real_escape_string($title),
				mysql_real_escape_string($userID));
		$result = mysql_query($query) or error_log("Query Error<br /> File: stats.php <br />Function: getAchiev()<br />Line: 26<br />Mysql Error: ".mysql_error());
		list($value) = mysql_fetch_row($result);			
		return $value;
	}
	function getAchievInfo($title, $field){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		//createAchievIfNotExists($title,$userID);
		$query = sprintf("SELECT %s FROM achievements WHERE id = (SELECT id FROM achievements WHERE title = '%s' )",
				mysql_real_escape_string($field),
				mysql_real_escape_string($title));
		$result = mysql_query($query) or error_log("Query Error<br /> File: stats.php <br />Function: getAchievInfo()<br />Line: 26<br />Mysql Error: ".mysql_error());
		list($value) = mysql_fetch_row($result);			
		return $value;
	}
	function setAchiev($title,$userID,$value){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createAchievIfNotExists($title,$userID);		
			$user_tbl = 'user_stats';
			$tbl = 'stats';
			$tbl_id = 'stat_id';			
			$query = sprintf("UPDATE user_achievements SET value = '%s' WHERE aid = (SELECT id FROM achievements WHERE title = '%s' ) AND user_id = '%s'",
					mysql_real_escape_string($value),
					mysql_real_escape_string($title),
					mysql_real_escape_string($userID));
			$result = mysql_query($query) or error_log("Query Error<br /> File: stats.php <br />Function: setStat()<br />Line: 44<br />Mysql Msg:".mysql_error());			
	}
	//may be createIfNotExists existing in other files, change to createStatIfNotExists
	function createAchievIfNotExists($title,$userID){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT value FROM user_achievements WHERE aid = (SELECT id FROM achievements WHERE title = '%s' ) AND user_id = '%s'",
				mysql_real_escape_string($title),
				mysql_real_escape_string($userID));
		$result = mysql_query($query) or die(mysql_error());
		list($count) = mysql_fetch_row($result);
		//echo "$count values of $title <br />";
		if($count == ""){								
			//the stat doesn't exist; insert it into the database					
			$query = sprintf("INSERT INTO user_achievements(aid,user_id,value) VALUES ((SELECT id FROM achievements WHERE title = '%s'),'%s','%s')",
				mysql_real_escape_string($title),
				mysql_real_escape_string($userID),
				'0');
			mysql_query($query) or error_log(mysql_error());
		}
	}
	function dropUGhostDeck($deckId, $userId){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("DELETE FROM user_decks WHERE user_id = '%s' AND deck_id = '%s'",
				mysql_real_escape_string($deckId),
				mysql_real_escape_string($userId));
		$result = mysql_query($query) or die(mysql_error());
	}
	function incrStat($stat, $userId){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createStatIfNotExists($stat,$userId);
		$userStat = getStat($stat,$userId);
		$userStat++;
		$query = sprintf("UPDATE user_stats SET value = '%s' WHERE stat_id = (SELECT id FROM stats WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
				mysql_real_escape_string($userStat),
				mysql_real_escape_string($stat),
				mysql_real_escape_string($stat),
				mysql_real_escape_string($userId));
		$result = mysql_query($query);	
	}
	function incrUserDeckStat($stat, $dkN, $vstyle, $userId){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$userDeckStat = getUserDeckStat($stat,$dkN,$vstyle,$userId);
		$userDeckStat++;
		$query = sprintf("UPDATE user_decks SET stats_correct = '%s' WHERE deck_id = (SELECT id FROM decks WHERE short_name = '%s' OR display_name = '%s') AND vstyle_id = (SELECT id FROM vstyles WHERE vstyle_description ='%s' OR vstyle='%s') AND user_id = '%s'",
				mysql_real_escape_string($userDeckStat),
				mysql_real_escape_string($dkN),
				mysql_real_escape_string($dkN),
				mysql_real_escape_string($vstyle),
				mysql_real_escape_string($vstyle),
				mysql_real_escape_string($userId));
		$result = mysql_query($query);	
	}
	function getPrice($sElement, $sMeth){
		//echo $sElement . $sMeth . "ss</br>";
		include 'config.php';		
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT $sMeth,sale_on,dmd_sale FROM prices WHERE short_name = '%s'",
				mysql_real_escape_string($sElement));
		$result = mysql_query($query) or die(mysql_error());
		$value = mysql_fetch_array($result);
		if($value['sale_on'] == 1 && $sMeth == 'dmd'){ $price = $value['dmd_sale'];}
		else{ $price = $value[$sMeth];}
		return $price;
	}
/***********************************************************************************************
*********************************************    SKILLS    **************************************
***********************************************************************************************/	
	function getSkill($skillName, $userId){			
			//echo "getSkill skillname $skillName <br />";
			include 'config.php';			
			$conn = mysql_connect($dbhost,$dbuser,$dbpass)
					or die('Error connecting to mysql');
			mysql_select_db($dbname);
			createSkillIfNotExists($skillName,$userId);
			$query = sprintf("SELECT value FROM user_skills WHERE skill_id = (SELECT id FROM skills WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
					mysql_real_escape_string($skillName),
					mysql_real_escape_string($skillName),
					mysql_real_escape_string($userId));
			$result = mysql_query($query) or die(mysql_error());
			list($value) = mysql_fetch_row($result);					
			return $value;
	}
	function setSkill($skillName,$userID,$value){
			include 'config.php';
			$conn = mysql_connect($dbhost,$dbuser,$dbpass)
					or die('Error connecting to mysql');
			mysql_select_db($dbname);
			//echo "$skillName $userID $value"; //don't keep echo's, messes up ajax.responseText
			createSkillIfNotExists($skillName,$userID);
			$user_tbl = 'user_skills';
			$tbl = 'skills';
			$tbl_id = 'skill_id';			
			$query = sprintf("UPDATE $user_tbl SET value = '%s' WHERE $tbl_id = (SELECT id FROM $tbl WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
					mysql_real_escape_string($value),
					mysql_real_escape_string($skillName),
					mysql_real_escape_string($skillName),
					mysql_real_escape_string($userID));
			$result = mysql_query($query) or error_log("setSkill error".mysql_error());			
	}
	//may be createIfNotExists existing in other files, change to createStatIfNotExists
	function createSkillIfNotExists($skillName,$userID){
			include 'config.php';
			$conn = mysql_connect($dbhost,$dbuser,$dbpass)
					or die('Error connecting to mysql');
			mysql_select_db($dbname);
			$query = sprintf("SELECT value FROM user_skills WHERE skill_id = (SELECT id FROM skills WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
					mysql_real_escape_string($skillName),
					mysql_real_escape_string($skillName),
					mysql_real_escape_string($userID));
			$result = mysql_query($query) or die(mysql_error());
			list($count) = mysql_fetch_row($result);
			if($count == ""){			
				$query = sprintf("INSERT INTO user_skills(skill_id,user_id,value) VALUES ((SELECT id FROM skills WHERE display_name = '%s' OR short_name = '%s'),'%s','%s')",
					mysql_real_escape_string($skillName),
					mysql_real_escape_string($skillName),
					mysql_real_escape_string($userID),
					'1');
				mysql_query($query) or die(mysql_error());
			}
	}
/***********************************************************************************************
*********************************************    VOCAB    **************************************
***********************************************************************************************/	
	function getVocStat($vocabSet, $userID){
			include 'config.php';			
			$conn = mysql_connect($dbhost,$dbuser,$dbpass)
					or die('Error connecting to mysql');
			mysql_select_db($dbname);
			createVocIfNotExists($vocabSet,$userID);
			$query = sprintf("SELECT value FROM user_skills WHERE skill_id = (SELECT id FROM skills WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
					mysql_real_escape_string($vocabSet),
					mysql_real_escape_string($vocabSet),
					mysql_real_escape_string($userID));
			$result = mysql_query($query);
			list($value) = mysql_fetch_row($result);			
			return $value;
	}
	function setVocStat($vocabSet,$userID,$value){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createVocIfNotExists($vocabSet,$userID);
		$query = sprintf("UPDATE user_skills SET value = '%s' WHERE skill_id = (SELECT id FROM skills WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
				mysql_real_escape_string($value),
				mysql_real_escape_string($vocabSet),
				mysql_real_escape_string($vocabSet),
				mysql_real_escape_string($userID));
		$result = mysql_query($query);
	}
	function createVocIfNotExists($vocabSet,$userID){
		$default = 'null';
		if($vocabSet == 'cvset' || $vocabSet == 'Current Vocab Set'){
			$default = 'minna';
		}elseif($vocabSet =='minna'){
			$default = '1';
		}
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT value FROM user_skills WHERE skill_id = (SELECT id FROM skills WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
				mysql_real_escape_string($vocabSet),
				mysql_real_escape_string($vocabSet),
				mysql_real_escape_string($userID));
		$result = mysql_query($query) or die(mysql_error());
		list($count) = mysql_fetch_row($result);
		
		if($count == ""){								
			//the stat doesn't exist; insert it into the database					
			$query = sprintf("INSERT INTO user_skills(skill_id,user_id,value) VALUES ((SELECT id FROM skills WHERE display_name = '%s' OR short_name = '%s'),'%s','%s')",
				mysql_real_escape_string($vocabSet),
				mysql_real_escape_string($vocabSet),
				mysql_real_escape_string($userID),
				mysql_real_escape_string($default));
			mysql_query($query) or die(mysql_error());
		}
	}
	function getVSDisplayName($shortN){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT display_name FROM skills WHERE short_name = '%s'",
				mysql_real_escape_string($shortN));
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}	
/***********************************************************************************************
*********************************************    LEVELING **************************************
***********************************************************************************************/	
	function setLevelUp($userID, $ref){ //$ref could be quiz, fib, particles other drills
		$confMultiplier = 10;
		$wordsperlv = 40;
		$minPracNewWords = 2;
		$minPracOldWords = 1;
		$curConf=getStat('conf', $userID);//overall conf stat
		$curLv = getStat('lv', $userID);
		$maxConf = getStat('maxconf', $userID);
		//If Assigning Skills Based on Type Usage, then Find Adjust Skill Appropriately
		if($ref == 'quiz' || 'particle'){
			//cvset details
			$cvset = getSkill('cvset',$userID);
			$vstyle = getSkill('vstyle',$userID);
			$skillLv = getSkill($cvset . '_'.$vstyle.'_lv', $userID);
			$skillProg=getSkill($cvset . '_'.$vstyle. '_prog', $userID);
			$skillProgMax = getSkill($cvset . '_'.$vstyle. '_prog_max', $userID);
			
			//calc if prog >prog_max
			$confChange = getLevelChange($curConf, $curLv, $maxConf);//overall conf sat
			$skillChange = getLevelChange($skillProg, $skillLv, $skillProgMax);//cvset skill
			//Adjust Level's Appropriately For Overall Confidence Lv, and Current Skill Lv
			if($confChange == 'same' && $skillChange == 'same'){ //no change
				return false;
			}//THEY ARE LV 1 AND FELL BELOW ZERO, RESET TO Lv.1 CONF. 0
			elseif($confChange == 'reset'){ 
				setStat('Confidence', $userID, 0,'stat');			
			}elseif($skillChange == 'reset'){
				setSkill($cvset . '_'.$vstyle.'_prog', $userID, 0);
			}//OVERALL CONF. - LEVEL UP/DOWN EVENT OCCURED
			elseif($confChange != 'same'){
				if($confChange == 'up'){
					setStat('lv', $userID, $curLv+1,'stat');
					setStat('Confidence', $userID, 0,'stat');			
					$newMaxConf = ($wordsperlv*$confMultiplier)+(10*$curLv);
					//$newMaxConf = ($wordsperlv*3*$confMultiplier)+(2*$confMultiplier*((($curLv+1)*$confMultiplier)*$wordsperlv)); //new words 3 times, old words 2 times	
					setStat('maxconf', $userID, $newMaxConf,'stat');
				}elseif($confChange == 'down'){//
					setStat('lv', $userID, $curLv-1,'stat');			
					//$newMaxConf = ($wordsperlv*3*$confMultiplier)+(2*$confMultiplier*((($curLv)*$confMultiplier)*$wordsperlv)); //new words 3 times, old words 2 times	
					$newMaxConf = ($wordsperlv*$confMultiplier)+(10*$curLv);
					setStat('maxconf', $userID, $newMaxConf,'stat');
					setStat('conf', $userID, $newMaxConf+$curConf,'stat');
				}
			}//SKILL - LEVEL UP/DOWN EVENT OCCURED
			elseif($skillChange != 'same'){
				if($skillChange == 'up'){			
					if($skillLv >= getDeckInfo($cvset, 'levels')){//Check if their deck is at max level
						//set lv to max and lower cvset conf to max
						setSkill($cvset . '_'.$vstyle. '_lv', $userID, getDeckInfo($cvset, 'levels'));
						setSkill($cvset . '_'.$vstyle. '_prog', $userID, $skillProgMax);
						return False;
					}else{
						$newProgMax = ($wordsperlv*$minPracNewWords)+($minPracOldWords*((($skillLv+1))*$wordsperlv)); //new words 3 times, old words 2 times	
						setSkill($cvset . '_'.$vstyle. '_lv', $userID, $skillLv+1); //for new vStyle leveling-> $cvset . '_'.$vStyle.'_lv'
						setSkill($cvset . '_'.$vstyle. '_prog', $userID, 0);			
						setSkill($cvset . '_'.$vstyle. '_prog_max', $userID, $newProgMax);
					}
				}elseif($skillChange == 'down'){			
					$newProgMax = ($wordsperlv*$minPracNewWords)+($minPracOldWords*(($skillLv)*$wordsperlv));
					setSkill($cvset . '_'.$vstyle. '_lv', $userID, $skillLv-1);								
					setSkill($cvset . '_'.$vstyle. '_prog', $userID, $newProgMax+$skillProg);
					setSkill($cvset . '_'.$vstyle. '_prog_max', $userID, $newProgMax);			
				}
			}
			return true;
		}//end quiz lvup
		return true;
	}
	function getLevelChange($Prog, $curLv, $ProgMax){//See If Current Progress Calls For A Level Change +||-
		//Get Max Progress for Current level		
		$lvChange = 'same';				
		if($Prog >= $ProgMax){
			$lvChange = 'up';	
		} elseif($Prog<0 AND $curLv != 1){ 
			$lvChange = 'down';					
		}elseif($Prog<0 AND $curLv <=1){
			$lvChange = 'reset';
		}
		return $lvChange;
	}
/***********************************************************************************************
*********************************************    DECKS    **************************************
***********************************************************************************************/
	function getDeckDisplay($deckId, $name){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT display_name FROM decks WHERE id = '%s' OR short_name = '%s'",
			mysql_real_escape_string($deckId),
			mysql_real_escape_string($name));
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	function getDeckShortName($deckId, $name){	
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT short_name FROM decks WHERE id = '%s' OR display_name = '%s'",
			mysql_real_escape_string($deckId),
			mysql_real_escape_string($name));
		$result = mysql_query($query) or error_log("getDeckShortName error ".mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	function getDeckRow($d){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT * FROM decks WHERE id = '%s' OR short_name = '%s' limit 1",
			mysql_real_escape_string($d),
			mysql_real_escape_string($d));
		$result = mysql_query($query) or error_log(mysql_error());
		$row = mysql_fetch_assoc($result);
		return $row;
	}
	function getDeckInfo($deckN, $field){//takes name as input
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT %s FROM decks WHERE id = (SELECT id FROM decks WHERE short_name = '%s' OR display_name = '%s')",
			mysql_real_escape_string($field),
			mysql_real_escape_string($deckN),
			mysql_real_escape_string($deckN));
		$result = mysql_query($query) or error_log("getDeckInfo error: ".mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	function getDeckFullUrl($deckN){//takes name as input
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT display_url,type FROM decks WHERE id = (SELECT id FROM decks WHERE short_name = '%s' OR display_name = '%s')",
			mysql_real_escape_string($deckN),
			mysql_real_escape_string($deckN));
		$query = mysql_query($query) or error_log("getDeckFullUrl error: ".mysql_error());
		$result = mysql_fetch_assoc($query);
		//print_r($value);
		return "http://www.jpvocab.com/Japanese-Vocabulary/deck.php?t=".$result['type']."&d=".$result['display_url'];
	}
	
	function getDeckIDFromURL($url){//takes name as input
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT id FROM decks WHERE display_url = '%s'",
			mysql_real_escape_string($url));
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		return $value;
	}
	function getDeckInfoFromId($deckId, $field){ //takes id as input
		//echo $deckId . '---"'. $field.'" in getDeckInfoFromId </br>';
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT %s FROM decks WHERE id = '%s'",
			mysql_real_escape_string($field),
			mysql_real_escape_string($deckId));
		$result = mysql_query($query) or error_log(mysql_error());
		list($value) = mysql_fetch_row($result);
		//echo "returning $value </br>";
		return $value;
	}
	function getTopVocab($d, $q){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT word,reading,id FROM jtest WHERE %s = '1' OR  %s = '2' ORDER BY %s ASC,reading ASC LIMIT %s",
			mysql_real_escape_string($d),
			mysql_real_escape_string($d),
			mysql_real_escape_string($d),
			mysql_real_escape_string($q));
		$result = mysql_query($query) or error_log(mysql_error());
		for($i=0; $row = mysql_fetch_array($result);$i++){
			$array[$i]['q']=$i+1;
			$array[$i]['kanji'] = $row['word'];
			$array[$i]['reading'] = $row['reading'];
			$array[$i]['id'] = $row['id'];
		}
		return $array;
	}
	function getAllVocab($d, $q,$max){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT word,reading,id,%s FROM jtest WHERE %s <= '%s' ORDER BY %s ASC,reading ASC LIMIT %s",
			mysql_real_escape_string($d),
			mysql_real_escape_string($d),
			mysql_real_escape_string($q),
			mysql_real_escape_string($d),
			mysql_real_escape_string($max));
		$result = mysql_query($query) or error_log(mysql_error());
		for($i=0; $row = mysql_fetch_array($result);$i++){
			$array[$i]['q']=$i+1;
			$array[$i]['kanji'] = $row['word'];
			$array[$i]['reading'] = $row['reading'];
			$array[$i]['id'] = $row['id'];
			$array[$i]['lv'] = $row[$d];
		}
		return $array;
	}
	function setDeck($deck, $userId, $value){ //change $deck to receive $deckId
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createDeckIfNotExists($deck, $userId);
		$query = sprintf("UPDATE user_decks SET owned = '%s' WHERE user_id = '%s' AND deck_id = (SELECT id FROM decks WHERE display_name = '%s' OR short_name = '%s')",
			'1',
			mysql_real_escape_string($userId),
			mysql_real_escape_string($deck),
			mysql_real_escape_string($deck));
		$result = mysql_query($query);
	}
	function countDeckOwners($deck){ //change $deck to receive $deckId
		include("pdc.php");
		try{
			$stmt=$db->prepare("SELECT  *
								FROM users
								WHERE activated = 1
								AND id IN
								(
								SELECT user_id
								FROM   user_decks 
								WHERE  owned = '1'
								AND deck_id = 
									(
									SELECT id 
									FROM decks 
									WHERE display_name = :deckDN 
									OR short_name = :deckSN
									)
								)"
							);
			$stmt->bindParam(':deckDN',$deck,PDO::PARAM_STR);
			$stmt->bindParam(':deckSN',$deck,PDO::PARAM_STR);
			$stmt->execute();
			$number_of_owners = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor(); //gets multiple rows
			error_log(sizeOf($number_of_owners));
		} catch(PDOException $ex){
			error_log("Couldn't count deck owners <br />".$ex);
		}
		return $number_of_owners;
	}
	function countTypeOwners($type){ //change $deck to receive $deckId
		include("pdc.php");
		try{
			$stmt=$db->prepare("SELECT  *
								FROM users
								WHERE activated = 1
								AND id IN
								(
								SELECT user_id
								FROM   user_decks 
								WHERE  owned = '1'
								AND deck_id = 
									(
									SELECT DISTINCT(id) 
									FROM decks 
									WHERE type = :type 
									)
								)"
							);
			$stmt->bindParam(':type',$type,PDO::PARAM_STR);
			$stmt->execute();
			$type_owners = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor(); //gets multiple rows
			error_log(sizeOf($type_owners));
		} catch(PDOException $ex){
			error_log("Couldn't count deck owners <br />".$ex);
		}
		return $type_owners;
	}
	function createDeckIfNotExists($deck, $userId){//change $deck to receive $deckId
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT owned FROM user_decks WHERE deck_id = (SELECT id FROM decks WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s'",
			mysql_real_escape_string($deck),
			mysql_real_escape_string($deck),
			mysql_real_escape_string($userId));
		$result = mysql_query($query) or die(mysql_error());
		list($count) = mysql_fetch_row($result);
		if($count == ""){
			//echo "nocount||";
			$query = sprintf("INSERT INTO user_decks(deck_id, user_id, owned) VALUES ((SELECT id FROM decks WHERE display_name = '%s' OR short_name = '%s'), '%s', '%s')",
				mysql_real_escape_string($deck),
				mysql_real_escape_string($deck),
				mysql_real_escape_string($userId),
				'0');
			mysql_query($query) or die(mysql_error());
		}		
	}
	function getUserDecks($userId){
		include 'config.php';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass)
			or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT deck_id FROM user_decks WHERE owned = '%s' AND user_id = '%s' ORDER BY (SELECT display_name FROM decks WHERE id = 'deck_id') ASC",
			'1',
			mysql_real_escape_string($userId));
		$result = mysql_query($query) or die(mysql_error());		
		while($row = mysql_fetch_array($result)){			
			$userDeckIds[] = $row['deck_id'];
		}
		return $userDeckIds;
	}
	function getUserDeckStat($stat,$dkN,$vstyle,$userID){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		//createUserDeckStatIfNotExists($statName,$userID);
		$query = sprintf("SELECT %s FROM user_decks WHERE deck_id = (SELECT id FROM decks WHERE short_name = '%s' OR display_name = '%s') AND vstyle_id = (SELECT id FROM vstyles WHERE vstyle_description ='%s' OR vstyle='%s') AND user_id = '%s'",
				mysql_real_escape_string($stat),
				mysql_real_escape_string($dkN),
				mysql_real_escape_string($dkN),
				mysql_real_escape_string($vstyle),
				mysql_real_escape_string($vstyle),
				mysql_real_escape_string($userID));
		$result = mysql_query($query) or die(mysql_error());
		list($value) = mysql_fetch_row($result);
		//echo $value ."</br>";
		return $value;
	}
	function countUserDecks($userId){
		include 'config.php';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass)
			or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT count(DISTINCT deck_id) FROM user_decks WHERE owned = '%s' AND user_id = '%s' ORDER BY (SELECT display_name FROM decks WHERE id = deck_id) ASC",
			'1',
			mysql_real_escape_string($userId));
		$result = mysql_query($query) or die(error_log("Query Error.<br />File: stats.php <br />Function countUserDecks()<br />Line:452<br />Mysql error msg: " . mysql_error()));
		list($count) = mysql_fetch_row($result);
		error_log("decks: $count");
		return $count;
	}
	function countUserVStyle($userId){
		include 'config.php';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass)
			or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT count(vstyle_id) FROM user_decks WHERE owned = '%s' AND user_id = '%s'",
			'1',
			mysql_real_escape_string($userId));
		$result = mysql_query($query) or error_log("Query Error.<br />File: stats.php <br />Function countUserVStyle()<br />Line:465<br />Mysql error msg: " . mysql_error());		
		list($count) = mysql_fetch_row($result);
		return $count;
	}
	function getOwnershipStatus($deckId, $userId){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createDeckIfNotExists(getDeckInfoFromId($deckId, 'short_name'), $userId);
		$query = sprintf("SELECT count(id) FROM user_decks WHERE deck_id = '%s' AND user_id = '%s' AND owned = '1'",
			mysql_real_escape_string($deckId),
			mysql_real_escape_string($userId));
		$result = mysql_query($query) or die(mysql_error());
		list($count) = mysql_fetch_row($result);
		if($count == "" || $count == 0){
			return false;
		}else{
			return true;
		}
	}
	function getAllDecks(){
		include 'config.php';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass)
			or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT id FROM decks ORDER BY display_name ASC");			
		$typeResult = mysql_query($query) or error_log("<br />Query Error<br />File: stats.php<br />Function and Line:getAllDecks() Line:502<br />Mysql_error:".mysql_error());
		//assign type values to associative array
		while($row = mysql_fetch_array($typeResult)){	//create associative array here					
			$deckIds[] = $row['id'];
		}
		return $deckIds;
	}
	function getSomeDecks($type){
		include 'config.php';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass)
			or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT * FROM decks WHERE type = '%s' ORDER BY display_name ASC",
			mysql_real_escape_string($type));
		$typeResult = mysql_query($query) or error_log("<br />Query Error<br />File: stats.php<br />Function and Line:getSomeDecks() Line:502<br />Mysql_error:".mysql_error());
		//assign type values to associative array
		for($i=0;$row = mysql_fetch_array($typeResult);$i++){	//create associative array here					
			$deckIds[$i]['id'] = $row['id'];
			$deckIds[$i]['picture'] = $row['picture'];
			$deckIds[$i]['display_name'] = $row['display_name'];
			$deckIds[$i]['display_url'] = $row['display_url'];
			$deckIds[$i]['gold_price'] = $row['gold_price'];
			$deckIds[$i]['diamond_price'] = $row['diamond_price'];
			$deckIds[$i]['description'] = $row['description'];
			$deckIds[$i]['is_sentences'] = $row['sentences_deck'];
		}
		return $deckIds;
	}
	function getAllDeckTypes(){
		include 'config.php';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass)
			or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT DISTINCT type FROM decks ORDER BY display_name ASC");			
		$typeResult = mysql_query($query) or die(mysql_error());		
		//assign type values to associative array
		while($row = mysql_fetch_array($typeResult)){	//create associative array here					
			$deckTypes[] = $row['type'];
		}
		return $deckTypes;
	}
	function getTypeIds($type){
		include 'config.php';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass)
			or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT id FROM decks where type = '%s' ORDER BY display_name ASC",
			mysql_real_escape_string($type));
		$results = mysql_query($query) or die(mysql_error());			
		while($row = mysql_fetch_array($results)){	//create associative array here					
			$typeIds[] = $row['id'];
		}
		return $typeIds;
	}//$currency is short_name or display_name
	function buyDeck($deckSN, $userId, $currency){//possibly change $deckSN to receive $deckId, more proper?
		if(setMoneyBoughtDeck($deckSN, $userId, $currency) == 'success'){
			$result = setOwnershipDeck($deckSN, $userId);
			incrStat('ttldks',$userId);
		}
	}
	function setMoneyBoughtDeck($deckSN, $userId, $currency){
		//Assign funds and price for chosen currency
		if($currency == "gc"){
			$userFunds = getStat($currency, $userId);
			$deckPrice = getDeckInfo($deckSN, 'gold_price');//change this to getPrice() later - after deck prices added to tbl
		}elseif($currency == "dmd"){
			$userFunds = getStat('Diamonds', $userId);
			$deckPrice = getDeckInfo($deckSN, 'diamond_price');
		}
		$balance = $userFunds - $deckPrice;
		if($balance >=0 ){
			if($currency == "gc"){ 
				$currencyDisplay = 'Gold';
			}elseif($currency == "dmd"){
				$currencyDisplay = 'Diamonds';
			}
			setStat($currencyDisplay, $userId, $balance);
			return 'success';
		}elseif($balance<0){
			echo "Error: Couldn't purchase deck, insufficient funds";
			return;
		}
	}
	function getMoneyBalances($sElement, $sMethod, $userId){
		//Assign funds and price for chosen currency
		$userFunds = getStat($sMethod, $userId);
		$elementP = getPrice($sElement, $sMethod);
		$balance = $userFunds - $elementP;
		//echo "$balance = $userFunds - $elementP</br>";
		if($balance >=0 ){
			return 'sufficient';
		}elseif($balance<0){
			return 'Insufficient Funds';
		}
	}
	function setMoneyBalances($sElement, $sMethod, $userId){
		$userFunds = getStat($sMethod, $userId);
		$elementP = getPrice($sElement, $sMethod);
		$balance = $userFunds - $elementP;
		if($balance >=0 ){
			setStat($sMethod, $userId, $balance);
			return 'success';
		}
	}
	function setOwnershipDeck($deckSN, $userId){//essentially, adds skill to skills table
		setDeck($deckSN, $userId, '1');//sets ownership of deck in user_decks table
		setOwnershipvStyle($deckSN, 'kanjiRE', $userId); //gives default vstyle
	}
	
	function sortDeckArrDN($decksArr){
		foreach($decksArr as $key=>$value){
			$tempAr[getDeckInfoFromId($value,'display_name')] = $value;
		}
		ksort($tempAr);
		return$tempAr;
	}
/***********************************************************************************************
*******************************************    vSTYLES    **************************************
***********************************************************************************************/
	function getVstyleId($deckSN, $vStyle){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createUDeckVStyleIfNotExists($deckSN, $userId, $vStyle);
		$query = sprintf("SELECT id FROM vstyles WHERE vstyle = '%s'",
			mysql_real_escape_string($vStyle));
		$result = mysql_query($query) or die(mysql_error());
		list($count) = mysql_fetch_row($result);
		return $count;
	}
	function getVstyleInfo($deckSN, $field){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT $field FROM vstyles WHERE vstyle = '%s'",
			mysql_real_escape_string($deckSN));
		$result = mysql_query($query) or die(mysql_error());
		list($count) = mysql_fetch_row($result);
		return $count;
	}
	function getOwnershipDeckVstyle($deckSN, $vStyle, $userId){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createUDeckVStyleIfNotExists($deckSN, $userId, $vStyle);
		$query = sprintf("SELECT owned FROM user_decks WHERE deck_id = (SELECT id FROM decks WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s' AND vstyle_id = (SELECT id FROM vstyles WHERE vstyle_description ='%s' OR vstyle='%s')",
			mysql_real_escape_string($deckSN),
			mysql_real_escape_string($deckSN),
			mysql_real_escape_string($userId),
			mysql_real_escape_string($vStyle),
			mysql_real_escape_string($vStyle));
		$result = mysql_query($query) or error_log("getOwnershipDeckVstyle error".mysql_error());
		list($count) = mysql_fetch_row($result);
		//echo "<p>Does $userId have $deckSN $vStyle owned? $count |";
		if($count == 1){
			//echo "returning true";
			return TRUE;
		}else{
			//echo "returning false</p>";
			return FALSE;}
	}
	function setOwnershipvStyle($deckSN, $vStyle, $userId){
		//find the id's of these in the skills table and insert into user_skills table
		$sProg = $deckSN ."_".$vStyle."_prog";
		$sLevel = $deckSN ."_".$vStyle."_lv";			
		$sProgMax = $deckSN ."_".$vStyle."_prog_max";
		setUDecksVStyle($deckSN, $userId, $vStyle);//updates user_decks ownership of vstyle
		setSkill($sProg, $userId, '1'); //skill needs to exist in skill table first
		setSkill($sLevel, $userId, '1');
		setSkill($sProgMax, $userId, '100'); //later, create getInitSkillMax() to grab the deck/skill's lv 1 cap.
	}
	function setUDecksVStyle($deckSN,$userId,$vStyle){
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		createUDeckVStyleIfNotExists($deckSN, $userId, $vStyle);
		$query = sprintf("UPDATE user_decks SET owned = '%s' WHERE user_id = '%s' AND deck_id = (SELECT id FROM decks WHERE display_name = '%s' OR short_name = '%s') AND vstyle_id = (SELECT id FROM vstyles WHERE vstyle_description ='%s' OR vstyle='%s')",
			'1',
			mysql_real_escape_string($userId),
			mysql_real_escape_string($deckSN),
			mysql_real_escape_string($deckSN),
			mysql_real_escape_string($vStyle),
			mysql_real_escape_string($vStyle));
		$result = mysql_query($query) or die(mysql_error());
	}
	function createUDeckVStyleIfNotExists($deckSN, $userId, $vStyle){//change $deck to receive $deckId
		//echo "create||";
		include 'config.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT owned FROM user_decks WHERE deck_id = (SELECT id FROM decks WHERE display_name = '%s' OR short_name = '%s') AND user_id = '%s' AND vstyle_id = (SELECT id FROM vstyles WHERE vstyle_description ='%s' OR vstyle='%s')",
			mysql_real_escape_string($deckSN),
			mysql_real_escape_string($deckSN),
			mysql_real_escape_string($userId),
			mysql_real_escape_string($vStyle),
			mysql_real_escape_string($vStyle));
		$result = mysql_query($query) or die(mysql_error());
		list($count) = mysql_fetch_row($result);
		if($count == ""){
			//echo "nocount $deckSN, $userId, $vStyle ||";
			$query = sprintf("INSERT INTO user_decks(deck_id, vstyle_id, user_id, owned) VALUES ((SELECT id FROM decks WHERE display_name = '%s' OR short_name = '%s'), (SELECT id FROM vstyles WHERE vstyle_description ='%s' OR vstyle='%s'),'%s', '%s')",
				mysql_real_escape_string($deckSN),
				mysql_real_escape_string($deckSN),
				mysql_real_escape_string($vStyle),
				mysql_real_escape_string($vStyle),
				mysql_real_escape_string($userId),
				'0');
			mysql_query($query) or die(mysql_error());
		}		
	}
	function buyDeckvStyle($deckSN, $vStyle, $userId, $sMethod){//possibly change $deckSN to receive $deckId, more proper?
		if(getOwnershipDeckVstyle($deckSN, $vStyle, $userId) == FALSE){
			if(getMoneyBalances($vStyle, $sMethod, $userId) == 'sufficient'){ 
				setOwnershipvStyle($deckSN, $vStyle, $userId);
				setMoneyBalances($vStyle, $sMethod, $userId);
				incrStat('ttlpvstyl',$userId);
				return "success";
			}else if(setMoneyBalances($vStyle, $sMethod, $userId) != 'sufficient'){
				return "Insufficient funds";
			}
		}else if(getOwnershipDeckVstyle($deckSN, $vStyle, $userId) == TRUE){
			return "already owned";
		}
	}
	function getDeckVstylesAss($deckId){
		$vStyles['kanjiRE']=getDeckInfoFromId($deckId, 'kanjiRE');
		$vStyles['kanjiH']=getDeckInfoFromId($deckId, 'kanjiH');
		$vStyles['kanjiE']=getDeckInfoFromId($deckId, 'kanjiE');
		$vStyles['engKR']=getDeckInfoFromId($deckId, 'engKR');
		$vStyles['engH']=getDeckInfoFromId($deckId, 'engH');
		$vStyles['engK']=getDeckInfoFromId($deckId, 'engK');
		
		return $vStyles;
	}
	function getAffilInfo($affilId, $element){
		include 'config.php';			
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$query = sprintf("SELECT %s FROM affiliates WHERE id = '%s'",
				mysql_real_escape_string($element),
				mysql_real_escape_string($affilId));
		$result = mysql_query($query);
		list($value) = mysql_fetch_row($result) or error_log('Error: getAffilInfo().'.mysql_error());			
		return $value;
	}
	/* NUMBER FUNCTIONS*/
	function ordinal($number) {
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if ((($number % 100) >= 11) && (($number%100) <= 13))
			return $number. 'th';
		else
			return $number. $ends[$number % 10];
	}
	function isHKid($id){
		if(getDeckInfoFromId($id,'short_name') == 'hirkat' OR getDeckInfoFromId($id,'short_name') == 'katakana'){
			return TRUE;
		}else
			return FALSE;
	}
/***********************************************************************************************
*******************************************    Click Choice ************************************
***********************************************************************************************/
	function getClickChoiceQuizArray($ttlQ,$classification,$difficulty){
		include 'pdc.php';
		//echo "<meta charset='utf-8'>"; !!! If you try to debug and echo anything out, must echo html charset first!!!!!!!
		try {
			$stmt = $db->prepare("SELECT * FROM click_choice INNER JOIN cchoice_tags ON click_choice.id = cchoice_tags.cchoice_ID WHERE cchoice_tags.grammar_tag = :classification AND cchoice_tags.difficulty_tag=:diff");
			//$stmt = $db->prepare("SELECT * FROM click_choice WHERE classification=:classification AND difficulty=:diff");
			$stmt->execute(array(':classification' => $classification, ':diff' => $difficulty));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//Randomly select $ttlQ and return it
			error_log(count($rows));
			if(count($rows)<=$ttlQ){
				return $rows;
			}else{
				$shuffledRows = shuffle_assoc($rows);
				$finalRows = array_slice($shuffledRows,0,$ttlQ);
				return $finalRows;
			}
		} catch(PDOException $ex) {
			echo "An Error occured!"; //user friendly message
			error_log($ex);
			error_log(mysql_error());
		}
	}
	function clickChoiceInfoToQuestions($infoArr){
		require_once 'words.php';
		$qaArr = array();
		for($i=0; $i<count($infoArr);$i++){
			$choicesStr = "";
			$temp = explode(',',$infoArr[$i]['choices'],-1);
			shuffle($temp);
			$choicesStr .= '<div class="btn-group">';
			for($j=0;$j<count($temp);$j++){
				$q = $i+1; $c = $j+1;
				$idStr = "$q.$c";
				if($temp[$j]==$infoArr[$i]['correct']){$infoArr[$i]['correctid']=$idStr;}
				$choicesStr .= " <button type='button' class='btn btn-info btn-xs' id='$idStr' style='font-size:1.0em; margin-right:0.2em;' title='".getReading($temp[$j],'jtest')."' onClick='setUserResponse($q,$idStr)'>".$temp[$j]."</button>"; //id's of choices are 0.0;0.1;0.2
			}
			$choicesStr .= '</div>';
			$qaArr[$i]['question'] = str_replace("(choices)",$choicesStr,$infoArr[$i]['sentence']);
			$qaArr[$i]['correct'] = $infoArr[$i]['correct'];
			$qaArr[$i]['correctid'] = $infoArr[$i]['correctid'];
		}
		return $qaArr;
	}
	function shuffle_assoc($array){
		$shuffleKeys = array_keys($array);
		shuffle($shuffleKeys);
		$newArray = array();
		foreach($shuffleKeys as $key){
			$newArray[$key] = $array[$key];
		}
		return $newArray;
	}
	function getUserFCardRank($userID){
		include("pdc.php");
		try{
			$stmt=$db->query("SELECT  uo.*,
								(
								SELECT  COUNT(*)
								FROM    user_stats ui
								WHERE   (ui.value) >= (uo.value)
								AND ui.stat_id=14
								) AS rank
							FROM    user_stats uo
							WHERE user_id=$userID
							AND stat_id=14");
			$urank = $stmt->fetchALL(PDO::FETCH_ASSOC);
		} catch(PDOException $ex){
			echo "Couldn't get rank <br />";
		}
		return ($urank[0]['value'] != 0 ? $urank[0]['rank'] : 'N/A');
	}
	function getOnlineUsers(){
		include("pdc.php");
		try{
			$stmt=$db->prepare("SELECT  id,username
								FROM    users b
								WHERE   last_act >= now() - INTERVAL 10 MINUTE");
			//error_log(strtotime('-5 minutes',time()) . ' ' . time());
			//$stmt->bindParam(':timeLimit',,PDO::PARAM_STR),);
			$stmt->execute();
			$uOnline = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
		/*$sth = $dbh->prepare('SELECT your_column FROM your_table WHERE column < :parameter');
		$sth->bindParam(':parameter', $your_variable, PDO::PARAM_STR);
		$sth->execute();*/
		
		} catch(PDOException $ex){
			echo "Couldn't get online users <br />";
		}
		return $uOnline;
	}
	function getOfflineUsers(){
		include("pdc.php");
		try{
			$stmt=$db->prepare("SELECT  id,username
								FROM    users b
								WHERE   last_act < now() - INTERVAL 10 MINUTE
								AND activated = 1
								AND is_guest = 0
								ORDER BY last_login DESC");
			//error_log(strtotime('-5 minutes',time()) . ' ' . time());
			//$stmt->bindParam(':timeLimit',,PDO::PARAM_STR),);
			$stmt->execute();
			$uOffline = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $ex){
			echo "Couldn't get offline users <br />";
		}
		return $uOffline;
	}
	function getUsers(){
		include("pdc.php");
		try{
			$stmt=$db->prepare("SELECT  id
								FROM    users 
								WHERE   activated = 1");
			$stmt->execute();
			$u = $stmt->fetchAll(PDO::FETCH_COLUMN,0);
		//	print_r($u);
		} catch(PDOException $ex){
			echo "Couldn't get users <br />";
		}
		return $u;
	}
	function assignPVPRank($userIds){
		include("pdc.php");
		try{
			$stmt = $db->prepare('INSERT INTO user_pvp_rank 
										  SET user_id=:uid, pvp_rank=:pvprank');
			$i = 1;
			foreach($userIds as $id) {
				$stmt->execute(array(':uid' => $id, ':pvprank' => $i));
				$i++;
			}
		} catch(PDOException $ex){
			echo "Couldn't assign rank.";
		}
		//return $u;
	}
	function getPvpRank($uid){
		include("pdc.php");
		try{
			$stmt = $db->prepare('SELECT pvp_rank FROM user_pvp_rank WHERE user_id =:uid');
			$stmt->bindParam(':uid',$uid,PDO::PARAM_STR);
			$stmt->execute();
			$pvpRank = $stmt->fetchColumn();
		} catch(PDOException $ex){
			echo "Couldn't get pvp rank. $ex";
		}
		return $pvpRank;
	}
	function getPvpUI($pvpRank){
		include("pdc.php");
		try{
			$stmt = $db->prepare('SELECT user_id FROM user_pvp_rank WHERE pvp_rank =:val');
			$stmt->bindParam(':val',$pvpRank,PDO::PARAM_STR);
			$stmt->execute();
			$uid = $stmt->fetchColumn();
		} catch(PDOException $ex){
			echo "Couldn't get pvp rank. $ex";
		}
		return $uid;
	}
?>
