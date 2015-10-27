<?php
	if(substr($vstyle,0,5)=='kanji'){
		$vstyleDropDownActive = '日本語';
		$vstyleListItem1 = 'Audio Flashcards <span class="glyphicon glyphicon-volume-up marg-top-5" aria-hidden="true"></span>';
		$vstyleListItem1Value = 'audio';
	}else if(substr($vstyle,0,5)=='audio'){
		$vstyleDropDownActive = 'Audio Flashcards <span class="glyphicon glyphicon-volume-up marg-top-5" aria-hidden="true"></span>';
		$vstyleListItem1 = '日本語';
		$vstyleListItem1Value = 'kanji';
	}
	//$vstyle = getSkill('vstyle',$userID);
?>
<div class="row">
	<div class="col-sm-12">
		<ul class="nav nav-pills">
			<!--If user owns this vocabulary style -->
			<li role="presentation" class="dropdown">
				<a class="dropdown-toggle bg-primary" data-toggle="dropdown" href="#" role="button" aria-expanded="false"><?php
					echo $vstyleDropDownActive ;?><span class="caret"></span>
				</a>
				<ul class="dropdown-menu text-center" role="menu">
					<li><a href="#" onClick="changeVstyleMenu('<?php echo $cvset."','".$userID."','".$vstyleListItem1Value;?>')"><?php echo $vstyleListItem1;?></a></li>
				</ul>
			</li><?php
			  if(substr($vstyle, 0,5)=='kanji'){
				  include("vstyle-kanji.php");
			  }else if(substr($vstyle,0,5)=='audio'){
				  include("vstyle-audio.php");
			  }
			  ?>
		</ul>
	</div>
</div>