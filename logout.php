<?php
	session_start();
	include($_SERVER['DOCUMENT_ROOT']."/config.php");
	$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
	mysql_select_db($dbname);
	mysql_query("SET NAMES UTF8");
	if(isset($_SESSION["userid"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])) {
		$log_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
	}elseif(isset($_COOKIE["id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
		$log_id = preg_replace('#[^0-9]#', '', $_COOKIE['id']);
		setcookie("id", '', strtotime( '-5 days' ), '/');
		setcookie("user", '', strtotime( '-5 days' ), '/');
		setcookie("pass", '', strtotime( '-5 days' ), '/');
	}
	$sql = "UPDATE users SET last_act= now() - INTERVAL 10 MINUTE WHERE id='$log_id' LIMIT 1";
	$query = mysql_query($sql) or error_log("Couldn't update last_act on log out".$sql.mysql_error());
	
	setcookie("id", '', 1);
	setcookie("user", '', 1);
	setcookie("pass", '', 1);
		//print_r($_COOKIE);
	$_SESSION = array();
	
	session_destroy();
// Double check to see if their sessions exists
if(isset($_SESSION['username'])){
	header("location: message.php?msg=Error:_Logout_Failed");
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="NOODP">
	
	<meta name="description" content="I worked real hard on flashcards today with JPVocab.com's Online Japanese Flashcards App. Don't join, you might beat my scores.">
	<title>I just finished my daily Japanese flashcards online</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<script src="js/main.js" type="text/javascript"></script>
	<script src="js/ajax.js" type="text/javascript"></script>
	<script>
		function emptyElement(x){
			_(x).style.visibility = "hidden";
		}
		function login(){
			var e = _("loginEmail").value;
			var p = _("loginPassword").value;
			if(e == "" || p == ""){
				_("loginStatus").style.visibility = "visible";
				_("loginStatus").innerHTML = "Please fill out both fields.<div id='erMes'><a href='http://www.tehjapanesesite.com/reset.php'>Forgot Password?</a></div>";
			} else {
				_("loginStatus").innerHTML = 'Please wait ...';
				var ajax = ajaxObj("POST", "index.php"); //send to index, index logs in through scriptlogin.php
				var vars ="e="+e+"&p="+p;
				ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
						if(ajax.responseText == "login_failed"){
							_("loginStatus").style.visibility = "visible";
							_("loginStatus").innerHTML = "Login unsuccessful, please try again.<br /><div id='erMes'><a href='http://www.tehjapanesesite.com/reset.php'>Forgot Password?</a></div>";
						} else {
							window.location = "index.php";
						}
					}
				}
				ajax.send(vars);
			}
		}
		function _(el){
			return document.getElementById(el);
		}
		
		function toggle_visibility(id) {
		   var e = document.getElementById(id);
		   if(e.style.display == 'none')
			  e.style.display = 'block';
		   else
			  e.style.display = 'none';
		}
		function openTerms(){
			_("terms").style.display = "block";
			emptyElement("statusReg");
		}
	</script>
	<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "ur-29e2d76c-6a5b-d05d-59a6-22a7a66c13f0", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
</head>
<body>
<?php
		include('include/header1.php'); ?>
	<section>
	<!-- /.Container Div -->
		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="row">
						<div class="inner-wrap col-md-12">
							<div class="innerLeft col-md-5">
									<div class="innerLeft-wrap col-md-12">
										<h2 class="text-center">Logged Out</h2>
										<p><?php if(isset($_SESSION['logreas'])){ echo $_SESSION['logreas'];}
									else{?>You've been logged out.<?php }?> I hope to see you again tomorrow.</p>
									<p>Subscribe to me on twitter on the right.</p>
									<p>If any aspect of my site might help a friend of yours learning Japanese then, because you're a friend, send it to them.</p>
									<span class='st_reddit_hcount' displayText='Reddit'></span>
									<span class='st_wordpress_hcount' displayText='WordPress'></span>
									<span class='st_fbrec_hcount' displayText='Facebook Recommend'></span>
									<span class='st_fbsend_hcount' displayText='Facebook Send'></span>
									
									<span class='st_google_bmarks_hcount' displayText='Bookmarks'></span>
									<span class='st_googleplus_hcount' displayText='Google +'></span>
									<span class='st_facebook_hcount' displayText='Facebook'></span>
									<span class='st_twitter_hcount' displayText='Tweet'></span>
									<span class='st_linkedin_hcount' displayText='LinkedIn'></span>
									<span class='st_pinterest_hcount' displayText='Pinterest'></span>
									<span class='st_email_hcount' displayText='Email'></span>
									</div><!-- message-->
									
							</div>
							<div class="innerRight col-md-7">
								<div class="row">
									<a class="twitter-timeline"  href="https://twitter.com/JPVocab_Ben" data-widget-id="575354622455349248">Tweets by @JPVocab_Ben</a>
									<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--end #innerContainer-->
	</section>
</body>
</html>