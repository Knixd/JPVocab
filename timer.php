<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="NOODP">
	<meta name="description" content="Japanese Flashcards. Many decks. Many styles. - jpvocab.com">
	<title>Inn</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!--<script language="javascript" type="text/javascript">
		var i = 0, diff = 0, d = new Date()
		var minutesLabel = document.getElementById("minutes");
		var secondsLabel = document.getElementById("seconds");
		var totalSeconds = 0;
		
		var timer = setTimeout(function() {
		 
			setInterval(setTime, 1000);

			function setTime()
			{
				++totalSeconds;
				secondsLabel.innerHTML = pad(totalSeconds%60);
				minutesLabel.innerHTML = pad(parseInt(totalSeconds/60));
			}

			function pad(val)
			{
				var valString = val + "";
				if(valString.length < 2)
				{
					return "0" + valString;
				}
				else
				{
					return valString;
				}
			}
		}, 0)
	</script>-->
</head>
<body>
	<?php include('include/header.php');?>
	<form name="forming" action="#">
		<input type="text" name="fahrBox" size="6" /> F = 
		<input type="text" name="celsiusBox" size="6" /> C 
		<input type="button" value=" Convert "
		onclick="convert_temp();" />
	</form>
	<div id="timeLeft"></div>
	<div id="status"></div>
	<script>
		function convert_temp(){
			var celsius;
			var fahr = document.forming.fahrBox.value;
			
			fahr = parseFloat ( fahr );
			
			celsius = ((fahr - 32) / 9)*5;
			
			document.forming.celsiusBox.value = celsius;
			startTimer.secondsLable = startTimer.secondsLable+10;
		}
	</script>
	<script>
		var startTimer = function (secondsLeftStr){
			//var timeoutStr = document.getElementById("input1").value;
			//var timeout = parseFloat(timeoutStr) * 1000;
			var secondsLable = parseFloat(secondsLeftStr);
			var secondsLeft = secondsLable*1000;
			var timeout = parseFloat('5') * 1000;
			
			document.getElementById("status").innerHTML = "Wait for it...";
			
			var intervalID = setInterval(function(){
				secondsLable--;
				document.getElementById("timeLeft").innerHTML = secondsLable;
				if(secondsLable == 0){
					clearInterval(intervalID);
				}
			}, 1000);
			var timeoutID = setTimeout(function (){
				document.getElementById("status").innerHTML = "Times Up!";
				clearTimeout(timeoutID);
				//var startAgain = setTimeout( startTimer('10'),3000);
			}, secondsLeft);
		}
		onload = function(){
			startTimer('10');
		};
		var addTime = document.getElementById("add");
			addTime.onclick = startTimer('20');
	</script>
</body>
</html>