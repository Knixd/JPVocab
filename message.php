<?php include_once($_SERVER['DOCUMENT_ROOT'].'/googleanalytics.php'); ?>
<?php
	if($_GET['msg']=="activation_success"){
		header("location: index.php");
		exit();
	}
	$message = "No message";
	$msg = preg_replace('#[^a-z0-9.:_()]#i', '',  $_GET['msg']);
	if($msg == "activation_failure" || $msg == "activation_string_length_issues"){
		$message  = '<h2>Activation Error</h2> Sorry there seems to have been an issue activating your account. Please try again. <p>Email me (Ben Cann) at <my-email data-user="contact" data-domain="JPVocab.com">@</my-email> for assistance.</p><p>We\'ll fix this. Sorry for the inconvenience.</p>';
	}elseif($msg == "activation_success2"){
		session_start();
		$message = '<h2 class="page-header text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">Account <span class="text-success">Activated</span>!</h2>
		<p >Congrats <strong>'.$_SESSION['uTemp'].'</strong>, 
		</p>
		<p>You\'re in! Login to get started on the two decks I just gave you. (<a href="http://www.jpvocab.com/Japanese-Vocabulary/deck.php?t=Beginner&d=Hiragana" title="Hiragana Deck">Hiragana</a> and <a href="http://www.tehjapanesesite.com/Japanese-Vocabulary/deck.php?t=Textbook&d=Minna-no-Nihongo-Bk1" alt="Minna no Nihongo flash card set">Minna no Nihongo</a>)</p>
		<p>You can login by clicking the Login link on the top right of this page.</p>
		<p>Oh, don\'t forget...</p>
		<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="//jpvocab.us10.list-manage.com/subscribe/post?u=46bf0e7984df57314048144f2&amp;id=82ea1bd74a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	<h2>Final Step - Join over 100 JP learners and receive exclusive access to free giveaways, site updates, and other amazing info - because you\'re amazing too!</h2>
<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
<div class="mc-field-group">
	<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
</label>
	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
</div>
<div class="mc-field-group">
	<label for="mce-MMERGE3">Username <span class="asterisk">*</span></label>
	<input type="text" value="" name="MMERGE3" class="" id="mce-MMERGE3">
</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;"><input type="text" name="b_46bf0e7984df57314048144f2_82ea1bd74a" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>
<script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js"></script><script type="text/javascript">(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]="EMAIL";ftypes[0]="email";fnames[3]="MMERGE3";ftypes[3]="text";}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->';
	}elseif($msg == "reset_failure" || $msg == "reset_string_length_issues"){
		$message  = '<h2>Password Reset Error</h2> Sorry there seems to have been an issue reseting your password. Please try again.';
	}elseif($msg == "not_requested_email"){
		$message  = '<h2>Password Reset Error</h2> Sorry, you entered a different email than the originally requested email. We cannot reset your password. Please try again using the same email through the reset process.';
	}else{
		$message = $msg;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Message - JPVocab.com</title>
	<link rel="stylesheet" type="text/css" href="css/readable.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9] >
	<script src="/js/html5shiv.js">alert('Your version of Internet Explorer is not supported!');</script>
	<![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<style>
	  my-email::after {
		content: attr(data-domain);
	  }
	  my-email::before {
		content: attr(data-user);
	  }
	</style>
	
<!-- Facebook Conversion Code for Register -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6022203776784', {'value':'0.01','currency':'CAD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6022203776784&amp;cd[value]=0.01&amp;cd[currency]=CAD&amp;noscript=1" /></noscript>

</head>
<body>
	<?php include('include/header1.php'); ?>
	<div class="container text-center">
		<?= $message;?>
	</div>
	<!-- ********************Include Footer ******************************-->
	<footer class="footer">
      <div class="container">
        <p class="text-muted">&copy;2015 JPVocab.com </p>
      </div>
    </footer>
	<!-- ********************JS ******************************-->
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>