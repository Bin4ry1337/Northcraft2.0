<div class="row">
	<div class="footer column small-12">
		<div class="footer-line column medium-9 hide-for-small-only">
			<ul class="footer-menu">
				<li><a href="terms.php">Terms of Service</a></li>
				<li><a href="privacy.php">Privacy Policy</a></li>
				<li><a href="faq.php">FAQ</a></li>
				<li><a href="contact.php">Contact</a></li>
			</ul>
		</div>

		<div class="footer-line-small column small-12 show-for-small-only">
			<ul class="footer-menu">
				<li><a href="terms.php">Terms of Service</a></li>
				<li><a href="privacy.php">Privacy Policy</a></li>
				<li><a href="faq.php">FAQ</a></li>
				<li><a href="contact.php">Contact</a></li>
			</ul>
		</div>

		<div class="footer-line column medium-3 hide-for-small-only">
			<div class="footer-social">
				<ul class="social-menu">
					<li><a href="https://www.reddit.com/r/worldofnorthcraft/"><i class="fa fa-reddit-alien" aria-hidden="true"></i></a></li>
					<li><a href="https://www.youtube.com/channel/UCxVl7c-txQqpE-53HZ96nwQ"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</div>

		<div class="footer-line-small column small-12 show-for-small-only">
			<div class="footer-social-small">
				<ul class="social-menu-small">
					<li><a href="https://www.reddit.com/r/worldofnorthcraft/"><i class="fa fa-reddit-alien" aria-hidden="true"></i></a></li>
					<li><a href="https://www.youtube.com/channel/UCxVl7c-txQqpE-53HZ96nwQ"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</div>

		<div class="footer-line column small-12">
			<div class="copyright">
				Copyright &copy; <?php echo date('Y'); ?> <a href="https://northcraft.org">Northcraft.org</a> -  All rights reserved.
			</div>
		</div>
	</div>
</div>

<!-- Javascript Stylesheets -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-100691014-1', 'auto');
  ga('send', 'pageview');

</script>
<script type="text/javascript" src="js/vendor/jquery.js"></script>
<script type="text/javascript" src="js/vendor/what-input.js"></script>
<script type="text/javascript" src="js/vendor/foundation.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/timeline.js"></script>
<script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="js/power.js"></script>
<?php if(basename($_SERVER['PHP_SELF']) == 'changelog.php'): ?>
<script type="text/javascript" async>
	var aowow_tooltips = {
	        /* Enable or disable the rename of URLs into item, spell and other names automatically */
	        rename: true,
	        /* Enable or disable icons appearing on the left of the tooltip links. */
	        icons: false,
	        /* Overrides the default icon size of 15x15, 13x13 as an example, icons must be true */
	        iconsize: 53,
	        /* Enable or disable link rename quality colors, an epic item will be purple for example. */
	        qualitycolor: true,
	        /* TBA */
	        forcexpac: { },
	        /* Override link colors, qualitycolor must be true. Example: spells: '#000' will color all renamed spell links black. */
	        overridecolor: {
	            spells: '',
	            items: '',
	            npcs: '',
	            objects: '',
	            quests: '',
	            achievements: ''
	        }
	};
</script>
<?php endif; ?>

<script type="text/javascript" async>
	var aowow_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true }
</script>

<?php if(basename($_SERVER['PHP_SELF']) == 'index.php' || ''): ?>
<script type="text/javascript" async>
	var end = new Date('08/04/2017 06:00 PM GMT+1');
    var _second = 1000;
    var _minute = _second * 60;
    var _hour = _minute * 60;
    var _day = _hour * 24;
    var timer;

    function showRemaining() {
        var now = new Date();
        var distance = end - now;
        if (distance < 0) {

            clearInterval(timer);
            document.getElementById('timer-text').innerHTML = 'WELCOME TO NORTHCRAFT';
            document.getElementById('timer-countdown').innerHTML = 'set realmlist logon.northcraft.org';

            return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor((distance % _day) / _hour);
        var minutes = Math.floor((distance % _hour) / _minute);
        var seconds = Math.floor((distance % _minute) / _second);

        document.getElementById('timer-countdown').innerHTML = days + ' <span class="orange">Days</span> ';
        document.getElementById('timer-countdown').innerHTML += hours + ' <span class="orange">Hours</span> ';
        document.getElementById('timer-countdown').innerHTML += minutes + ' <span class="orange">Minutes</span> ';
        document.getElementById('timer-countdown').innerHTML += seconds + ' <span class="orange">Seconds</span>';
    }

    timer = setInterval(showRemaining, 1000);

    var end3 = new Date('08/04/2017 06:00 PM GMT+1');
    var _second3 = 1000;
    var _minute3 = _second3 * 60;
    var _hour3 = _minute3 * 60;
    var _day3 = _hour3 * 24;
    var timer3;

    function showRemaining3() {
        var now3 = new Date();
        var distance3 = end3 - now3;
        if (distance3 < 0) {

            clearInterval(timer3);
            document.getElementById('timer-text3').innerHTML = 'WELCOME TO NORTHCRAFT';
            document.getElementById('timer-countdown3').innerHTML = 'set realmlist logon.northcraft.org';

            return;
        }
        var days3 = Math.floor(distance3 / _day3);
        var hours3 = Math.floor((distance3 % _day3) / _hour3);
        var minutes3 = Math.floor((distance3 % _hour3) / _minute3);
        var seconds3 = Math.floor((distance3 % _minute3) / _second3);

        document.getElementById('timer-countdown3').innerHTML = days3 + ' <span class="orange">Days</span> ';
        document.getElementById('timer-countdown3').innerHTML += hours3 + ' <span class="orange">Hours</span> ';
        document.getElementById('timer-countdown3').innerHTML += minutes3 + ' <span class="orange">Minutes</span> ';
        document.getElementById('timer-countdown3').innerHTML += seconds3 + ' <span class="orange">Seconds</span>';
    }

    timer3 = setInterval(showRemaining3, 1000);
</script>
<?php endif; ?>

<script>
	function nameq()
	{
		var searchTxt = $("input[name='name']").val();

		$.post("ajax/search_character.php", {searchVal: searchTxt}, function(output) {
			$("#output").html(output);
		});
	}
</script>
</body>
</html>