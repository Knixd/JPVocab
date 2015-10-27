<?php 
	include_once("googleanalytics.php"); 
	include_once($_SERVER['DOCUMENT_ROOT']."/stats.php");
	$uOn = getOnlineUsers();
	$uOnQ = '<b><span id="uOn">'.sizeOf($uOn).'</span></b>' . (sizeOf($uOn)==1 ? " User " : " Users ") . "Online";
?>
<style type="text/css">
	#loginStatus{color:#e0e0e0;}
</style>
<header>
<div class="navbar navbar-default" role="navigation"  itemscope itemtype="http://schema.org/SiteNavigationElement">
    <div class="container" id="topAnchor">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div  itemprop="url"><a class="navbar-brand" href="http://www.JPVocab.com" title="Home"  itemprop="name"><b><span class="text-danger">JP</span><span class="text-primary">Vocab</span></b><span class="text-muted">.com</span></a></div>
        </div>
        <center>
            <div class="navbar-collapse collapse pull-right" id="navbar-main">
                <ul class="nav navbar-nav">
                    <li itemprop="url"><a href="http://www.JPVocab.com/lobby.php" title="Japanese Flashcards Home - JPVocab"  itemprop="name"><small><span class="glyphicon glyphicon-home text-muted" aria-hidden="true"></span></small> Lobby</a></li>
					<li itemprop="url"><a href="http://www.JPVocab.com/unlock.php">Japanese Flashcard Sets</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Flashcards<span class="caret"></span></a>
						  <ul class="dropdown-menu">
							<li itemprop="url"><a href="http://www.JPVocab.com/quiz.php" class=""><b><span class="glyphicon glyphicon-education " aria-hidden="true"></span> &nbsp;Study Flashcards</b></a></li>
							<li role="separator" class="divider"></li>
							<li class="dropdown-header">Flashcard Options</li>
							<li itemprop="url"><a href="http://www.JPVocab.com/deck-words.php" class=""><i class="fa fa-book fa-fw text-muted" aria-hidden="true"></i> View Flashcard Words</a></li>
							<li role="separator" class="divider"></li>
							<!--<li><a href="http://www.JPVocab.com/player.php?player=<?= $_SESSION['username'];?>&report=deckdetails"><small><span class="glyphicon glyphicon-stats text-muted" aria-hidden="true"></span></small> &nbsp;My Flashcard Stats</a></li>-->
							<li itemprop="url"><a href="http://www.JPVocab.com/mydecks.php"><i class="fa fa-line-chart text-muted" aria-hidden="true"></i> &nbsp;My Progress</a></li>
							<li><a href="http://www.JPVocab.com/player.php?player=<?= $_SESSION['username'];?>&report=flashcardrank"><small><span class="glyphicon glyphicon-king text-muted" aria-hidden="true"></span></small> &nbsp;Flashcard Rankings</a></li>
						  </ul>
					</li>
                    <!--<li <?php //if($user_ok == true){?>  itemprop="url">
						<a href="http://www.JPVocab.com/grammar.php" title="Japanese Grammar Practice"  itemprop="name">
							<span class="text-danger">JP</span><span class="text-primary">Drills</span><span class="text-muted">.com</span>
						</a></li>-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><small><span class="glyphicon glyphicon-user text-muted" aria-hidden="true"></span></small> <?= $_SESSION['username'];?><span class="caret"></span></a>
						  <ul class="dropdown-menu"><?
						  if($user_ok == true){?>
							<li itemprop="url">
								<a href="http://www.JPVocab.com/player.php?player=<?= $_SESSION['username'];?>&report=summary" title="Japanese Flashcard Stats"  itemprop="name">
									<i class="fa fa-user fw"></i> My Profile
								</a>
							</li>
							<li itemprop="url">
								<a href="http://www.JPVocab.com/users.php" title="Japanese Flashcard Stats"  itemprop="name">
								<i class="fa fa-users fw"></i> Browse Users
								</a>
							</li>
							<li role="separator" class="divider"></li>
								<li itemprop="url">
									<a href="http://www.JPVocab.com/logout.php" title="JPVocab.com Logout"  itemprop="name">
										<span class="glyphicon glyphicon-log-out small" aria-hidden="true"></span> Logout 
									</a>
								</li><? 
							}else{ ?>
								<li itemprop="url">
									<a href="http://www.JPVocab.com/" title="Register for free Japanese Flashcards online"  itemprop="name">Register
									</a>
								</li><?
							} ?>
						  </ul>
					</li>
                </ul>
            </div>
        </center>
    </div>
</div>
</header>
<?php
if(isset($_SESSION['username'])){?>
	<div class="container">
	<div class="row no-marg-top-23" style="font-size:0.8em">
		<div class="col-xs-12 col-sm-6 text-left">
				<a href="http://www.JPVocab.com/users.php" alt="Online JPVocab Users" title="View Online Users"><u><?= $uOnQ;?></u></a>
		</div>
		<div class="col-xs-12  col-sm-6 pull-right text-right">
			<span>You have <b><span id="headerGC" class="text-success"><?= getStat('gold',$_SESSION['userid']);?></span></b> <span class="label label-warning">Gold Coins</span>
			<!--and <span class="label label-default"><?php echo getStat('diamonds',$_SESSION['userid']);?> Diamonds</span> <a href="http://www.JPVocab.com/diamond.php" title="Get Diamonds"><i>Get Diamonds</i></span></a>-->
		</div>
	</div>
	</div>
	<?php
}?>
<script src="../js/update-status.js" type="text/javascript"></script>