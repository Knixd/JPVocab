<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8');	
	include_once("../include/check_login.php");
	if($user_ok == false){header("location: ../restricted.php");}
	include_once('../stats.php');
	$userId = getUserID($_SESSION['username']);
	
	setSkill('cvset', $userId, getDeckShortName($_POST['deckId'], ''));
	setSkill('vStyle', $userId, $_POST['vStyle']);
	
	if(getSkill('cvset',$userId)!= getDeckInfoFromId($_POST['deckId'],'short_name') || getSkill('vStyle',$userId)!= $_POST['vStyle']){
		echo "sent id " .$_POST['deckId'] . "</br>".getDeckShortName($_POST['deckId'], '');
		echo getSkill('cvset',$userId)."</br>";
		echo getSkill('vStyle',$userId)."</br>";
	} else{
		echo "change_success";
	}
?>