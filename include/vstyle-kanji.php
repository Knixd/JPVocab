<div class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-exchange"></i><span class="sr-only">Change</span><span class="hidden-xs caret"></span></span></a>
		<!--********* SHOW ALL AVAILABLE QUIZ MODE STYLES***************-->
		<ul class="dropdown-menu">
			<li class="dropdown-header">Switch <b>Quiz Modes</b></li>
			<!--*****************EAZY IS OWNED OR NOT OWNED*************-->
			<li><?
				if(getOwnershipDeckVstyle($cvset,'kanjiRE',$userID)==TRUE && getDeckInfo($cvset, 'kanjiRE')==1){?>
					<li 
						role="presentation" 
						class="<? if($vstyle== 'kanjiRE'){echo "vsSel ";}?>" 
						onClick="vsChange('vStyle','kanjiRE')">
							<a href="#1" >
								<b><span class="text-success">Easy</span></b>
								 <i>Introduce Word</i>
								<span class="text-muted">
									<small>Lv.<?= $vsLvEZ; if($vsLvEZ==$mxDkLv){echo " (Max)";}?></small>
								</span>
							</a>
					</li><? 
				}else if(getOwnershipDeckVstyle($cvset,'kanjiRE',$userID)==FALSE &&  getDeckInfo($cvset, 'kanjiRE')==1){?>
					<li 
						role="presentation" 
						class="vsBuy" 
						onClick="buyVstyle('<?php echo $cvset; ?>','<?php echo getDeckInfo($cvset, 'id'); ?>','<?= $userID; ?>','gc', 'kanjiRE')" >
							<a href="#2">
								<span class="text-success">Easy Mode</span><i></i> Buy mode for <span class="text-default"><?= getPrice('kanjiRE', 'gc');?> Gold</span>
							</a>
					</li><?php
				}?>
			</li><!-- END EASY QUIZ MODE -->
			<!--*****************MEDIUM IS OWNED OR NOT OWNED*************-->
			<li><?
				if(getOwnershipDeckVstyle($cvset,'kanjiE',$userID)==TRUE && getDeckInfo($cvset, 'kanjiE')==1){?>
					<li 
						role="presentation" 
						class="<? if($vstyle == 'kanjiE'){echo "";}?>" 
						onClick="vsChange('vStyle','kanjiE')" >
							<a href="#2">
								<span class='text-warning'><b>Medium</b></span>: <small><i>Learn Kanji Meaning</i></small> <span class="text-muted"><small>Lv.<?= $vsLvMed; if($vsLvMed==$mxDkLv){echo " (Max)";}?></small></span>
							</a>
					</li><?
				}else if(getOwnershipDeckVstyle($cvset,'kanjiE',$userID)==FALSE && $cvset != 'hirkat'&& $cvset !='katakana'){?>
					<li 
						role="presentation" 
						class="vsBuy" 
						onClick="buyVstyle('<?php echo $cvset; ?>','<?php echo getDeckInfo($cvset, 'id'); ?>','<?php echo $userID; ?>','gc', 'kanjiE')" >
							<a href="#2">
								<span class='text-warning'><b>Medium</b></span>: <small><i>Learn Kanji Meaning</i></small>. <span class="text-info">Click to buy for <?php echo getPrice('kanjiE', 'gc');?> Gold</span>
							</a>
					</li><?
				}?>
			</li><!-- END MEDIUM QUIZ MODE -->
			<!--*****************HARD IS OWNED OR NOT OWNED*************-->
			<li><?
				if(getOwnershipDeckVstyle($cvset,'kanjiH',$userID)==TRUE  && getDeckInfo($cvset, 'kanjiH')==1){?>
					<li 
						role="presentation" 
						class="<? if($vstyle == 'kanjiH'){echo "";}?>" 
						onClick="vsChange('vStyle','kanjiH')" >
							<a href="#3">
								<span class='text-danger'><b>Hard</b></span>: <small><i>Learn Kanji Reading</i></small> <span class="text-muted"><small>Lv.<?= $vsLvHard; if($vsLvHard==$mxDkLv){echo " (Max)";}?></small></span>
							</a>
					</li><?
			   }else if(getOwnershipDeckVstyle($cvset,'kanjiH',$userID)==FALSE && $cvset != 'hirkat'&& $cvset !='katakana'){?>
					<li 
						role="presentation" 
						class="vsBuy" 
						onClick="buyVstyle('<?php echo $cvset; ?>','<?php echo getDeckInfo($cvset, 'id'); ?>','<?php echo $userID; ?>','gc', 'kanjiH')" >
							<a href="#3">
								<span class='text-danger'><b>Hard</b></span>: <small><i>Learn Kanji Reading</i></small> <span class="text-info">Click to buy for <?php echo getPrice('kanjiH', 'gc');?> Gold</span>
							</a>
					</li><?php
			   }?>
			</li><!-- END HARD QUIZ MODE -->
			<li role="separator" class="divider"></li>
			<!--***************AUDIO FLASHCARDS***************************-->
			<!--***************EAZY MODE OWNED OR NOT OWNED*************-->
			<li><?
				if(getOwnershipDeckVstyle($cvset,'audioR',$userID)==TRUE && getDeckInfo($cvset, 'audioR')==1){?>
					<li 
						role="presentation" 
						class="<?php if($vstyle== 'audioR'){echo " ";}?> bg-info audio-tab" 
						onClick="vsChange('vStyle','audioR')">
							<a href="#1" >
								<b>Audio Card</b>: <small><i>Learn Spelling</i></small>. <span class="badge-default"><small>(Lv.<?php echo $vsLvAEZ; if($vsLvAEZ==$mxDkLv){echo " (Max)";}?>)</small></span>
							</a>
					</li><?
				}else if(getOwnershipDeckVstyle($cvset,'audioR',$userID)==FALSE &&  getDeckInfo($cvset, 'audioR')==1){?>
					<li 
						role="presentation" 
						class="vsBuy" 
						onClick="buyVstyle('<?php echo $cvset; ?>','<?php echo getDeckInfo($cvset, 'id'); ?>','<?php echo $userID; ?>','gc', 'audioR')" >
							<a href="#2">
								Audio Flashcards: Learn Spelling. <span class="text-info">Click to buy for <?php echo getPrice('audioR', 'gc');?> Gold</span>
							</a>
					</li><?php
				}?>
			</li><!-- END EAZY AUDIO MODE-->
			<!--***************MEDIUM AUDIO MODE OWNED OR NOT OWNED*************-->
			<li><?
				if(getOwnershipDeckVstyle($cvset,'audioE',$userID)==TRUE && getDeckInfo($cvset, 'audioE')==1){?>
					<li 
						role="presentation" 
						class="<?php if($vstyle == 'audioE'){echo "";}?>" 
						onClick="vsChange('vStyle','audioE')" >
							<a href="#2">
								<span class="text-warning">Med</span> Listen, Guess English <span class="badge"><small><i>Lv.<?php echo $vsLvAMed; if($vsLvAMed==$mxDkLv){echo " (Max)";}?></i></small></span>
							</a>
					</li><?
				}else if(getOwnershipDeckVstyle($cvset,'audioE',$userID)==FALSE && getDeckInfo($cvset, 'audioE')==1){?>
					<li 
						role="presentation" 
						class="vsBuy disabled" 
						onClick="buyVstyle('<?php echo $cvset; ?>','<?php echo getDeckInfo($cvset, 'id'); ?>','<?php echo $userID; ?>','gc', 'audioE')" >
							<a href="#2">
								Audio Flashcards: Learn English. <span class="text-info">Click to buy for <?php echo getPrice('audioE', 'gc');?> Gold</span>
							</a>
					</li><?php
				}?>
			</li><!-- END MEDIUM AUDIO FLASHCARDS-->
			<!--***************HARD AUDIO MODE OWNED OR NOT OWNED*************-->
			<li><?
				if(getOwnershipDeckVstyle($cvset,'audioK',$userID)==TRUE  && getDeckInfo($cvset, 'audioK')==1){?>
					<li 
						role="presentation" 
						class="<?php if($vstyle == 'audioK'){echo "";}?>" 
						onClick="vsChange('vStyle','audioK')" >
							<a href="#3">
								Audio Flashcards: Learn Kanji <span class="badge"><small><i>Lv.<?= $vsLvAHard; if($vsLvAHard==$mxDkLv){echo " (Max)";}?></i></small></span>
							</a>
					</li><?
				}else if(getOwnershipDeckVstyle($cvset,'audioK',$userID)==FALSE && getDeckInfo($cvset, 'audioK')==1){?>
					<li 
						role="presentation" 
						class="vsBuy" 
						onClick="buyVstyle('<?php echo $cvset; ?>','<?php echo getDeckInfo($cvset, 'id'); ?>','<?php echo $userID; ?>','gc', 'audioK')" >
							<a href="#3">
								Audio Flashcards: Learn Kanji. Click to buy <span class="text-default"><?php echo getPrice('audioK', 'gc');?> Gold 
							</a>
					</li><?php
				}?>
			</li><!--END HARD MODE AUDIO-->
		</ul>
</div>