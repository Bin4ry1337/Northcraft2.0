<?php

include('header.php');

Permission(10);

?>

<div class="row">
	<div class="content">
		<div class="content-content column small-12 medium-12 large-12">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Add a new streamer
				</div>

				<div class="content-box-content column small-12">
					<div class="news">
						<form method="POST">
							<div class="news-header column small-12">
								<label>Username</label>
								<input type="text" name="username" />
							</div>

							<div class="news-content column small-12">
								<label>Status</label>
								<select name="status">
									<option value="0">Disabled</span>
									<option value="1">Enabled</span>
								</select>
							</div>

							<div class="news-bottom column small-12">
								<input type="submit" class="button small" name="add-streamer" value="Add" />
								<span class="response"><?php AddStreamer(); ?></span>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>