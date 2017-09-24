<?php

include('header.php');
include('inc/armory.php');

?>

<div class="row">
	<div class="content column small-12">
		<div class="content-page column small-12">
			<div class="armory-box column small-12">
				<div class="armory-box-header column small-12">
					Armory
				</div>

				<div class="armory-box-content column small-12">
				<?php if(!isset($_GET['character'])): ?>
					<form method="POST">
						<input type="text" name="name" autocomplete="OFF" placeholder="Character.." onkeyup="nameq();" />
					</form>
					<?php
					if(isset($_POST['name']))
					{
						echo '<meta http-equiv="refresh" content="0;url=armory.php?character=' . $_POST['name'] . '&page=1" />';
					}

					?>
					<div id="output">

					</div>

					<?php

					endif;
					Armory();

					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>