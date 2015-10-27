<?php
	//Defining Variables
	$vstyleDescr = getVstyleInfo($vstyle,'vstyle_description');
	$progPerc = round(100*((getSkill($cvset . '_' . $vstyle.'_prog',$userID))/((getSkill($cvset .'_' . $vstyle. '_prog_max',$userID)))),0);
	error_log("progPerc $progPerc");
	$percentLeft = 100 - $progPerc;
	if($vstyle == 'kanjiRE'){$progStyle = 'progress-bar-success';}
	elseif($vstyle == 'kanjiE'){$progStyle = 'progress-bar-warning';}
	elseif($vstyle == 'kanjiH'){$progStyle = 'progress-bar-danger';}
?>
	<div class="progress progress-striped " id="quizProgBar">
		<div class="progress-bar active <?= $progStyle;?>" role="progressbar" aria-valuenow="<?php echo $progPerc; ?>" aria-valuemin="0" aria-valuemax="100" style="min-width:2em; width: <?= $progPerc; ?>%;">
			<?= $progPerc; ?>% Completed
		</div>
		<div class="text-center"><small><?= $percentLeft; ?>% left until next level</small></div>
	</div>
