<?php

include('header.php');

Permission(3);

?>

<div class="row">
	<div class="content">
		<div class="content-strip column small-12">
			<div class="content-strip-content column small-12">
				<a href="newfaq.php" class="small button">New Question</a>
			</div>
		</div>

		<div class="content-content column small-12 medium-12 large-12">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					FAQ
				</div>

				<div class="content-box-content column small-12">
					<?php ListFAQ(); ?>
				</div>
			</div>
		</div>

		<?php EditFAQ(); ?>
		<?php DeleteFAQ(); ?>
	</div>
</div>

<?php

include('footer.php');

?>