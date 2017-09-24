<?php

include('header.php');

Permission(9);

?>

<div class="row">
	<div class="content">
		<div class="content-content column small-12 medium-12 large-12">
			<form method="GET">
				<input type="text" name="search" placeholder="Search for anything" />
			</form>
		</div>

		<?php Commands(); ?>
	</div>
</div>

<?php

include('footer.php');

?>