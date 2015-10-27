<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8');	
	include_once("../include/check_login.php");
	if($user_ok == false){header("location: ../restricted.php");}
	include_once('../stats.php');
	include("../pdc.php");
	
	$skill = $_POST['el'];
	$price = $_POST['val'];
	$uid = getUserID(preg_replace('#[^a-z0-9]#i', '',$_POST['user']));
	$sessUid = getUserID(preg_replace('#[^a-z0-9]#i', '',$_SESSION['username']));
	$gold = getStat('gold',$uid);
	//double check post is same as session username
	if($uid != $sessUid){
		echo "error";
		die();
	}else if($gold<$price){
		echo "error";
		die();
	}else{
		setStat($skill,$uid,getStat($skill,$uid)+1);
		setStat('gold',$uid,getStat('gold',$uid)-$price);
		echo "success";
	}
	//double check enough gold
	//increase skill
	//decrease gold
?>