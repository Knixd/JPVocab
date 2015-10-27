<?php include_once("googleanalytics.php"); ?>
	<script src="../js/main.js" type="text/javascript"></script>
	<script src="../js/ajax.js" type="text/javascript"></script>
	<script>
		function emptyElement(x){
			_(x).style.visibility = "hidden";
		}
		function login(){
			_("loginStatus").style.visibility = "visible";
			_("loginStatus").innerHTML = "Please wait...";
			var e = _("loginEmail").value;
			var p = _("loginPassword").value;
			if(e == "" || p == ""){
				_("loginStatus").style.visibility = "visible";
				_("loginStatus").innerHTML = "<small>Oops, we need more info!</small>";
			} else {
				var ajax = ajaxObj("POST", "index.php");
				var vars ="e="+e+"&p="+p;
				ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
						if(ajax.responseText == "login_failed"){
							_("loginStatus").style.visibility = "visible";
							_("loginStatus").innerHTML = "<small>Oops, that password/email combo didn't work.</small>";
						} else {
							_("loginStatus").style.visibility = "visible";
							_("loginStatus").innerHTML = "<span class='text-success'>beep bop boop...</span>";
							window.location = "../lobby.php";
						}
					}
				}
				ajax.send(vars);
			}
		}
		function _(el){
			return document.getElementById(el);
		}
		function emptyElementReg(x){
			_(x).innerHTML = "";
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
	$('.dropdown-menu').find('form').click(function (e) {
		e.stopPropagation();
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
<header>
<div class="navbar navbar-default" role="navigation"  itemscope itemtype="http://schema.org/SiteNavigationElement">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://www.JPVocab.com"><b><span class="text-danger">JP</span><span class="text-primary">Vocab</span></b><span class="text-muted">.com</span></a>
        </div>
        <center>
            <div class="navbar-collapse collapse " id="navbar-main">
                <ul class="nav navbar-nav pull-right">
                    <li><a href="http://www.JPVocab.com/sample-flashcard.php">Flashcard Tour</a></li>
                    <!--<li><a href="http://www.JPVocab.com/grammar.php"><b><span class="text-danger">JP</span><span class="text-primary">Drills</span></b><span class="text-muted">.com</span></a></li>-->
                    <li><a href="http://www.JPVocab.com/unlock.php">Japanese Flashcard Sets</a></li>
					<li><a href="http://www.JPVocab.com/users.php">Users</a></li>
					<!--<li><a href="http://www.JPVocab.com/about.php">About</a>-->
                    </li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" style="border: 1px solid red;"data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-log-in " aria-hidden="true"></span> Members<span class="caret"></span></a>
						  <ul class="dropdown-menu dropdown-menu-right">
								<form id="loginForm" onsubmit="return false;" class="navbar-form" role="search">
									<li>
										<div class="form-group">
											<input type="text" id="loginEmail" class="form-control input" name="username" placeholder="Username or Email" onfocus="emptyElement('loginStatus')" maxlength="88">
										</div>
									</li>
									<li>
										<div class="form-group">
											<input type="password" id="loginPassword" class="form-control input" name="password" placeholder="Password" onfocus="emptyElement('loginStatus')" maxlength="100">
										</div>
									</li>
									<li><button type="submit"  id="loginBtn" class="btn btn-success btn-block" onclick="login()">Log In</button></li>
									<li role="separator" class="divider"></li>
									<li itemprop="url">
										<small><a href="http://www.JPVocab.com" class="">Register</a> &bullet; <a href="http://www.JPVocab.com/reset.php" class="text-right">Forgot Password</a></small>
									</li>
									<div class="text-danger" id="loginStatus"></div>
								</form>
						</ul>
					</li>
                </ul>
                
            </div>
        </center>
    </div>
</div>
</header>
