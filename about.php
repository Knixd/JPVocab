<?php
	include_once("include/check_login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>About JPVocab.com - Who's behind these Japanese flashcards?</title>
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">-->
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9] >
	<script src="/js/html5shiv.js">alert('Your version of Internet Explorer is not supported!');</script>
	<![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	
</head>
<body>
<?php include_once("scripts/scriptaddthis.php");
	include('include/header1.php'); ?>
	<section>
		<div class="container">
			<div class="row panel panel-default">
				<div class="col-xs-12 panel-heading"><h1 class="text-center">About JPVocab</h1></div>
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<p>Welcome to JPVocab! I'm Ben Cann, and I'm so grateful you're here when I know there's a billion other Japanese sites wanting your attention.</p>
					<p>You might think I started this site simply because I crave the daily ritual of practicing Japanese flashcards. Actuallly, this isn't completely false. I've gone through the craziest Anki flashcard regimes (self-inflicted) and learned a ton. But really, <b>I created JPVocab because I care so much about Japanese learners.</b></p>
					<p>Japanese learners are some of the hardest working, adventurous people that I've met. Unfortunately, many learners get discouraged and quit Japanese before enjoying benefits of their studies. It doesn't help that most learners study Japanese alone, wondering what other learners are doing. It doesn't have to be like this...</p>
					<p>Enter JPVocab: Your flashcard system that adds a pinch of peer community while increasing your Japanese vocabulary and kanji prowess through our addictive flashcard system.</p>
					<h2>JPVocab will help you build you vocabulary and kanji knowledge faster than making your own cards through Anki</h2>
					<p>At JPVocab, we believe that your time is valuable. You may not always have an hour or more to make a set of 30 awesome flashcards on Anki (or more if you make your flashcards by hand!). All our Japanese flashcard decks have been personally made by us, for you. We've even utilized some complicated programming to make flashcard decks for some popular anime series for all our anime fans.</p>
					<p>Ultimately, consistent practice will increase your retention. Our goal at JPVocab was to design an easy-to-use flashcard system to record your progress over time so you can see yours and others progress, building each other up when motivation fails us. So, if you've ever asked yourself "How many flashcards JLPT N3 users do everyday?" or "What amount of flashcards, on average, do I have to do to get to JLPT N5?" or "Why can't I bring myself to study flashcards right now?" or simply "What are other people doing?", then you've come to the right place!</p>
					<p>To join our community of Japanese learners receiving access to the best flashcards around, register and <b>we'll throw in our Hiragana and Minna no Nihongo decks</b>. Free!</p>
				<div class="col-md-1"></div>
			</div>
			<div class="col-xs-12 text-center panel-footer">
				<h2><a href="http://www.JPVocab.com/" alt="JPVocab login" title="Register your account!">Register and receive my two free decks!</a></h2>
			</div>
		</div>
	</section>
	<!--<section id="welcome-wrap1" class="welcome-wrap">
		<div class="innerContainer">
			<div class="inner-wrap">
				<div class="innerLeft">
					<div class="innerLeft-wrap">
						<h1>Intermediate Japanese Practice Site</h1>
						<div id="introHome">
							<h5>
								<b>Japanese learners who want to practice, this is for you.</br></br>
								I made this site so that I could practice practice practice. You can read all the Japanese grammar rules you want but it's better to learn by doing. This site is continually updating.</br></br>
								</br></br><a href="https://plasso.co/benjamincann@gmail.com" target="_blank"><span style="border:1px solid red; border-radius:5px; line-height:1.2em; font-size:1.2em; padding:5px;">Support Us</span></a>
							</h5>
						</div>
					</div>
				</div>
				<div class="innerRight">
					<div id="register">
						<h3>Sign Up</h3>
						<form name="signupform" id="signupform" onsubmit="return false;" style="font-color:white;">
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
							</div>
							<div class="regRow">
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
							</div>
							<div class="regRow">
								<button id="signupbtn" onclick="signup()">Create Account</button>
							</div>
							<div class="regRow">
								<span id="statusReg"></span>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div><!--end #innerContainer-->
	<!--</section>
	<section id="welcome-wrap2" class="welcome-wrap">
		<div class="innerContainer">
			<div class="inner-wrap">
				<div id="welcome2">
					<div class="welTitle">
						<h1>WELCOME!</h1>
					</div>
					<div id="wel2Aside" class="welAside">
						Out of the bazillion sites out there, you're here. Thank you for that.
					</div>
					<div id="wel2Message" class="welMessage">
						<h5>Being here means that you take studying Japanese seriously. You're willing to spend the energy, effort, and money (if it's worth it) to achieve your personal goals.
						</br></br>
						Let us help.</h5>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section id="welcome-wrap3" class="welcome-wrap">
		<div class="innerContainer">
			<div class="inner-wrap">
				<div class="welcomeFull">
					<div class="welTitle">
						<h2>Intermediate Japanese Learning</h2>
					</div>
					<div class="welMessage welFullMessage">
						<h5>There are a ton of fantastic Japanese learning sites for beginner Japanese; and then, of course, the whole Japanese world for the advanced. Take a quick search for <a href="http://lmgtfy.com/?q=intermediate+japanese">"intermediate Japanese"</a> and you'll see that, compared to beginner and advanced materials, there's a gap.</h5>
						<h5><b>This site attempts to fill the gap of non-existent intermediate Japanese material by practice.</b></br>
						At the intermediate level, we already know what we don't know. Just let us practice! Let us build our vocabulary even more!</br>Where's the platform?</h5>
						<h5>Our <b>Vocabulary Trainer</b> builds vocabulary and the <b>Fill-In-The-Blank Sentence Bank</b> quizzes our dormant grammar skills.</h5>
						
						<!--specific grammar We've already learned a ton of vocab and grammar; and, some of us, myself included, have already lived in Japan! What we need is an opportunity to review and practice what we've already learned in a convenient way. That is this site. This site caters
						to the Intermediate Japanese language learner who, fueled by their own motivation, doesn't need explanations, but wants practice.</h5>
						<h5>Aside from the extensive Japanese vocab trainer that even utilizies statistics and text analysis for Japanese Anime Vocabulary decks, JapaneseGame at NVent provides a fill in the blank system where you can specify the exact type of sentences you want! This is because <b>intermediate Japanese learners already know what they need.</b> We want to help you do this, and help you keep track of it.</h5>
						<h5><b>This site is being expaned continuously.</b> Phase I includes a Japanese vocabulary trainer, a Vocabulary deck store, blog, and your account particulars. Phase II and III will be released as they are developed. They include some simple game aspects and more methods of practical Japanese practice.</h5>-->
						<!--<h5></h5>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="welcome-wrap4" class="welcome-wrap">
		<div class="innerContainer">
			<div class="inner-wrap">
				<div class="innerLeft innerLeftFeat">
					<div class="innerLeft-wrap">
						<h1>Japanese Vocabulary Trainer</h1>
						<div class="welAside welAsideFeat">
							Don't you want to build towards something?
						</div>
						<div class="welMessage welMessageFeat">
							<h5>We've all done flashcards, but this vocab trainer is different:
								<ul>
									<li>Choose your format:</li>
										<ul>
											<li>Kanji &amp; Hiragana to English</li>
											<li>Kanji to English</li>
											<li>Kanji to Hiragana</li>
										</ul>
									<li>Recieve money for right answers,</li>
									<li>Recieve experience points per answer: correct = more, incorrect = points taken away</li>
										<ul>
											<li>Levels should represent your current knowledge, thus levelling goes either way</li>
										</ul>
									<li>Japanese Vocab Decks have levels - each level introduces 30-40 new vocabulary,</li>
										<!--<ul>
											<li><b>If</b> you max your deck level, you have a good idea of that deck topics vocab</li>
										</ul>-->
									<!--<li>Buy Japanese Vocab Decks in the store using in-game currency you've earned</li>
										<ul>
											<li>Decks: Anime($); Textbooks($$$); Sentence Elements($$) Verbs, Nouns..; Survival etc</li>
											<!--<li>Anime: Gintama, One Piece, Naruto, Bleach, ... you choose!</li>
											<li>Textbooks: Minna no Nihongo, Genki...</li>
											<li>Sentence elements: Verbs, Adjectives, Nouns, Adverbs...,</li>-->
										<!--</ul>
									<li>Buy Sentence Vocab Decks, memorize and practice words in context ($$)</li>
								</ul>
							</h5>
						</div>
					</div>
				</div>
				<div id="innerRightS4" class="innerRight">
					<div class="sImgFeat">
						<img src="img/vtthumg.jpg" height="" width="">
					</div>
					<div class="sImgFeatCap welMessage inner-wrap">
						Terribly simple design aimed towards practical and convenient use
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="welcome-wrap5" class="welcome-wrap">
		<div id="fibselectContainter" class="container_24 prefix_4 rounded">
			<div id="fibselect-inner">
				<div class="fibStitleContainer">
				<h1 style="text-align:center; color:#fff; margin-top:15px; margin-botton:-10px; font-size:3.5em;">Japanese Particle Practice</h1>
					<div class="fibStitleInner" id="fibchoiceTitle">
						<h2>Choose from the answers below.</h2>
						<div id="choiceContainer">
								<span class="fibchoice" onMouseDown="input('の')" style="cursor:pointer;">の</span>
								<span class="fibchoice" onMouseDown="input('から')" style="cursor:pointer;">から</span>
								<span class="fibchoice" onMouseDown="input('まで')" style="cursor:pointer;">まで</span>
								<span class="fibchoice" onMouseDown="input('が')" style="cursor:pointer;">が</span>
								<span class="fibchoice" onMouseDown="input('を')" style="cursor:pointer;">を</span>
						</div>
					</div>
				</div>
				<div class="fibStitleContainer">
					<div class="fibStitleInner" id="fibchoiceTitle">
						<div class="fibSent">
							私<input type='text' id="sam1" class="fibPIn" size="15" style="width=50px;" maxlength="15" autocomplete="off" />会社は９時<input type='text' id="sam2" class="fibPIn" size="15" style="width=50px;" maxlength="15" autocomplete="off" />５時<input type='text' id="sam3" class="fibPIn" size="15" style="width=50px;" maxlength="15" autocomplete="off" />です。
						</div>
					</div>
				</div>
				<p>
				<a href="#welcome-wrap1"><input id="regAnc" type="submit" class="fibSubmit" name="action" value="Answer!"/></a></p>
			</div><!--end fib .grid_12-->
		<!--</div><!--end #fibselectContainter-->
	<!--</section>
	<section id="welcome-wrap6" class="welcome-wrap">
		<div class="innerContainer">
			<div class="inner-wrap">
				<div class="welcomeFull">
					<div class="welTitle">
						<h2>About Me</h2>
						<div class="welAside">
							I answer some frequent questions!
						</div>
					</div>
					<div id="s6Message" class="welMessage welFullMessage welMessageFeat">
						<h4><div class="QA">Q: </div>What do you do? Programmar? English teacher in Japan?</h4>
							<h5><div class="QA">A: </div>"Currently I'm economics grad student in Canada specializing in applied econometrics."</h5>
						<!--<h4><div class="QA">Q: </div>Is your major Japanese?</h4>
							<h5><div class="QA">A: </div>"Believe it or not, it's not Japanese, not computer science, it's economics. Straight up Survival Analysis with nonlinear time series forecasting using neural nets regarding start-ups and their degree of success or failure based on only their initial data econometrics with renowned <a href="http://davegiles.blogspot.ca/">David Giles</a> as my supervisor."</h5>
						<h4><div class="QA">Q: </div>Sounds tough, is it?</h4>
							<h5><div class="QA">A: </div>"lol, my friends help me a lot."</h5>-->
						<!--<h4><div class="QA">Q: </div>Why make this Japanese site?</h4>
							<h5><div class="QA">A: </div>"I started making this site for myself during my undergrad exchange in Kyoto out of frustration due to the plethora of online practice sites that stop after the beginning stages. I needed long term intermediate practice that remembered my progress. This is what it turned into.</h5>
						<h4><div class="QA">Q: </div>What do you mean, frustration?</h4>
							<h5><div class="QA">A: </div>"This is a long story so skip it if you don't care. I was living the dream and studying Japanese in Japan. I was making tremendous progress having been intensely motivated to study and then it happened. One day I couldn't bring myself to open my textbooks. Insane. I couldn't be criticized. I was doing everything right:
								<ul><ul><li>living in Japan immersed,</li>
									<li>enrolled in Doshisha's intensive Japanese language "Bekka" program,</li>
									<li>regularly studying &amp; speaking,</li>
									<li>never speaking English...</li>
								</ul></ul>
							It seems my mind couldn't handle another day with <i>those</i> textbooks. I needed something different and searched online for different material that wouldn't waste my time. As a non-beginner, I knew what I needed. I didn't find it. (<span onclick="toggle_visibility('findings');" style="color: blue; cursor: pointer; cursor: hand;">Findings</span>)
								<ul id="findings" style="display:none;">
									<li>Sites that taught you the "ABC's" of Japanese,</li>
										<ul><li><i>"pffft, this is so 1 year ago..."</i></li></ul>
									<li>Sites that only gave 5-10 exercise drills, on grammar I already knew...,</li>
										<ul><li><i>"I need more than 10 sentences to master a new grammar concept and the choice of grammar here is very limited..."</i></li>
											<li><i>"The exact same 5-10 sentences every day kills me. I.need.variation...."</i></li></ul>
									<li>the advanced Japanese world with it's newspapers and books,</li>
										<ul><li><i>"too hard atm..."</i></li></ul>
									<li><a href="http://lrnj.com/" target="_blank">slimy</a> Japanese games,</li>
										<ul><li><i>"Good effort but, I already know this stuff and there's too much lag time between actual practicing..."</i></li>
											<li><i>"Nice try but, the practice is unsubstantial and not terribly interesting despite the effort..."</i></li>
										</ul>
									<li>Sites with great explanations and difficult material, but no practice whatsoever.</li>
								</ul>
							</br></br>
							So instead of complaining about it. I pulled up my big-boy pants and made a site myself. Then I thought, 'Why not share this with others?' So I polished it the best I could and released it to the world~"</span></h5>
						<h4><div class="QA">Q: </div>So what now?</h4>
							<h5><div class="QA">A: </div>I will keep expanding and improving the quality of the site within it's current scope of providing drills for intermediate Japanese learners. Then I'll go from there!"</h5>
						<h4><div class="QA">Q: </div>You charge real life money, why u rip us off mang?</h4>
							<h5><div class="QA">A: </div>Yup
							</br>If I make any real cents from this site, it simply motivated me to expand the services of the site. I'm not consumed with making money here, I just want to make the experience of studying Japanese easier than the system I felt like I was sometimes dragged through. The system of paying is designed to give immediate access to features that people don't want to wait for. It's not subscription-based and most the site is free on purpose - so I'm not making much. It's for the cause man - but money is nice too!
							</br></br><a href="https://plasso.co/benjamincann@gmail.com" target="_blank"><span style="border:1px solid red; border-radius:5px; line-height:1.2em; font-size:1.2em; padding:5px;">Support Us</span></a>
							</br></br>Thank you everyone!!</h5>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- ********************Include Footer ******************************-->
	<footer class="footer">
      <div class="container">
        <p class="text-muted">&copy;2015 JPVocab.com </p>
      </div>
    </footer>
	<!-- ********************JS ******************************-->
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type='text/javascript' src='https://plasso.co/embed/v2/embed.js'></script>
</body>
</html>