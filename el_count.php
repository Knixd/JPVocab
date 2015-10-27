<?php
header('Content-Type: text/html;charset=utf-8');	
	session_start();	
	require_once 'config.php';
	require_once 'stats.php';
	require_once 'words.php';
	$userID = getUserID($_SESSION['username']);							
	$cvset = getSkill('cvset',$userID);
	$minnaLv = $_GET['minna_lv'];
	$customize = "";
	if($_GET['type'] != 'any'){
		$optionId = getTypeId($_GET['type'], 'fib_types');			
		$customize .= "AND type_id = '$optionId' ";
	}if($_GET['v_tense'] != 'any'){ 
		$optionId = getTypeId($_GET['v_tense'], 'fib_v_tenses');						
		$customize .= "AND verb_tense_id = '$optionId' ";
	}if($_GET['politeness'] != 'any'){
		$optionId = getTypeId($_GET['politeness'], 'fib_politenesses');						
		$customize .= "AND politeness_id = '$optionId' ";
	}if($_GET['theme'] != 'any'){
		$optionId = getTypeId($_GET['theme'], 'fib_themes');						
		$customize .= "AND theme_id = '$optionId' ";
	}if($_GET['format'] != 'any'){
		$optionId = getTypeId($_GET['format'], 'fib_formats');						
		$customize .= "AND format_id = '$optionId' ";
	}if($_GET['minna_lv'] != 'any'){
		$customize .= "AND difficulty = '$minnaLv'";
	}
	$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
	mysql_select_db($dbname);
	mysql_query("SET NAMES UTF8");
	//echo "$customize </br>";
	$query = sprintf("SELECT COUNT(id) FROM fib_word WHERE reference = 'minna' $customize ORDER BY RAND() LIMIT 1");
	$result = mysql_query($query) or die(mysql_error());
	list($fibWord) = mysql_fetch_row($result);
	if($fibWord < '5'){
		echo 
		"<td>
			$fibWord Available.			
		</td>
		<td>
			Not enough sentences yet! Sorry!</br>
			Please choose another combo!
		</td>";
	}elseif($fibWord>100){
		echo
		"<td>
			More than 100 Sentences Available!
		</td>
		<td>
			<input class='selectionBtn' type='submit' name='action' value='Go!'/>					
		</td>";
	}elseif($fibWord>50){
		echo 
		"<td>
			More than 50 Sentences Available.
		</td>
		<td>
			<input class='selectionBtn' type='submit' name='action' value='Go!' />					
		</td>";
	}else{
		echo
		"<td>
			$fibWord Available.
		</td>
		<td>
			<input class='selectionBtn' type='submit' name='action' value='Go!'/>					
		</td>";
	}
?>