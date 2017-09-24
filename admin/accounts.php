<?php

include('header.php');

Permission(13);

?>

<div class="row">
	<div class="content">
		<div class="content-content column small-12">
			<form method="GET">
				<input type="text" name="search" placeholder="Search for account" />
			</form>
		</div>

		<?php AccountList(); ?>

		<?php ForgotPassword(); ?>
		<?php ModifyAccount(); ?>
	</div>
</div>

<?php

include('footer.php');

?>