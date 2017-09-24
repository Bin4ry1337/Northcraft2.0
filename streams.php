<?php

include('header.php');
include('inc/twitch.api.php');

?>

<div class="row">
	<div class="content column small-12">
		<?php GrabStreams(); ?>
	</div>
</div>

<?php

include('footer.php');

?>