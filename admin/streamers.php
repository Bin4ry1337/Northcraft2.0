<?php

include('header.php');

Permission(10);

?>

<div class="row">
	<div class="content">
		<?php ListStreamers(); ?>

		<?php EditStreamer(); ?>
		<?php DeleteStreamer(); ?>
	</div>
</div>

<?php

include('footer.php');

?>