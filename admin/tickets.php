<?php

include('header.php');

Permission(7);

?>

<div class="row">
	<div class="content">
		<?php if(!isset($_GET['view'])): ?>
			<div class="content-content column small-12 medium-12 large-12">
				<form method="GET">
					<input type="text" name="search" placeholder="Search for character" />
				</form>
			</div>
		<?php endif; ?>

		<?php if(isset($_GET['view'])): ?>
			<div class="content-content column small-12 medium-12 large-12">
				<a href="tickets.php" class="back-button button small">Go Back</a>
			</div>
		<?php endif; ?>

		<?php Tickets(); ?>
	</div>
</div>

<?php

include('footer.php');

?>