<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8');	
	include_once("../include/check_login.php");
	if($user_ok == false){header("location: ../restricted.php");}
	include_once('../stats.php');
	include_once('../words.php');
	//$userId = getUserID($_SESSION['username']);
	
	//setSkill('cvset', $userId, getDeckShortName($_POST['deckId'], ''));
	//setSkill('vStyle', $userId, $_POST['vStyle']);
	$d = getDeckRow($_POST['deckId']);
?>
<!--********************RIGHT COLUMN-*********************************-->
<div class="page-header no-marg-top-23">
	<h2><i class="fa fa-list-ol"></i> <?= $d['display_name'];?></h2></div>
</div>
<div class="col-xs-12">
<? include('../Japanese-Vocabulary/deckDetail.php');?>
	<table class="table table-bordered table-hover table-condensed unselectable">
		<tr>
			<th>Card #</th>
			<th class="text-center">Japanese</th>
			<th class="text-center">English</th>
			<th class="text-center">Level</th>
		</tr><?php
		$top =getAllVocab($d['short_name'], $d['levels'], $d['size']);
		foreach($top as $row => $word){?>
			<tr>
				<td class="text-center"><small><?php echo $word['q'];?></small></td>
				<td class="text-center" >
					<abbr title="<?= $word['reading'];?>"><?= $word['kanji'];?></abbr>
				</td>
				<td class="text-left">
					<?= getWord(getOppositeWordID($word['id'],'jtest'),'etest'); ?>
				</td>
				<td class="text-center"><?= $word['lv'];?></td>
			</tr><?php
		}?>
	</table>