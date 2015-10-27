<?php
	session_start();	
	include '../stats.php';
	$userId = $_POST['userId'];
	$sMethod = $_POST['sMeth'];
	$vStyle = $_POST['vStyle'];
	$deckSN = $_POST['deckSN'];
	
	if(buyDeckvStyle($deckSN, $vStyle, $userId, $sMethod)=="success"){ 
		echo "successful purchase";
	}else{
		$result = buyDeckvStyle($deckSN, $vStyle, $userId, $sMethod);
		echo $result;
	}
?>