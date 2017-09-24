<?php

include('header.php');

Permission(11);

?>

<div class="row">
	<div class="content">
		<div class="content-content column small-12 medium-12 large-12">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Add a new Staff Member
				</div>

				<div class="content-box-content column small-12">
					<div class="news">
						<form method="POST">
							<div class="news-header column small-12">
								<label>Username</label>
								<input type="text" name="username" />
							</div>

							<div class="news-header column small-12">
								<label>Avatar</label>
								<input type="text" name="avatar" />
							</div>

							<div class="news-header column small-12">
								<label>Rank</label>
								<select name="rank">
									<option value="1">Project Lead</option>
									<option value="2">Web Developer</option>
									<option value="3">Core Developer</option>
									<option value="4">Consigliere</option>
									<option value="5">Junior Developer</option>
									<option value="6">Community Manager</option>
									<option value="7">Head Moderator</option>
									<option value="8">Moderator</option>
									<option value="9">Graphic Artist</option>
									<option value="10">Head Game Master</option>
									<option value="11">Game Master</option>
								</select>
							</div>

							<div class="news-bottom column small-12">
								<input type="submit" class="button small" name="add-staff" value="Post" />
								<span class="response"><?php AddStaff(); ?></span>
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