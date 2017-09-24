<?php

include('header.php');

?>

<div class="row">
	<div class="content column small-12">
		<div class="content-content column small-12 medium-7 large-8">
			<?php GrabNews(); ?>
		</div>

		<div class="content-content column small-12 medium-5 large-4">
			<div class="content-sidebar">
				<?php echo $sidebar['SIDEBAR1']; ?>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>