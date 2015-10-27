<?php
	include_once("include/check_login.php");
	require_once 'words.php';
	require_once 'stats.php';
	require_once 'config.php';
	$conn = mysql_connect($dbhost,$dbuser,$dbpass)
			or die('Error connecting to mysql');
	mysql_select_db($dbname);
	mysql_query("SET NAMES UTF8");
	if($user_ok == false){ 
		$_SESSION['username']='Guest';
		$userID = getUserID("Sample");
		$fcrank ="None";
		$ttldks = "No";
		$ttlpvstyl = "No";
		$fcrankFA = '<i class="fa fa-frown-o text-danger"></i>';
		$dksFA = '<i class="fa fa-frown-o text-danger"></i>';
		$vstylFA = '<i class="fa fa-frown-o text-danger"></i>';
		$uOff = getOfflineUsers();
	}else{
		$userID = getUserID($_SESSION['username']);
		$fcrank =getUserFCardRank($userID);
		$ttldks = getStat('ttldks',$userID);
		$ttlpvstyl = getStat('ttlpvstyl',$userID);
		$fcrankFA = ($fcrank > 50 ? '<i class="fa fa-frown-o text-danger"></i>' : ($fcrank > 25 ? '<i class="fa fa-meh-o"></i>' : ($fcrank <= 25 ? '<i class="fa fa-smile-o text-success"></i>' : '')));
		$dksFA = ($ttldks < 3 ? '<i class="fa fa-frown-o text-danger"></i>' : ($ttldks >=3 && $ttldks < 7 ? '<i class="fa fa-meh-o"></i>' : ($ttldks >= 7 ? '<i class="fa fa-smile-o text-success"></i>' : '')));
		$vstylFA = ($ttlpvstyl < 3 ? '<i class="fa fa-frown-o text-danger"></i>' : ($ttlpvstyl >=3 && $ttlpvstyl < 7 ? '<i class="fa fa-meh-o"></i>' : ($ttlpvstyl >= 7 ? '<i class="fa fa-smile-o text-success"></i>' : '')));
	}
		$uOff = getOfflineUsers();
		$uOn = getOnlineUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Super important! Tells googlebot that this site is responsive!-->
	<meta name="robots" content="NOODP">
	<title>Users Learning Japanese at JPVocab.com</title>
	<meta name="description" content="We're dedicated to Japanese practice. Learn elsewhere, practice here. We feature modern design, anime flashcards, and free online Japanese practice quizzes.">
	<meta name="keywords" content="Learning Japanese, Japanese practice, online Japanese exercises, login, sign up">
	<meta property="og:title" content="Best Free Online Japanese practice site. Lobby!" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://www.tehJapaneseSite.com" />
	<meta property="og:image" content="http://www.tehJapaneseSite.com/img/as.jpg" />
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
	<script src="js/update-status.js" type="text/javascript"></script>
	<script src="js/ajax.js" type="text/javascript"></script>
	<script language="javascript" type="text/javascript">
		<!-- 
		//Browser Support Code
		function _(el){
			return document.getElementById(el);
		}
	</script>
</head>
<body>
	<div id="header-wrap">
		<? ($_SESSION['username']=='Guest' ? include('include/header1.php') : include('include/header.php') )?>
	</div>
	<div class="container-fluid">
		<div class="row" itemprop="breadcrumb">
			<ol class="breadcrumb" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" 
					itemscope itemtype="http://schema.org/ListItem">
						<a href="http://www.JPVocab.com/lobby.php" title="Home" itemprop="item">
							<span itemprop="name">Home</span>
						</a>
						<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" 
					itemscope itemtype="http://schema.org/ListItem">
						<span itemprop="name">Users</span>
						<meta itemprop="position" content="2" />
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
			<!--**************ONLINE USERS****************-->
			<div class="col-xs-12 col-sm-8 col-md-9" >
				<div class="page-header no-marg-top-23">
					<h2><i class="fa fa-users"></i> Online Users</h2>
				</div>
				<div class="media"><?
					foreach($uOn as $row=>$user){?>
						<div class="media-left media-top">
							<a href="http://www.jpvocab.com/player.php?player=<?= $user['username'];?>&report=summary" alt="<?= $user['username'];?> Profile" title="<?= $user['username'];?> Profile">
								<i class="text-center media-object fa fa-user fa-3x thumbnail  text-success" style="height:65px;width:65px;"></i>
							</a>
						</div>
						<div class="media-body">
							<h4 class="media-heading"><a href="http://www.jpvocab.com/player.php?player=<?= $user['username'];?>&report=summary" alt="<?= $user['username'];?> Profile" title="<?= $user['username'];?> Profile"><?= $user['username'];?></a></h4>
							<table class="table table-condensed borderless thin marg-bot-0">
								<tr>
									<td class="col-xs-3">
										<small><small><a href="http://www.JPVocab.com/player.php?player=<?= $user['username'];?>&report=flashcardrank">Flashcard Ranking</a>: <?= ordinal(getUserFCardRank($user['id'])); ?></small>
									</td>
									<td>
										<small>Currently Practicing
										<a href="<?= getDeckFullUrl(getSkill('cvset',$user['id']));?>">
											<?= getDeckInfo(getSkill('cvset',$user['id']),'display_name'); ?>
										</a></small>
									</td>
								</tr>
								<tr><td colspan="2"><small><b><?= getStat('ttldks',$user['id']); ?></b> Decks owned</small></td></tr>
								<tr><td colspan="2"><small><b><?= getStat('ttlpvstyl',$user['id']); ?></b> Quiz Modes owned</small></td></tr>
							</table>
							
						</div>
						<hr><?
					}?>
				</div>
				<!--**************OFFLINE USERS****************-->
				<div class="page-header no-marg-top-23">
					<h2><i class="fa fa-users"></i> Offline Users</h2>
				</div>
				<div class="media"><?
					foreach($uOff as $row=>$user){?>
						<div class="media-left media-top">
							<a href="http://www.jpvocab.com/player.php?player=<?= $user['username'];?>&report=summary" alt="<?= $user['username'];?> Profile" title="<?= $user['username'];?> Profile">
								<i class="text-center media-object fa fa-user fa-3x thumbnail text-muted" style="height:65px;width:65px;"></i>
							</a>
						</div>
						<div class="media-body">
							<h4 class="media-heading"><a href="http://www.jpvocab.com/player.php?player=<?= $user['username'];?>&report=summary" alt="<?= $user['username'];?> Profile" title="<?= $user['username'];?> Profile"><?= $user['username'];?></a></h4>
							<table class="table table-condensed borderless thin marg-bot-0">
								<tr>
									<td class="col-xs-3">
										<small><small><a href="http://www.JPVocab.com/player.php?player=<?= $user['username'];?>&report=flashcardrank">Flashcard Ranking</a>: <?= ordinal(getUserFCardRank($user['id'])); ?></small>
									</td>
									<td>
										<small>Currently Practicing
										<a href="<?= getDeckFullUrl(getSkill('cvset',$user['id']));?>">
											<?= getDeckInfo(getSkill('cvset',$user['id']),'display_name'); ?>
										</a></small>
									</td>
								</tr>
								<tr><td colspan="2"><small><b><?= getStat('ttldks',$user['id']); ?></b> Decks owned</small></td></tr>
								<tr><td colspan="2"><small><b><?= getStat('ttlpvstyl',$user['id']); ?></b> Quiz Modes owned</small></td></tr>
							</table>
							
						</div>
						<hr><?
					}?>
				</div>
			</div>
		</div>
	</div>
		<!-- ********************Include Footer ******************************--><?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/include/footer-new.php'); ?>
	<!-- ********************JS ******************************-->
	
	<!--<script type="text/javascript" src="js/scrolltest.js"></script>-->
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
</body>
</html>