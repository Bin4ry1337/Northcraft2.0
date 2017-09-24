<?php

include('header.php');

Permission(2);

?>

<div class="row">
	<div class="content">
		<?php ListNews(); ?>

		<?php EditNews(); ?>
		<?php DeleteNews(); ?>
	</div>
</div>

<?php

include('footer.php');

?>