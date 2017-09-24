<?php

include('header.php');

?>

<div class="row">
	<div class="content column small-12">
		<br>
		<br>
		<br>
		<br>
		<center>
			<div class="title-hof">
				Hall of Fame
			</div>

			<div class="ach-image column medium-12 show-for-medium">
				<img src="img/achievement/achievement_base.png">

				<div class="ach-icon">
					<img src="img/achievement/achievement_obsidian.jpg" width="49">
				</div>

				<div class="ach-title">
					Sun Project Realm First! Obsidian Slayer
				</div>

				<div class="ach-description" style="line-height: 15px;">
					Participated in the realm first defeat of Sartharion<br> the Onyx Guardian in 25-player mode.
				</div>

				<div class="ach-reward">
					Title Reward: Obsidian Slayer < Name >
				</div>
			</div>

			<?php HallsOfFame(); ?>
		</center>
	</div>
</div>

<?php

include('footer.php');

?>