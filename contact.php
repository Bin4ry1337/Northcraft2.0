<?php

include('header.php');

?>

<div class="row">
	<div class="content column small-12">
		<div class="box column small-12 medium-12">

			<?php ContactUs(); ?>
			
			<div class="box-content">
				<div class="box-content-line">
					<div class="box-content-title">
						Contact Us
					</div>
				</div>

				<div class="box-content-line">
					<div class="contact">
						<form method="POST">
							<label>Name</label>
							<input type="text" name="yourname" />

							<label>Email</label>
							<input type="text" name="youremail" />

							<label>Subject</label>
							<input type="text" name="subject" />

							<label>Message</label>
							<textarea name="message"></textarea>

							<div class="captcha">
								<div class="g-recaptcha" data-sitekey="6LfUyQ4UAAAAACDCMqn_pFVy44_EpF59fcKwfG7W"></div>
							</div>

							<input type="submit" class="button small" name="send" value="Send" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>