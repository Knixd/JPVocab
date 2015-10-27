<?php
	include_once("include/check_login.php");
	if($user_ok == true){
		header("location: lobby.php");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">-->
	<link rel="canonical" href="http://www.tehjapanesesite.com/restricted.php" />	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>	
	<!--[if lt IE 9] >
	<script src="/js/html5shiv.js">alert('Your version of Internet Explorer is not supported!');</script>
	<![endif]-->
	<title>Restricted Content. Please login to access</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="js/main.js" type="text/javascript"></script>
	<script src="js/ajax.js" type="text/javascript"></script>
	<script>
		function emptyElement(x){
			_(x).style.visibility = "hidden";
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
	function unexpectedLogout(refPage,u){
		var ajax = ajaxObj("POST", "scripts/issues.php");
		var issue = "unexpectedlogout";
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText != "error_logged_success"){
					_("ifIssue").style.visibility = "hidden";
					_("result").innerHTML = "Thank you!";
				} else {
					_("ifIssue").style.visibility = "hidden";
					_("result").innerHTML = "<i>A report has been sent to the developers. Thanks for letting us know. We're really sorry for the inconvenience and will work on this right away!</i>";
				}
			}
		}
		ajax.send("issue="+issue+"&refPage="+refPage+"&u="+u);
		_("result").innerHTML = 'Please wait ...';
	}
	</script>
</head>
<body>
<?php include_once("scripts/scriptaddthis.php");
	include('include/header1.php'); ?>
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
									<h1>Restricted Content</h1>
									<p class="lead">Oops, you must be logged in.</p>
									<p>This content is exclusive for JPVocab.com members. Please login  or register for access.</p>									<p><a href="http://www.tehJapaneseSite.com/" title="tehJapaneseSite.com homepage"><button type="button" class="btn btn-link">Register</button></a></p>
									<p id="ifIssue"> If you were logged out unexpectedly <button type="button" class="btn btn-info btn-sm" onClick="unexpectedLogout('<?php echo $refPage; ?>','<?php echo $u;?>')">Notify Us</button>
									<div id="result"></div></p> 
									
								</div><!-- message-->
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
	</section>
	<!-- ********************Include Footer ******************************--><?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/include/footer-new.php'); ?>
	<!-- ********************JS ******************************-->
</body>
</html>