<div class="container">
  <div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	  <div id="main">
		<div class="content">
		  <!-- /.Text Div -->
		  <div class="counter">
			<div class="col-xs-12 col-sm-4">
				<a href="http://www.JPVocab.com/to/Nisemonogatari/" title="Nisemonogatari">
					<img src="../img/nisemono.jpg" alt="Nisemonogatari Amazon DVD Image" class="thumbnail img-responsive" />
				</a>
			</div>
			<div class="col-xs-12 col-sm-8">
				<p class="lead">You recently voted for <a href="http://www.JPVocab.com/to/Nisemonogatari/" title="Nisemonogatari">Nisemonogatari</a> to be the next Japanese Anime Vocabulary set. It'll be ready on Sunday, Oct 25th. </p>
				<div id="countdown" class="col-xs-12 text-center"></div>
				<p class="lead" style="padding-top:150px;">In the meantime, see if any of our <a href="http://www.jpvocab.com/unlock.php" title="Japanese Flashcard sets">Japanese Flashcard sets</a> interest you.</p>
			</div>
			<!-- /#Countdown Div -->
		  </div>
		  <!-- /.Counter Div -->
		</div>
		<!-- /.Content Div -->
	 </div>
	  <!-- /#Main Div -->
	</div>
	<!-- /.Columns Div -->
  </div>
  <!-- /.Row Div -->
</div>
<!-- /.Container Div -->
<script>
// set the date we're counting down to
	var target_date = new Date('Oct, 25, 2015').getTime();

	// variables for time units
	var days, hours, minutes, seconds;

	// get tag element
	//var countdown = _("countdown");

	// update the tag with id "countdown" every 1 second
	setInterval(function() {

	  // find the amount of "seconds" between now and target
	  var current_date = new Date().getTime();
	  var seconds_left = (target_date - current_date) / 1000;

	  // do some time calculations
	  days = parseInt(seconds_left / 86400);
	  seconds_left = seconds_left % 86400;

	  hours = parseInt(seconds_left / 3600);
	  seconds_left = seconds_left % 3600;

	  minutes = parseInt(seconds_left / 60);
	  seconds = parseInt(seconds_left % 60);

	  // format countdown string + set tag value
	  _("countdown").innerHTML = '<span class="days">' + days + ' <b>Days</b></span> <span class="hours">' + hours + ' <b>Hours</b></span> <span class="minutes">' + minutes + ' <b>Minutes</b></span> <span class="seconds">' + seconds + ' <b>Seconds</b></span>';

	}, 1000);
	</script>