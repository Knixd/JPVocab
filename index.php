<?php
	include_once("include/check_login.php");
	//header("location: login.php");
	if($user_ok == true){
		header("location: lobby.php");
		exit();
	}
?><?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
	include_once("scripts/scriptlogin.php");
?><?php
	//Ajax request Namecheck
	if(isset($_POST["usernamecheck"])){
		require_once 'config.php';				
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);			/*counts users in table with same username (caps=nocaps)*/	/*using springf() to format output so to be able to use mysql_real_escape_string() to escape the value of $_POST['username'] before we put it into our query*/
		$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);		
		$query = sprintf("SELECT COUNT(id) FROM users WHERE UPPER(username) = UPPER('$username') LIMIT 1");
				//mysql_real_escape_string($_POST['username']));
		$result = mysql_query($query);
		list($count) = mysql_fetch_row($result);
		if(strlen($username) < 3 || strlen($username) > 16){
			echo '<strong style="color:#e56659;">3 - 16 characters please</strong>';
			exit();
		}
		if(is_numeric($username[0])){
			echo '<strong style="color:#e56659;">Usernames must begin with a letter</strong>';
			exit();
		}
		if($count < 1){
			echo '<strong style="color:#00cf63;">'.$username.' is OK!</strong>';
			exit();
		} else{
			echo '<strong style="color:#e56659;">'.$username.' is already taken, sorry!</strong>';
			exit();
		}
	}
?><?php
	//Ajax Registration code
	if(isset($_POST["u"])){
		require_once 'config.php';
		include 'include/password.php';
		$conn = mysql_connect($dbhost,$dbuser,$dbpass)
				or die('Error connecting to mysql');
		mysql_select_db($dbname);
		$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
		$e = mysql_real_escape_string($_POST['regE']);
		$p = $_POST['p'];
		$g = preg_replace('#[^a-z]#', '', $_POST['g']); //#i means upper case too
		$c = preg_replace('#[^a-z]#i', '', $_POST['c']);
		$j = preg_replace('#\D#', '', $_POST['j']); //jlpt
		//Get User IP Address
		$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
		$query = "SELECT id FROM users WHERE username='$u' LIMIT 1";
		$result = mysql_query($query)or die(mysql_error());
		$u_check = mysql_num_rows($result) ;
		//--------------------------------------------------
		$query = "SELECT id FROM users WHERE email='$e' LIMIT 1";
		$result = mysql_query($query);
		$e_check = mysql_num_rows($result);
		//FORM DATA ERROR HANDLING
		if($u == "" || $e == "" || $p == "" || $g == "" || $c == "" || $j ==""){
			echo "The form submission is missing values";
			exit();
		}elseif($u_check > 0){
			echo "The username you entered is already taken";
			exit();
		}elseif($e_check >0){
			echo "The email address is already in use.";
			exit();
		}elseif(strlen($u) < 3 || strlen($u) >16){
			echo "Username must be between 3 and 16 characters";
			exit();
		}elseif(is_numeric($u[0])){
			echo "Username cannot begin with a number";
			exit();
		}
		//END FOR DATA ERROR HANDLING
			//Begin insertion of data into db
			//Hash the password and apply own unique salt
			$pHashed = password_hash($p, PASSWORD_BCRYPT);
			//Add user info into the db
			$sql = sprintf("INSERT INTO users (username, email, password, gender, country, ip, jlpt, signup, last_login, notescheck) VALUES('%s','%s','%s','%s','%s','%s','%s',now(),now(),now())",
				$u,$e,$pHashed,$g,$c,$ip,$j);
			$query = mysql_query($sql) or die(mysql_error());
			$userID = mysql_insert_id($conn);
			require_once 'stats.php';						
			setStat('atk',$userID,'5');
			setStat('def',$userID,'2');
			setStat('conf',$userID,'0');
			setStat('maxconf',$userID,'150');
			setStat('mag',$userID,'5');	
			setStat('lv', $userID, '1');
			//Set Money
			setStat('gold', $userID, '0');
			setStat('dmd', $userID, '0');
			//Set Initial Deck
			setOwnershipDeck('hirkat',$userID);
			setOwnershipvStyle('hirkat','audioR',$userID);
			setOwnershipDeck('minna',$userID);//sets ownership of deck(adds this deck to users' user_decks); initializesdeck_lv, deck_progress, deck_prog_max
			setStat('ttldks',$userID, '2');
			setSkill('cvset',$userID,'hirkat');
			setSkill('vstyle',$userID,'kanjiRE');
			setAchiev('submit_jlpt',$userID,'1');
			//Could create a folder for this user at this point. Folder would hold their files
			
			//Email the suer their activation link
			$to = "$e";
			$from = "no-reply@jpvocab.com";//create this
			$subject = 'Free JP decks for '.$u.' coming right up! One step left.';
			$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>jpvocab.com Email Confirmation</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background: #2c3e50; font-size:24px; color:#CCC;"><a href="http://www.jpvocab.com" style="color:white;"><!--<img src="http://www.jpvocab.com/img/logo.png" width="36" height="30" alt="jpvocab.com" style="border:none; float:left;"></a>-->jpvocab.com Account Activation</div><div style="padding:24px; font-size:17px;">Welcome '.$u.'!<p>I am so grateful that you decided to check out jpvocab! My name is Ben and I am a Japanese learner just like you. I went on a year exchange to Japan in 2012-2013 and it changed my life. Now I am working towards helping others learn Japanese even faster than I did.</p><p>So, free vocab decks? All you need to do is click the link to confirm your email and they\'ll be transmorgified straight to your account (Calvin & Hobbes reference anyone?).</p><p>Sincerely,</p><p>Ben<br />jpvocab.com</p><p>Click the link to activate your account.</p><p><a href="http://www.jpvocab.com/activation.php?id='.$userID.'&u='.$u.'&e='.$e.'&p='.$pHashed.'">Click to activate</a><br /><br />Your login info:<br /><b>Username:</b> '.$u.'<br /><b>Email:</b> '.$e.'</div><br /><a href="https://twitter.com/jpvocab_ben" target="_blank"><img
src="http://static.viewbook.com/images/social_icons/twitter_32.png"/></a></p></body></html>';
			$headers = "From: $from\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			if(mail($to,$subject,$message,$headers)){
				echo "signup_success";
				mail('contact@jpvocab.com','New User','A new user signed up: '.$u,$headers);
			}else{
				echo "Thanks! If you don't receive a confirmation email from us contact us at contact@jpvocab.com";
				error_log("Couldn't email confirmation email! $to,$subject,$message,$headers");
			}
			exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register to receive access to our Flashcards-with-a-twist.</title>
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">-->
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9] >
	<script src="/js/html5shiv.js">alert('Your version of Internet Explorer is not supported!');</script>
	<![endif]-->
	<meta property="og:title" content="Register to receive access to our Flashcards-with-a-twist." />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://www.jpvocab.com" />
	<meta property="og:image" content="http://www.jpvocab/img/logo.png" />
	<meta name="p:domain_verify" content="ca317a1128e1340a8db2e495910406c3"/>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="js/main.js" type="text/javascript"></script>
	<script src="js/ajax.js" type="text/javascript"></script>
	<script>
		function emptyElement(x){
			_(x).style.visibility = "hidden";
		}

		function _(el){
			return document.getElementById(el);
		}
		function restrict(elem){
			var tf = _(elem);
			var rx = new RegExp;
			if(elem == "emailReg"){
				rx = /[' "]/gi;
			} else if(elem == "usernameReg"){
				rx = /[^a-z0-9]/gi;
			}
			tf.value = tf.value.replace(rx, "");
		}
		function emptyElementReg(x){
			_(x).innerHTML = "";
		}
		function checkusername(){
			var u = _("usernameReg").value;
			if(u != ""){
				_("unamestatus").innerHTML = 'checking ...';
				var ajax = ajaxObj("POST", "index.php");
				ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
						_("unamestatus").innerHTML = ajax.responseText;
					}
				}
				ajax.send("usernamecheck="+u);
			}
		}
		function checkemail(e){
			var atpos = e.indexOf("@");
			var dotpos = e.lastIndexOf(".");
			if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=e.length) {
				return false;
			}
		}
		function signup(){
			var u = _("usernameReg").value;
			var e = _("emailReg").value;
			var p1 = _("pass1").value;
			var p2 = _("pass2").value;
			var c = _("country").value;
			var gm = _("genderRegM").checked;
			var gf = _("genderRegF").checked;
			var j1 = _("jlptN1").checked;
			var j2 = _("jlptN2").checked;
			var j3 = _("jlptN3").checked;
			var j4 = _("jlptN4").checked;
			var j5 = _("jlptN5").checked;
			var status = _("statusReg");
			if(gm==true){ var g = "m"}else if(gf==true){var g = "f"}else{ var g=false};
			if(j1==true){ var j = "1"}else if(j2==true){var j = "2"}else if(j3==true){var j = "3"}else if(j4==true){var j = "4"}else if(j5==true){var j = "5"}else{ var j=false};
			console.log(j);
			if(u == "" || e == "" || p1 == "" || p2 == "" || c == "" || g == false || j==false){
				status.innerHTML = "Oops! Some data is still missing still.";
			} else if(checkemail(e)==false){
				status.innerHTML = "Oh no! Enter a valid email please.";
			}else if(p1 != p2){
				status.innerHTML = "Oops! Your password fields don't match yet";
			} else {
				_("signupbtn").style.display = "none";
				status.innerHTML = 'beep bop boop beep ...';
				var ajax = ajaxObj("POST", "index.php");
				ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
						if(ajax.responseText != "signup_success"){
							status.innerHTML = ajax.responseText;
							_("signupbtn").style.display = "block";
						} else {
							window.scrollTo(0,0);
							_("signupform").innerHTML = "<div class='row'><div class='col-sm-12'><h2 style='color:#00cf63;'>Success!</h2></div><div class='col-sm-12'><p>Great news "+u+"!</p><p> We've saved you a spot until you confirm your email.</p><p>Confirm your email to receive your two free vocab decks: Hiragana and Minna no Nihongo.</p><p>Thanks!</p><p>Ben</p></div></div>";
						}
					}
				}
				ajax.send("u="+u+"&regE="+e+"&p="+p1+"&c="+c+"&g="+g+"&j="+j);
			}
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
		$(function() {
		  $('a[href*=#]:not([href=#])').click(function() {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

			  var target = $(this.hash);
			  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			  if (target.length) {
				$('html,body').animate({
				  scrollTop: target.offset().top
				}, 1000);
				return false;
			  }
			}
		  });
		});
	function input(el){
		var output = document.getElementById('output-result');
		var selectedTextArea = document.activeElement;
		var puthere = document.getElementById(selectedTextArea.id);
		puthere.value=el;
		puthere.focus();
		//puthere.next('input').focus();
	}
</script>
</head>
<body>
<?php include_once("scripts/scriptaddthis.php");
	include('include/header1.php');
	include('scripts/countdown.php'); ?>
	<hr>
	<!--
	<section id="">
		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
				<div class="row">
					<div class="inner-wrap col-md-12">
						<div class="innerLeft col-md-12">
							<div class="row">
								<div class="innerLeft-wrap col-md-12">
									<iframe src="http://www.easysurveyonline.com/embed/44-need_your_help.html" width="100%" height="600" frameBorder="0" scrolling="yes"></iframe>
								</div><!-- message-->

							<!--</div>

						</div>

					</div>

				</div>

				<div class="col-md-1"></div>

			</div>

		</div>
	</div>

	</section>-->
	<section>
		
		<div class="container">
			<div class="row" id="register">
				<div class="col-md-1"></div>
				<div class="col-md-10">
				<div class="row">
					<div class="inner-wrap col-md-12">
						<div class="innerLeft col-md-5">
							<div class="row">
								<div class="innerLeft-wrap col-md-12">
									<h2 class="text-center"><b><span class="text-danger">JP</span><span class="text-primary">Vocab</span></b><small>.com</small></h2>
									<p><b><span class='text-danger'>Flashcards</span> + <span class='text-success'>Leveling</span> + <span class='text-warning'>Gold</span> + Ranking</b></p>
									<p>
										If you like flashcards, but are bored of doing them alone..
									</p>
									<p>
										If you want to keep track of your Japanese efforts...
									</p>
									<p>
										If you want to see how much advanced learners study and have studied to...
									</p>
									<p>
										If you want realistic daily Japanese vocabulary goals...
									</p>
									<p>
										If you reached a plateau and your lack of Japanese vocabulary is holding you back...
									</p>
									<p>
										If you want to study Japanese while watching Japanese anime...
									</p>
									<p>
										If you want a community of Japanese learners who like working hard...
									</p>
									<p>
										<strong>Then JPVocab is for you. </p><p>Register now to get started.</strong>
									</p>
									<p class="text-warning">If you register today, I'll throw in the <a href="http://www.jpvocab.com/Japanese-Vocabulary/deck.php?t=Beginner&d=Hiragana" alt="Hiragana Flashcards" title="Hiragana flashcards">Hiragana flash card set</a> AND the massive 972 card <a href="http://www.jpvocab.com/Japanese-Vocabulary/deck.php?t=Textbook&d=Minna-no-Nihongo-Bk1" alt="Minna no Nihongo flashcards" title="Minna no Nihongo flashcard">Minna no Nihongo flashcard set</a> to help you get started.<br /><br />Hurry though because I might end this promo tomorrow!
									</p>
									<p><small><i>Flashcards still aren't your thing? Maybe you'd like our other site: <a href="http://www.JPDrills.com" alt="Japanese Drill practice"><b><span class="text-danger">JP</span><span class="text-primary">Drills</span></b><span class="text-muted">.com</span></a></i></small></p>
								</div><!-- message-->
							</div>
						</div>
						<div class="innerRight col-md-7">
							<form name="signupform" id="signupform" onsubmit="return false;">
								<div class="row">
									<div class="col-md-12">
										<h2 style="color:#fff;">Register</h2>
										<!--Username, email-->
										<div class="row marg-bot">
											<div class="col-sm-6">
												<input type="text" id="usernameReg" class="form-control form-rounded" placeholder="Pick a Username" onblur="checkusername()" onkeyup="restrict('usernameReg')" maxlength="16">
												<span id="unamestatus"></span>
											</div>
											<div class="col-sm-6">
												<input type="text" id="emailReg" class="form-control form-rounded" placeholder="Email - @example.com" onfocus="emptyElementReg('statusReg')" onkeyup="restrict('emailReg')" maxlength="88">
											</div>
										</div>
										<!--Password-->
										<div class="row marg-bot">
											<div class="col-sm-6">
												<input id="pass1" type="password" class="form-control form-rounded" placeholder="Password" onfocus="emptyElementReg('statusReg')" maxlength="16">
											</div>
											<div class="col-sm-6">
												<input id="pass2" type="password" class="form-control form-rounded" placeholder="Re-enter Password" onfocus="emptyElementReg('statusReg')" maxlength="16">
											</div>
										</div>
										<!--Gender, JLPT-->
										<div class="row">
											<div class="col-sm-6">
												<div class="row">
													<div class="col-sm-6 col-md-12 text-center">
														<h4 style="color:#C8E3E2;">Gender</h4>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-3 col-md-6 text-center">
														<div class="radio">
														  <label>
															<input type="radio" id="genderRegM" name="genderReg" onfocus="emptyElementReg('statusReg')" value="m" style="color:#C8E3E2;">
															<span  style="color:#C8E3E2;">Male</span>
														  </label>
														</div>
													</div>
													<div class="col-sm-3 col-md-6 text-center">
														<div class="radio">
														  <label>
															<input type="radio" id="genderRegF" name="genderReg" onfocus="emptyElementReg('statusReg')" value="f" style="color:#C8E3E2;">
															<span  style="color:#C8E3E2;">Female</span>
														  </label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="row">
													<div class="col-sm-6 col-md-12 text-center">
														<h4 style="color:#C8E3E2;">Approximate JLPT</h4>
													</div>
												</div>
												<div class="row">
													<div class="col-xs-12 no-marg-bot">
															<span  class="col-xs-2" style="color:#C8E3E2;">N1</span>
															<span   class="col-xs-2"style="color:#C8E3E2;">N2</span>
															<span  class="col-xs-2" style="color:#C8E3E2;">N3</span>
															<span   class="col-xs-2"style="color:#C8E3E2;">N4</span>
															<span   class="col-xs-2"style="color:#C8E3E2;">N5</span>
													</div>
													<div class="col-xs-12">
														<div class="radio ">
															<label class="col-xs-2 col-xs-offset-1">
																<input type="radio" id="jlptN1" name="jlpt" onfocus="emptyElementReg('statusReg')" value="m" style="color:#C8E3E2;">
															</label>
															<label class="col-xs-2">
																<input type="radio" id="jlptN2" name="jlpt" onfocus="emptyElementReg('statusReg')" value="m" style="color:#C8E3E2;">
															</label>
															<label class="col-xs-2">
																<input type="radio" id="jlptN3"  name="jlpt" onfocus="emptyElementReg('statusReg')" value="m" style="color:#C8E3E2;">
															</label>
															<label class="col-xs-2">
																<input type="radio" id="jlptN4"  name="jlpt" onfocus="emptyElementReg('statusReg')" value="m" style="color:#C8E3E2;">
															</label>
															<label class="col-xs-2">
																<input type="radio" id="jlptN5"  name="jlpt" onfocus="emptyElementReg('statusReg')" value="m" style="color:#C8E3E2;">
															</label>
														</div>
													</div>
													
												</div>
											</div>
											
										</div>
										<div class="row marg-bot">
											<div class="col-sm-6">
												<div class="row">
													<div class="col-sm-12 text-center">
														<h4 style="color:#C8E3E2;">Right now you're living in</h4>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-12 text-center">
														<select id="country" class="form-control" onfocus="emptyElementReg('statusReg')">
															<?php include_once("include/country_list.php"); ?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<button type="button" id="signupbtn" class="btn btn-danger btn-lg btn-block" onclick="signup()">Register</button>
											</div>
											<div class="col-md-12">
												<span id="statusReg" class="text-center"></span>
											</div>
										</div>
									</div>
								</div>
							</form>
								<!--<form name="signupform" id="signupform" onsubmit="return false;" style="font-color:white;">
									<div class="regRow">
										<div class="regRowCol">
											<div id="regU" class="labelReg">Username: </div>
											<input id="usernameReg" type="text" onblur="checkusername()" onkeyup="restrict('usernameReg')" maxlength="16">
											<span id="unamestatus"></span>
										</div>
										<div class="regRowCol">
											<div id="regE" class="labelReg">Email:</div>
											<input id="emailReg" type="text" onfocus="emptyElementReg('statusReg')" onkeyup="restrict('emailReg')" maxlength="88">
										</div>
									</div>
									<div class="regRow">
										<div class="regRowCol">
											<div id="regP1" class="labelReg">Create Password:</div>
											<input id="pass1" type="password" onfocus="emptyElementReg('statusReg')" maxlength="16">
										</div>
										<div class="regRowCol">
											<div id="regP2" class="labelReg">Confirm Password:</div>
											<input id="pass2" type="password" onfocus="emptyElementReg('statusReg')" maxlength="16">
										</div>
									</div>-->
									<!--<div class="regRow">
										<div class="regRowCol">
											<div id="regG" class="labelReg">Gender:</div>
											<div id="genderReg-wrap">
												<input type="radio" id="genderRegM" name="genderReg" onfocus="emptyElementReg('statusReg')" value="m">
												<div class="radioLabelReg labelReg">Male</div>
												<input type="radio" id="genderRegF" name="genderReg" onfocus="emptyElementReg('statusReg') "value="f">
												<div class="radioLabelReg labelReg">Female</div>
											</div>
										</div>
										<div class="regRowCol">
											<div id="regC" class="labelReg">Country:</div>
											<select id="country" onfocus="emptyElementReg('statusReg')">
												<?php include_once("include/country_list.php"); ?>
											</select>			
										</div>
									</div>-->
									<!--<div class="regRow">
										<button id="signupbtn" onclick="signup()">Create Account</button>
									</div>-->
									<!--<div class="regRow">
										<span id="statusReg"></span>
									</div>-->
								
						</div>
					</div>
				</div>
				<div class="col-md-1"></div>
				<hr>
				<div class="row">
					<div class="col-xs-12 text-center">
							<i class="col-xs-6 col-sm-2 col-sm-offset-1 opacity2 fa fa-twitter-square fa-5x"></i>
							<i class="col-xs-6 col-sm-2 opacity2 fa fa-facebook-square fa-5x"></i>
							<i class="col-xs-6 col-sm-2 opacity2 fa fa-google-plus-square fa-5x"></i>
							<i class="col-xs-6 col-sm-2 opacity2 fa fa-youtube-square fa-5x"></i>
							<i class="col-xs-6 col-sm-2 opacity2 fa fa-linkedin-square fa-5x"></i>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12">
						<h3>1. Leveling Up Your JPVocab Arsenal <small>Our Deck Leveling System Introduction</small></h3>
						<div class="vid">
							<iframe width="560" height="315" src="https://www.youtube.com/embed/WjVMvlPMyZY" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12">
						<h3>2. JP Vocab Done Right. Are you doing this? <small>Introducing Our 3 Quiz Modes</small></h3>
						<div class="vid">
							<iframe width="560" height="315" src="https://www.youtube.com/embed/J7sOYAegBFY" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12">
						<h3>3. Why Gold Rewards for Flash cards? <small>Introducing our Gold Rewards System</small></h3>
						<div class="vid">
							<iframe width="560" height="315" src="https://www.youtube.com/embed/3gFTOjNIXBU" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12">
						<h3>Hiragana and Katakana Audio Flashcards</h3>
						<div class="vid">
							<iframe width="560" height="315" src="https://www.youtube.com/embed/YBQ2_XIwcpA" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12">
						<h3>Change it Up! <small>How to Change Your Flash Card Decks | Tutorial</small></h3>
						<div class="vid">
							<iframe width="560" height="315" src="https://www.youtube.com/embed/PvJmMHet21A" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
				<hr>
				
			</div>
		</div>
	</section>
	<!-- ********************Include Footer ******************************-->
	<footer class="footer">
      <div class="container">
        <p class="text-muted">&copy;2015 JPVocab.com 
			
		</p>
      </div>
    </footer>
	<!-- ********************JS ******************************-->
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type='text/javascript' src='https://plasso.co/embed/v2/embed.js'></script>
</body>
</html>