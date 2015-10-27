<?php
	session_start();	
	include '../stats.php';
	$t = $_POST['t'];
	$u = $_POST['u'];
	if($_POST['query']=='check'){
		$status = (getAchiev($t,$u)=='1' ? 'claimed' : 'not claimed');
		error_log("getAchiev..$t,$u.ss $status");
		echo $status;
	}else if($_POST['query']=='claim'){
		if($t =='dmd_reg_bonus'){
			setStat('dmd',$u,getStat('dmd',$u)+getAchievInfo($t,'reward'));
			setAchiev($t,$u,'1');
			echo "Success";
		}else if($t == 'submit_jlpt'){
			$j = $_POST['j'];
			setUserDetail('jlpt',$j,$u);
			setStat(getAchievInfo($t,'reward_type'),$u,getStat(getAchievInfo($t,'reward_type'),$u)+getAchievInfo($t,'reward'));
			setAchiev($t,$u,'1');
			echo "Success";
		}else{
			echo "Fail";
		}
	}
	error_log("nuthin".$_POST['query']);
?>