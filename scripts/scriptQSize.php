<?php
	$fontSize='8em';
	if(mb_strlen($question, 'utf8')==2){ 
		$fontSize='7em';}
	if(mb_strlen($question, 'utf8')==3){ 
		$fontSize='4.6em';}
	if(mb_strlen($question, 'utf8')>=4){ 
		$fontSize='3.5em';}
	if(mb_strlen($question, 'utf8')>=5){
		$fontSize='3.0em';}
	if(mb_strlen($question, 'utf8')>=6){
		$fontSize='2.5em';}
	if(mb_strlen($question, 'utf8')>=8){
		$fontSize='2em';}
?>