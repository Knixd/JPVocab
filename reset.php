<?php
	//Ajax request Namecheck
	if(isset($_POST["e"])){
		require_once 'config.php';
		include_once('include/password.php');
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$e = mysql_real_escape_string($_POST['e']);		
		$query = sprintf("SELECT COUNT(id) FROM users WHERE UPPER(email) = UPPER('$e') LIMIT 1");
				//mysql_real_escape_string($_POST['username']));
		$result = mysql_query($query);
		list($count) = mysql_fetch_row($result);
		if($count < 1){
			exit();
		} else{
			$eHashed = password_hash($e, PASSWORD_BCRYPT);
			$to = "$e";
			$from = "no-reply@JPVocab.com";//create this
			$subject = 'JPVocab.com Password Reset Request';
			$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>JPVocab.com Password Reset Request</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://www.JPVocab.com" style="color:white;"><!--<img src="http://www.JPVocab.com/img/logo.png" width="36" height="30" alt="JPVocab.com" style="border:none; float:left;"></a>-->JPVocab.com Password Reset Request</div><div style="padding:24px; font-size:17px;">Hello,<br /><br />Thanks for using JPVocab.com to practice your Japanese! A password reset request has been issued. <br /><br />When you\'re ready, click the link below to go to a page to reset your password.<br /><br />Sincerely,<br />Ben<br /><br /><a href="http://www.JPVocab.com/forgotton.php?eh='.$eHashed.'">Click here to reset your password at JPVocab.com</a><br /><br /><br />Login after a successful reset using your email Address: <b>'.$e.'</b></div></body></html>';
			$headers = "From: $from\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			if(mail($to,$subject,$message,$headers)){
				echo "Emailed </br>";
			}else{
				echo "Not emailed </br>";
			}
			exit();
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Forgot your password? Have no fear, we can fix this.</title>
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	
	<meta property="og:title" content="Forgot your password? Have no fear, we can fix this." />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://www.JPVocab.com" />
	<meta property="og:image" content="http://www.JPVocab/img/logo.png" />
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="js/main.js" type="text/javascript"></script>
	<script src="js/ajax.js" type="text/javascript"></script>
	<script>
		function emptyElement(x){
			_(x).style.visibility = "hidden";
		}
		function checkemail(e){
			var atpos = e.indexOf("@");
			var dotpos = e.lastIndexOf(".");
			if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=e.length) {
				return false;
			}
		}
		function restrict(elem){
			var tf = _(elem);
			var rx = new RegExp;
			rx = /[' "]/gi;
		}
		function reqpr(){
			var e = _("emailReg").value;
			var status = _("statusReg");
			if(e == ""){
				status.innerHTML = "Please fill out your email.";
			}if(checkemail(e)==false){
				status.innerHTML = "Oh no! Enter a valid email please.";
			}else {
				_("forgotbtn").style.display = "none";
				status.innerHTML = 'Please wait ...';
				var ajax = ajaxObj("POST", "reset.php");
				var vars ="e="+e;
				ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
						_("signupform").innerHTML = "<span style='color:white;'>We've checked to see if that email exists with us here at JPVocab.com.</br>If it does, we've sent an email to reset your password.</br></br>Please check your email to continue - check your spam box too!</span>";
					}
				}
				ajax.send(vars);
			}
		}
</script>
</head>
<body>
	<header class="header-wrap">
		<?php include('include/header1.php'); ?>
	</header>
	<section id="welcome-wrap1">
		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
				<div class="row">
					<div class="inner-wrap col-md-12">
						<div class="innerLeft col-md-5">
							<div class="row">
								<div class="innerLeft-wrap col-md-12">
									<h2>Forgotten password?</h2>
									<p>
										For shame my friend, for shame. You forgot your password to the best Japanese Practice site ever.</p>
									<p>
										But fear not denizen! We can fix this.<br /><br />
										Start by entering your account email.
									</p>
								</div><!-- message-->
							</div>
						</div>
						<div class="innerRight col-md-7">
							<div class="row">
								<div class="col-md-12">
									<h2 style="color:#fff;">Password Reset</h2>
									<form name="signupform" id="signupform" onsubmit="return false;">
										<div class="col-xs-12">
											<label>
												Email:
											</label>
											<input id="emailReg" class="form-control form-rounded" placeholder="Enter your email" type="text" onfocus="emptyElementReg('statusReg')" onkeyup="restrict('emailReg')" maxlength="88">
										</div>
										<div class="col-xs-12 col-sm-6 text-center">
											<button id="forgotbtn" class="btn btn-default btn-lg btn-block" onclick="reqpr()">Send Reset Email</button>
										</div>
										<div class="col-xs-12">
											<span id="statusReg"></span>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
			</div>
		</div>
	</section>