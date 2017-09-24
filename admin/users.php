<?php

include('header.php');

Permission(5);

?>

<div class="row">
	<div class="content">
		<div class="content-strip column small-12">
			<div class="content-strip-content column small-12">
				<a href="newuser.php" class="small button">Create User</a>
			</div>
		</div>

		<div class="content-content column small-12 medium-12 large-12">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Users
				</div>

				<div class="content-box-content column small-12">
					<?php UserList(); ?>
				</div>
			</div>
		</div>

		<?php EditUser(); ?>
		<?php DeleteUser(); ?>
	</div>
</div>

<?php

include('footer.php');

?>