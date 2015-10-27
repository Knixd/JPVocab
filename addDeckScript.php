<?php
	include 'adminScripts.php';
	
	$dBase = $_POST['displayName'];
	$sBase = $_POST['shortName'];
	addDeckSkills($dBase, $sBase);
	//Adds leveling system for each reading style
	addVStyleDeckSkill($sBase,$dBase,'kanjiRE');
	addVStyleDeckSkill($sBase,$dBase,'kanjiH');
	addVStyleDeckSkill($sBase,$dBase,'kanjiE');
	addVStyleDeckSkill($sBase,$dBase,'engKR');
	addVStyleDeckSkill($sBase,$dBase,'engH');
	addVStyleDeckSkill($sBase,$dBase,'engK');
	echo "Added 6 Leveling Skills Definitions for users for later when they buy the reading styles! <br />";	
	
	$description  = $_POST['description'];
	$sentencesDeck  = $_POST['sentencesDeck'];
	$gold_price = $_POST['gold_price'];
	$diamond_price = $_POST['diamond_price'];
	$diamond_list_price = $_POST['diamond_list_price'];
	$type = $_POST['type'];
	$picture = $_POST['pictureExt'];
	$size = $_POST['size'];
	$levels = $_POST['levels'];
	$details = $_POST['details'];
	addVocabColum($sBase);	//Add associated column to word banks
	echo "Added <b>$sBase</b> column to Vocab <b>Word Banks</b> <br />";
	
	addDeck($dBase, $sBase,$description,$gold_price,$diamond_price,$diamond_list_price,$type,$picture,$size,$levels,$details,$sentencesDeck);//Add deck to 'decks'
	echo "Added <b>$sBase and $dBase</b> to <b>Decks</b> table. <br />";
	
	echo "Added description, gold price and the other details. <br />";
?>