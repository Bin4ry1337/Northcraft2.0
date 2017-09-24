<?php

include('header.php');

Permission(11);

?>

<div class="row">
	<div class="content">
		<?php ListStaff(); ?>
		<?php EditStaff(); ?>
		<?php DeleteStaff(); ?>
	</div>
</div>

<?php

include('footer.php');

?>