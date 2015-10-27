<?php
	header('Content-Type: text/html; charset=utf-8');	
	include_once("include/check_login.php");
	include("stats.php");
	countTypeOwners('anime');
	//if($user_ok == false){header('location: restricted.php?refPage=buy');}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Super important! Tells googlebot that this site is responsive!-->
	<meta name="robots" content="NOODP">
	<title>Japanese Vocabulary Flashcard Decks</title>
	<meta name="description" content="Unlock JPVocab sets at JPVocab.com">
	<meta name="keywords" content="Japanese flashcard exercises, Japanese flash card exercises, Japanese vocabulary, Japanese exercises">
	<meta name="author" content="Benjamin Cann">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.jpvocab.com/js/bootstrap.min.js"></script>
	
	<meta property="og:title" content="Unlock JPVocab sets at JPVocab.com" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://www.JPVocab.com/unlock.php" />
	<meta property="og:image" content="http://www.JPVocab.com/img/unlock4.png" />
	
	
	
	<link rel=”publisher” href=”https://plus.google.com/u/0/b/117072635220046762454/+TehJapanesepractice/posts“/>
	<link rel="canonical" href="http://www.JPVocab.com/unlock.php" />
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">-->
	<!--[if lt IE 9] >
	<script src="/js/html5shiv.js">alert('Your version of Internet Explorer is not supported!');</script>
	<![endif]-->
	
</head>
<body itemscope itemtype="https://schema.org/ItemPage">
	<?php if($user_ok==false){include('include/header1.php');}else{include('include/header.php');} ?>
	
	<!--<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="3000">
	  <!-- Indicators -->
	  <!--<ol class="carousel-indicators">
		<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		<li data-target="#carousel-example-generic" data-slide-to="1"></li>
		<li data-target="#carousel-example-generic" data-slide-to="2"></li>
	  </ol>
	  <!-- Wrapper for slides -->
	 <!-- <div class="carousel-inner">
		<div class="item active">
		  <img src="img/slide-JLPT.jpg" alt="...">
		  <div class="carousel-caption">
			<a type="button" class="btn btn-success" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=JLPT&d=" title="Browse Japanese Language Proficiency test Vocabulary">Browse <i><strong>JLPT</strong></i> Decks</a>
		  </div>
		</div>
		<div class="item">
		  <img src="img/slide-anime.jpg" alt="...">
		  <div class="carousel-caption">
			<a type="button" class="btn btn-success" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Anime&d=" title="Browse Japanese Anime Vocabulary">Browse <i><strong>Anime</strong></i> Decks</a>
		  </div>
		</div>
		<div class="item">
		  <img src="img/slide-beginner.jpg" alt="...">
		  <div class="carousel-caption">
			<a type="button" class="btn btn-success" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Beginner&d=" title="Browse Japanese Beginner Vocabulary">Browse <i><strong>Beginner</strong></i> Decks</a>
		  </div>
		</div>
		<div class="item">
		  <img src="img/slide-textbook.jpg" alt="...">
		  <div class="carousel-caption">
			<a type="button" class="btn btn-success" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Textbook&d=" title="Browse Japanese Textbooks Vocabulary">Browse <i><strong>Textbook</strong></i> Decks</a>
		  </div>
		</div>
		<div class="item">
		  <img src="img/slide-verbs.jpg" alt="...">
		  <div class="carousel-caption">
			<a type="button" class="btn btn-success" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Verbs&d=" title="Browse Japanese Verb Vocabulary">Browse <i><strong>Verbs</strong></i> Decks</a>
		  </div>
		</div>
	  </div>
	  <!-- Controls -->
	<!-- <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	  </a>
	</div>-->
	
	 <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
<div class="container-fluid">
	<div class="row" itemprop="breadcrumb">
		<ol class="breadcrumb" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
		  <li itemprop="itemListElement" 
			itemscope itemtype="http://schema.org/ListItem">
			<a href="http://www.JPVocab.com/" title="Home" itemprop="item">
			<span itemprop="name">Home</span></a>
			<meta itemprop="position" content="1" />
		</li>
		  <!--<li itemprop="itemListElement" 
			itemscope itemtype="http://schema.org/ListItem">
			<a href="http://www.JPVocab.com/quiz.php" title="Japanese Flashcards" itemprop="item">
			<span itemprop="name">Japanese Flashcards</span></a>
			<meta itemprop="position" content="2" />
		</li>-->
		  <li itemprop="itemListElement" 
			itemscope itemtype="http://schema.org/ListItem">
			<span itemprop="name">Deck Types</span>
			<meta itemprop="position" content="2" />
		</li>
	</div>
</div>
    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row text-center">
        <div class="col-xs-6 col-sm-4">
          <a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Beginner&d=" ><img class="img-circle" src="img/unlock-beginner.png" alt="commons.wikimedia.org/wiki/File:Hiragana-strokes-k.png" title="Learn Beginner Japanese Online" width="140" height="140"></a>
          <h2>Beginner</h2>
          <p>A few vocab sets for those who are just starting out in Japanese.</p>
          <p><a class="btn btn-default" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Beginner&d=" role="button">Beginner Decks &raquo;</a></p>
        </div><!-- /.col-lg-3 -->
        <div class="col-xs-6 col-sm-4">
          <a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Anime&d=" ><img class="img-circle" src="img/unlock-anime.png" alt="commons.wikimedia.org/wiki/File:Anime-Wallpaper-2.jpg" title="Learn Japanese Anime Vocabulary" width="140" height="140"></a>
          <h2>Anime</h2>
          <p>A collection of fun flashcards sets made from the scripts of popular Japanese anime.</p>
          <p><a class="btn btn-default" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Anime&d=" role="button">Anime Decks &raquo;</a></p>
        </div><!-- /.col-lg-3 -->
        <div class="col-xs-6 col-sm-4">
          <a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=JLPT&d=" ><img class="img-circle" src="img/unlock-jlpt.png" alt="Toby Oxborrow's Flikr Passed" title="Study JLPT Vocab to Pass" width="140" height="140"></a>
          <h2>JLPT</h2>
          <p>A series of vocab and kanji flashcard decks helping you pass the Japanese Language Proficiency Test, aka JLPT.</p>
          <p><a class="btn btn-default" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=JLPT&d=" role="button">JLPT Flashcards &raquo;</a></p>
        </div><!-- /.col-lg-3 -->
        <div class="col-xs-6 col-sm-4">
          <a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Textbook&d=" ><img class="img-circle" src="img/unlock-textbook.png" alt="commons.wikimedia.org/wiki/File:Japanese_textbooks" title="Learn Japanese Vocabulary from Textbooks" width="140" height="140"></a>
          <h2>Textbook</h2>
          <p>Minna no Nihongo vocabulary converted to our flashcard decks.</p>
          <p><a class="btn btn-default" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Textbook&d=" role="button">Textbook Vocabulary &raquo;</a></p>
        </div><!-- /.col-lg-3 -->
		<div class="col-xs-6 col-sm-4">
         <a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Verbs&d=" ><img class="img-circle" src="img/unlock-verbs.png" alt="Learn Japanese Verbs Online" title="Learn Japanese Verbs Online" width="140" height="140"></a>
          <h2>Verbs</h2>
          <p>Featuring 501 Verbs you absolutely must know as a Japanese learner.</p>
          <p><a class="btn btn-default" href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Verbs&d=" role="button">Japanese Verbs Decks &raquo;</a></p>
        </div><!-- /.col-lg-3 -->
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Beginner vocab sets. <span class="text-muted">Get started right!</span></h2>
          <p class="lead">Our beginner set of flash card decks help you with your first steps in Japanese. Many practicing these decks tell us <b>they love the <u>audio flashcards</u> feature</b>.</p>
        </div>
        <div class="col-md-5">
         <a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Beginner&d=" ><img class="img-circle" src="img/unlock-beginner.png" alt="commons.wikimedia.org/wiki/File:Hiragana-strokes-k.png" title="Learn Beginner Japanese Online" width="140" height="140"></a>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 col-md-push-5">
          <h2 class="featurette-heading">These anime decks are rare.<span class="text-muted"> Only for JPVocab users</span></h2>
          <p class="lead">You won't find these decks anywhere else...</p> <p class="lead">Because we made them from scratch ourselves.</p><p class="lead">We're quite proud of the quality that went into making these anime vocabulary. We did something called text-frequency analysis and a bunch of other computer magic to bring you the most used words in each anime.</p>
        </div>
        <div class="col-md-5 col-md-pull-7">
          <a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Anime&d=" ><img class="img-circle" src="img/unlock-anime.png" alt="commons.wikimedia.org/wiki/File:Anime-Wallpaper-2.jpg" title="Learn Japanese Anime Vocabulary" width="140" height="140"></a>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">The JLPT decks. <span class="text-muted">They're massive.</span></h2>
          <p class="lead">Some websites think they're helping JP learners by simply handing off a list of JLPT vocab and saying 'Good luck!'</p> <p class="lead">We wanted to do even more.</p> <p class="lead">  We wanted to <b>give you <u>a way</u></b> to use a list of vocab. So we made you an browser-based flashcard system and fed a list of JLPT words into it. Try it out!</p>
        </div>
        <div class="col-md-5">
           <a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=JLPT&d=" ><img class="img-circle" src="img/unlock-jlpt.png" alt="Toby Oxborrow's Flikr Passed" title="Study JLPT Vocab to Pass" width="140" height="140"></a>
        </div>
      </div>

      <hr class="featurette-divider">
     
      <div class="row featurette">
        <div class="col-md-7 col-md-push-5">
          <h2 class="featurette-heading">Textbook vocabulary. <span class="text-muted">Already made!</span></h2>
          <p class="lead">We've all had the pleasure of spending hours making flashcard decks for every single textbook chapter. Often when we've finished there isn't enough time to study! Our textbook Japanese vocab sets have one chapter of words per level. So if you ace Minna no Nihongo's level 1, you've know all chapter 1 vocab from it!</p>
        </div>
        <div class="col-md-5 col-md-pull-7">
          <a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=Textbook&d=" ><img class="img-circle" src="img/unlock-textbook.png" alt="commons.wikimedia.org/wiki/File:Japanese_textbooks" title="Learn Japanese Vocabulary from Textbooks" width="140" height="140"></a>
        </div>
      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->


      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2015 JPVocab.com, Inc. &middot; <!--<a href="#">Privacy</a> &middot; <a href="#">Terms</a>--></p>
      </footer>

    </div><!-- /.container -->
	<!-- ********************Include Footer ******************************--><?php
	include_once($_SERVER['DOCUMENT_ROOT']."/include/footer-new.php"); ?>
	<script type='text/javascript' src='https://plasso.co/embed/v2/embed.js'></script>
</body>
</html>