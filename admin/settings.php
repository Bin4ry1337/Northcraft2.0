<?php

include('header.php');

Permission(6);

?>

<div class="row">
	<div class="content">
		<div class="content-content column small-12 medium-12 large-6">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Page Permissions
				</div>

				<div class="content-box-content column small-12">
					<?php PagePermissions(); ?>
				</div>
			</div>
		</div>

		<?php EditPermissions(); ?>
	</div>
</div>

<?php

include('footer.php');

?>