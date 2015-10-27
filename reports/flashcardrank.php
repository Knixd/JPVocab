<?php
	/******************************************************************************************************************/
	function getUN($uid, $db){
		$stmt = $db->query("SELECT * FROM users WHERE id=$uid");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	include($_SERVER['DOCUMENT_ROOT']."/pdc.php");
	$stmt = $db->query('SELECT * FROM user_stats WHERE stat_id=14 AND value > 100 ORDER BY value DESC');
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$j=count($results);
?>
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8 table-responsive">
		<h1>Flashcard Rankings</h1>
		<p>Increase your rank by answering more flashcards correctly.</p>
		<table class="table table-striped table-hover">
			<?= ($_GET['player'] != $_SESSION['username'] ? 
														"<a href='http://www.JPVocab.com/player.php?player=".$_GET['player']."&report=summary'>".$_GET['player'] . '</a> is ' : 
														'You are ') . 'ranked <b>'. ordinal($ranktfca).'</b>';?>
			<tr>
				<th class="text-center">Rank</th>
				<th>User</th>
				<th class="text-center">#</th>
			</tr><?php
			$n= ($ranktfca-4 <=0 ? 0 : $ranktfca-4);
			$j = $n+5;
			for($n;$n<$j;$n++){
				try{
					$user=getUN($results[$n]['user_id'],$db);
				} catch(PDOException $ex){ 
					//echo "Username error <br />";
				}
				if($results[$n+1]['value']==$results[$n]['value']){//handle ties
					$rank=$n+2;
				} else{
					$rank=$n+1;
				}
				if($results[$n]['value']!=0){
					if($n<=2){
						$fcolor="red";
						$fweight="bold";
					} else{
						$fcolor="default";
						$fweight="default";
					}
					if($user[0]['username'] == $_GET['player']){ $ifThisUser = "class='info'";}else{ $ifThisUser = "";}
					echo '<tr '.$ifThisUser.'><td style="text-align:center; font-weight:'.$fweight.';">'.$rank.'</td><td style=font-weight:bold; "><a style="color:'.$fcolor.';" href="http://www.JPVocab.com/player.php?player='.$user[0]['username'].'&report=summary">'.$user[0]['username']. '</a></td><td style="text-align:center; font-weight:'.$fweight.';">'.$results[$n]['value'].'</td></tr>';
				} elseif($results[$n]['user_id']!=0){//if for some reason a bogus user_id gets into user_stats
					echo '<tr><td style="text-align:center; color:grey;">N/A</td><td style="font-weight:bold; color:grey; font-size:80%;"><a href="http://www.JPVocab.com/player.php?player='.$user[0]['username'].'">'.$user[0]['username']. '</a></td><td style="text-align:center; color:grey;">'.$results[$n]['value'].'</td></tr>';
				}
			}?>
		</table>
	</div>
	<div class="col-md-2"></div>
</div>
	