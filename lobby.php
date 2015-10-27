<?php
	include("include/check_login.php");
	if($user_ok == false){ 
		header("location: restricted.php?refPage=lobby");
		exit(); 
	}
	include('words.php');
	include('stats.php');
	include('config.php');
	$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
	mysql_select_db($dbname);
	mysql_query("SET NAMES UTF8");
	//Temporary until cron job set up.
	//Set todays flashcard goals if haven't logged in yet; or, if forgot to log out and today is at least one day ahead of previous login.
	/*if(!isset($_SESSION['todayStart']) || date('F jS', time()) >= date('F jS', strtotime('+1 day',$_SESSION['todayStart']))){
		include_once('stats.php');
		$_SESSION['todayStart']=time();
		$_SESSION['todayFCStart'] = getStat('sumcfc',$_SESSION['userid']);
		$_SESSION['todayFCToDo'] = round($_SESSION['todayFCStart']*0.1,0);
		$_SESSION['todayFCEnd'] = $_SESSION['todayFCStart']+$_SESSION['todayFCToDo'] ;
	}
	$_SESSION['currentFCTotal'] = getStat('sumcfc',$_SESSION['userid']);
	$_SESSION['fcUntilEnd'] = (($_SESSION['todayFCEnd']-$_SESSION['currentFCTotal'])>0)? $_SESSION['todayFCEnd']-$_SESSION['currentFCTotal'] : 0;
	$_SESSION['userLink'] = "<a href='http://www.jpvocab.com/player.php?player=".$_SESSION['username']."&report=summary' tite='Practice Profile Page'>".$_SESSION['username']."</a>";
	if($_SESSION['username']=='Aeyce'){
		//echo date('F jS',strtotime('+1 day',$_SESSION['todayStart'])).'<br />';
		//echo date('F jS',strtotime($_SESSION['todayStart'])).'<br />';
		//echo date('F jS',time());
		//echo date('F jS', time()) ."". date('F jS', strtotime('+1 day',$_SESSION['todayStart']));
	}
	//echo mktime($_SESSION['todayStart']);
	//echo $_SESSION['todayStart'];
	/*session_start();
	if($_SESSION['username']!='Aeyce'){
		include_once("include/check_login.php");
		if($user_ok == false){header('location: unlock.php');}
	}else{
		include_once("mybb-site-config.php");
		if (!$mybb->user['uid']){ header("location: inputtest.php");}
	}*/
	
				
	$userID = getUserID($_SESSION['username']);
	$fcrank =getUserFCardRank($userID);
	$ttldks = getStat('ttldks',$userID);
	$ttlpvstyl = getStat('ttlpvstyl',$userID);
	//error_log($ttldks);
	$fcrankFA = ($fcrank > 50 ? '<i class="fa fa-frown-o text-danger"></i>' : ($fcrank > 25 ? '<i class="fa fa-meh-o"></i>' : ($fcrank <= 25 ? '<i class="fa fa-smile-o text-success"></i>' : '')));
	$dksFA = ($ttldks < 3 ? '<i class="fa fa-frown-o text-danger"></i>' : ($ttldks >=3 && $ttldks < 7 ? '<i class="fa fa-meh-o"></i>' : ($ttldks >= 7 ? '<i class="fa fa-smile-o text-success"></i>' : '')));
	$vstylFA = ($ttlpvstyl < 3 ? '<i class="fa fa-frown-o text-danger"></i>' : ($ttlpvstyl >=3 && $ttlpvstyl < 7 ? '<i class="fa fa-meh-o"></i>' : ($ttlpvstyl >= 7 ? '<i class="fa fa-smile-o text-success"></i>' : '')));
	
	if($ttldks==0){ $ttldks = countUserDecks($userID); setStat('ttldks',$userID,$ttldks); } //make sure db is correc
	if($ttlpvstyl == 0){ $ttlpvstyl = countUserVStyle($userID); setStat('ttlpvstyl',$userID,$ttlpvstyl);}
	//error_log(var_dump($uOnline));
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Super important! Tells googlebot that this site is responsive!-->
	<meta name="robots" content="NOODP">
	<title>Lobby Home - Signed In</title>
	<meta name="description" content="We're dedicated to Japanese practice. Learn elsewhere, practice here. We feature modern design, anime flashcards, and free online Japanese practice quizzes.">
	<meta name="keywords" content="Learning Japanese, Japanese practice, online Japanese exercises, login, sign up">
	<meta property="og:title" content="Best Free Online Japanese practice site. Lobby!" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://www.jpvocab.com" />
	<meta property="og:image" content="http://www.jpvocab.com/img/as.jpg" />
	<link rel=”publisher” href=”https://plus.google.com/u/0/b/117072635220046762454/+Tehjapanesesitepractice/posts“/>
	<link rel="canonical" href="http://www.JPVocab.com/" />
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9] >
	<script src="/js/html5shiv.js">alert('Your version of Internet Explorer is not supported!');</script>
	<![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="js/ajax.js" type="text/javascript"></script>
	<script language="javascript" type="text/javascript">
		<!-- 
		//Browser Support Code
		function _(el){
			return document.getElementById(el);
		}
		function claimBonus(t, uID,rDiv){
			var vars = false;
			var ajax;
			try{
				// Opera 8.0+, Firefox, Safari
				ajax = new XMLHttpRequest();
			} catch (e){
				// Internet Explorer Browsers
				try{
					ajax = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					try{
						ajax = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e){								
						alert("Your browser broke!");
						return false;
					}
				}
			}
			var url = "scripts/script-achievements.php";
			if(t =="submit_jlpt"){
				j = _("exampleInputAmount").value;
				console.log(j);
				if(j == '1' || j=='2' || j=='3' || j=='4' || j=='5'){
					var vars = "t="+t+"&u="+uID+"&query=claim&j="+j;
				}else{
					_(rDiv).innerHTML = "Please enter either 5,4,3,2, or 1";
				}
			}else{
				var vars = "t="+t+"&u="+uID+"&query=claim";
			}
			if(vars!=false){
				ajax.open("POST", url, true);
				ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				ajax.onreadystatechange = function() {
					if(ajax.readyState == 4){
						if(ajax.responseText == "Success"){
							_(rDiv).innerHTML = "<span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span> Congratulations! You've claimed this bonus successfully!";
						}else if(ajax.responseText == "Fail"){
							_(rDiv).innerHTML = "An error occurred. Contact support@jpvocab.com for assistance.";
						}else{
							console.log("end "+ajax.responseText);
						}
					}
				}
				ajax.send(vars);
			}
		}
		function checkBonusStatus(title, uID,rDiv){
			var ajax;
			try{
				// Opera 8.0+, Firefox, Safari
				ajax = new XMLHttpRequest();
			} catch (e){
				// Internet Explorer Browsers
				try{
					ajax = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					try{
						ajax = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e){								
						alert("Your browser broke!");
						return false;
					}
				}
			}
			var url = "scripts/script-achievements.php";
			var vars = "t="+title+"&u="+uID+"&query=check";
			ajax.open("POST", url, true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.onreadystatechange = function() {
				if(ajax.readyState == 4){
					if(ajax.responseText == "claimed"){
						_(rDiv).innerHTML = "You've already claimed this!";
					}else if(ajax.responseText == "not claimed"){
						claimBonus(title,uID,rDiv);
					}else{
						console.log("rt"+ajax.responseText);
					}
				}
			}
			ajax.send(vars);
		}
	</script>
</head>
<body>
	<div id="header-wrap">
		<?php $active = "lobby"; include('include/header.php'); ?>
	</div>
	<div class="container-fluid">
		<div class="row" itemprop="breadcrumb">
			<ol class="breadcrumb" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" 
				itemscope itemtype="http://schema.org/ListItem">
				<span itemprop="name">Lobby</span>: <i>Welcome back!</i>
				<meta itemprop="position" content="1" />
				</li>
			</ol>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<!-- *************SIDEBAR**********************-->
			<div class="col-xs-12 col-sm-4 col-md-3" ><?
				include('include/template-lobbySidebar.php');?>
			</div>
			<div class="col-xs-12 col-sm-8 col-md-9" >
			<div class="page-header no-marg-top-23">
				<h2><i class="fa fa-newspaper-o"></i> News & Updates</h2></div>
				<div class="media">
					<div class="media-left media-middle">
						<a href="http://www.JPVocab.com/to/Nisemonogatari" title="Nisemonogatari's Amazon Description"><img src="img/nisemono.jpg" class="img-responsibe" style="height:65px;width:65px;" /></a>
					</div>
					<div class="media-body">
					<h4 class="media-heading">Anime Deck Survey Results!</h4>
						<a href="http://www.JPVocab.com/to/Nisemonogatari" title="Nisemonogatari's Amazon Description">Nisemonogatari</a> won! It will be completed Sunday, Oct 25th. Save your gold and check back on Sunday!
					</div>
				</div>
				<div class="media text-muted">
					<div class="media-left media-top">
						<i class="text-center media-object fa fa-search fa-3x thumbnail" style="height:65px;width:65px;"></i>
					</div>
					<div class="media-body ">
						<h4 class="media-heading">New Features</h4>
						Notice the new features? Coded by yours truly. New additions are:
						<ul>
							<li>New Lobby Area</li>
							<li>
								<a href="http://www.jpvocab.com/online-users.php" alt="Online Users" title="Online Users"><small><i class="fa fa-users"></i></small> Online Users</a></li>
							<li>
								<a href="http://www.jpvocab.com/deck-words.php" alt="View Flashcard Deck Word" title="View Flashcard Deck Word">View All Words in your Flashcard Deck</a></li>
							<li>
								Sample Flashcard Area for Guests <i>(only visible to users not logged in)</i>
							</li>
						</ul>
					</div>
				</div>
				<div class="media text-muted disabled">
					<div class="media-left media-middle">
						<a href="http://www.jpvocab.com/flashcard-rewards.php" alt="Online Japanese flashcard rewards" title="Online Japanese Flashcard Rewards">
							<i class="text-center media-object fa fa-question fa-3x thumbnail" style="height:65px;width:65px;"></i>
						</a>
					</div>
					<div class="media-body">
						<h4 class="media-heading">What the heck are Gold and Diamonds?</h4>
						Find out what the big deal is about gold and diamonds.<a href="http://www.jpvocab.com/flashcard-rewards.php" alt="Online Japanese flashcard rewards" title="Online Japanese Flashcard Rewards">Read more...</a>
					</div>
				</div>
				<div class="media text-muted">
					<div class="media-left media-middle">
						<a href="http://www.jpvocab.com/survey.php" alt="Online Japanese flashcard rewards" title="Online Japanese Flashcard Rewards">
							<i class="text-center media-object fa fa-list-ol fa-3x thumbnail" style="height:65px;width:65px;"></i>
						</a>
					</div>
					<div class="media-body">
					<h4 class="media-heading">Anime Deck Survey</h4>
						Have you voted yet? I need your help determining which anime deck I should make next. <a href="http://www.jpvocab.com/survey.php" alt="Online Japanese flashcard vote" title="Online Japanese Flashcard vote">Vote...</a>
					</div>
				</div>
			</div>
		</div>
	</div>
			<!--<p class="lead"></p>
			<p>
				<ol>
					<li><h2>Japanese Practice</h2></li>
					<ul>
						<li><h3><a href="http://www.jpvocab.com/quiz.php" title="Japanese flashcards">Flashcards</a></h3></li>
						<li><h3><a href="http://www.jpvocab.com/japanese-grammar-list.php" title="Japanese Grammar Exercises">Grammar Exercises</a></h3></li>
					</ul>
					<li><h4>Community</h4></li>
					<ul>
						<li><h4><a href="http://www.jpvocab.com/blog/" title="Japanese blog">Blog</a></h4></li>
						<li><h4><a href="http://www.jpvocab.com/forum/" title="Japanese forum">Forum</h4></li>
					</ul>
				</ol>
			</p>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-0 col-sm-1"></div>
			<div class="col-xs-12 col-sm-10">
				<div class="jumbotron no-left-right-pad">
				  <h1><?php echo $_SESSION['userLink'];?><small>さん</small>お帰り なさい！</h1>
				  <p>今日何をしますか？What will you do today?</p>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h1>Japanese Vocabulary</h1>
						<h3>Daily Flashcard Goal <small>
						Reach <?php echo $_SESSION['todayFCEnd'] . " cards";
						if($_SESSION['fcUntilEnd'] >0){?>
								<span class="label label-danger"><i>NOT MET</i></span><?php
							}else{?>
								<span class="label label-success">おめでとうございます！<i>Successfully Met</i></span><?php
						}?>
					</small>
						</h3>
						<p><strong><i>Tomorrow you need to reach <?php echo round($_SESSION['todayFCEnd']*1.1,0);?> cards.</strong></i></p>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<h2>Bonuses</h2>
						<table class="table table-bordered table-responsive">
							<tr>
								<th>Bonus Frequency</th>
								<th>Description</th>
								<th></th>
								<th>Status</th>
							</tr>
							<tr>
								<td class="col-xs-3 col-md-3"><h4>Special</h4></td>
								<td class="col-xs-3 col-md-3"><h4><?php echo getAchievInfo("dmd_reg_bonus","description");?></h4></td>
								<td class="col-xs-3 col-md-3"><?php
									if(getAchiev("dmd_reg_bonus",$_SESSION['userid'])=='0'){?>
										<button type="button" class="btn btn-info" onClick="checkBonusStatus('dmd_reg_bonus',<?php echo $_SESSION['userid'];?>,'bonus1');">Claim <span class="label label-default">+50 DMD</span> Bonus</button><?php
									}else{?><span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span> Congrats! You've already claimed this bonus!<?php }?>
								</td>
								<td class="col-xs-3 col-md-3">
									<span id="bonus1"></span>
								</td>
							</tr><?php if(isAdmin($_SESSION['username'])){?>
							<tr>
								<td class="col-xs-3 col-md-3"><h4>Special</h4></td>
								<td class="col-xs-3 col-md-3"><h4><?php echo getAchievInfo("submit_jlpt","description");?></h4></td>
								<td class="col-xs-3 col-md-4"><?php 
									if(getAchiev("submit_jlpt",$_SESSION['userid'])=='0'){?>
										<div class="col-xs-12">
											<div class="form-inline">
											  <div class="form-group">
												<label class="sr-only" for="exampleInputAmount">JLPT Number</label>
												<div class="input-group">
												  <div class="input-group-addon">JLPT N</div>
												  <input type="text" class="form-control" id="exampleInputAmount" placeholder="1, 2, 3, 4, or 5" maxlength="1" autocomplete="off">
												</div>
											  </div>
											  <button type="submit" class="btn btn-primary" onClick="checkBonusStatus('submit_jlpt',<?= $_SESSION['userid'];?>,'bonus2');">Submit and Claim <span class="label label-warning">+50 GC</span></button>
											</div>
										</div><?php
									}else{?><span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span> Congrats! You've already done this!<?php }?>
								</td>
										<td class="col-xs-3 col-md-2">
											<span id="bonus2"></span>
										</td>
							</tr><? }?>
							<!--<dt>Daily Sign in</dt>
							<dd><button type="button" class="btn btn-default btn-sm">Claim <span class="label label-warning">+50 GC</span></button></dd>-->
						<!--</table>
					</div>
				</div><!--end row-->
			<!--</div>
			<div class="col-xs-0 col-sm-2"></div>
		</div>
	</div>-->
		<!-- ********************Include Footer ******************************--><?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/include/footer-new.php'); ?>
	<!-- ********************JS ******************************-->
	
	<!--<script type="text/javascript" src="js/scrolltest.js"></script>-->
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
</body>
</html>