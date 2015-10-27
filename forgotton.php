<?php
	if(!isset($_GET['eh'])){
		header("location: login.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="js/main.js" type="text/javascript"></script>
	<script src="js/ajax.js" type="text/javascript"></script>
	<script>
		function _(el){
			return document.getElementById(el);
		}
		function emptyElementReg(x){
			_(x).innerHTML = "";
		}
		function checkemail(e){
			var atpos = e.indexOf("@");
			var dotpos = e.lastIndexOf(".");
			if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=e.length) {
				return false;
			}
		}
		function restrict(elem){
			var tf = _(elem);
			var rx = new RegExp;
			rx = /[' "]/gi;
		}
		function reset(ehashed){
			var p1 = _("pass1").value;
			var p2 = _("pass2").value;
			var e = _("emailReg").value;
			var status = _("statusReg");
			if(p1 == "" || p2 == ""){
				status.innerHTML = "Oops! Some data is still missing still.";
			}else if(p1 != p2){
				status.innerHTML = "Oops! Your password fields don't match yet";
			}if(checkemail(e)==false){
				status.innerHTML = "Oh no! Enter a valid email please.";
			} else {
				_("resetbtn").style.display = "none";
				status.innerHTML = 'please wait ...';
				var ajax = ajaxObj("POST", "forgottonform.php");
				ajax.onreadystatechange = function() {
					if(ajaxReturn(ajax) == true) {
						if(ajax.responseText != "reset_success"){
							status.innerHTML = ajax.responseText;
							_("resetbtn").style.display = "block";
							status.innerHTML = "There was an error reseting your password. Please try again.";
						} else {
							status.innerHTML = "";
							_("resetform").innerHTML = "Success. You have reset your password. <a href='http://www.tehjapanesesite.com'>Click here to return to the login page</a>.";
						}
					}
				}
				ajax.send("e="+e+"&p="+p1+"&eh="+ehashed);
			}
		}
	</script>
</head>
<body>
<div id="resetform">
	<div class="regRow">
		<div class="regRowCol">
			<div id="regE" class="labelReg">Re-enter Email:</div>
			<input id="emailReg" type="text" onfocus="emptyElementReg('statusReg')" onkeyup="restrict('emailReg')" maxlength="88">
		</div>
		<div class="regRowCol">
			<div id="regP1" class="labelReg">Create New Password:</div>
			<input id="pass1" type="password" onfocus="emptyElementReg('statusReg')" maxlength="16">
		</div>
		<div class="regRowCol">
			<div id="regP2" class="labelReg">Confirm New Password:</div>
			<input id="pass2" type="password" onfocus="emptyElementReg('statusReg')" maxlength="16">
		</div>
	</div>
	<button id="resetbtn" onClick="reset('<?php echo $_GET['eh'];?>')">Reset Password</button>
</div>
<div id="statusReg"></div>