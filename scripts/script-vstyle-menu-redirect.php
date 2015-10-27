<?php
	session_start();
	include '../stats.php';
	include '../words.php';
	$userID = getUserID($_SESSION['username']);
	//echo "Before switch ".$_POST['vstyle']."<br />";
	if($_POST['vstyle']=='kanji'){
		$vstyle = 'kanjiRE';
		setSkill('vstyle', $userID, 'kanjiRE');
	}else if($_POST['vstyle']=='audio'){
		$vstyle = 'audioR';
		setSkill('vstyle', $userID, 'audioR');
	}else{
		//$vstyle = 'kanjiRE';
	}
	//echo "After switch $vstyle <br />";
	//echo "getting skill just after setting it $userID".getSkill('vStyle',$userID) ."<br />";
	//echo $vstyle;
	//$cvset = $_POST['cv']; //without this post, super dumb to get the uid through
	//$userID = $_POST['u'];
	include '../include/vstyle-menus.php';
	include '../mc_get.php';
	//echo "from mc_get into RE $userID".getSkill('vStyle',$userID) ."<br />";
	include '../include/kanjiRE.php';
?>