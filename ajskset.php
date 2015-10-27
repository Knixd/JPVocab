<?php
	session_start();
	$_SESSION['streak']=0;
	include 'stats.php';
	$userId = getUserID($_SESSION['username']);
	$skillName = $_POST['skillName'];
	$value = $_POST['value'];
	echo "received $skillName and $value";
	setSkill($skillName, $userId, $value);
	//echo "<p>ajskset:  $skillName || $value || $userId</p>";
	echo "<span style='color:#e2e5e9; font-size:0.9em;'>Updated!</span>";
	//header("location: quiz.php");
	//if($skillName == 'vStyle' && substr($value,0,5)=='kanji'){
	//include 'display_mc.php';
	include 'mc_get.php';
	include 'include/kanjiRE.php';
?>   