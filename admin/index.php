<?php

include('header.php');

Permission(1);

?>

<div class="row">
	<div class="content">
		<div class="content-content column small-12 medium-12 large-4">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					User Information
				</div>

				<div class="content-box-content column small-12">
					<div class="content-box-strip even column small-12">
						<div class="content-box-strip-left column small-6">
							Username
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo WebsiteInformation('USER'); ?>
						</div>
					</div>

					<div class="content-box-strip odd column small-12">
						<div class="content-box-strip-left column small-6">
							Email
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo WebsiteInformation('EMAIL'); ?>
						</div>
					</div>

					<div class="content-box-strip even column small-12">
						<div class="content-box-strip-left column small-6">
							Access Level
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo WebsiteInformation('LEVEL'); ?>
						</div>
					</div>

					<div class="content-box-strip odd column small-12">
						<div class="content-box-strip-left column small-6">
							IP Address
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo WebsiteInformation('IP'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="content-content column small-12 medium-12 large-4">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					System Information
				</div>

				<div class="content-box-content column small-12">
					<div class="content-box-strip even column small-12">
						<div class="content-box-strip-left column small-6">
							PHP Version
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo SystemInformation('PHP'); ?>
						</div>
					</div>

					<div class="content-box-strip odd column small-12">
						<div class="content-box-strip-left column small-6">
							Server Version
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo SystemInformation('SERVER'); ?>
						</div>
					</div>

					<div class="content-box-strip even column small-12">
						<div class="content-box-strip-left column small-6">
							CMS Version
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo SystemInformation('CMS'); ?>
						</div>
					</div>

					<div class="content-box-strip odd column small-12">
						<div class="content-box-strip-left column small-6">
							Errors
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo SystemInformation('ERRORS'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="content-content column small-12 medium-12 large-4">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Server Statistics
				</div>

				<div class="content-box-content column small-12">
					<div class="content-box-strip even column small-12">
						<div class="content-box-strip-left column small-6">
							Server Uptime
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo WebStatistics('UPTIME'); ?>
						</div>
					</div>

					<div class="content-box-strip odd column small-12">
						<div class="content-box-strip-left column small-6">
							Characters
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo WebStatistics('CHARS'); ?>
						</div>
					</div>

					<div class="content-box-strip even column small-12">
						<div class="content-box-strip-left column small-6">
							Total Tickets
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo WebStatistics('TICKETS'); ?>
						</div>
					</div>

					<div class="content-box-strip odd column small-12">
						<div class="content-box-strip-left column small-6">
							Players Online
						</div>

						<div class="content-box-strip-right column small-6">
							<?php echo WebStatistics('ONLINE'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>